<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Models\ProjectAttachment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
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
        $project = Project::create([
            ...$request->validated(),
            'status' => 'upcoming',
        ]);

        // Handle file uploads
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $filePath = $file->store('project-attachments', 'public');
                
                ProjectAttachment::create([
                    'project_id' => $project->id,
                    'original_name' => $file->getClientOriginalName(),
                    'file_path' => $filePath,
                    'file_size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                ]);
            }
        }

        return redirect()->route('projects.index')->with('success', 'Project created successfully!');
    }

    /**
     * Display the specified project.
     */
    public function show(Project $project): View
    {
        $project->load('tasks', 'attachments');

        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified project.
     */
    public function edit(Project $project): View
    {
        $project->load('attachments');
        
        $existingAttachments = $project->attachments->map(function ($attachment) {
            return [
                'id' => $attachment->id,
                'name' => $attachment->original_name,
                'size' => $attachment->file_size,
                'url' => route('attachments.download', $attachment),
                'isImage' => $attachment->mime_type && str_starts_with($attachment->mime_type, 'image/'),
            ];
        })->values()->all();
        
        return view('projects.edit', compact('project', 'existingAttachments'));
    }

    /**
     * Update the specified project in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project): RedirectResponse
    {
        $project->update($request->validated());

        // Handle attachment deletions
        if ($request->has('delete_attachments')) {
            $attachmentsToDelete = ProjectAttachment::whereIn('id', $request->input('delete_attachments'))
                ->where('project_id', $project->id)
                ->get();
            
            foreach ($attachmentsToDelete as $attachment) {
                // Delete the file from storage
                if (Storage::disk('public')->exists($attachment->file_path)) {
                    Storage::disk('public')->delete($attachment->file_path);
                }
                // Delete the database record
                $attachment->delete();
            }
        }

        // Handle file uploads
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $filePath = $file->store('project-attachments', 'public');
                
                ProjectAttachment::create([
                    'project_id' => $project->id,
                    'original_name' => $file->getClientOriginalName(),
                    'file_path' => $filePath,
                    'file_size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                ]);
            }
        }

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

    /**
     * Download or view a project attachment.
     */
    public function downloadAttachment(ProjectAttachment $attachment)
    {
        // Verify the file exists
        if (!Storage::disk('public')->exists($attachment->file_path)) {
            abort(404, 'File not found');
        }

        $filePath = Storage::disk('public')->path($attachment->file_path);
        
        // Check if it's an image - serve for viewing instead of downloading
        if ($attachment->mime_type && str_starts_with($attachment->mime_type, 'image/')) {
            return response()->file($filePath, [
                'Content-Type' => $attachment->mime_type,
            ]);
        }

        // For non-images, download the file
        return Storage::disk('public')->download($attachment->file_path, $attachment->original_name);
    }
}
