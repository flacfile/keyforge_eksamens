function openModal(modalId) {
    document.getElementById(modalId).classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    document.querySelectorAll('.modal').forEach(modal => {
        modal.classList.remove('active');
    });
    document.body.style.overflow = '';
}

function openImportModal() {
    openModal('importModal');
}

// Close modal when clicking outside
document.addEventListener('click', (e) => {
    if (e.target.classList.contains('modal')) {
        closeModal();
    }
});

// Close modal when clicking close button
document.querySelectorAll('.close-modal').forEach(button => {
    button.addEventListener('click', closeModal);
});

// Import form handling
document.getElementById('importForm').addEventListener('submit', function(e) {
    e.preventDefault();
    // Add your CSV import logic here
    const formData = new FormData(this);
    console.log('Importing keys...', Object.fromEntries(formData));
    closeModal();
});

// maybe use modal for confirm?
// function deleteProduct(id) {
//     confirm('Vai tiešām vēlaties dzēst šo produktu?');
// }