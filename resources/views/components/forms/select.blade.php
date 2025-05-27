@props([
    'label' => '',
    'name' => null,
    'selectType' => 'select-beast',
    'class' => 'form-select' . ($errors->has($name) ? ' is-invalid' : ''),
    'id' => '',
    'placeholder' => __('Select a person...'),
    'autocomplete' => 'off',
])

<div class="mb-3">
    <label for="{{ $id ?? '' }}" class="form-label">{{ $label }}</label>
    <select
        {{ $attributes->merge([
            'class' => $class . ($selectType !== 'normal' ? ' select-beast' : ''),
            'name' => $name,
            'id' => $id,
            'placeholder' => $placeholder,
            'autocomplete' => $autocomplete,
        ]) }}>
        {{ $slot }}
    </select>
</div>
