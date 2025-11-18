@extends('dashboard.layouts.app')

@section('title', $title)
@section('content')
    <!-- PAGE HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">{{ucfirst($title)}}</h4>

{{--        <nav aria-label="breadcrumb">--}}
{{--            <ol class="breadcrumb mb-0">--}}
{{--                <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Home</a></li>--}}
{{--                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>--}}
{{--            </ol>--}}
{{--        </nav>--}}
    </div>

<div class="container-fluid">
    Welcome to the Dashboard
</div>
@endsection
