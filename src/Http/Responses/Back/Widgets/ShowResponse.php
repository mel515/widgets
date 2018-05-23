<?php

namespace InetStudio\Widgets\Http\Responses\Back\Widgets;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Support\Responsable;
use InetStudio\Widgets\Contracts\Models\WidgetModelContract;
use InetStudio\Widgets\Contracts\Http\Responses\Back\Widgets\ShowResponseContract;

/**
 * Class ShowResponse.
 */
class ShowResponse implements ShowResponseContract, Responsable
{
    /**
     * @var WidgetModelContract
     */
    private $item;

    /**
     * ShowResponse constructor.
     *
     * @param WidgetModelContract $item
     */
    public function __construct(WidgetModelContract $item)
    {
        $this->item = $item;
    }

    /**
     * Возвращаем ответ при получении объекта.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return JsonResponse
     */
    public function toResponse($request): JsonResponse
    {
        return response()->json($this->item);
    }
}
