@extends('dashboard.layouts.app')
@section('title', $title)
@section('content')

    <div class="container-fluid py-4">

        <!-- PAGE HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <small class="text-muted">Execution & Follow-up Monitoring</small>
                <h4 class="fw-bold mb-0">Task Overview</h4>
            </div>

            <div class="d-flex gap-2">
                <button class="btn btn-sm btn-outline-secondary">Today</button>
                <button class="btn btn-sm btn-outline-secondary">This Week</button>
                <button class="btn btn-sm btn-dark">This Month</button>
            </div>
        </div>

        <!-- KPI CARDS -->
        <div class="row g-3 mb-4">
            <div class="col-lg-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <small class="text-muted">Total Tasks</small>
                        <h4 class="fw-bold mb-0">100</h4>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="card shadow-sm border-0 bg-warning-subtle">
                    <div class="card-body">
                        <small class="text-muted">In Progress</small>
                        <h4 class="fw-bold mb-0">14</h4>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="card shadow-sm border-0 bg-danger-subtle">
                    <div class="card-body">
                        <small class="text-muted">Overdue</small>
                        <h4 class="fw-bold mb-0">6</h4>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="card shadow-sm border-0 bg-success-subtle">
                    <div class="card-body">
                        <small class="text-muted">Completed</small>
                        <h4 class="fw-bold mb-0">32</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- OVERVIEW SECTION -->
        <div class="row g-4 mb-4">

            <!-- TASK STATUS -->
            <div class="col-lg-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <h6 class="fw-semibold mb-3">Task Status Overview</h6>

                        <div class="d-flex justify-content-around text-center">
                            <div>
                                <span class="dot bg-warning"></span>
                                <small class="d-block text-muted">In Progress</small>
                                <h6 class="fw-bold">14</h6>
                            </div>
                            <div>
                                <span class="dot bg-success"></span>
                                <small class="d-block text-muted">Completed</small>
                                <h6 class="fw-bold">32</h6>
                            </div>
                            <div>
                                <span class="dot bg-secondary"></span>
                                <small class="d-block text-muted">Not Started</small>
                                <h6 class="fw-bold">54</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PRIORITY -->
            <div class="col-lg-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <h6 class="fw-semibold mb-3">Task Priority Breakdown</h6>

                        <div class="d-flex justify-content-between mb-2">
                            <span>High Priority</span>
                            <strong class="text-danger">18</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Medium Priority</span>
                            <strong class="text-warning">47</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Low Priority</span>
                            <strong class="text-success">35</strong>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- EXECUTION TREND -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h6 class="fw-semibold mb-3">Execution Trend</h6>
                <div class="line-chart-placeholder"></div>

                <div class="d-flex justify-content-between mt-3">
                    <small class="text-muted">Avg. Completion Time</small>
                    <strong>1.8 days</strong>
                </div>
            </div>
        </div>

        <!-- TASK TABLE -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="fw-semibold mb-0">
                    <i class="fa-solid fa-list-check"></i> Tasks
                </h6>

                <div class="d-flex gap-2 align-items-center">
                    <input
                        type="text"
                        id="taskSearch"
                        class="form-control form-control-sm"
                        placeholder="Search task # or title"
                        style="width:220px;"
                    >

                    <select class="form-select form-select-sm">
                        <option>All Status</option>
                        <option>Overdue</option>
                        <option>In Progress</option>
                        <option>Completed</option>
                    </select>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table align-middle mb-0 task-table">
                    <thead class="table-light">
                    <tr>
                        <th>Task #</th>
                        <th>Task</th>
                        <th>Due</th>
                        <th>Priority</th>
                        <th>Assigned</th>
                        <th>Linked To</th>
                        <th>Status</th>
                        <th class="text-end">Action</th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr class="task-row overdue">
                        <td class="task-number">TSK-10021</td>
                        <td>
                            <strong>Follow-up: Rania Model Inquiry</strong>
                            <div class="text-muted small">Financing discussion</div>
                        </td>
                        <td>
                            <span class="fw-semibold text-danger">Today</span>
                            <div class="small text-muted">4:00 PM</div>
                        </td>
                        <td><span class="badge bg-danger-subtle text-danger">High</span></td>
                        <td>John P.</td>
                        <td>
                            <span class="badge bg-info-subtle text-info">Lead</span>
                            <div class="small text-muted">Juan Dela Cruz</div>
                        </td>
                        <td><span class="badge bg-warning-subtle text-warning">Overdue</span></td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-outline-success">✓</button>
                            <button class="btn btn-sm btn-outline-secondary">
                                <i class="fa fa-eye"></i>
                            </button>
                        </td>
                    </tr>

                    <tr class="task-row">
                        <td class="task-number">TSK-10022</td>
                        <td>
                            <strong>Site Viewing Preparation</strong>
                            <div class="text-muted small">Print documents</div>
                        </td>
                        <td>
                            Tomorrow
                            <div class="small text-muted">9:00 AM</div>
                        </td>
                        <td><span class="badge bg-warning-subtle text-warning">Medium</span></td>
                        <td>Agent Rose</td>
                        <td>
                            <span class="badge bg-primary-subtle text-primary">Appointment</span>
                            <div class="small text-muted">Solana Zaragoza</div>
                        </td>
                        <td><span class="badge bg-info-subtle text-info">In Progress</span></td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-outline-success">✓</button>
                            <button class="btn btn-sm btn-outline-secondary">
                                <i class="fa fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection

@push('css')

@endpush

@push('scripts')
    @vite('resources/js/dashboard/tasks/dashboard.js')
@endpush
