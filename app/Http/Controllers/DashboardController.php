<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index(): View
    {
        $recentProjects = Project::latest()->take(5)->get();
        $recentTasks = Task::with('project')->latest()->take(5)->get();

        $totalProjects = Project::count();
        $totalTasks = Task::count();
        $activeTasks = Task::where('status', '!=', 'completed')->count();
        $completedTasks = Task::where('status', 'completed')->count();

        return view('dashboard', compact(
            'recentProjects',
            'recentTasks',
            'totalProjects',
            'totalTasks',
            'activeTasks',
            'completedTasks'
        ));
    }
}