<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">

    <title>@yield('title')</title>
    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/sass/app.scss','resources/js/app.js'])
        @vite('resources/css/components/floating-tools.css')
    @endif
    @stack('css')
</head>
<body class="bg-lighta">
<div id="sidebarOverlay" class="sidebar-overlay"></div>

<div id="app-user-id" data-user-id="{{ auth()->id() }}">

<x-dashboard.navigation.menu/>

<!-- CONTENT -->
<div id="content" class="content-wrapper safe-area">
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
