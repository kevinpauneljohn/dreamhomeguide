@extends('layouts.singlePage')

@section('title', $title)
@push('preload')
    @push('preload')
        <link
            rel="preload"
            as="image"
            href="{{ asset('storage/property_images/'.$property->images->first()->file_name) }}"
            fetchpriority="high">
    @endpush

@endpush
@push('seo')
    <x-seo
        :title="$property->title"
        :description="$property->meta_description"
        :keywords="$property->meta_keywords"
        :image="url('/storage/property_images/'.$property->images->first()->file_name)"
        schemaType="Residence"
    />

@endpush
@section('bannerTitle')
    <div class="container">
        <h1 class="single-page-banner-title">{{$title}}</h1>
    </div>
@endsection
@section('content')
    {{-- Breadcrumb --}}
    <div class="container mt-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('listing.index')}}">Listings</a></li>
                <li class="breadcrumb-item active">{{ ucwords(strtolower($property->title)) }}</li>
            </ol>
        </nav>
    </div>


    {{-- IMAGE GALLERY --}}
    <div class="container py-2">
        <x-listing-images propertyId="{{$property->id}}"/>
    </div>


    {{-- PROPERTY HEADER GROUP --}}
    <div class="container my-3">
        <div class="property-header">

            <div class="row d-flex justify-content-between align-items-start">
                <div class="col-lg-8">
                    <h1 class="property-title">{{ ucwords(strtolower($property->title)) }}</h1>

                    <div class="text-muted small mt-1">
                        <i class="fa-regular fa-clock"></i>
                        Posted on {{ $property->created_at->format('F d, Y') }}
                    </div>
                </div>

                <div class="col-lg-4 d-flex justify-content-end">
                    {{-- Floating Action Icons --}}
                    <div class="property-actions d-flex gap-2">

                        {{-- Facebook --}}
                        <a class="action-btn action-fb"
                           href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                           target="_blank">
                            <i class="bi bi-facebook"></i>
                        </a>

                        {{-- Messenger --}}
                        <a class="action-btn action-msg"
                           href="https://www.facebook.com/dialog/send?link={{ urlencode(url()->current()) }}&app_id=YOUR_APP_ID&redirect_uri={{ urlencode(url()->current()) }}"
                           target="_blank">
                            <i class="bi bi-messenger"></i>
                        </a>

                        {{-- Twitter --}}
                        <a class="action-btn action-twt"
                           href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($property->title) }}"
                           target="_blank">
                            <i class="bi bi-twitter"></i>
                        </a>

                        {{-- LinkedIn --}}
                        <a class="action-btn action-li"
                           href="https://www.linkedin.com/shareArticle?url={{ urlencode(url()->current()) }}"
                           target="_blank">
                            <i class="bi bi-linkedin"></i>
                        </a>

                        {{-- Copy Link --}}
                        <span class="action-btn action-copy" onclick="copyPropertyLink()">
                            <i class="bi bi-link-45deg"></i>
                        </span>

                                            {{-- Favorite --}}
                                            <span class="action-btn action-fav" title="Add to Favorites">
                            <i class="bi bi-heart"></i>
                        </span>

                                            {{-- Compare --}}
                                            <span class="action-btn action-compare" title="Compare Property">
                            <i class="bi bi-arrow-left-right"></i>
                        </span>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="d-flex flex-wrap gap-3 mt-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-peso-sign text-primary"></i>
                            <span class="property-price">{{ number_format($property->price, 2) }}</span>
                        </div>

                        <div class="d-flex align-items-center text-muted gap-2">
                            <i class="fa-solid fa-location-dot"></i>
                            <span>{{ $property->location }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    {{-- Badges --}}
                    <div class="mt-3">
                        @if($property->is_featured)
                            <span class="badge rounded-pill text-bg-success badge-pill">Featured</span>
                        @endif
                        <span class="badge rounded-pill text-bg-danger badge-pill">{{ $property->property_type }}</span>
                    </div>
                </div>
            </div>

        </div>
    </div>


    {{-- MAIN CONTENT --}}
    <div class="container py-3 mb-5">
        <div class="row g-4">

            {{-- LEFT COLUMN --}}
            <div class="col-lg-8">

                {{-- PROPERTY STATS --}}
                <div class="row g-3 mb-4">

                    <div class="col-6 col-md-3">
                        <div class="stat-box">
                            <i class="fa-solid fa-building"></i>
                            <div class="fw-bold">{{ ucwords(str_replace('-', ' ', $property->property_category)) }}</div>
                            <div class="stat-label">Property Type</div>
                        </div>
                    </div>

                    @if($property->bedrooms)
                        <div class="col-6 col-md-3">
                            <div class="stat-box">
                                <i class="fa-solid fa-bed"></i>
                                <div class="fw-bold">{{ $property->bedrooms }}</div>
                                <div class="stat-label">Bedrooms</div>
                            </div>
                        </div>
                    @endif

                    @if($property->bathrooms)
                        <div class="col-6 col-md-3">
                            <div class="stat-box">
                                <i class="fa-solid fa-shower"></i>
                                <div class="fw-bold">{{ $property->bathrooms }}</div>
                                <div class="stat-label">Bathrooms</div>
                            </div>
                        </div>
                    @endif

                    @if($property->garage)
                        <div class="col-6 col-md-3">
                            <div class="stat-box">
                                <i class="fa-solid fa-car"></i>
                                <div class="fw-bold">{{ $property->garage }}</div>
                                <div class="stat-label">Parking</div>
                            </div>
                        </div>
                    @endif

                    @if($property->lot_area)
                        <div class="col-6 col-md-3">
                            <div class="stat-box">
                                <i class="fa-solid fa-arrows-alt"></i>
                                <div class="fw-bold">{{ $property->lot_area }} sqm</div>
                                <div class="stat-label">Lot Area</div>
                            </div>
                        </div>
                    @endif
                    @if($property->floor_area)
                        <div class="col-6 col-md-3">
                            <div class="stat-box">
                                <i class="fa-solid fa-ruler-combined"></i>
                                <div class="fw-bold">{{ $property->floor_area }} sqm</div>
                                <div class="stat-label">Floor Area</div>
                            </div>
                        </div>
                    @endif

                </div>


                {{-- DESCRIPTION --}}
                <div class="description-box mb-4">
                    <h4 class="fw-bold text-muted mb-3">Description</h4>
                    {!! $property->description !!}
                </div>


                {{-- VIDEO --}}
                @if($property->youtube_video_id)
                    <div class="description-box mb-4 video-container">
                        <h4 class="fw-bold mb-3">Video House Tour</h4>
                        <iframe width="100%" height="450"
                                src="https://www.youtube.com/embed/{{ $property->youtube_video_id }}"
                                allowfullscreen></iframe>
                    </div>
                @endif

            </div>



            {{-- SIDEBAR --}}
            <div class="col-lg-4">

                <div class="sidebar-card mb-4">
                    <img src="{{asset('/carousel/businessman-8825632_1280.jpg')}}" class="card-img-top" alt="">
                    <div class="card-body">
                        <p class="card-text p-3">
                            Looking to learn more about this unit?
                            Contact us today for full pricing details, payment options, and a personalized consultation.
                        </p>
                    </div>
                </div>

                <div class="sidebar-card p-3">
                    <h5 class="fw-bold mb-3">Inquire About This Property</h5>
                    <x-contact-form propertyId="{{ $property->id }}"/>
                </div>

                <div class="sidebar-card p-3 mt-4">
                    <h5 class="fw-bold mb-3">Mortgage Calculator</h5>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Property Price</label>
                        <input type="text" id="mc-price" class="form-control" value="{{ $property->price }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Down Payment (%)</label>
                        <input type="number" id="mc-downpayment" class="form-control" value="20">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Annual Interest Rate (%)</label>
                        <input type="number" id="mc-interest" class="form-control" value="8">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Loan Term (Years)</label>
                        <input type="number" id="mc-years" class="form-control" value="20">
                    </div>

                    <button class="btn btn-primary w-100 fw-bold" onclick="calculateMortgage()">Calculate</button>

                    <hr>

                    <div id="mc-results" class="mt-3" style="display: none;">
                        <h6 class="fw-bold">Results</h6>
                        <p class="mb-1"><strong>Loan Amount:</strong> ₱<span id="mc-loan"></span></p>
                        <p class="mb-1"><strong>Monthly Payment:</strong> ₱<span id="mc-monthly"></span></p>
                        <p class="mb-1"><strong>Total Interest:</strong> ₱<span id="mc-interest-total"></span></p>
                    </div>
                </div>


            </div>

        </div>
    </div>



    {{-- SUGGESTED PROPERTIES --}}
    <div class="container-fluid py-5 bg-light">
        <h2 class="text-center section-title-line mb-4 w-100">Suggested Properties</h2>
        <div class="container">
            <x-suggested-properties/>
        </div>
    </div>

@endsection

@push('scripts')
    @vite(['resources/js/pages/mortgage-calculator.js'])
@endpush

@push('meta')
    <script>
        fbq('track', 'ViewContent', {
            content_name: '{{$property->title}}',
            content_category: 'Listing'
        });
    </script>
@endpush




