<form>
    @csrf
    <div class="row g-3 align-items-end mb-3">
        <!-- Property Type -->
        <div class="col-md-3">
            <label for="property_type" class="form-label">Property Type</label>
            <select name="property_type" id="property_type" class="form-select">
                <option value=""></option>
                <option value="buy">Lot Only</option>
                <option value="rent">Bungalow</option>
                <option value="rent">Townhouse</option>
                <option value="rent">Single-attached</option>
                <option value="rent">Single-Detached</option>
                <option value="rent">Condominium</option>
                <option value="rent">Commercial Space</option>
            </select>
        </div>

        <!-- Purpose -->
        <div class="col-md-3">
            <label for="purpose" class="form-label">Purpose</label>
            <select name="purpose" id="purpose" class="form-select">
                <option value=""></option>
                <option value="buy">Buy</option>
                <option value="rent">Rent</option>
            </select>
        </div>

        <!-- Min & Max Price -->
        <div class="col-md-3">
            <div class="row g-2">
                <div class="col">
                    <label for="minPrice" class="form-label">Min Price</label>
                    <select name="minPrice" id="minPrice" class="form-select">
                        <option value=""></option>
                        @for($minPrice = 1; $minPrice <= 20; $minPrice++)
                            <option value="{{$minPrice}}">{{$minPrice}} Million</option>
                        @endfor
                    </select>
                </div>
                <div class="col">
                    <label for="maxPrice" class="form-label">Max Price</label>
                    <select name="maxPrice" id="maxPrice" class="form-select">
                        <option value=""></option>
                        @for($maxPrice = 1; $maxPrice <= 20; $maxPrice++)
                            <option value="{{$maxPrice}}">{{$maxPrice}} Million</option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>

        <!-- Min & Max Area -->
        <div class="col-md-3">
            <div class="row g-2">
                <div class="col">
                    <label for="minPrice" class="form-label">Min Area</label>
                    <select name="lot_area" id="lot_area" class="form-select">
                        <option value=""></option>
                        @for($lotArea = 50; $lotArea <= 500; $lotArea = $lotArea + 50)
                            <option value="{{$lotArea}}">{{$lotArea}} sqm</option>
                        @endfor
                    </select>
                </div>
                <div class="col">
                    <label for="maxPrice" class="form-label">Max Area</label>
                    <select name="maxPrice" id="maxPrice" class="form-select">
                        <option value=""></option>
                        @for($lotArea = 50; $lotArea <= 500; $lotArea = $lotArea + 50)
                            <option value="{{$lotArea}}">{{$lotArea}} sqm</option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-3 align-items-end">
                <!-- Rooms -->
        <div class="col-md-3">
            <label for="room" class="form-label">Room</label>
            <select name="garage" id="garage" class="form-select">
                <option value=""></option>
                @for($room = 1; $room <= 10; $room++)
                    <option value="{{$room}}">{{$room}}</option>
                @endfor
            </select>
        </div>

        <!-- Garage -->
        <div class="col-md-3">
            <label for="garage" class="form-label">Garage</label>
            <select name="garage" id="garage" class="form-select">
                <option value=""></option>
                @for($garage = 1; $garage <= 10; $garage++)
                    <option value="{{$garage}}">{{$garage}}</option>
                @endfor
            </select>
        </div>

        <!-- Location Input -->
        <div class="col-md-3">
            <label for="location" class="form-label">Location</label>
            <select name="location" id="location" class="form-select">
                <option value=""></option>
                <option value="Pampanga">Pampanga</option>
                <option value="Tarlac">Tarlac</option>
                <option value="Bulacan">Bulacan</option>
                <option value="Bataan">Bataan</option>
            </select>
        </div>

        <!-- Search Button -->
        <div class="col-md-3 d-flex">
            <button type="submit" class="btn btn-warning w-100">Search</button>
        </div>
    </div>
</form>
