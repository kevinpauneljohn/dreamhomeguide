@extends('dashboard.layouts.app')

@section('title', $title)

@section('content')

<!-- Page Header -->
<span data-project-id="{{$project->id}}" id="project"></span>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-0 project-name"></h3>
                <small class="text-muted">
                    {{ $project->address ?? 'No address provided' }}
                </small>
            </div>

            <div class="d-flex gap-2">
                @can('edit project')
                    <button data-project-id="{{$project->id}}" class="btn btn-outline-primary edit-project" id="edit-project-btn">
                        Edit Project
                    </button>
                @endcan

                @can('delete project')
                    <button data-project-id="{{$project->id}}" class="btn btn-outline-danger delete-project" id="delete-project-btn">
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
                <li class="breadcrumb-item active project-name">
{{--                    {{ $project->name }}--}}
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
                <p class="fw-semibold mb-0 project-slug"></p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body">
                <h6 class="text-muted mb-1">Created</h6>
                <p class="fw-semibold mb-0 project-created-at">
{{--                    {{ $project->created_at->format('M d, Y h:i A') }}--}}
                </p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body project-status ">
            </div>
        </div>
    </div>

</div>

<div class="card mb-4">
    <div class="card-header bg-light fw-semibold">
        Project Description
    </div>

    <div class="card-body project-description">

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

@pushonce('modal')
    <div class="modal fade" id="projectModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form class="modal-content" id="project-form">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="fw-semibold mb-2">Name</label>
                        <input type="text" name="name" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="fw-semibold mb-2">Slug</label>
                        <input type="text" name="slug" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="fw-semibold mb-2">Address</label>
                        <input type="text" name="address" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="fw-semibold mb-2">Description</label>
                        <textarea name="description" class="form-control" rows="8"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="fw-semibold mb-2">Status</label>
                        <select name="status" class="form-select">
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="save-project-btn">Save</button>
                </div>

            </form>
        </div>
    </div>
@endpushonce


@push('scripts')
    @vite(['resources/js/dashboard/projects/show.js'])
@endpush
