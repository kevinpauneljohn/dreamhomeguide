@if($appointment->appointmentActivities()->count() > 0)
    @foreach ($appointment->appointmentActivities as $activity)

        @php
            $isCompleted = $activity->status === 'completed';
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
                        completed the appointment
                    @else
                        reopened the appointment / set status to pending
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

@else
    <li class="d-flex align-items-start gap-3 p-3 bg-light rounded-3">
        {{-- ICON --}}
        <div class="flex-shrink-0">
            <div class="rounded-circle bg-white border d-flex align-items-center justify-content-center"
                 style="width: 42px; height: 42px;">
                <i class="fa fa-clock text-muted"></i>
            </div>
        </div>

        {{-- CONTENT --}}
        <div>
            <div class="fw-medium text-muted">
                No activity yet
            </div>

            <div class="small text-muted">
                Status changes, notes, and updates for this appointment will appear here.
            </div>
        </div>
    </li>
@endif


