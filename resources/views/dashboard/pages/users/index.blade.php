@extends('dashboard.layouts.app')

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
                    <input type="text" class="form-control" placeholder="Search name, email, phone…">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select class="form-select">
                        <option>All</option>
                        <option>Active</option>
                        <option>Inactive</option>
                        <option>Pending</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Role</label>
                    <select class="form-select">
                        <option>All</option>
                        <option>Agent</option>
                        <option>Team Leader</option>
                        <option>Manager</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Sort</label>
                    <select class="form-select">
                        <option>Name A–Z</option>
                        <option>Newest</option>
                        <option>Oldest</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Agents Table -->
    <div class="card">
        <div class="card-body">
            <table id="agents-table" class="table table-hover align-middle">
                <thead>
                <tr>
                    <th>Avatar</th>
                    <th>User</th>
                    <th>Phone</th>
                    <th>Listings</th>
                    <th>Joined</th>
                    <th>Status</th>
                    <th class="text-end">Action</th>
                </tr>
                </thead>

                <tbody>
                <tr>
                    <td>
                        <img src="/images/sample-agent.jpg" class="rounded-circle" width="40" height="40">
                    </td>
                    <td>
                        <strong>Maria Santos</strong> <br>
                        <small class="text-muted">maria@example.com</small>
                    </td>
                    <td>0917-123-4567</td>
                    <td><span class="badge bg-info">12 Listings</span></td>
                    <td>Jan 15, 2025</td>
                    <td><span class="badge bg-success">ACTIVE</span></td>
                    <td class="text-end">
                        <div class="btn-group">
                            <button class="btn btn-light btn-sm border dropdown-toggle" data-bs-toggle="dropdown">
                                Actions
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{route('user.show',1)}}">View Profile</a></li>
                                <li><a class="dropdown-item" href="#">Edit</a></li>
                                <li><a class="dropdown-item text-warning" href="#">Deactivate</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="#">Delete</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>

                <!-- repeat rows here -->
                </tbody>
            </table>
        </div>
    </div>

@endsection

