<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login</title>
    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/sass/app.scss','resources/js/app.js'])
    @endif

    <style>
        body {
            background: linear-gradient(135deg, #e0e7ff, #f5f3ff);
        }
        .login-wrapper {
            height: 100vh;
        }
        .login-card {
            width: 100%;
            max-width: 420px;
            padding: 30px;
            border-radius: 12px;
            background: #fff;
            box-shadow: 0px 6px 20px rgba(0,0,0,0.08);
        }
        .brand-title {
            font-weight: 700;
            font-size: 1.5rem;
            color: #0d6efd;
        }
    </style>

</head>
<body>

<div class="d-flex justify-content-center align-items-center login-wrapper">

    <div class="login-card">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <h3 class="text-center brand-title mb-3">DHG Admin</h3>
        <p class="text-center text-muted mb-4">Sign in to continue</p>

        <!-- LOGIN FORM -->
        <form method="POST" action="{{route('authenticate')}}">
            @csrf
            <!-- Email -->
            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" name="email" class="form-control" placeholder="admin@example.com" value="{{old('email')}}">
                </div>
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="********" >
                </div>
            </div>

            <!-- Forgot Password -->
            <div class="d-flex justify-content-end mb-3">
                <a href="#" class="small text-decoration-none">Forgot password?</a>
            </div>

            <!-- Button -->
            <button type="submit" class="btn btn-primary w-100 mb-3">
                <i class="bi bi-box-arrow-in-right me-1"></i> Login
            </button>

        </form>

        <!-- Footer -->
        <p class="text-center text-muted small mt-3 mb-0">
            © 2025 Dream Home Guide Realty
        </p>
    </div>

</div>

</body>
</html>
