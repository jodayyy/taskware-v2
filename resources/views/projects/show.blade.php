@extends('layouts.app')

@section('title', $project->title)

@section('content')
<x-layout.page>
    <div class="project-details-header">
        <a href="{{ route('projects.index') }}" class="back-button" aria-label="Back to all projects">
            <x-icons.back />
        </a>
        <div class="project-details-actions">
            <a href="{{ route('projects.edit', $project) }}" class="btn btn-primary btn-icon-only" aria-label="Edit project">
                <x-icons.edit />
            </a>
            <form id="delete-project-form" method="POST" action="{{ route('projects.destroy', $project) }}" class="inline-form">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-secondary btn-icon-only" aria-label="Delete project" data-delete-dialog="deleteConfirmDialog" data-delete-form="delete-project-form">
                    <x-icons.delete />
                </button>
            </form>
        </div>
    </div>

    <div class="project-details">
        <h2 class="main-content-title">{{ $project->title }}</h2>
        
        <div class="project-detail-item">
            <label class="project-detail-label">Description:</label>
            <p class="project-detail-value">{{ $project->description ?: 'No description provided.' }}</p>
        </div>

        <div class="project-detail-item project-detail-item-inline">
            <label class="project-detail-label">Status:</label>
            <span class="status-badge status-{{ $project->status }}">{{ ucfirst(str_replace('-', ' ', $project->status)) }}</span>
        </div>

        <div class="project-detail-item project-detail-item-row">
            <div class="project-detail-date-item">
                <label class="project-detail-label">Created At:</label>
                <p class="project-detail-value">{{ $project->created_at->format('F j, Y g:i A') }}</p>
            </div>
            <div class="project-detail-date-item">
                <label class="project-detail-label">Updated At:</label>
                <p class="project-detail-value">{{ $project->updated_at->eq($project->created_at) ? '' : $project->updated_at->format('F j, Y g:i A') }}</p>
            </div>
            <div class="project-detail-date-item">
                <label class="project-detail-label">Completed At:</label>
                <p class="project-detail-value">{{ $project->completed_at ? $project->completed_at->format('F j, Y g:i A') : '' }}</p>
            </div>
        </div>
    </div>

    <x-ui.delete-confirm-dialog 
        id="deleteConfirmDialog"
        title="Delete Project"
        message="Are you sure you want to delete this project? This action cannot be undone."
        confirm-text="Delete"
        cancel-text="Cancel"
    />
</x-layout.page>
@endsection
