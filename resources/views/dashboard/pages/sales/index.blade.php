@extends('dashboard.layouts.app')

@section('title', 'Sales Dashboard')

@section('content')
    <div class="container-fluid py-4 sales-dashboard">

        {{-- PAGE HEADER --}}
        <div class="mb-4">
            <small class="text-muted">Manage and track your sales activities</small>

            <div class="d-flex justify-content-between align-items-center">
                <h3 class="fw-bold mb-0">Sales Dashboard</h3>
            </div>
        </div>

        {{-- TOP SUMMARY --}}
        <div class="row g-4 mb-4">

            {{-- TOTAL SALES (CURRENT MONTH) --}}
            <div class="col-lg-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <small class="text-muted">Sales This Month</small>
                        <h1 class="fw-bold mt-2 text-success" id="current-month-sales">
                        </h1>
                        <span class="badge bg-success-subtle text-success">
                    {{ now()->format('F Y') }}
                </span>
                    </div>
                </div>
            </div>

            {{-- AGENT RANKING --}}
            <div class="col-lg-8">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">Top Performing Agents</h6>

                        <div class="table-responsive">
                            <table class="table table-sm align-middle">
                                <thead class="text-muted small">
                                <tr>
                                    <th>#</th>
                                    <th>Agent</th>
                                    <th>Units Sold</th>
                                    <th>Total Amount</th>
                                </tr>
                                </thead>
                                <tbody id="top-agents-by-sales">

                                </tbody>
                            </table>
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
