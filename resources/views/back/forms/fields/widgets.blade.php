@php
    $item = $value;
@endphp

{!! Form::hidden('widgets', implode($item->widgets()->pluck('id')->toArray(), ',')) !!}
