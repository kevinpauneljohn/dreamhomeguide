@extends('layouts.singlePage')

@section('title', $title)

@section('bannerTitle')
    <div class="container">
        <h1 class="single-page-banner-title">{{$title}}</h1>
    </div>
@endsection

@section('content')
    <div class="container py-5 w-75">

        <div class="row g-5">

            <!-- LEFT SIDE – CONTACT DETAILS -->
            <div class="col-md-6">

                <h2 class="mb-3 fw-light">Tell Us Your Inquiry</h2>

                <p class="section-description mb-4 text-muted lh-lg">
                    At <strong>Presello</strong>, we are committed to delivering exceptional brokering service.
                    Whether you want to sell your property or purchase your next investment,
                    our team is ready to assist you every step of the way.
                </p>

                <h4 class="fw-light mb-3">You May Also Contact Us</h4>

                <ul class="list-unstyled text-muted">

                    <li class="my-3 d-flex align-items-center gap-2">
                        <i class="bi bi-whatsapp text-success fs-5"></i>
                        <span>Viber or WhatsApp:
        <strong class="text-primary">+639171027662</strong>
    </span>
                    </li>

                    <li class="my-3 d-flex align-items-start gap-2">
                        <i class="bi bi-phone text-primary fs-5"></i>
                        <div>
                            <span class="fw-semibold">Mobile Numbers:</span>
                            <ul class="list-unstyled ms-4 mt-2">
                                <li class="my-1">
                                    <a href="tel:+639171027662" class="text-primary fw-bold text-decoration-none">
                                        +639171027662
                                    </a> <small class="text-muted">(Globe)</small>
                                </li>
                                <li class="my-1">
                                    <a href="tel:+639297096801" class="text-primary fw-bold text-decoration-none">
                                        +639297096801
                                    </a> <small class="text-muted">(Smart)</small>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="my-3 d-flex align-items-center gap-2">
                        <i class="bi bi-envelope-at text-danger fs-5"></i>
                        <span>Email:
        <a href="mailto:johnkevinpaunel@gmail.com"
           class="fw-bold text-dark-emphasis text-decoration-none">johnkevinpaunel@gmail.com</a>
    </span>
                    </li>

                    <li class="my-3 d-flex align-items-center gap-2">
                        <i class="bi bi-youtube text-danger fs-5"></i>
                        <span>YouTube:
        <a href="https://www.youtube.com/@JohnKevinPaunel"
           target="_blank"
           class="fw-bold text-decoration-none text-dark-emphasis">John Kevin Paunel</a>
    </span>
                    </li>

                    <li class="my-3 d-flex align-items-center gap-2">
                        <i class="bi bi-facebook text-primary fs-5"></i>
                        <span>Facebook:
        <a href="https://www.facebook.com/johnkevinPaunelVlog"
           target="_blank"
           class="fw-bold text-decoration-none text-dark-emphasis">John Kevin Paunel</a>
    </span>
                    </li>

                    <li class="my-3 d-flex align-items-center gap-2">
                        <i class="bi bi-tiktok fs-5"></i>
                        <span>TikTok:
        <a href="https://www.tiktok.com/@johnkevinpaunel"
           target="_blank"
           class="fw-bold text-decoration-none text-dark-emphasis">John Kevin Paunel</a>
    </span>
                    </li>


                </ul>
            </div>

            <!-- RIGHT SIDE – CONTACT FORM -->
            <div class="col-md-6">
                <div class="card border-0 shadow-sm p-4 rounded-4">
                    <x-contact-form />
                </div>
            </div>

        </div>
    </div>
@endsection
