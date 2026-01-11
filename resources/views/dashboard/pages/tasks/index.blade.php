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

            <div class="d-flex gap-2 align-items-center">
                <button class="btn btn-outline-secondary btn-sm">Today</button>
                <button class="btn btn-outline-secondary btn-sm">This Week</button>
                <button class="btn btn-dark btn-sm">This Month</button>
                <button class="btn btn-outline-secondary btn-sm">Reports</button>

            </div>
        </div>

        <div class="row mb-4">
            <div class="col-lg-3">
                <!-- MY TASKS -->
                <div class="col-lg-12">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="fw-semibold mb-0">My Tasks</h6>
                                <button class="btn btn-sm btn-outline-primary">+</button>
                            </div>

                            <div class="btn-group w-100 mb-3">
                                <button class="btn btn-sm btn-dark">Today</button>
                                <button class="btn btn-sm btn-outline-secondary">Tomorrow</button>
                            </div>

                            <select class="form-select form-select-sm mb-3">
                                <option>On Going Tasks</option>
                                <option>Completed</option>
                                <option>Overdue</option>
                            </select>

                            <!-- TASK ITEM -->
                            <div class="task-item mb-3 p-3 rounded">
                                <span class="badge bg-warning mb-2">Follow-up</span>
                                <h6 class="fw-semibold mb-1">Rania Model – Inquiry</h6>
                                <small class="text-muted">
                                    Call client re financing options
                                </small>
                                <div class="mt-2 d-flex justify-content-between">
                                    <small class="text-muted">4:00 PM</small>
                                    <input type="checkbox">
                                </div>
                            </div>

                            <div class="task-item mb-3 p-3 rounded">
                                <span class="badge bg-info mb-2">Appointment</span>
                                <h6 class="fw-semibold mb-1">Site Viewing – Solana</h6>
                                <small class="text-muted">
                                    Prepare documents
                                </small>
                                <div class="mt-2 d-flex justify-content-between">
                                    <small class="text-muted">Tomorrow</small>
                                    <input type="checkbox">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            <div class="col-lg-9">
                <div class="row">
                    <!-- OVERVIEW -->
                    <div class="col-lg-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-3">
                                    <h6 class="fw-semibold">Task Overview</h6>
                                    <i class="fa fa-arrow-up-right-from-square text-muted"></i>
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



                    <!-- PERFORMANCE / KPI -->
                    <div class="col-lg-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-3">
                                    <h6 class="fw-semibold">Lead & Appointment Activity</h6>
                                    <i class="fa fa-sliders text-muted"></i>
                                </div>

                                <!-- Line Chart Placeholder -->
                                <div class="line-chart-placeholder mb-3"></div>

                                <!-- KPIs -->
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small class="text-muted">Total Leads</small>
                                    <strong>124</strong>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small class="text-muted">Appointments Set</small>
                                    <strong>38</strong>
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">Conversion Rate</small>
                                    <strong class="text-success">30.6%</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="card border-0 shadow-sm mt-4">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                <h6 class="fw-semibold mb-0">Tasks</h6>

                                <div class="d-flex gap-2 align-items-center">

                                    <!-- SEARCH -->
                                    <input
                                        type="text"
                                        id="search"
                                        class="form-control form-control-sm"
                                        placeholder="Search task # or title"
                                        style="width: 220px;"
                                    >

                                    <!-- PRIORITY FILTER -->
                                    <select class="form-select form-select-sm" id="agent-filter">
                                        <option value="">All Agent</option>
                                        @foreach($agents as $agent)
                                            <option value="{{$agent->id}}">{{ucwords($agent->full_name)}} - {{$agent->getRoleNames()->first()}}</option>
                                        @endforeach
                                    </select>

                                    <!-- PRIORITY FILTER -->
                                    <select class="form-select form-select-sm" id="priorities">
                                        <option value="">All Priorities</option>
                                        <option value="low">Low</option>
                                        <option value="medium">Medium</option>
                                        <option value="high">High</option>
                                    </select>

                                    <!-- STATUS FILTER -->
                                    <select class="form-select form-select-sm" id="status-filter">
                                        <option value="">All Status</option>
                                        <option value="pending">Pending</option>
                                        <option value="in progress">In Progress</option>
                                        <option value="completed">Completed</option>
                                        <option value="overdue">Overdue</option>
                                    </select>

                                    <!-- DUE DATE FILTER -->
                                    <input
                                        type="date"
                                        id="due-date-filter"
                                        class="form-control form-control-sm"
                                        title="Filter by Due Date"
                                    >

                                    <!-- ORDER BY DUE DATE -->
                                    <select class="form-select form-select-sm" id="order-by-due">
                                        <option value="">Default (Latest Created)</option>
                                        <option value="asc">Due Date ↑ (Soonest)</option>
                                        <option value="desc">Due Date ↓ (Latest)</option>
                                    </select>


                                    <a href="{{route('task.create')}}" class="btn btn-sm btn-primary">
                                        <i class="fa fa-plus"></i>
                                    </a>
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
                                        <th>Assigned</th>
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
