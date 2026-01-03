@extends('dashboard.layouts.app')

@section('title', $title)

@section('content')

<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-0">{{$title}}</h3>
        <small class="text-muted">
            Manage subdivision projects
        </small>
    </div>

    @can('add project')
    <button type="button" class="btn btn-primary px-4" id="add-project-btn">
        + Add New Project
    </button>
    @endcan
</div>

<!-- Breadcrumb -->
<div class="card mb-3">
    <div class="card-body py-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{$title}}
                </li>
            </ol>
        </nav>
    </div>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Search Role</label>
                <input type="text" id="search" class="form-control"
                       placeholder="Search role name…">
            </div>

            <div class="col-md-4">
                <label class="form-label">Permission</label>
                <select id="permission" class="form-select">
                    <option value="">All Permissions</option>

                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">Sort</label>
                <select id="sort" class="form-select">
                    <option value="name_asc">Role Name A–Z</option>
                    <option value="name_desc">Role Name Z–A</option>
                    <option value="newest">Newest</option>
                    <option value="oldest">Oldest</option>
                </select>
            </div>
        </div>
    </div>
</div>

<!-- Roles Table -->
<div class="card">
    <div class="card-body">
        <table id="roles-table" class="table table-bordered table-hover align-middle border rounded">
            <thead class="table-light">
            <tr>
                <th style="width: 10%;">Project</th>
                <th style="width: 30%;">Location</th>
                <th style="width: 30%;">Description</th>
                <th style="width: 12%">Created</th>
                <th class="text-center" style="width: 1%">Actions</th>
            </tr>
            </thead>

            <tbody>
            {{-- Loaded via AJAX --}}
            </tbody>
        </table>
    </div>
</div>

@endsection

@pushonce('modal')
<div class="modal fade" id="projectModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form class="modal-content" id="project-form">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="mb-3">
                    <label class="fw-semibold mb-2">Name</label>
                    <input type="text" name="roles" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="fw-semibold mb-2">Permissions</label>

                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>

        </form>
    </div>
</div>
@endpushonce

{{--@push('scripts')--}}
{{--    @vite(['resources/js/dashboard/roles/roles-table.js'])--}}
{{--@endpush--}}
