<form>
    @csrf
    <div class="row">
        <div class="col-lg-3 form-floating mb-3 location">
            <select name="location" class="form-select" id="location" aria-label="Floating label select example">
                <option selected>Any</option>
                <option value="1">Pampanga</option>
                <option value="2">Tarlac</option>
                <option value="3">Bulacan</option>
            </select>
            <label for="location">Location</label>
        </div>
        <div class="col-lg-3 form-floating mb-3 property_type">
            <select name="property_type" class="form-select" id="property_type" aria-label="Floating label select example">
                <option selected>Any</option>
                <option value="1">Bungalow</option>
                <option value="2">Single-attached</option>
                <option value="3">Single-detached</option>
                <option value="3">Townhouse</option>
                <option value="3">Condominium</option>
            </select>
            <label for="property_type">Property Type</label>
        </div>
        <div class="col-lg-3 form-floating mb-3 purpose">
            <select name="purpose" class="form-select" id="purpose" aria-label="Floating label select example">
                <option selected>Any</option>
                <option value="1">Buy</option>
                <option value="2">Rent</option>
            </select>
            <label for="purpose">Purpose</label>
        </div>
        <div class="col-lg-3 form-floating mb-3 purpose">
            <button type="submit" class="btn button-orange w-100 p-3" id="search-btn">Search</button>
        </div>
    </div>
</form>
