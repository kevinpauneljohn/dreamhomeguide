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
    <div class="card-header bg-white border-bottom">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0 fw-semibold">Model Units</h5>
                <small class="text-muted">
                    Manage model units under this project
                </small>
            </div>

            @can('add model unit')
                <button
                    class="btn btn-primary"
                    id="add-model-unit-btn"
                    data-project-id="{{ $project->id }}"
                >
                    <i class="fa fa-plus me-1"></i> Add Model Unit
                </button>
            @endcan
        </div>
    </div>
    <div class="card-body">
        <table id="model-units-table" class="table table-bordered table-hover align-middle w-100">
            <thead class="table-light">
            <tr>
                <th>Model Name</th>
                <th>Type</th>
                <th>Lot Area</th>
                <th>Floor Area</th>
                <th>Status</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
            </thead>
        </table>


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

    <div class="modal fade" id="model-unit-modal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form class="modal-content" id="model-unit-form">
                @csrf
                <input type="hidden" name="project_id" value="{{$project->id}}">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="fw-semibold mb-2">Name</label>
                        <input type="text" name="name" id="model-unit-name" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="fw-semibold mb-2">Slug</label>
                        <input type="text" name="slug" id="model-unit-slug" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="fw-semibold mb-2">Description</label>
                        <textarea name="description" class="form-control" rows="8"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="fw-semibold mb-2">Type</label>
                        <select name="type" class="form-select">
                            <option value=""></option>
                            <option value="single-detached">Single Detached</option>
                            <option value="single-attached">Single Attached</option>
                            <option value="duplex">Duplex</option>
                            <option value="bungalow">Bungalow</option>
                            <option value="condominium">Condominium</option>
                            <option value="lot">Lot</option>
                            <option value="shop-house">Shop House</option>
                        </select>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="fw-semibold mb-2">Lot Area</label>
                            <input type="number" step="0.01" name="lot_area" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="fw-semibold mb-2">Floor Area</label>
                            <input type="number" step="0.01" name="floor_area" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="fw-semibold mb-2">Status</label>
                        <select name="status" class="form-select">
                            <option value=""></option>
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="save-model-unit-btn">Save</button>
                </div>

            </form>
        </div>
    </div>
@endpushonce


@push('scripts')
    @vite(['resources/js/dashboard/projects/show.js'])
    @vite(['resources/js/dashboard/modelUnits/model-unit-table.js'])
    @vite(['resources/js/dashboard/modelUnits/add.js'])
    @vite(['resources/js/dashboard/modelUnits/edit.js'])
    @vite(['resources/js/dashboard/modelUnits/submit-model-unit.js'])
@endpush
