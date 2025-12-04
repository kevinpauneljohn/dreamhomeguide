<div id="propertyCarousel" class="carousel slide" data-bs-ride="carousel">
    <!-- Main images -->
    <div class="carousel-inner">
        @foreach($images as $image)
            <div class="carousel-item {{$image->is_thumbnail ? 'active' : ''}}">
                <img src="/storage/property_images/{{$image->file_name}}" class="d-block w-100" alt="Property {{$image->id}}">
            </div>
        @endforeach
    </div>

    <!-- Thumbnail controls -->
    <div class="mt-3 d-flex justify-content-center flex-wrap gap-2">
        @php $imageCounter = 0; @endphp
        @foreach($images as $image)
            <img src="/storage/property_images/{{$image->file_name}}" class="img-thumbnail thumb {{$image->is_thumbnail ? 'active-thumb' : ''}}" data-bs-target="#propertyCarousel" data-bs-slide-to="{{$imageCounter++}}" alt="Thumbnail {{$image->id}}">
        @endforeach
    </div>
</div>

@push('scripts')
    @vite('resources/js/property-gallery.js')
@endpush
