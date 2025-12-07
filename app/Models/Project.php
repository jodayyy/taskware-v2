<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'description',
        'status',
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
            'completed_at' => 'datetime',
        ];
    }

    /**
     * Get the tasks for the project.
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Get the attachments for the project.
     */
    public function attachments(): HasMany
    {
        return $this->hasMany(ProjectAttachment::class);
    }

    /**
     * Update the project status based on its tasks.
     */
    public function updateStatusFromTasks(): void
    {
        $tasksCount = $this->tasks()->count();

        if ($tasksCount === 0) {
            $this->status = 'upcoming';
            $this->completed_at = null;
        } else {
            $completedTasksCount = $this->tasks()->where('status', 'completed')->count();

            if ($completedTasksCount === $tasksCount) {
                $this->status = 'completed';
                if (!$this->completed_at) {
                    $this->completed_at = now();
                }
            } else {
                $this->status = 'in-progress';
                $this->completed_at = null;
            }
        }

        $this->save();
    }
}
