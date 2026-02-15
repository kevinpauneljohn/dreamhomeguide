@extends('dashboard.layouts.app')

@section('title', 'Sales Quota')

@section('content')
    <div class="container-fluid py-4 quota-index">

        {{-- PAGE HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <small class="text-muted">Sales Management</small>
                <div class="d-flex align-items-center gap-2">
                    <i class="fa-solid fa-bullseye text-primary fs-4"></i>
                    <h3 class="fw-bold mb-0">Sales Quota</h3>
                </div>
            </div>

            <a href="{{ route('quota.create') }}" class="btn btn-primary">
                <i class="fa-solid fa-plus me-1"></i> Assign Quota
            </a>
        </div>

        {{-- KPI CARDS --}}
        <div class="row g-4 mb-4">

            <div class="col-lg-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <small class="text-muted">Total Assigned Quota</small>
                        <h4 class="fw-bold mb-0">₱1,250,000</h4>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <small class="text-muted">Total Closed Sales</small>
                        <h4 class="fw-bold text-success mb-0">₱920,000</h4>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <small class="text-muted">Average Achievement</small>
                        <h4 class="fw-bold text-primary mb-0">73%</h4>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <small class="text-muted">Top Performer</small>
                        <h5 class="fw-bold mb-0">John Doe</h5>
                        <small class="text-success">112% Achieved</small>
                    </div>
                </div>
            </div>

        </div>

        {{-- FILTERS --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <div class="row g-3">

                    <div class="col-lg-4">
                        <input type="text" class="form-control" placeholder="Search agent...">
                    </div>

                    <div class="col-lg-3">
                        <select class="form-select">
                            <option>All Roles</option>
                            <option>Agent</option>
                            <option>Manager</option>
                        </select>
                    </div>

                    <div class="col-lg-3">
                        <select class="form-select">
                            <option>All Status</option>
                            <option>Achieved</option>
                            <option>At Risk</option>
                            <option>Behind</option>
                        </select>
                    </div>

                    <div class="col-lg-2">
                        <select class="form-select">
                            <option>January 2026</option>
                            <option>February 2026</option>
                        </select>
                    </div>

                </div>
            </div>
        </div>

        {{-- QUOTA TABLE --}}
        <div class="card shadow-sm border-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">

                    <thead class="table-light">
                    <tr>
                        <th>Agent</th>
                        <th>Role</th>
                        <th>Period</th>
                        <th>Quota</th>
                        <th>Closed Sales</th>
                        <th>Achievement</th>
                        <th>Status</th>
                        <th width="80"></th>
                    </tr>
                    </thead>

                    <tbody>

                    {{-- SAMPLE ROW --}}
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar bg-primary text-white rounded-circle d-flex justify-content-center align-items-center">
                                    JK
                                </div>
                                <div>
                                    <div class="fw-semibold">John Kevin Paunel</div>
                                    <small class="text-muted">john@email.com</small>
                                </div>
                            </div>
                        </td>

                        <td><span class="badge bg-primary">Manager</span></td>
                        <td>January 2026</td>
                        <td>₱300,000</td>
                        <td>₱275,000</td>

                        <td style="width:200px;">
                            <div class="progress" style="height:8px;">
                                <div class="progress-bar bg-warning" style="width:92%"></div>
                            </div>
                            <small class="fw-semibold">92%</small>
                        </td>

                        <td>
                            <span class="badge bg-warning text-dark">
                                At Risk
                            </span>
                        </td>

                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item">Edit</a></li>
                                    <li><a class="dropdown-item text-danger">Delete</a></li>
                                </ul>
                            </div>
                        </td>

                    </tr>

                    </tbody>

                </table>
            </div>
        </div>

    </div>
@endsection
