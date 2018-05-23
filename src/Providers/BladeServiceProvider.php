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
     * Загрузка сервиса.
     *
     * @return void
     */
    public function boot(): void
    {
        $widgetsService = app()->make('InetStudio\Widgets\Contracts\Services\Back\WidgetsServiceContract');

        Blade::directive('widget', function ($expression) use ($widgetsService) {
            $widget = $widgetsService->getWidgetObject($expression);

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
