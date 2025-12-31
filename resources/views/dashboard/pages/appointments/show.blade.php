@extends('dashboard.layouts.app')

@section('title', 'Appointment Details')

@section('content')
    <div class="container-fluid py-4">

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-2">
            <ol class="breadcrumb small mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('crm.index') }}" class="text-decoration-none">Leads</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('leads.show',['lead' => $appointment->lead_id]) }}" class="text-decoration-none">
                        {{ $appointment->lead->full_name ?? 'Client' }}
                    </a>
                </li>
                <li class="breadcrumb-item active">Appointment</li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">Appointment Details</h2>
                <div class="text-muted small">
                    Review schedule, participants, and internal notes
                </div>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('appointment.index') }}"
                   class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
                <a href="{{ route('leads.show', $appointment->lead_id) }}" class="btn btn-primary px-4">
                    View Lead
                </a>
            </div>

        </div>

        <!-- Main Container -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">

                <!-- Title + Meta -->
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h4 class="fw-bold mb-1">{{ $appointment->title }}</h4>
                        <div class="text-muted small">
                            {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y | h:i A') }}
                            • {{ ucfirst($appointment->appointment_type) }}
                        </div>
                    </div>

                    <span class="badge rounded-pill px-3 py-2
                    @if($appointment->status === 'scheduled') bg-primary
                    @elseif($appointment->status === 'done') bg-success
                    @elseif($appointment->status === 'cancelled') bg-danger
                    @else bg-secondary
                    @endif
                ">
                    {{ ucfirst($appointment->status) }}
                </span>
                </div>

                <!-- Section: Schedule -->
                <div class="mb-4">
                    <h6 class="fw-semibold text-uppercase text-muted mb-3">
                        Schedule Information
                    </h6>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded-3 h-100">
                                <div class="small text-muted mb-1">Date & Time</div>
                                <div class="fw-semibold">
                                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y | h:i A') }}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded-3 h-100">
                                <div class="small text-muted mb-1">Location</div>
                                <div class="fw-semibold">
                                    {{ $appointment->location }}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded-3 h-100">
                                <div class="small text-muted mb-1">Type</div>
                                <div class="fw-semibold text-capitalize">
                                    {{ $appointment->appointment_type }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section: Participants -->
                <div class="mb-4">
                    <h6 class="fw-semibold text-uppercase text-muted mb-3">
                        Participants
                    </h6>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="p-3 border rounded-3 h-100">
                                <div class="small text-muted mb-1">Created By</div>
                                <div class="fw-semibold">
                                    {{ ucwords(strtolower($appointment->user->full_name)) ?? '—' }}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="p-3 border rounded-3 h-100">
                                <div class="small text-muted mb-1">Assigned Agent</div>
                                <div class="fw-semibold">
                                    {{ ucwords(strtolower($appointment->agent->full_name)) ?? 'Unassigned' }}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="p-3 border rounded-3 h-100">
                                <div class="small text-muted mb-1">Lead</div>
                                <div class="fw-semibold">
                                    {{ ucwords(strtolower($appointment->lead->full_name)) ?? '—' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section: Notes -->
                <div>
                    <h6 class="fw-semibold text-uppercase text-muted mb-3">
                        Notes
                    </h6>

                    <div class="p-4 bg-light rounded-3">
                        {!! e($appointment->notes ?? 'No notes provided.') !!}
                    </div>
                </div>

            </div>

            <!-- Footer Actions -->
            <div class="card-footer bg-white border-top d-flex justify-content-end gap-2 px-4 py-3">

                <a href="{{ route('appointment.edit', $appointment->id) }}"
                   class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-pencil"></i> Edit
                </a>

                <form action="{{ route('appointment.destroy', $appointment->id) }}"
                      method="POST"
                      onsubmit="return confirm('Delete this appointment? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </form>

            </div>
        </div>
    </div>
@endsection
