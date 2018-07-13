<?php

namespace InetStudio\Widgets\Http\Responses\Back\GalleryWidgets;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Support\Responsable;
use InetStudio\Widgets\Contracts\Http\Responses\Back\GalleryWidgets\AttachImagesToWidgetResponseContract;

/**
 * Class AttachImagesToWidgetResponse.
 */
class AttachImagesToWidgetResponse implements AttachImagesToWidgetResponseContract, Responsable
{
    /**
     * @var array
     */
    private $result;

    /**
     * AttachImagesToWidgetResponse constructor.
     *
     * @param array $result
     */
    public function __construct(array $result)
    {
        $this->result = $result;
    }

    /**
     * Возвращаем ответ при прикреплении изображений к виджету.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return JsonResponse
     */
    public function toResponse($request): JsonResponse
    {
        return response()->json($this->result);
    }
}
