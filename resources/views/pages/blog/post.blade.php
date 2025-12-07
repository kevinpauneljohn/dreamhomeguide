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
                <li class="breadcrumb-item"><a href="{{route('blogs')}}" class="text-decoration-none">Blogs</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ucwords(strtolower($blog->title))}}</li>
            </ol>
        </nav>
    </div>
    <div class="container pt-3 pb-5">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">{{ucwords(strtolower($blog->title))}}</h3>

                        <div class="my-3">
                            <img src="/storage/profile_pictures/{{$blog->user->profile_photo}}" class="img-thumbnail rounded-circle author-img-thumbnail" alt="{{$blog->user->full_name}}">
                            <span class="ms-2 fw-lighter">By: <span class="text-primary">{{ucwords(strtolower($blog->user->full_name))}}</span></span>
                            <span class="ms-2 fw-lighter">On: <span class="text-primary">{{$blog->created_at->format('F d, Y')}}</span></span>
                            <span class="ms-2 fw-lighter">Category: <span class="text-primary">{{ucwords(strtolower(str_replace('-',' ',$blog->category)))}}</span></span>
                        </div>

                        <img src="/storage/blogs/{{$blog->thumbnail}}" class="img-fluid w-100" alt="{{$blog->title}}">
                        <p class="card-text mt-4">
                            {!! $blog->blog_content !!}
                        </p>
                    </div>
                    <hr/>
                    <div class="px-3 py-2">
                        <h4>Tags</h4>
                        @php
                            $tags = explode(',', $blog->meta_keywords)
                        @endphp
                        @foreach($tags as $tag)
                            <span class="badge text-bg-info">{{ucwords(strtolower($tag))}}</span>
                        @endforeach
                    </div>
                </div>

            </div>
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="{{asset('/carousel/businessman-8825632_1280.jpg')}}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <p class="card-text">
                            Looking for Your Dream Home?<br>
                            Let me help you find the perfect property that matches your lifestyle, budget,
                            and long-term goals. Send your inquiry below and I’ll personally assist you.
                        </p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body p-3">
                        <x-contact-form/>
                    </div>
                </div>
            </div>
        </div>
        <div class="container py-5">
            <h3>Related Posts</h3>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach($relatedBlogs as $blog)
                    <x-blog.blog-card :blog="$blog" />
                @endforeach
            </div>
        </div>
    </div>
@endsection
