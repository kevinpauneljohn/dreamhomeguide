<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/sass/app.scss','resources/js/app.js'])
        @vite('resources/css/components/floating-tools.css')
    @endif
    @stack('css')
</head>
<body class="bg-light">
<div id="app-user-id" data-user-id="{{ auth()->id() }}">

<x-dashboard.navigation.menu/>

<!-- CONTENT -->
<div id="content" class="content-wrapper">
    <x-dashboard.navigation.top-nav/>

    <div class="container-fluid">
        <x-floating-tools />
        <x-notifications />
        @yield('content')
    </div>
</div>


@stack('modal')

@vite(['resources/js/dashboard/app.js'])
@stack('scripts')
</body>
</html>
