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
                <li class="breadcrumb-item active" aria-current="page">Inside of a Modern House and Lot for Sale in South Forbes, Makati City</li>
            </ol>
        </nav>
    </div>
<div class="container py-2">
    <x-listing-images />
</div>
    <div class="container py-3 mb-5">
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header p-3">
                        <div class="d-flex justify-content-between">
                            <div>
                                <span class="badge rounded-pill text-bg-success">Featured</span>
                                <span class="badge rounded-pill text-bg-danger">Buy</span>
                            </div>
                            <div>
                                <i class="fa fa-share-alt text-secondary share-icon mx-1" title="Share"></i>
                                <i class="fa fa-heart text-secondary add-to-favorite-icon mx-1" title="Add to favorites"></i>
                                <i class="fa fa-code-compare text-secondary compare-icon mx-1" title="Compare"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <h2 class="property-title">
                            Inside of a Modern House and Lot for Sale in South Forbes, Makati City
                        </h2>
                        <div class="d-flex justify-content-between align-items-baseline">
                            <span class="property-price mt-4 text-primary fs-4 fw-bold">
                                &#8369 21,500,000
                            </span>
                            <div class="text-muted">
                                <i class="fa fa-map-marker-alt"></i>
                                <span>Dau, Mabalacat, Pampanga</span>
                            </div>
                        </div>


                        <hr/>

                        <div class="row row-cols-2 row-cols-md-4 row-cols-lg-5 g-4">
                            <div class="col">
                                <h5>Apartment</h5>
                                <span class="text-muted">Property Type</span>
                            </div>
                            <div class="col">
                                <i class="fa-solid fa-bed fa-xl text-orange"></i>
                                <span class="">4 </span>
                                <div class="text-muted">Bedrooms</div>
                            </div>
                            <div class="col">
                                <i class="fa-solid fa-shower fa-xl text-orange"></i>
                                <span class="">4 </span>
                                <div class="text-muted">Bathroom</div>
                            </div>
                            <div class="col">
                                <i class="fa-solid fa-car-alt fa-xl text-orange"></i>
                                <span class="">4 </span>
                                <div class="text-muted">Carport</div>
                            </div>
                            <div class="col">
                                <i class="fa-solid fa-arrows-alt fa-xl text-orange"></i>
                                <span class="">500 sqm </span>
                                <div class="text-muted">Area Size</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="text-muted">Description</h5>
                    </div>
                    <div class="card-body p-3">
                        <p>
                            Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.
                        </p>
                        <p>
                            Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem. Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima. Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum.
                        </p>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Video House Tour</h4>
                    </div>
                    <div class="card-body">
                        <iframe width="100%" height="500" src="https://www.youtube.com/embed/0LaIJHEikIg?si=W5XVBNnO0flaM58p" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="https://na.rdcpix.com/2004563991/ab56a5a91431644dc57e031e9b665a54w-c199274xd-w685_h860_q80.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body p-3">
                        <x-contact-form/>
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


