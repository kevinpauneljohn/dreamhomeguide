@extends('dashboard.layouts.app')
@section('title', $title)
@section('content')

    <!-- PAGE HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">{{ $user->full_name }}</h3>
            <small class="text-muted">User Profile Overview</small>
        </div>

        <a href="{{ route('user.index') }}" class="btn btn-light border px-4">
            Back to Users
        </a>
    </div>

    <div class="row">

        <!-- LEFT SIDEBAR -->
        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center p-4">
                    <!-- Avatar -->
                    <img src="{{ !is_null($user->profile_photo) ?  '/storage/profile_pictures/'.$user->profile_photo : 'https://static.vecteezy.com/system/resources/previews/026/434/417/original/default-avatar-profile-icon-of-social-media-user-photo-vector.jpg' }}"
                         class="rounded-circle border mb-3 shadow-sm"
                         width="120" height="120">

                    <!-- Name -->
                    <h4 class="fw-bold mb-0">{{ $user->full_name }}</h4>
                    <small class="text-muted d-block mb-3">{{ $user->email }}</small>

                    <!-- Roles -->
                    <div class="mt-2 mb-2">
                        @foreach($user->getRoleNames() as $role)
                            <span class="badge px-3 py-2 rounded-pill"
                                  style="background: linear-gradient(90deg, #4c6ef5, #7950f2);">
                                {{ ucfirst($role) }}
                            </span>
                        @endforeach
                    </div>

                    <!-- Status with Icon -->
                    <div class="mt-2">
            <span class="badge px-3 py-2 rounded-pill  gap-1
                @if($user->status=='active') bg-success
                @elseif($user->status=='inactive') bg-secondary
                @else bg-warning text-dark @endif"
                  style="background: linear-gradient(90deg, #7cda39, #17cd41);"
            >
                {{ strtoupper($user->status) }}
            </span>
                    </div>

                    <hr class="my-4">

                    <!-- Contact -->
                    <div class="text-start">
                        <p class="mb-2 "><i class="bi bi-phone me-2 text-primary"></i><strong>Phone:</strong> {{ $user->phone }}</p>
                        <p class="mb-2"><i class="bi bi-envelope me-2 text-primary"></i><strong>Email:</strong> {{ $user->email }}</p>
                        <p><i class="bi bi-calendar me-2 text-primary"></i><strong>Joined:</strong> {{ $user->created_at->format('F d, Y') }}</p>
                    </div>

                </div>
            </div>


            <!-- QUICK STATS -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="row text-center g-3">

                        <div class="col-4">
                            <div class="p-3 rounded bg-primary bg-opacity-10">
                                <h4 class="fw-bold mb-0 text-primary">25</h4>
                                <small class="text-muted d-block mt-1">Listings</small>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="p-3 rounded bg-success bg-opacity-10">
                                <h4 class="fw-bold mb-0 text-success">50</h4>
                                <small class="text-muted d-block mt-1">Sales</small>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="p-3 rounded bg-info bg-opacity-10">
                                <h4 class="fw-bold mb-0 text-info">100</h4>
                                <small class="text-muted d-block mt-1">Clients</small>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        <!-- MAIN CONTENT AREA -->
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">

                    <!-- TABS -->
                    <ul class="nav nav-tabs mb-4" role="tablist">

                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#overview">
                                Overview
                            </button>
                        </li>

                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#listings">
                                Listings
                            </button>
                        </li>

                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#activity">
                                Activities
                            </button>
                        </li>

                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#commissions">
                                Commissions
                            </button>
                        </li>

                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#files">
                                Files
                            </button>
                        </li>

                    </ul>

                    <!-- TAB CONTENT -->
                    <div class="tab-content">

                        <!-- OVERVIEW TAB -->
                        <div class="tab-pane fade show active" id="overview">

                            <h5 class="fw-bold mb-3">User Information</h5>

                            <div class="row mb-3">
                                <div class="col-2 text-muted">Full Name</div>
                                <div class="col-10">{{ ucwords(strtolower($user->full_name)) }}</div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-2 text-muted">Role</div>
                                <div class="col-10">
                                    @foreach($user->getRoleNames() as $role)
                                        <span class="badge bg-primary px-3 py-2">{{ ucfirst($role) }}</span>
                                    @endforeach
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-2 text-muted">Status</div>
                                <div class="col-10">{{ ucfirst($user->status) }}</div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-2 text-muted">Email</div>
                                <div class="col-10">{{ $user->email }}</div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-2 text-muted">Phone</div>
                                <div class="col-10">{{ $user->phone }}</div>
                            </div>

                            <hr>

                            <h5 class="fw-bold mb-3">Performance Summary</h5>

                            <p>Total Listings: <strong>25</strong></p>
                            <p>Total Sales: <strong>50</strong></p>
                            <p>Total Clients: <strong>100</strong></p>
                        </div>

                        <!-- LISTINGS TAB -->
                        <div class="tab-pane fade" id="listings">
                            <h5 class="fw-bold mb-3">Assigned Listings</h5>

                            @php $listings_count = 25; @endphp

                            @if($listings_count == 0)
                                <div class="alert alert-warning">This user has no listings.</div>
                            @else
                                <table class="table table-hover border">
                                    <thead>
                                    <tr>
                                        <th>Property</th>
                                        <th>Location</th>
                                        <th>Type</th>
                                        <th>Price</th>
                                        <th class="text-end"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($user->properties as $listing)
                                        <tr>
                                            <td>{{ $listing->title }}</td>
                                            <td>{{ $listing->location }}</td>
                                            <td>{{ strtoupper($listing->property_category) }}</td>
                                            <td>₱ {{ number_format($listing->price) }}</td>
                                            <td class="text-end">
                                                <a href="{{ route('property.show', $listing->id) }}"
                                                   class="btn btn-sm btn-light border">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>

                        <!-- ACTIVITY TAB -->
                        <div class="tab-pane fade" id="activity">
                            <h5 class="fw-bold mb-3">Recent Activity</h5>
                            <x-activities.logs userId="{{ $user->id }}"/>
                        </div>

                        <!-- Commissions TAB -->
                        <div class="tab-pane fade" id="commissions">

                            <div class="d-flex justify-content-between mb-3">
                                <button class="btn btn-primary" id="add-commission-btn">
                                    Add Commission
                                </button>
                            </div>

                            <table class="table table-bordered" id="commission-table">
                                <thead>
                                <tr>
                                    <th>Date Assigned</th>
                                    <th>Commission Rate</th>
                                    <th>Project</th>
                                    <th width="120">Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>

                        </div>

                        <div class="tab-pane fade" id="files">
                            <div class="card card-default mb-3">
                                <div class="card-body">
                                    <div id="actions" class="row">
                                        <div class="col-lg-6">
                                            <div class="btn-group w-100">
                                              <span class="btn btn-success col fileinput-button">
                                                <i class="fas fa-plus"></i>
                                                <span>Add files</span>
                                              </span>
                                                <button type="submit" class="btn btn-primary col start">
                                                    <i class="fas fa-upload"></i>
                                                    <span>Start upload</span>
                                                </button>
                                                <button type="reset" class="btn btn-warning col cancel">
                                                    <i class="fas fa-times-circle"></i>
                                                    <span>Cancel upload</span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 d-flex align-items-center">
                                            <div class="fileupload-process w-100">
                                                <div id="total-progress" class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                                    <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table table-striped files" id="previews">
                                        <div id="template" class="row mt-2">
                                            <div class="col-auto">
                                                <span class="preview"><img src="data:," alt="" data-dz-thumbnail /></span>
                                            </div>
                                            <div class="col d-flex align-items-center">
                                                <p class="mb-0">
                                                    <span class="lead" data-dz-name></span>
                                                    (<span data-dz-size></span>)
                                                </p>
                                                <strong class="error text-danger" data-dz-errormessage></strong>
                                            </div>
                                            <div class="col-4 d-flex align-items-center">
                                                <div class="progress progress-striped active w-100" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                                    <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                                                </div>
                                            </div>
                                            <div class="col-auto d-flex align-items-center">
                                                <div class="btn-group">
                                                    <button class="btn btn-primary start">
                                                        <i class="fas fa-upload"></i>
                                                        <span>Start</span>
                                                    </button>
                                                    <button data-dz-remove class="btn btn-warning cancel">
                                                        <i class="fas fa-times-circle"></i>
                                                        <span>Cancel</span>
                                                    </button>
                                                    <button data-dz-remove class="btn btn-danger delete">
                                                        <i class="fas fa-trash"></i>
                                                        <span>Delete</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>image</th>
                                        <th>File Name</th>
                                        <th>Uploaded At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($user->files as $file)
                                        <tr>
                                            <td><img src="{{asset('/storage/files/thumbs/' . $file->file_name)}}" class="img-thumbnail" width="55"></td>
                                            <td>{{$file->file_name}}</td>
                                            <td>{{$file->created_at}}</td>
                                            <td></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>


                    </div><!-- /tab-content -->

                </div>
            </div>
        </div>

    </div>

@endsection

@push('modal')
    <div class="modal fade" id="commission-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form id="commission-form" data-user-id="{{ $user->id }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel"></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <label for="project_id">Project</label>
                            <select name="project_id" id="project_id" class="form-select">
                                <option value="">Select Project</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="rate">Rate%</label>
                            <select name="rate" id="rate" class="form-select">
                                <option value="">Select Rate</option>
                                @for($rate = 0.5; $rate <= 8; $rate = $rate + 0.5)
                                    <option value="{{$rate}}">{{$rate}}%</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="save-commission-btn">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endpush

@push('scripts')
    @vite(['resources/js/dashboard/commissions/create.js'])
    @vite(['resources/js/dashboard/commissions/commission-table.js'])
    @vite(['resources/js/dashboard/users/files.js'])
@endpush
