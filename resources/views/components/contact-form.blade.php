<form autocomplete="off">
    @csrf
    <div class="row">
        <div class="col-md-6 firstname mt-3">
            <label for="firstname">First Name</label> <span class="text-danger">*</span>
            <input type="text" name="firstname" class="form-control" id="firstname" autocomplete="new-name" required>
        </div>
        <div class="col-md-6 lastname mt-3">
            <label for="lastname">Last Name</label> <span class="text-danger">*</span>
            <input type="text" name="lastname" class="form-control" id="lastname" autocomplete="new-name" required>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 email mt-3">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" id="email" autocomplete="new-name">
        </div>
        <div class="col-md-6 mobile_number mt-3">
            <label for="mobile_number">Mobile Number</label> <span class="text-danger">*</span>
            <input type="number" name="mobile_number" class="form-control" id="mobile_number" autocomplete="new-name" required>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 message mt-3">
            <label for="message">Message</label>
            <textarea name="message" class="form-control" id="message" cols="30" rows="10"></textarea>
        </div>
    </div>
    <div>
        <button type="submit" class="btn button-orange mt-3 w-100">Submit</button>
    </div>
</form>
