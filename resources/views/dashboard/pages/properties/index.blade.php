@extends('dashboard.layouts.app')

@section('title', $title)
@push('css')
    @vite(['resources/css/dashboard.css','resources/css/properties.css'])
@endpush
@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">Properties</h3>
            <small class="text-muted">Manage all listings under Dream Home Guide Realty</small>
        </div>

{{--        <a href="{{ route('properties.create') }}" class="btn btn-primary px-4">--}}
        <a href="{{route('property.create')}}" class="btn btn-primary px-4">
            + Add New Property
        </a>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>

                    {{-- Active page --}}
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
                <div class="col-md-3">
                    <label class="form-label">Search</label>
                    <input type="text" id="search" class="form-control" placeholder="Search name, city, owner...">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Listing Type</label>
                    <select id="listingType" class="form-select">
                        <option value="">All</option>
                        <option value="sale">For Sale</option>
                        <option value="rent">For Rent</option>
                        <option value="preselling">Pre-Selling</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Category</label>
                    <select id="category" class="form-select">
                        <option value="">All</option>
                        <option value="house-and-lot">House & Lot</option>
                        <option value="condominium">Condominium</option>
                        <option value="lot">Lot Only</option>
                        <option value="townhouse">Townhouse</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select id="status" class="form-select">
                        <option value="">All</option>
                        <option value="active">Active</option>
                        <option value="status">Sold</option>
                        <option value="reserved">Reserved</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="card">
        <div class="card-body table-responsive">
            <table id="properties-table" class="table table-striped table-hover w-100 border">
                <thead>
                <tr>
                    <th>Thumbnail</th>
                    <th>Property Name</th>
                    <th>Location</th>
                    <th>Images</th>
                    <th>Type</th>
                    <th>Price</th>
                    <th>Is Featured</th>
                    <th>Status</th>
                    <th class="text-center" width="40"></th>
                </tr>
                </thead>
            </table>
        </div>
    </div>

@endsection

@push('scripts')
    @vite(['resources/js/dashboard/properties/properties.js'])
@endpush
