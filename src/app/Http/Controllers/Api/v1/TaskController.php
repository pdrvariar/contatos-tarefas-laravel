<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Http\Requests\Api\v1\StoreTaskRequest;
use App\Http\Requests\Api\v1\UpdateTaskRequest;
use App\Http\Resources\Api\v1\TaskResource;
use App\Interfaces\TaskServiceInterface;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    use ApiResponse;

    protected $taskService;

    public function __construct(TaskServiceInterface $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'tags', 'status']);
        $tasks = $this->taskService->getAllTasksForUser(Auth::user(), 6, $filters);

        return TaskResource::collection($tasks)->additional([
            'status' => 'success',
            'message' => 'Lista de tarefas recuperada'
        ]);
    }

    public function store(StoreTaskRequest $request)
    {
        $task = $this->taskService->createTaskForUser(Auth::user(), $request->validated());

        return $this->successResponse(
            new TaskResource($task),
            'Tarefa criada com sucesso',
            201
        );
    }

    public function show(Task $task)
    {
        Gate::authorize('view', $task);

        return (new TaskResource($task->load('tags')))->additional([
            'status' => 'success',
            'message' => 'Tarefa recuperada com sucesso'
        ]);
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        Gate::authorize('update', $task);

        $this->taskService->updateTask($task, $request->validated());

        return $this->successResponse(
            new TaskResource($task->load('tags')),
            'Tarefa atualizada com sucesso'
        );
    }

    public function destroy(Task $task)
    {
        Gate::authorize('delete', $task);

        $this->taskService->deleteTask($task);

        return $this->successResponse(null, 'Tarefa excluída com sucesso', 204);
    }

    public function complete(Task $task)
    {
        Gate::authorize('update', $task);

        $this->taskService->completeTask($task);

        return $this->successResponse(
            new TaskResource($task->load('tags')),
            'Tarefa concluída com sucesso'
        );
    }
}
