@extends('dashboard.layouts.app')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">{{ $property->title }}</h3>
            <small class="text-muted">Viewing property details</small>
        </div>

        <div class="d-flex gap-2">
            @can('edit listing')
                <a href="{{ route('property.edit', $property->id) }}" class="btn btn-primary px-4">
                    Edit Property
                </a>
            @endcan

            @can('view listing')
                <a href="{{ route('property.index') }}" class="btn btn-light border px-4">
                    Back
                </a>
            @endcan
        </div>
    </div>


    {{-- Breadcrumb --}}
    <div class="card mb-3">
        <div class="card-body">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('property.index') }}">Properties</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $property->title }}</li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- Main Thumbnail + Info --}}
    <div class="card mb-4">
        <div class="card-body">

            <div class="row g-4">
                <div class="col-md-5">
                    <img src="{{$thumbnail}}"
                         class="img-fluid rounded border"
                         style="object-fit: cover; width:100%; height:330px;" alt="">
                </div>

                <div class="col-md-7">
                    <h4 class="fw-bold mb-2">{{ $property->title }}</h4>

                    <p class="text-muted mb-2">
                        <i class="bi bi-geo-alt"></i> {{ $property->location }}
                    </p>

                    <div class="mb-3">
                        <span class="badge bg-primary">{{ strtoupper($property->property_type) }}</span>
                        <span class="badge bg-secondary">{{ strtoupper($property->property_category) }}</span>
                        <span class="badge bg-{{ $property->status_color }}">{{ strtoupper($property->status) }}</span>
                    </div>

                    <h3 class="fw-bold text-success mb-3">₱ {{ number_format($property->price, 2) }}</h3>

                    <div class="row g-3">
                        @if(!is_null($property->bedrooms))
                            <div class="col-md-4">
                                <div class="border rounded p-3 text-center">
                                    <div class="fw-bold fs-4">{{ $property->bedrooms}}</div>
                                    <div class="text-muted small">Bedrooms</div>
                                </div>
                            </div>
                        @endif

                        @if(!is_null($property->bathrooms))
                            <div class="col-md-4">
                                <div class="border rounded p-3 text-center">
                                    <div class="fw-bold fs-4">{{ $property->bathrooms }}</div>
                                    <div class="text-muted small">Bathrooms</div>
                                </div>
                            </div>
                        @endif

                        @if(!is_null($property->garage))
                            <div class="col-md-4">
                                <div class="border rounded p-3 text-center">
                                    <div class="fw-bold fs-4">{{ $property->garage }}</div>
                                    <div class="text-muted small">Garage</div>
                                </div>
                            </div>
                        @endif

                        @if (!is_null($property->lot_area))
                            <div class="col-md-4">
                                <div class="border rounded p-3 text-center">
                                    <div class="fw-bold fs-4">{{ $property->lot_area }} sqm</div>
                                    <div class="text-muted small">Lot Area</div>
                                </div>
                            </div>
                        @endif

                        @if (!is_null($property->floor_area))
                            <div class="col-md-4">
                                <div class="border rounded p-3 text-center">
                                    <div class="fw-bold fs-4">{{ $property->floor_area }} sqm</div>
                                    <div class="text-muted small">Floor Area</div>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Gallery --}}

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Gallery</h5>
                @if ($property->images && count($property->images) > 0)
                    <div id="propertyGallery" class="carousel slide" data-bs-ride="carousel">

                        <div class="carousel-inner">
                            @foreach($property->images as $index => $image)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    <img src="{{ asset('storage/property_images/' . $image['file_name']) }}"
                                         class="d-block w-100 rounded"
                                         style="height:350px; object-fit: contain;"
                                         alt="{{$image['file_name']}}">
                                </div>
                            @endforeach
                        </div>

                        {{-- NUMBERING --}}
                        <div class="carousel-counter">
                            <span id="carouselNumber">1</span> /
                            <span id="carouselTotal">{{ count($property->images) }}</span>
                        </div>

                        <button class="carousel-control-prev" type="button" data-bs-target="#propertyGallery" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#propertyGallery" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>

                    </div>
                    @else
                    <div class="alert alert-warning d-flex justify-content-between align-items-center" role="alert">
                        <span>No images uploaded yet.</span>

                        <a href="{{ route('property.images', $property->id) }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-upload"></i> Upload Images
                        </a>
                    </div>

                @endif
            </div>
        </div>

    {{-- Description --}}
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="fw-bold mb-3">Youtube Video</h5>
            <div class="text-muted">
                @if(empty(!$property->youtube_video_id))
                    <iframe width="100%" height="500" src="https://www.youtube.com/embed/{!! $property->youtube_video_id !!}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                @else
                    <div class="alert alert-warning d-flex justify-content-between align-items-center" role="alert">
                        <span>No images uploaded yet.</span>

                        <a href="/property/{{$property->id}}/edit?youtube_video=add" class="btn btn-sm btn-primary">
                            <i class="bi bi-upload"></i> Add Youtube Video
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Description --}}
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="fw-bold mb-3">Description</h5>
            <div class="text-muted">
                {!! $property->description !!}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @vite(['resources/js/dashboard/properties/property-image-gallery-counter.js'])
@endpush

