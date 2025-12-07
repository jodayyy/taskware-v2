@props([
    'id' => 'deleteConfirmDialog', 
    'title' => 'Confirm Delete', 
    'message' => 'Are you sure you want to delete this item? This action cannot be undone.', 
    'confirmText' => 'Delete', 
    'cancelText' => 'Cancel'
])

@php
    $confirmText = $confirmText ?? 'Delete';
    $cancelText = $cancelText ?? 'Cancel';
@endphp

<div id="{{ $id }}" class="delete-dialog-overlay" role="dialog" aria-modal="true" aria-labelledby="delete-dialog-title" style="display: none;">
    <div class="delete-dialog">
        <div class="delete-dialog-header">
            <h3 id="delete-dialog-title" class="delete-dialog-title">{{ $title }}</h3>
        </div>
        <div class="delete-dialog-body">
            <p class="delete-dialog-message">{{ $message }}</p>
        </div>
        <div class="delete-dialog-actions">
            <button type="button" class="btn btn-secondary delete-dialog-cancel">{{ $cancelText }}</button>
            <button type="button" class="btn btn-primary delete-dialog-confirm">{{ $confirmText }}</button>
        </div>
    </div>
</div>
