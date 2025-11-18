@extends('dashboard.layouts.app')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">{{ $property->title }}</h3>
            <small class="text-muted">Viewing property details</small>
        </div>

        <a href="{{ route('property.index') }}" class="btn btn-light border px-4">
            Back
        </a>
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
                    <img src="https://tse3.mm.bing.net/th/id/OIP._Aa03XhsKxpyEJiSLoTtqwHaFj?rs=1&pid=ImgDetMain&o=7&rm=3"
                         class="img-fluid rounded border"
                         style="object-fit: cover; width:100%; height:330px;">
                </div>

                <div class="col-md-7">
                    <h4 class="fw-bold mb-2">{{ $property->title }}</h4>

                    <p class="text-muted mb-2">
                        <i class="bi bi-geo-alt"></i> {{ $property->address }}
                    </p>

                    <div class="mb-3">
                        <span class="badge bg-primary">{{ strtoupper($property->type) }}</span>
                        <span class="badge bg-secondary">{{ strtoupper($property->category) }}</span>
                        <span class="badge bg-{{ $property->status_color }}">{{ strtoupper($property->status) }}</span>
                    </div>

                    <h3 class="fw-bold text-success mb-3">₱ {{ number_format($property->price, 2) }}</h3>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="border rounded p-3 text-center">
                                <div class="fw-bold fs-4">{{ $property->bedrooms ?? '-' }}</div>
                                <div class="text-muted small">Bedrooms</div>
                            </div>
                        </div>

                        {{-- Add more features here if needed --}}
                        {{-- Example:
                        <div class="col-md-4">
                            <div class="border rounded p-3 text-center">
                                <div class="fw-bold fs-4">{{ $property->bathrooms }}</div>
                                <div class="text-muted small">Bathrooms</div>
                            </div>
                        </div>
                        --}}
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Gallery --}}
    @if ($property->gallery && count($property->gallery) > 0)
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Gallery</h5>

                <div id="propertyGallery" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">

                        @foreach($property->gallery as $index => $image)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <img src="{{ asset('storage/' . $image) }}"
                                     class="d-block w-100 rounded"
                                     style="height:350px; object-fit:cover;">
                            </div>
                        @endforeach

                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#propertyGallery" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#propertyGallery" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>

            </div>
        </div>
    @endif

    {{-- Description --}}
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="fw-bold mb-3">Description</h5>
            <div class="text-muted">
                {!! nl2br(e($property->description)) !!}
            </div>
        </div>
    </div>

@endsection
