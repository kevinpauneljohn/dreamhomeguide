@push('modal')
    <!-- Calculator Modal -->
    <div class="modal fade" id="calculatorModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Calculator</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <label for="calculator-type">Select Calculator</label>
                    <select id="calculator-type" class="form-select mb-4">
                        <option value=""></option>
                        <option value="mortgage">Mortgage</option>
                        <option value="apecpagibig">Apec Homes - Pag-IBIG</option>
                        <option value="apecinhouse">Apec Homes - In-house</option>
                    </select>
                    <div id="calculator-content"></div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" id="calculateBtn">Calculate</button>
                </div>
            </div>
        </div>
    </div>

@endpush

{{--@pushonce('scripts')--}}
{{--    @vite('resources/js/component/floatingTools/calculator.js')--}}
{{--@endpushonce--}}
