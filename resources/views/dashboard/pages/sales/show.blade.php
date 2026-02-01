@extends('dashboard.layouts.app')

@section('title', 'Sales Profile')

@section('content')
    <div class="container-fluid py-4 sales-profile">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <small class="text-muted">Sales / Profile</small>
                <h2 class="fw-bold mb-1">
                    Sale #{{ str_pad($sale->id, 5, '0', STR_PAD_LEFT) }}
                </h2>
                <span class="badge bg-primary text-uppercase px-3 py-2">
                {{ $sale->status }}
            </span>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
                <a href="{{ route('sales.edit', $sale) }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-pencil"></i> Edit
                </a>
            </div>
        </div>

        <div class="row g-4">

            {{-- LEFT COLUMN --}}
            <div class="col-lg-8">

                {{-- CLIENT & AGENT --}}
                <div class="card profile-card mb-4">
                    <div class="card-header">
                        <h6><i class="bi bi-people"></i> Client & Agent</h6>
                    </div>
                    <div class="card-body">
                        <div class="row gy-3">
                            <div class="col-md-6">
                                <div class="profile-field">
                                    <span>Client / Lead</span>
                                    <strong>{{ $sale->lead->name ?? '—' }}</strong>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="profile-field">
                                    <span>Assigned Agent</span>
                                    <strong>{{ $sale->user->name ?? '—' }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- PROPERTY DETAILS --}}
                <div class="card profile-card mb-4">
                    <div class="card-header">
                        <h6><i class="bi bi-house"></i> Property Details</h6>
                    </div>
                    <div class="card-body">
                        <div class="row gy-3">
                            <div class="col-md-6">
                                <div class="profile-field">
                                    <span>Project</span>
                                    <strong>{{ $sale->project->name ?? '—' }}</strong>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="profile-field">
                                    <span>Model Unit</span>
                                    <strong>{{ $sale->modelUnit->name ?? '—' }}</strong>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="profile-field">
                                    <span>Lot Area</span>
                                    <strong>{{ $sale->lot_area ? $sale->lot_area.' sqm' : '—' }}</strong>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="profile-field">
                                    <span>Floor Area</span>
                                    <strong>{{ $sale->floor_area ? $sale->floor_area.' sqm' : '—' }}</strong>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="profile-field">
                                    <span>Phase</span>
                                    <strong>{{ $sale->phase ?? '—' }}</strong>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="profile-field">
                                    <span>Block No.</span>
                                    <strong>{{ $sale->block_no ?? '—' }}</strong>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="profile-field">
                                    <span>Lot No.</span>
                                    <strong>{{ $sale->lot_no ?? '—' }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- REMARKS --}}
                <div class="card profile-card">
                    <div class="card-header">
                        <h6><i class="bi bi-chat-left-text"></i> Remarks</h6>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-0">
                            {{ $sale->remarks ?? 'No remarks provided.' }}
                        </p>
                    </div>
                </div>

            </div>

            {{-- RIGHT COLUMN --}}
            <div class="col-lg-4">

                {{-- TRANSACTION SUMMARY --}}
                <div class="card profile-card mb-4">
                    <div class="card-header">
                        <h6><i class="bi bi-calendar-check"></i> Transaction Summary</h6>
                    </div>
                    <div class="card-body">
                        <div class="profile-field mb-3">
                            <span>Reservation Date</span>
                            <strong>
                                {{ $sale->reservation_date
                                    ? \Carbon\Carbon::parse($sale->reservation_date)->format('F d, Y')
                                    : '—'
                                }}
                            </strong>
                        </div>

                        <div class="profile-field">
                            <span>Status</span>
                            <strong class="text-uppercase">{{ $sale->status }}</strong>
                        </div>
                    </div>
                </div>

                {{-- PRICING & FINANCING --}}
                <div class="card profile-card mb-4">
                    <div class="card-header">
                        <h6><i class="bi bi-cash-stack"></i> Pricing & Financing</h6>
                    </div>
                    <div class="card-body">
                        <div class="profile-field mb-3">
                            <span>Total Contract Price</span>
                            <strong>
                                {{ $sale->total_contract_price
                                    ? '₱ '.number_format($sale->total_contract_price, 2)
                                    : '—'
                                }}
                            </strong>
                        </div>

                        <div class="profile-field mb-3">
                            <span>Down Payment</span>
                            <strong>{{ $sale->down_payment ?? '—' }}</strong>
                        </div>

                        <div class="profile-field mb-3">
                            <span>DP Terms</span>
                            <strong>{{ $sale->dp_terms ?? '—' }}</strong>
                        </div>

                        <div class="profile-field mb-3">
                            <span>Financing</span>
                            <strong>{{ $sale->financing ?? '—' }}</strong>
                        </div>

                        <div class="profile-field">
                            <span>Commission Rate</span>
                            <strong>
                                {{ $sale->commission_rate ? $sale->commission_rate.'%' : '—' }}
                            </strong>
                        </div>
                    </div>
                </div>

                {{-- META --}}
                <div class="card profile-card">
                    <div class="card-header">
                        <h6><i class="bi bi-clock-history"></i> Record Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="profile-field mb-3">
                            <span>Created At</span>
                            <strong>{{ $sale->created_at?->format('F d, Y h:i A') }}</strong>
                        </div>

                        <div class="profile-field">
                            <span>Last Updated</span>
                            <strong>{{ $sale->updated_at?->diffForHumans() }}</strong>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .sales-profile .profile-card {
            border: none;
            border-radius: 14px;
            box-shadow: 0 10px 30px rgba(0,0,0,.05);
        }

        .sales-profile .card-header {
            background: transparent;
            border-bottom: 1px solid #eee;
            padding: 1rem 1.25rem;
        }

        .sales-profile .card-header h6 {
            margin: 0;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .sales-profile .profile-field span {
            font-size: .72rem;
            text-transform: uppercase;
            letter-spacing: .6px;
            color: #6c757d;
            margin-bottom: 2px;
        }

        .sales-profile .profile-field strong {
            font-size: .95rem;
            color: #212529;
        }

    </style>
@endpush
