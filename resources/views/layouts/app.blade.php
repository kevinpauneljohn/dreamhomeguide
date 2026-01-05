<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>
    @stack('seo')
    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/sass/app.scss','resources/js/app.js'])
    @endif
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');

        fbq('init', '{{ config('services.facebook.pixel_id') }}');
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
    <!-- Facebook Messenger Chat Plugin -->
    <div id="fb-root"></div>

    <script async defer crossorigin="anonymous"
            src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v19.0">
    </script>

    <div class="fb-customerchat"
         attribution="biz_inbox"
         page_id="1928768050502869">
    </div>


    <script>
        var chatbox = document.getElementById('fb-customer-chat');
        chatbox.setAttribute("page_id", "1928768050502869");
    </script>

    <script>
        window.fbAsyncInit = function () {
            FB.init({
                xfbml: true,
                version: 'v19.0'
            });
        };

        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = "https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>

</body>
</html>
