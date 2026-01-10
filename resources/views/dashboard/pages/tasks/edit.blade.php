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
                <a href="{{ route('task.index') }}" class="btn btn-outline-secondary">
                    Cancel
                </a>
                <button type="submit" form="createTaskForm" class="btn btn-primary">
                    Update Task
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
                                       value="{{$task->title}}"
                                >
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description"
                                          class="form-control"
                                          rows="8"
                                          placeholder="Add notes or instructions for this task">{{$task->description}}</textarea>
                            </div>

                            <div>
                                <label class="form-label">Task Type</label>
                                <select name="type" class="form-select">
                                    <option value=""></option>
                                    <option value="follow_up" @if($task->type == 'follow_up')selected @endif>Follow-up</option>
                                    <option value="appointment" @if($task->type == 'appointment')selected @endif>Appointment</option>
                                    <option value="call" @if($task->type == 'call')selected @endif>Call</option>
                                    <option value="meeting" @if($task->type == 'meeting')selected @endif>Meeting</option>
                                    <option value="documentation" @if($task->type == 'documentation')selected @endif>Documentation</option>
                                    <option value="internal" @if($task->type == 'internal')selected @endif>Internal Task</option>
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
                                           value="{{$task->due_date}}">
                                </div>


                                <div class="col-md-6">
                                    <label class="form-label">Priority</label>
                                    <select name="priority" class="form-select">
                                        <option value=""></option>
                                        <option value="low" @if($task->priority == 'low')selected @endif>Low</option>
                                        <option value="medium" @if($task->priority == 'medium')selected @endif>Medium</option>
                                        <option value="high" @if($task->priority == 'high')selected @endif>High</option>
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
                                    <option value="" @if(is_null($task->lead_id) && is_null($task->appointment_id)) @endif>None</option>
                                    <option value="lead" @if(!is_null($task->lead_id))selected @endif>Lead</option>
                                    <option value="appointment" @if(!is_null($task->appointment_id))selected @endif>Appointment</option>
                                </select>
                            </div>

                            <div>
                                <label class="form-label">Linked Record</label>
                                <input type="hidden" id="link_value" value="{{$task->lead_id ?? $task->appointment_id}}">
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
                                        <option value="{{ $agent->id }}" @if($task->assigned_to == $agent->id)selected @endif>
                                            {{ ucwords(strtolower($agent->full_name)) }} ({{ $agent->getRoleNames()->first() ?? 'User' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>

                                <label class="form-label">Created By</label>
                                <input type="text"
                                       class="form-control"
                                       value="{{ $task->creator ? $task->creator->full_name : ''}}"
                                       disabled>
                            </div>
                        </div>
                    </div>

                    <!-- VISIBILITY -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h6 class="fw-semibold mb-3">Visibility</h6>

                            <div class="form-check">
                                <input class="form-check-input"
                                       type="checkbox"
                                       name="is_public"
                                       @if($task->is_public)checked @endif>
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

                </div>
            </div>

            <!-- FOOTER ACTIONS -->
            <div class="d-flex justify-content-end gap-2 mt-4 mb-4">
                <a href="{{ route('task.index') }}" class="btn btn-outline-secondary">
                    Cancel
                </a>
                <button type="submit" id="submitTaskBtn" class="btn btn-primary">
                    Update Task
                </button>
            </div>

        </form>

    </div>
@endsection

@push('scripts')
    @vite('resources/js/dashboard/tasks/edit.js')
@endpush
