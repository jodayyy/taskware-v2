@extends('layouts.app')

@section('title', 'Edit Task')

@section('content')
<x-layout.page>
    <x-layout.container>
        <div class="task-form-header">
            <h1 class="main-content-title">Edit Task</h1>
        </div>

        <form method="POST" action="{{ route('tasks.update', $task) }}" class="task-form">
        @csrf
        @method('PUT')

        <x-ui.form-input 
            name="title" 
            label="Title" 
            :value="old('title', $task->title)"
            required 
            autofocus
        />

        <x-ui.form-select 
            name="project_id" 
            label="Project (Optional)"
            :options="$projects"
            :value="old('project_id', $task->project_id)"
            placeholder="No Project"
            option-value="id"
            option-label="title"
        />

        <div class="form-group mt-2">
            <label for="description" class="form-label">Description</label>
            <textarea 
                id="description"
                name="description" 
                class="form-input @error('description') form-input-error @enderror"
                rows="5"
            >{{ old('description', $task->description) }}</textarea>
            @error('description')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <x-ui.form-select 
            name="status" 
            label="Status"
            :options="[
                'to-do' => 'To-do',
                'in-progress' => 'In-progress',
                'completed' => 'Completed',
            ]"
            :value="old('status', $task->status)"
            required
        />

        <x-ui.priority-select 
            name="priority" 
            label="Priority"
            :value="old('priority', $task->priority)"
            required
        />

        <x-ui.datetime-picker 
            name="due" 
            label="Due Date & Time"
            :value="old('due', $task->due)"
        />

        <div class="task-form-actions">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('tasks.show', $task) }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
    </x-layout.container>
</x-layout.page>
@endsection