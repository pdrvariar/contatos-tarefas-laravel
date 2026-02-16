<?php

namespace App\Services;

use App\Interfaces\TaskServiceInterface;
use App\Models\Task;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TaskService implements TaskServiceInterface
{
    protected $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    public function getAllTasksForUser(User $user, int $perPage = 6, array $filters = []): LengthAwarePaginator
    {
        $query = $user->tasks()->with('tags');

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['tags'])) {
            $tags = explode(',', $filters['tags']);
            $query->whereHas('tags', function ($q) use ($tags) {
                $q->whereIn('name', $tags);
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function createTaskForUser(User $user, array $data): Task
    {
        return DB::transaction(function () use ($user, $data) {
            $task = $user->tasks()->create($data);

            if (isset($data['tags'])) {
                $this->tagService->syncTags($task, $user, explode(',', $data['tags']));
            }

            return $task->load('tags');
        });
    }

    public function updateTask(Task $task, array $data): Task
    {
        return DB::transaction(function () use ($task, $data) {
            $oldStatus = $task->status;
            $task->update($data);

            if (isset($data['tags'])) {
                $this->tagService->syncTags($task, $task->user, explode(',', $data['tags']));
            }

            if ($task->status === 'Concluída' && $oldStatus !== 'Concluída') {
                $task->completed_at = now();
                $task->save();
            } elseif ($task->status !== 'Concluída') {
                $task->completed_at = null;
                $task->save();
            }

            return $task->load('tags');
        });
    }

    public function deleteTask(Task $task): bool
    {
        return $task->delete();
    }

    public function completeTask(Task $task): Task
    {
        $task->update([
            'status' => 'Concluída',
            'completed_at' => now()
        ]);

        return $task;
    }
}
