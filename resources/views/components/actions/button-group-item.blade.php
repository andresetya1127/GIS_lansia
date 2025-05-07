{{-- @props(['title' => null, 'icon' => null]) --}}

<input
    {{ $attributes->merge([
        'class' => 'btn-check',
        'type' => 'radio',
        'autocomplete' => 'off',
    ]) }}>
<label class="btn btn-outline-info" for="{{ $id ?? '' }}">
    @if ('icon' != null)
        <i class="{{ $icon }}"></i>
    @endif
    {{ $title }}
</label>
