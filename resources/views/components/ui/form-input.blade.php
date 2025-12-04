@props([
    'name',
    'label',
    'type' => 'text',
    'value' => null,
    'required' => false,
    'minlength' => null,
    'maxlength' => null,
    'placeholder' => null,
    'readonly' => false,
    'autofocus' => false,
    'id' => null,
])

@php
    $inputId = $id ?? $name;
    $inputValue = $value ?? old($name);
    $wrapperClass = $attributes->get('class', '');
    $inputAttributes = $attributes->except('class');
@endphp

<div class="form-group {{ $wrapperClass }}">
    <label for="{{ $inputId }}" class="form-label">{{ $label }}</label>
    <input 
        type="{{ $type }}"
        id="{{ $inputId }}"
        name="{{ $name }}"
        class="form-input @error($name) form-input-error @enderror"
        value="{{ $inputValue }}"
        @if($required) required @endif
        @if($minlength) minlength="{{ $minlength }}" @endif
        @if($maxlength) maxlength="{{ $maxlength }}" @endif
        @if($placeholder) placeholder="{{ $placeholder }}" @endif
        @if($readonly) readonly @endif
        @if($autofocus) autofocus @endif
        {{ $inputAttributes }}
    >
    @error($name)
        <span class="form-error">{{ $message }}</span>
    @enderror
    {{ $slot }}
</div>

