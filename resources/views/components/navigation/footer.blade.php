<div class="app-footer">
    <footer class="footer bg-primary text-white">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <h5 class="mb-4">Navigation</h5>
                    <ul class="list-unstyled">
                        <li>
                            <a href="{{route('home')}}" class="text-decoration-none footer-link">Home</a>
                        </li>
                        <li>
                            <a href="{{route('listing.index')}}" class="text-decoration-none footer-link">Listings</a>
                        </li>
                        <li>
                            <a href="{{route('about-us')}}" class="text-decoration-none footer-link">About Us</a>
                        </li>
                        <li>
                            <a href="{{route('blogs')}}" class="text-decoration-none footer-link">Blogs</a>
                        </li>
                        <li>
                            <a href="{{route('contact-us')}}" class="text-decoration-none footer-link">Contact Us</a>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5 class="mb-4">Key Locations</h5>
                    <ul class="list-unstyled">
                        <li>
                            <a href="{{ route('listing.index') }}?location=pampanga" class="text-decoration-none footer-link">Pampanga</a>
                        </li>
                        <li>
                            <a href="{{ route('listing.index') }}?location=tarlac" class="text-decoration-none footer-link">Tarlac</a>
                        </li>
                        <li>
                            <a href="{{ route('listing.index') }}?location=bulacan" class="text-decoration-none footer-link">Bulacan</a>
                        </li>
                        <li>
                            <a href="{{ route('listing.index') }}?location=bataan" class="text-decoration-none footer-link">Bataan</a>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5 class="mb-4">Information</h5>
                    <ul class="list-unstyled">

                        <li>
                            <a href="{{route('privacy-policy')}}" class="text-decoration-none footer-link">Privacy Policy</a>
                        </li>
                        <li>
                            <a href="{{route('terms-and-conditions')}}" class="text-decoration-none footer-link">Terms & Conditions</a>
                        </li>
                        <li>
                            <a href="{{route('sitemap')}}" class="text-decoration-none footer-link">Sitemap</a>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5 class="mb-4">Get In Touch</h5>
                    <ul class="list-unstyled">
                        <li>
                            <a href="#" class="text-decoration-none footer-link"><i class="bi-envelope" aria-hidden="true"></i> johnkevinpaunel@gmail.com</a>
                        </li>
                        <li>
                            <a href="#" class="text-decoration-none footer-link"><i class="bi-phone" aria-hidden="true"></i> 091710277662 / 09297096801</a>
                        </li>
                        <li>
                            <a href="https://www.facebook.com/johnkevinPaunelVlog" target="_blank" class="text-decoration-none footer-link"><i class="bi-facebook"></i> John Kevin Paunel</a>
                        </li>
                        <li>
                            <a href="https://www.youtube.com/@JohnKevinPaunel" target="_blank" class="text-decoration-none footer-link"><i class="bi-youtube"></i> John Kevin Paunel</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </footer>
    <footer class="container-fluid text-center text-white p-2 bg-dark">
        <div class="container">
            <p>Copyright © {{now()->format('Y')}} johnkevinpaunel.com</p>
        </div>
    </footer>
</div>
