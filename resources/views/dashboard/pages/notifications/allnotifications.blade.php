@extends('dashboard.layouts.app')
@section('title', $title)
@section('content')



@endsection

@push('scripts')
    @vite('resources/js/dashboard/leads/create.js')
@endpush
