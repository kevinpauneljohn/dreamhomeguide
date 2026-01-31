@extends('dashboard.layouts.app')

@section('title', 'Computation Library')

@section('content')
    <div class="container-fluid">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h3 class="mb-0">Computation Library</h3>
                <small class="text-muted">
                    Approved and reusable computations for agents
                </small>
            </div>

            @can('add computation')
                <button class="btn btn-primary" id="btnAddComputation">
                    <i class="fa fa-plus me-1"></i> Add Computation
                </button>
            @endcan
        </div>

        {{-- Filters --}}
        <div class="card mb-3">
            <div class="card-body py-2">
                <div class="row g-2 align-items-center">

                    {{-- Search --}}
                    <div class="col-md-3">
                        <div class="input-group">
                    <span class="input-group-text bg-white">
                        <i class="fa fa-search"></i>
                    </span>
                            <input
                                type="text"
                                class="form-control"
                                id="search"
                                placeholder="Search project, model, computation..."
                            >
                        </div>
                    </div>

                    {{-- Project --}}
                    <div class="col-md-2">
                        <select class="form-select" id="filter-project">
                            <option value="">Filter by Project</option>
                            @foreach($projects as $p)
                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Financing --}}
                    <div class="col-md-2">
                        <select class="form-select" id="filter-financing">
                            <option value="">Filter by Financing</option>
                            <option value="bank">Bank</option>
                            <option value="hdmf">HDMF</option>
                            <option value="inhouse">Inhouse</option>
                            <option value="cash">Cash</option>
                            <option value="deferred-cash">Deferred Cash</option>
                        </select>
                    </div>

                    {{-- Date --}}
                    <div class="col-md-2">
                        <input
                            type="date"
                            class="form-control"
                            id="filter-date"
                        >
                    </div>

                    {{-- Reset --}}
                    <div class="col-md-1 text-end">
                        <button class="btn btn-light w-100" id="btnResetFilters">
                            <i class="fa fa-rotate-left"></i>
                        </button>
                    </div>

                </div>
            </div>
        </div>


        {{-- Table --}}
        <div class="card">
            <div class="card-body p-0">
                <div class="p-3 table-responsive">
                    <table class="table table-hover align-middle bordered mb-0" id="computationsTable">
                        <thead class="table-light">
                        <tr>
                            <th>Project / Model</th>
                            <th>Financing</th>
                            <th>Last Update</th>
                            <th>Updated By</th>
                            <th class="text-end">Actions</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>


    </div>

    {{-- ADD / EDIT MODAL --}}
    @push('modal')
        <div class="modal fade" id="computationModal" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <form id="computationForm">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Computation</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <input type="hidden" id="computation_id">

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Project *</label>
                                    <select class="form-select" name="project_id">
                                        <option value="">Select Project</option>
                                        @foreach($projects as $p)
                                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Model Unit *</label>
                                    <select class="form-select" name="model_unit_id"></select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Financing *</label>
                                    <select class="form-select" name="financing">
                                        <option value=""></option>
                                        <option value="bank">Bank</option>
                                        <option value="hdmf">HDMF</option>
                                        <option value="inhouse">Inhouse</option>
                                        <option value="cash">Cash</option>
                                        <option value="deferred-cash">Deferred Cash</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Unit Type</label>
                                    <select class="form-select" name="type">
                                        <option value=""></option>
                                        <option value="inner">Inner</option>
                                        <option value="corner">Corner</option>
                                        <option value="End">End</option>
                                    </select>
                                </div>
                            </div>

                            <label class="form-label fw-semibold">
                                Computation (Copy-Ready)
                            </label>
                            <textarea
                                name="computation"
                                rows="14"
                                class="form-control font-monospace"
                                placeholder="Paste the exact computation agents will send to clients..."></textarea>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-primary" id="saveComputationBtn">
                                Save
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        {{-- VIEW COMPUTATION MODAL --}}
        <div class="modal fade" id="viewComputationModal" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">

                    {{-- Header --}}
                    <div class="modal-header">
                        <div>
                            <h5 class="modal-title" id="viewTitle">—</h5>
                            <small class="text-muted" id="viewSubtitle">—</small>
                        </div>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    {{-- Body --}}
                    <div class="modal-body">

                        {{-- Computation --}}
                        <label class="fw-semibold mb-1 d-flex align-items-center gap-2">
                            Copy-Ready Computation
                            <span class="badge bg-secondary">Read-only</span>
                        </label>

                        <textarea
                            id="viewComputationText"
                            class="form-control font-monospace"
                            rows="25"
                            readonly></textarea>
                    </div>

                    {{-- Footer --}}
                    <div class="modal-footer">
                        <button class="btn btn-outline-secondary" id="btnCopyComputation">
                            <i class="fa fa-copy me-1"></i> Copy
                        </button>
                        <button class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                    </div>

                </div>
            </div>
        </div>

    @endpush


@endsection

@push('css')
    <style>
        #viewComputationText {
            background: #f8f9fa;
            white-space: pre-wrap;
            line-height: 1.6;
        }

    </style>
@endpush

@push('scripts')
    @vite('resources/js/dashboard/computations/computations-table.js')
    @vite('resources/js/dashboard/computations/submitComputation.js')
    @vite('resources/js/dashboard/computations/add.js')
    @vite('resources/js/dashboard/computations/edit.js')
    @vite('resources/js/dashboard/computations/view.js')
@endpush

@push('css')
    @vite('resources/css/computations.css')
@endpush
