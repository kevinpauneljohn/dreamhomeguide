@extends('dashboard.layouts.app')
@section('title',$title)
@section('content')

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">Add New User</h3>
            <small class="text-muted">Register a new user under Dream Home Guide Realty</small>
        </div>

        <a href="{{ route('user.index') }}" class="btn btn-light border px-4">
            Cancel
        </a>
    </div>

    <!-- Breadcrumb -->
    <div class="card mb-4">
        <div class="card-body">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('user.index') }}">User</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add New User</li>
                </ol>
            </nav>
        </div>
    </div>

    <form id="create-user-form" enctype="multipart/form-data" class="mb-3">
        @csrf

        <!-- Agent Info -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="fw-bold mb-3">User Information</h5>

                <div class="row g-3">
                    <div class="col-md-6 first_name">
                        <label class="form-label" for="first_name">First Name <span class="text-danger">*</span></label>
                        <input type="text" name="first_name" id="first_name" class="form-control" placeholder="e.g. Maria">
                    </div>

                    <div class="col-md-6 last_name">
                        <label class="form-label" for="last_name">Last Name <span class="text-danger">*</span></label>
                        <input type="text" name="last_name" id="last_name" class="form-control" placeholder="e.g. Santos">
                    </div>

                    <div class="col-md-6 email">
                        <label class="form-label" for="email">Email Address <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="maria@example.com">
                    </div>

                    <div class="col-md-6 phone">
                        <label class="form-label" for="phone">Phone Number <span class="text-danger">*</span></label>
                        <input type="text" name="phone" id="phone" class="form-control" placeholder="e.g. 0917-123-4567">
                    </div>
                </div>
            </div>
        </div>

        <!-- Account Access -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Account Login</h5>

                <div class="row g-3">
                    <div class="col-md-6 password">
                        <label class="form-label" for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Set a password">
                    </div>
                    <div class="col-md-6 password_confirmation">
                        <label class="form-label" for="password_confirmation">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm password">
                    </div>
                </div>
            </div>
        </div>

        <!-- Role & Status -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="fw-bold mb-3">User Role & Status</h5>

                <div class="row g-3">
                    <div class="col-md-4 role">
                        <label class="form-label" for="role">Role <span class="text-danger">*</span></label>
                        <select class="form-select" name="role" id="role">
                            <option value="">Select Role</option>
                            <option value="agent">Agent</option>
                            <option value="team leader">Team Leader</option>
                            <option value="manager">Manager</option>
                        </select>
                    </div>

                    <div class="col-md-4 status">
                        <label class="form-label" for="status">Status <span class="text-danger">*</span></label>
                        <select class="form-select" name="status" id="status">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="pending">Pending</option>
                        </select>
                    </div>

                    <div class="col-md-4 position">
                        <label class="form-label">Position (Optional)</label>
                        <input type="text" class="form-control" name="position" id="position" placeholder="Ex. CEO & Founder">
                    </div>
                </div>
            </div>
        </div>

        <!-- Upload Avatar -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Profile Picture</h5>

                <div class="d-flex align-items-center gap-3 ">
                    <img id="previewImage" src="https://static.vecteezy.com/system/resources/previews/026/434/417/original/default-avatar-profile-icon-of-social-media-user-photo-vector.jpg" width="70" height="70" class="rounded-circle border" alt="Profile Photo">

                    <div class="profile_photo">
                        <label class="form-label" for="profile_photo">Upload Image</label>
                        <input type="file" name="profile_photo" id="profile_photo" class="form-control" accept="image/*" onchange="previewPhoto(event)">
                        <small class="text-muted d-block">JPEG, PNG only — Max 2MB</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit -->
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary px-4 save-user-button">Save</button>
        </div>
    </form>

@endsection

@push('scripts')
    @vite(['resources/js/dashboard/users/create.js'])
@endpush
