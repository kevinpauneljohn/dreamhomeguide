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
                <li class="breadcrumb-item"><a href="{{route('blog.index')}}" class="text-decoration-none">Blogs</a></li>
                <li class="breadcrumb-item active" aria-current="page">Inside of a Modern House and Lot for Sale in South Forbes, Makati City</li>
            </ol>
        </nav>
    </div>
    <div class="container pt-3 pb-5">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Inside of a Modern House and Lot for Sale in South Forbes, Makati City</h3>

                        <div class="my-3">
                            <img src="https://images.pexels.com/photos/1222271/pexels-photo-1222271.jpeg?auto=compress&cs=tinysrgb&h=750&w=1260" class="img-thumbnail rounded-circle author-img-thumbnail" alt="thumbnail">
                            <span class="ms-2 fw-lighter">By: <span class="text-primary">John Kevin Paunel</span></span>
                            <span class="ms-2 fw-lighter">On: <span class="text-primary">2021-08-20</span></span>
                            <span class="ms-2 fw-lighter">Category: <span class="text-primary">Real Estate</span></span>
                        </div>

                        <img src="https://wallpaperaccess.com/full/1859346.jpg" class="img-fluid" alt="...">
                        <p class="card-text mt-4">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis mollis et sem sed sollicitudin. Donec non odio neque. Aliquam hendrerit sollicitudin purus, quis rutrum mi accumsan nec. Quisque bibendum orci ac nibh facilisis, at malesuada orci congue. Nullam tempus sollicitudin cursus. Ut et adipiscing erat. Curabitur this is a text link libero tempus congue.
                            Duis mattis laoreet neque, et ornare neque sollicitudin at. Proin sagittis dolor sed mi elementum pretium. Donec et justo ante. Vivamus egestas sodales est, eu rhoncus urna semper eu. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Integer tristique elit lobortis purus bibendum, quis dictum metus mattis. Phasellus posuere felis sed eros porttitor mattis. Curabitur massa magna, tempor in blandit id, porta in ligula. Aliquam laoreet nisl massa, at interdum mauris sollicitudin et.
                        </p>
                        <h3>Quisque this is a link nibh facilisis at malesuada</h3>
                        <p class="card-text mt-4">
                            Nullam tempus sollicitudin cursus. Nulla elit mauris, volutpat eu varius malesuada, pulvinar eu ligula. Ut et adipiscing erat. Curabitur adipiscing erat vel libero tempus congue. Nam pharetra interdum vestibulum. Aenean gravida mi non aliquet porttitor. Praesent dapibus, nisi a faucibus tincidunt, quam dolor condimentum metus, in convallis libero ligula ut eros.
                        </p>
                        <p class="card-text mt-4">
                            Nullam tempus sollicitudin cursus. Nulla elit mauris, volutpat eu varius malesuada, pulvinar eu ligula. Ut et adipiscing erat. Curabitur adipiscing erat vel libero tempus congue. Nam pharetra interdum vestibulum. Aenean gravida mi non aliquet porttitor. Praesent dapibus, nisi a faucibus tincidunt, quam dolor condimentum metus, in convallis libero ligula ut eros.
                        </p>
                        <p class="fs-4 fw-light border-start ps-3 border-5">
                            Duis mollis et sem sed sollicitudin. Donec non odio neque. Aliquam hendrerit sollicitudin purus,
                        </p>
                        <h3>Quisque this is a link nibh facilisis at malesuada</h3>
                        <ul class="mt-4">
                            <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</li>
                            <li>
                                Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                                <ol>
                                    <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</li>
                                    <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</li>
                                </ol>
                            </li>
                        </ul>
                    </div>
                    <hr/>
                    <div class="p-3">
                        <h4>Tags</h4>
                        <span class="badge text-bg-info">Apartment</span>
                        <span class="badge text-bg-info">Business Development</span>
                        <span class="badge text-bg-info">House for families</span>
                        <span class="badge text-bg-info">Luxury</span>
                    </div>
                </div>
                <div class="container py-5">
                    <h3>Related Posts</h3>
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                        <div class="col">
                            <div class="card h-100">
                                <a href="{{route('blog.show',['blog' => 1])}}">
                                    <img src="https://wallpaperaccess.com/full/1859346.jpg" class="card-img-top featured-property-image" alt="...">
                                </a>

                                <div class="card-body">
                                    <h3 class="card-title">Why Live in Milano</h3>
                                    <p class="card-text">Inside of a Modern House and Lot for Sale in South Forbes, Makati City <a href="#">[more]</a></p>
                                    <div class="d-flex justify-content-between mt-4">
                            <span class="text-muted fw-lighter">
                                By: John Kevin Paunel
                            </span>
                                        <span class="text-muted fw-lighter">
                                November 11, 2025
                            </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100">
                                <a href="{{route('blog.show',['blog' => 1])}}">
                                    <img src="https://wallpaperaccess.com/full/1859346.jpg" class="card-img-top featured-property-image" alt="...">
                                </a>

                                <div class="card-body">
                                    <h3 class="card-title">Why Live in Milano</h3>
                                    <p class="card-text">Inside of a Modern House and Lot for Sale in South Forbes, Makati City <a href="#">[more]</a></p>
                                    <div class="d-flex justify-content-between mt-4">
                            <span class="text-muted fw-lighter">
                                By: John Kevin Paunel
                            </span>
                                        <span class="text-muted fw-lighter">
                                November 11, 2025
                            </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100">
                                <a href="{{route('blog.show',['blog' => 1])}}">
                                    <img src="https://wallpaperaccess.com/full/1859346.jpg" class="card-img-top featured-property-image" alt="...">
                                </a>

                                <div class="card-body">
                                    <h3 class="card-title">Why Live in Milano</h3>
                                    <p class="card-text">Inside of a Modern House and Lot for Sale in South Forbes, Makati City <a href="#">[more]</a></p>
                                    <div class="d-flex justify-content-between mt-4">
                            <span class="text-muted fw-lighter">
                                By: John Kevin Paunel
                            </span>
                                        <span class="text-muted fw-lighter">
                                November 11, 2025
                            </span>
                                    </div>
                                </div>
                            </div>
                        </div>
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
@endsection
