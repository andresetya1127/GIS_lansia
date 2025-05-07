@props(['wire:click' => null])
<button {{ $attributes->merge($attribut) }}>
    @if (isset($icon))
        <i class="fa-solid {{ $icon }}"></i>
    @endif
    {{ $slot ?? '' }}
</button>
