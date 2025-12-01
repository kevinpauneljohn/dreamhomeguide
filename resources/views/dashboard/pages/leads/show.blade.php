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
                    {{ $lead->full_name }}
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

                <small class="text-muted">Created on {{ $lead->created_at->format('M d, Y') }}</small>
            </div>
        </div>
    </div>

    <div class="row g-4">

        <!-- LEFT COLUMN -->
        <div class="col-lg-8">

            <!-- CONTACT & PERSONAL DETAILS -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="fw-bold mb-0">Lead Details</h5>
                </div>

                <div class="card-body">

                    <!-- Editable Grid -->
                    <div class="row">

                        <!-- Email -->
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Email</label>
                            <div class="editable-field" data-field="email">
                                <span class="value">{{ $lead->email }}</span>
                                <i class="bi bi-pencil edit-icon"></i>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Phone</label>
                            <div class="editable-field" data-field="phone">
                                <span class="value">{{ $lead->phone }}</span>
                                <i class="bi bi-pencil edit-icon"></i>
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Address</label>
                            <div class="editable-field" data-field="address">
                                <span class="value">{{ $lead->address }}</span>
                                <i class="bi bi-pencil edit-icon"></i>
                            </div>
                        </div>

                        <!-- Birthday -->
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Birthday</label>
                            <div class="editable-field" data-field="birthday">
                                <span class="value">{{ $lead->birthday->format('M d, Y') }}</span>
                                <i class="bi bi-pencil edit-icon"></i>
                            </div>
                        </div>

                        <!-- Gender -->
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Gender</label>
                            <p class="fw-semibold">{{ $lead->gender }}</p>
                        </div>

                        <!-- Civil Status -->
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Civil Status</label>
                            <p class="fw-semibold">{{ $lead->civil_status }}</p>
                        </div>

                        <!-- Income -->
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Income Range</label>
                            <p class="fw-semibold">{{ $lead->income_range }}</p>
                        </div>

                        <!-- Lead Source -->
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Source</label>
                            <p class="fw-semibold">{{ $lead->source }}</p>
                        </div>

                        <!-- Assigned Agent -->
                        <div class="col-md-12 mb-3">
                            <label class="text-muted small">Assigned Agent</label>
                            <p class="fw-semibold">{{ $lead->user->full_name ?? 'Unassigned' }}</p>
                        </div>

                    </div>

                </div>
            </div>

            <!-- NOTES -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header d-flex justify-content-between bg-white border-bottom-0">
                    <h5 class="fw-bold mb-0">Notes</h5>

                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addNoteModal">
                        <i class="bi bi-plus-circle me-1"></i> Add Note
                    </button>
                </div>

