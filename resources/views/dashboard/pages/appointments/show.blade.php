@extends('dashboard.layouts.app')

@section('title', 'Appointment Details')

@section('content')
    <div class="container-fluid py-4">

        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb small mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('crm.index') }}" class="text-decoration-none">Leads</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('leads.show',['lead' => $appointment->lead_id]) }}" class="text-decoration-none">
                        {{ $appointment->lead->full_name ?? 'Client' }}
                    </a>
                </li>
                <li class="breadcrumb-item active">Appointment</li>
            </ol>
        </nav>

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-start align-items-md-center gap-3 mb-4">
            <div>
                <h2 class="fw-bold mb-1">Appointment Details</h2>
                <div class="text-muted small">Review the details of this appointment and its activity history.</div>
            </div>

            <div class="d-flex gap-2">
                <a onclick="window.history.back()" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
                <a href="{{ route('leads.show', $appointment->lead_id) }}" class="btn btn-primary">
                    View Lead
                </a>
            </div>
        </div>

        {{-- Grid: Main + Sidebar --}}
        <div class="row g-4">

            {{-- MAIN (Left) --}}
            <div class="col-lg-8">

                {{-- Identity Card (Task-style header card) --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start gap-3">
                            <div class="min-w-0">
                                <h3 class="fw-bold mb-2 text-truncate">{{ $appointment->title }}</h3>

                                <div class="d-flex flex-wrap gap-2 align-items-center small text-muted">
                                    <span class="d-inline-flex align-items-center gap-1">
                                        <i class="bi bi-hash"></i>
                                        APT-{{ str_pad($appointment->id, 5, '0', STR_PAD_LEFT) }}
                                    </span>

                                    <span class="text-muted">•</span>

                                    <span class="d-inline-flex align-items-center gap-1 text-capitalize">
                                        <i class="bi bi-tag"></i>
                                        {{ $appointment->appointment_type }}
                                    </span>

                                    <span class="text-muted">•</span>

                                    <span class="d-inline-flex align-items-center gap-1">
                                        <i class="bi bi-calendar-event"></i>
                                        {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y | h:i A') }}
                                    </span>
                                </div>
                            </div>

                            {{-- Status Badge (JS will fill + set bg class) --}}
                            <div class="text-end">
                                <span
                                    class="badge rounded-pill px-3 py-2"
                                    id="appointment-status"
                                    data-appointment-id="{{ $appointment->id }}"
                                ></span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Agenda / Purpose --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="text-uppercase small fw-semibold text-muted mb-2">Agenda / Purpose</div>

                        @php
                            $agenda = trim((string) ($appointment->notes ?? ''));
                        @endphp

                        @if($agenda !== '')
                            <div class="text-body">{!! nl2br(e($agenda)) !!}</div>
                        @else
                            <div class="text-muted fst-italic">No agenda or purpose was provided for this appointment.</div>
                        @endif
                    </div>
                </div>

                {{-- Linked Records --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="text-uppercase small fw-semibold text-muted mb-3">Linked Records</div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="p-3 border rounded-3 h-100">
                                    <div class="small text-muted mb-1">Lead</div>
                                    @if($appointment->lead_id)
                                        <a class="fw-semibold text-decoration-none"
                                           href="{{ route('leads.show', $appointment->lead_id) }}">
                                            {{ ucwords(strtolower($appointment->lead->full_name ?? 'Client')) }}
                                        </a>
                                    @else
                                        <div class="text-muted">—</div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="p-3 border rounded-3 h-100">
                                    <div class="small text-muted mb-1">Task</div>
                                    <div class="text-muted">—</div>
                                    {{-- Future-proof: link related task if you add relationship --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Activity Timeline --}}
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">

                        <h6 class="fw-semibold mb-3 text-uppercase text-muted">
                            Activity
                        </h6>

                        <ul class="list-unstyled activity-lite mb-0" id="appointment-activity-list">



                        </ul>

                    </div>
                </div>

                {{-- Related Tasks --}}
                <div class="card shadow-sm border-0">
                    <div class="card-body">

                        <h6 class="fw-semibold mb-3 text-uppercase text-muted">
                            Related Tasks
                        </h6>

                        <ul class="list-unstyled activity-lite mb-0" id="related-tasks-list">



                        </ul>

                    </div>
                </div>

            </div>

            {{-- SIDEBAR (Right) --}}
            <div class="col-lg-4">

                {{-- Timeline --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="text-uppercase small fw-semibold text-muted mb-3">Timeline</div>

                        <div class="mb-3">
                            <div class="small text-muted mb-1">Appointment Date</div>
                            <div class="fw-semibold" id="appointment-date-display">
{{--                                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y h:i A') }}--}}
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="small text-muted mb-1">Type</div>
                            <div class="fw-semibold text-capitalize">{{ $appointment->appointment_type }}</div>
                        </div>

                        <div>
                            <div class="small text-muted mb-1">Status</div>
                            <span
                                class="badge rounded-pill px-3 py-2"
                                id="appointment-status-sidebar"
                                data-appointment-id="{{ $appointment->id }}"
                            ></span>
                        </div>
                    </div>
                </div>

                {{-- Assignment --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="text-uppercase small fw-semibold text-muted mb-3">Assignment</div>

                        <div class="d-flex align-items-center gap-3 mb-3">
                            @php
                                $agentName = $appointment->agent->full_name ?? 'Unassigned';
                                $agentInitials = collect(explode(' ', trim($agentName)))
                                    ->filter()
                                    ->map(fn($p) => strtoupper(mb_substr($p, 0, 1)))
                                    ->take(2)
                                    ->implode('');
                            @endphp

                            <div class="rounded-circle bg-light border d-flex align-items-center justify-content-center fw-bold"
                                 style="width: 44px; height: 44px;">
                                {{ $agentInitials ?: '—' }}
                            </div>

                            <div class="min-w-0">
                                <div class="fw-semibold text-truncate">
                                    {{ ucwords(strtolower($agentName)) }}
                                </div>
                                <div class="small text-muted">Assigned Agent</div>
                            </div>
                        </div>

                        <div class="border-top pt-3">
                            <div class="small text-muted mb-1">Created By</div>
                            <div class="fw-semibold">
                                {{ ucwords(strtolower($appointment->user->full_name ?? '—')) }}
                            </div>
                        </div>

                        <div class="border-top pt-3 mt-3">
                            <div class="small text-muted mb-1">Lead</div>
                            <div class="fw-semibold">
                                {{ ucwords(strtolower($appointment->lead->full_name ?? '—')) }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Controls --}}
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="text-uppercase small fw-semibold text-muted mb-3">Appointment Controls</div>

                        <div class="d-grid gap-2">
                            {{-- Your modal/button component (Complete Status) --}}
                            <x-appointment.complete-status appointmentId="{{ $appointment->id }}"/>

                            <button type="button" class="btn btn-outline-dark" id="re-schedule-btn">
                                <i class="bi bi-calendar"></i> Re-schedule
                            </button>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    @push('modal')
        <div id="re-schedule-modal" class="modal fade" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog ">
                <form id="re-schedule-form">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Re-schedule Appointment</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <label class="fw-semibold">Date</label>
                            <input type="datetime-local" name="appointment_date" class="form-control" >
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary w-100" id="save-reschedule-appointment-btn">Save changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endpush
@endsection
@push('css')
    @vite('resources/css/task/show.css')
@endpush
@push('scripts')
    @vite('resources/js/dashboard/appointments/show.js')
@endpush
