@foreach ($appointment->tasks as $task)

    @php
        $status = $task->status;
        $isNewTask = $task->created_at->equalTo($task->updated_at);

        $statusMap = [
            'completed' => [
                'bg'   => 'bg-success',
                'icon' => 'fa-check',
                'text' => 'completed the assigned appointment task',
            ],

            'pending' => [
                'bg'   => 'bg-warning',
                'icon' => $isNewTask ? 'fa-plus' : 'fa-rotate-left',
                'text' => $isNewTask
                    ? 'has a pending assigned appointment task'
                    : 'has a reopened assigned appointment task',
            ],

            'in progress' => [
                'bg'   => 'bg-primary',
                'icon' => 'fa-spinner',
                'text' => 'is working on the assigned appointment task',
            ],

            'overdue' => [
                'bg'   => 'bg-danger',
                'icon' => 'fa-exclamation',
                'text' => 'has an overdue assigned appointment task',
            ],
        ];

        $ui = $statusMap[$status] ?? [
            'bg'   => 'bg-secondary',
            'icon' => 'fa-circle-info',
            'text' => 'updated the assigned appointment task',
        ];

        $taskNumber = 'TSK-' . str_pad($task->id, 5, '0', STR_PAD_LEFT);
    @endphp

    <li class="d-flex gap-3 mb-3">

        {{-- ICON --}}
        <span class="activity-icon {{ $ui['bg'] }}">
            <i class="fa {{ $ui['icon'] }}"></i>
        </span>

        {{-- CONTENT --}}
        <div class="flex-grow-1">

            <div class="fw-medium">

                {{-- Assigned Agent is the ACTOR --}}
                <strong>{{ $task->assignedAgent?->full_name ?? 'System' }}</strong>

                {{ $ui['text'] }}

                {{-- Task Number --}}
                <a href="{{ route('task.show', $task->id) }}"
                   title="Click to view task details"
                   class="ms-1 text-decoration-none text-primary fw-semibold">
                    {{ $taskNumber }}
                </a>

            </div>

            <div class="small text-muted mb-1">
                {{ $task->updated_at->format('M d, Y h:i A') }}
            </div>

            {{-- Task Description --}}
            @if(!empty($task->description))
                <div class="small text-muted fst-italic">
                    “{{ $task->description }}”
                </div>
            @endif

        </div>

    </li>

@endforeach
