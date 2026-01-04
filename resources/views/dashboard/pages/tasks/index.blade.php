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

                <div class="ms-3">
                    <input type="text" class="form-control form-control-sm" placeholder="Search task...">
                </div>
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

                                <!-- Donut Chart Placeholder -->
                                <div class="d-flex justify-content-center my-4">
                                    <div class="chart-placeholder rounded-circle position-relative">
                                        <div class="chart-center text-center">
                                            <small class="text-muted">Total</small>
                                            <h5 class="fw-bold mb-0">100</h5>
                                            <small class="text-muted">Tasks</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Stats -->
                                <div class="d-flex justify-content-around text-center">
                                    <div>
                                        <span class="dot bg-warning"></span>
                                        <small class="d-block text-muted">In Progress</small>
                                        <h6 class="fw-bold mb-0">14</h6>
                                    </div>
                                    <div>
                                        <span class="dot bg-success"></span>
                                        <small class="d-block text-muted">Completed</small>
                                        <h6 class="fw-bold mb-0">32</h6>
                                    </div>
                                    <div>
                                        <span class="dot bg-secondary"></span>
                                        <small class="d-block text-muted">Not Started</small>
                                        <h6 class="fw-bold mb-0">54</h6>
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
                                        id="taskSearch"
                                        class="form-control form-control-sm"
                                        placeholder="Search task # or title"
                                        style="width: 220px;"
                                    >

                                    <!-- STATUS FILTER -->
                                    <select class="form-select form-select-sm">
                                        <option>All Status</option>
                                        <option>Overdue</option>
                                        <option>In Progress</option>
                                        <option>Completed</option>
                                    </select>

                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fa fa-filter"></i>
                                    </button>
                                </div>
                            </div>


                            <div class="table-responsive">
                                <table class="table align-middle mb-0 task-table">
                                    <thead class="table-light">
                                    <tr>
                                        <th style="width: 110px;">Task #</th>
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

                                    <!-- TASK ROW -->
                                    <tr class="task-row overdue">
                                        <td>
                                            <span class="fw-semibold text-muted task-number">TSK-10021</span>
                                        </td>

                                        <td>
                                            <strong>Follow-up: Rania Model Inquiry</strong>
                                            <div class="text-muted small">
                                                Financing discussion
                                            </div>
                                        </td>

                                        <td>
                                            <span class="fw-semibold text-danger">Today</span>
                                            <div class="small text-muted">4:00 PM</div>
                                        </td>

                                        <td>
                        <span class="badge bg-danger-subtle text-danger">
                            High
                        </span>
                                        </td>

                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="avatar">JP</div>
                                                <span>John P.</span>
                                            </div>
                                        </td>

                                        <td>
                        <span class="badge bg-info-subtle text-info">
                            Lead
                        </span>
                                            <div class="small text-muted">
                                                Juan Dela Cruz
                                            </div>
                                        </td>

                                        <td>
                        <span class="badge bg-warning-subtle text-warning">
                            Overdue
                        </span>
                                        </td>

                                        <td class="text-end">
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-outline-success">
                                                    ✓
                                                </button>
                                                <button class="btn btn-sm btn-outline-secondary">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-secondary">
                                                    <i class="fa fa-ellipsis-vertical"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- NORMAL TASK -->
                                    <tr class="task-row">
                                        <td>
                                            <span class="fw-semibold text-muted task-number">TSK-10021</span>
                                        </td>

                                        <td>
                                            <strong>Site Viewing Preparation</strong>
                                            <div class="text-muted small">
                                                Print documents
                                            </div>
                                        </td>

                                        <td>
                                            <span class="fw-semibold">Tomorrow</span>
                                            <div class="small text-muted">9:00 AM</div>
                                        </td>

                                        <td>
                        <span class="badge bg-warning-subtle text-warning">
                            Medium
                        </span>
                                        </td>

                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="avatar">AR</div>
                                                <span>Agent Rose</span>
                                            </div>
                                        </td>

                                        <td>
                        <span class="badge bg-primary-subtle text-primary">
                            Appointment
                        </span>
                                            <div class="small text-muted">
                                                Solana Zaragoza
                                            </div>
                                        </td>

                                        <td>
                        <span class="badge bg-info-subtle text-info">
                            In Progress
                        </span>
                                        </td>

                                        <td class="text-end">
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-outline-success">
                                                    ✓
                                                </button>
                                                <button class="btn btn-sm btn-outline-secondary">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

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
    <style>
        .task-table th {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        .task-row.overdue {
            background: #fff5f5;
        }

        .avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.75rem;
        }

        .badge {
            font-weight: 500;
        }

        .btn-group .btn {
            padding: 4px 8px;
        }

        .chart-placeholder {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            border: 12px solid #e5e7eb;
            position: relative;
        }

        .chart-center {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }


    </style>
@endpush

@push('scripts')
    @vite('resources/js/dashboard/tasks/dashboard.js')
@endpush
