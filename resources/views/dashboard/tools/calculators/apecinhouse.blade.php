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
<div id="calc-result" class="d-none apec-homes-in-house-computation">
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
            <span>Loanable Amount</span>
            <strong id="loanable_amount">₱0</strong>
        </li>
        <li class="list-group-item d-flex justify-content-between">
            <span>Monthly Amortization for the chosen loan tenure</span>
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
    <!-- Prepared By Section -->
    <div class="border-top pt-3 mt-3 small text-muted">
        <div class="row">
            <div class="col-md-6">
                <strong>Prepared by:</strong><br>
                {{ucwords(strtolower(auth()->user()->full_name))}}
            </div>
            <div class="col-md-6 text-md-end">
                <div><strong>Contact:</strong> <a href="tel:{{auth()->user()->phone}}">{{auth()->user()->phone}}</a> </div>
                <div><strong>Email:</strong> <a href="mailto:inquiry@johnkevinpaunel.com">inquiry@johnkevinpaunel.com</a></div>
            </div>
        </div>
    </div>
</div>
<button class="btn btn-outline-primary mt-3" onclick="downloadApecHomesInHousePDF()">
    <i class="fa fa-file-pdf"></i> Download PDF
</button>
