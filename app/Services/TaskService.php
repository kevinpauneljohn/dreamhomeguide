<?php

namespace App\Services;

use App\Models\Task;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class TaskService
{
    public function priorities(): array
    {
        return [
            'high' => [
                'label' => 'High',
                'description' => 'Urgent tasks that directly impact active clients, appointments, or deadlines and require immediate action.',
                'badge' => 'danger',
                'sla_hours' => 24,
            ],

            'medium' => [
                'label' => 'Medium',
                'description' => 'Important tasks that support ongoing deals and should be completed within 1–2 days.',
                'badge' => 'warning',
                'sla_hours' => 48,
            ],

            'low' => [
                'label' => 'Low',
                'description' => 'Non-urgent tasks related to planning, documentation, or long-term follow-ups.',
                'badge' => 'success',
                'sla_hours' => 168, // 7 days
            ],
        ];
    }

    public function resolvePriority(string $priority): array
    {
        return $this->priorities()[$priority] ?? [
            'label' => 'Unknown',
            'badge' => 'secondary',
            'description' => 'Undefined priority',
            'sla_hours' => null,
        ];
    }


    public function findPriority(string $priority): array
    {
        foreach ($this->priorities() as $key => $item) {
            if (strcasecmp($key, $priority) === 0) {
                return $item;
            }
        }

        return [];
    }

    public function getQuery(array $request): \Illuminate\Database\Eloquent\Builder
    {
        $user = auth()->user();

        //only tasks assigned to the user will be displayed or if the user is the super admin or manager all tasks will be displayed
        $query = Task::query()
            ->when(
                ! $user->hasAnyRole(['manager', 'super admin']),
                function ($q) use ($user) {
                    $q->where(function ($sub) use ($user) {
                        $sub->where('user_id', $user->id)
                            ->orWhere('assigned_to', $user->id);
                    });
                }
            );

        /* -----------------------------------------
         | SEARCH (Task #, Title, Description)
         ----------------------------------------- */
        $search = $request['search']['value']
            ?? $request['search']
            ?? null;

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");

                // Allow searching by task number (TSK-00012)
                if (preg_match('/\d+/', $search, $m)) {
                    $q->orWhere('id', (int) $m[0]);
                }
            });
        }

        /* -----------------------------------------
         | Assigned To FILTER
         ----------------------------------------- */
        if (!empty($request['assigned_to'])) {
            $query->where('assigned_to', $request['assigned_to']);
        }

        /* -----------------------------------------
         | STATUS FILTER
         ----------------------------------------- */
        if (!empty($request['status'])) {
            $query->where('status', $request['status']);
        }

        /* -----------------------------------------
         | PRIORITY FILTER
         ----------------------------------------- */
        if (!empty($request['priority'])) {
            $query->where('priority', $request['priority']);
        }

        /* -----------------------------------------
         | DUE DATE FILTER
         ----------------------------------------- */
        if (!empty($request['due_date'])) {
            $query->whereDate(
                'due_date',
                Carbon::parse($request['due_date'])->toDateString()
            );
        }

        /* -----------------------------------------
         | ORDERING (PRIORITY-BASED)
         | 1) User-selected due date sorting
         | 2) Default: latest created tasks
         ----------------------------------------- */
        if (!empty($request['order_due']) && in_array($request['order_due'], ['asc', 'desc'])) {

            $query->orderBy('due_date', $request['order_due']);

        } else {

            $query->orderByDesc('created_at');
        }

        return $query;
    }





    public function getTasks($request): \Illuminate\Http\JsonResponse
    {
        $query = $this->getQuery($request);
        return DataTables::of($query)
            ->editColumn('assigned_to',content:  function ($task) {
                return $task->assigned_to ? [
                    'name' => $task->assignedAgent->full_name,
                    'role' => $task->assignedAgent->getRoleNames()->first(),
                ] : null;
            })
            ->addColumn('action', content: function ($task) {
                return [
                    'view' => (bool)auth()->user()->can('view task'),
                    'edit' => auth()->user()->can('edit task') && $task->status !== 'completed',
                    'delete' => auth()->user()->can('delete task') && $task->status !== 'completed',
                    'id' => $task->id,
                    'title' => ucwords(strtolower($task->title)),
                    'ticket_number' => sprintf('TSK-%05d', $task->id),
                ];
            })
            ->make(true);
    }

    public function taskCountDegrees($taskCount, $totalTasks): float|int
    {
        return ($taskCount / $totalTasks) * 360;
    }


}
