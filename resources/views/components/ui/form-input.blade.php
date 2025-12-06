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
    @if($type === 'password')
        <div class="password-input-wrapper">
            <input 
                type="password"
                id="{{ $inputId }}"
                name="{{ $name }}"
                class="form-input password-input @error($name) form-input-error @enderror"
                value="{{ $inputValue }}"
                @if($required) required @endif
                @if($minlength) minlength="{{ $minlength }}" @endif
                @if($maxlength) maxlength="{{ $maxlength }}" @endif
                @if($placeholder) placeholder="{{ $placeholder }}" @endif
                @if($readonly) readonly @endif
                @if($autofocus) autofocus @endif
                {{ $inputAttributes }}
            >
            <button type="button" class="password-toggle-btn" aria-label="Toggle password visibility">
                <span class="eye-icon eye-open-icon">
                    <x-icons.eye-open />
                </span>
                <span class="eye-icon eye-closed-icon hidden">
                    <x-icons.eye-closed />
                </span>
            </button>
        </div>
    @else
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
    @endif
    @error($name)
        <span class="form-error">{{ $message }}</span>
    @enderror
    {{ $slot }}
</div>