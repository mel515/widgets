<?php

namespace InetStudio\Widgets\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
     * @param Request $request
     *
     * @return string
     *
     * @throws \Throwable
     */
    public function getWidget(Request $request): string
    {
        $id = $request->get('id') ?? 0;

        return $this->services['widgets']->getWidgetContent($id);
    }
}
