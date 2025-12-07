<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'project_id',
        'description',
        'status',
        'priority',
        'due',
        'completed_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'due' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    /**
     * Get the project that owns the task.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::created(function (Task $task) {
            if ($task->project_id) {
                $task->project->touch();
                $task->project->updateStatusFromTasks();
            }
        });

        static::updated(function (Task $task) {
            // Handle project_id changes - update both old and new projects
            $originalProjectId = $task->getOriginal('project_id');
            $newProjectId = $task->project_id;

            if ($originalProjectId !== $newProjectId) {
                // Update old project if it changed
                if ($originalProjectId) {
                    $oldProject = Project::find($originalProjectId);
                    if ($oldProject) {
                        $oldProject->touch();
                        $oldProject->updateStatusFromTasks();
                    }
                }
                // Update new project
                if ($newProjectId) {
                    $task->project->touch();
                    $task->project->updateStatusFromTasks();
                }
            } elseif ($task->project_id) {
                // Same project, just touch and update status
                $task->project->touch();
                $task->project->updateStatusFromTasks();
            }
        });

        static::deleting(function (Task $task) {
            // Store project_id before deletion
            $task->project_id_before_delete = $task->project_id;
        });

        static::deleted(function (Task $task) {
            if (isset($task->project_id_before_delete) && $task->project_id_before_delete) {
                $project = Project::find($task->project_id_before_delete);
                if ($project) {
                    $project->touch();
                    $project->updateStatusFromTasks();
                }
            }
        });
    }
}

