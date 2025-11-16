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
                <h2 class="fw-lighter">Your Vision Unrestricted</h2>
                <p class="text-muted">
                    <strong>Houzez is a premium WordPress theme for real estate agents and agencies</strong> where
                    modern aesthetics are combined with a tasteful simplicity
                    and where the ease of use is achieved without compromise in your
                    ability to customize the design.
                </p>
                <p class="text-muted">
                    Whether you are a real estate agent looking to build a website
                    for your company or a web developer seeking a perfect
                    WordPress theme for your next project, you are certain
                    to appreciate the numerous features and benefits that
                    our theme provides.
                </p>
            </div>
            <div class="col-md-6">
                <p class="text-muted">
                    Houzez is also a WordPress-based property management system which allows you to own and maintain a real estate marketplace, coordinate your agents, accept submissions and offer membership packages.
                </p>
                <p class="text-muted">
                    Unlike many other real estate themes which confine you to a handful of predefined layouts, Houzez offers a limitless array of possibilities to structure and style your content. All of the customization options are logically organized in your WordPress admin panel and thorough customization in the provided documentation.
                </p>
            </div>
        </div>
    </div>

    <div class="container-fluid p-5 bg-secondary-subtle">
        <div class="container p-2">
            <h2 class="text-center">Meet Our Team</h2>
            <p class="mb-5 text-center">Lorem ipsum dolor sit amet, consectetur adipisicing elit</p>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 mb-5">
                <div class="col">
                    <x-card-profile
                        imageUrl="https://images.pexels.com/photos/1222271/pexels-photo-1222271.jpeg?auto=compress&cs=tinysrgb&h=750&w=1260"
                        name="JOHN KEVIN PAUNEL"
                        role="CEO & Founder"
                    />
                </div>
                <div class="col">
                    <x-card-profile
                        imageUrl="https://tse1.mm.bing.net/th/id/OIP.-q_t4DefnfAF-3Jf271WSwHaFc?w=626&h=460&rs=1&pid=ImgDetMain&o=7&rm=3"
                        name="JOHN KEVIN PAUNEL"
                        role="CEO & Founder"
                    />
                </div>
                <div class="col">
                    <x-card-profile
                        imageUrl="https://tse1.mm.bing.net/th/id/OIP.qPFvljdWQWAKm9NUM_NUvgHaDt?rs=1&pid=ImgDetMain&o=7&rm=3"
                        name="JOHN KEVIN PAUNEL"
                        role="CEO & Founder"
                    />
                </div>
                <div class="col">
                    <x-card-profile
                        imageUrl="https://tse1.mm.bing.net/th/id/OIP.xngmei78BNsh21wH8xyj-wHaJ4?rs=1&pid=ImgDetMain&o=7&rm=3"
                        name="JOHN KEVIN PAUNEL"
                        role="CEO & Founder"
                    />
                </div>
            </div>
        </div>
    </div>

    <div class="container p-5">
        <h2 class="text-center mb-3 section-title w-100">How Can We Help You?</h2>
        <p class="section-description text-center">
            We at Presello are committed to deliver the best brokering service in the market. Whether you are looking to sell your property or purchase your next investment, we are here to assist you.
        </p>
        <x-service-offered/>
    </div>
@endsection
