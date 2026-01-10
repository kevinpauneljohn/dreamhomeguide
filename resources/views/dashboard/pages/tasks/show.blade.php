@extends('dashboard.layouts.app')

@section('title', 'Task Details')

@section('content')
    <div class="container-fluid py-4">

        {{-- =========================
            BREADCRUMB
        ========================== --}}
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('task.index') }}">Tasks</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Task #TSK-{{ str_pad($task->id, 5, '0', STR_PAD_LEFT) }}
                </li>
            </ol>
        </nav>

        @if(request()->has('success'))
            <div class="alert alert-success " role="alert" id="success-alert">
                Task marked as completed successfully!
            </div>
        @endif

        @php
            $statusMap = [
                'pending'     => ['label' => 'Pending', 'badge' => 'secondary'],
                'in progress' => ['label' => 'In Progress', 'badge' => 'info'],
                'completed'   => ['label' => 'Completed', 'badge' => 'success'],
                'overdue'     => ['label' => 'Overdue', 'badge' => 'warning'],
            ];

            $status = $statusMap[$task->status] ?? [
                'label' => ucfirst($task->status),
                'badge' => 'secondary',
            ];
        @endphp

        {{-- =========================
            HEADER CARD
        ========================== --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h3 class="fw-bold mb-2">
                            {{ $task->title }}
                        </h3>

                        <div class="d-flex flex-wrap gap-2 align-items-center">
                        <span class="badge bg-{{ $priority['badge'] }}">
                            {{ $priority['label'] }} Priority
                        </span>

                            <span class="badge bg-{{ $status['badge'] }}">
                            {{ $status['label'] }}
                        </span>

                            <span class="text-muted small">
                            <i class="fa fa-hashtag me-1"></i>
                            TSK-{{ str_pad($task->id, 5, '0', STR_PAD_LEFT) }}
                        </span>
                        </div>
                    </div>

                    {{-- QUICK ACTIONS --}}
                    <div class="d-flex gap-2">
                        @can('edit task')
                            <a href="{{ route('task.edit', $task) }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fa fa-pen"></i>
                            </a>
                        @endcan

                        @can('delete task')
                            <button class="btn btn-outline-danger btn-sm">
                                <i class="fa fa-trash"></i>
                            </button>
                        @endcan
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">

            {{-- =========================
                LEFT COLUMN
            ========================== --}}
            <div class="col-lg-8">

                {{-- DESCRIPTION --}}
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h6 class="fw-semibold mb-3 text-uppercase text-muted">
                            Description
                        </h6>
                        <p class="mb-0">
                            {{ $task->description ?: 'No description provided.' }}
                        </p>
                    </div>
                </div>

                {{-- LINKED RECORDS --}}
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h6 class="fw-semibold mb-3 text-uppercase text-muted">
                            Linked Records
                        </h6>

                        <div class="row">
                            <div class="col-md-6">
                                <small class="text-muted">Lead</small>
                                <div class="fw-semibold">
                                    @if($task->lead)
                                        <a href="{{ route('leads.show', $task->lead) }}">
                                            {{ $task->lead->full_name ?? 'View Lead' }}
                                        </a>
                                    @else
                                        —
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <small class="text-muted">Appointment</small>
                                <div class="fw-semibold">
                                    @if($task->appointment)
                                        <a href="{{ route('appointment.show', ['appointment' => $task->appointment]) }}">
                                            {{ $task->appointment->title ?? 'View Lead' }}
                                        </a>
                                    @else
                                        —
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ACTIVITY --}}
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="fw-semibold mb-3 text-uppercase text-muted">
                            Activity
                        </h6>

                        <ul class="list-unstyled small mb-0">
                            <li class="mb-2">
                                <strong>{{ $task->creator?->full_name ?? 'System' }}</strong>
                                created this task
                                <span class="text-muted">
                                {{ $task->created_at->format('M d, Y h:i A') }}
                            </span>
                            </li>

                            @if($task->status === 'completed')
                                <li>
                                    Task completed
                                    <span class="text-muted">
                                    {{ $task->updated_at->format('M d, Y h:i A') }}
                                </span>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>

            </div>

            {{-- =========================
                RIGHT COLUMN
            ========================== --}}
            <div class="col-lg-4">

                {{-- ASSIGNMENT --}}
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h6 class="fw-semibold mb-3 text-uppercase text-muted">
                            Assignment
                        </h6>

                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar">
                                {{ strtoupper(substr($task->assignedAgent?->full_name ?? 'NA', 0, 2)) }}
                            </div>
                            <div>
                                <div class="fw-semibold">
                                    {{ !is_null($task->assignedAgent) ? ucwords(strtolower($task->assignedAgent->full_name)) : 'NA' }}
                                </div>
                                <small class="text-muted">
                                    {{ $task->assignedAgent?->getRoleNames()->first() ?? '—' }}
                                </small>
                            </div>
                        </div>

                        <hr>

                        <small class="text-muted">Created By</small>
                        <div class="fw-semibold">
                            {{ !is_null($task->creator) ? ucwords(strtolower($task->creator->full_name)) : 'System' }}
                        </div>
                    </div>
                </div>

                {{-- TIMELINE --}}
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h6 class="fw-semibold mb-3 text-uppercase text-muted">
                            Timeline
                        </h6>

                        <div class="mb-2">
                            <small class="text-muted">Due Date</small>
                            <div class="fw-semibold">
                                {{ optional($task->due_date)->format('M d, Y h:i A') ?? '—' }}
                            </div>
                        </div>

                        <div>
                            <small class="text-muted">Status</small><br>
                            <span class="badge bg-{{ $status['badge'] }}">
                            {{ $status['label'] }}
                        </span>
                        </div>
                    </div>
                </div>

                {{-- TASK CONTROLS --}}
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="fw-semibold mb-3 text-uppercase text-muted">
                            Task Controls
                        </h6>

                        <div class="d-grid gap-2">
                            @if($task->status !== 'completed')
                                <button class="btn btn-success">
                                    ✓ Mark as Completed
                                </button>
                            @endif

                            @can('edit task')
                                <button class="btn btn-outline-secondary">
                                    Reassign Task
                                </button>
                            @endcan
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection
@push('css')
    <style>
        .avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.75rem;
        }


    </style>
@endpush

@push('scripts')
    @vite('resources/js/dashboard/tasks/show.js')
@endpush
