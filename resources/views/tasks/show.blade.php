@extends('layouts.app')

@section('title', $task->title)

@section('content')
<x-layout.page>
    <x-layout.container>
        <div class="task-details-header">
            <a href="{{ route('tasks.index') }}" class="back-button" aria-label="Back to all tasks">
                <x-icons.back />
            </a>
            <div class="task-details-actions">
                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-primary btn-icon-only" aria-label="Edit task">
                    <x-icons.edit />
                </a>
                <form id="delete-task-form" method="POST" action="{{ route('tasks.destroy', $task) }}" class="inline-form">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary btn-icon-only" aria-label="Delete task" data-delete-dialog="deleteConfirmDialog" data-delete-form="delete-task-form">
                        <x-icons.delete />
                    </button>
                </form>
            </div>
        </div>

        <div class="task-details">
            <h2 class="main-content-title">{{ $task->title }}</h2>
            
            @if($task->project)
                <div class="task-detail-item">
                    <label class="task-detail-label">Project:</label>
                    <p class="task-detail-value">
                        <a href="{{ route('projects.show', $task->project) }}" class="task-project-link">{{ $task->project->title }}</a>
                    </p>
                </div>
            @endif

            <div class="task-detail-item">
                <label class="task-detail-label">Description:</label>
                <p class="task-detail-value">{{ $task->description ?: 'No description provided.' }}</p>
            </div>

            <div class="task-detail-item task-detail-item-row">
                <div class="task-detail-inline-item">
                    <label class="task-detail-label">Priority:</label>
                    <span class="priority-badge priority-{{ $task->priority }}">{{ ucfirst($task->priority) }}</span>
                </div>
                <div class="task-detail-inline-item">
                    <label class="task-detail-label">Status:</label>
                    <span class="status-badge status-{{ $task->status }}">{{ ucfirst(str_replace('-', ' ', $task->status)) }}</span>
                </div>
                <div class="task-detail-inline-item">
                    <label class="task-detail-label">Due:</label>
                    @if($task->isOverdue())
                        <span class="due-badge due-overdue">Overdue - {{ $task->due->format('F j, Y g:i A') }}</span>
                    @else
                        <p class="task-detail-value">{{ $task->due ? $task->due->format('F j, Y g:i A') : 'No due date' }}</p>
                    @endif
                </div>
            </div>

            <div class="task-detail-item task-detail-item-row">
                <div class="task-detail-date-item">
                    <label class="task-detail-label">Created At:</label>
                    <p class="task-detail-value">{{ $task->created_at->format('F j, Y g:i A') }}</p>
                </div>
                <div class="task-detail-date-item">
                    <label class="task-detail-label">Updated At:</label>
                    <p class="task-detail-value">{{ $task->updated_at->eq($task->created_at) ? '' : $task->updated_at->format('F j, Y g:i A') }}</p>
                </div>
                <div class="task-detail-date-item">
                    <label class="task-detail-label">Completed At:</label>
                    <p class="task-detail-value">{{ $task->completed_at ? $task->completed_at->format('F j, Y g:i A') : '' }}</p>
                </div>
            </div>
        </div>
    </x-layout.container>

    <x-ui.delete-confirm-dialog 
        id="deleteConfirmDialog"
        title="Delete Task"
        message="Are you sure you want to delete this task? This action cannot be undone."
        confirm-text="Delete"
        cancel-text="Cancel"
    />
</x-layout.page>
@endsection