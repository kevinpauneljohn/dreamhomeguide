@extends('layouts.app')

@section('title', $title)
@section('content')
    <x-carousel />

    <div class="container-fluid p-5 bg-primary text-white">
        <div class="container">
            <h2 class="text-center">Move Online</h2>
            <p class="text-center mb-4">
                Search for your next property to buy or rent in the Philippines
            </p>
            <div class="search-form pt-3 px-3">
                <x-search-property />
            </div>
        </div>
    </div>
    <div class="container-fluid p-5">
        <div class="container mt-4">
            <h2 class="text-center mb-5 section-title w-100">Featured Properties</h2>
            <x-featured-properties />
        </div>
    </div>
    <div class="container-fluid p-5">
        <div class="container mt-4 home-services-container">
            <h2 class="text-center mb-3 section-title w-100">How Can We Help You?</h2>
            <p class="section-description text-center">
                We at Presello are committed to deliver the best brokering service in the market. Whether you are looking to sell your property or purchase your next investment, we are here to assist you.
            </p>

            <x-service-offered/>
        </div>
    </div>

    <div class="container-fluid p-5 bg-secondary-subtle">
        <div class="container home-contact-form-container mt-4 mb-4">
            <div class="row">
                <div class="col-lg-6">
                    <h2 class="mb-3">Tell Us Your Inquiry</h2>
                    <p class="section-description mb-5">
                        We at Presello are committed to deliver the best brokering service in the market. Whether you are looking to sell your property or purchase your next investment, we are here to assist you.
                    </p>
                    <h4>You May Also Contact Us At</h4>
                    <ul>
                        <li>Viber or WhatsApp: +639171027662</li>
                        <li>Mobile No.: +639171027662 (globe) / +639297096801 (smart)</li>
                    </ul>
                </div>
                <div class="col-lg-6">
                    <x-contact-form />
                </div>
            </div>
        </div>
    </div>
@endsection
