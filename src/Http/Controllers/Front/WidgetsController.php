<?php

namespace InetStudio\Widgets\Http\Controllers\Front;

use InetStudio\AdminPanel\Base\Http\Controllers\Controller;
use InetStudio\Widgets\Contracts\Http\Controllers\Front\WidgetsControllerContract;

/**
 * Class WidgetsController.
 */
class WidgetsController extends Controller implements WidgetsControllerContract
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
        $this->services['widgets'] = app()->make('InetStudio\Widgets\Contracts\Services\Front\WidgetsServiceContract');
    }

    /**
     * Получаем содержимое виджета.
     *
     * @param int $id
     *
     * @return string
     *
     * @throws \Throwable
     */
    public function getWidget(int $id): string
    {
        return $this->services['widgets']->getWidgetContent($id);
    }
}
