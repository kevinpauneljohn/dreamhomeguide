@extends('dashboard.layouts.app')
@section('title',$title)
@section('content')

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">Edit User</h3>
            <small class="text-muted">Edit user under Dream Home Guide Realty</small>
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
                    <li class="breadcrumb-item active" aria-current="page">Edit User</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <form id="edit-user-form" action="{{route('user.update',['user' => $user->id])}}" enctype="multipart/form-data" class="mb-3">
                @csrf

                <!-- Agent Info -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">User Information</h5>

                        <div class="row g-3">
                            <div class="col-md-6 first_name">
                                <label class="form-label" for="first_name">First Name <span class="text-danger">*</span></label>
                                <input type="text" name="first_name" id="first_name" class="form-control" placeholder="e.g. Maria" value="{{$user->first_name}}">
                            </div>

                            <div class="col-md-6 last_name">
                                <label class="form-label" for="last_name">Last Name <span class="text-danger">*</span></label>
                                <input type="text" name="last_name" id="last_name" class="form-control" placeholder="e.g. Santos" value="{{$user->last_name}}">
                            </div>

                            <div class="col-md-6 email">
                                <label class="form-label" for="email">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="maria@example.com" value="{{$user->email}}">
                            </div>

                            <div class="col-md-6 phone">
                                <label class="form-label" for="phone">Phone Number <span class="text-danger">*</span></label>
                                <input type="text" name="phone" id="phone" class="form-control" placeholder="e.g. 0917-123-4567" value="{{$user->phone}}">
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
                                    <option value="agent" @if($user->hasRole('agent')) selected @endif>Agent</option>
                                    <option value="team leader" @if($user->hasRole('team leader')) selected @endif>Team Leader</option>
                                    <option value="manager" @if($user->hasRole('manager')) selected @endif>Manager</option>
                                </select>
                            </div>

                            <div class="col-md-4 status">
                                <label class="form-label" for="status">Status <span class="text-danger">*</span></label>
                                <select class="form-select" name="status" id="status">
                                    <option value="active" @if($user->hasRole('active')) selected @endif>Active</option>
                                    <option value="inactive" @if($user->hasRole('inactive')) selected @endif>Inactive</option>
                                    <option value="pending" @if($user->hasRole('pending')) selected @endif>Pending</option>
                                </select>
                            </div>

                            <div class="col-md-4 position">
                                <label class="form-label">Position (Optional)</label>
                                <input type="text" class="form-control" name="position" id="position" placeholder="Ex. CEO & Founder" value="{{$user->position}}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit -->
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary px-4 save-user-button">Save User Details</button>
                </div>
            </form>
        </div>
        <div class="col-md-6">
            <form id="edit-profile-photo-form" action="{{route('update-user-profile-photo',['user' => $user->id])}}" enctype="multipart/form-data">
                @csrf
                <!-- Upload Avatar -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Update Profile Picture</h5>

                        <div class="d-flex align-items-center gap-3 ">
                            <img id="previewImage" src="https://static.vecteezy.com/system/resources/previews/026/434/417/original/default-avatar-profile-icon-of-social-media-user-photo-vector.jpg" width="70" height="70" class="rounded-circle border" alt="Profile Photo">

                            <div class="profile_photo">
                                <label class="form-label" for="profile_photo">Upload Image</label>
                                <input type="hidden" name="old_profile_photo" id="old_profile_photo" value="{{$user->profile_photo}}">
                                <input type="file" name="profile_photo" id="profile_photo" class="form-control" accept="image/*" onchange="previewPhoto(event)">
                                <small class="text-muted d-block">JPEG, PNG only — Max 2MB</small>
                            </div>
                            <button type="submit" class="btn btn-primary px-4 mt-2 save-user-button">Save Photo</button>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>





@endsection

@push('scripts')
    @vite(['resources/js/dashboard/users/edit.js'])
@endpush
