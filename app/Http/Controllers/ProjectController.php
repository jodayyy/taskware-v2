<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProjectController extends Controller
{
    /**
     * Display a listing of all projects.
     */
    public function index(): View
    {
        $projects = Project::latest()->get();

        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new project.
     */
    public function create(): View
    {
        return view('projects.create');
    }

    /**
     * Store a newly created project in storage.
     */
    public function store(StoreProjectRequest $request): RedirectResponse
    {
        Project::create([
            ...$request->validated(),
            'status' => 'upcoming',
        ]);

        return redirect()->route('projects.index')->with('success', 'Project created successfully!');
    }

    /**
     * Display the specified project.
     */
    public function show(Project $project): View
    {
        $project->load('tasks');

        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified project.
     */
    public function edit(Project $project): View
    {
        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified project in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project): RedirectResponse
    {
        $project->update($request->validated());

        return redirect()->route('projects.show', $project)->with('success', 'Project updated successfully!');
    }

    /**
     * Remove the specified project from storage.
     */
    public function destroy(Project $project): RedirectResponse
    {
        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Project deleted successfully!');
    }
}
