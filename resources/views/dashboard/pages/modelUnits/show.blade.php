@extends('dashboard.layouts.app')

@section('title', $title ?? 'Model Unit')

@section('content')

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">

        <!-- Left: Back + Title -->
        <div class="d-flex align-items-start gap-3">
            <a onclick="window.history.back();"
               class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1"
               style="cursor: pointer;">
                <i class="bi bi-arrow-left"></i>
                <span class="d-none d-sm-inline">Back</span>
            </a>

            <div>
                <h3 class="fw-bold mb-0">
                    {{ $modelUnit->name }}
                </h3>

                <div class="d-flex flex-wrap align-items-center gap-2 mt-1">
                    <span class="text-muted small">
                        <i class="bi bi-link-45deg me-1"></i>
                        {{ $modelUnit->slug }}
                    </span>

                    @php
                        $status = $modelUnit->status ?? 'draft';
                        $statusClass = match($status) {
                            'published' => 'success',
                            'draft' => 'secondary',
                            'archived' => 'dark',
                            default => 'secondary',
                        };
                    @endphp

                    <span class="badge bg-{{ $statusClass }} text-uppercase">
                        {{ $status }}
                    </span>

                    <span class="badge bg-light text-dark border">
                        {{ ucfirst(str_replace('-', ' ', $modelUnit->type)) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Right: Actions -->
        <div class="d-flex gap-2">
            @can('edit model unit')
                <a href="{{ route('model-units.edit', $modelUnit) }}"
                   class="btn btn-outline-primary">
                    <i class="bi bi-pencil me-1"></i> Edit
                </a>
            @endcan

            @can('delete model unit')
                <button class="btn btn-outline-danger delete-model-unit"
                        data-model-unit-id="{{ $modelUnit->id }}">
                    <i class="bi bi-trash me-1"></i> Delete
                </button>
            @endcan
        </div>
    </div>

    <!-- Breadcrumb -->
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body py-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 small">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('project.index') }}">Projects</a>
                    </li>
                    @if(isset($project))
                        <li class="breadcrumb-item">
                            <a href="{{ route('project.show', $project) }}">
                                {{ $project->name }}
                            </a>
                        </li>
                    @endif
                    <li class="breadcrumb-item active" aria-current="page">
                        Model Unit
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row g-4">

        <!-- Left Column -->
        <div class="col-lg-4">

            <!-- Thumbnail Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white fw-semibold">
                    Thumbnail
                </div>
                <div class="card-body">
                    @if($modelUnit->thumbnail)
                        <img
                            src="{{ asset('storage/'.$modelUnit->thumbnail) }}"
                            class="img-fluid rounded border w-100"
                            style="object-fit: cover; aspect-ratio: 16 / 10;"
                            alt="{{ $modelUnit->name }}"
                        >
                    @else
                        <div class="border rounded d-flex align-items-center justify-content-center text-muted"
                             style="height: 220px;">
                            <div class="text-center">
                                <i class="bi bi-image fs-1 d-block mb-2"></i>
                                No thumbnail uploaded
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Facts -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-semibold">
                    Quick Facts
                </div>
                <div class="card-body">

                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Type</span>
                        <span class="fw-semibold">
                            {{ ucfirst(str_replace('-', ' ', $modelUnit->type)) }}
                        </span>
                    </div>

                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Lot Area</span>
                        <span class="fw-semibold">
                            {{ $modelUnit->lot_area ? $modelUnit->lot_area.' sqm' : '—' }}
                        </span>
                    </div>

                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Floor Area</span>
                        <span class="fw-semibold">
                            {{ $modelUnit->floor_area ? $modelUnit->floor_area.' sqm' : '—' }}
                        </span>
                    </div>

                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Status</span>
                        <span class="fw-semibold">
                            <span class="badge bg-{{ $statusClass }} text-uppercase">
                                {{ $status }}
                            </span>
                        </span>
                    </div>

                    <div class="d-flex justify-content-between pt-2">
                        <span class="text-muted">Created</span>
                        <span class="fw-semibold">
                            {{ optional($modelUnit->created_at)->format('M d, Y') ?? '—' }}
                        </span>
                    </div>

                </div>
            </div>

        </div>

        <!-- Right Column -->
        <div class="col-lg-8">

            <!-- Description -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white fw-semibold">
                    Description
                </div>
                <div class="card-body">
                    @if($modelUnit->description)
                        <div class="text-muted">
                            {!! nl2br(e($modelUnit->description)) !!}
                        </div>
                    @else
                        <span class="text-muted">No description provided.</span>
                    @endif
                </div>
            </div>

            <!-- Details Grid -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-semibold">
                    Details
                </div>
                <div class="card-body">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="p-3 border rounded">
                                <div class="text-muted small mb-1">Model Name</div>
                                <div class="fw-semibold">{{ $modelUnit->name }}</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3 border rounded">
                                <div class="text-muted small mb-1">Slug</div>
                                <div class="fw-semibold">{{ $modelUnit->slug }}</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3 border rounded">
                                <div class="text-muted small mb-1">Project</div>
                                <div class="fw-semibold">
                                    @if(isset($project))
                                        <a href="{{ route('project.show', $project) }}"
                                           class="text-decoration-none">
                                            {{ $project->name }}
                                        </a>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3 border rounded">
                                <div class="text-muted small mb-1">Last Updated</div>
                                <div class="fw-semibold">
                                    {{ optional($modelUnit->updated_at)->format('M d, Y h:i A') ?? '—' }}
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>

@endsection

@push('scripts')
    {{-- If you want to wire delete here with your SweetAlert flow, keep your delegated listener --}}
    @vite(['resources/js/dashboard/modelUnits/delete.js'])
@endpush
