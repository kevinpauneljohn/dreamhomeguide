@extends('layouts.singlePage')

@section('title', $title)
@section('bannerTitle')
    <div class="container">
        <h1 class="single-page-banner-title">{{$title}}</h1>
    </div>
@endsection
@section('content')
    <div class="container mt-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('listing.index')}}" class="text-decoration-none">Listings</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ucwords(strtolower($property->title))}}</li>
            </ol>
        </nav>
    </div>
<div class="container py-2">
    <x-listing-images propertyId="{{$property->id}}"/>
</div>
    <div class="container py-3 mb-5">
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header p-3">
                        <div class="d-flex justify-content-between">
                            <div>
                                @if($property->is_featured)<span class="badge rounded-pill text-bg-success">Featured</span> @endif
                                <span class="badge rounded-pill text-bg-danger">{{$property->property_type}}</span>
                            </div>
                            <div>
                                <i class="fa fa-share-alt text-secondary share-icon mx-1" title="Share"></i>
                                <i class="fa fa-heart text-secondary add-to-favorite-icon mx-1" title="Add to favorites"></i>
                                <i class="fa fa-code-compare text-secondary compare-icon mx-1" title="Compare"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <h3 class="property-title">
                            {{ucwords(strtolower($property->title))}}
                        </h3>
                        <div class="d-flex justify-content-between align-items-baseline">
                            <span class="property-price mt-4 text-primary fs-4 fw-bold">
                                &#8369 {{number_format($property->price,2)}}
                            </span>
                            <div class="text-muted">
                                <i class="fa fa-map-marker-alt"></i>
                                <span>{{$property->location}}</span>
                            </div>
                        </div>


                        <hr/>

                        <div class="row row-cols-2 row-cols-md-4 row-cols-lg-5 g-4">
                            <div class="col">
                                <h5>{{$property->property_category}}</h5>
                                <span class="text-muted">Property Type</span>
                            </div>
                            @if(!is_null($property->bedrooms))
                                <div class="col">
                                    <i class="fa-solid fa-bed fa-xl text-orange"></i>
                                    <span class="">{{$property->bedrooms}} </span>
                                    <div class="text-muted">Bedrooms</div>
                                </div>
                            @endif

                            @if(!is_null($property->bathrooms))
                                <div class="col">
                                    <i class="fa-solid fa-shower fa-xl text-orange"></i>
                                    <span class="">{{$property->bathrooms}} </span>
                                    <div class="text-muted">Bathrooms</div>
                                </div>
                            @endif

                            @if(!is_null($property->garage))
                                <div class="col">
                                    <i class="fa-solid fa-car-alt fa-xl text-orange"></i>
                                    <span class="">{{$property->garage}} </span>
                                    <div class="text-muted">Carport</div>
                                </div>
                            @endif

                            @if(!is_null($property->lot_area))
                                <div class="col">
                                    <i class="fa-solid fa-arrows-alt fa-xl text-orange"></i>
                                    <span class="">{{$property->lot_area}} sqm </span>
                                    <div class="text-muted">Area Size</div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="text-muted">Description</h5>
                    </div>
                    <div class="card-body p-3">
                        {!! $property->description !!}
                    </div>
                </div>

                @if(!empty($property->youtube_video_id))
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4>Video House Tour</h4>
                        </div>
                        <div class="card-body">
                            <iframe width="100%" height="500" src="https://www.youtube.com/embed/{{$property->youtube_video_id}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        </div>
                    </div>
                @endif

            </div>
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="{{asset('/carousel/businessman-8825632_1280.jpg')}}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <p class="card-text">Looking to learn more about this unit? Contact us today for full pricing details, payment options, and a personalized consultation.</p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body p-3">
                        <x-contact-form propertyId="{{$property->id}}"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid py-5">
        <h2 class="text-center mb-3 section-title w-100">Suggested Properties</h2>
        <div class="container py-3">
            <x-suggested-properties/>
        </div>
    </div>
@endsection


