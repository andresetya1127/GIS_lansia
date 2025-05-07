<div
    {{ $attributes->merge([
        'class' => 'btn-group',
        'role' => 'group',
        'aria-label' => 'Button group',
    ]) }}>
    {{ $slot }}
</div>
