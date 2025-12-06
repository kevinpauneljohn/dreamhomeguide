@if($leadType === 'seller')
    <form id="list-my-property-form">
        @csrf
        <div class="row g-3">
            <div class="col-md-6 first_name">
                <label class="form-label">First Name</label><span class="text-danger">*</span>
                <input name="first_name" id="first_name" type="text" class="form-control" required>
            </div>
            <div class="col-md-6 last_name">
                <label class="form-label">Last Name</label><span class="text-danger">*</span>
                <input name="last_name" id="last_name" type="text" class="form-control" required>
            </div>
            <div class="col-md-6 phone">
                <label class="form-label">Mobile Number</label><span class="text-danger">*</span>
                <input name="phone" type="text" id="phone" class="form-control">
            </div>
            <div class="col-md-6 email">
                <label class="form-label">Email</label><span class="text-danger">*</span>
                <input name="email" id="email" type="email" class="form-control">
            </div>
            <div class="col-md-6 location">
                <label class="form-label">Location</label><span class="text-danger">*</span>
                <input name="location" id="location" type="text" class="form-control" required>
            </div>
            <div class="col-md-6 property_category">
                <label class="form-label">Property Category</label><span class="text-danger">*</span>
                <select name="property_category" id="property_category" class="form-select" required>
                    <option value="">-- select category --</option>
                    @foreach ($propertyCategories as $key => $value)
                        <option value="{{$key}}">{{$value}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-12 additional_details">
                <label class="form-label">Additional Details</label>
                <textarea name="additional_details" id="additional_details" class="form-control" rows="4"></textarea>
            </div>
            <div class="col-12 g-recaptcha-response">
                {!! NoCaptcha::display() !!}
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-4 w-100 py-2">Submit Property Details</button>
    </form>
@endif


@push('scripts')
    @if($leadType === 'seller')
        {!! NoCaptcha::renderJs() !!}
        @vite('resources/js/pages/list-my-property.js')
    @endif
@endpush
