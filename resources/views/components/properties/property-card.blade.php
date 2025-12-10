<div class="col">

    <div class="card h-100">

                <span class="position-absolute mt-3 ms-3 d-flex align-items-start text-wrap bg-dark bg-opacity-50 text-white rounded px-3 py-2"
                      style="max-width: 90%; white-space: normal; line-height: 1.25; font-size: 13px;">

                    <i class="fa fa-map-marker-alt me-2 mt-1"></i>

                    <span class="lh-sm">
                        {{ ucwords(strtolower($property->location)) }}
                    </span>

                </span>


        <a href="{{route('show-property-by-slug',['slug' => $property->slug])}}" class="stretched-link">
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
                    @if(!empty($property->bedrooms))
                        <div class="mb-2">
                            <i class="fa-solid fa-bed fa-xl text-orange"></i>
                            <span class="">{{$property->bedrooms}} {{\Illuminate\Support\Str::plural('Bedroom', $property->bedrooms)}}</span>
                        </div>
                    @endif
                    @if(!empty($property->lot_area))
                        <div>
                            <i class="fa-solid fa-arrows-alt fa-xl text-orange"></i>
                            <span class="">{{number_format($property->lot_area,2)}} {{\Illuminate\Support\Str::plural('sqm', $property->lot_area)}}</span>
                        </div>
                    @endif

                </div>
                <div>
                    @if(!empty($property->bathrooms))
                        <div class="mb-2">
                            <i class="fa-solid fa-shower fa-xl text-orange"></i>
                            <span class="">{{$property->bathrooms}} {{\Illuminate\Support\Str::plural('Bathrooms', $property->bathrooms)}} </span>
                        </div>
                    @endif
                    @if(!empty($property->garage))
                        <div>
                            <i class="fa-solid fa-car-alt fa-xl text-orange"></i>
                            <span class="">{{$property->garage}} {{\Illuminate\Support\Str::plural('Carport', $property->garage)}}</span>
                        </div>
                    @endif

                </div>
            </div>
        </div>
{{--        <div class="card-footer">--}}
{{--            <span class="badge text-bg-primary">Available</span>--}}
{{--        </div>--}}
    </div>
</div>