{{--                <div class="card-body">--}}
{{--                    <p class="text-muted">No notes added yet.</p>--}}
{{--                </div>--}}

                <div class="card-body">
                    <table class="table table-hover align-middle notes-table">
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

                        <!-- CALL NOTE -->
                        <tr>
                            <td>
                                <div class="note-type-icon call"><i class="bi bi-telephone-fill"></i></div>
                            </td>

                            <td>
                                <h6 class="fw-bold mb-1">Call Attempt</h6>
                                <p class="note-text mb-0">
                                    Called the client to confirm site tripping schedule. Client prefers Saturday morning.
                                </p>
                            </td>

                            <td>
                                <small class="text-muted">Jan 22, 2025 • 2:18 PM</small>
                            </td>

                            <td>
                                <small><strong>Andrea Santos</strong></small>
                            </td>

                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border-0" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item">Edit</a></li>
                                        <li><a class="dropdown-item text-danger">Delete</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>

                        <!-- MESSAGE NOTE -->
                        <tr>
                            <td>
                                <div class="note-type-icon message"><i class="bi bi-chat-dots-fill"></i></div>
                            </td>

                            <td>
                                <h6 class="fw-bold mb-1">Follow-Up Message Sent</h6>
                                <p class="note-text mb-0">
                                    Sent follow-up message through Messenger. Client has read it but did not reply yet.
                                </p>
                            </td>

                            <td>
                                <small class="text-muted">Jan 18, 2025 • 5:52 PM</small>
                            </td>

                            <td>
                                <small><strong>John Kevin</strong></small>
                            </td>

                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border-0" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item">Edit</a></li>
                                        <li><a class="dropdown-item text-danger">Delete</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>

                        <!-- MEETING NOTE -->
                        <tr>
                            <td>
                                <div class="note-type-icon meeting"><i class="bi bi-calendar-event-fill"></i></div>
                            </td>

                            <td>
                                <h6 class="fw-bold mb-1">Site Viewing Scheduled</h6>
                                <p class="note-text mb-0">
                                    Scheduled site viewing at Mansfield Tarlac. Client confirmed attendance for Saturday.
                                </p>
                            </td>

                            <td>
                                <small class="text-muted">Jan 15, 2025 • 11:30 AM</small>
                            </td>

                            <td>
                                <small><strong>Andrea Santos</strong></small>
                            </td>

                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border-0" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item">Edit</a></li>
                                        <li><a class="dropdown-item text-danger">Delete</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>

                        <!-- GENERAL NOTE -->
                        <tr>
                            <td>
                                <div class="note-type-icon note"><i class="bi bi-journal-text"></i></div>
                            </td>

                            <td>
                                <h6 class="fw-bold mb-1">Initial Interest Note</h6>
                                <p class="note-text mb-0">
                                    Lead entered via Facebook Ads. Estimated budget ₱2M–₱3M. Recommended Fiesta Communities & Highview.
                                </p>
                            </td>

                            <td>
                                <small class="text-muted">Jan 10, 2025 • 10:12 AM</small>
                            </td>

                            <td>
                                <small><strong>System</strong></small>
                            </td>

                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border-0" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item text-danger">Delete</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>

                        </tbody>
                    </table>


                </div>


            </div>

            <!-- APPOINTMENTS -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header d-flex justify-content-between align-items-center bg-white border-bottom-0">
                    <h5 class="fw-bold mb-0">Appointments</h5>

                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addAppointmentModal">
                        <i class="bi bi-calendar-plus me-1"></i> Set Appointment
                    </button>
                </div>

                <div class="card-body">

                    <!-- Appointment Calendar -->
                    <div class="calendar-wrapper mb-4">
                        <div id="appointmentCalendar"></div>
                    </div>

                    <!-- Appointment Table -->
                    <table class="table table-hover align-middle appointments-table">
                        <thead class="table-light">
                        <tr>
                            <th width="60">Type</th>
                            <th>Appointment</th>
                            <th width="200">Date</th>
                            <th width="150">Status</th>
                            <th class="text-center" width="40"></th>
                        </tr>
                        </thead>

                        <tbody>

                        <!-- SAMPLE UPCOMING APPOINTMENT -->
                        <tr>
                            <td>
                                <div class="appt-type-icon meeting">
                                    <i class="bi bi-people-fill"></i>
                                </div>
                            </td>

                            <td>
                                <h6 class="fw-bold mb-1">Site Viewing — Mansfield Tarlac</h6>
                                <p class="mb-0 appt-text">Client wants to check 3BR model units.</p>
                            </td>

                            <td>
                                <small class="text-muted">Feb 02, 2025 • 10:00 AM</small>
                            </td>

                            <td>
                                <span class="badge bg-warning text-dark">Upcoming</span>
                            </td>

                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border-0" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item">Edit</a></li>
                                        <li><a class="dropdown-item text-danger">Cancel</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>

                        <!-- SAMPLE PAST -->
                        <tr>
                            <td>
                                <div class="appt-type-icon call">
                                    <i class="bi bi-telephone-fill"></i>
                                </div>
                            </td>

                            <td>
                                <h6 class="fw-bold mb-1">Follow-up Call</h6>
                                <p class="mb-0 appt-text">Discussed Pag-IBIG financing details.</p>
                            </td>

                            <td>
                                <small class="text-muted">Jan 25, 2025 • 3:00 PM</small>
                            </td>

                            <td>
                                <span class="badge bg-success">Completed</span>
                            </td>

                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border-0" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item">View</a></li>
                                        <li><a class="dropdown-item text-danger">Delete</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>

                        </tbody>
                    </table>

                </div>
            </div>


        </div>

        <!-- RIGHT COLUMN (Sticky Sidebar) -->
        <div class="col-lg-4">
            <!-- FILES & DOCUMENTS -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header d-flex justify-content-between align-items-center bg-white border-bottom-0">
                    <h5 class="fw-bold mb-0">Files & Documents</h5>

                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#uploadDocumentModal">
                        <i class="bi bi-upload me-1"></i> Upload File
                    </button>
                </div>

                <div class="card-body">

                    <!-- If no documents -->
                    <!-- <p class="text-muted">No documents uploaded yet.</p> -->

                    <table class="table table-hover align-middle documents-table">
                        <thead class="table-light">
                        <tr>
                            <th width="60">Type</th>
                            <th>File Name</th>
                            <th width="160">Size</th>
                            <th width="180">Uploaded</th>
                            <th class="text-center" width="60"></th>
                        </tr>
                        </thead>

                        <tbody>

                        <!-- EXAMPLE PDF -->
                        <tr>
                            <td>
                                <div class="file-type-icon pdf">
                                    <i class="bi bi-file-earmark-pdf-fill"></i>
                                </div>
                            </td>
                            <td>
                                <strong>Buyer_Reservation_Form.pdf</strong>
                            </td>
                            <td>
                                <small class="text-muted">1.2 MB</small>
                            </td>
                            <td>
                                <small class="text-muted">Jan 18, 2025 • by <strong>John Kevin</strong></small>
                            </td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border-0" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item">Download</a></li>
                                        <li><a class="dropdown-item text-danger">Delete</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>

                        <!-- EXCEL -->
                        <tr>
                            <td>
                                <div class="file-type-icon excel">
                                    <i class="bi bi-file-earmark-excel-fill"></i>
                                </div>
                            </td>
                            <td>
                                <strong>Income_Documentation.xlsx</strong>
                            </td>
                            <td>
                                <small class="text-muted">450 KB</small>
                            </td>
                            <td>
                                <small class="text-muted">Jan 15, 2025 • by <strong>Andrea Santos</strong></small>
                            </td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border-0" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item">Download</a></li>
                                        <li><a class="dropdown-item text-danger">Delete</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>

                        <!-- IMAGE -->
                        <tr>
                            <td>
                                <div class="file-type-icon image">
                                    <i class="bi bi-file-image-fill"></i>
                                </div>
                            </td>
                            <td>
                                <strong>Valid_ID.jpg</strong>
                            </td>
                            <td>
                                <small class="text-muted">280 KB</small>
                            </td>
                            <td>
                                <small class="text-muted">Jan 10, 2025 • by <strong>System</strong></small>
                            </td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border-0" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item">Download</a></li>
                                        <li><a class="dropdown-item text-danger">Delete</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>

                        </tbody>
                    </table>

                </div>
            </div>

            <div class="card shadow-sm border-0 sticky-top" style="top: 90px">

                <div class="card-header bg-white border-bottom-0">
                    <h5 class="fw-bold mb-0">Activity Timeline</h5>
                </div>

                <div class="card-body" style="max-height: 500px; overflow-y: auto;">

                    <div class="timeline-item d-flex gap-3 mb-4">
                        <div class="timeline-icon bg-primary text-white">
                            <i class="bi bi-hourglass-split display-5"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">No activity recorded</h6>
                            <small class="text-muted">Once activities are added, they appear here.</small>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>

    <!-- TAG MODAL -->
    <div class="modal fade" id="addTagModal" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Tag</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control" placeholder="Enter tag…">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>

    <!-- NOTE MODAL -->
    <div class="modal fade" id="addNoteModal" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Note</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <textarea class="form-control" rows="4" placeholder="Enter note…" required></textarea>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary">Save Note</button>
                </div>
            </form>
        </div>
    </div>

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

    <!-- ADD APPOINTMENT MODAL -->
    <div class="modal fade" id="addAppointmentModal" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Set Appointment</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <label class="fw-semibold">Appointment Title</label>
                    <input type="text" class="form-control mb-3" placeholder="Ex. Tripping at Mansfield" required>

                    <label class="fw-semibold">Date</label>
                    <input type="date" class="form-control mb-3" required>

                    <label class="fw-semibold">Time</label>
                    <input type="time" class="form-control mb-3" required>

                    <label class="fw-semibold">Location (Optional)</label>
                    <input type="text" class="form-control mb-3" placeholder="Ex. Mansfield Tarlac Gate">

                    <label class="fw-semibold">Notes (Optional)</label>
                    <textarea class="form-control" rows="3" placeholder="Additional instructions…"></textarea>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary">Save Appointment</button>
                </div>

            </form>
        </div>
    </div>


