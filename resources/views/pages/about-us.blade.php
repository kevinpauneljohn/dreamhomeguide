@extends('layouts.singlePage')

@section('title', $title)
@section('bannerTitle')
    <div class="container">
        <h1 class="single-page-banner-title">{{$title}}</h1>
    </div>
@endsection
@section('content')
    <div class="container p-5">
        <div class="row">
            <div class="col-md-6">
                <h2 class="fw-lighter">Your Vision, Our Mission</h2>
                <p class="text-muted">
                    Welcome to the official website of <strong>John Kevin Paunel</strong>—a real estate professional, entrepreneur,
                    and storyteller committed to helping Filipinos make smarter, more confident decisions in buying, selling, and investing in real estate.
                </p>

            </div>
            <div class="col-md-6">
                <p class="text-muted">
                    My mission is simple:<br/>
                    <strong>To guide people toward better homes, better opportunities, and a better quality of life through honest service, clear advice, and modern real estate solutions.</strong>

                    Whether you're a first-time buyer, an OFW hoping to build your future back home, or an investor searching for high-value developments,
                    my goal is to make the entire journey easier, clearer, and truly rewarding.
                </p>
            </div>
        </div>
    </div>

    @if($teams->count() > 0)
        <div class="container-fluid p-5 bg-secondary-subtle">
            <div class="container p-2">
                <h2 class="text-center">Meet Our Team</h2>
                <p class="mb-5 text-center">Dedicated to Serving You With Excellence</p>
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 mb-5">
                    @foreach($teams->get() as $team)
                        <div class="col">
                            <x-card-profile
                                imageUrl="storage/profile_pictures/{{$team->profile_photo}}"
                                name="{{ucwords(strtolower($team->full_name))}}"
                                role="{{$team->position}}"
                            />
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <div class="container p-5">
        <h2 class="text-center mb-3 section-title w-100">How Can We Help You?</h2>
        <p class="section-description text-center">
            No matter your real estate goal—selling, buying, or investing—you can count on us for honest guidance and reliable service.
        </p>
        <x-service-offered/>
    </div>
@endsection
