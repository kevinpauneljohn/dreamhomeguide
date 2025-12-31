<form id="calculator-form">
    <div class="row g-3">
        <div class="col-md-6">
            <label>Property Price</label>
            <input type="number" class="form-control" id="price" placeholder="e.g. 2500000">
        </div>

        <div class="col-md-6">
            <label>Downpayment (%)</label>
            <input type="number" class="form-control" id="dpPercent" value="20">
        </div>

        <div class="col-md-6">
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

        <div class="col-md-6">
            <label>Interest Rate (% / year)</label>
            <input type="number" class="form-control" id="interest" value="6.5">
        </div>
    </div>
</form>

<hr>

<!-- Results -->
<div id="calc-result" class="d-none">
    <h6>Computation Summary</h6>

    <ul class="list-group">
        <li class="list-group-item d-flex justify-content-between">
            <span>Downpayment</span>
            <strong id="dpAmount">₱0</strong>
        </li>
        <li class="list-group-item d-flex justify-content-between">
            <span>Loan Amount</span>
            <strong id="loanAmount">₱0</strong>
        </li>
        <li class="list-group-item d-flex justify-content-between">
            <span>Monthly Amortization</span>
            <strong id="monthly">₱0</strong>
        </li>
    </ul>
</div>
