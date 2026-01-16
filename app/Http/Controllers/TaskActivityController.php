<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskActivity;
use App\Http\Requests\StoreTaskActivityRequest;
use App\Http\Requests\UpdateTaskActivityRequest;
use Illuminate\Support\Facades\DB;

class TaskActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreTaskActivityRequest $request)
    {
        try {
            return DB::transaction(function () use ($request) {

                $task = Task::findOrFail($request->task_id);

                $allowedStatuses = ['pending', 'in progress', 'overdue', 'completed'];

                $currentStatus = $request->task_status;

                if (!in_array($currentStatus, $allowedStatuses)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid task status provided.',
                    ], 422);
                }

                $newStatus = match ($currentStatus) {
                    'completed'               => 'pending',
                    'pending',
                    'in progress',
                    'overdue'                 => 'completed',
                };


                // Update task status
                $task->update([
                    'status' => $newStatus,
                ]);

                $request->merge(['task_status' => $newStatus]);
                // Create task activity
                $activity = TaskActivity::create($request->only('task_id', 'user_id', 'accomplishment','task_status'));

                return response()->json([
                    'success' => true,
                    'message' => 'Task activity created successfully.',
                    'data' => [
                        'task'     => $task->fresh(),
                        'activity' => $activity,
                    ],
                ], 201);
            });

        } catch (\Throwable $e) {

            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update task. Please try again.',
            ], 500);
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(TaskActivity $taskActivity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TaskActivity $taskActivity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskActivityRequest $request, TaskActivity $taskActivity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskActivity $taskActivity)
    {
        //
    }

    public function getTaskActivities(Task $task): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('dashboard.pages.taskActivities.activity')->with([
            'task' => $task,
        ]);
    }
}
