@extends('dashboard.layouts.app')

@section('title', $title)

@push('css')
    @vite(['resources/css/dashboard.css'])
@endpush

@section('content')
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">Blogs</h3>
            <small class="text-muted">Manage articles, announcements & content</small>
        </div>

        @can('add blog')
            <a href="{{ route('blog.create') }}" class="btn btn-primary px-4">
                <i class="bi bi-pencil-square me-1"></i> Add New Blog
            </a>
        @endcan
    </div>

    {{-- Breadcrumb --}}
    <div class="card mb-3">
        <div class="card-body">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $title }}
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- Filters --}}
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3">

                <div class="col-md-4">
                    <label class="form-label">Search</label>
                    <input type="text" id="search" class="form-control" placeholder="Search title, author...">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Category</label>
                    <select id="category" class="form-select">
                        <option value="">All</option>
                        @foreach($blogCategories as $key => $value)
                            <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select id="status" class="form-select">
                        <option value="">All</option>
                        @foreach($blogStatus as $key => $value)
                            <option value="{{$key}}">{{$value['label']}}</option>
                        @endforeach
                    </select>
                </div>

            </div>
        </div>
    </div>

    {{-- Blog Table --}}
    <div class="card">
        <div class="card-body table-responsive">

            <table id="blogs-table" class="table table-striped table-hover w-100 border">
                <thead>
                <tr>
                    <th>Thumbnail</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Published Date</th>
                    <th class="text-center" width="40"></th>
                </tr>
                </thead>
            </table>

        </div>
    </div>

@endsection

@push('scripts')
    @vite(['resources/js/dashboard/blogs/index.js'])
@endpush
