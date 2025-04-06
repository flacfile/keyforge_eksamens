document.addEventListener('DOMContentLoaded', function() {
    // Filter toggle
    const filterToggleBtn = document.querySelector('.filter-toggle-btn');
    const filters = document.querySelector('.filters');

    if (filterToggleBtn) {
        filterToggleBtn.addEventListener('click', function() {
            filters.classList.toggle('active');
            const icon = filterToggleBtn.querySelector('i');
            if (filters.classList.contains('active')) {
                icon.classList.remove('fa-filter');
                icon.classList.add('fa-times');
            } else {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-filter');
            }
        });
    }

    const productsGrid = document.querySelector('.products');
    const productCards = productsGrid.querySelectorAll('.product-card');
    const itemsPerPage = 6;
    let currentPage = 1;

    function showPage(page) {
        const start = (page - 1) * itemsPerPage;
        const end = start + itemsPerPage;

        productCards.forEach((card, index) => {
            card.style.display = (index >= start && index < end) ? '' : 'none';
        });
    }

    function createButton(content, onClick) {
        const btn = document.createElement('button');
        btn.className = 'btn-page';
        btn.innerHTML = content;
        btn.onclick = onClick;
        return btn;
    }

    function updatePagination() {
        const totalPages = Math.ceil(productCards.length / itemsPerPage);
        const pagination = document.querySelector('.pagination');
        pagination.innerHTML = '';

        // Previous button
        if (currentPage > 1) {
            pagination.appendChild(createButton('<i class="fas fa-chevron-left"></i>', () => {
                currentPage--;
                showPage(currentPage);
                updatePagination();
            }));
        }

        // Page numbers (always 3)
        const start = Math.max(1, currentPage - 1);
        const end = Math.min(totalPages, start + 2);
        const adjustedStart = end - start < 2 ? Math.max(1, end - 2) : start;

        for (let i = adjustedStart; i <= end; i++) {
            pagination.appendChild(createButton(i, () => {
                currentPage = i;
                showPage(currentPage);
                updatePagination();
            }));
        }

      // Next button
      if (currentPage < totalPages) {
            pagination.appendChild(createButton('<i class="fas fa-chevron-right"></i>', () => {
                currentPage++;
                showPage(currentPage);
                updatePagination();
            }));
        }
    }

    showPage(1);
    updatePagination();
}); 