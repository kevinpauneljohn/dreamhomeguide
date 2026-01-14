@extends('dashboard.layouts.app')

@section('title', $title)

@section('content')

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">{{$title}}</h3>
            <small class="text-muted">
                Manage subdivision projects
            </small>
        </div>

        @can('add project')
            <button type="button" class="btn btn-primary px-4" id="add-project-btn" data-bs-toggle="modal"
                    data-bs-target="#projectModal">
                + Add New Project
            </button>
        @endcan
    </div>

    <!-- Breadcrumb -->
    <div class="card mb-3">
        <div class="card-body py-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{$title}}
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Search Role</label>
                    <input type="text" id="search" class="form-control"
                           placeholder="Search project…">
                </div>
            </div>
        </div>
    </div>

    <!-- Roles Table -->
    <div class="card">
        <div class="card-body">
            <table id="projects-table" class="table table-bordered table-hover align-middle border rounded">
                <thead class="table-light">
                <tr>
                    <th>Project</th>
                    <th>Address</th>
                    <th>Created</th>
                    <th>Status</th>
                    <th class="text-center" style="width: 1%">Actions</th>
                </tr>
                </thead>

                <tbody>
                {{-- Loaded via AJAX --}}
                </tbody>
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
@endpushonce


@push('scripts')
    @vite(['resources/js/dashboard/projects/main.js'])
@endpush
