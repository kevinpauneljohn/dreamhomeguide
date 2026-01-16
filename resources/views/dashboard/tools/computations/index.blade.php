@forelse ($computations as $computation)

    @php
        $displayText = <<<TEXT
**** Sample Computation Only ****
PROJECT: {$computation->project->name}
MODEL UNIT: {$computation->modelUnit->name}
UNIT LOCATION: END UNIT

FINANCING: DEFERRED-CASH
PROPERTY LOCATION:
{$computation->project->address}

LOT AREA: {$computation->modelUnit->lot_area}
FLOOR AREA: {$computation->modelUnit->floor_area}
--------------------------------------
{$computation->computation}
--------------------------------------

✔ Prices and computation are subject to change without prior notice.
✔ Final approval is subject to financing evaluation.
✔ Processing fees and other charges may apply.
TEXT;
    @endphp

    <div class="card mb-4 border border-warning rounded-3">

        <!-- HEADER -->
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-warning text-dark text-uppercase">
                    {{ strtoupper($computation->financing) }} FINANCING
                </span>
                <span class="text-muted small">
                    Unit Type: {{ ucfirst($computation->type) }}
                </span>
            </div>

            <button
                type="button"
                class="btn btn-outline-secondary btn-sm copy-computation"
                data-text="{{ e($displayText) }}">
                Copy
            </button>
        </div>

        <!-- BODY -->
        <div class="card-body">

            <div class="text-muted small mb-2">
                Created: {{ $computation->created_at->format('M d, Y h:i A') }}
            </div>

            <pre class="bg-light p-3 rounded mb-0"
                 style="
                    font-family: 'Courier New', monospace;
                    font-size: 0.9rem;
                    white-space: pre-wrap;
                 ">
{{ $displayText }}
            </pre>

        </div>

    </div>

@empty

    <!-- EMPTY STATE -->
    <div class="card border-0 bg-light text-center py-5">
        <div class="card-body">
            <h6 class="fw-semibold text-muted mb-2">
                No Computation Available
            </h6>
            <p class="text-muted mb-0">
                There are no saved computations for the selected project and model unit.
            </p>
        </div>
    </div>

@endforelse
