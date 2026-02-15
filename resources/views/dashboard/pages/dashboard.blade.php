@extends('dashboard.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid py-4 dashboard-main">

        {{-- HEADER --}}
        <div class="mb-4">
            <small class="text-muted">Business Overview</small>
            <h3 class="fw-bold mb-0">Sales Command Center</h3>
        </div>

        {{-- EXECUTIVE KPI STRIP --}}
        <div class="row g-3 mb-4">

            <div class="col-6 col-lg-3">
                <div class="card border-0 shadow-sm kpi-card">
                    <div class="card-body">
                        <small class="text-muted">Sales Closed (MTD)</small>
                        <h3 class="fw-bold text-success">₱12.4M</h3>
                        <small class="text-success">▲ +18% vs last month</small>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="card border-0 shadow-sm kpi-card">
                    <div class="card-body">
                        <small class="text-muted">Pipeline Value</small>
                        <h3 class="fw-bold">₱28.9M</h3>
                        <small class="text-muted">Next 30 days</small>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="card border-0 shadow-sm kpi-card">
                    <div class="card-body">
                        <small class="text-muted">Lead → Sale Conversion</small>
                        <h3 class="fw-bold">{{ $monthlyConversionRate }}%</h3>

                        @if($monthlyConversionRate >= 30)
                            <small class="text-success">Excellent performance</small>

                        @elseif($monthlyConversionRate >= 20)
                            <small class="text-success">Strong performance</small>

                        @elseif($monthlyConversionRate >= 10)
                            <small class="text-warning">Needs improvement</small>

                        @else
                            <small class="text-danger">Critical – review follow-ups</small>
                        @endif

                    </div>
                </div>
            </div>


            <div class="col-6 col-lg-3">
                <div class="card border-0 shadow-sm kpi-card">
                    <div class="card-body">
                        <small class="text-muted">Avg Days to Close</small>
                        <h3 class="fw-bold">{{$avgDaysToClose}}</h3>
                        @if($avgDaysToClose <= 15)
                            <small class="text-success">Excellent closing speed</small>
                        @elseif($avgDaysToClose <= 30)
                            <small class="text-warning">Industry average</small>
                        @else
                            <small class="text-danger">Slow conversion</small>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        {{-- MAIN GRID --}}
        <div class="row g-4">

            {{-- LEAD FLOW HEALTH --}}
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0">
                        <h6 class="fw-bold mb-0">Lead Flow Health</h6>
                    </div>

                    <div class="card-body">

                        <div class="row text-center mb-3">
                            <div class="col">
                                <small class="text-muted">New Today</small>
                                <h5 class="fw-bold">{{$newLeadsToday}}</h5>
                            </div>
                            <div class="col">
                                <small class="text-muted">Contacted &lt; 1hr</small>
                                <h5 class="fw-bold text-success">9</h5>
                            </div>
                            <div class="col">
                                <small class="text-muted">Delayed</small>
                                <h5 class="fw-bold text-danger">5</h5>
                            </div>
                        </div>

                        <hr>

                        <ul class="list-unstyled small mb-0">
                            <li class="d-flex justify-content-between mb-2">
                                <span>Unassigned Leads</span>
                                <span class="badge bg-danger">{{$unAssignedLeads}}</span>
                            </li>
                            <li class="d-flex justify-content-between mb-2">
                                <span>For Follow-up</span>
                                <span class="badge bg-warning text-dark">{{$leadsForFollowUp}}</span>
                            </li>
                            <li class="d-flex justify-content-between">
                                <span>Hot Leads</span>
                                <span class="badge bg-success">{{$hotLeads}}</span>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>

            {{-- SALES MOMENTUM --}}
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0">
                        <h6 class="fw-bold mb-0">Sales Momentum</h6>
                    </div>

                    <div class="card-body">

                        <div class="row text-center mb-3">
                            <div class="col">
                                <small class="text-muted">Closing This Week</small>
                                <h5 class="fw-bold">4</h5>
                            </div>
                            <div class="col">
                                <small class="text-muted">Loan Processing</small>
                                <h5 class="fw-bold">5</h5>
                            </div>
                            <div class="col">
                                <small class="text-muted">At Risk</small>
                                <h5 class="fw-bold text-danger">3</h5>
                            </div>
                        </div>

                        <hr>

                        <div class="small">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Expected Revenue (30 days)</span>
                                <strong>₱18.2M</strong>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Stalled Deals</span>
                                <strong class="text-danger">4</strong>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- AGENT PERFORMANCE --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0">
                        <h6 class="fw-bold mb-0">Agent Accountability</h6>
                    </div>

                    <div class="card-body p-0 table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>Agent</th>
                                <th>Leads</th>
                                <th>Sales</th>
                                <th>Conversion</th>
                                <th>Health</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>John Santos</td>
                                <td>32</td>
                                <td>5</td>
                                <td><span class="badge bg-success">16%</span></td>
                                <td><span class="badge bg-success">Top Performer</span></td>
                            </tr>
                            <tr>
                                <td>Maria Reyes</td>
                                <td>28</td>
                                <td>3</td>
                                <td><span class="badge bg-primary">11%</span></td>
                                <td><span class="badge bg-secondary">Stable</span></td>
                            </tr>
                            <tr>
                                <td>Alex Cruz</td>
                                <td>21</td>
                                <td>0</td>
                                <td><span class="badge bg-danger">0%</span></td>
                                <td><span class="badge bg-danger">Needs Coaching</span></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- ACTION QUEUE --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0">
                        <h6 class="fw-bold mb-0">Action Required Today</h6>
                    </div>

                    <div class="card-body small">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">🔴 5 leads untouched for 48h</li>
                            <li class="mb-2">🟠 2 reservations expiring</li>
                            <li class="mb-2">🔴 1 agent inactive today</li>
                            <li>🟡 3 deals stuck in loan processing</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection

@push('css')
    @vite(['resources/css/dashboard/dashboard.css'])
@endpush
