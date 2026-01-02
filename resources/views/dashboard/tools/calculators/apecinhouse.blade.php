<a href="https://drive.google.com/drive/folders/1YzAwNRW2iuITjtszA6bK0mdpokRrON3r?usp=drive_link" target="_blank" class="btn btn-primary mb-4">
    View Apec Homes Pampanga - Google Drive</a>
<form id="calculator-form">
    <div class="row g-3">
        <div class="col-md-6">
            <label>Total Contract Price</label>
            <input type="number" class="form-control" id="total_contract_price" >
        </div>

        <div class="col-md-6">
            <label>Discount</label>
            <input type="number" class="form-control" id="discount" min="0" value="0">
        </div>

        <div class="col-md-6">
            <label>Reservation Fee</label>
            <input type="number" class="form-control" id="reservation_fee" value="10000">
        </div>


        <div class="col-md-6">
            <label>Equity Percentage</label>
            <input type="number" class="form-control" id="equity_percentage" min="0" value="30">
        </div>

        <div class="col-md-6">
            <label>Equity Term</label>
            <select class="form-control" id="months">
                @for($month = 1; $month <= 60; $month++)
                    <option value="{{$month}}" @if($month == 24) selected @endif>{{$month}} {{\Illuminate\Support\Str::plural('month', $month)}}</option>
                @endfor
            </select>
        </div>
    </div>
</form>

<hr>

<!-- Results -->
<div id="calc-result" class="d-none">
    <h6>APEC Homes - In-house Financing Computation</h6>

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
            <span>5 Years (12%/Annum)</span>
            <strong id="five_years_amortization">₱0</strong>
        </li>
        <li class="list-group-item d-flex justify-content-between">
            <span>10 Years (17%/Annum)</span>
            <strong id="ten_years_amortization">₱0</strong>
        </li>
    </ul>
</div>
