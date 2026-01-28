@extends('dashboard.layouts.app')

@section('title', $title)

@section('content')
    <div class="container-fluid">

        <!-- PAGE HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1">{{$title}}</h4>
                <small class="text-muted">
                    Add a task to track follow-ups, appointments, and internal actions
                </small>
            </div>

            <div class="d-flex gap-2">
                <a onclick="window.history.back()" class="btn btn-outline-secondary">
                    Back
                </a>
                <button type="submit" form="createTaskForm" class="btn btn-primary save-task">
                    Save Task
                </button>
            </div>
        </div>

        <!-- FORM -->
        <form id="createTaskForm" method="POST" action="{{ route('task.store') }}">
            @csrf

            <input type="hidden" name="link" value="{{request('type')}}">

            <div class="row g-4">

                <!-- LEFT COLUMN -->
                <div class="col-lg-8">

                    <!-- TASK DETAILS -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h6 class="fw-semibold mb-3">Task Details</h6>

                            <div class="mb-3">
                                <label class="form-label">
                                    Task Title <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       name="title"
                                       class="form-control"
                                       placeholder="e.g. Send sample computation"
                                       value="@if(request('type') === 'appointment' && request()->has('id')) {{ucwords($appointment->title)}} @endif"
                                       >
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description"
                                          class="form-control"
                                          rows="8"
                                          placeholder="Add notes or instructions for this task">@if(request('type') === 'appointment' && request()->has('id')){{$appointment->notes}}@endif</textarea>
                            </div>

                            <div>
                                <label class="form-label">Task Type</label>
                                <select name="type" class="form-select">
                                    <option value=""></option>
                                    <option value="follow_up">Follow-up</option>
                                    <option value="appointment">Appointment</option>
                                    <option value="call">Call</option>
                                    <option value="meeting">Meeting</option>
                                    <option value="documentation">Documentation</option>
                                    <option value="internal">Internal Task</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- SCHEDULE & PRIORITY -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h6 class="fw-semibold mb-3">Schedule & Priority</h6>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Due Date</label>
                                    <input type="datetime-local"
                                           name="due_date"
                                           class="form-control"
                                            value="@if(request('type') === 'appointment' && request()->has('id')){{$appointment->appointment_date}}@endif">
                                </div>


                                <div class="col-md-6">
                                    <label class="form-label">Priority</label>
                                    <select name="priority" class="form-select">
                                        <option value=""></option>
                                        <option value="low">Low</option>
                                        <option value="medium">Medium</option>
                                        <option value="high">High</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- LINK TASK TO -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h6 class="fw-semibold mb-3">Link Task To</h6>

                            <div class="mb-3">
                                <label class="form-label">Linked Type</label>
                                <select name="linked_type" id="linkedType" class="form-select">
                                    <option value="">None</option>
                                    <option value="lead">Lead</option>
                                    <option value="appointment" @if(request('appointment')) selected @endif>Appointment</option>
                                </select>
                            </div>

                            <div>
                                <label class="form-label">Linked Record</label>
                                <select name="linked_id"
                                        id="linkedRecord"
                                        class="form-select"
                                        disabled>
                                    <option value="">Select linked record</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- RIGHT COLUMN -->
                <div class="col-lg-4">

                    <!-- ASSIGNMENT -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h6 class="fw-semibold mb-3">Assignment</h6>

                            <div class="mb-3">
                                <label class="form-label">Assign To</label>
                                <select name="assigned_to" class="form-select">
                                    @foreach($agents ?? [] as $agent)
                                        <option value="{{ $agent->id }}" @if(request('type') === 'appointment' && request()->has('id')) @if($appointment->assigned_agent == $agent->id)selected @endif @endif>
                                            {{ ucwords(strtolower($agent->full_name)) }} ({{ $agent->getRoleNames()->first() ?? 'User' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="form-label">Created By</label>
                                <input type="text"
                                       class="form-control"
                                       value="{{ auth()->user()->full_name }}"
                                       disabled>
                            </div>
                        </div>
                    </div>


                    <!-- VISIBILITY -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h6 class="fw-semibold mb-3">Visibility</h6>

                            <div class="form-check">
                                <input class="form-check-input"
                                       type="checkbox"
                                       name="is_public"
                                       checked>
                                <label class="form-check-label">
                                    Visible to assigned user
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input"
                                       type="checkbox"
                                       name="visible_to_managers">
                                <label class="form-check-label">
                                    Visible to managers
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input"
                                       type="checkbox"
                                       name="is_private">
                                <label class="form-check-label">
                                    Private task
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h6 class="fw-semibold mb-3">Trigger Appointment Status Completion</h6>

                            <div class="form-check">
                                <input class="form-check-input"
                                       type="checkbox"
                                       name="complete_appointment"
                                       disabled
                                       >
                                <label class="form-check-label">
                                    Enable Appointment Status Completion
                                </label>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- FOOTER ACTIONS -->
            <div class="d-flex justify-content-end gap-2 mt-4 mb-4">
                <a onclick="window.history.back()" class="btn btn-outline-secondary">
                    Back
                </a>
{{--                <button type="submit" name="create_another" value="1" class="btn btn-outline-primary">--}}
{{--                    Save & Create Another--}}
{{--                </button>--}}
                <button type="submit" id="submitTaskBtn" class="btn btn-primary save-task">
                    Save Task
                </button>
            </div>

        </form>

    </div>
@endsection

@push('scripts')
    @vite(['resources/js/dashboard/tasks/create.js','resources/js/dashboard/tasks/enable-status-completion.js'])
    @vite(['resources/js/dashboard/tasks/enable-status-completion.js'])
@endpush
