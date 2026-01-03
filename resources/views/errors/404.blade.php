@extends('layouts.app')

@section('title', '404 Not Found')

@section('content')
    <style>
        body {
            background: linear-gradient(135deg, #f8f9fa, #ffffff);
            color: #333;
        }

        .error-page {
            min-height: 85vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .floating-img {
            width: 260px;
            opacity: 0.13;
            position: absolute;
            animation: float 6s ease-in-out infinite;
            filter: brightness(0.7);
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }

        .error-code {
            font-size: 140px;
            font-weight: 900;
            background: linear-gradient(135deg, #ff7eb3, #ffb88c);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: -10px;
        }

        .error-title {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
            color: #333;
        }

        .error-desc {
            font-size: 18px;
            max-width: 460px;
            opacity: 0.8;
            margin-bottom: 30px;
            color: #555;
        }

        .btn-custom {
            padding: 12px 30px;
            font-size: 16px;
            border-radius: 50px;
            background: linear-gradient(135deg, #ff7eb3, #ffb88c);
            border: none;
            color: #fff;
            font-weight: 600;
            box-shadow: 0 5px 15px rgba(255, 126, 179, 0.3);
            transition: 0.2s ease;
        }

        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 7px 18px rgba(255, 126, 179, 0.35);
        }
    </style>

    <div class="container error-page">

        <!-- Floating decorative icons -->
        <img src="https://cdn-icons-png.flaticon.com/512/10337/10337641.png"
             class="floating-img"
             style="top: 10%; left: 5%; width:180px;">

        <img src="https://cdn-icons-png.flaticon.com/512/10337/10337641.png"
             class="floating-img"
             style="bottom: 10%; right: 10%; width:150px; animation-delay: 2s;">

        <!-- Content -->
        <div>
            <div class="error-code">404</div>

            <div class="error-title">Page Not Found</div>

            <p class="error-desc">
                It seems the page you’re looking for no longer exists or the link is outdated.
                No worries — let's get you back on track.
            </p>

            <a onclick="window.history.back()" class="btn btn-custom">
                ⬅ Go Back
            </a>
        </div>

    </div>
    @if(auth()->check())
        <div id="app-user-id" data-user-id="{{ auth()->id() }}">
        <x-notifications />
    @endif

@endsection
