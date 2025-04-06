let slideIndex = 1;
let slideTimer; // Variable to store the timer

// When the document is loaded, show the first slide
document.addEventListener('DOMContentLoaded', function() {
    showSlides(slideIndex);
    startSlideTimer(); // Start initial timer
});

function startSlideTimer() {
    // Clear any existing timer
    clearInterval(slideTimer);
    // Start a new timer
    slideTimer = setInterval(function() {
        changeSlide(1);
    }, 5000);
}

function changeSlide(n) {
    showSlides(slideIndex += n);
    startSlideTimer(); // Reset timer
}

function currentSlide(n) {
    showSlides(slideIndex = n);
    startSlideTimer(); // Reset timer
}

function showSlides(n) {
    let slides = document.getElementsByClassName("slide");
    let dots = document.getElementsByClassName("dot");
    
    if (n > slides.length) {slideIndex = 1}
    if (n < 1) {slideIndex = slides.length}
    
    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    
    for (let i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" activeDot", "");
    }
    
    slides[slideIndex-1].style.display = "block";
    dots[slideIndex-1].className += " activeDot";
}

document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const mainNav = document.querySelector('.main-nav');

    mobileMenuToggle.addEventListener('click', function() {
        mainNav.classList.toggle('active');
        const icon = mobileMenuToggle.querySelector('i');
        if (mainNav.classList.contains('active')) {
            icon.classList.remove('fa-times');
            icon.classList.add('fa-bars');
        } else {
            icon.classList.remove('fa-bars');
            icon.classList.add('fa-times');
        }
    });
});
