<form id="calculator-form">
    <div class="row g-3">
        <div class="col-md-6">
            <label>Total Contract Price</label>
            <input type="number" class="form-control" id="total_contract_price" value="0">
        </div>

        <div class="col-md-6">
            <label>Processing Fee</label>
            <input type="number" class="form-control" id="processing_fee" min="0" value="0">
        </div>

        <div class="col-md-6">
            <label>Reservation Fee</label>
            <input type="number" class="form-control" id="reservation_fee" min="0" value="0">
        </div>

        <div class="col-md-6">
            <label>Processing Fee Months To Pay</label>
            <div class="input-group">
                <select class="form-control" id="pf_months">
                    @for($month = 1; $month <= 60; $month++)
                        <option value="{{$month}}">{{$month}} {{\Illuminate\Support\Str::plural('month', $month)}}</option>
                    @endfor
                </select>
            </div>
        </div>

        <div class="col-md-4">
            <label class="form-label">
                Equity Percentage <span class="text-danger">*</span>
            </label>

            <div class="input-group">
                <input
                    type="number"
                    class="form-control"
                    id="equity_percentage"
                    min="0"
                    max="100"
                    placeholder="Enter percentage"
                >
                <button
                    class="btn btn-outline-secondary"
                    type="button"
                    onclick="setEquityPercentage()"
                    title="Calculate equity percentage"
                >
                    <i class="fa fa-calculator"></i>
                </button>
            </div>
        </div>


        <div class="col-md-4">
            <label class="form-label">
                Equity Exact Amount <span class="text-danger">*</span>
            </label>

            <div class="input-group">
                <input
                    type="number"
                    class="form-control"
                    id="equity_exact_amount"
                    min="0"
                    placeholder="Enter amount"
                >
                <button
                    class="btn btn-outline-secondary"
                    onclick="setEquityExactAMount()"
                    type="button"
                    title="Calculate equity exact amount"
                >
                    <i class="fa fa-calculator"></i>
                </button>
            </div>
        </div>


        <div class="col-md-4">
            <label class="form-label">
                Equity Term <span class="text-danger">*</span>
            </label>
            <div class="input-group">
                <select class="form-control" id="equity_months">
                    @for($month = 1; $month <= 60; $month++)
                        <option value="{{$month}}">{{$month}} {{\Illuminate\Support\Str::plural('month', $month)}}</option>
                    @endfor
                </select>
            </div>
        </div>

        <div class="col-md-12">
            <label class="form-label">
                Loanable Amount <span class="text-danger">*</span>
            </label>

            <div class="input-group">
                <input
                    type="number"
                    class="form-control"
                    id="loanable_amount"
                    min="0"
                    placeholder="Enter loanable amount"
                >
                <button
                    class="btn btn-outline-secondary"
                    type="button"
                    onclick="setLoanableAmount()"
                    title="Calculate loanable amount"
                >
                    <i class="fa fa-calculator"></i>
                </button>
            </div>
        </div>


        <div class="col-md-12">
            <label>Years To Pay</label>
            <select class="form-control" id="years">
                <option value=""></option>
                <option value="5">5 Years</option>
                <option value="10">10 Years</option>
                <option value="15">15 Years</option>
            </select>
        </div>
    </div>
</form>

<hr>

<!-- Results -->
<div id="calc-result" class="d-none">
    <h6>Hausland In-house Computation</h6>

    <ul class="list-group" id="hausland-inhouse-result-list">
        <li class="list-group-item d-flex justify-content-between">
            <span>Total Contract Price</span>
            <strong id="total_contract_price_result">₱0</strong>
        </li>
        <li class="list-group-item d-flex justify-content-between">
            <span>(PF) Processing Fee</span>
            <strong id="processing_fee_result"></strong>
        </li>
        <li class="list-group-item d-flex justify-content-between">
            <span>(RF) - Reservation Fee</span>
            <strong id="reservation_fee_result">₱0</strong>
        </li>
        <li class="list-group-item d-flex justify-content-between">
            <span>PF less RF</span>
            <strong id="pf_less_rf">₱0</strong>
        </li>
        <li class="list-group-item d-flex justify-content-between">
            <span>PF less RF monthly payment <span id="pf_months_to_pay"></span></span>
            <strong id="pf_less_rf_monthly">₱0</strong>
        </li>
        <li class="list-group-item d-flex justify-content-between">
            <span>Equity</span>
            <strong id="equity_result">₱0</strong>
        </li>
        <li class="list-group-item d-flex justify-content-between">
            <span>Equity Payment <span id="monthly_equity_result"></span></span>
            <strong id="monthly_equity_payment_result">₱0</strong>
        </li>
        <li class="list-group-item d-flex justify-content-between">
            <span>Combined DP and PF within <span id="combined_monthly"></span> </span>
            <strong id="combined_monthly_result">₱0</strong>
        </li>
        <li class="list-group-item d-flex justify-content-between">
            <strong class="text-secondary">Monthly Amortization For The Chosen Loan Tenure</strong>
        </li>
        <li class="list-group-item d-flex justify-content-between">
            <span id="amortization"></span>
        </li>
    </ul>
</div>
