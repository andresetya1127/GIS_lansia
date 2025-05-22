@props([
    'type' => 'button',
    'title' => null,
    'icon' => null,
    'url' => null,
    'color' => 'primary',
    'wire:click' => null,
])

<!-- From Uiverse.io by vinodjangid07 -->
<button {{ $attributes->merge(['class' => 'text-white btn btn-' . $color, 'type' => $type]) }}
    @if ($url) onclick="location.href='{{ $url }}'" @endif>
    <i class="fa-solid {{ $icon }}"></i>
    {{ $title ?? '' }}
</button>
