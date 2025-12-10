@extends('layouts.singlePage')

@section('title', $title)
@push('seo')
    <x-seo title="{{$title}} — {{url('/')}}" />
@endpush

@section('bannerTitle')
    <div class="blog-banner">
        <div class="container">
            <h1 class="single-page-banner-title fw-bold">{{ $title }}</h1>
        </div>
    </div>
@endsection

@section('content')
    <div class="container py-5">
        <h4 class="mb-4 text-center fw-semibold text-uppercase mb-4" style="font-size: 0.95rem; letter-spacing: 2px; color:#555;">
            Insights • Guides • Real Estate Knowledge
        </h4>


        <div class="row g-4">

            @if($blogs->count() > 0)
                @foreach($blogs as $blog)
                    <x-blog.blog-card :blog="$blog" />
                @endforeach

            @else
                <div class="col-12">
                    <div class="text-center py-5 my-5">

                        <i class="bi bi-journal-text text-secondary" style="font-size: 4rem;"></i>

                        <h2 class="fw-bold mt-3">Blog Articles Coming Soon</h2>

                        <p class="text-muted mx-auto" style="max-width: 600px;">
                            We're working on helpful guides, market insights, and real estate tips to empower homebuyers and investors.
                            Check back again soon!
                        </p>

                    </div>
                </div>
            @endif

        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-5">
            {{$blogs->links()}}
        </div>

    </div>
@endsection

@push('meta')
    <script>
        fbq('track', 'ViewContent', {
            content_name: 'Blog Page',
            content_category: 'Blog'
        });
    </script>
@endpush
