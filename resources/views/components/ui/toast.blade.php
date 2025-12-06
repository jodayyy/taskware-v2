@props(['type' => 'info', 'title' => 'Info', 'description' => '', 'id' => null])

@php
    $toastId = $id ?? 'toast-' . uniqid();
    $typeClasses = [
        'success' => 'toast-success',
        'error' => 'toast-error',
        'info' => 'toast-info',
    ];
    $typeClass = $typeClasses[$type] ?? $typeClasses['info'];
@endphp

<div id="{{ $toastId }}" class="toast {{ $typeClass }}" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-content">
        <div class="toast-body">
            <h4 class="toast-title">{{ $title }}</h4>
            @if($description)
                <p class="toast-description">{{ $description }}</p>
            @endif
        </div>
        <button type="button" class="toast-close" aria-label="Close" onclick="this.closest('.toast').remove()">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>

