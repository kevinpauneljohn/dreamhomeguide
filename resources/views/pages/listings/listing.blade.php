@extends('layouts.singlePage')

@section('title', $title)
@section('bannerTitle')
    <div class="container">
        <h1 class="single-page-banner-title">{{$title}}</h1>
    </div>
@endsection
@section('content')
    <div class="container pt-3 pb-3 mt-5 d-flex justify-content-between align-items-center">
        <span id="result" class="fw-semibold fs-3">{{$searchQueryCount}} {{\Illuminate\Support\Str::plural('Result', $searchQueryCount)}}</span>

        <a href="#" id="reset-search" class="text-decoration-none text-secondary d-flex align-items-center gap-2">
            <i class="fa fa-undo"></i>
            <span>Reset Search</span>
        </a>
    </div>
    <div class="container p-5 shadow-lg">
        <x-search-property-full-form/>
    </div>
    <div class="container py-5">
        {{$properties->links()}}
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-5">
            @foreach($properties as $property)
                <x-properties.property-card :property="$property"/>
            @endforeach
        </div>
        {{$properties->links()}}
    </div>
@endsection

@push('scripts')
    @vite(['resources/js/pages/search-property-full-form.js'])
@endpush
