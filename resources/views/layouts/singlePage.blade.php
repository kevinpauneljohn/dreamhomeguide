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
<body>

    <x-navigation.menus/>
    <div class="container-fluid single-page-banner">
        @section('bannerTitle')@show
    </div>
        @yield('content')
    <x-navigation.footer/>
@section('scripts')

@show
</body>
</html>
