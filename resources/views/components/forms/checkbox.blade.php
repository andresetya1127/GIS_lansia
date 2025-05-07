@props([
    'label' => '',
    'id' => '',
    'name' => null,
    'value' => null,
])

@php

    if (strpos($name, '[]')) {
        $checkOld = in_array($value, old(str_replace('[]', '', $name), []));
    } else {
        $checkOld = old($name) == $value;
    }
@endphp


<div class="mb-3">
    <div class="form-check">
        <input
            {{ $attributes->merge([
                'class' => 'form-check-input' . ($errors->has($name) ? ' is-invalid' : ''),
                'name' => $name,
                'value' => $value,
                'type' => 'checkbox',
            ]) }}
            id="{{ str_replace(' ', '-', $id) }}" @if ($checkOld) checked @endif>
        <label class="form-check-label" for="{{ str_replace(' ', '-', $id) }}">
            {{ $label }}
        </label>
    </div>
</div>
