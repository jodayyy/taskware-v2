@extends('layouts.app')

@section('title', 'All Tasks')

@section('content')
<x-layout.page>
    <div class="tasks-header">
        <h1 class="main-content-title">All Tasks</h1>
        <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-icon-only">
            <x-icons.add />
        </a>
    </div>

    @if($tasks->isEmpty())
        <div class="tasks-empty">
            <p>No tasks yet. Create your first task!</p>
        </div>
    @else
        <div class="tasks-list">
            @foreach($tasks as $task)
                <a href="{{ route('tasks.show', $task) }}" class="task-card">
                    <div class="task-card-content">
                        <div class="task-card-header">
                            <div class="task-card-left">
                                <h2 class="task-title">{{ $task->title }}</h2>
                            </div>
                            <div class="task-card-right">
                                <span class="priority-badge priority-{{ $task->priority }}">{{ ucfirst($task->priority) }}</span>
                                <span class="status-badge status-{{ $task->status }}">{{ ucfirst(str_replace('-', ' ', $task->status)) }}</span>
                                @if($task->due)
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
</x-layout.page>
@endsection

