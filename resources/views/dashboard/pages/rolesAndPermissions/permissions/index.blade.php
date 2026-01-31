@extends('dashboard.layouts.app')

@section('title', $title)

@section('content')

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">{{$title}}</h3>
            <small class="text-muted">
                Manage access control and system permissions
            </small>
        </div>

        @can('add permission')
            <button type="button" class="btn btn-primary px-4" id="add-permission-btn">
                + Add Permission
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
                           placeholder="Search permission">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Roles</label>
                    <select id="role" class="form-select">
                        <option value="">All Roles</option>
                        @foreach($roles as $role)
                            <option value="{{$role->name}}">{{$role->name}}</option>
                        @endforeach
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
        <div class="card-body table-responsive">
            <table id="permissions-table" class="table table-bordered table-hover align-middle border rounded">
                <thead class="table-light">
                <tr>
                    <th style="width: 10%;">Permissions</th>
                    <th style="width: 30%;">Roles</th>
                    <th style="width: 30%;">Users</th>
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
    <div class="modal fade" id="permissionModal" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content" id="permission-form">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="fw-semibold mb-2">Permission</label>
                        <input type="text" name="permission" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="fw-semibold mb-2">Roles</label>
                        <select name="roles[]" class="form-control" id="roles" multiple>
                            @foreach($roles as $role)
                                <option value="{{$role->name}}">{{$role->name}}</option>
                            @endforeach
                        </select>
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

@push('scripts')
    @vite(['resources/js/dashboard/permissions/permissions-table.js'])
@endpush
