<?php

namespace InetStudio\Widgets\Services\Back;

use Illuminate\Support\Facades\Session;
use InetStudio\Widgets\Contracts\Models\WidgetModelContract;
use InetStudio\Widgets\Contracts\Services\Back\WidgetsServiceContract;
use InetStudio\Widgets\Contracts\Repositories\WidgetsRepositoryContract;
use InetStudio\Widgets\Contracts\Http\Requests\Back\SaveWidgetRequestContract;

/**
 * Class WidgetsService.
 */
class WidgetsService implements WidgetsServiceContract
{
    /**
     * @var WidgetsRepositoryContract
     */
    private $repository;

    /**
     * WidgetsService constructor.
     *
     * @param WidgetsRepositoryContract $repository
     */
    public function __construct(WidgetsRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Сохраняем модель.
     *
     * @param SaveWidgetRequestContract $request
     * @param int $id
     *
     * @return WidgetModelContract
     */
    public function save(SaveWidgetRequestContract $request, int $id): WidgetModelContract
    {
        $action = ($id) ? 'отредактирован' : 'создан';
        $item = $this->repository->save($request, $id);

        event(app()->makeWith('InetStudio\Widgets\Contracts\Events\Back\ModifyWidgetEventContract', [
            'object' => $item,
        ]));

        Session::flash('success', 'Виджет «'.$item->name.'» успешно '.$action);

        return $item;
    }

    /**
     * Удаляем модель.
     *
     * @param $id
     *
     * @return bool
     */
    public function destroy(int $id): ?bool
    {
        return $this->repository->destroy($id);
    }
}
