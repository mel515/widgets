<?php

namespace InetStudio\Widgets\Services\Front;

use InetStudio\Widgets\Contracts\Services\Front\WidgetsServiceContract;
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
     * Получаем содержимое виджета.
     *
     * @param int $id
     *
     * @return string
     */
    public function getWidgetContent(int $id): string
    {
        $widget = $this->repository->getItemByID($id);

        if ($widget->id) {
            $view = $widget->view;

            if (view()->exists($view)) {
                return view($view, $widget->params);
            }
        }

        return '';
    }
}
