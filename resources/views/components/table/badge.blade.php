@props([
    'class' => 'secondary',
    'icon' => null,
])

<span class="badge text-bg-{{ $class }}">
    @isset($icon)
        <i class="{{ $icon }}"></i> {{ $slot }}
    @endisset
</span>
