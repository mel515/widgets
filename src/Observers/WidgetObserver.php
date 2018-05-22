<?php

namespace InetStudio\Widgets\Observers;

use InetStudio\Widgets\Contracts\Models\WidgetModelContract;
use InetStudio\Widgets\Contracts\Observers\WidgetObserverContract;

/**
 * Class WidgetObserver.
 */
class WidgetObserver implements WidgetObserverContract
{
    /**
     * Используемые сервисы.
     *
     * @var array
     */
    protected $services;

    /**
     * WidgetObserver constructor.
     */
    public function __construct()
    {
        $this->services['widgetsObserver'] = app()->make('InetStudio\Widgets\Contracts\Services\Back\WidgetsObserverServiceContract');
    }

    /**
     * Событие "объект создается".
     *
     * @param WidgetModelContract $item
     */
    public function creating(WidgetModelContract $item): void
    {
        $this->services['widgetsObserver']->creating($item);
    }

    /**
     * Событие "объект создан".
     *
     * @param WidgetModelContract $item
     */
    public function created(WidgetModelContract $item): void
    {
        $this->services['widgetsObserver']->created($item);
    }

    /**
     * Событие "объект обновляется".
     *
     * @param WidgetModelContract $item
     */
    public function updating(WidgetModelContract $item): void
    {
        $this->services['widgetsObserver']->updating($item);
    }

    /**
     * Событие "объект обновлен".
     *
     * @param WidgetModelContract $item
     */
    public function updated(WidgetModelContract $item): void
    {
        $this->services['widgetsObserver']->updated($item);
    }

    /**
     * Событие "объект подписки удаляется".
     *
     * @param WidgetModelContract $item
     */
    public function deleting(WidgetModelContract $item): void
    {
        $this->services['widgetsObserver']->deleting($item);
    }

    /**
     * Событие "объект удален".
     *
     * @param WidgetModelContract $item
     */
    public function deleted(WidgetModelContract $item): void
    {
        $this->services['widgetsObserver']->deleted($item);
    }
}
