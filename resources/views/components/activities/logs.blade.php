@if(!empty($url))
    <table id="activity-logs-table" class="table table-hover align-middle" data-url="{{$url}}">
        <thead><tr></tr></thead>
        <tbody></tbody>
    </table>


    @if(auth()->user()->hasRole(['super admin','manager']))
        @pushonce('modal')
            <!-- ADD APPOINTMENT MODAL -->
            <div class="modal fade" id="viewActivityModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @endpushonce
    @endif

    @pushonce('scripts')
        @vite(['resources/js/component/activities/logs.js'])
    @endpushonce
@endif

