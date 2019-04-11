<?php

namespace InetStudio\Widgets\Services\Back;

use Illuminate\Support\Facades\Session;
use InetStudio\AdminPanel\Base\Services\BaseService;
use InetStudio\Widgets\Contracts\Models\WidgetModelContract;
use InetStudio\Widgets\Contracts\Services\Back\WidgetsServiceContract;
use InetStudio\Widgets\Contracts\Repositories\WidgetsRepositoryContract;
use InetStudio\Widgets\Contracts\Http\Requests\Back\SaveWidgetRequestContract;

/**
 * Class WidgetsService.
 */
class WidgetsService extends BaseService implements WidgetsServiceContract
{
    /**
     * Используемые сервисы.
     *
     * @var array
     */
    public $services = [];

    /**
     * @var WidgetsRepositoryContract
     */
    public $repository;

    /**
     * WidgetsService constructor.
     *
     * @param WidgetsRepositoryContract $repository
     */
    public function __construct(WidgetsRepositoryContract $repository)
    {
        parent::__construct(app()->make('InetStudio\Widgets\Contracts\Models\WidgetModelContract'));

        $this->services['images'] = app()->make('InetStudio\Uploads\Contracts\Services\Back\ImagesServiceContract');

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

    /**
     * Присваиваем изображения виджету.
     *
     * @param int $widgetID
     *
     * @param string $widgetType
     */
    public function attachImagesToWidget(int $widgetID, string $widgetType): void
    {
        $widget = $this->getWidgetObject($widgetID);

        $images = (config('widgets.images.conversions.'.$widgetType)) ? array_keys(config('widgets.images.conversions.'.$widgetType)) : [];
        $this->services['images']->attachToObject(request(), $widget, $images, 'widgets', $widgetType);
    }

    /**
     * Возвращаем изображения виджета.
     *
     * @param int $widgetID
     * @param string $collection
     *
     * @return array
     */
    public function getWidgetImages(int $widgetID, string $collection): array
    {
        $widget = $this->getWidgetObject($widgetID);
        $images = $widget->getMedia($collection);

        $media = [];

        foreach ($images as $mediaItem) {
            $data = [
                'id' => $mediaItem->id,
                'src' => url($mediaItem->getUrl()),
                'thumb' => ($mediaItem->getUrl($collection.'_admin')) ? url($mediaItem->getUrl($collection.'_admin')) : url($mediaItem->getUrl()),
                'properties' => $mediaItem->custom_properties,
            ];

            $media[] = $data;
        }

        return $media;
    }
}
