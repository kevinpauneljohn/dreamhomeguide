@push('modal')
    <!-- Computation Modal -->
    <div class="modal fade" id="computationToolModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="computationToolForm">
                @csrf
                <div class="modal-content border-0 shadow">

                    <!-- Header -->
                    <div class="modal-header bg-light">
                        <h5 class="modal-title fw-semibold">
                            Computation Library
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Body -->
                    <div class="modal-body px-4 py-3">

                        <!-- Select computation -->
                        <!-- Select computation -->
                        <div class="row g-3 align-items-end">

                            <!-- Project -->
                            <div class="col-md-5">
                                <label for="project_id" class="form-label fw-medium">
                                    Select Project
                                </label>
                                <select id="project" name="project_id" class="form-select">
                                    <option value=""></option>
                                    @foreach($projects as $project)
                                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Model Unit -->
                            <div class="col-md-5">
                                <label for="model_unit" class="form-label fw-medium">
                                    Select Model Unit
                                </label>
                                <select id="model_unit" name="model_unit" class="form-select"></select>
                            </div>

                            <!-- Search Button -->
                            <div class="col-md-2 d-grid">
                                <label class="form-label invisible">Search</label>
                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                    id="searchComputationBtn">
                                    Search
                                </button>
                            </div>

                        </div>


                        <!-- Dynamic computation result -->
                        <div class="mt-4 d-none" id="computationResultWrapper">
                            <div class="border rounded p-3 bg-white">
                                <h6 class="fw-semibold mb-3">Computation Details</h6>
                                <textarea
                                    id="viewComputationText"
                                    class="form-control"
                                    rows="10"
                                    readonly
                                    style="font-family: monospace; font-size: 0.9rem;"
                                ></textarea>
                            </div>
                        </div>

                    </div>

                    <!-- Footer -->
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endpush


