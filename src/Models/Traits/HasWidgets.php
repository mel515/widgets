<?php

namespace InetStudio\Widgets\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use InetStudio\Widgets\Contracts\Models\WidgetModelContract;

trait HasWidgets
{
    /**
     * The Queued Widgets.
     *
     * @var array
     */
    protected $queuedWidgets = [];

    /**
     * Get Widget class name.
     *
     * @return string
     */
    public static function getWidgetClassName(): string
    {
        $model = app()->make('InetStudio\Widgets\Contracts\Models\WidgetModelContract');

        return get_class($model);
    }

    /**
     * Get all attached widgets to the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function widgets(): MorphToMany
    {
        return $this->morphToMany(static::getWidgetClassName(), 'widgetable')->withTimestamps();
    }

    /**
     * Attach the given widget(s) to the model.
     *
     * @param int|string|array|\ArrayAccess|WidgetModelContract $widgets
     */
    public function setWidgetsAttribute($widgets)
    {
        if (! $this->exists) {
            $this->queuedWidgets = $widgets;

            return;
        }

        $this->attachWidgets($widgets);
    }

    /**
     * Boot the widgetable trait for a model.
     */
    public static function bootHasWidgets()
    {
        static::created(function (Model $widgetableModel) {
            if ($widgetableModel->queuedWidgets) {
                $widgetableModel->attachWidgets($widgetableModel->queuedWidgets);
                $widgetableModel->queuedWidgets = [];
            }
        });

        static::deleted(function (Model $widgetableModel) {
            $widgetableModel->syncWidgets(null);
        });
    }

    /**
     * Get the widget list.
     *
     * @param string $keyColumn
     *
     * @return array
     */
    public function widgetList(string $keyColumn = 'id'): array
    {
        return $this->widgets()->pluck('view', $keyColumn)->toArray();
    }

    /**
     * Scope query with all the given widgets.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int|string|array|\ArrayAccess|WidgetModelContract $widgets
     * @param string $column
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithAllWidgets(Builder $query, $widgets, string $column = 'id'): Builder
    {
        $widgets = static::isWidgetsStringBased($widgets)
            ? $widgets : static::hydrateWidgets($widgets)->pluck($column);

        collect($widgets)->each(function ($widget) use ($query, $column) {
            $query->whereHas('widgets', function (Builder $query) use ($widget, $column) {
                return $query->where($column, $widget);
            });
        });

        return $query;
    }

    /**
     * Scope query with any of the given widgets.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int|string|array|\ArrayAccess|WidgetModelContract $widgets
     * @param string $column
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithAnyWidgets(Builder $query, $widgets, string $column = 'id'): Builder
    {
        $widgets = static::isWidgetsStringBased($widgets)
            ? $widgets : static::hydrateWidgets($widgets)->pluck($column);

        return $query->whereHas('widgets', function (Builder $query) use ($widgets, $column) {
            $query->whereIn($column, (array) $widgets);
        });
    }

    /**
     * Scope query with any of the given widgets.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int|string|array|\ArrayAccess|WidgetModelContract $widgets
     * @param string $column
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithWidgets(Builder $query, $widgets, string $column = 'id'): Builder
    {
        return static::scopeWithAnyWidgets($query, $widgets, $column);
    }

    /**
     * Scope query without the given widgets.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int|string|array|\ArrayAccess|WidgetModelContract $widgets
     * @param string $column
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithoutWidgets(Builder $query, $widgets, string $column = 'id'): Builder
    {
        $widgets = static::isWidgetsStringBased($widgets)
            ? $widgets : static::hydrateWidgets($widgets)->pluck($column);

        return $query->whereDoesntHave('widgets', function (Builder $query) use ($widgets, $column) {
            $query->whereIn($column, (array) $widgets);
        });
    }

    /**
     * Scope query without any widgets.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithoutAnyWidgets(Builder $query): Builder
    {
        return $query->doesntHave('widgets');
    }

    /**
     * Attach the given Widget(ies) to the model.
     *
     * @param int|string|array|\ArrayAccess|WidgetModelContract $widgets
     *
     * @return $this
     */
    public function attachWidgets($widgets)
    {
        static::setWidgets($widgets, 'syncWithoutDetaching');

        return $this;
    }

    /**
     * Sync the given widget(s) to the model.
     *
     * @param int|string|array|\ArrayAccess|WidgetModelContract|null $widgets
     *
     * @return $this
     */
    public function syncWidgets($widgets)
    {
        static::setWidgets($widgets, 'sync');

        return $this;
    }

    /**
     * Detach the given Widget(s) from the model.
     *
     * @param int|string|array|\ArrayAccess|WidgetModelContract $widgets
     *
     * @return $this
     */
    public function detachWidgets($widgets)
    {
        static::setWidgets($widgets, 'detach');

        return $this;
    }

