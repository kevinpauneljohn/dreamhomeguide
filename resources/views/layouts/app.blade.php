<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="manifest" href="{{ asset('manifest.json') }}">

    <meta name="theme-color" content="#0d6efd">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">

    <title>@yield('title')</title>
    @stack('seo')
    <!-- Styles / Scripts -->
{{--    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))--}}
{{--        @vite(['resources/sass/app.scss','resources/js/app.js'])--}}
{{--    @endif--}}
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(reg => console.log('SW registered', reg))
                    .catch(err => console.error('SW failed', err));
            });
        }
    </script>

    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');

        fbq('init', '{{ env('FACEBOOK_PIXEL_ID') }}' );
        fbq('track', 'PageView');
    </script>
    <noscript>
        <img height="1" width="1" style="display:none"
             src="https://www.facebook.com/tr?id={{ env('FACEBOOK_PIXEL_ID') }}&ev=PageView&noscript=1"
        />
    </noscript>
    @vite(['resources/sass/app.scss','resources/js/app.js'])
    @stack('css')
    <!-- Meta Pixel Code -->
    @stack('meta')
</head>
<body>

    <x-navigation.menus/>
        @yield('content')
    <x-navigation.footer/>
    @stack('scripts')
</body>
</html>
