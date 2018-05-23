<?php

namespace InetStudio\Widgets\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use InetStudio\Widgets\Contracts\Http\Requests\Back\SaveWidgetRequestContract;
use InetStudio\Widgets\Contracts\Http\Controllers\Back\WidgetsControllerContract;
use InetStudio\Widgets\Contracts\Http\Responses\Back\Widgets\SaveResponseContract;
use InetStudio\Widgets\Contracts\Http\Responses\Back\Widgets\ShowResponseContract;
use InetStudio\Widgets\Contracts\Http\Responses\Back\Widgets\DestroyResponseContract;

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
        $this->services['widgets'] = app()->make('InetStudio\Widgets\Contracts\Services\Back\WidgetsServiceContract');
    }

    /**
     * Получение объекта.
     *
     * @param int $id
     *
     * @return ShowResponseContract
     */
    public function show(int $id = 0): ShowResponseContract
    {
        $item = $this->services['widgets']->getWidgetObject($id);

        return app()->makeWith('InetStudio\Widgets\Contracts\Http\Responses\Back\Widgets\ShowResponseContract', [
            'item' => $item,
        ]);
    }

    /**
     * Создание объекта.
     *
     * @param SaveWidgetRequestContract $request
     *
     * @return SaveResponseContract
     */
    public function store(SaveWidgetRequestContract $request): SaveResponseContract
    {
        return $this->save($request);
    }

    /**
     * Обновление объекта.
     *
     * @param SaveWidgetRequestContract $request
     * @param int $id
     *
     * @return SaveResponseContract
     */
    public function update(SaveWidgetRequestContract $request, int $id = 0): SaveResponseContract
    {
        return $this->save($request, $id);
    }

    /**
     * Сохранение объекта.
     *
     * @param SaveWidgetRequestContract $request
     * @param int $id
     *
     * @return SaveResponseContract
     */
    private function save(SaveWidgetRequestContract $request, int $id = 0): SaveResponseContract
    {
        $item = $this->services['widgets']->save($request, $id);

        return app()->makeWith('InetStudio\Widgets\Contracts\Http\Responses\Back\Widgets\SaveResponseContract', [
            'item' => $item,
        ]);
    }

    /**
     * Удаление объекта.
     *
     * @param int $id
     *
     * @return DestroyResponseContract
     */
    public function destroy(int $id = 0): DestroyResponseContract
    {
        $result = $this->services['widgets']->destroy($id);

        return app()->makeWith('InetStudio\Widgets\Contracts\Http\Responses\Back\Widgets\DestroyResponseContract', [
            'result' => ($result === null) ? false : $result,
        ]);
    }
}
