function showAddProductModal() {
    document.getElementById('addProductModal').classList.add('active');
}

function closeAddProductModal() {
    document.getElementById('addProductModal').classList.remove('active');
}

document.addEventListener('DOMContentLoaded', function() {
    window.showAddProductModal = function() {
        document.getElementById('addProductModal').style.display = 'block';
    }

    window.closeAddProductModal = function() {
        document.getElementById('addProductModal').style.display = 'none';
    }

    window.editProduct = function(productId) {
        window.location.href = `functionality/update_product_info.php?id=${productId}`;
    }
});

// keys functionality should be added