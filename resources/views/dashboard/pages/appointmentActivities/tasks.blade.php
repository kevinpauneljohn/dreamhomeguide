@foreach ($appointment->tasks as $task)

    @php
        $status = $task->status;

        $statusMap = [
            'completed'   => [
                'bg'   => 'bg-success',
                'icon' => 'fa-check',
                'text' => 'completed the appointment from this task: ',
            ],
            'pending'     => [
                'bg'   => 'bg-warning',
                'icon' => 'fa-rotate-left',
                'text' => 'reopened the appointment this task: ',
            ],
            'in progress' => [
                'bg'   => 'bg-primary',
                'icon' => 'fa-spinner',
                'text' => 'started working on the appointment',
            ],
            'overdue'     => [
                'bg'   => 'bg-danger',
                'icon' => 'fa-exclamation',
                'text' => 'appointment became overdue',
            ],
        ];

        $ui = $statusMap[$status] ?? [
            'bg'   => 'bg-secondary',
            'icon' => 'fa-circle-info',
            'text' => 'updated the appointment',
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
                <strong>{{ $task->assignedAgent->full_name ?? 'System' }}</strong>
                {{ $ui['text'] }}

                {{-- Task Number Link --}}
                <a href="{{ route('task.show', $task->id) }}" title="Click to view task details."
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
