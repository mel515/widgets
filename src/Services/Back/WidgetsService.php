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
     * Получаем объект модели.
     *
     * @param int $id
     *
     * @return WidgetModelContract
     */
    public function getWidgetObject(int $id = 0)
    {
        return $this->repository->getItemByID($id);
    }

    /**
     * Получаем объекты по списку id.
     *
     * @param array|int $ids
     * @param bool $returnBuilder
     *
     * @return mixed
     */
    public function getWidgetsByIDs($ids, bool $returnBuilder = false)
    {
        return $this->repository->getItemsByIDs($ids, $returnBuilder);
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

    /**
     * Присваиваем виджеты объекту.
     *
     * @param $request
     *
     * @param $item
     */
    public function attachToObject($request, $item)
    {
        if ($request->filled('widgets')) {
            $widgets = explode(',', $request->get('widgets'));
            $item->syncWidgets($this->repository->getItemsByIDs((array) $widgets));
        } else {
            $item->detachWidgets($item->widgets);
        }
    }
}
