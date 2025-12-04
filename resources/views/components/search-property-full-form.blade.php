<form id="full-search-property-form">
    @csrf
    <div class="row g-3 align-items-end mb-3">
        <!-- Property Type -->
        <div class="col-md-3">
            <label for="category" class="form-label">Property Type</label>
            <select name="category" id="category" class="form-select">
                <option value=""></option>
                @foreach ($propertyCategories as $key => $value)
                    <option value="{{$key}}" @if(request('category') == $key) selected @endif>{{$value}}</option>
                @endforeach
            </select>
        </div>

        <!-- Purpose -->
        <div class="col-md-3">
            <label for="purpose" class="form-label">Purpose</label>
            <select name="purpose" id="purpose" class="form-select">
                <option value=""></option>
                @foreach ($propertyTypes as $key => $value)
                    <option value="{{$key}}" @if(request('purpose') == $key) selected @endif>{{$value}}</option>
                @endforeach
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
                            <option value="{{$minPrice}}" @if(request('minPrice') == $minPrice) selected @endif>{{$minPrice}} Million</option>
                        @endfor
                    </select>
                </div>
                <div class="col">
                    <label for="maxPrice" class="form-label">Max Price</label>
                    <select name="maxPrice" id="maxPrice" class="form-select">
                        <option value=""></option>
                        @for($maxPrice = 1; $maxPrice <= 20; $maxPrice++)
                            <option value="{{$maxPrice}}" @if(request('maxPrice') == $maxPrice) selected @endif>{{$maxPrice}} Million</option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>

        <!-- Min & Max Area -->
        <div class="col-md-3">
            <div class="row g-2">
                <div class="col">
                    <label for="minArea" class="form-label">Min Area</label>
                    <select name="minArea" id="minArea" class="form-select">
                        <option value=""></option>
                        @for($minArea = 50; $minArea <= 500; $minArea = $minArea + 50)
                            <option value="{{$minArea}}" @if(request('minArea') == $minArea) selected @endif>{{$minArea}} sqm</option>
                        @endfor
                    </select>
                </div>
                <div class="col">
                    <label for="maxArea" class="form-label">Max Area</label>
                    <select name="maxArea" id="maxArea" class="form-select">
                        <option value=""></option>
                        @for($max_area = 50; $max_area <= 500; $max_area = $max_area + 50)
                            <option value="{{$max_area}}" @if(request('maxArea') == $max_area) selected @endif>{{$max_area}} sqm</option>
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
            <select name="room" id="room" class="form-select">
                <option value=""></option>
                @for($room = 1; $room <= 10; $room++)
                    <option value="{{$room}}" @if(request('room') == $room) selected @endif>{{$room}}</option>
                @endfor
            </select>
        </div>

        <!-- Garage -->
        <div class="col-md-3">
            <label for="garage" class="form-label">Garage</label>
            <select name="garage" id="garage" class="form-select">
                <option value=""></option>
                @for($garage = 1; $garage <= 10; $garage++)
                    <option value="{{$garage}}" @if(request('garage') == $garage) selected @endif>{{$garage}}</option>
                @endfor
            </select>
        </div>

        <!-- Location Input -->
        <div class="col-md-3">
            <label for="location" class="form-label">Location</label>
            <select name="location" id="location" class="form-select">
                <option value=""></option>
                @foreach ($location as $key => $value)
                    <option value="{{$key}}" @if(request('location') == $key) selected @endif>{{$value}}</option>
                @endforeach
            </select>
        </div>

        <!-- Search Button -->
        <div class="col-md-3 d-flex">
            <button type="submit" class="btn btn-warning w-100">Search</button>
        </div>
    </div>
</form>

@push('scripts')

@endpush
