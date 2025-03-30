document.addEventListener('DOMContentLoaded', function() {
    const flashMessage = document.getElementById('flash-message');
    if (flashMessage) {
        flashMessage.classList.add('flash-message-fixed');
        flashMessage.style.opacity = '0';
        
        // Trigger fade in
        setTimeout(() => {
            flashMessage.style.opacity = '1';
            flashMessage.style.transition = 'opacity 0.3s ease-in-out';
        }, 100);
        
        // Fade out after 3 seconds
        setTimeout(function() {
            flashMessage.style.opacity = '0';
            setTimeout(() => {
                setTimeout(() => flashMessage.remove(), 300);
            }, 300);
        }, 3000);
    }
});