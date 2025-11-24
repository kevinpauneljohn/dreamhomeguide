@extends('dashboard.layouts.app')

@section('content')

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
{{--            <h3 class="fw-bold mb-0">{{ $agent->full_name }}</h3>--}}
            <h3 class="fw-bold mb-0">John Kevin Paunel</h3>
            <small class="text-muted">Agent Profile</small>
        </div>

        <a href="{{ route('user.index') }}" class="btn btn-light border px-4">
            Back
        </a>
    </div>

    <div class="row">
        <!-- LEFT COLUMN -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body text-center">

                    <!-- Avatar -->
                    <img src="{{ $agent->avatar_url ?? '/images/default-avatar.png' }}"
                         class="rounded-circle mb-3 border"
                         width="120" height="120">

                    <!-- Name -->
{{--                    <h4 class="fw-bold mb-0">{{ $agent->full_name }}</h4>--}}
{{--                    <small class="text-muted">{{ $agent->email }}</small>--}}

                    <h4 class="fw-bold mb-0">John Kevin Paunel</h4>
                    <small class="text-muted">johnkevinpaunel@gmail.com</small>

                    <!-- Role -->
                    <div class="mt-3">
{{--                        <span class="badge bg-primary px-3 py-2">{{ $agent->role }}</span>--}}
                        <span class="badge bg-primary px-3 py-2">Team Leader</span>
                    </div>

                    <!-- Status -->
                    <div class="mt-2">
{{--                    <span class="badge --}}
{{--                        @if($agent->status == 'ACTIVE') bg-success --}}
{{--                        @elseif($agent->status == 'INACTIVE') bg-secondary --}}
{{--                        @else bg-warning @endif--}}
{{--                    px-3 py-2">--}}
                        <span class="badge text-bg-success px-3 py-2">
{{--                        {{ $agent->status }}--}}
                        Active
                    </span>
                    </div>

                    <hr>

                    <!-- Contact Info -->
                    <div class="text-start">
{{--                        <p class="mb-1"><strong>Phone:</strong> {{ $agent->phone }}</p>--}}
{{--                        <p class="mb-1"><strong>Email:</strong> {{ $agent->email }}</p>--}}
{{--                        <p class="mb-1"><strong>Joined:</strong> {{ $agent->created_at->format('F d, Y') }}</p>--}}
                        <p class="mb-1"><strong>Phone:</strong> 09171027662</p>
                        <p class="mb-1"><strong>Email:</strong> johnkevinpaunel@gmail.com</p>
                        <p class="mb-1"><strong>Joined:</strong> 10-25-2025 10:00 am</p>
                    </div>

                    <hr>

                    <!-- Quick Stats -->
                    <div class="row text-center">
                        <div class="col-4">
{{--                            <h5 class="fw-bold">{{ $agent->listings_count }}</h5>--}}
                            <h5 class="fw-bold">25</h5>
                            <small class="text-muted">Listings</small>
                        </div>

                        <div class="col-4">
{{--                            <h5 class="fw-bold">{{ $agent->sales_count }}</h5>--}}
                            <h5 class="fw-bold">25</h5>
                            <small class="text-muted">Sales</small>
                        </div>

                        <div class="col-4">
{{--                            <h5 class="fw-bold">{{ $agent->clients_count }}</h5>--}}
                            <h5 class="fw-bold">100</h5>
                            <small class="text-muted">Clients</small>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN -->
        <div class="col-md-8">

            <div class="card">
                <div class="card-body">

                    <!-- Tabs -->
                    <ul class="nav nav-tabs mb-4" id="agentTab" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#overview"
                                    type="button" role="tab">Overview</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#listings"
                                    type="button" role="tab">Listings</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#activity"
                                    type="button" role="tab">Activity</button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content">

                        <!-- Overview -->
                        <div class="tab-pane fade show active" id="overview" role="tabpanel">
                            <h5 class="fw-bold mb-3">Basic Information</h5>

                            <div class="row mb-3">
                                <div class="col-md-4"><strong>Full Name:</strong></div>
{{--                                <div class="col-md-8">{{ $agent->full_name }}</div>--}}
                                <div class="col-md-8">John Kevin Paunel</div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4"><strong>Role:</strong></div>
{{--                                <div class="col-md-8">{{ $agent->role }}</div>--}}
                                <div class="col-md-8">Team Leader</div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4"><strong>Status:</strong></div>
{{--                                <div class="col-md-8">{{ $agent->status }}</div>--}}
                                <div class="col-md-8">Active</div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4"><strong>Email:</strong></div>
{{--                                <div class="col-md-8">{{ $agent->email }}</div>--}}
                                <div class="col-md-8">johnkevinpaunel@gmail.com</div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4"><strong>Phone:</strong></div>
{{--                                <div class="col-md-8">{{ $agent->phone }}</div>--}}
                                <div class="col-md-8">09171027662</div>
                            </div>

                            <hr>

                            <h5 class="fw-bold mb-3">Performance Summary</h5>
{{--                            <p>Total Listings: <strong>{{ $agent->listings_count }}</strong></p>--}}
{{--                            <p>Total Sales: <strong>{{ $agent->sales_count }}</strong></p>--}}
{{--                            <p>Total Clients: <strong>{{ $agent->clients_count }}</strong></p>--}}

                            <p>Total Listings: <strong>25</strong></p>
                            <p>Total Sales: <strong>50</strong></p>
                            <p>Total Clients: <strong>100</strong></p>
                        </div>

                        <!-- Listings Tab -->
                        <div class="tab-pane fade" id="listings" role="tabpanel">
                            <h5 class="fw-bold mb-3">Assigned Listings</h5>

{{--                            @if($agent->listings_count == 0)--}}
                            @php $listings_count = 25; @endphp
                            @if($listings_count == 0)
                                <div class="alert alert-warning">This agent has no listings yet.</div>
                            @else
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>Property</th>
                                        <th>Location</th>
                                        <th>Type</th>
                                        <th>Price</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
{{--                                    @foreach($agent->listings as $listing)--}}
{{--                                        <tr>--}}
{{--                                            <td>{{ $listing->title }}</td>--}}
{{--                                            <td>{{ $listing->location }}</td>--}}
{{--                                            <td>{{ strtoupper($listing->category) }}</td>--}}
{{--                                            <td>₱ {{ number_format($listing->price) }}</td>--}}
{{--                                            <td>--}}
{{--                                                <a href="{{ route('property.show', $listing->id) }}"--}}
{{--                                                   class="btn btn-sm btn-light border">View</a>--}}
{{--                                            </td>--}}
{{--                                        </tr>--}}
{{--                                    @endforeach--}}
                                    </tbody>
                                </table>
                            @endif
                        </div>

                        <!-- Activity Tab -->
                        <div class="tab-pane fade" id="activity" role="tabpanel">
                            <h5 class="fw-bold mb-3">Recent Activity</h5>
                            @php $logs = ""; @endphp
                            @if(empty($logs))
                                <div class="alert alert-info">No recent activity.</div>
                            @else
                                <ul class="list-group">
                                    @foreach($logs as $log)
                                        <li class="list-group-item">
                                            <strong>{{ $log->action }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $log->created_at->diffForHumans() }}</small>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>

                    </div><!-- tab-content -->

                </div>
            </div>

        </div>
    </div>

@endsection
