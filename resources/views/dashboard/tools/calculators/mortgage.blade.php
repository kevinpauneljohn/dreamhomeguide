<form id="calculator-form">
    <div class="row g-3">
        <div class="col-md-6">
            <label>Property Price</label>
            <input type="number" class="form-control" id="price">
        </div>

        <div class="col-md-6">
            <label>Down payment (%)</label>
            <input type="number" class="form-control" id="dpPercent" min="0" max="100" placeholder="100%">
        </div>

        <div class="col-md-6">
            <label>Loan Term (Years)</label>
            <select class="form-control" id="years">
                @for($year = 1; $year <= 30; $year++)
                    <option value="{{$year}}">{{$year}} {{\Illuminate\Support\Str::plural('Year', $year)}}</option>
                @endfor
            </select>
        </div>

        <div class="col-md-6">
            <label>Interest Rate (% / year)</label>
            <input type="number" class="form-control" id="interest" placeholder="12%">
        </div>
    </div>
</form>

<hr>

<!-- Results -->
<div id="calc-result" class="d-none">
    <h6>Computation Summary</h6>

    <ul class="list-group">
        <li class="list-group-item d-flex justify-content-between">
            <span>Property Price</span>
            <strong id="propertyPrice">₱0</strong>
        </li>
        <li class="list-group-item d-flex justify-content-between">
            <span>Down payment %</span>
            <strong id="dpPercentValue"></strong>
        </li>
        <li class="list-group-item d-flex justify-content-between">
            <span>Down payment</span>
            <strong id="dpAmount">₱0</strong>
        </li>
        <li class="list-group-item d-flex justify-content-between">
            <span>Loan Amount</span>
            <strong id="loanAmount">₱0</strong>
        </li>
        <li class="list-group-item d-flex justify-content-between">
            <strong id="terms" class="text-secondary"></strong>
        </li>
        <li class="list-group-item d-flex justify-content-between">
            <span>Monthly Amortization</span>
            <strong id="monthly">₱0</strong>
        </li>
        <li class="list-group-item d-flex justify-content-between">
            <span>Required Monthly Income</span>
            <strong id="monthlyIncome">₱0</strong>
        </li>
    </ul>
</div>
