@extends('dashboard.layouts.app')

@section('title', 'My Profile')

@section('content')
    <div class="container-fluid py-4">

        <div class="row g-4">
            <!-- LEFT: PROFILE CARD -->
            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <img
                            src="{{ !is_null(auth()->user()->profile_photo) ?  '/storage/profile_pictures/'.auth()->user()->profile_photo : 'https://static.vecteezy.com/system/resources/previews/026/434/417/original/default-avatar-profile-icon-of-social-media-user-photo-vector.jpg' }}"
                            class="rounded-circle mb-3"
                            width="120"
                            height="120"
                            alt="Profile Photo"
                        >

                        <h5 class="mb-1">{{ auth()->user()->full_name }}</h5>
                        <p class="text-muted mb-2">{{ auth()->user()->email }}</p>

                        <span class="badge bg-primary">{{ strtoupper(auth()->user()->getRoleNames()->first()) }}</span>
                        <span class="badge bg-success ms-1">{{ucwords(auth()->user()->status)}}</span>

                        <hr>

                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-primary btn-sm" id="changePhotoBtn">
                                <i class="fa fa-camera"></i> Change Photo
                            </button>

                            <button class="btn btn-outline-secondary btn-sm" id="changePasswordBtn">
                                <i class="fa fa-lock"></i> Change Password
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT: PROFILE DETAILS -->
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <ul class="nav nav-tabs card-header-tabs" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-info">
                                    Profile Information
                                </button>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body tab-content">

                        <!-- PROFILE INFO -->
                        <div class="tab-pane fade show active" id="profile-info">
                            <form id="update-profile-form">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">First Name</label>
                                        <input type="text" name="first_name" class="form-control" value="{{ auth()->user()->first_name }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Last Name</label>
                                        <input type="text" name="last_name" class="form-control" value="{{ auth()->user()->last_name }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Phone</label>
                                        <input type="text" name="phone" class="form-control" value="{{ auth()->user()->phone }}">
                                    </div>
                                </div>

                                <div class="mt-4 text-end">
                                    <button type="submit" class="btn btn-primary" id="saveProfileBtn">
                                        <i class="fa fa-save me-1"></i>
                                        <span class="btn-text">Save Changes</span>
                                    </button>

                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('modal')
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModal" aria-hidden="true">
        <form id="change-password-form">
            @csrf
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Change Password</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-label">Current Password</label>
                                <input type="password" name="existing_password" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">New Password</label>
                                <input type="password" name="new_password" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" name="new_password_confirmation" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endpush

@push('scripts')
    @vite(['resources/js/dashboard/profile/update-profile.js'])
@endpush
