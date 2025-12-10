@extends('layouts.app')

@section('title', $title)
@push('seo')
    <x-seo title="{{$title}} — {{url('/')}}" />
@endpush
@section('content')
    <x-carousel />

    <div class="container-fluid px-0 py-5 bg-primary text-white">
        <div class="container">
            <h2 class="text-center">Start Your Property Search</h2>
            <p class="text-center mb-4">
                Find the perfect home, investment, or rental in the Philippines.
            </p>
            <div class="search-form pt-3 px-3">
                <x-search-property />
            </div>
        </div>
    </div>
    <div class="container-fluid p-0 mb-5">
        <div class="container mt-4">
            <h2 class="text-center mb-5 section-title w-100">Featured Properties</h2>
{{--            <x-featured-properties :properties="$featuredProperties"/>--}}
        </div>
    </div>
    <div class="container-fluid p-0 mb-5">
        <div class="container mt-4 home-services-container">
            <h2 class="text-center mb-3 section-title w-100">How Can We Help You?</h2>
            <p class="section-description text-center">
                Your real estate journey matters to us. Whether you’re upgrading, investing, or selling, we’re here to provide guidance, support, and the best brokering service tailored to your needs.
            </p>

            <x-service-offered/>
        </div>
    </div>

    <div class="container-fluid py-5 bg-light">
        <div class="container home-contact-form-container">
            <div class="row align-items-start g-5">

                <!-- LEFT SIDE -->
                <div class="col-lg-6">

                    <h2 class="mb-3 fw-semibold">Tell Us Your Inquiry</h2>

                    <p class="section-description mb-4 text-muted lh-lg">
                        Whatever your real estate needs may be—selling, buying, or investing—our team is here to support you with reliable assistance and personalized service every step of the way.
                    </p>

                    <h4 class="fw-semibold mb-3">You May Also Contact Us</h4>

                    <ul class="list-unstyled contact-list">

                        <!-- WhatsApp / Viber -->
                        <li class="d-flex align-items-center gap-2 mb-3">
                            <i class="bi bi-whatsapp text-success fs-4"></i>
                            <span>Viber or WhatsApp:
                                <strong class="text-primary">+639171027662</strong>
                            </span>
                        </li>

                        <!-- Mobile Numbers -->
                        <li class="d-flex align-items-start gap-2 mb-3">
                            <i class="bi bi-phone text-primary fs-4"></i>
                            <span>
                                Mobile Numbers: <br>
                                <strong class="text-primary">+639171027662</strong> <small>(Globe)</small><br>
                                <strong class="text-primary">+639297096801</strong> <small>(Smart)</small>
                            </span>
                        </li>

                        <!-- Email -->
                        <li class="d-flex align-items-center gap-2 mb-3">
                            <i class="bi bi-envelope-fill text-danger fs-4"></i>
                            <span>Email:
                                <a href="mailto:johnkevinpaunel@gmail.com"
                                   class="fw-semibold text-decoration-none text-dark">
                                    inquiry@johnkevinpaunel.com
                                </a>
                            </span>
                        </li>

                        <!-- Facebook -->
                        <li class="d-flex align-items-center gap-2 mb-3">
                            <i class="bi bi-facebook text-primary fs-4"></i>
                            <span>Facebook:
                                <a href="https://www.facebook.com/johnkevinPaunelVlog"
                                   target="_blank"
                                   class="fw-semibold text-decoration-none text-dark">
                                    John Kevin Paunel
                                </a>
                            </span>
                        </li>

                    </ul>

                </div>

                <!-- RIGHT SIDE (FORM) -->
                <div class="col-lg-6">
                    <div class="card shadow-sm border-0 p-4 rounded-4 bg-white">
                        <x-contact-form />
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
