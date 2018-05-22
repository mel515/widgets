@inject('widgetsService', 'InetStudio\Widgets\Contracts\Services\Common\WidgetsServiceContract')

@php
    $widgetString = $widgetsService->transformWidgetToString($id);
@endphp

{!! blade_string($widgetString) !!}
