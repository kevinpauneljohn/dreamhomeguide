<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct(
        public TaskService $taskService
    )
    {

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.pages.tasks.index')->with([
            'title' => 'Tasks',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $priorities = $this->taskService->priorities();

        return view('dashboard.pages.tasks.show')->with([
            'title'     => 'Task Details',
            'task'      => $task,
            'priority' => $this->taskService->resolvePriority($task->priority),
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }

    public function getTasks(Request $request): \Illuminate\Http\JsonResponse
    {
        return $this->taskService->getTasks($request->all());
    }
}
