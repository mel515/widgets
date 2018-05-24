<?php

namespace InetStudio\Widgets\Repositories;

use Illuminate\Database\Eloquent\Builder;
use InetStudio\Widgets\Contracts\Models\WidgetModelContract;
use InetStudio\Widgets\Contracts\Repositories\WidgetsRepositoryContract;
use InetStudio\Widgets\Contracts\Http\Requests\Back\SaveWidgetRequestContract;

/**
 * Class WidgetsRepository.
 */
class WidgetsRepository implements WidgetsRepositoryContract
{
    /**
     * @var WidgetModelContract
     */
    private $model;

    /**
     * TagsRepository constructor.
     *
     * @param WidgetModelContract $model
     */
    public function __construct(WidgetModelContract $model)
    {
        $this->model = $model;
    }

    /**
     * Возвращаем объект по id, либо создаем новый.
     *
     * @param int $id
     *
     * @return WidgetModelContract
     */
    public function getItemByID(int $id): WidgetModelContract
    {
        return $this->model::find($id) ?? new $this->model;
    }

    /**
     * Возвращаем объекты по списку id.
     *
     * @param $ids
     * @param bool $returnBuilder
     *
     * @return mixed
     */
    public function getItemsByIDs($ids, bool $returnBuilder = false)
    {
        $builder = $this->getItemsQuery()->whereIn('id', (array) $ids);

        if ($returnBuilder) {
            return $builder;
        }

        return $builder->get();
    }

    /**
     * Сохраняем объект.
     *
     * @param SaveWidgetRequestContract $request
     * @param int $id
     *
     * @return WidgetModelContract
     */
    public function save(SaveWidgetRequestContract $request, int $id): WidgetModelContract
    {
        $item = $this->getItemByID($id);

        $item->view = strip_tags($request->get('view'));
        $item->params = $request->input('params');
        $item->additional_info = $request->input('additional_info');
        $item->save();

        return $item;
    }

    /**
     * Удаляем объект.
     *
     * @param int $id
     *
     * @return bool
     */
    public function destroy($id): ?bool
    {
        return $this->getItemByID($id)->delete();
    }

    /**
     * Ищем объекты.
     *
     * @param string $field
     * @param $value
     * @param bool $returnBuilder
     *
     * @return mixed
     */
    public function searchItemsByField(string $field, string $value, bool $returnBuilder = false)
    {
        $builder = $this->getItemsQuery()->where($field, 'LIKE', '%'.$value.'%');

        if ($returnBuilder) {
            return $builder;
        }

        return $builder->get();
    }

    /**
     * Получаем все объекты.
     *
     * @param bool $returnBuilder
     *
     * @return mixed
     */
    public function getAllItems(bool $returnBuilder = false)
    {
        $builder = $this->getItemsQuery(['created_at', 'updated_at'])->orderBy('created_at', 'desc');

        if ($returnBuilder) {
            return $builder;
        }

        return $builder->get();
    }

    /**
     * Возвращаем запрос на получение объектов.
     *
     * @param array $extColumns
     * @param array $with
     *
     * @return Builder
     */
    protected function getItemsQuery($extColumns = [], $with = []): Builder
    {
        $defaultColumns = ['id', 'view', 'params'];

        $relations = [];

        return $this->model::select(array_merge($defaultColumns, $extColumns))
            ->with(array_intersect_key($relations, array_flip($with)));
    }
}
