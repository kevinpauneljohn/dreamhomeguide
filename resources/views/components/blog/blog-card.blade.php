<div class="col-12 col-md-6 col-lg-4">
    <div class="card blog-card h-100">

        <a href="{{ route('blog-post', ['slug' => $blog->slug]) }}">
            <img src="/storage/blogs/{{$blog->thumbnail}}" class="card-img-top" alt="">
        </a>

        <div class="card-body">

            <!-- Tag -->
            <span class="badge badge-tag mb-2">Real Estate</span>

            <!-- Title -->
            <h4 class="card-title fw-bold">
                {{ucwords(strtolower($blog->title))}}
            </h4>

            <!-- Excerpt -->
            <p class="blog-excerpt">
                {{$blog->meta_description}}
            </p>

            <!-- Author + Date -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <span class="blog-meta">By {{ucwords(strtolower($blog->user->full_name))}}</span>
                <span class="blog-meta">{{$blog->created_at->format('F d, Y')}}</span>
            </div>

            <!-- Read more -->
            <a href="{{ route('blog-post', ['slug' => $blog->slug]) }}" class="btn btn-dark btn-sm mt-3 w-100">
                Read Article →
            </a>

        </div>

    </div>
</div>
