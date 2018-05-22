<?php

namespace InetStudio\Widgets\Services\Back;

use InetStudio\Widgets\Contracts\Models\WidgetModelContract;
use InetStudio\Widgets\Contracts\Repositories\WidgetsRepositoryContract;
use InetStudio\Widgets\Contracts\Services\Back\WidgetsObserverServiceContract;

/**
 * Class WidgetsObserverService.
 */
class WidgetsObserverService implements WidgetsObserverServiceContract
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
     * Событие "объект создается".
     *
     * @param WidgetModelContract $item
     */
    public function creating(WidgetModelContract $item): void
    {
    }

    /**
     * Событие "объект создан".
     *
     * @param WidgetModelContract $item
     */
    public function created(WidgetModelContract $item): void
    {
    }

    /**
     * Событие "объект обновляется".
     *
     * @param WidgetModelContract $item
     */
    public function updating(WidgetModelContract $item): void
    {
    }

    /**
     * Событие "объект обновлен".
     *
     * @param WidgetModelContract $item
     */
    public function updated(WidgetModelContract $item): void
    {
    }

    /**
     * Событие "объект подписки удаляется".
     *
     * @param WidgetModelContract $item
     */
    public function deleting(WidgetModelContract $item): void
    {
    }

    /**
     * Событие "объект удален".
     *
     * @param WidgetModelContract $item
     */
    public function deleted(WidgetModelContract $item): void
    {
    }
}