@endsection

@push('styles')
    <style>

        /* Profile avatar gradient ring */
        .profile-ring {
            background: conic-gradient(#0d6efd, #6f42c1, #0d6efd);
            padding: 4px;
            border-radius: 50%;
            width: 105px;
            height: 105px;
            display:flex;
            align-items:center;
            justify-content:center;
        }
        .profile-photo {
            border-radius: 50%;
            width: 95px;
            height: 95px;
        }

        /* Tags */
        .badge {
            font-size: 13px;
        }

        /* Editable fields */
        .editable-field {
            display: flex;
            justify-content: space-between;
            align-items:center;
            padding: 10px 12px;
            border: 1px solid #e6e6e6;
            border-radius: 8px;
            cursor: pointer;
            transition: .2s;
        }
        .editable-field:hover {
            background:#f8f9fa;
        }
        .edit-icon {
            font-size: 16px;
            color:#777;
        }

        /* Timeline */
        .timeline-icon {
            width: 40px;
            height:40px;
            border-radius:50%;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:18px;
        }

        .lead-score {
            font-size: 14px;
        }

        .notes-table td,
        .notes-table th {
            vertical-align: top;
            padding: 14px 12px;
        }

        .note-type-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:17px;
            color:white;
        }

        /* TYPES */
        .note-type-icon.call {
            background:#0d6efd;
        }
        .note-type-icon.message {
            background:#6f42c1;
        }
        .note-type-icon.meeting {
            background:#198754;
        }
        .note-type-icon.note {
            background:#6c757d;
        }

        .note-text {
            font-size: 14px;
            line-height: 1.5;
        }

        .dropdown .btn {
            padding: 4px 6px;
            border-radius: 6px;
        }

        .table-hover tbody tr:hover {
            background:#f8f9fa;
        }

        /*appointment*/
        /* Appointment table layout */
        .appointments-table td,
        .appointments-table th {
            vertical-align: top;
            padding: 14px 12px;
        }

        /* Icons */
        .appt-type-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:17px;
            color:white;
        }

        .appt-type-icon.meeting {
            background:#0d6efd;
        }
        .appt-type-icon.call {
            background:#6f42c1;
        }
        .appt-type-icon.other {
            background:#6c757d;
        }

        .appt-text {
            font-size: 14px;
            line-height: 1.5;
        }

        /* Simple lightweight calendar */
        .calendar-wrapper {
            background:#f8f9fa;
            border-radius:8px;
            padding:15px;
            border:1px solid #eee;
        }

        #appointmentCalendar {
            display:grid;
            grid-template-columns: repeat(7, 1fr);
            gap:6px;
        }

        #appointmentCalendar div {
            background:white;
            border:1px solid #ddd;
            padding:10px;
            border-radius:6px;
            text-align:center;
            font-size:14px;
            cursor:pointer;
            transition:.2s;
        }

        #appointmentCalendar div:hover {
            background:#0d6efd;
            color:white;
        }



    </style>
@endpush
