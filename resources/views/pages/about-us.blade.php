@extends('layouts.singlePage')

@section('title', $title)
@push('seo')
    <x-seo title="{{$title}} — {{url('/')}}" />
@endpush

{{-- ============================= --}}
{{-- HERO HEADER --}}
{{-- ============================= --}}
@section('bannerTitle')
    <div class="about-hero d-flex align-items-center">
        <div class="container text-center text-white">
            <h1 class="fw-bold display-5 mb-3">About Dream Home Guide Realty</h1>
            <p class="lead mx-auto" style="max-width: 650px;">
                Your trusted partner in finding better homes, better investments, and a better future.
            </p>
        </div>
    </div>
@endsection

@section('content')

    {{-- ============================= --}}
    {{-- SECTION: BRAND STORY --}}
    {{-- ============================= --}}
    <div class="container py-5">

        <div class="story-section">

            <div class="row g-4">
                <div class="col-md-6">
                    <h2 class="fw-bold mb-3">Your Vision, Our Mission</h2>
                    <p class="text-muted lh-lg">
                        Welcome to <strong>Dream Home Guide Realty</strong>, led by <strong>John Kevin Paunel</strong>—
                        a real estate professional, entrepreneur, and storyteller committed to helping Filipinos make smarter,
                        more confident decisions in buying, selling, and investing in real estate.
                    </p>
                </div>

                <div class="col-md-6">
                    <p class="text-muted lh-lg">
                        <strong>Our mission is simple:</strong><br>
                        To guide people toward better homes, better opportunities, and a better quality of life through honest service,
                        clear advice, and modern real estate solutions.

                        Whether you're a first-time buyer, an OFW building your dream home, or an investor seeking strong returns,
                        our goal is to make your journey easier, clearer, and truly rewarding.
                    </p>
                </div>
            </div>

        </div>
    </div>


    {{-- ============================= --}}
    {{-- SECTION: WHY CHOOSE US --}}
    {{-- ============================= --}}
    <div class="container py-5">
        <h2 class="text-center section-title-line mb-4 w-100">Why Choose Dream Home Guide Realty?</h2>


        <p class="text-center text-muted mb-5">
            A modern real estate agency built on trust, experience, digital innovation, and heart.
        </p>

        <div class="row g-4">

            <div class="col-lg-4 col-md-6">
                <div class="why-card">
                    <div class="why-icon"><i class="bi bi-lightning-charge-fill"></i></div>
                    <h5 class="fw-bold mb-2">Fast & Reliable Service</h5>
                    <p class="text-muted">
                        We respond quickly, handle documents efficiently, and guide you through every step with clarity.
                    </p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="why-card">
                    <div class="why-icon"><i class="bi bi-people-fill"></i></div>
                    <h5 class="fw-bold mb-2">Client-Centered Approach</h5>
                    <p class="text-muted">
                        Your goals are our priority. We tailor solutions to your needs—never a one-size-fits-all approach.
                    </p>
                </div>
            </div>

            <div class="col-lg-4 col-md-12">
                <div class="why-card">
                    <div class="why-icon"><i class="bi bi-buildings-fill"></i></div>
                    <h5 class="fw-bold mb-2">Strong Developer Network</h5>
                    <p class="text-muted">
                        We partner with trusted developers across Pampanga, Tarlac, and Central Luzon to give you more options.
                    </p>
                </div>
            </div>

        </div>
    </div>


    {{-- ============================= --}}
    {{-- SECTION: MEET THE TEAM --}}
    {{-- ============================= --}}
    @if($teams->count() > 0)
        <div class="container-fluid p-5 bg-secondary-subtle mt-4">
            <div class="container">

                <h2 class="text-center section-title-line mb-2 w-100">Meet Our Team</h2>
                <p class="mb-5 text-center text-muted">Dedicated to serving you with integrity and excellence.</p>

                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 justify-content-center">

                    @foreach ($teams->get() as $team)
                        <div class="col d-flex justify-content-center">
                            <x-card-profile
                                imageUrl="storage/profile_pictures/{{ $team->profile_photo }}"
                                name="{{ ucwords(strtolower($team->full_name)) }}"
                                role="{{ $team->position }}"
                            />
                        </div>
                    @endforeach

                </div>

            </div>
        </div>
    @endif


    {{-- ============================= --}}
    {{-- SECTION: HOW CAN WE HELP YOU --}}
    {{-- ============================= --}}
    <div class="container p-5">
        <h2 class="text-center section-title-line mb-3 w-100">How Can We Help You?</h2>
        <p class="section-description text-center text-muted">
            No matter your real estate goal—selling, buying, or investing—you can count on us for honest guidance and reliable service.
        </p>

        <x-service-offered/>
    </div>

@endsection
