@extends('dashboard.layouts.app')

@section('title', $title)
@section('content')

    @can('view appointment')
        <!-- Calendar -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <span class="badge bg-primary rounded-pill m-1">Tripping</span>
                    <span class="badge bg-warning rounded-pill m-1">Follow Up</span>
                    <span class="badge bg-success rounded-pill m-1">Assistance</span>
                    <span class="badge bg-danger rounded-pill m-1">Reservations</span>
                    <span class="badge rounded-pill m-1" style="background-color: #6f42c1">Send Update</span>
                    <select class="form-select form-select-sm ms-auto w-25" aria-label="Default select example" id="view-appointments-filter">
                        <option value="all">All</option>
                        <option value="self" selected>My Appointments</option>
                    </select>
                </div>
                <!-- calendar here -->
                <div id="my-calendar"></div>
                <div id="app-user-id" data-user-id="{{auth()->id()}}"></div>
            </div>
        </div>
    @endcan
@endsection

@push('modal')
    @if(auth()->user()->can('add appointment') || auth()->user()->can('edit appointment'))
        <!-- ADD APPOINTMENT MODAL -->
        <div class="modal fade" id="addAppointmentModal" tabindex="-1">
            <div class="modal-dialog">
                <form class="modal-content" id="appointment-form">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Set Appointment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label class="fw-semibold">Leads</label>
                            <select name="lead_id" class="form-select">
                                <option value="">-- select a lead --</option>
                                @foreach($leads as $lead)
                                    <option value="{{$lead->id}}">{{$lead->full_name}}</option>
                                @endforeach
                            </select>
                        </div>

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
                                    <option value="{{ $agent->id }}">{{ $agent->full_name }} - {{$agent->email}}</option>
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

                        <div class="form-group mb-3 create-task d-none">
                            <input class="form-check-input" name="task" type="checkbox" value="create" id="create-task-input" checked>
                            <label class="form-check-label" for="checkDefault">
                                Create a task for this appointment
                            </label>
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
@endpush

@push('scripts')
    @vite('resources/js/component/appointment/my-calendar.js')
@endpush


