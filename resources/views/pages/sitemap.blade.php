@extends('layouts.singlePage')

@section('title', 'Sitemap')

@section('bannerTitle')
    <div class="container">
        <h1 class="single-page-banner-title">Sitemap</h1>
    </div>
@endsection

@section('content')

    <style>
        .sitemap-container {
            display: flex;
            gap: 40px;
        }

        /* LEFT SIDEBAR */
        .sitemap-sidebar {
            width: 260px;
            position: sticky;
            top: 100px;
            height: fit-content;
            background: rgba(255,255,255,0.25);
            backdrop-filter: blur(12px);
            border-radius: 16px;
            padding: 20px;
            border: 1px solid rgba(255,255,255,0.3);
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }

        .sitemap-sidebar h5 {
            font-weight: 700;
            margin-bottom: 15px;
        }

        .sitemap-sidebar a {
            display: block;
            padding: 6px 0;
            font-size: 14px;
            color: #0d6efd;
            text-decoration: none;
        }

        .sitemap-sidebar a:hover {
            text-decoration: underline;
        }

        /* MAIN CONTENT CARD */
        .sitemap-card {
            flex: 1;
            background: rgba(255,255,255,0.45);
            padding: 40px;
            border-radius: 20px;
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255,255,255,0.25);
            box-shadow: 0px 12px 30px rgba(0,0,0,0.1);
        }

        .sitemap-card h3 {
            font-weight: 700;
            margin-top: 30px;
        }

        .sitemap-card ul li a {
            text-decoration: none;
            color: #0d6efd;
            font-weight: 500;
        }

        .sitemap-card ul li a:hover {
            text-decoration: underline;
        }

        html { scroll-behavior: smooth; }

        @media (max-width: 992px) {
            .sitemap-container {
                flex-direction: column;
            }
            .sitemap-sidebar {
                width: 100%;
                position: relative;
            }
        }
    </style>


    <div class="container py-5">

        <div class="sitemap-container">

            {{-- LEFT SIDEBAR --}}
            <aside class="sitemap-sidebar shadow-sm">
                <h5>Sections</h5>
                <a href="#navigation">Navigation</a>
                <a href="#listings">Property Listings</a>
                <a href="#blogs">Blogs</a>
                <a href="#locations">Key Locations</a>
                <a href="#legal">Legal Pages</a>
                <a href="#contact">Contact</a>
            </aside>

            {{-- MAIN CONTENT --}}
            <div class="sitemap-card">

                <h2 class="fw-bold mb-4">Website Sitemap</h2>
                <p class="text-muted">Explore all pages available on johnkevinpaunel.com under Dream Home Guide Realty.</p>

                <hr>

                {{-- NAVIGATION --}}
                <h3 id="navigation">Navigation</h3>
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('listing.index') }}">Listings</a></li>
                    <li><a href="{{ route('about-us') }}">About Us</a></li>
                    <li><a href="{{ route('blogs') }}">Blogs</a></li>
                    <li><a href="{{ route('contact-us') }}">Contact Us</a></li>
                </ul>

                {{-- LISTINGS --}}
                <h3 id="listings">Property Listings</h3>
                <ul>
                    <li><a href="{{ route('listing.index') }}">All Listings</a></li>
                    <li><a href="{{ route('listing.index') }}?purpose=sale">Properties for Sale</a></li>
                    <li><a href="{{ route('listing.index') }}?purpose=rent">Properties for Rent</a></li>
                    <li><a href="{{ route('listing.index') }}?category=house-and-lot">House & Lot</a></li>
                    <li><a href="{{ route('listing.index') }}?category=condominium">Condominiums</a></li>
                </ul>

                {{-- BLOGS --}}
                <h3 id="blogs">Blogs & Articles</h3>
                <ul>
                    <li><a href="{{ route('blog.index') }}">All Blog Articles</a></li>
{{--                    @foreach($latestBlogs ?? [] as $blog)--}}
{{--                        <li><a href="{{ route('blog.show', $blog->id) }}">{{ $blog->title }}</a></li>--}}
{{--                    @endforeach--}}
                </ul>

                {{-- LOCATIONS --}}
                <h3 id="locations">Key Locations</h3>
                <ul>
                    <li><a href="{{ route('listing.index') }}?location=pampanga">Pampanga</a></li>
                    <li><a href="{{ route('listing.index') }}?location=tarlac">Tarlac</a></li>
                    <li><a href="{{ route('listing.index') }}?location=bulacan">Bulacan</a></li>
                    <li><a href="{{ route('listing.index') }}?location=bataan">Bataan</a></li>
                </ul>

                {{-- LEGAL --}}
                <h3 id="legal">Legal & Policy Pages</h3>
                <ul>
                    <li><a href="{{ route('privacy-policy') }}">Privacy Policy</a></li>
                    <li><a href="{{ route('terms-and-conditions') }}">Terms & Conditions</a></li>
                    <li><a href="{{ route('sitemap') }}">Sitemap</a></li>
                </ul>

                {{-- CONTACT --}}
                <h3 id="contact">Contact Information</h3>
                <ul>
                    <li>Email: <a href="mailto:inquiry@johnkevinpaunel.com">inquiry@johnkevinpaunel.com</a></li>
                    <li>Mobile: 091710277662 / 09297096801</li>
                    <li>Facebook: <a href="https://facebook.com/johnkevinpaunelvlog" target="_blank">John Kevin Paunel</a></li>
                </ul>

            </div>

        </div>

    </div>

@endsection
