@props([
    'name',
    'label',
    'options' => [],
    'value' => null,
    'required' => false,
    'placeholder' => null,
    'id' => null,
    'optionValue' => 'id',
    'optionLabel' => 'title',
])

@php
    $inputId = $id ?? $name;
    $selectedValue = $value ?? old($name);
    $wrapperClass = $attributes->get('class', '');
    $selectAttributes = $attributes->except(['class', 'options', 'value', 'optionValue', 'optionLabel', 'placeholder']);
    
    // Handle options - can be array or collection
    $optionsArray = [];
    if (is_array($options)) {
        $optionsArray = $options;
    } elseif (is_object($options) && method_exists($options, 'toArray')) {
        // Collection or array-like object
        foreach ($options as $key => $item) {
            if (is_array($item)) {
                $val = $item[$optionValue] ?? $key;
                $label = $item[$optionLabel] ?? $item['name'] ?? $item['title'] ?? $val;
                $optionsArray[$val] = $label;
            } elseif (is_object($item)) {
                $val = $item->{$optionValue} ?? $key;
                $label = $item->{$optionLabel} ?? ($item->name ?? ($item->title ?? $val));
                $optionsArray[$val] = $label;
            } else {
                $optionsArray[$key] = $item;
            }
        }
    }
@endphp

<div class="form-group mt-2 {{ $wrapperClass }}">
    <label for="{{ $inputId }}" class="form-label">{{ $label }}</label>
    <select 
        id="{{ $inputId }}"
        name="{{ $name }}" 
        class="form-input @error($name) form-input-error @enderror"
        @if($required) required @endif
        {{ $selectAttributes }}
    >
        @if($placeholder !== null)
            <option value="">{{ $placeholder }}</option>
        @endif
        @foreach($optionsArray as $optionValue => $optionLabel)
            <option 
                value="{{ $optionValue }}" 
                {{ (string)$selectedValue === (string)$optionValue ? 'selected' : '' }}
            >
                {{ $optionLabel }}
            </option>
        @endforeach
    </select>
    @error($name)
        <span class="form-error">{{ $message }}</span>
    @enderror
    {{ $slot }}
</div>

