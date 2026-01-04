<?php

namespace App\Services;

use App\Models\Task;
use Yajra\DataTables\Facades\DataTables;

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

    public function findPriority(string $priority): array
    {
        foreach ($this->priorities() as $key => $item) {
            if (strcasecmp($key, $priority) === 0) {
                return $item;
            }
        }

        return [];
    }
    public function getQuery(array $request)
    {
        $query = Task::query();

        // Search
        if (!empty($request['search'])) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', "%{$request['search']}%");
            });
        }

        // Filter by permission
        if (!empty($request['permission'])) {
            $query->whereHas('permissions', function ($q) use ($request) {
                $q->where('name', $request['permission']);
            });
        }

        // Sorting
        if (!empty($request['sort'])) {
            switch ($request['sort']) {
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;

                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;

                case 'newest':
                    $query->orderBy('created_at', 'asc');
                    break;

                case 'oldest':
                    $query->orderBy('created_at', 'desc');
                    break;

            }
        }

        return $query;
    }
    public function getTasks($request)
    {
        $query = $this->getQuery($request);
        return DataTables::of($query)
            ->make(true);
    }


}
