@extends('layouts.singlePage')

@section('title', $title)

@section('bannerTitle')
    <div class="blog-banner">
        <div class="container">
            <h1 class="single-page-banner-title fw-bold">{{ $title }}</h1>
            <p class="lead">Insights, guides, and real estate knowledge for every homeowner and investor</p>
        </div>
    </div>
@endsection

@section('content')
    <div class="container py-5">

        <div class="row g-4">

            @foreach(range(1,9) as $i)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card blog-card h-100">

                        <a href="{{ route('blog.show', ['blog' => $i]) }}">
                            <img src="https://wallpaperaccess.com/full/1859346.jpg" class="card-img-top" alt="">
                        </a>

                        <div class="card-body">

                            <!-- Tag -->
                            <span class="badge badge-tag mb-2">Real Estate</span>

                            <!-- Title -->
                            <h4 class="card-title fw-bold">
                                Why Live in Milano
                            </h4>

                            <!-- Excerpt -->
                            <p class="blog-excerpt">
                                Inside a Modern House and Lot for Sale in South Forbes. Explore the design, features, lifestyle, and investment potential of living in Milano...
                            </p>

                            <!-- Author + Date -->
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="blog-meta">By John Kevin Paunel</span>
                                <span class="blog-meta">Nov 11, 2025</span>
                            </div>

                            <!-- Read more -->
                            <a href="{{ route('blog.show', ['blog' => $i]) }}" class="btn btn-dark btn-sm mt-3 w-100">
                                Read Article →
                            </a>

                        </div>

                    </div>
                </div>
            @endforeach

        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-5">
            <nav>
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                        <span class="page-link">Previous</span>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
        </div>

    </div>
@endsection
