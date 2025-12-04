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
    <form class="add-property-form" enctype="multipart/form-data">
        @csrf


        {{-- Basic Info --}}
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Basic Information</h5>

                <div class="row g-4">
                    <div class="col-md-12">

                        <div class="mb-3 title">
                            <label class="form-label fw-semibold">Property Name</label><span class="text-danger">*</span>
                            <input type="text" name="title" id="title" class="form-control" placeholder="Ex. The Hauslands Pampanga" >
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-8 slug">
                                <label class="form-label fw-semibold">Slug</label><span class="text-danger">*</span>
                                <input type="text" name="slug" id="slug" class="form-control" placeholder="Ex. the-hauslands-pampanga" >
                            </div>
                            <div class="col-md-4 is_featured">
                                <label class="form-label fw-semibold">Is Featured</label><span class="text-danger">*</span>
                                <select name="is_featured" class="form-select" id="is_featured">
                                    <option value="0"></option>
                                    <option value="1">Featured</option>
                                </select>
                            </div>
                        </div>


                        <div class="row g-3">
                            <div class="col-md-3 status">
                                <label class="form-label fw-semibold">Status</label><span class="text-danger">*</span>
                                <select name="status" class="form-select" id="status" required>
                                    <option value="active">Active</option>
                                    <option value="reserved">Reserved</option>
                                    <option value="sold">Sold</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-3 property_type">
                                <label class="form-label fw-semibold">Property Type</label><span class="text-danger">*</span>
                                <select name="property_type" class="form-select" id="property_type">
                                    <option value=""></option>
                                    @foreach($propertyTypes as $key => $value)
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 property_category">
                                <label class="form-label fw-semibold">Property Category</label><span class="text-danger">*</span>
                                <select name="property_category" class="form-select" id="property_category">
                                    <option value=""></option>
                                    @foreach($propertyCategories as $key => $value)
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="col-md-3 youtube_video_id">
                                <label class="form-label fw-semibold">Youtube Video ID</label>
                                <input type="text" name="youtube_video_id" id="youtube_video_id" class="form-control" placeholder="Ex: 5oKpoqmUj64">
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        {{-- Location --}}
        <div class="card mb-4">
            <div class="card-body">
                <span class="fw-bold fs-5 mb-3">Location Details</span><span class="text-danger">*</span>

                <div class="row g-3">
                    <div class="col-md-12 location">
                        <textarea name="location" id="location" class="form-control mt-2" rows="2" placeholder="Ex. Brgy. Calulut" ></textarea>
                    </div>
                </div>

            </div>
        </div>

        {{-- Pricing --}}
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Other Details</h5>

                <div class="row g-3 mb-3">
                    <div class="col-md-4 price">
                        <label class="form-label fw-semibold">Price (₱)</label><span class="text-danger">*</span>
                        <input type="number" name="price" id="price" class="form-control" min="0" placeholder="5000000" >
                    </div>

                    <div class="col-md-4 bedrooms">
                        <label class="form-label fw-semibold">Bedrooms</label>
                        <input type="number" name="bedrooms" class="form-control" id="bedrooms" min="0" placeholder="3">
                    </div>

                    <div class="col-md-4 bathrooms">
                        <label class="form-label fw-semibold">Bathrooms</label>
                        <input type="number" name="bathrooms" class="form-control" id="bathrooms" min="0" placeholder="3">
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-md-4 garage">
                        <label class="form-label fw-semibold">Garage</label>
                        <input type="number" name="garage" class="form-control" id="garage" min="0" placeholder="2">
                    </div>

                    <div class="col-md-4 lot_area">
                        <label class="form-label fw-semibold">Lot Area (sqm)</label>
                        <input type="number" name="lot_area" class="form-control" id="lot_area" min="0" placeholder="150">
                    </div>

                    <div class="col-md-4 floor_area">
                        <label class="form-label fw-semibold">Floor Area (sqm)</label>
                        <input type="number" name="floor_area" id="floor_area" class="form-control" min="0" placeholder="100">
                    </div>
                </div>
            </div>
        </div>

        {{-- Description --}}
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Description</h5>
                <div class="description">
                    <textarea name="description" id="description" class="form-control" rows="5"
                              placeholder="Write a detailed description (features, amenities, etc.)"></textarea>
                </div>
            </div>
        </div>

        {{-- Submit --}}
        <div class="text-end mb-5">
            <button class="btn btn-primary px-4 save-property-btn" type="submit">
                Save Property
            </button>
        </div>

    </form>
@endsection



@push('scripts')
    @vite('resources/js/dashboard/properties/add-property.js')
@endpush
