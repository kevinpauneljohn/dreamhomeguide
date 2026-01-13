@extends('dashboard.layouts.app')

@section('title', $title)

@section('content')

<!-- Page Header -->

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-0">{{ $project->name }}</h3>
                <small class="text-muted">
                    {{ $project->address ?? 'No address provided' }}
                </small>
            </div>

            <div class="d-flex gap-2">
                @can('edit project')
                    <button class="btn btn-outline-primary" id="edit-project-btn">
                        Edit Project
                    </button>
                @endcan

                @can('delete project')
                    <button class="btn btn-outline-danger" id="delete-project-btn">
                        Delete
                    </button>
                @endcan
            </div>
        </div>


<!-- Breadcrumb -->
<div class="card mb-4">
    <div class="card-body py-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('project.index') }}">Projects</a>
                </li>
                <li class="breadcrumb-item active">
                    {{ $project->name }}
                </li>
            </ol>
        </nav>
    </div>
</div>


<div class="row g-4 mb-4">

    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body">
                <h6 class="text-muted mb-1">Slug</h6>
                <p class="fw-semibold mb-0">{{ $project->slug }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body">
                <h6 class="text-muted mb-1">Created</h6>
                <p class="fw-semibold mb-0">
                    {{ $project->created_at->format('M d, Y h:i A') }}
                </p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body">
                <h6 class="text-muted mb-1">Status</h6>
                <span class="badge bg-success">Active</span>
            </div>
        </div>
    </div>

</div>

<div class="card mb-4">
    <div class="card-header bg-light fw-semibold">
        Project Description
    </div>

    <div class="card-body">
        @if($project->description)
            <p class="mb-0">{{ $project->description }}</p>
        @else
            <p class="text-muted mb-0">No description provided.</p>
        @endif
    </div>
</div>

<div class="card">
    <div class="card-body">

        <ul class="nav nav-tabs mb-3" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#overview">
                    Overview
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#activity">
                    Activity Logs
                </button>
            </li>
        </ul>

        <div class="tab-content">

            <div class="tab-pane fade show active" id="overview">
                <p class="text-muted mb-0">
                    Project overview details can go here.
                </p>
            </div>

            <div class="tab-pane fade" id="activity">
                <p class="text-muted mb-0">
                    Activity logs will be loaded via AJAX.
                </p>
            </div>

        </div>

    </div>
</div>

@endsection


{{--@push('scripts')--}}
{{--    @vite(['resources/js/dashboard/roles/roles-table.js'])--}}
{{--@endpush--}}
