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
                        <option value="For Sale">For Sale</option>
                        <option value="For Rent">For Rent</option>
                        <option value="Pre-Selling">Pre-Selling</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Category</label>
                    <select id="category" class="form-select">
                        <option value="">All</option>
                        <option value="House & Lot">House & Lot</option>
                        <option value="Condominium">Condominium</option>
                        <option value="Residential Lot">Residential Lot</option>
                        <option value="Townhouse">Townhouse</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select id="status" class="form-select">
                        <option value="">All</option>
                        <option value="Active">Active</option>
                        <option value="Sold">Sold</option>
                        <option value="Reserved">Reserved</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="card">
        <div class="card-body table-responsive">
            <table id="properties-table" class="table table-striped table-hover w-100">
                <thead>
                <tr>
                    <th>Thumbnail</th>
                    <th>Property Name</th>
                    <th>Location</th>
                    <th>Type</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th width="80px">Action</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>

@endsection

@push('scripts')
    @vite(['resources/js/dashboard/properties.js'])
@endpush
