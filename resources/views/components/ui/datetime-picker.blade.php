@props([
    'name' => 'due',
    'label' => 'Due Date & Time',
    'value' => null,
    'required' => false,
    'id' => null,
])

@php
    $inputId = $id ?? $name;
    $inputValue = $value ?? old($name);
    // Format datetime for input if it's a Carbon instance or string
    if ($inputValue instanceof \Carbon\Carbon) {
        $inputValue = $inputValue->format('Y-m-d\TH:i');
    } elseif (is_string($inputValue) && $inputValue) {
        try {
            $inputValue = \Carbon\Carbon::parse($inputValue)->format('Y-m-d\TH:i');
        } catch (\Exception $e) {
            $inputValue = '';
        }
    } else {
        $inputValue = '';
    }
@endphp

<div class="form-group mt-2">
    <label for="{{ $inputId }}" class="form-label">{{ $label }}</label>
    <input 
        type="datetime-local"
        id="{{ $inputId }}"
        name="{{ $name }}" 
        class="form-input @error($name) form-input-error @enderror"
        value="{{ $inputValue }}"
        @if($required) required @endif
    >
    @error($name)
        <span class="form-error">{{ $message }}</span>
    @enderror
</div>

