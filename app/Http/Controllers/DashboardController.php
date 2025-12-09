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
        $userId = auth()->id();
        
        $recentProjects = Project::where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();
        $recentTasks = Task::where('user_id', $userId)
            ->with('project')
            ->latest()
            ->take(5)
            ->get();

        $totalProjects = Project::where('user_id', $userId)->count();
        $totalTasks = Task::where('user_id', $userId)->count();
        $activeTasks = Task::where('user_id', $userId)
            ->where('status', '!=', 'completed')
            ->count();
        $completedTasks = Task::where('user_id', $userId)
            ->where('status', 'completed')
            ->count();

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