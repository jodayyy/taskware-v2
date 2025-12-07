@props([
    'name' => 'priority',
    'label' => 'Priority',
    'value' => 'normal',
    'required' => false,
    'id' => null,
])

@php
    $inputId = $id ?? $name;
    $selectedValue = $value ?? old($name, 'normal');
    $priorities = [
        'low' => 'Low',
        'normal' => 'Normal',
        'urgent' => 'Urgent',
    ];
@endphp

<div class="form-group mt-2">
    <label for="{{ $inputId }}" class="form-label">{{ $label }}</label>
    <div class="priority-select">
        @foreach($priorities as $priorityValue => $priorityLabel)
            <label class="priority-option">
                <input 
                    type="radio" 
                    name="{{ $name }}" 
                    value="{{ $priorityValue }}"
                    id="{{ $inputId }}-{{ $priorityValue }}"
                    class="priority-radio"
                    @if($selectedValue === $priorityValue) checked @endif
                    @if($required) required @endif
                >
                <span class="priority-label priority-{{ $priorityValue }}">
                    {{ $priorityLabel }}
                </span>
            </label>
        @endforeach
    </div>
    @error($name)
        <span class="form-error">{{ $message }}</span>
    @enderror
</div>

