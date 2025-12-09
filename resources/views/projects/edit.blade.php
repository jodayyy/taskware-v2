@extends('layouts.app')

@section('title', 'Edit Project')

@section('content')
<x-layout.page>
    <x-layout.container>
        <div class="project-form-header">
            <h1 class="main-content-title">Edit Project</h1>
        </div>

        <form method="POST" action="{{ route('projects.update', $project) }}" class="project-form" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <x-ui.form-input 
            name="title" 
            label="Title" 
            :value="old('title', $project->title)"
            required 
            autofocus
        />

        <div class="form-group mt-2">
            <label for="description" class="form-label">Description</label>
            <textarea 
                id="description"
                name="description" 
                class="form-input @error('description') form-input-error @enderror"
                rows="5"
            >{{ old('description', $project->description) }}</textarea>
            @error('description')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group mt-2">
            <label for="attachments" class="form-label">Attachments</label>
            <div class="file-input-wrapper">
                <input 
                    type="file" 
                    id="attachments" 
                    name="attachments[]" 
                    class="file-input-hidden @error('attachments') form-input-error @enderror"
                    multiple
                    accept="*/*"
                >
                <button type="button" class="btn-choose-file" onclick="document.getElementById('attachments').click()">Choose file</button>
            </div>
            @error('attachments')
                <span class="form-error">{{ $message }}</span>
            @enderror
            @error('attachments.*')
                <span class="form-error">{{ $message }}</span>
            @enderror
            
            <div id="attachments-preview" class="attachments-preview mt-4"></div>
            <div id="delete-attachments-container"></div>
        </div>

        <div class="project-form-actions">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('projects.show', $project) }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
    </x-layout.container>
</x-layout.page>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('attachments');
    const previewContainer = document.getElementById('attachments-preview');
    const deleteContainer = document.getElementById('delete-attachments-container');
    const selectedFiles = [];
    const existingAttachments = @json($existingAttachments);
    const attachmentsToDelete = new Set();

    // Load existing attachments
    existingAttachments.forEach(att => {
        addExistingAttachmentPreview(att);
    });

    fileInput.addEventListener('change', function(e) {
        const files = Array.from(e.target.files);
        
        files.forEach(file => {
            if (!selectedFiles.find(f => f.name === file.name && f.size === file.size)) {
                selectedFiles.push(file);
                addFilePreview(file);
            }
        });
        
        // Update the file input to include all selected files
        updateFileInput();
    });

    function addExistingAttachmentPreview(attachment) {
        const fileItem = document.createElement('div');
        fileItem.className = 'attachment-item';
        fileItem.dataset.attachmentId = attachment.id;
        fileItem.dataset.isExisting = 'true';
        
        const fileSize = formatFileSize(attachment.size);
        
        const downloadAttr = attachment.isImage ? '' : 'download';
        fileItem.innerHTML = `
            <div class="attachment-item-content">
                <a href="${escapeHtml(attachment.url)}" target="_blank" class="attachment-name" ${downloadAttr}>
                    ${escapeHtml(attachment.name)}
                </a>
                <span class="attachment-size">(${fileSize})</span>
            </div>
            <button type="button" class="attachment-remove" aria-label="Remove ${escapeHtml(attachment.name)}" data-attachment-id="${attachment.id}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        `;
        
        previewContainer.appendChild(fileItem);
        
        // Add remove functionality
        const removeBtn = fileItem.querySelector('.attachment-remove');
        removeBtn.addEventListener('click', function() {
            const attachmentId = this.dataset.attachmentId;
            if (attachmentId) {
                // Mark for deletion
                attachmentsToDelete.add(attachmentId);
                addDeleteInput(attachmentId);
            }
            fileItem.remove();
        });
    }

    function addFilePreview(file) {
        const fileItem = document.createElement('div');
        fileItem.className = 'attachment-item';
        fileItem.dataset.fileName = file.name;
        fileItem.dataset.fileSize = file.size;
        fileItem.dataset.isExisting = 'false';
        
        const fileSize = formatFileSize(file.size);
        
        fileItem.innerHTML = `
            <div class="attachment-item-content">
                <span class="attachment-name">${escapeHtml(file.name)}</span>
                <span class="attachment-size">(${fileSize})</span>
            </div>
            <button type="button" class="attachment-remove" aria-label="Remove ${escapeHtml(file.name)}" data-file-name="${file.name}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        `;
        
        previewContainer.appendChild(fileItem);
        
        // Add remove functionality
        const removeBtn = fileItem.querySelector('.attachment-remove');
        removeBtn.addEventListener('click', function() {
            const fileName = this.dataset.fileName;
            selectedFiles.splice(selectedFiles.findIndex(f => f.name === fileName), 1);
            fileItem.remove();
            updateFileInput();
        });
    }

    function addDeleteInput(attachmentId) {
        // Check if input already exists
        if (document.querySelector(`input[name="delete_attachments[]"][value="${attachmentId}"]`)) {
            return;
        }
        
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'delete_attachments[]';
        input.value = attachmentId;
        deleteContainer.appendChild(input);
    }

    function updateFileInput() {
        const dataTransfer = new DataTransfer();
        selectedFiles.forEach(file => {
            dataTransfer.items.add(file);
        });
        fileInput.files = dataTransfer.files;
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
});
</script>
@endsection