    /**
     * Determine if the model has any the given widgets.
     *
     * @param int|string|array|\ArrayAccess|WidgetModelContract $widgets
     *
     * @return bool
     */
    public function hasWidget($widgets): bool
    {
        // Single Widget id
        if (is_string($widgets)) {
            return $this->widgets->contains('id', $widgets);
        }

        // Single Widget id
        if (is_int($widgets)) {
            return $this->widgets->contains('id', $widgets);
        }

        // Single Widget model
        if ($widgets instanceof WidgetModelContract) {
            return $this->widgets->contains('id', $widgets->id);
        }

        // Array of Widget ids
        if (is_array($widgets) && isset($widgets[0]) && is_string($widgets[0])) {
            return ! $this->widgets->pluck('id')->intersect($widgets)->isEmpty();
        }

        // Array of Widget ids
        if (is_array($widgets) && isset($widgets[0]) && is_int($widgets[0])) {
            return ! $this->widgets->pluck('id')->intersect($widgets)->isEmpty();
        }

        // Collection of Widget models
        if ($widgets instanceof Collection) {
            return ! $widgets->intersect($this->widgets->pluck('id'))->isEmpty();
        }

        return false;
    }

    /**
     * Determine if the model has any the given widgets.
     *
     * @param int|string|array|\ArrayAccess|WidgetModelContract $widgets
     *
     * @return bool
     */
    public function hasAnyWidget($widgets): bool
    {
        return static::hasWidget($widgets);
    }

    /**
     * Determine if the model has all of the given widgets.
     *
     * @param int|string|array|\ArrayAccess|WidgetModelContract $widgets
     *
     * @return bool
     */
    public function hasAllWidgets($widgets): bool
    {
        // Single widget id
        if (is_string($widgets)) {
            return $this->widgets->contains('id', $widgets);
        }

        // Single widget id
        if (is_int($widgets)) {
            return $this->widgets->contains('id', $widgets);
        }

        // Single widget model
        if ($widgets instanceof WidgetModelContract) {
            return $this->widgets->contains('id', $widgets->id);
        }

        // Array of widget ids
        if (is_array($widgets) && isset($widgets[0]) && is_string($widgets[0])) {
            return $this->widgets->pluck('id')->count() === count($widgets)
                && $this->widgets->pluck('id')->diff($widgets)->isEmpty();
        }

        // Array of widget ids
        if (is_array($widgets) && isset($widgets[0]) && is_int($widgets[0])) {
            return $this->widgets->pluck('id')->count() === count($widgets)
                && $this->widgets->pluck('id')->diff($widgets)->isEmpty();
        }

        // Collection of widget models
        if ($widgets instanceof Collection) {
            return $this->widgets->count() === $widgets->count() && $this->widgets->diff($widgets)->isEmpty();
        }

        return false;
    }

    /**
     * Set the given widget(s) to the model.
     *
     * @param int|string|array|\ArrayAccess|WidgetModelContract $widgets
     * @param string $action
     */
    protected function setWidgets($widgets, string $action)
    {
        // Fix exceptional event name
        $event = $action === 'syncWithoutDetaching' ? 'attach' : $action;

        // Hydrate Widgets
        $widgets = static::hydrateWidgets($widgets)->pluck('id')->toArray();

        // Fire the Widget syncing event
        static::$dispatcher->dispatch("inetstudio.widgets.{$event}ing", [$this, $widgets]);

        // Set Widgets
        $this->widgets()->$action($widgets);

        // Fire the Widget synced event
        static::$dispatcher->dispatch("inetstudio.widgets.{$event}ed", [$this, $widgets]);
    }

    /**
     * Hydrate widgets.
     *
     * @param int|string|array|\ArrayAccess|WidgetModelContract $widgets
     *
     * @return \Illuminate\Support\Collection
     */
    protected function hydrateWidgets($widgets)
    {
        $isWidgetsStringBased = static::isWidgetsStringBased($widgets);
        $isWidgetsIntBased = static::isWidgetsIntBased($widgets);
        $field = $isWidgetsStringBased ? 'id' : 'id';
        $className = static::getWidgetClassName();

        return $isWidgetsStringBased || $isWidgetsIntBased
            ? $className::query()->whereIn($field, (array) $widgets)->get() : collect($widgets);
    }

    /**
     * Determine if the given widget(s) are string based.
     *
     * @param int|string|array|\ArrayAccess|WidgetModelContract $widgets
     *
     * @return bool
     */
    protected function isWidgetsStringBased($widgets)
    {
        return is_string($widgets) || (is_array($widgets) && isset($widgets[0]) && is_string($widgets[0]));
    }

    /**
     * Determine if the given widget(s) are integer based.
     *
     * @param int|string|array|\ArrayAccess|WidgetModelContract $widgets
     *
     * @return bool
     */
    protected function isWidgetsIntBased($widgets)
    {
        return is_int($widgets) || (is_array($widgets) && isset($widgets[0]) && is_int($widgets[0]));
    }
}
