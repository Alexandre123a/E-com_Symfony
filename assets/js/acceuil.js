let slideIndex = 1;
showSlides(slideIndex);

let next = document.getElementsByClassName('next');
let prev = document.getElementsByClassName('prev');

next[0].addEventListener('click',function () {
    plusSlides(1)

});
prev[0].addEventListener('click',function () {
    plusSlides(-1)

})


// Next/previous controls
function plusSlides(n) {
    showSlides(slideIndex += n);
}

// Thumbnail image controls
function currentSlide(n) {
    showSlides(slideIndex = n);
}

function showSlides(n) {
    let i;
    let slides = document.getElementsByClassName("mySlides");
    if (n > slides.length) {slideIndex = 1}
    if (n < 1) {slideIndex = slides.length}
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    slides[slideIndex-1].style.display = "block";

}