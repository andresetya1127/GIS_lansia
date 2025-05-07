@php
    if (isset($attributes['class'])) {
        $attributes['class'] .= ' dropdown-item ';
    } else {
        $attributes['class'] = ' dropdown-item ';
    }
@endphp

@if (strstr($attributes['class'], 'd-none') == false)
    <a href="{{ $path }}" {!! count($attributes) ? $column->arrayToAttributes($attributes) : '' !!}>
        @if (isset($attributes['icon']))
            <i class="{{ $attributes['icon'] }}"></i>
        @endif
        @if ($column->isHtml())
            {!! $title !!}
        @else
            {{ $title }}
        @endif
    </a>
@endif
