const carousel = document.querySelector('#propertyCarousel');
const thumbs = document.querySelectorAll('.thumb');

carousel.addEventListener('slide.bs.carousel', function (e) {
    thumbs.forEach(t => t.classList.remove('active-thumb'));
    thumbs[e.to].classList.add('active-thumb');
});
