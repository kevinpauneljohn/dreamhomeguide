<button
    data-bs-toggle="modal"
    data-bs-target="#complete-status-note-modal"
    class="btn btn-sm btn-success">
    <i class="bi bi-check"></i> Complete Status
</button>

@push('modal')
    <div class="modal fade" id="complete-status-note-modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="status-update-form" novalidate>
                <input type="hidden" name="appointment_id" value="{{$appointmentId}}">
                @csrf

                <div class="modal-content border-0 shadow">

                    <!-- Header -->
                    <div class="modal-header bg-light">
                        <div>
                            <h5 class="modal-title fw-semibold mb-0">
                                <!-- Set dynamically via JS -->
                            </h5>
                            <small class="text-muted">
                                This note will be saved in the appointments activity log.
                            </small>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Body -->
                    <div class="modal-body px-4 py-3">


                        <div class="mb-3">
                            <label for="accomplishment" class="form-label fw-medium">
                                Accomplishments / Notes / Reasons for Change
                            </label>

                            <textarea
                                id="accomplishment"
                                name="accomplishment"
                                class="form-control"
                                rows="8"
                                required
                                placeholder="Describe the work done, notes, or reasons related to this task..."
                            ></textarea>

                            <div class="form-text">
                                Be concise but clear. This will be visible in the activity history.
                            </div>
                        </div>

                    </div>

                    <!-- Footer -->
                    <div class="modal-footer bg-light">
                        <button
                            type="button"
                            class="btn btn-outline-secondary"
                            data-bs-dismiss="modal">
                            Close
                        </button>

                        <button
                            type="submit"
                            class="btn btn-primary"
                            id="submit-accomplishment-button">
                            Submit
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endpush
