@extends('dashboard.layouts.app')
@section('title', $title)
@section('content')

    <h3 class="fw-bold mb-2">Dashboard</h3>
    <p class="text-muted">Welcome back, {{ auth()->user()->full_name }} 👋</p>

    {{-- KPI CARDS --}}
    <div class="row g-3 mb-4">

        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="fw-bold text-muted">Total Properties</span>
                        <span class="text-primary"><i class="bi bi-building"></i></span>
                    </div>
                    <h3 class="fw-bold">{{ $totalProperties ?? 0 }}</h3>
                    <small class="text-success fw-semibold">+{{ $addedThisWeek ?? 0 }} this week</small>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="fw-bold text-muted">Active Listings</span>
                        <span class="text-success"><i class="bi bi-check-circle"></i></span>
                    </div>
                    <h3 class="fw-bold">{{ $activeListings ?? 0 }}</h3>
                    <small class="text-muted">Properties currently visible</small>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="fw-bold text-muted">Agents</span>
                        <span class="text-warning"><i class="bi bi-people"></i></span>
                    </div>
                    <h3 class="fw-bold">{{ $agents ?? 0 }}</h3>
                    <small class="text-muted">{{ $newAgents ?? 0 }} new this month</small>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="fw-bold text-muted">Estimated Revenue</span>
                        <span class="text-info"><i class="bi bi-cash-stack"></i></span>
                    </div>
                    <h3 class="fw-bold">₱{{ number_format($revenue ?? 0) }}</h3>
                    <small class="text-muted">Projected for this month</small>
                </div>
            </div>
        </div>

    </div>

    {{-- CHARTS ROW --}}
    <div class="row g-3 mb-4">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Property Activity Overview</h5>
                    <canvas id="propertyChart" height="140"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Listings by Type</h5>
                    <canvas id="listingTypeChart" height="240"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Properties --}}
    <div class="card shadow-sm border-0 mb-5">
        <div class="card-body">

            <h5 class="fw-bold mb-3">Recent Properties</h5>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                    <tr>
                        <th>Thumbnail</th>
                        <th>Property</th>
                        <th>Location</th>
                        <th>Type</th>
                        <th>Price</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($recentProperties ?? [] as $property)
                        <tr>
                            <td>
                                @if($property->images->where('is_thumbnail', true)->count() > 0)
                                    <img src="/storage/property_images/{{$property->images->where('is_thumbnail', true)->first()->file_name}}" width="60" class="rounded" alt="{{$property->images->where('is_thumbnail', true)->first()->file_name}}">
                                @endif
                            </td>
                            <td>{{ $property->title }}</td>
                            <td>{{ $property->location }}</td>
                            <td>{{ ucfirst($property->property_type) }}</td>
                            <td>₱{{ number_format($property->price) }}</td>
                            <td>
                                    <span class="badge bg-{{ $property->status === 'active' ? 'success' : ($property->status === 'reserved' ? 'warning' : 'secondary') }}">
                                        {{ strtoupper($property->status) }}
                                    </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No recent properties found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

@endsection

@push('scripts')
    @vite('resources/js/dashboard/dashboard.js')
@endpush
