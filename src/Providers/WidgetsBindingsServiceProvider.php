<?php

namespace InetStudio\Widgets\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class WidgetsBindingsServiceProvider.
 */
class WidgetsBindingsServiceProvider extends ServiceProvider
{
    /**
    * @var  bool
    */
    protected $defer = true;

    /**
    * @var  array
    */
    public $bindings = [
        'InetStudio\Widgets\Contracts\Events\Back\ModifyWidgetEventContract' => 'InetStudio\Widgets\Events\Back\ModifyWidgetEvent',
        'InetStudio\Widgets\Contracts\Http\Controllers\Back\GalleryWidgetsControllerContract' => 'InetStudio\Widgets\Http\Controllers\Back\GalleryWidgetsController',
        'InetStudio\Widgets\Contracts\Http\Controllers\Back\WidgetsControllerContract' => 'InetStudio\Widgets\Http\Controllers\Back\WidgetsController',
        'InetStudio\Widgets\Contracts\Http\Controllers\Front\WidgetsControllerContract' => 'InetStudio\Widgets\Http\Controllers\Front\WidgetsController',
        'InetStudio\Widgets\Contracts\Http\Requests\Back\SaveWidgetRequestContract' => 'InetStudio\Widgets\Http\Requests\Back\SaveWidgetRequest',
        'InetStudio\Widgets\Contracts\Http\Responses\Back\GalleryWidgets\AttachImagesToWidgetResponseContract' => 'InetStudio\Widgets\Http\Responses\Back\GalleryWidgets\AttachImagesToWidgetResponse',
        'InetStudio\Widgets\Contracts\Http\Responses\Back\GalleryWidgets\GetWidgetImagesResponseContract' => 'InetStudio\Widgets\Http\Responses\Back\GalleryWidgets\GetWidgetImagesResponse',
        'InetStudio\Widgets\Contracts\Http\Responses\Back\Widgets\DestroyResponseContract' => 'InetStudio\Widgets\Http\Responses\Back\Widgets\DestroyResponse',
        'InetStudio\Widgets\Contracts\Http\Responses\Back\Widgets\SaveResponseContract' => 'InetStudio\Widgets\Http\Responses\Back\Widgets\SaveResponse',
        'InetStudio\Widgets\Contracts\Http\Responses\Back\Widgets\ShowResponseContract' => 'InetStudio\Widgets\Http\Responses\Back\Widgets\ShowResponse',
        'InetStudio\Widgets\Contracts\Models\WidgetModelContract' => 'InetStudio\Widgets\Models\WidgetModel',
        'InetStudio\Widgets\Contracts\Observers\WidgetObserverContract' => 'InetStudio\Widgets\Observers\WidgetObserver',
        'InetStudio\Widgets\Contracts\Repositories\WidgetsRepositoryContract' => 'InetStudio\Widgets\Repositories\WidgetsRepository',
        'InetStudio\Widgets\Contracts\Services\Back\WidgetsObserverServiceContract' => 'InetStudio\Widgets\Services\Back\WidgetsObserverService',
        'InetStudio\Widgets\Contracts\Services\Back\WidgetsServiceContract' => 'InetStudio\Widgets\Services\Back\WidgetsService',
        'InetStudio\Widgets\Contracts\Services\Front\WidgetsServiceContract' => 'InetStudio\Widgets\Services\Front\WidgetsService',
    ];

    /**
     * Получить сервисы от провайдера.
     *
     * @return  array
     */
    public function provides()
    {
        return array_keys($this->bindings);
    }
}
