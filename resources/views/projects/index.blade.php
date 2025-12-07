@extends('layouts.app')

@section('title', 'All Projects')

@section('content')
<x-layout.page>
    <div class="projects-header">
        <h1 class="main-content-title">All Projects</h1>
        <a href="{{ route('projects.create') }}" class="btn btn-primary">
            <x-icons.add />
        </a>
    </div>

    @if($projects->isEmpty())
        <div class="projects-empty">
            <p>No projects yet. Create your first project!</p>
        </div>
    @else
        <div class="projects-list">
            @foreach($projects as $project)
                <a href="{{ route('projects.show', $project) }}" class="project-card">
                    <div class="project-card-content">
                        <div class="project-card-header">
                            <div class="project-card-left">
                                <h2 class="project-title">{{ $project->title }}</h2>
                                @if($project->description)
                                    <p class="project-description">{{ Str::limit($project->description, 150) }}</p>
                                @endif
                            </div>
                            <div class="project-status">
                                <span class="status-badge status-{{ $project->status }}">{{ ucfirst(str_replace('-', ' ', $project->status)) }}</span>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</x-layout.page>
@endsection
