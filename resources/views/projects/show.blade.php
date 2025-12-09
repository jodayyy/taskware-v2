@extends('layouts.app')

@section('title', $project->title)

@section('content')
<x-layout.page>
    <div class="project-main-content-grid">
        <x-layout.container>
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

                @if($project->attachments->isNotEmpty())
                    <div class="project-detail-item">
                        <label class="project-detail-label">Attachments:</label>
                        <div class="attachments-list">
                            @foreach($project->attachments as $attachment)
                                <div class="attachment-item-existing">
                                    <a href="{{ route('attachments.download', $attachment) }}" target="_blank" class="attachment-link-text" @if(!$attachment->mime_type || !str_starts_with($attachment->mime_type, 'image/')) download @endif>
                                        {{ $attachment->original_name }}
                                    </a>
                                    <span class="attachment-size-text">({{ $attachment->formatted_size }})</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </x-layout.container>

        <x-layout.container>
            <div class="tasks-header">
                <h2 class="main-content-title">Tasks</h2>
                <a href="{{ route('tasks.create', ['project_id' => $project->id]) }}" class="btn btn-primary btn-icon-only" aria-label="Add task">
                    <x-icons.add />
                </a>
            </div>

            @if($project->tasks->isEmpty())
                <div class="tasks-empty">
                    <p>No tasks yet. Create your first task!</p>
                </div>
            @else
                <div class="tasks-list">
                    @foreach($project->tasks as $task)
                        <a href="{{ route('tasks.show', $task) }}" class="task-card">
                            <div class="task-card-content">
                                <div class="task-card-header">
                                    <div class="task-card-left">
                                        <h2 class="task-title">{{ $task->title }}</h2>
                                    </div>
                                    <div class="task-card-right">
                                        <span class="priority-badge priority-{{ $task->priority }}">{{ ucfirst($task->priority) }}</span>
                                        <span class="status-badge status-{{ $task->status }}">{{ ucfirst(str_replace('-', ' ', $task->status)) }}</span>
                                        @if($task->isOverdue())
                                            <span class="due-badge due-overdue">Overdue</span>
                                        @elseif($task->due)
                                            <span class="due-badge">{{ $task->due->format('M j, Y g:i A') }}</span>
                                        @else
                                            <span class="due-badge due-none">No due date</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </x-layout.container>
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
