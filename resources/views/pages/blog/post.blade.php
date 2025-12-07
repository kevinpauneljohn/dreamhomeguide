@extends('layouts.singlePage')

@section('title', $title)
@section('bannerTitle')
    <div class="container">
        <h1 class="single-page-banner-title">{{$title}}</h1>
    </div>
@endsection
@section('content')

    <style>

    </style>



    {{-- =========================== --}}
    {{-- Breadcrumb --}}
    {{-- =========================== --}}
    <div class="container mt-3 mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('blogs')}}">Blogs</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ ucwords(strtolower($blog->title)) }}
                </li>
            </ol>
        </nav>
    </div>


    {{-- =========================== --}}
    {{-- BLOG MAIN LAYOUT --}}
    {{-- =========================== --}}
    <div class="container pb-5">
        <div class="row g-4">

            {{-- LEFT MAIN BLOG CONTENT --}}
            <div class="col-lg-8">

                {{-- Featured Image --}}
                <img src="/storage/blogs/{{$blog->thumbnail}}"
                     alt="{{$blog->title}}"
                     class="img-fluid w-100 blog-feature-image mb-4">

                {{-- Blog Title --}}
                <h1 class="fw-bold mb-3">{{ ucwords(strtolower($blog->title)) }}</h1>

                {{-- Author Box --}}
                <div class="author-box d-flex align-items-center gap-3 mb-4">
                    <img src="/storage/profile_pictures/{{$blog->user->profile_photo}}" alt="Author Photo">
                    <div>
                        <div class="fw-bold">{{ ucwords(strtolower($blog->user->full_name)) }}</div>
                        <small class="text-muted">
                            {{ $blog->created_at->format('F d, Y') }} •
                            <span id="reading-time" class="fw-semibold"></span> •
                            {{ ucwords(str_replace('-', ' ', $blog->category)) }}
                        </small>
                    </div>
                </div>

                {{-- Share Buttons --}}
                <div class="share-buttons mb-4">

                    {{-- Facebook --}}
                    <a class="share-btn share-fb"
                       href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                       target="_blank">
                        <i class="bi bi-facebook"></i>
                    </a>

                    {{-- Messenger --}}
                    <a class="share-btn share-msg"
                       href="https://www.facebook.com/dialog/send?link={{ urlencode(url()->current()) }}&app_id=YOUR_APP_ID&redirect_uri={{ urlencode(url()->current()) }}"
                       target="_blank">
                        <i class="bi bi-messenger"></i>
                    </a>

                    {{-- Twitter --}}
                    <a class="share-btn share-twt"
                       href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($blog->title) }}"
                       target="_blank">
                        <i class="bi bi-twitter"></i>
                    </a>

                    {{-- LinkedIn --}}
                    <a class="share-btn share-li"
                       href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&title={{ urlencode($blog->title) }}"
                       target="_blank">
                        <i class="bi bi-linkedin"></i>
                    </a>

                    {{-- Copy Link --}}
                    <div class="share-btn share-copy" onclick="copyBlogLink()">
                        <i class="bi bi-link-45deg"></i>
                    </div>

                </div>


                {{-- Blog Content --}}
                <div class="blog-content mt-4">
                    {!! $blog->blog_content !!}
                </div>

                {{-- Tags Section --}}
                <div class="mt-5">
                    <h5 class="fw-bold mb-3">Tags</h5>

                    @php $tags = explode(',', $blog->meta_keywords); @endphp

                    @foreach ($tags as $tag)
                        <span class="tag-badge">{{ ucwords(strtolower($tag)) }}</span>
                    @endforeach
                </div>
            </div>



            {{-- RIGHT SIDEBAR --}}
            <div class="col-lg-4">

                {{-- Promo card --}}
                <div class="card sidebar-card mb-4">
                    <img src="{{asset('/carousel/businessman-8825632_1280.jpg')}}" class="card-img-top">
                    <div class="card-body">
                        <p class="mb-0">
                            Looking for your dream home?<br>
                            I’ll personally guide you to the best options based on your lifestyle and goals.
                        </p>
                    </div>
                </div>

                {{-- Contact Form --}}
                <div class="card sidebar-card p-3">
                    <h5 class="fw-bold mb-3">Send an Inquiry</h5>
                    <x-contact-form />
                </div>

            </div>
        </div>



        {{-- =========================== --}}
        {{-- RELATED POSTS --}}
        {{-- =========================== --}}
        <div class="container pt-5">
            <h3 class="related-title mb-4">Related Posts</h3>

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach($relatedBlogs as $blog)
                    <x-blog.blog-card :blog="$blog" />
                @endforeach
            </div>
        </div>

    </div>

@endsection

@push('css')
    <style>
        .share-buttons {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .share-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            color: white;
            font-size: 1.1rem;
            transition: .25s ease;
            cursor: pointer;
        }

        .share-btn:hover {
            transform: translateY(-4px);
            opacity: 0.9;
        }

        .share-fb { background: #1877f2; }
        .share-msg { background: #0084ff; }
        .share-twt { background: #1da1f2; }
        .share-li { background: #0a66c2; }
        .share-copy { background: #6c757d; }

    </style>
@endpush

@push('scripts')
    @vite(['resources/js/pages/blog-post.js'])
@endpush
