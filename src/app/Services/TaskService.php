<?php

namespace App\Services;

use App\Models\Task;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class TaskService
{
    protected $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    public function getAllTasksForUser(User $user, int $perPage = 6, array $filters = []): LengthAwarePaginator
    {
        try {
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
        } catch (\Exception $e) {
            Log::error("Erro ao carregar tarefas com tags: " . $e->getMessage());
            return $user->tasks()->orderBy('created_at', 'desc')->paginate($perPage);
        }
    }

    public function createTaskForUser(User $user, array $data): Task
    {
        $task = $user->tasks()->create($data);

        if (isset($data['tags'])) {
            try {
                $this->tagService->syncTags($task, $user, explode(',', $data['tags']));
            } catch (\Exception $e) {
                Log::error("Erro ao salvar tags na tarefa: " . $e->getMessage());
            }
        }

        try {
            return $task->load('tags');
        } catch (\Exception $e) {
            return $task;
        }
    }

    public function updateTask(Task $task, array $data): Task
    {
        $oldStatus = $task->status;
        $task->update($data);

        if (isset($data['tags'])) {
            try {
                $this->tagService->syncTags($task, $task->user, explode(',', $data['tags']));
            } catch (\Exception $e) {
                Log::error("Erro ao atualizar tags na tarefa: " . $e->getMessage());
            }
        }

        if ($task->status === 'Concluída' && $oldStatus !== 'Concluída') {
            $task->completed_at = now();
            $task->save();
        } elseif ($task->status !== 'Concluída') {
            $task->completed_at = null;
            $task->save();
        }

        try {
            return $task->load('tags');
        } catch (\Exception $e) {
            return $task;
        }
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
