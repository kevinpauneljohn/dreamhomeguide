document.addEventListener('DOMContentLoaded', () => {
    const carouselEl = document.getElementById('propertyCarousel');
    if (!carouselEl) return;

    const carousel = new bootstrap.Carousel(carouselEl, {
        interval: false,
        ride: false
    });

    const thumbs = document.querySelectorAll('.thumb');

    // When carousel slides, update active thumbnail
    carouselEl.addEventListener('slide.bs.carousel', (e) => {
        thumbs.forEach(t => t.classList.remove('active-thumb'));
        thumbs[e.to].classList.add('active-thumb');
    });

    // When thumbnail is clicked
    thumbs.forEach((thumb, index) => {
        thumb.addEventListener('click', () => {
            carousel.to(index);

            thumbs.forEach(t => t.classList.remove('active-thumb'));
            thumb.classList.add('active-thumb');
        });
    });
});
