<?php

namespace InetStudio\Widgets\Http\Responses\Back\GalleryWidgets;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Support\Responsable;
use InetStudio\Widgets\Contracts\Http\Responses\Back\GalleryWidgets\GetWidgetImagesResponseContract;

/**
 * Class GetWidgetImagesResponse.
 */
class GetWidgetImagesResponse implements GetWidgetImagesResponseContract, Responsable
{
    /**
     * @var array
     */
    private $media;

    /**
     * GetWidgetImagesResponse constructor.
     *
     * @param array $media
     */
    public function __construct(array $media)
    {
        $this->media = $media;
    }

    /**
     * Возвращаем изображения, прикрепленные к виджету.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return JsonResponse
     */
    public function toResponse($request): JsonResponse
    {
        return response()->json($this->media);
    }
}
