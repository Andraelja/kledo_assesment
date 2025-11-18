<?php

namespace App\Http\Controllers\API;

use App\Services\TaskService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTaskRequest;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function store(StoreTaskRequest $request) {
        $task = $this->taskService->createTask($request->validated(), $request->user());

        return response()->json($task, 201);
    }
}
