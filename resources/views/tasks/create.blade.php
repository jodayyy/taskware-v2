@extends('layouts.app')

@section('title', 'Create Task')

@section('content')
<x-layout.page>
    <x-layout.container>
        <div class="task-form-header">
            <h1 class="main-content-title">Create Task</h1>
        </div>

        <form method="POST" action="{{ route('tasks.store') }}" class="task-form">
        @csrf

        <x-ui.form-input 
            name="title" 
            label="Title" 
            :value="old('title')"
            required 
            autofocus
        />

        <x-ui.form-select 
            name="project_id" 
            label="Project"
            :options="$projects"
            :value="old('project_id', $selectedProjectId ?? null)"
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
            >{{ old('description') }}</textarea>
            @error('description')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <x-ui.priority-select 
            name="priority" 
            label="Priority"
            :value="old('priority', 'normal')"
            required
        />

        <x-ui.datetime-picker 
            name="due" 
            label="Due Date & Time"
            :value="old('due')"
        />

        <div class="task-form-actions">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
    </x-layout.container>
</x-layout.page>
@endsection