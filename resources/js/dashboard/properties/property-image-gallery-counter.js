document.addEventListener("DOMContentLoaded", function () {
    const carouselElement = document.querySelector('#propertyGallery');
    if (!carouselElement) return;

    const numberDisplay = document.getElementById('carouselNumber');
    const items = carouselElement.querySelectorAll('.carousel-item');

    // Set initial number
    let activeIndex = [...items].findIndex(item => item.classList.contains('active'));
    numberDisplay.textContent = activeIndex + 1;

    // Listen for slide change
    carouselElement.addEventListener('slid.bs.carousel', function (event) {
        let index = typeof event.to !== 'undefined'
            ? event.to
            : [...items].indexOf(event.relatedTarget);

        numberDisplay.textContent = index + 1;
    });
});
