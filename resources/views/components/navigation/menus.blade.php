<nav class="navbar navbar-expand-sm gradient-nav fixed-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2 text-white" href="{{ route('home') }}">
            <img
                src="{{ asset('images/johnkevinpaunel_logo.svg') }}"
                alt="John Kevin Paunel Logo"
                height="36"
                class="navbar-logo"
            >
            <span class="fw-semibold">John Kevin Paunel</span>
        </a>

        <!-- Toggler for Offcanvas -->
        <button class="navbar-toggler text-white border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#mainOffcanvas">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Desktop Menu (hidden on mobile) -->
        <div class="collapse navbar-collapse d-none d-sm-flex" id="collapsibleNavbar">
            <ul class="navbar-nav">
                <li class="nav-item px-2">
                    <a class="nav-link {{ Route::is('home') ? 'active' : '' }} text-white" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item px-2">
                    <a class="nav-link {{ Route::is('listing.index') ? 'active' : '' }} text-white" href="{{ route('listing.index') }}">Listings</a>
                </li>
                <li class="nav-item px-2">
                    <a class="nav-link {{ Route::is('about-us') ? 'active' : '' }} text-white" href="{{ route('about-us') }}">About Us</a>
                </li>
                <li class="nav-item px-2">
                    <a class="nav-link {{ Route::is('blogs') ? 'active' : '' }} text-white" href="{{ route('blogs') }}">Blogs</a>
                </li>
                <li class="nav-item px-2">
                    <a class="nav-link {{ Route::is('contact-us') ? 'active' : '' }} text-white" href="{{ route('contact-us') }}">Contact Us</a>
                </li>
            </ul>

            <div class="d-flex ms-auto">
                <ul class="navbar-nav">
                    <li class="nav-item px-2">
                        <a class="nav-link text-white" href="https://www.youtube.com/@JohnKevinPaunel" target="_blank">
                            <i class="bi-youtube"></i>
                            <span class="nav-social-media-menu-text">Watch our Video Tours</span>
                        </a>
                    </li>
                    <li class="nav-item px-2">
                        <a class="nav-link text-white" href="https://www.facebook.com/johnkevinPaunelVlog" target="_blank">
                            <i class="bi-facebook"></i>
                            <span class="nav-social-media-menu-text">Like us on Facebook</span>
                        </a>
                    </li>
{{--                    <li class="nav-item px-2">--}}
{{--                        <a class="nav-link text-white" href="#">--}}
{{--                            <i class="bi-instagram"></i>--}}
{{--                            <span class="nav-social-media-menu-text">Follow us on Instagram</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
                </ul>

                <a href="{{route('list-my-property')}}" class="btn btn-fla btn-warning">List Your Property</a>
            </div>
        </div>
    </div>
</nav>


<!-- OFFCANVAS MENU FOR MOBILE -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="mainOffcanvas">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">

        <!-- MAIN LINKS -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link {{ Route::is('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::is('listing.index') ? 'active' : '' }}" href="{{ route('listing.index') }}">Listings</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::is('about-us') ? 'active' : '' }}" href="{{ route('about-us') }}">About Us</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::is('blogs') ? 'active' : '' }}" href="{{ route('blogs') }}">Blogs</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::is('contact-us') ? 'active' : '' }}" href="{{ route('contact-us') }}">Contact Us</a>
            </li>
        </ul>

        <hr>

        <!-- SOCIAL MEDIA LINKS -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="https://www.youtube.com/@JohnKevinPaunel" target="_blank">
                    <i class="bi-youtube"></i> Watch our Video Tours
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="https://www.facebook.com/johnkevinPaunelVlog" target="_blank">
                    <i class="bi-facebook"></i> Like us on Facebook
                </a>
            </li>
        </ul>

        <div class="mt-3">
            <a href="{{route('list-my-property')}}" class="btn btn-warning w-100">List Your Property</a>
        </div>

    </div>
</div>
