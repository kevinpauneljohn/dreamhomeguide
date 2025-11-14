@extends('layouts.singlePage')

@section('title', $title)
@section('bannerTitle')
    <div class="container">
        <h1 class="single-page-banner-title">{{$title}}</h1>
    </div>
@endsection
@section('content')
    <div class="container pt-3 pb-3 mt-5 d-flex justify-content-between align-items-center">
        <span id="result" class="fw-semibold fs-3">20 Results</span>

        <a href="#" id="reset-search" class="text-decoration-none text-secondary d-flex align-items-center gap-2">
            <i class="fa fa-undo"></i>
            <span>Reset Search</span>
        </a>
    </div>
    <div class="container p-5 shadow-lg">
        <x-search-property-full-form/>
    </div>
    <div class="container py-5">
        <x-property-listings/>
    </div>
@endsection
