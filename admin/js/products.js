document.addEventListener('DOMContentLoaded', function() {
    // Get current page from URL/default to 1
    const currentPage = new URLSearchParams(window.location.search).get('page') || '1';

    window.showAddProductModal = function() {
        document.getElementById('addProductModal').style.display = 'block';
    }

    window.closeAddProductModal = function() {
        document.getElementById('addProductModal').style.display = 'none';
    }

    window.editProduct = function(productId) {
        const page = new URLSearchParams(window.location.search).get('page') || '1';
        window.location.href = `functionality/update_product_info.php?id=${productId}&page=${page}`;
    }

    window.closeEditProductModal = function() {
        document.getElementById('editProductModal').style.display = 'none';
        const page = new URLSearchParams(window.location.search).get('page') || '1';
        window.location.href = `products.php?page=${page}`;
    }

    window.manageKeys = function(productId) {
        const page = new URLSearchParams(window.location.search).get('page') || '1';
        window.location.href = `products.php?product_id=${productId}&page=${page}`;
    };

    window.closeKeyModal = function() {
        const page = new URLSearchParams(window.location.search).get('page') || '1';
        window.location.href = `products.php?page=${page}`;
    };
});
