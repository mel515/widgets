<?php

namespace InetStudio\Widgets\Services\Common;

use InetStudio\Widgets\Contracts\Models\WidgetModelContract;
use InetStudio\Widgets\Contracts\Services\Common\WidgetsServiceContract;
use InetStudio\Widgets\Contracts\Repositories\WidgetsRepositoryContract;

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

    public function transformWidgetToString(int $id = 0)
    {
        $widget = $this->repository->getItemByID($id);

        $widgetString = '@'.$widget->directive.'(\''.$widget->view.'\', \''.implode('\', \'', $widget->params).'\')';

        return $widgetString;
    }
}
