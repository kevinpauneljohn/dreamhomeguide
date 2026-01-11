<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Leads;
use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\User;
use App\Services\TaskService;
use Carbon\Carbon;
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
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $user = auth()->user();

        $taskCounts = Task::query()
            ->when(
                ! $user->hasAnyRole(['manager', 'super admin']),
                function ($query) use ($user) {
                    $query->where(function ($q) use ($user) {
                        $q->where('user_id', $user->id)
                            ->orWhere('assigned_to', $user->id);
                    });
                }
            )
            ->selectRaw("
        COUNT(*) as total,
        COALESCE(SUM(status = 'in progress'), 0) as in_progress,
        COALESCE(SUM(status = 'completed'), 0) as completed,
        COALESCE(SUM(status = 'pending'), 0) as pending,
        COALESCE(SUM(status = 'overdue'), 0) as overdue
    ")
            ->first();


        return view('dashboard.pages.tasks.index')->with([
            'title' => 'Tasks',
            'agents' => User::select('id','first_name','last_name','email')->get(),
            'inProgressTasks' => $taskCounts->in_progress,
            'completedTasks' => $taskCounts->completed,
            'pendingTasks' => $taskCounts->pending,
            'overdueTasks' => $taskCounts->overdue,
            'allTasks' => $taskCounts->total,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return view('dashboard.pages.tasks.create')->with([
            'title' => 'Create Task',
            'priorities' => $this->taskService->priorities(),
            'agents' => User::select('id','first_name','last_name','email')->get(),
            'appointment' => $request->get('type') == 'appointment' && $request->has('id') ? Appointment::findOrFail($request->get('id')) : null,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $request->merge([
            'is_public' => $request->has('is_public'),
            'appointment_id' => $request->linked_type == 'appointment' ? $request->linked_id : null,
            'lead_id' => $request->linked_type == 'lead' ? $request->linked_id : null,
            'user_id' => auth()->id(),
        ]);
        $task = Task::create($request->only('title','description','type','due_date','priority','user_id','lead_id','appointment_id','assigned_to','is_public'));
        return  $task->exists() ? response()->json(['success' => true, 'message' => 'Task created successfully.', 'redirect' => '/task/'.$task->id.'?success=Task created successfully.']) :
            response()->json(['success' => false, 'message' => 'An error occurred while creating the task.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $user = auth()->user();

        $canView =
            $task->user_id === $user->id ||
            $task->assigned_to === $user->id ||
            $user->hasAnyRole(['super admin', 'manager']);

        if (! $canView) {
            abort(403);
        }

        $task->load(['lead', 'appointment', 'assignedAgent', 'creator']);
        return view('dashboard.pages.tasks.show')->with([
            'title'     => 'Task Details',
            'task'      => $task,
            'priority' => $this->taskService->resolvePriority($task->priority),
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task, Request $request)
    {
        if($task->user_id !== auth()->id() && !auth()->user()->hasRole(['super admin','manager']))
        {
            abort(403);
        }
        return view('dashboard.pages.tasks.edit')->with([
            'title' => 'Edit Task',
            'task' => $task,
            'priorities' => $this->taskService->priorities(),
            'agents' => User::select('id','first_name','last_name','email')->get(),
            'appointment' => $request->get('type') == 'appointment' && $request->has('id') ? Appointment::findOrFail($request->get('id')) : null,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task): \Illuminate\Http\JsonResponse
    {
        if($task->user_id !== auth()->id() && !auth()->user()->hasRole(['super admin','manager']))
        {
            return response()->json(['success' => false, 'message' => 'You are not authorized to update this task.'],401);
        }
        $request->merge([
            'is_public' => $request->has('is_public'),
            'appointment_id' => $request->linked_type == 'appointment' ? $request->linked_id : null,
            'lead_id' => $request->linked_type == 'lead' ? $request->linked_id : null,
            'due_date' => Carbon::parse($request->due_date)->format('Y-m-d H:i:s')
        ]);

        $task->fill($request->only('title','description','type','due_date','priority','user_id','lead_id','appointment_id','assigned_to','is_public'));
        if($task->isDirty())
        {
            $task->save();
            return response()->json(['success' => true, 'message' => 'Task updated successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'No changes were made to the task.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task): \Illuminate\Http\JsonResponse
    {
        return $task->delete() ?
            response()->json(['success' => true, 'message' => 'Task deleted successfully.']) :
            response()->json(['success' => false, 'message' => 'An error occurred while deleting the task.']);
    }

    public function getTasks(Request $request): \Illuminate\Http\JsonResponse
    {
        return $this->taskService->getTasks($request->all());
    }

    public function linkType($type): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $options = [];
        if($type == 'appointment')
        {
            $options = Appointment::where('user_id',auth()->id())
                ->orWhere('assigned_agent',auth()->id())->get();
        }
        elseif($type == 'lead')
        {
            $options = auth()->user()->hasRole(['super admin','manager']) ? Leads::all() : Leads::where('user_id',auth()->id())->get();
        }
        return view('dashboard.pages.tasks.link-type.'.$type)->with([
            'title' => ucwords(strtolower($type)),
            'options' => $options
        ]);
    }
}
