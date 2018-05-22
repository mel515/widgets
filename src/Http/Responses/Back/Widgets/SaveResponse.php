<?php

namespace InetStudio\Widgets\Http\Responses\Back\Widgets;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Support\Responsable;
use InetStudio\Widgets\Contracts\Models\WidgetModelContract;
use InetStudio\Widgets\Contracts\Http\Responses\Back\Widgets\SaveResponseContract;

/**
 * Class SaveResponse.
 */
class SaveResponse implements SaveResponseContract, Responsable
{
    /**
     * @var WidgetModelContract
     */
    private $item;

    /**
     * SaveResponse constructor.
     *
     * @param WidgetModelContract $item
     */
    public function __construct(WidgetModelContract $item)
    {
        $this->item = $item;
    }

    /**
     * Возвращаем ответ при сохранении объекта.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return JsonResponse
     */
    public function toResponse($request): JsonResponse
    {
        return response()->json([
            'id' => $this->item->id,
        ]);
    }
}
