setTimeout(function() {
    const flashMessage = document.getElementById('flash-message');
    if (flashMessage) {
        flashMessage.style.opacity = '0';
        setTimeout(() => flashMessage.remove(), 300);
    }
}, 3000);
