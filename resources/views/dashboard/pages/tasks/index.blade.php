@extends('dashboard.layouts.app')
@section('title', $title)
@section('content')
    <div class="container-fluid task-dashboard py-4">

        <!-- TOP BAR -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <small class="text-muted">Manage and track your sales activities</small>
                <h3 class="fw-bold mb-0">Task Dashboard</h3>
            </div>

{{--            <div class="d-flex gap-2 align-items-center">--}}
{{--                <button class="btn btn-outline-secondary btn-sm">Today</button>--}}
{{--                <button class="btn btn-outline-secondary btn-sm">This Week</button>--}}
{{--                <button class="btn btn-dark btn-sm">This Month</button>--}}
{{--                <button class="btn btn-outline-secondary btn-sm">Reports</button>--}}

{{--            </div>--}}
        </div>

        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="row">
                    <!-- OVERVIEW -->
                    <div class="col-lg-6 mb-3">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-3">
                                    <h6 class="fw-semibold">Task Overview</h6>
{{--                                    <i class="fa fa-arrow-up-right-from-square text-muted"></i>--}}
                                </div>

                                <!-- Donut Chart -->
                                <div class="d-flex justify-content-center my-4">
                                    <div class="chart-placeholder rounded-circle position-relative" data-total="{{$allTasks}}" data-completed="{{$completedTasks}}">
                                        <div class="chart-center text-center">
                                            <small class="text-muted">Completed</small>
                                            <h5 class="fw-bold mb-0" id="taskPercent">0%</h5>
                                            <small class="text-muted">of Tasks</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Stats -->
                                <div class="d-flex justify-content-around text-center">
                                    <div>
                                        <span class="dot bg-warning"></span>
                                        <small class="d-block text-muted">In Progress</small>
                                        <h6 class="fw-bold mb-0">{{$inProgressTasks}}</h6>
                                    </div>
                                    <div>
                                        <span class="dot bg-success"></span>
                                        <small class="d-block text-muted">Completed</small>
                                        <h6 class="fw-bold mb-0">{{$completedTasks}}</h6>
                                    </div>
                                    <div>
                                        <span class="dot bg-secondary"></span>
                                        <small class="d-block text-muted">Not Started</small>
                                        <h6 class="fw-bold mb-0">{{$pendingTasks}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- TASK ATTENTION & RISK -->
                    <div class="col-lg-6 mb-3">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-3">
                                    <h6 class="fw-semibold">Task Attention & Risk</h6>
                                    <i class="fa fa-triangle-exclamation text-muted"></i>
                                </div>

                                <!-- TOP ALERT METRICS -->
                                <div class="row g-3 mb-3">
                                    <div class="col-6">
                                        <div class="p-3 rounded bg-danger-subtle">
                                            <small class="text-muted d-block">Overdue Tasks</small>
                                            <h4 class="fw-bold text-danger mb-0">
                                                {{ $overdueTasks }}
                                            </h4>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="p-3 rounded bg-warning-subtle">
                                            <small class="text-muted d-block">Due Today</small>
                                            <h4 class="fw-bold text-warning mb-0">
                                                {{ $dueTodayTasks }}
                                            </h4>
                                        </div>
                                    </div>
                                </div>

                                <!-- SECONDARY METRICS -->
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small class="text-muted">High Priority Tasks</small>
                                    <strong class="text-danger">{{ $highPriorityTasks }}</strong>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small class="text-muted">Due This Week</small>
                                    <strong>{{ $dueThisWeekTasks }}</strong>
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">Completion Rate</small>
                                    <strong class="text-success">
                                        {{ $completionRate }}%
                                    </strong>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white border-0 pb-2">
                                <div class="d-flex flex-column gap-3">

                                    <!-- TOP ROW: TITLE + ADD BUTTON -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="fw-semibold mb-0">Tasks</h6>

                                        <a href="{{ route('task.create') }}"
                                           class="btn btn-sm btn-primary d-flex align-items-center justify-content-center"
                                           style="width: 34px; height: 34px;">
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </div>

                                    <!-- FILTER BAR -->
                                    <div class="task-filter-bar d-flex flex-wrap flex-lg-nowrap gap-2">

                                        <!-- SEARCH -->
                                        <input
                                            type="text"
                                            id="search"
                                            class="form-control form-control-sm"
                                            placeholder="Search task # or title"
                                        >

                                        <!-- AGENT -->
                                        <select class="form-select form-select-sm" id="agent-filter">
                                            <option value="">All Agent</option>
                                            @foreach($agents as $agent)
                                                <option value="{{ $agent->id }}">
                                                    {{ ucwords($agent->full_name) }} - {{ $agent->getRoleNames()->first() }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <!-- PRIORITY -->
                                        <select class="form-select form-select-sm" id="priorities">
                                            <option value="">All Priorities</option>
                                            <option value="low">Low</option>
                                            <option value="medium">Medium</option>
                                            <option value="high">High</option>
                                        </select>

                                        <!-- STATUS -->
                                        <select class="form-select form-select-sm" id="status-filter">
                                            <option value="">All Status</option>
                                            <option value="pending">Pending</option>
                                            <option value="in progress">In Progress</option>
                                            <option value="completed">Completed</option>
                                            <option value="overdue">Overdue</option>
                                        </select>

                                        <!-- DUE DATE -->
                                        <input
                                            type="date"
                                            id="due-date-filter"
                                            class="form-control form-control-sm"
                                        >

                                        <!-- ORDER -->
                                        <select class="form-select form-select-sm" id="order-by-due">
                                            <option value="">Default (Latest Created)</option>
                                            <option value="asc">Due Date ↑</option>
                                            <option value="desc">Due Date ↓</option>
                                        </select>
                                    </div>
                                </div>
                            </div>





                            <div class="table-responsive">
                                <table class="table align-middle mb-0 task-table table-hover" id="task-table">
                                    <thead class="table-light">
                                    <tr>
                                        <th style="width: 110px;">Task #</th>
                                        <th style="width: 28%;">Task</th>
                                        <th>Due</th>
                                        <th>Priority</th>
                                        <th style="width: 30%;">Assigned</th>
                                        <th>Linked To</th>
                                        <th>Status</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                    </thead>


                                    <tbody>


                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row g-4">

        </div>
    </div>

@endsection

@push('css')
    @vite('resources/css/task/task.css')
@endpush

@push('scripts')
    @vite('resources/js/dashboard/tasks/dashboard.js')
@endpush
