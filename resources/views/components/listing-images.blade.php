<div id="propertyCarousel" class="carousel slide" data-bs-ride="carousel">
    <!-- Main images -->
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="https://wallpaperaccess.com/full/1859346.jpg" class="d-block w-100" alt="Property 1">
        </div>
        <div class="carousel-item">
            <img src="https://ascentris.com/wp-content/uploads/2020/04/Investments-NY-Office-1.jpg" class="d-block w-100" alt="Property 2">
        </div>
        <div class="carousel-item">
            <img src="https://images.pexels.com/photos/13356892/pexels-photo-13356892.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" class="d-block w-100" alt="Property 3">
        </div>
        <div class="carousel-item">
            <img src="https://www.allproperties.com.ph/wp-content/uploads/2023/04/elaisa-house-and-lot-for-sale-in-aklan-5-bedroom-592x444.webp" class="d-block w-100" alt="Property 4">
        </div>
    </div>

    <!-- Thumbnail controls -->
    <div class="mt-3 d-flex justify-content-center flex-wrap gap-2">
        <img src="https://wallpaperaccess.com/full/1859346.jpg" class="img-thumbnail thumb active-thumb" data-bs-target="#propertyCarousel" data-bs-slide-to="0" alt="Thumbnail 1">
        <img src="https://ascentris.com/wp-content/uploads/2020/04/Investments-NY-Office-1.jpg" class="img-thumbnail thumb" data-bs-target="#propertyCarousel" data-bs-slide-to="1" alt="Thumbnail 2">
        <img src="https://images.pexels.com/photos/13356892/pexels-photo-13356892.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" class="img-thumbnail thumb" data-bs-target="#propertyCarousel" data-bs-slide-to="2" alt="Thumbnail 3">
        <img src="https://www.allproperties.com.ph/wp-content/uploads/2023/04/elaisa-house-and-lot-for-sale-in-aklan-5-bedroom-592x444.webp" class="img-thumbnail thumb" data-bs-target="#propertyCarousel" data-bs-slide-to="3" alt="Thumbnail 4">
    </div>
</div>

@section('scripts')
    @once
        @vite('resources/js/property-gallery.js')
    @endonce
@endsection
