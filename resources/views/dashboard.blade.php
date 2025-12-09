@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <x-layout.page>
        <x-layout.container>
            <h1 class="main-content-title">Welcome, {{ Auth::user()->username }}!</h1>
            <p class="main-content-subtitle">This is your dashboard.</p>
        </x-layout.container>

        <x-layout.container>
            <div class="dashboard-stats">
                <div class="dashboard-stat-card">
                    <div class="dashboard-stat-value">{{ $totalProjects }}</div>
                    <div class="dashboard-stat-label">Total Projects</div>
                </div>
                <div class="dashboard-stat-card">
                    <div class="dashboard-stat-value">{{ $totalTasks }}</div>
                    <div class="dashboard-stat-label">Total Tasks</div>
                </div>
                <div class="dashboard-stat-card">
                    <div class="dashboard-stat-value">{{ $activeTasks }}</div>
                    <div class="dashboard-stat-label">Active Tasks</div>
                </div>
                <div class="dashboard-stat-card">
                    <div class="dashboard-stat-value">{{ $completedTasks }}</div>
                    <div class="dashboard-stat-label">Completed Tasks</div>
                </div>
            </div>
        </x-layout.container>

        <div class="dashboard-recent-container">
            <x-layout.container>
                <div class="dashboard-section-header">
                    <h2 class="dashboard-section-title">Recent Projects</h2>
                    <a href="{{ route('projects.create') }}" class="btn btn-primary btn-icon-only" aria-label="Add project">
                        <x-icons.add />
                    </a>
                </div>

                @if($recentProjects->isEmpty())
                    <div class="dashboard-empty">
                        <p>No projects yet. Create your first project!</p>
                    </div>
                @else
                    <div class="dashboard-list">
                        @foreach($recentProjects as $project)
                            <a href="{{ route('projects.show', $project) }}" class="dashboard-card">
                                <div class="dashboard-card-content">
                                    <div class="dashboard-card-header">
                                        <div class="dashboard-card-left">
                                            <h3 class="dashboard-card-title">{{ $project->title }}</h3>
                                        </div>
                                        <div class="dashboard-card-right">
                                            <span class="status-badge status-{{ $project->status }}">{{ ucfirst(str_replace('-', ' ', $project->status)) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </x-layout.container>

            <x-layout.container>
                <div class="dashboard-section-header">
                    <h2 class="dashboard-section-title">Recent Tasks</h2>
                    <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-icon-only" aria-label="Add task">
                        <x-icons.add />
                    </a>
                </div>

                @if($recentTasks->isEmpty())
                    <div class="dashboard-empty">
                        <p>No tasks yet. Create your first task!</p>
                    </div>
                @else
                    <div class="dashboard-list">
                        @foreach($recentTasks as $task)
                            <a href="{{ route('tasks.show', $task) }}" class="dashboard-card">
                                <div class="dashboard-card-content">
                                    <div class="dashboard-card-header">
                                        <div class="dashboard-card-left">
                                            <h3 class="dashboard-card-title">{{ $task->title }}</h3>
                                            @if($task->project)
                                                <p class="dashboard-card-description">Project: {{ $task->project->title }}</p>
                                            @endif
                                        </div>
                                        <div class="dashboard-card-right">
                                            <span class="priority-badge priority-{{ $task->priority }}">{{ ucfirst($task->priority) }}</span>
                                            <span class="status-badge status-{{ $task->status }}">{{ ucfirst(str_replace('-', ' ', $task->status)) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </x-layout.container>
        </div>
    </x-layout.page>
@endsection