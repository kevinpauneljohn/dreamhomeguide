@extends('layouts.singlePage')

@section('title', $title)
@section('bannerTitle')
    <div class="container">
        <h1 class="single-page-banner-title">{{$title}}</h1>
    </div>
@endsection
@section('content')
    <div class="container py-5 w-75">
        <div class="row">
            <div class="col-md-6">
                <h2 class="mb-3 fw-lighter">Tell Us Your Inquiry</h2>
                <p class="section-description mb-5 text-muted">
                    We at Presello are committed to deliver the best brokering service in the market. Whether you are looking to sell your property or purchase your next investment, we are here to assist you.
                </p>
                <h4 class=" fw-lighter">You May Also Contact Us At</h4>
                <ul class="text-muted">
                    <li class="my-2">Viber or WhatsApp: <span class="fw-bold text-primary">+639171027662 </span>
                    <li class="my-2">Mobile No.:
                        <ul class="list-unstyled">
                            <li class="my-1"><span class="fw-bold text-primary"><a href="tel:+639171027662" class="text-decoration-none">+639171027662</a></span> (globe)</li>
                            <li class="my-1"><span class="fw-bold text-primary"><a href="tel:+639297096801" class="text-decoration-none">+639297096801</a></span> (smart)</li>
                        </ul>
                    </li>
                    <li class="my-2">Email: <span class="fw-bold"><a href="mailto:johnkevinpaunel@gmail.com" class="text-decoration-none text-dark-emphasis">johnkevinpaunel@gmail.com</a></span></li>
                    <li class="my-2">Youtube: <span class="fw-bold"><a href="https://www.youtube.com/@JohnKevinPaunel" target="_blank" class="text-decoration-none text-dark-emphasis">John Kevin Paunel</a></span></li>
                    <li class="my-2">Facebook: <span class="fw-bold"><a href="https://www.facebook.com/johnkevinPaunelVlog" target="_blank" class="text-decoration-none text-dark-emphasis">John Kevin Paunel</a></span></li>
                    <li class="my-2">Tiktok: <span class="fw-bold"><a href="https://www.tiktok.com/@johnkevinpaunel" target="_blank" class="text-decoration-none text-dark-emphasis">John Kevin Paunel</a></span></li>
                </ul>
            </div>
            <div class="col-md-6">
                <x-contact-form/>
            </div>
        </div>
    </div>
@endsection
