let slideIndex = 1;
let slideTimer; // Mainīgais, kurā glabāsies taimeris

// Slideshow inicializēšana, kad lapa tiek ielādēta
document.addEventListener('DOMContentLoaded', function() {
    showSlides(slideIndex);
    startSlideTimer(); // Startēt taimeri
});

// Funkcija, kas sāk taimerīša automātisko darbību
function startSlideTimer() {
    // Visu esošo taimeru dzēšana, lai novērstu vairāku taimeru parādīšanos.
    clearInterval(slideTimer);
    // Startēt jaunu taimerīšu, kas maina slaidus katru 5 sekundes.
    slideTimer = setInterval(function() {
        changeSlide(1);
    }, 5000);
}

// Funkcija, kas maina slaidus manuāli (nākamašais/iepriekšējais)
function changeSlide(n) {
    showSlides(slideIndex += n);
    startSlideTimer(); // Taimeris tiek atiestatīts, kad slaidus tiek mainīts manuāli
}

// Funkcija, kas parāda konkrētu slaidu, izmantojot tās indeksu
function currentSlide(n) {
    showSlides(slideIndex = n);
    startSlideTimer(); // Taimeris tiek atiestatīts, kad slaidus tiek mainīts manuāli
}

// Galvenā funkcija, kas parāda slaidus un atjaunina navigācijas punktus
function showSlides(n) {
    let slides = document.getElementsByClassName("slide");
    let dots = document.getElementsByClassName("dot");
    
    // Apstrādā slaidu indeksa pārklāšanos
    if (n > slides.length) {slideIndex = 1}
    if (n < 1) {slideIndex = slides.length}
    
    // Paslēpj visus slaidus
    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    
    // Noņem active klasi visiem navigācijas punktiem
    for (let i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" activeDot", "");
    }
    
    // Parāda pašreizējo slaidu un aktivizē atbilstošo navigācijas punktu
    slides[slideIndex-1].style.display = "block";
    dots[slideIndex-1].className += " activeDot";
}

// Inicializē mobilās menu funkcionalitāti, kad lapa tiek ielādēta
document.addEventListener('DOMContentLoaded', function() {
    // Iegūt mobilo menu elementus, balstoties uz klasi, lai saglabātu tos kā mainīgos
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const mainNav = document.querySelector('.main-nav');
    const menuTrigger = document.querySelector('.menu-trigger');
    const menuContent = document.querySelector('.menu-content');

    // Pievienot noklikšķina notikuma listeneru, lai aktivizētu mobilā menu
    mobileMenuToggle.addEventListener('click', function() {
        mainNav.classList.toggle('active');
        // Pārslēgt starp ikonām
        const icon = mobileMenuToggle.querySelector('i');
        if (mainNav.classList.contains('active')) {
            icon.classList.remove('fa-bars');
            icon.classList.add('fa-times');
        } else {
            icon.classList.remove('fa-times');
            icon.classList.add('fa-bars');
        }
    });

    // Pievienot noklikšķina notikuma listeneru, lai aktivizētu kategoriju menu
    if (menuTrigger) {
        menuTrigger.addEventListener('click', function() {
            menuContent.classList.toggle('active');
            // Pārslēgt chevron ikonasvirzienu
            const chevron = menuTrigger.querySelector('.fa-chevron-down');
            chevron.classList.toggle('fa-chevron-up');
        });
    }
});