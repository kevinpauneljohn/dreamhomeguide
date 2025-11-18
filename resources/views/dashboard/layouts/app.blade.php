<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>
    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/sass/app.scss','resources/js/app.js'])
    @endif
</head>
<body class="bg-light">

<x-dashboard.navigation.menu/>

<!-- CONTENT -->
<div id="content" class="content-wrapper">
    <x-dashboard.navigation.top-nav/>
    <div class="container-fluid">
        @yield('content')
    </div>
</div>

@vite(['resources/js/dashboard/app.js'])
@stack('scripts')


</body>
</html>
