@extends('dashboard.layouts.app')

@section('title', $title)

@push('css')
    @vite(['resources/css/dashboard.css'])
@endpush

@section('content')

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">{{$title}}</h3>
            <small class="text-muted">Edit your articles to grow your brand & educate your audience</small>
        </div>

        <a href="{{ route('blog.index') }}" class="btn btn-light border px-4">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    {{-- Breadcrumb --}}
    <div class="card mb-4">
        <div class="card-body">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('blog.index') }}">Blogs</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Blog</li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- Blog Form --}}
    <input type="hidden" id="blog_id" value="{{ $blog->id }}">
    <form id="edit-blog-form" enctype="multipart/form-data">
        @csrf

        <div class="card mb-4">
            <div class="card-body">

                <div class="row g-4">

                    {{-- Title --}}
                    <div class="col-md-12 title">
                        <label class="form-label fw-semibold">Blog Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="Enter blog title" value="{{$blog->title}}">
                    </div>

                    {{-- Title --}}
                    <div class="col-md-12 slug">
                        <label class="form-label fw-semibold">Slug <span class="text-danger">*</span></label>
                        <input type="text" name="slug" id="slug" class="form-control" placeholder="Enter slug" value="{{$blog->slug}}">
                    </div>

                    {{-- Category --}}
                    <div class="col-md-6 category">
                        <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                        <select name="category" id="category" class="form-select">
                            <option value="">Select Category</option>
                            @foreach($blogCategories as $key => $category)
                                <option value="{{ $key }}" @if($blog->category === $key) selected @endif>{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Status --}}
                    <div class="col-md-6 status">
                        <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-select">
                            @foreach($blogStatus as $key => $status)
                                <option value="{{ $key }}" @if($blog->status === $key) selected @endif>{{ $status['label'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Featured Image --}}
                    <div class="col-md-6 thumbnail">
                        <label class="form-label fw-semibold">Thumbnail <span class="text-danger">*</span></label>
                        <input type="file" name="thumbnail" id="thumbnail" class="form-control">
                        <small class="text-muted">Recommended size: 1200 x 600px</small>
                    </div>

                </div>

            </div>
        </div>

        {{-- Content Section --}}
        <div class="card mb-4">
            <div class="card-body">
                <input type="hidden" name="content" value="{{ $blog->blog_content }}">
                <label class="form-label fw-semibold">Content <span class="text-danger ">*</span></label>
                <span class="blog_content"></span>
                <textarea name="blog_content" id="blog_content" class="form-control"></textarea>
            </div>
        </div>

        {{-- SEO Section --}}
        <div class="card mb-4">
            <div class="card-header bg-light fw-bold">SEO Settings (Optional)</div>
            <div class="card-body">
                <div class="row g-4">

                    <div class="col-md-6">
                        <label class="form-label">Meta Title</label>
                        <input type="text" name="meta_title" class="form-control" value="{{ $blog->meta_title }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Meta Keywords</label>
                        <input type="text" name="meta_keywords" class="form-control" placeholder="e.g. real estate, pampanga, bahay for sale" value="{{ $blog->meta_keywords }}">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Meta Description</label>
                        <textarea name="meta_description" class="form-control" rows="3">{{$blog->meta_description}}</textarea>
                    </div>

                </div>
            </div>
        </div>


        {{-- Submit Button --}}
        <div class="text-end mb-5">
            <button type="submit" class="btn btn-primary px-5 save-blog-btn">
                <i class="bi bi-save"></i> Update Blog
            </button>
        </div>

    </form>

@endsection

@push('scripts')
    @vite(['resources/js/dashboard/blogs/edit.js'])
@endpush
