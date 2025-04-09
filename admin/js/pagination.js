document.addEventListener('DOMContentLoaded', function() {
    const usersTable = document.querySelector('.users-table');
    const productsTable = document.querySelector('.products-table');
    
    let rows, rowsPerPage;
    
    if (usersTable) {
        rows = usersTable.querySelectorAll('tbody tr');
        rowsPerPage = 10;
    } else if (productsTable) {
        rows = productsTable.querySelectorAll('tbody tr');
        rowsPerPage = 8;
    } else {
        return;
    }

    // Get current page from URL or default to 1
    const urlParams = new URLSearchParams(window.location.search);
    let currentPage = parseInt(urlParams.get('page')) || 1;

    function showPage(page) {
        rows.forEach((row, index) => {
            row.style.display = (index >= (page - 1) * rowsPerPage && index < page * rowsPerPage) ? '' : 'none';
        });
        
        // Update URL without reloading the page
        const newUrl = new URL(window.location.href);
        newUrl.searchParams.set('page', page);
        window.history.pushState({}, '', newUrl);
    }

    function createButton(content, onClick) {
        const btn = document.createElement('button');
        btn.className = 'btn-page';
        btn.innerHTML = content;
        btn.onclick = onClick;
        return btn;
    }

    function updatePagination() {
        const totalPages = Math.ceil(rows.length / rowsPerPage);
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

    // Show initial page
    showPage(currentPage);
    updatePagination();
}); 