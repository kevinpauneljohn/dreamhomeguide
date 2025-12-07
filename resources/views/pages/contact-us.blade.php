@extends('layouts.singlePage')

@section('title', $title)

@section('bannerTitle')
    <div class="container">
        <h1 class="single-page-banner-title">{{ $title }}</h1>
    </div>
@endsection

@section('content')

    <div class="container py-5 px-3 contact-wrapper">

        <div class="row g-5 align-items-start">

            <!-- LEFT SIDE – CONTACT INFO -->
            <div class="col-lg-6">

                <h2 class="premium-heading fw-semibold mb-3">How Can We Help You?</h2>

                <p class="text-muted lh-lg mb-4 fs-6">
                    We're dedicated to providing exceptional service to help you buy, sell, or invest in real estate.
                    Reach out through any of our channels below or send us a direct inquiry.
                </p>

                <div class="mb-4">
                    <h5 class="fw-bold">Direct Contact Options</h5>
                    <p class="text-muted">We respond quickly during business hours.</p>
                </div>

                <ul class="list-unstyled contact-list">

                    <li class="my-4 d-flex gap-3 align-items-center">
                        <div class="contact-icon"><i class="bi bi-whatsapp text-success"></i></div>
                        <div>
                            <div class="fw-semibold">Viber / WhatsApp</div>
                            <span class="text-primary fw-bold fs-5">+639171027662</span>
                        </div>
                    </li>

                    <li class="my-4 d-flex gap-3 align-items-start">
                        <div class="contact-icon"><i class="bi bi-phone text-primary"></i></div>
                        <div>
                            <div class="fw-semibold">Mobile Numbers</div>
                            <ul class="list-unstyled mt-2">
                                <li><a href="tel:+639171027662" class="text-primary fw-bold text-decoration-none fs-5">+639171027662</a> <small class="text-muted">(Globe)</small></li>
                                <li><a href="tel:+639297096801" class="text-primary fw-bold text-decoration-none fs-5">+639297096801</a> <small class="text-muted">(Smart)</small></li>
                            </ul>
                        </div>
                    </li>

                    <li class="my-4 d-flex gap-3 align-items-center">
                        <div class="contact-icon"><i class="bi bi-envelope-at text-danger"></i></div>
                        <div>
                            <div class="fw-semibold">Email</div>
                            <a href="mailto:johnkevinpaunel@gmail.com" class="fw-semibold text-dark-emphasis text-decoration-none fs-5">
                                johnkevinpaunel@gmail.com
                            </a>
                        </div>
                    </li>

                    <li class="my-4 d-flex gap-3 align-items-center">
                        <div class="contact-icon"><i class="bi bi-facebook text-primary"></i></div>
                        <div>
                            <div class="fw-semibold">Facebook</div>
                            <a href="https://www.facebook.com/johnkevinPaunelVlog" target="_blank" class="fw-semibold text-dark-emphasis text-decoration-none fs-5">
                                John Kevin Paunel
                            </a>
                        </div>
                    </li>

                    <li class="my-4 d-flex gap-3 align-items-center">
                        <div class="contact-icon"><i class="bi bi-youtube text-danger"></i></div>
                        <div>
                            <div class="fw-semibold">YouTube</div>
                            <a href="https://www.youtube.com/@JohnKevinPaunel" class="fw-semibold text-dark text-decoration-none fs-5">
                                @JohnKevinPaunel
                            </a>
                        </div>
                    </li>

                </ul>

            </div>

            <!-- RIGHT SIDE – CONTACT FORM -->
            <div class="col-lg-6">

                <div class="glass-card p-4">
                    <h4 class="fw-semibold mb-2">Send Us a Message</h4>
                    <p class="text-muted mb-4">Our team will reach out to you shortly.</p>

                    <x-contact-form />
                </div>

            </div>

        </div>
    </div>

@endsection

