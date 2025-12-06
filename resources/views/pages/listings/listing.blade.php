@extends('layouts.singlePage')

@section('title', $title)

@section('bannerTitle')
    <div class="container text-center py-5">
        <h1 class="single-page-banner-title fw-bold">{{$title}}</h1>
        <p class="text-light opacity-75 mt-2">
            Browse premium homes, curated listings, and top investment-ready properties.
        </p>
    </div>
@endsection

@section('content')

    {{-- HERO + FLOATING SEARCH --}}
    <div class="listing-hero position-relative">
        <div class="container text-center py-5">
            <h3 class="fw-semibold text-dark">Found {{$searchQueryCount}} {{ Str::plural('Property', $searchQueryCount) }}</h3>
            <p class="text-muted">Refine your search to find the perfect home.</p>
        </div>

        {{-- FLOATING SEARCH CARD --}}
        <div class="container position-relative">
            <div class="floating-search-card shadow-lg rounded-4 p-4 p-lg-5 bg-white">
                <x-search-property-full-form/>
            </div>
        </div>
    </div>

    {{-- SORT + RESET --}}
    <div class="container mt-5 pt-5 pb-2 d-flex justify-content-between align-items-center">

        {{-- Sort Bar --}}
        <div class="d-flex align-items-center gap-2 sort-bar">
            <span class="text-muted small">Sort:</span>
            <a href="#" class="sort-link">Newest</a>
            <a href="#" class="sort-link">Price: Low to High</a>
            <a href="#" class="sort-link">Price: High to Low</a>
            <a href="#" class="sort-link">Most Viewed</a>
        </div>

        {{-- Reset --}}
        <a href="#" id="reset-search" class="text-decoration-none text-secondary d-flex align-items-center gap-2">
            <i class="fa fa-undo"></i>
            <span>Reset Search</span>
        </a>
    </div>

    {{-- PROPERTY LIST --}}
    <div class="container pb-5">

        {{-- TOP PAGINATION --}}
        <div class="d-flex justify-content-center mb-4">
            {{ $properties->links() }}
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($properties as $property)
                <div class="col">
                    <div class="property-card shadow-sm rounded-4 overflow-hidden">
                        <x-properties.property-card :property="$property"/>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- BOTTOM PAGINATION --}}
        <div class="d-flex justify-content-center mt-5">
            {{ $properties->links() }}
        </div>
    </div>

@endsection

@push('styles')
    <style>

        /* HERO SECTION */
        .listing-hero {
            background: linear-gradient(to bottom, #ffffff, #f5f7fa);
            padding-bottom: 60px;
        }

        /* FLOATING SEARCH BOX */
        .floating-search-card {
            position: relative;
            top: -50px;
            border: 1px solid rgba(0,0,0,0.06);
            backdrop-filter: blur(8px);
        }

        /* SORT BAR */
        .sort-link {
            padding: 4px 10px;
            border-radius: 6px;
            text-decoration: none;
            color: #0d6efd;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .sort-link:hover {
            background-color: #e9f2ff;
        }

        /* PROPERTY CARD EFFECT */
        .property-card {
            transition: 0.25s ease;
            background: #fff;
            border-radius: 20px;
        }

        .property-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 35px rgba(0,0,0,0.12);
        }

        /* PAGINATION STYLE */
        .pagination {
            gap: 8px;
        }

        .page-link {
            border-radius: 10px !important;
            padding: 8px 14px;
            font-size: 0.9rem;
        }

        .page-item.active .page-link {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #000;
        }
    </style>
@endpush

@push('scripts')
    @vite(['resources/js/pages/search-property-full-form.js'])
@endpush
