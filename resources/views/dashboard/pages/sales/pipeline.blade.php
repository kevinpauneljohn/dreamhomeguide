@extends('dashboard.layouts.app')

@section('title', 'Sales Pipeline')

@section('content')
    <div class="container-fluid py-4 sales-pipeline">

        {{-- PAGE HEADER --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
            <div>
                <h3 class="fw-bold mb-1">Sales Pipeline</h3>
                <small class="text-muted">
                    Track deals from lead to closing
                </small>
            </div>

            <div class="d-flex gap-2 mt-3 mt-md-0">
                <button class="btn btn-outline-secondary btn-sm">All</button>
                <button class="btn btn-outline-secondary btn-sm">My Deals</button>
                <button class="btn btn-dark btn-sm">This Month</button>
            </div>
        </div>

        {{-- KANBAN BOARD --}}
        <div class="pipeline-board d-flex gap-3 pb-3" style="overflow-x:auto">

            @php
                $stages = [
                    'New Leads',
                    'Contacted',
                    'Site Tripping',
                    'Proposal Sent',
                    'Reserved',
                    'Loan Processing',
                    'Closed',
                    'Lost'
                ];
            @endphp

            @foreach($stages as $stage)
                <div class="pipeline-column">

                    <div class="card shadow-sm border-0 pipeline-stage">
                        {{-- STAGE HEADER --}}
                        <div class="card-header bg-white border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold mb-0">{{ $stage }}</h6>
                                <span class="badge bg-secondary bg-opacity-10 text-secondary">12</span>
                            </div>
                            <small class="text-muted">₱4.2M value</small>
                        </div>

                        {{-- STAGE BODY --}}
                        <div class="card-body p-2 pipeline-cards">

                            {{-- DEAL CARD --}}
                            <div class="card mb-2 shadow-sm border-0 pipeline-card">
                                <div class="card-body p-2">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <strong class="small">Juan Dela Cruz</strong>
                                        <span class="badge bg-warning text-dark small">5d</span>
                                    </div>

                                    <small class="text-muted d-block">
                                        Villa Corazon – Duplex
                                    </small>

                                    <div class="mt-2 d-flex justify-content-between align-items-center">
                                        <span class="fw-bold text-success small">₱1,200,000</span>
                                        <span class="badge bg-primary bg-opacity-10 text-primary small">
                                        Maria S.
                                    </span>
                                    </div>
                                </div>
                            </div>

                            {{-- DUPLICATE CARD FOR DESIGN --}}
                            <div class="card mb-2 shadow-sm border-0 pipeline-card">
                                <div class="card-body p-2">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <strong class="small">Ana Reyes</strong>
                                        <span class="badge bg-danger small">12d</span>
                                    </div>

                                    <small class="text-muted d-block">
                                        Solana Zaragoza
                                    </small>

                                    <div class="mt-2 d-flex justify-content-between align-items-center">
                                        <span class="fw-bold text-success small">₱2,300,000</span>
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary small">
                                        Juan D.
                                    </span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            @endforeach

        </div>

    </div>
@endsection
