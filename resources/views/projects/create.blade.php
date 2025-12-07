@extends('layouts.app')

@section('title', 'Create Project')

@section('content')
<x-layout.page>
    <div class="project-form-header">
        <h1 class="main-content-title">Create Project</h1>
    </div>

    <form method="POST" action="{{ route('projects.store') }}" class="project-form">
        @csrf

        <x-ui.form-input 
            name="title" 
            label="Title" 
            :value="old('title')"
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
            >{{ old('description') }}</textarea>
            @error('description')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="project-form-actions">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('projects.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</x-layout.page>
@endsection
