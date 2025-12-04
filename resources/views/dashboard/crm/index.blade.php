@extends('dashboard.layouts.app')

@section('content')

    <!-- PAGE HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">Customer Relationship Manager</h2>
            <p class="text-muted mb-0">Track, manage and nurture your leads efficiently</p>
        </div>

        <a href="{{ route('leads.create') }}" class="btn btn-primary px-4 py-2">
            <i class="bi bi-plus-circle me-1"></i> Add New Lead
        </a>
    </div>

    <!-- STAT CARDS -->
    <div class="row g-3 mb-4">

        <!-- New Leads -->
        <div class="col-md-3">
            <div class="crm-stat-card p-4 shadow-sm rounded">
                <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                    <i class="bi bi-person-plus"></i>
                </div>
                <h6 class="text-muted mt-3">New Leads</h6>
                <h2 class="fw-bold">{{$newLeads}}</h2>
            </div>
        </div>

        <!-- Follow Ups -->
        <div class="col-md-3">
            <div class="crm-stat-card p-4 shadow-sm rounded">
                <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                    <i class="bi bi-clock-history"></i>
                </div>
                <h6 class="text-muted mt-3">Follow Ups</h6>
                <h2 class="fw-bold">42</h2>
            </div>
        </div>

        <!-- Hot Leads -->
        <div class="col-md-3">
            <div class="crm-stat-card p-4 shadow-sm rounded">
                <div class="stat-icon bg-danger bg-opacity-10 text-danger">
                    <i class="bi bi-fire"></i>
                </div>
                <h6 class="text-muted mt-3">Hot Leads</h6>
                <h2 class="fw-bold">18</h2>
            </div>
        </div>

        <!-- Closed Deals -->
        <div class="col-md-3">
            <div class="crm-stat-card p-4 shadow-sm rounded">
                <div class="stat-icon bg-success bg-opacity-10 text-success">
                    <i class="bi bi-check-circle"></i>
                </div>
                <h6 class="text-muted mt-3">Closed Deals</h6>
                <h2 class="fw-bold">7</h2>
            </div>
        </div>

    </div>

    <!-- FILTER BAR -->
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body d-flex flex-wrap gap-3 align-items-center">

            <div class="input-group w-25">
                <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                <input type="text" id="search" class="form-control" placeholder="Search name, email, phone…">
            </div>

            <div class="input-group w-25">
                <span class="input-group-text bg-white"><i class="bi bi-funnel"></i></span>
                <select class="form-select" id="status">
                    <option value="">Status</option>
                    @foreach($statuses as $key => $value)
                        <option value="{{ $key }}">{{ $key }}</option>
                    @endforeach
                </select>
            </div>

            <div class="input-group w-25">
                <span class="input-group-text bg-white"><i class="bi bi-diagram-3"></i></span>
                <select class="form-select" id="source">
                    <option value="">Source</option>
                    @foreach($sources as $source)
                        <option value="{{ $source }}">{{ $source }}</option>
                    @endforeach
                </select>
            </div>

            <div class="input-group w-auto">
                <span class="input-group-text bg-white"><i class="bi bi-calendar"></i></span>
                <input type="date" class="form-control" id="date_range">
            </div>

        </div>
    </div>

    <!-- LEADS TABLE -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-bottom-0">
            <h5 class="fw-bold mb-0">Lead List</h5>
        </div>

        <div class="card-body p-1">
            <table id="crm-table" class="table table-hover table-striped align-middle">
                <thead class="table-light">
                <tr>
                    <th class="w-25">Name</th>
                    <th>Phone</th>
                    <th>Source</th>
                    <th>Status</th>
                    <th>Date Added</th>
                    <th>Assigned To</th>
                    <th class="text-center" width="40"></th>
                </tr>
                </thead>
            </table>
        </div>
    </div>

@endsection

@push('scripts')
    @vite('resources/js/dashboard/leads/crmIndex.js')
@endpush
