<form action="{{route('listing.index')}}" method="get">
    @csrf
    <div class="row">
        <div class="col-lg-3 form-floating mb-3 location">
            <select name="location" class="form-select" id="location" aria-label="Floating label select example">
                <option value="" selected>Any</option>
                @foreach ($location as $key => $value)
                    <option value="{{$key}}">{{$value}}</option>
                @endforeach
            </select>
            <label for="location">Location</label>
        </div>
        <div class="col-lg-3 form-floating mb-3 category">
            <select name="category" class="form-select" id="category" aria-label="Floating label select example">
                <option value="" selected>Any</option>
                @foreach ($propertyCategories as $key => $value)
                    <option value="{{$key}}">{{$value}}</option>
                @endforeach
            </select>
            <label for="property_type">Property Category</label>
        </div>
        <div class="col-lg-3 form-floating mb-3 purpose">
            <select name="purpose" class="form-select" id="purpose" aria-label="Floating label select example">
                <option value="" selected>Any</option>
                @foreach ($propertyTypes as $key => $value)
                    <option value="{{$key}}">{{$value}}</option>
                @endforeach
            </select>
            <label for="purpose">Purpose</label>
        </div>
        <div class="col-lg-3 form-floating mb-3 purpose">
            <button type="submit" class="btn button-orange w-100 p-3" id="search-btn">Search</button>
        </div>
    </div>
</form>
