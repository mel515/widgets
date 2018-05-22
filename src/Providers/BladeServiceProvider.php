<?php

namespace InetStudio\Widgets\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

/**
 * Class BladeServiceProvider.
 */
class BladeServiceProvider extends ServiceProvider
{
    /**
     * Используемые сервисы.
     *
     * @var array
     */
    private $services;

    /**
     * WidgetsController constructor.
     */
    public function __construct()
    {
        $this->services['widgets'] = app()->make('InetStudio\Widgets\Contracts\Services\Back\WidgetsServiceContract');
    }

    /**
     * Загрузка сервиса.
     *
     * @return void
     */
    public function boot(): void
    {
        Blade::directive('widget', function ($expression) {
            $widget = $this->services['widgets']->getWidgetObject($expression);

            if ($widget->id) {
                $view = $widget->view;

                if (view()->exists($view)) {
                    return view($view, $widget->params);
                }
            }

            return '';
        });
    }

    /**
     * Регистрация привязки в контейнере.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }
}
