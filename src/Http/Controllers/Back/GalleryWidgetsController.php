<?php

namespace InetStudio\Widgets\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use InetStudio\Widgets\Contracts\Http\Controllers\Back\GalleryWidgetsControllerContract;
use InetStudio\Widgets\Contracts\Http\Responses\Back\GalleryWidgets\GetWidgetImagesResponseContract;
use InetStudio\Widgets\Contracts\Http\Responses\Back\GalleryWidgets\AttachImagesToWidgetResponseContract;

/**
 * Class GalleryWidgetsController.
 */
class GalleryWidgetsController extends Controller implements GalleryWidgetsControllerContract
{
    /**
     * Используемые сервисы.
     *
     * @var array
     */
    public $services;

    /**
     * WidgetsController constructor.
     */
    public function __construct()
    {
        $this->services['widgets'] = app()->make('InetStudio\Widgets\Contracts\Services\Back\WidgetsServiceContract');
    }

    /**
     * Загружаем изображения для виджета.
     *
     * @param Request $request
     *
     * @return AttachImagesToWidgetResponseContract
     */
    public function attachImagesToWidget(Request $request): AttachImagesToWidgetResponseContract
    {
        $widgetID = (int) $request->get('widgetID');
        $widgetType = $request->get('material_type');

        $this->services['widgets']->attachImagesToWidget($widgetID, $widgetType);

        return app()->makeWith('InetStudio\Widgets\Contracts\Http\Responses\Back\GalleryWidgets\AttachImagesToWidgetResponseContract', [
            'result' => [
                'success' => true,
            ],
        ]);
    }

    /**
     * Получаем изображения, прикрепленные к виджету.
     *
     * @param Request $request
     *
     * @return GetWidgetImagesResponseContract
     */
    public function getWidgetImages(Request $request): GetWidgetImagesResponseContract
    {
        $widgetID = (int) $request->get('widgetID');
        $collection = $request->get('collection');

        $media = $this->services['widgets']->getWidgetImages($widgetID, $collection);

        return app()->makeWith('InetStudio\Widgets\Contracts\Http\Responses\Back\GalleryWidgets\GetWidgetImagesResponseContract', [
            'media' => $media,
        ]);
    }
}
