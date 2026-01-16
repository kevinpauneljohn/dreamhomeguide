@foreach ($task->taskActivities as $activity)

    @php
        $isCompleted = $activity->task_status === 'completed';
    @endphp

    <li class="d-flex gap-2 mb-3">

        {{-- ICON --}}
        <span class="activity-icon {{ $isCompleted ? 'bg-success' : 'bg-warning' }}">
            <i class="fa {{ $isCompleted ? 'fa-check' : 'fa-rotate-left' }}"></i>
        </span>

        {{-- CONTENT --}}
        <div>
            <div class="fw-medium">
                <strong>{{ $activity->user?->full_name ?? 'System' }}</strong>

                @if($isCompleted)
                    completed the task
                @else
                    reopened the task / set status to pending
                @endif
            </div>

            <div class="small text-muted mb-1">
                {{ $activity->created_at->format('M d, Y h:i A') }}
            </div>

            @if(!empty($activity->accomplishment))
                <div class="small text-muted fst-italic">
                    “{{ $activity->accomplishment }}”
                </div>
            @endif
        </div>

    </li>

@endforeach
