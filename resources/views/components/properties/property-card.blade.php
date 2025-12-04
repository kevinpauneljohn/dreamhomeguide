<div class="col">

    <div class="card h-100">

                <span class="badge rounded-pill text-bg-dark bg-opacity-50 position-absolute mt-3 ms-3">
                    <i class="fa fa-map-marker-alt fa-xl"></i>
                    {{ucwords(strtolower($property->location))}}
                </span>
        <a href="{{route('show-property-by-slug',['slug' => $property->slug])}}">
            @php
                $thumbnail = $property->images()->where('is_thumbnail',true);
                $propertyPhoto = $thumbnail->count() > 0 ? $thumbnail->first()->file_name : 'No Photo';
            @endphp

            <img src="/storage/property_images/{{$propertyPhoto}}" class="card-img-top featured-property-image" alt="{{$propertyPhoto}}">
        </a>

        <div class="card-body">
            <h3 class="card-title">&#8369 {{number_format($property->price,2)}}</h3>
            <p class="card-text">{{ucwords(strtolower($property->title))}}</p>
            <div class="d-flex justify-content-between mb-3">
                <div>
                    <div class="mb-2">
                        <i class="fa-solid fa-bed fa-xl text-orange"></i>
                        <span class="">{{$property->bedrooms}} Bedrooms</span>
                    </div>
                    <div>
                        <i class="fa-solid fa-arrows-alt fa-xl text-orange"></i>
                        <span class="">{{number_format($property->lot_area,2)}} sqm</span>
                    </div>
                </div>
                <div>
                    <div class="mb-2">
                        <i class="fa-solid fa-shower fa-xl text-orange"></i>
                        <span class="">{{$property->bathrooms}} Bathrooms</span>
                    </div>
                    <div>
                        <i class="fa-solid fa-car-alt fa-xl text-orange"></i>
                        <span class="">{{$property->garage}} Carport</span>
                    </div>
                </div>
            </div>
        </div>
{{--        <div class="card-footer">--}}
{{--            <span class="badge text-bg-primary">Available</span>--}}
{{--        </div>--}}
    </div>
</div>
