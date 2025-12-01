@extends('dashboard.layouts.app')
@section('title', $title)
@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">Add New Lead</h3>
            <small class="text-muted">Input essential information to create a new lead</small>
        </div>

        <a href="{{ route('crm.index') }}" class="btn btn-light border px-4">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('crm.index') }}">CRM</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add New Lead</li>
                </ol>
            </nav>
        </div>
    </div>

    <form id="create-lead-form">
        @csrf

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Lead Information</h5>

                <div class="row">
                    <div class="col-md-6">
                        <div class="row g-3">
                            <div class="col-md-6 first_name">
                                <label class="form-label" for="first_name">First Name <span class="text-danger">*</span></label>
                                <input type="text" name="first_name" id="first_name" class="form-control">
                            </div>

                            <div class="col-md-6 last_name">
                                <label class="form-label" for="last_name">Last Name <span class="text-danger">*</span></label>
                                <input type="text" name="last_name" id="last_name" class="form-control">
                            </div>
                            <div class="col-md-6 email">
                                <label class="form-label">Email Address</label>
                                <input type="email" name="email" id="email" class="form-control">
                            </div>

                            <div class="col-md-6 phone">
                                <label class="form-label" for="phone">Phone Number <span class="text-danger">*</span></label>
                                <input type="text" name="phone" id="phone" class="form-control">
                            </div>
                            <div class="col-md-6 birthday">
                                <label class="form-label" for="birthday">Birthday</label>
                                <input type="date" name="birthday" id="birthday" class="form-control">
                            </div>

                            <div class="col-md-6 gender">
                                <label class="form-label" for="gender">Gender</label>
                                <select name="gender" id="gender" class="form-select">
                                    <option value=""> -- Select an option -- </option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>

                            <div class="col-md-12 civil_status">
                                <label class="form-label" for="civil_status">Civil Status</label>
                                <select name="civil_status" id="civil_status" class="form-select">
                                    <option value=""> -- Select an option -- </option>
                                    <option value="single">Single</option>
                                    <option value="married">Married</option>
                                    <option value="widower">Widower</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row g-3">
                            <div class="col-md-12 status">
                                <div id="lead-status-content" class="d-none">
                                    <ol class="mb-0">
                                        <li><strong>New</strong> – Fresh leads that entered the system and are not yet contacted.</li>
                                        <li><strong>Attempting Contact</strong> – Agent tried calling/texting but has not reached the lead yet.</li>
                                        <li><strong>Contacted</strong> – Lead responded or agent successfully reached the lead.</li>
                                        <li><strong>Follow-Up</strong> – Lead is interested but needs more time or info.</li>
                                        <li><strong>Qualified</strong> – Meets budget, location, timeline, intent.</li>
                                        <li><strong>Needs More Time</strong> – Not ready now but may convert later.</li>
                                        <li><strong>Scheduled for Tripping</strong> – Viewing/tripping scheduled.</li>
                                        <li><strong>Tripping Done</strong> – Waiting for next steps.</li>
                                        <li><strong>Reservation Pending</strong> – Preparing requirements/payment.</li>
                                        <li><strong>Reserved</strong> – Reservation fee paid.</li>
                                        <li><strong>For Documentation</strong> – Processing IDs, COE, payslips.</li>
                                        <li><strong>For Loan Processing</strong> – Bank/Pag-IBIG evaluation.</li>
                                        <li><strong>Approved</strong> – Loan approved.</li>
                                        <li><strong>Not Qualified</strong> – Failed screening.</li>
                                        <li><strong>Closed / Sold</strong> – Lead purchased.</li>
                                        <li><strong>Lost Lead</strong> – Unreachable or bought elsewhere.</li>
                                        <li><strong>Invalid / Spam</strong> – Fake number, wrong info.</li>
                                    </ol>
                                </div>

                                <label class="form-label" for="status">Lead Status</label>
                                <i class="bi bi-question-circle" id="leadStatusPopover" data-bs-title="Lead Status Definition"></i>
                                <select name="status" id="status" class="form-select">
                                    @foreach($leadStatus as $key => $value)
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="col-md-12 source">
                                <label class="form-label" for="source">Lead Source <span class="text-danger">*</span></label>
                                <select name="source" id="source" class="form-select">
                                    <option value="">Select Source</option>
                                    @foreach($sources as $source)
                                        <option value="{{$source}}">{{$source}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-12 user_id">
                                <label class="form-label" for="user_id">Assign to Agent</label>
                                <select name="user_id" id="user_id" class="form-select">
                                    <option value="">Select Agent</option>
                                    @foreach($agents as $agent)
                                        <option value="{{ $agent->id }}">{{ $agent->full_name }} - {{$agent->email}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-12 income_range">
                                <label class="form-label" for="income_range">Income Range</label>
                                <select name="income_range" id="income_range" class="form-select">
                                    <option value=""></option>
                                    @foreach($incomeRange as $range)
                                        <option value="{{ $range }}">{{ $range }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tags -->
        <div class="card shadow-sm mb-4">
            <div class="card-body tags">
                <h5 class="fw-bold mb-3">Tags (Optional)</h5>
{{--                <input type="text" name="tags" id="tags" class="form-control" placeholder="Ex: hot, investor, follow-up">--}}
                <select name="tags[]" id="tags" class="form-select" multiple>
                    <option value="Investor">Investor</option>
                    <option value="Hot Lead">Hot Lead</option>
                    <option value="Follow Up">Follow Up</option>
                    <option value="Site Visit">Site Visit</option>
                    <option value="Messenger Inquiry">Messenger Inquiry</option>
                </select>
                <small class="text-muted">Separate tags with commas</small>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-3 mb-3">
            <a href="{{ route('crm.index') }}" class="btn btn-light border px-4">Cancel</a>
            <button type="submit" class="btn btn-primary px-4 save-lead-button">Create Lead</button>
        </div>

    </form>

@endsection

@push('scripts')
    @vite('resources/js/dashboard/leads/create.js')
@endpush
