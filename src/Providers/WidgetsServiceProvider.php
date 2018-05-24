<?php

namespace InetStudio\Widgets\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class WidgetsServiceProvider.
 */
class WidgetsServiceProvider extends ServiceProvider
{
    /**
     * Загрузка сервиса.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerConsoleCommands();
        $this->registerPublishes();
        $this->registerRoutes();
        $this->registerViews();
        $this->registerObservers();
    }

    /**
     * Регистрация привязки в контейнере.
     *
     * @return void
     */
    public function register(): void
    {
        $this->registerBindings();
    }

    /**
     * Регистрация команд.
     *
     * @return void
     */
    protected function registerConsoleCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                'InetStudio\Widgets\Console\Commands\SetupCommand',
            ]);
        }
    }

    /**
     * Регистрация ресурсов.
     *
     * @return void
     */
    protected function registerPublishes(): void
    {
        if ($this->app->runningInConsole()) {
            if (! class_exists('CreateWidgetsTables')) {
                $timestamp = date('Y_m_d_His', time());
                $this->publishes([
                    __DIR__.'/../../database/migrations/create_widgets_tables.php.stub' => database_path('migrations/'.$timestamp.'_create_widgets_tables.php'),
                ], 'migrations');
            }
        }
    }

    /**
     * Регистрация путей.
     *
     * @return void
     */
    protected function registerRoutes(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
    }

    /**
     * Регистрация представлений.
     *
     * @return void
     */
    protected function registerViews(): void
    {
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'admin.module.widgets');
    }

    /**
     * Регистрация наблюдателей.
     *
     * @return void
     */
    public function registerObservers(): void
    {
        $this->app->make('InetStudio\Widgets\Contracts\Models\WidgetModelContract')::observe($this->app->make('InetStudio\Widgets\Contracts\Observers\WidgetObserverContract'));
    }

    /**
     * Регистрация привязок, алиасов и сторонних провайдеров сервисов.
     *
     * @return void
     */
    protected function registerBindings(): void
    {
        // Controllers
        $this->app->bind('InetStudio\Widgets\Contracts\Http\Controllers\Back\WidgetsControllerContract', 'InetStudio\Widgets\Http\Controllers\Back\WidgetsController');

        // Events
        $this->app->bind('InetStudio\Widgets\Contracts\Events\Back\ModifyWidgetEventContract', 'InetStudio\Widgets\Events\Back\ModifyWidgetEvent');

        // Models
        $this->app->bind('InetStudio\Widgets\Contracts\Models\WidgetModelContract', 'InetStudio\Widgets\Models\WidgetModel');

        // Observers
        $this->app->bind('InetStudio\Widgets\Contracts\Observers\WidgetObserverContract', 'InetStudio\Widgets\Observers\WidgetObserver');

        // Repositories
        $this->app->bind('InetStudio\Widgets\Contracts\Repositories\WidgetsRepositoryContract', 'InetStudio\Widgets\Repositories\WidgetsRepository');

        // Requests
        $this->app->bind('InetStudio\Widgets\Contracts\Http\Requests\Back\SaveWidgetRequestContract', 'InetStudio\Widgets\Http\Requests\Back\SaveWidgetRequest');

        // Responses
        $this->app->bind('InetStudio\Widgets\Contracts\Http\Responses\Back\Widgets\DestroyResponseContract', 'InetStudio\Widgets\Http\Responses\Back\Widgets\DestroyResponse');
        $this->app->bind('InetStudio\Widgets\Contracts\Http\Responses\Back\Widgets\SaveResponseContract', 'InetStudio\Widgets\Http\Responses\Back\Widgets\SaveResponse');
        $this->app->bind('InetStudio\Widgets\Contracts\Http\Responses\Back\Widgets\ShowResponseContract', 'InetStudio\Widgets\Http\Responses\Back\Widgets\ShowResponse');

        // Services
        $this->app->bind('InetStudio\Widgets\Contracts\Services\Back\WidgetsObserverServiceContract', 'InetStudio\Widgets\Services\Back\WidgetsObserverService');
        $this->app->bind('InetStudio\Widgets\Contracts\Services\Back\WidgetsServiceContract', 'InetStudio\Widgets\Services\Back\WidgetsService');
    }
}
