@extends('dashboard.layouts.app')

@section('content')

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">Edit Property</h3>
            <small class="text-muted">Edit listing under Dream Home Guide Realty</small>
        </div>

        <a href="{{ route('property.index') }}" class="btn btn-light border px-4">
            Back
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
    <form class="edit-property-form">
        @csrf


        {{-- Basic Info --}}
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Basic Information</h5>

                <div class="row g-4">
                    <div class="col-md-12">

                        <div class="mb-3 title">
                            <label class="form-label fw-semibold">Property Name</label><span class="text-danger">*</span>
                            <input type="text" name="title" id="title" class="form-control" value="{{$property->title}}" placeholder="Ex. The Hauslands Pampanga" >
                        </div>

                        <div class="mb-3 slug">
                            <label class="form-label fw-semibold">Slug</label><span class="text-danger">*</span>
                            <input type="text" name="slug" id="slug" class="form-control" placeholder="Ex. the-hauslands-pampanga" value="{{$property->slug}}">
                        </div>

                        <div class="row g-3">
                            <div class="col-md-3 status">
                                <label class="form-label fw-semibold">Status</label><span class="text-danger">*</span>
                                <select name="status" class="form-select" id="status" required>
                                    <option value="active" @if($property->status === "active") selected @endif>Active</option>
                                    <option value="reserved" @if($property->status === "reserved") selected @endif>Reserved</option>
                                    <option value="sold" @if($property->status === "sold") selected @endif>Sold</option>
                                    <option value="inactive" @if($property->status === "inactive") selected @endif>Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-3 property_type">
                                <label class="form-label fw-semibold">Property Type</label><span class="text-danger">*</span>
                                <select name="property_type" class="form-select" id="property_type">
                                    <option value="sale" @if($property->property_type === "sale") selected @endif>For Sale</option>
                                    <option value="rent" @if($property->property_type === "rent") selected @endif>For Rent</option>
                                    <option value="preselling" @if($property->property_type === "preselling") selected @endif>Pre-Selling</option>
                                </select>
                            </div>

                            <div class="col-md-3 property_category">
                                <label class="form-label fw-semibold">Property Category</label><span class="text-danger">*</span>
                                <select name="property_category" class="form-select" id="property_category">
                                    <option value=""></option>
                                    <option value="house-and-lot" @if($property->property_category === "house-and-lot") selected @endif>House & Lot</option>
                                    <option value="condominium" @if($property->property_category === "condominium") selected @endif>Condominium</option>
                                    <option value="lot" @if($property->property_category === "lot") selected @endif>Residential Lot</option>
                                    <option value="townhouse" @if($property->property_category === "townhouse") selected @endif>Townhouse</option>
                                </select>
                            </div>
                            <div class="col-md-3 youtube_video_id">
                                <label class="form-label fw-semibold">Youtube Video ID</label>
                                <input type="text" name="youtube_video_id" id="youtube_video_id" class="form-control" placeholder="Ex: 5oKpoqmUj64" value="{{$property->youtube_video_id}}">
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
                        <textarea name="location" id="location" class="form-control mt-2" rows="2" placeholder="Ex. Brgy. Calulut" >{{$property->location}}</textarea>
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
                        <input type="number" name="price" id="price" class="form-control" min="0" value="{{$property->price}}" placeholder="5000000" >
                    </div>

                    <div class="col-md-4 bedrooms">
                        <label class="form-label fw-semibold">Bedrooms</label>
                        <input type="number" name="bedrooms" class="form-control" id="bedrooms" min="0" value="{{$property->bedrooms}}" placeholder="3">
                    </div>

                    <div class="col-md-4 bathrooms">
                        <label class="form-label fw-semibold">Bathrooms</label>
                        <input type="number" name="bathrooms" class="form-control" id="bathrooms" min="0" value="{{$property->bathrooms}}" placeholder="3">
                    </div>
                </div>
                <div class="row g-3 mb-3">

                    <div class="col-md-4 garage">
                        <label class="form-label fw-semibold">Garage</label>
                        <input type="number" name="garage" class="form-control" id="garage" min="0" value="{{$property->garage}}" placeholder="2">
                    </div>

                    <div class="col-md-4 lot_area">
                        <label class="form-label fw-semibold">Lot Area (sqm)</label>
                        <input type="number" name="lot_area" class="form-control" id="lot_area" min="0" value="{{$property->lot_area}}" placeholder="150">
                    </div>

                    <div class="col-md-4 floor_area">
                        <label class="form-label fw-semibold">Floor Area (sqm)</label>
                        <input type="number" name="floor_area" id="floor_area" class="form-control" min="0" value="{{$property->floor_area}}" placeholder="100">
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
    <input type="hidden" id="property_description" value="{{$property->description}}">
    <input type="hidden" name="property_id" value="{{$property->id}}">
        {{-- Submit --}}
        <div class="text-end mb-5">
            <button class="btn btn-primary px-4" type="submit">
                Save Property
            </button>
        </div>

    </form>
@endsection

@push('scripts')
    @vite(['resources/js/dashboard/properties/add-property.js','resources/js/dashboard/properties/edit-property.js'])
@endpush
