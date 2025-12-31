<div id="propertyCarousel" class="carousel slide" data-bs-ride="false">

    {{-- MAIN IMAGES --}}
    <div class="carousel-inner">
        @foreach($images as $index => $image)
            <div class="carousel-item {{ $image->is_thumbnail ? 'active' : '' }}">
                <img
                    src="{{ asset('storage/property_images/'.$image->file_name) }}"
                    class="d-block w-100"
                    alt="Property {{ $image->id }}"
                    width="1200"
                    height="800"
                    loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                    fetchpriority="{{ $index === 0 ? 'high' : 'auto' }}"
                    decoding="async"
                >
            </div>
        @endforeach
    </div>

    {{-- THUMBNAILS --}}
    <div class="mt-3 d-flex justify-content-center flex-wrap gap-2">
        @foreach($images as $index => $image)
            <img
                src="{{ asset('storage/property_images/'.$image->file_name) }}"
                class="img-thumbnail thumb {{ $image->is_thumbnail ? 'active-thumb' : '' }}"
                data-bs-target="#propertyCarousel"
                data-bs-slide-to="{{ $index }}"
                alt="Thumbnail {{ $image->id }}"
                width="120"
                height="80"
                loading="lazy"
                decoding="async"
            >
        @endforeach
    </div>
</div>



@push('scripts')
    @vite('resources/js/property-gallery.js')
@endpush
