@extends('dashboard.layouts.app')
@section('title', $title)
@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">Users</h3>
            <small class="text-muted">Manage all users under Dream Home Guide Realty</small>
        </div>

        <a href="{{ route('user.create') }}" class="btn btn-primary px-4">
            + Add New User
        </a>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Users</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Search</label>
                    <input type="text" id="search" class="form-control" placeholder="Search name, email, phone…">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select id="status" class="form-select">
                        <option value="">All</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="pending">Pending</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Role</label>
                    <select id="role" class="form-select">
                        <option value="">All</option>
                        <option value="agent">Agent</option>
                        <option value="team leader">Team Leader</option>
                        <option value="manager">Manager</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Sort</label>
                    <select id="sort" class="form-select">
                        <option value="name_asc_first_name">First Name A–Z </option>
                        <option value="name_desc_first_name">First Name Z-A </option>
                        <option value="name_asc_last_name">Last Name A–Z </option>
                        <option value="name_desc_last_name">Last Name Z-A </option>
                        <option value="newest">Newest</option>
                        <option value="oldest">Oldest</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Agents Table -->
    <div class="card">
        <div class="card-body">
            <table id="users-table" class="table table-hover align-middle border rounded">
                <thead>
                <tr>
                    <th width="100px">Avatar</th>
                    <th width="300px">User</th>
                    <th>Phone</th>
                    <th class="text-center">Listings</th>
                    <th>Joined</th>
                    <th>Status</th>
                    <th width="100px">Action</th>
                </tr>
                </thead>

                <tbody>
                </tbody>
            </table>
        </div>
    </div>

@endsection

@push('scripts')
    @vite(['resources/js/dashboard/users/user-table.js'])
@endpush

