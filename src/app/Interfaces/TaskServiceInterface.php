<?php

namespace App\Interfaces;

use App\Models\Task;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface TaskServiceInterface
{
    public function getAllTasksForUser(User $user, int $perPage = 6, array $filters = []): LengthAwarePaginator;

    public function createTaskForUser(User $user, array $data): Task;

    public function updateTask(Task $task, array $data): Task;

    public function deleteTask(Task $task): bool;

    public function completeTask(Task $task): Task;
}
