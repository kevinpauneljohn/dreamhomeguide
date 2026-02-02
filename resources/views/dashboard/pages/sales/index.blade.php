@extends('dashboard.layouts.app')

@section('title', 'Sales Dashboard')

@section('content')
    <div class="container-fluid py-4 sales-dashboard">

        {{-- PAGE HEADER --}}
        <div class="mb-4">
            <small class="text-muted">Manage and track your sales activities</small>

            <div class="d-flex justify-content-between align-items-center">
                <h3 class="fw-bold mb-0">Sales Dashboard</h3>

                {{-- QUICK KPI STRIP --}}
                <div class="d-none d-md-flex gap-2">
                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2">
                    ₱12.4M MTD
                </span>
                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">
                    12 Closed
                </span>
                    <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2">
                    8 In Progress
                </span>
                </div>
            </div>
        </div>

        {{-- TOP SUMMARY --}}
        <div class="row g-4 mb-4">

            {{-- SALES OVERVIEW --}}
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold mb-0">Sales Overview</h6>
                            <small class="text-muted">This Month</small>
                        </div>
                    </div>

                    <div class="card-body d-flex flex-column flex-md-row align-items-center gap-4">

                        {{-- DONUT PLACEHOLDER --}}
                        <div class="text-center" style="min-width:220px">
                            <div class="position-relative d-inline-block">
                                <div class="rounded-circle border border-4 border-success opacity-75"
                                     style="width:180px;height:180px;"></div>

                                <div class="position-absolute top-50 start-50 translate-middle">
                                    <small class="text-muted">Closed</small>
                                    <h3 class="fw-bold mb-0 text-success">45%</h3>
                                    <small class="text-muted">conversion</small>
                                </div>
                            </div>
                        </div>

                        {{-- STATUS BREAKDOWN --}}
                        <div class="w-100">
                            <div class="row text-center gy-3">

                                <div class="col-4">
                                    <i class="fa-solid fa-clock text-warning mb-1"></i>
                                    <small class="text-muted d-block">In Progress</small>
                                    <h5 class="fw-bold">8</h5>
                                </div>

                                <div class="col-4 border-start border-end">
                                    <i class="fa-solid fa-check-circle text-success mb-1"></i>
                                    <small class="text-muted d-block">Closed</small>
                                    <h5 class="fw-bold">12</h5>
                                </div>

                                <div class="col-4">
                                    <i class="fa-solid fa-xmark-circle text-secondary mb-1"></i>
                                    <small class="text-muted d-block">Cancelled</small>
                                    <h5 class="fw-bold">3</h5>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- SALES ATTENTION & RISK --}}
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 d-flex justify-content-between">
                        <h6 class="fw-bold mb-0">Sales Attention & Risk</h6>
                        <i class="fa-solid fa-triangle-exclamation text-muted"></i>
                    </div>

                    <div class="card-body">

                        <div class="row g-3 mb-4">
                            <div class="col-6">
                                <div class="p-3 rounded bg-danger bg-opacity-10 h-100">
                                    <i class="fa-solid fa-pause-circle text-danger"></i>
                                    <small class="text-muted d-block mt-1">Stalled Deals</small>
                                    <h4 class="fw-bold text-danger mb-0">4</h4>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="p-3 rounded bg-warning bg-opacity-10 h-100">
                                    <i class="fa-solid fa-calendar-week text-warning"></i>
                                    <small class="text-muted d-block mt-1">Due This Week</small>
                                    <h4 class="fw-bold text-warning mb-0">2</h4>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between small mb-2">
                            <strong>High Value Deals</strong>
                            <span class="fw-bold">₱6,500,000</span>
                        </div>

                        <div class="d-flex justify-content-between small mb-2">
                            <strong>Pending Reservations</strong>
                            <span class="fw-bold">3</span>
                        </div>

                        <div class="d-flex justify-content-between small">
                            <strong>Conversion Rate</strong>
                            <span class="fw-bold text-success">18%</span>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        {{-- SALES LIST --}}
        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0">Sales</h6>

                <a href="{{route('sales.create')}}" class="btn btn-primary btn-sm">
                    <i class="fa-solid fa-plus"></i>
                </a>
            </div>

            <div class="card-body">

                {{-- FILTERS --}}
                <div class="row g-2 mb-3">

                    <!-- Search -->
                    <div class="col-md-2">
                        <input type="text" name="search"
                               class="form-control form-control-sm"
                               placeholder="Search client or deal">
                    </div>

                    <!-- Project -->
                    <div class="col-md-2">
                        <select name="projects" class="form-select form-select-sm">
                            <option value="">All Projects</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Agent -->
                    <div class="col-md-2">
                        <select name="agents" class="form-select form-select-sm">
                            <option value="">All Agents</option>
                            @foreach($agents as $agent)
                                <option value="{{ $agent->id }}">{{ $agent->full_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status -->
                    <div class="col-md-2">
                        <select name="status" class="form-select form-select-sm">
                            <option value="">All Status</option>
                            <option value="reserved">Reserved</option>
                            <option value="cancelled">Cancelled</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>

                    <!-- Date -->
                    <div class="col-md-2">
                        <input name="date_created" type="date" class="form-control form-control-sm">
                    </div>

                    <!-- Sort -->
                    <div class="col-md-2">
                        <select name="sort" class="form-select form-select-sm">
                            <option value="latest">Latest Created</option>
                            <option value="oldest">Oldest Created</option>
                        </select>
                    </div>

                </div>


                {{-- TABLE --}}
                <div class="table-responsive">
                    <table id="sales-table" class="table align-middle table-hover mb-0">
                        <thead class="table-light">
                        <tr>
                            <th>CLIENT</th>
                            <th>PROJECT</th>
                            <th>AMOUNT</th>
                            <th>AGENT</th>
                            <th>STATUS</th>
                            <th>DATE</th>
                            <th class="text-end">ACTION</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr>
                            <td>
                                <strong>Juan Dela Cruz</strong><br>
                                <small class="text-muted">0921 817 3000</small>
                            </td>

                            <td>Villa Corazon – Duplex</td>

                            <td class="fw-bold">₱1,250,000</td>

                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="avatar bg-primary text-white fw-bold">JS</span>
                                    <div>
                                        <strong>John Santos</strong><br>
                                        <small class="text-muted">Agent</small>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <span class="badge rounded-pill bg-success bg-opacity-10 text-success px-3">
                                    Closed
                                </span>
                            </td>

                            <td>Jan 29</td>

                            <td class="text-end">
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-outline-secondary">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary">
                                        <i class="fa-solid fa-pen"></i>
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
@endsection

@push('css')
    @vite('resources/css/task/task.css')
    <style>
        .sales-dashboard .card {
            border-radius: 14px;
        }

        .sales-dashboard .avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
        }

        .sales-dashboard .table td {
            vertical-align: middle;
        }
    </style>
@endpush

@push('scripts')
    @vite(['resources/js/dashboard/sales/index.js'])
@endpush
