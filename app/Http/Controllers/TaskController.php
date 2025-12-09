<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TaskController extends Controller
{
    /**
     * Display a listing of all tasks.
     */
    public function index(): View
    {
        $tasks = Task::where('user_id', auth()->id())
            ->with('project')
            ->latest()
            ->get();

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new task.
     */
    public function create(): View
    {
        $projects = Project::where('user_id', auth()->id())
            ->orderBy('title')
            ->get();
        $selectedProjectId = request()->query('project_id');

        return view('tasks.create', compact('projects', 'selectedProjectId'));
    }

    /**
     * Store a newly created task in storage.
     */
    public function store(StoreTaskRequest $request): RedirectResponse
    {
        Task::create([
            ...$request->validated(),
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully!');
    }

    /**
     * Display the specified task.
     */
    public function show(Task $task): View
    {
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this task.');
        }

        $task->load('project');

        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified task.
     */
    public function edit(Task $task): View
    {
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this task.');
        }

        $projects = Project::where('user_id', auth()->id())
            ->orderBy('title')
            ->get();
        $task->load('project');

        return view('tasks.edit', compact('task', 'projects'));
    }

    /**
     * Update the specified task in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task): RedirectResponse
    {
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this task.');
        }

        $validated = $request->validated();
        
        // Set completed_at if status is being changed to completed
        if ($validated['status'] === 'completed' && $task->status !== 'completed') {
            $validated['completed_at'] = now();
        } elseif ($validated['status'] !== 'completed') {
            $validated['completed_at'] = null;
        }

        $task->update($validated);

        return redirect()->route('tasks.show', $task)->with('success', 'Task updated successfully!');
    }

    /**
     * Remove the specified task from storage.
     */
    public function destroy(Task $task): RedirectResponse
    {
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this task.');
        }

        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully!');
    }
}