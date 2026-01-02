<form id="calculator-form">
    <div class="row g-3">
        <div class="col-md-6">
            <label>Total Contract Price</label>
            <input type="number" class="form-control" id="total_contract_price">
        </div>

        <div class="col-md-6">
            <label>Discount</label>
            <input type="number" class="form-control" id="discount" min="0" value="0">
        </div>

        <div class="col-md-6">
            <label>Reservation Fee</label>
            <input type="number" class="form-control" id="reservation_fee">
        </div>


        <div class="col-md-6">
            <label>Gross Equity</label>
            <input type="number" class="form-control" id="gross_equity" min="0">
        </div>

        <div class="col-md-4">
            <label>Equity Term</label>
            <select class="form-control" id="months">
                @for($month = 1; $month <= 60; $month++)
                    <option value="{{$month}}">{{$month}} {{\Illuminate\Support\Str::plural('month', $month)}}</option>
                @endfor
            </select>
        </div>

        <div class="col-md-4">
            <label>Loan Term (Years)</label>
            <select class="form-control" id="years">
                @for($year = 1; $year <= 30; $year++)
                    <option value="{{$year}}">{{$year}} {{\Illuminate\Support\Str::plural('Year', $year)}}</option>
                @endfor
                <option value="10">10 Years</option>
                <option value="15">15 Years</option>
                <option value="20">20 Years</option>
                <option value="25">25 Years</option>
                <option value="30">30 Years</option>
            </select>
        </div>
        <div class="col-md-4">
            <label>Interest Rate</label>
            <input type="number" class="form-control" id="interest_rate" min="0" value="6.784">
        </div>
    </div>
</form>

<hr>

<!-- Results -->
<div id="calc-result" class="d-none">
    <h6>APEC Homes - HDMF Sample Computation</h6>

    <ul class="list-group">
        <li class="list-group-item d-flex justify-content-between">
            <span>(TCP) Total Contract Price</span>
            <strong id="property_total_contract_price">₱0</strong>
        </li>
        <li class="list-group-item d-flex justify-content-between">
            <span>Discount</span>
            <strong id="propertyDiscount"></strong>
        </li>
        <li class="list-group-item d-flex justify-content-between">
            <span>Discounted TCP</span>
            <strong id="discountedTcp"></strong>
        </li>
        <li class="list-group-item d-flex justify-content-between">
            <span>Reservation Fee</span>
            <strong id="property_reservation_fee">₱0</strong>
        </li>
        <li class="list-group-item d-flex justify-content-between">
            <span>Gross Equity</span>
            <strong id="property_gross_equity">₱0</strong>
        </li>
        <li class="list-group-item d-flex justify-content-between">
            <span>Equity Months To Pay</span>
            <strong id="equity_months_to_pay">₱0</strong>
        </li>
        <li class="list-group-item d-flex justify-content-between">
            <span>Monthly Equity </span>
            <strong id="monthly_equity">₱0</strong>
        </li>
        <li class="list-group-item d-flex justify-content-between">
            <span>Loanable AMount</span>
            <strong id="loanable_amount">₱0</strong>
        </li>
        <li class="list-group-item d-flex justify-content-between">
            <strong id="terms" class="text-secondary"></strong>
        </li>
        <li class="list-group-item d-flex justify-content-between">
            <span>HDMF Monthly Amortization</span>
            <strong id="hdmf_monthly_amortization">₱0</strong>
        </li>
        <li class="list-group-item d-flex justify-content-between">
            <span>Required Monthly Income</span>
            <strong id="required_monthly_income">₱0</strong>
        </li>
    </ul>
</div>
