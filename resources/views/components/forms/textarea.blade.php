@props([
    'label' => '',
    'name' => null,
    'class' => 'form-control' . ($errors->has($name) ? ' is-invalid' : ''),
    'id' => '',
    'value' => null
])

<div class="mb-3">
    <label for="{{ $id ?? '' }}" class="form-label">{{ $label }}</label>
    <textarea
        {{ $attributes->merge([
            'class' => $class,
            'placeholder' => $label,
            'name' => $name,
            'rows' => '3',
        ]) }}>{{old($name, $value)}}</textarea>
    @error($name)
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
