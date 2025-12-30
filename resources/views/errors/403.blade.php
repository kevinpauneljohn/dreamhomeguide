@extends('dashboard.layouts.app')

@section('title', '403 | Access Denied')

@section('content')
    <div class="d-flex justify-content-center align-items-center" style="min-height: 70vh;">
        <div class="text-center col-md-6">

            <div class="mb-4">
                <h1 class="display-1 fw-bold text-danger">403</h1>
                <h3 class="fw-semibold mt-3">Access Denied</h3>
                <p class="text-muted mt-2">
                    You do not have permission to access this page.
                    <br>
                    Please contact your administrator if you believe this is a mistake.
                </p>
            </div>

            <div class="d-flex justify-content-center gap-3 mt-4">
                <a href="{{ route('dashboard') }}" class="btn btn-primary px-4">
                    Go to Dashboard
                </a>

                <button onclick="history.back()" class="btn btn-outline-secondary px-4">
                    Go Back
                </button>
            </div>

        </div>
    </div>
@endsection
