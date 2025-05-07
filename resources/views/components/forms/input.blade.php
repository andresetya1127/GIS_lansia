@props([
    'label' => '',
    'name' => null,
    'class' => 'form-control' . ($errors->has($name) ? ' is-invalid' : ''),
    'highlight' => false,
])

<div class="mb-3">
    <label for="{{ $id ?? '' }}" class="form-label">{{ $label }}</label>
    <input
        {{ $attributes->merge([
            'class' => $class,
            'type' => 'text',
            'placeholder' => $label,
            'value' => old($name),
            'name' => $name,
        ]) }}>
    @if ($highlight)
        <div class="form-text">{{ $highlight }}</div>
    @endif
    @error($name)
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
