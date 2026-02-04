@extends('dashboard.layouts.app')

@section('title', $title)

@section('content')
    <div class="container-fluid py-4 sales-create">

        {{-- PAGE HEADER --}}
        <div class="mb-4">
            <small class="text-muted">Sales Management</small>

            <div class="d-flex justify-content-between align-items-center">

                {{-- LEFT: ICON + TITLE --}}
                <div class="d-flex align-items-center gap-2">
                    <i class="fa-solid fa-handshake fs-4 text-primary"></i>
                    <h3 class="fw-bold mb-0">{{$title}}</h3>
                </div>

                {{-- RIGHT: BACK BUTTON --}}
                <a href="{{ route('sales.index') }}"
                   class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1">
                    <i class="fa-solid fa-arrow-left"></i>
                    Back
                </a>

            </div>
        </div>


        <form id="edit-sales-form" data-sales="{{$sales->id}}" novalidate>
            @csrf
            <input type="hidden" name="model_id" value="{{$sales->model_unit_id}}">
            <div class="row g-4">

                {{-- LEFT: SALE DETAILS --}}
                <div class="col-lg-8">
                    <div class="alert alert-success d-none" role="alert">
                        test
                    </div>
                    {{-- CLIENT & PROPERTY --}}
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-0">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fa-solid fa-user text-primary"></i>
                                <h6 class="fw-bold mb-0">Client & Property</h6>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row g-3">

                                {{-- CLIENT --}}
                                <div class="col-md-6">
                                    <label class="form-label">Client / Lead</label> <span class="text-danger">*</span>
                                    <select name="lead_id" id="lead_id" class="form-select" required>
                                        <option value="">Select Client</option>
                                        @foreach($leads as $lead)
                                            <option value="{{$lead->id}}" @if($sales->lead_id === $lead->id)selected @endif>{{$lead->full_name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- AGENT --}}
                                <div class="col-md-6">
                                    <label class="form-label">Assigned Agent</label> <span class="text-danger">*</span>
                                    <select name="user_id" id="user_id" class="form-select" required>
                                        <option value="">Select Agent</option>
                                        @foreach($agents as $agent)
                                            <option value="{{$agent->id}}" @if($sales->user_id === $agent->id)selected @endif>{{$agent->full_name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- PROJECT (NEW) --}}
                                <div class="col-md-6">
                                    <label class="form-label">Project</label> <span class="text-danger">*</span>
                                    <select name="project_id" id="project_id" class="form-select" required>
                                        <option value="">Select Project</option>
                                        @foreach($projects as $project)
                                            <option value="{{ $project->id }}" @if($sales->project_id === $project->id)selected @endif>{{ $project->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- MODEL UNIT --}}
                                <div class="col-md-6">
                                    <label class="form-label">Model Unit</label> <span class="text-danger">*</span>
                                    <select name="model_unit_id" class="form-select" required>
                                        <option value="">Select Model Unit</option>
                                    </select>
                                </div>

                                {{-- RESERVATION DATE --}}
                                <div class="col-md-6">
                                    <label class="form-label">Reservation Date</label> <span class="text-danger">*</span>
                                    <input type="date" name="reservation_date" class="form-control" value="{{ optional($sales->reservation_date)->format('Y-m-d') }}" required>
                                </div>

                                {{-- PHASE --}}
                                <div class="col-md-6">
                                    <label class="form-label">Phase</label>
                                    <input type="text" name="phase" class="form-control" value="{{$sales->phase}}" placeholder="e.g. Phase 2">
                                </div>

                                {{-- BLOCK --}}
                                <div class="col-md-6">
                                    <label class="form-label">Block No.</label> <span class="text-danger">*</span>
                                    <input type="text" name="block_no" class="form-control" value="{{$sales->block_no}}">
                                </div>

                                {{-- LOT --}}
                                <div class="col-md-6">
                                    <label class="form-label">Lot No.</label> <span class="text-danger">*</span>
                                    <input type="text" name="lot_no" class="form-control" value="{{$sales->lot_no}}">
                                </div>

                                {{-- LOT AREA --}}
                                <div class="col-md-6">
                                    <label class="form-label">Lot Area (sqm)</label>
                                    <input type="number" step="0.01" name="lot_area" class="form-control" value="{{$sales->lot_area}}">
                                </div>

                                {{-- FLOOR AREA --}}
                                <div class="col-md-6">
                                    <label class="form-label">Floor Area (sqm)</label>
                                    <input type="number" step="0.01" name="floor_area" class="form-control" value="{{$sales->floor_area}}">
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- REMARKS --}}
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fa-solid fa-note-sticky text-secondary"></i>
                                <h6 class="fw-bold mb-0">Remarks</h6>
                            </div>
                        </div>

                        <div class="card-body">
                        <textarea
                            name="remarks"
                            rows="4"
                            class="form-control"
                            placeholder="Add internal notes, client preferences, or special conditions..."
                        >{{$sales->remarks}}</textarea>
                        </div>
                    </div>

                </div>

                {{-- RIGHT: FINANCIAL SUMMARY --}}
                <div class="col-lg-4">

                    <div class="card border-0 shadow-sm sticky-top" style="top: 90px;">
                        <div class="card-header bg-white border-0">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fa-solid fa-peso-sign text-success"></i>
                                <h6 class="fw-bold mb-0">Financial Details</h6>
                            </div>
                        </div>

                        <div class="card-body">

                            <div class="mb-3">
                                <label class="form-label">Total Contract Price</label> <span class="text-danger">*</span>
                                <input
                                    type="number"
                                    step="0.01"
                                    name="total_contract_price"
                                    class="form-control"
                                    value="{{$sales->total_contract_price}}"
                                    required
                                >
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Down Payment</label>
                                <input type="number" step="0.01" name="down_payment" class="form-control" value="{{$sales->down_payment}}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">DP Terms (months)</label> <span class="text-danger">*</span>
                                <select name="dp_terms" class="form-select">
                                    <option value="">Select Terms</option>
                                    @for($month = 1; $month <= 64; $month++)
                                        <option value="{{$month}}" @if($sales->dp_terms == $month)selected @endif>{{$month}}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Financing</label>
                                <select name="financing" class="form-select">
                                    <option value="">Select Financing</option>
                                    <option value="Pag-IBIG" @if($sales->financing == 'Pag-IBIG')selected @endif>Pag-IBIG</option>
                                    <option value="Bank" @if($sales->financing == 'Bank')selected @endif>Bank</option>
                                    <option value="In-house" @if($sales->financing == 'In-house')selected @endif>In-house</option>
                                    <option value="Spot Cash" @if($sales->financing == 'Spot Cash')selected @endif>Spot Cash</option>
                                    <option value="Deferred Cash" @if($sales->financing == 'Deferred Cash')selected @endif>Cash</option>
                                    <option value="NHMFC" @if($sales->financing == 'NHMFC')selected @endif>NHMFC</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="reserved" @if($sales->status == 'reserved')selected @endif>Reserved</option>
                                    <option value="completed" @if($sales->status == 'completed')selected @endif>Completed</option>
                                    <option value="cancelled" @if($sales->status == 'cancelled')selected @endif>Cancelled</option>
                                </select>
                            </div>

                            <hr>

                            {{-- ACTIONS --}}
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg" id="save-sales-btn">
                                    <i class="fa-solid fa-floppy-disk me-1"></i> Save Sale
                                </button>

                                <a href="{{ route('sales.index') }}" class="btn btn-light">
                                    Cancel
                                </a>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </form>

    </div>
@endsection

@push('css')
    @vite(['resources/css/sales.css'])
@endpush

@push('scripts')
    @vite(['resources/js/dashboard/sales/edit.js'])
@endpush
