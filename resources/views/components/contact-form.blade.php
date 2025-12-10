<form id="client-inquiry-form" class="contact-form">
    @csrf
    <div class="row">
        <div class="col-md-6 first_name mt-3">
            <label for="first_name">First Name</label> <span class="text-danger">*</span>
            <input type="text" name="first_name" class="form-control" id="first_name" required>
        </div>
        <div class="col-md-6 last_name mt-3">
            <label for="last_name">Last Name</label> <span class="text-danger">*</span>
            <input type="text" name="last_name" class="form-control" id="last_name" required>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 email mt-3">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" id="email">
        </div>
        <div class="col-md-6 phone mt-3">
            <label for="phone">Mobile Number</label> <span class="text-danger">*</span>
            <input type="number" name="phone" class="form-control" id="phone">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 message mt-3">
            <label for="message">Message</label>
            <textarea name="message" class="form-control" id="message" cols="30" rows="10"></textarea>
        </div>
    </div>
    @if(!is_null($propertyId))
        <input type="hidden" name="property_id" value="{{$propertyId}}">
    @endif
    <div class="col-12 g-recaptcha-response mt-4">
        {!! NoCaptcha::display() !!}
    </div>
    <div>
        <button type="submit" class="btn button-orange mt-3 w-100">Submit</button>
    </div>
</form>

@push('scripts')
    {!! NoCaptcha::renderJs() !!}
    @vite('resources/js/contactForms/contact-form.js')
@endpush

@push('meta')

@endpush
