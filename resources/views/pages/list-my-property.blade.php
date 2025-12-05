@extends('layouts.singlePage')

@section('content')

    <!-- HERO -->
    <section class="py-5 bg-light">
        <div class="container text-center">
            <h1 class="fw-bold">Sell Your Property With Confidence</h1>
            <p class="text-muted w-75 mx-auto">
                Get matched with serious buyers through professional marketing,
                smart pricing strategies, and a streamlined selling process.
            </p>
            <a href="#list-form" class="btn btn-dark px-5 py-2 mt-3">List My Property</a>
        </div>
    </section>

    <!-- BENEFITS -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center fw-semibold mb-4">Why List With Us?</h2>

            <div class="row g-4 text-center">
                <div class="col-md-3">
                    <i class="bi bi-camera fs-1 text-primary"></i>
                    <h5 class="fw-bold mt-2">Professional Photos</h5>
                    <p class="text-muted small">Showcase your property with high-quality images that attract more buyers.</p>
                </div>

                <div class="col-md-3">
                    <i class="bi bi-megaphone fs-1 text-primary"></i>
                    <h5 class="fw-bold mt-2">Massive Buyer Reach</h5>
                    <p class="text-muted small">Your listing is promoted across major platforms and social media channels.</p>
                </div>

                <div class="col-md-3">
                    <i class="bi bi-graph-up-arrow fs-1 text-primary"></i>
                    <h5 class="fw-bold mt-2">Smart Pricing Strategy</h5>
                    <p class="text-muted small">We help you price your property for the best balance of speed and value.</p>
                </div>

                <div class="col-md-3">
                    <i class="bi bi-people fs-1 text-primary"></i>
                    <h5 class="fw-bold mt-2">Expert Support</h5>
                    <p class="text-muted small">From listing to closing, our team assists you every step of the way.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- LIST FORM -->
    <section id="list-form" class="py-5 bg-light">
        <div class="container">
            <div class="card shadow-sm p-4 mx-auto" style="max-width: 700px;">
                <h3 class="fw-bold mb-3 text-center">List Your Property</h3>

                <x-inquiry-form leadType="seller"/>
            </div>
        </div>
    </section>

@endsection


