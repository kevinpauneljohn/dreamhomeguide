@extends('dashboard.layouts.app')

@section('content')

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">Add New Property</h3>
            <small class="text-muted">Create a new listing under Dream Home Guide Realty</small>
        </div>

        <a href="{{ route('property.index') }}" class="btn btn-light border px-4">
            Cancel
        </a>
    </div>

    {{-- Breadcrumb --}}
    <div class="card mb-3">
        <div class="card-body py-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('property.index') }}">Properties</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $title }}
                    </li>
                </ol>
            </nav>
        </div>
    </div>


    {{-- FORM START --}}
    <form action="{{ route('property.store') }}" method="POST" enctype="multipart/form-data">
        @csrf


        {{-- Basic Info --}}
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Basic Information</h5>

                <div class="row g-4">
                    {{-- Thumbnail --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Thumbnail</label>
                        <input type="file" name="thumbnail" id="thumbnailInput" class="form-control">
                        <div class="mt-3">
                            <img id="thumbnailPreview" src="/images/no-image.png" class="rounded border" width="160">
                        </div>
                    </div>

                    {{-- Name, Type, Category --}}
                    <div class="col-md-8">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Property Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Ex. The Hauslands Pampanga" required>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Listing Type</label>
                                <select name="listing_type" class="form-select" required>
                                    <option value="sale">For Sale</option>
                                    <option value="rent">For Rent</option>
                                    <option value="pre-selling">Pre-Selling</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Category</label>
                                <select name="category" class="form-select" required>
                                    <option value="house">House & Lot</option>
                                    <option value="condo">Condominium</option>
                                    <option value="lot">Residential Lot</option>
                                    <option value="townhouse">Townhouse</option>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>



        {{-- Gallery --}}
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Property Gallery</h5>

                <label class="form-label fw-semibold">Upload Images</label>
                <input type="file" name="gallery[]" id="galleryInput" class="form-control" multiple accept="image/*">

                <div id="galleryPreview" class="d-flex flex-wrap gap-3 mt-3"></div>

                <small class="text-muted">Upload multiple gallery images (recommended: at least 1200×800).</small>
            </div>
        </div>



        {{-- Location --}}
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Location Details</h5>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Street / Barangay</label>
                        <input type="text" name="street" class="form-control" placeholder="Ex. Brgy. Calulut" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">City / Municipality</label>
                        <input type="text" name="city" class="form-control" placeholder="Ex. City of San Fernando, Pampanga" required>
                    </div>
                </div>

            </div>
        </div>



        {{-- Pricing --}}
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Pricing</h5>

                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Price (₱)</label>
                        <input type="number" name="price" class="form-control" min="0" placeholder="5000000" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="active">Active</option>
                            <option value="reserved">Reserved</option>
                            <option value="sold">Sold</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Bedrooms</label>
                        <input type="number" name="bedrooms" class="form-control" min="0" placeholder="3">
                    </div>
                </div>
            </div>
        </div>



        {{-- Description --}}
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Description</h5>
                <textarea name="description" id="description" class="form-control" rows="5"
                          placeholder="Write a detailed description (features, amenities, etc.)"></textarea>
            </div>
        </div>



        {{-- Submit --}}
        <div class="text-end mb-5">
            <button class="btn btn-primary px-4" type="submit">
                Save Property
            </button>
        </div>

    </form>
@endsection



@push('scripts')
    @vite('resources/js/dashboard/add-property.js')
@endpush
