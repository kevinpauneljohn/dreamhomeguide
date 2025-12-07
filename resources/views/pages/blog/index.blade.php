@extends('layouts.singlePage')

@section('title', $title)

@section('bannerTitle')
    <div class="blog-banner">
        <div class="container">
            <h1 class="single-page-banner-title fw-bold">{{ $title }}</h1>
        </div>
    </div>
@endsection

@section('content')
    <div class="container py-5">
        <h4 class="mb-4">Insights, guides, and real estate knowledge for every homeowner and investor</h4>
        <div class="row g-4">

            @foreach($blogs as $blog)
                <x-blog.blog-card :blog="$blog" />
            @endforeach

        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-5">
            {{$blogs->links()}}
        </div>

    </div>
@endsection
