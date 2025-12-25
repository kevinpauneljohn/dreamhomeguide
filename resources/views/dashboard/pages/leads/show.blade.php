@extends('dashboard.layouts.app')
@section('title', $title)
@section('content')

    <!-- PAGE HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">Lead Profile</h2>
            <p class="text-muted mb-0">Complete details, timeline, interactions & scoring</p>
        </div>

        <a href="{{ route('crm.index') }}" class="btn btn-outline-secondary px-4">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <!-- PROFILE HEADER -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body d-flex align-items-center gap-4">

            <!-- Avatar -->
            <div class="profile-ring">
                <img src="{{ $genderPhoto }}"
                     class="rounded-circle border profile-photo"
                     width="95" height="95">
                {{--                <img src="{{ $genderPhoto }}" class="rounded-circle profile-photo">--}}
            </div>

            <div class="flex-grow-1">
                <h3 class="fw-bold mb-1 d-flex align-items-center gap-2">
{{--                    <span class="lead-name">{{ $lead->full_name }}</span>--}}
                    <span class="lead-name"></span>
                    <span class="badge bg-warning text-dark lead-score">
                    ⭐ {{ $lead->score ?? 72 }}
                </span>
                </h3>

                <div class="d-flex flex-wrap gap-2 mb-2">
                    <span class="badge px-3 py-2 bg-primary">{{ ucfirst($lead->status) }}</span>

                    <!-- TAGS -->
                    @if(!empty($lead->tags))
                        @foreach(explode(',', $lead->tags) as $tag)
                            <span class="badge bg-light text-dark border">{{ trim($tag) }}</span>
                        @endforeach
                    @else
                        <span class="text-muted small">No tags yet</span>
                    @endif

                    <!-- Add Tag Button -->
                    <button class="btn btn-sm btn-outline-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#addTagModal">
                        + Tag
                    </button>
                </div>

                <small class="text-muted">Created on {{ $lead->created_at->format('M d, Y g:i a') }}</small>
            </div>
        </div>
    </div>

    <div class="row g-4">

        <!-- LEFT COLUMN -->
        <div class="col-lg-9">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-lea-details-tab" data-bs-toggle="pill" data-bs-target="#lead-details" type="button" role="tab" aria-controls="pills-lead-details" aria-selected="true">Lead Details</button>
                </li>
                @can('view appointment')
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-appointment-tab" data-bs-toggle="pill" data-bs-target="#appointment" type="button" role="tab" aria-controls="appointment" aria-selected="false">Appointments</button>
                    </li>
                @endcan
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-files-tab" data-bs-toggle="pill" data-bs-target="#files" type="button" role="tab" aria-controls="files" aria-selected="false">Files</button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="lead-details" role="tabpanel" aria-labelledby="lead-details-tab" tabindex="0">
                    <!-- CONTACT & PERSONAL DETAILS -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white border-bottom-0">
                            <h5 class="fw-bold mb-0">Lead Details</h5>
                        </div>

                        <div class="card-body">

                            <!-- Editable Grid -->
                            <div class="row">

                                <!-- First Name -->
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small">First Name</label>
                                    <div class="editable-field" data-field="first_name">
                                        <span class="value fw-semibold">{{ $lead->first_name }}</span>
                                        @can('edit lead')
                                            <i class="bi bi-pencil edit-icon edit-btn"></i>

                                            <!-- Hidden input for editing -->
                                            <div class="edit-input mt-1 d-none">
                                                <input type="text" id="first_name" class="form-control input-box" value="{{ $lead->first_name }}">
                                                <div class="mt-1">
                                                    <button class="btn btn-sm btn-success save-btn">Save</button>
                                                    <button class="btn btn-sm btn-light cancel-btn">Cancel</button>
                                                </div>
                                            </div>
                                        @endcan
                                    </div>
                                </div>


                                <!-- First Name -->
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small">Last Name</label>
                                    <div class="editable-field" data-field="last_name">
                                        <span class="value fw-semibold">{{ $lead->last_name }}</span>
                                        @can('edit lead')
                                            <i class="bi bi-pencil edit-icon edit-btn"></i>

                                            <!-- Hidden input for editing -->
                                            <div class="edit-input mt-1 d-none">
                                                <input type="text" id="last_name" class="form-control input-box" value="{{ $lead->last_name }}">
                                                <div class="mt-1">
                                                    <button class="btn btn-sm btn-success save-btn">Save</button>
                                                    <button class="btn btn-sm btn-light cancel-btn">Cancel</button>
                                                </div>
                                            </div>
                                        @endcan
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small">Email</label>
                                    <div class="editable-field" data-field="email">
                                        <span class="value fw-semibold">{{ $lead->email }}</span>
                                        @can('edit lead')
                                            <i class="bi bi-pencil edit-icon edit-btn"></i>

                                            <!-- Hidden input for editing -->
                                            <div class="edit-input mt-1 d-none">
                                                <input type="text" id="email" class="form-control input-box" value="{{ $lead->email }}">
                                                <div class="mt-1">
                                                    <button class="btn btn-sm btn-success save-btn">Save</button>
                                                    <button class="btn btn-sm btn-light cancel-btn">Cancel</button>
                                                </div>
                                            </div>
                                        @endcan
                                    </div>
                                </div>

                                <!-- Phone -->
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small">Phone</label>
                                    <div class="editable-field" data-field="phone">
                                        <span class="value fw-semibold">{{ $lead->phone }}</span>
                                        @can('edit lead')
                                            <i class="bi bi-pencil edit-icon edit-btn"></i>

                                            <!-- Hidden input for editing -->
                                            <div class="edit-input mt-1 d-none">
                                                <input type="text" id="phone" class="form-control input-box" value="{{ $lead->phone }}">
                                                <div class="mt-1">
                                                    <button class="btn btn-sm btn-success save-btn">Save</button>
                                                    <button class="btn btn-sm btn-light cancel-btn">Cancel</button>
                                                </div>
                                            </div>
                                        @endcan
                                    </div>
                                </div>

                                <!-- Address -->
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small">Address</label>
                                    <div class="editable-field" data-field="address">
                                        <span class="value fw-semibold">{{ $lead->address }}</span>
                                        @can('edit lead')
                                            <i class="bi bi-pencil edit-icon edit-btn"></i>

                                            <!-- Hidden input for editing -->
                                            <div class="edit-input mt-1 d-none">
                                                <input type="text" id="address" class="form-control input-box" value="{{ $lead->address }}">
                                                <div class="mt-1">
                                                    <button class="btn btn-sm btn-success save-btn">Save</button>
                                                    <button class="btn btn-sm btn-light cancel-btn">Cancel</button>
                                                </div>
                                            </div>
                                        @endcan

                                    </div>
                                </div>

                                <!-- Birthday -->
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small">Birthday</label>
                                    <div class="editable-field" data-field="birthday">
                                        <span class="value fw-semibold">{{ !is_null($lead->birthday) ? $lead->birthday->format('M d, Y'):'' }}</span>
                                        @can('edit lead')
                                            <i class="bi bi-pencil edit-icon"></i>

                                            <!-- Hidden input for editing -->
                                            <div class="edit-input mt-1 d-none">
                                                <input type="hidden" class="form-control" id="birthday" value="{{ $lead->birthday }}">
                                                <input type="date" class="form-control input-box" id="birthday-input">
                                                <span id="birthday-error" class="text-danger small"></span>
                                                <div class="mt-1">
                                                    <button class="btn btn-sm btn-success save-btn">Save</button>
                                                    <button class="btn btn-sm btn-light cancel-btn">Cancel</button>
                                                </div>
                                            </div>
                                        @endcan
                                    </div>
                                </div>

                                <!-- Gender -->
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small">Gender</label>
                                    <div class="editable-field" data-field="gender">
                                        <span class="value fw-semibold">{{ $lead->gender }}</span>
                                        @can('edit lead')
                                            <i class="bi bi-pencil edit-icon edit-btn"></i>

                                            <!-- Hidden input for editing -->
                                            <div class="edit-input mt-1 d-none">
                                                <select name="gender" id="gender" class="form-select input-box">
                                                    <option value=""> -- Select an option -- </option>
                                                    <option value="Male" @if($lead->gender === "Male") selected @endif>Male</option>
                                                    <option value="Female" @if($lead->gender === "Female") selected @endif>Female</option>
                                                </select>
                                                <div class="mt-1">
                                                    <button class="btn btn-sm btn-success save-btn">Save</button>
                                                    <button class="btn btn-sm btn-light cancel-btn">Cancel</button>
                                                </div>
                                            </div>
                                        @endcan
                                    </div>
                                </div>

                                <!-- Civil Status -->
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small">Civil Status</label>
                                    <div class="editable-field" data-field="civil_status">
                                        <span class="value fw-semibold">{{ $lead->civil_status }}</span>
                                        @can('edit lead')
                                            <i class="bi bi-pencil edit-icon edit-btn"></i>

                                            <!-- Hidden input for editing -->
                                            <div class="edit-input mt-1 d-none">
                                                <select name="civil_status" id="civil_status" class="form-select input-box">
                                                    <option value=""> -- Select an option -- </option>
                                                    <option value="single" @if($lead->civil_status === "single") selected @endif>Single</option>
                                                    <option value="married" @if($lead->civil_status === "married") selected @endif>Married</option>
                                                    <option value="widower" @if($lead->civil_status === "widower") selected @endif>Widower</option>
                                                </select>
                                                <div class="mt-1">
                                                    <button class="btn btn-sm btn-success save-btn">Save</button>
                                                    <button class="btn btn-sm btn-light cancel-btn">Cancel</button>
                                                </div>
                                            </div>
                                        @endcan
                                    </div>
                                </div>

                                <!-- Income -->
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small">Income Range</label>
                                    <div class="editable-field" data-field="income_range">
                                        <span class="value fw-semibold">{{ $lead->income_range }}</span>
                                        @can('edit lead')
                                            <i class="bi bi-pencil edit-icon edit-btn"></i>

                                            <!-- Hidden input for editing -->
                                            <div class="edit-input mt-1 d-none">
                                                <select name="income_range" id="income_range" class="form-select input-box">
                                                    <option value=""></option>
                                                    @foreach($incomeRange as $range)
                                                        <option value="{{ $range }}" @if($range === $lead->income_range) selected @endif>{{ $range }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="mt-1">
                                                    <button class="btn btn-sm btn-success save-btn">Save</button>
                                                    <button class="btn btn-sm btn-light cancel-btn">Cancel</button>
                                                </div>
                                            </div>
                                        @endcan
                                    </div>
                                </div>

                                <!-- Lead Source -->
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small">Source</label>
                                    <div class="editable-field" data-field="source">
                                        <span class="value fw-semibold">{{ $lead->source }}</span>
                                        @can('edit lead')
                                            <i class="bi bi-pencil edit-icon edit-btn"></i>

                                            <!-- Hidden input for editing -->
                                            <div class="edit-input mt-1 d-none">
                                                <select name="source" id="source" class="form-select input-box">
                                                    <option value="">Select Source</option>
                                                    @foreach($sources as $source)
                                                        <option value="{{$source}}" @if($source === $lead->source) selected @endif>{{$source}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="mt-1">
                                                    <button class="btn btn-sm btn-success save-btn">Save</button>
                                                    <button class="btn btn-sm btn-light cancel-btn">Cancel</button>
                                                </div>
                                            </div>
                                        @endcan
                                    </div>

                                </div>

                                <!-- Assigned Agent -->
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small">Assigned Agent</label>
                                    <div class="editable-field" data-field="user_id">
                                        <span class="value fw-semibold">{{ $lead->user->full_name ?? 'Unassigned' }}</span>
                                        @can('edit lead')
                                            <i class="bi bi-pencil edit-icon edit-btn"></i>

                                            <!-- Hidden input for editing -->
                                            <div class="edit-input mt-1 d-none">
                                                <select name="assigned_agent" id="assigned_agent" class="form-select input-box">
                                                    <option value="">Select Agent</option>
                                                    @foreach($agents as $agent)
                                                        <option value="{{ $agent->id }}" @if($agent->id === $lead->user_id) selected @endif>{{ $agent->full_name }} - {{$agent->email}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="mt-1">
                                                    <button class="btn btn-sm btn-success save-btn">Save</button>
                                                    <button class="btn btn-sm btn-light cancel-btn">Cancel</button>
                                                </div>
                                            </div>
                                        @endcan
                                    </div>
                                </div>

                                <!-- Lead type -->
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small">Lead Type</label>
                                    <div class="editable-field" data-field="lead_type">
                                        <span class="value fw-semibold">{{ $lead->lead_type }}</span>
                                        @can('edit lead')
                                            <i class="bi bi-pencil edit-icon edit-btn"></i>

                                            <!-- Hidden input for editing -->
                                            <div class="edit-input mt-1 d-none">
                                                <select name="lead_type" id="lead_type" class="form-select input-box">
                                                    <option value="">Select lead Type</option>
                                                    @foreach($leadTypes as $key => $value)
                                                        <option value="{{ $key }}" @if($key === $lead->lead_type) selected @endif>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="mt-1">
                                                    <button class="btn btn-sm btn-success save-btn">Save</button>
                                                    <button class="btn btn-sm btn-light cancel-btn">Cancel</button>
                                                </div>
                                            </div>
                                        @endcan
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center bg-white border-bottom-0">
                            <h5 class="fw-bold mb-0">lead Initial Message</h5>
                        </div>
                        <div class="card-body">
                            @if(!is_null($lead->property_id))
                                <div>
                                    <strong>Property Interested to: <a href="{{route('property.show',['property' => $lead->property_id])}}" target="_blank">{{ucwords($lead->property->title)}}</a> </strong>
                                </div>
                            @endif
                            {!! $lead->message !!}
                        </div>
                    </div>

                    @can('view note')
                        <!-- NOTES -->
                        <div class="card shadow-sm border-0 mb-4">
                            <input type="hidden" name="lead_id" value="{{ $lead->id }}">
                            <div class="card-header d-flex justify-content-between bg-white border-bottom-0">
                                <h5 class="fw-bold mb-0">Notes</h5>

                                @can('add note')
                                    <button class="btn btn-primary btn-sm add-note-btn" data-bs-toggle="modal" data-bs-target="#addNoteModal">
                                        <i class="bi bi-plus-circle me-1"></i> Add Note
                                    </button>
                                @endcan
                            </div>

                            {{--                <div class="card-body">--}}
                            {{--                    <p class="text-muted">No notes added yet.</p>--}}
                            {{--                </div>--}}

                            <div class="card-body">
                                <table id="notes-table" class="table table-hover align-middle notes-table">
                                    <thead class="table-light">
                                    <tr>
                                        <th width="60">Type</th>
                                        <th>Title & Content</th>
                                        <th width="200">Date</th>
                                        <th width="150">Added By</th>
                                        <th class="text-center" width="40"></th>
                                    </tr>
                                    </thead>

                                    <tbody>

                                    </tbody>
                                </table>


                            </div>


                        </div>
                    @endcan
                </div>
                @can('view appointment')
                    <div class="tab-pane fade" id="appointment" role="tabpanel" aria-labelledby="appointment-tab" tabindex="0">
                        <!-- Calendar -->
                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <span class="badge bg-primary rounded-pill m-1">Tripping</span>
                                    <span class="badge bg-warning rounded-pill m-1">Follow Up</span>
                                    <span class="badge bg-success rounded-pill m-1">Assistance</span>
                                    <span class="badge bg-danger rounded-pill m-1">Reservations</span>
                                    <span class="badge rounded-pill m-1" style="background-color: #6f42c1">Send Update</span>
                                </div>
                                <!-- calendar here -->
                                <x-appointment.calendar />
                            </div>
                        </div>
                    </div>
                @endcan
                <div class="tab-pane fade" id="files" role="tabpanel" aria-labelledby="files-tab" tabindex="0">
                    <!-- FILES & DOCUMENTS -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center bg-white border-bottom-0">
                            <h5 class="fw-bold mb-0">Files & Documents</h5>

{{--                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#uploadDocumentModal">--}}
{{--                                <i class="bi bi-upload me-1"></i> Upload File--}}
{{--                            </button>--}}
                        </div>

                        <div class="card-body">
                            <p>
                                Coming soon!
                            </p>

                            <!-- If no documents -->
                            <!-- <p class="text-muted">No documents uploaded yet.</p> -->

{{--                            <table class="table table-hover align-middle documents-table">--}}
{{--                                <thead class="table-light">--}}
{{--                                <tr>--}}
{{--                                    <th width="60">Type</th>--}}
{{--                                    <th>File Name</th>--}}
{{--                                    <th width="160">Size</th>--}}
{{--                                    <th width="180">Uploaded</th>--}}
{{--                                    <th class="text-center" width="60"></th>--}}
{{--                                </tr>--}}
{{--                                </thead>--}}

{{--                                <tbody>--}}

{{--                                <!-- EXAMPLE PDF -->--}}
{{--                                <tr>--}}
{{--                                    <td>--}}
{{--                                        <div class="file-type-icon pdf">--}}
{{--                                            <i class="bi bi-file-earmark-pdf-fill"></i>--}}
{{--                                        </div>--}}
{{--                                    </td>--}}
{{--                                    <td>--}}
{{--                                        <strong>Buyer_Reservation_Form.pdf</strong>--}}
{{--                                    </td>--}}
{{--                                    <td>--}}
{{--                                        <small class="text-muted">1.2 MB</small>--}}
{{--                                    </td>--}}
{{--                                    <td>--}}
{{--                                        <small class="text-muted">Jan 18, 2025 • by <strong>John Kevin</strong></small>--}}
{{--                                    </td>--}}
{{--                                    <td class="text-center">--}}
{{--                                        <div class="dropdown">--}}
{{--                                            <button class="btn btn-sm btn-light border-0" data-bs-toggle="dropdown">--}}
{{--                                                <i class="bi bi-three-dots-vertical"></i>--}}
{{--                                            </button>--}}
{{--                                            <ul class="dropdown-menu dropdown-menu-end">--}}
{{--                                                <li><a class="dropdown-item">Download</a></li>--}}
{{--                                                <li><a class="dropdown-item text-danger">Delete</a></li>--}}
{{--                                            </ul>--}}
{{--                                        </div>--}}
{{--                                    </td>--}}
{{--                                </tr>--}}

{{--                                <!-- EXCEL -->--}}
{{--                                <tr>--}}
{{--                                    <td>--}}
{{--                                        <div class="file-type-icon excel">--}}
{{--                                            <i class="bi bi-file-earmark-excel-fill"></i>--}}
{{--                                        </div>--}}
{{--                                    </td>--}}
{{--                                    <td>--}}
{{--                                        <strong>Income_Documentation.xlsx</strong>--}}
{{--                                    </td>--}}
{{--                                    <td>--}}
{{--                                        <small class="text-muted">450 KB</small>--}}
{{--                                    </td>--}}
{{--                                    <td>--}}
{{--                                        <small class="text-muted">Jan 15, 2025 • by <strong>Andrea Santos</strong></small>--}}
{{--                                    </td>--}}
{{--                                    <td class="text-center">--}}
{{--                                        <div class="dropdown">--}}
{{--                                            <button class="btn btn-sm btn-light border-0" data-bs-toggle="dropdown">--}}
{{--                                                <i class="bi bi-three-dots-vertical"></i>--}}
{{--                                            </button>--}}
{{--                                            <ul class="dropdown-menu dropdown-menu-end">--}}
{{--                                                <li><a class="dropdown-item">Download</a></li>--}}
{{--                                                <li><a class="dropdown-item text-danger">Delete</a></li>--}}
{{--                                            </ul>--}}
{{--                                        </div>--}}
{{--                                    </td>--}}
{{--                                </tr>--}}

{{--                                <!-- IMAGE -->--}}
{{--                                <tr>--}}
{{--                                    <td>--}}
{{--                                        <div class="file-type-icon image">--}}
{{--                                            <i class="bi bi-file-image-fill"></i>--}}
{{--                                        </div>--}}
{{--                                    </td>--}}
{{--                                    <td>--}}
{{--                                        <strong>Valid_ID.jpg</strong>--}}
{{--                                    </td>--}}
{{--                                    <td>--}}
{{--                                        <small class="text-muted">280 KB</small>--}}
{{--                                    </td>--}}
{{--                                    <td>--}}
{{--                                        <small class="text-muted">Jan 10, 2025 • by <strong>System</strong></small>--}}
{{--                                    </td>--}}
{{--                                    <td class="text-center">--}}
{{--                                        <div class="dropdown">--}}
{{--                                            <button class="btn btn-sm btn-light border-0" data-bs-toggle="dropdown">--}}
{{--                                                <i class="bi bi-three-dots-vertical"></i>--}}
{{--                                            </button>--}}
{{--                                            <ul class="dropdown-menu dropdown-menu-end">--}}
{{--                                                <li><a class="dropdown-item">Download</a></li>--}}
{{--                                                <li><a class="dropdown-item text-danger">Delete</a></li>--}}
{{--                                            </ul>--}}
{{--                                        </div>--}}
{{--                                    </td>--}}
{{--                                </tr>--}}

{{--                                </tbody>--}}
{{--                            </table>--}}

                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- RIGHT COLUMN (Sticky Sidebar) -->
        <div class="col-lg-3">

            <div class="card shadow-sm border-0 sticky-top" style="top: 90px">

                <div class="card-header bg-white border-bottom-0">
                    <h5 class="fw-bold mb-0">Activity Timeline</h5>
                </div>

                <div class="card-body" style=" overflow-y: auto;">

                    <x-activities.logs leadId="{{ $lead->id }}"/>

{{--                    <div class="timeline-item d-flex gap-3 mb-4">--}}
{{--                        <div class="timeline-icon bg-primary text-white">--}}
{{--                            <i class="bi bi-hourglass-split display-5"></i>--}}
{{--                        </div>--}}
{{--                        <div>--}}
{{--                            <h6 class="fw-bold mb-1">No activity recorded</h6>--}}
{{--                            <small class="text-muted">Once activities are added, they appear here.</small>--}}
{{--                        </div>--}}
{{--                    </div>--}}

                </div>
            </div>

        </div>

    </div>

@endsection

@pushonce('modal')
    <!-- TAG MODAL -->
    <div class="modal fade" id="addTagModal" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Tag</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control" placeholder="Enter tag…">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
    @if(auth()->user()->can('add note') || auth()->user()->can('edit note'))
        <!-- NOTE MODAL -->
        <div class="modal fade" id="addNoteModal" tabindex="-1">
            <div class="modal-dialog">
                <form class="modal-content" id="addNoteForm">
                    @csrf
                    <input type="hidden" name="lead_id" value="{{$lead->id}}">
                    <input type="hidden" name="user_id" value="{{$lead->user_id}}">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Note</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3 type">
                            <label for="type">Note Type</label><span class="text-danger">*</span>
                            <select name="type" class="form-select" id="type">
                                <option value=""></option>
                                @foreach($noteTypes as $key => $value)
                                    <optgroup label="{{$key}}">
                                        @foreach($value as $type)
                                            <option value="{{$type['note_type']}}">{{$type['note_type']}}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>
                        <small class="text-muted">
                            <span id="char_count">0</span>/2000 characters
                        </small>
                        <textarea name="description" id="description" class="form-control" rows="4" maxlength="2000" placeholder="Enter optional note…"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary add-note-form-submit">Save Note</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- UPLOAD DOCUMENT MODAL -->
    <div class="modal fade" id="uploadDocumentModal" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content" enctype="multipart/form-data">

                <div class="modal-header">
                    <h5 class="modal-title">Upload Document</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <label class="fw-semibold mb-2">Choose File</label>
                    <input type="file" class="form-control mb-3" required>

                    <label class="fw-semibold mb-2">Description (Optional)</label>
                    <textarea class="form-control" rows="3" placeholder="Example: Client’s valid ID, proof of income"></textarea>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary">Upload</button>
                </div>

            </form>
        </div>
    </div>
    @if(auth()->user()->can('add appointment') || auth()->user()->can('edit appointment'))
        <!-- ADD APPOINTMENT MODAL -->
        <div class="modal fade" id="addAppointmentModal" tabindex="-1">
            <div class="modal-dialog">
                <form class="modal-content" id="appointment-form">
                    @csrf
                    <input type="hidden" name="lead_id" value="{{$lead->id}}">
                    <div class="modal-header">
                        <h5 class="modal-title">Set Appointment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="form-group mb-3">
                            <label class="fw-semibold">Appointment Type</label>
                            <select name="appointment_type" class="form-select">
                                <option value="">-- select type --</option>
                                @foreach($appointmentTypes as $key => $value)
                                    <option value="{{$key}}">{{$value['label']}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label class="fw-semibold">Appointment Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Ex. Tripping at Mansfield" >
                        </div>

                        <div class="form-group mb-3">
                            <label class="fw-semibold">Date</label>
                            <input type="datetime-local" name="appointment_date" class="form-control" >
                        </div>

                        <div class="form-group mb-3">
                            <label class="fw-semibold">Assign Agent</label>
                            <select name="assigned_agent" id="assigned_agent" class="form-select input-box">
                                <option value="">Select Agent</option>
                                @foreach($agents as $agent)
                                    <option value="{{ $agent->id }}" @if($agent->id === $lead->assigned_agent) selected @endif>{{ $agent->full_name }} - {{$agent->email}}</option>
                                @endforeach
                            </select>

                        </div>


                        <div class="form-group mb-3">
                            <label class="fw-semibold">Location (Optional)</label>
                            <input type="text" name="location" class="form-control" placeholder="Ex. Mansfield Tarlac Gate">
                        </div>

                        <div class="form-group mb-3">
                            <label class="fw-semibold">Notes (Optional)</label>
                            <textarea class="form-control" name="notes" rows="3" placeholder="Additional instructions…"></textarea>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Appointment</button>
                    </div>

                </form>
            </div>
        </div>
    @endif
@endpushonce

@pushonce('scripts')
    @vite(['resources/js/dashboard/notes/create.js','resources/js/dashboard/notes/editNote.js','resources/js/dashboard/leads/edit.js'])
@endpushonce
