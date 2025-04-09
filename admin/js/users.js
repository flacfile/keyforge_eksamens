document.addEventListener('DOMContentLoaded', function() {    
    const currentPage = new URLSearchParams(window.location.search).get('page') || '1';

    window.showAddUserModal = function() {
        document.getElementById('addUserModal').style.display = 'block';
    }

    window.closeAddUserModal = function() {
        document.getElementById('addUserModal').style.display = 'none';
    }

    window.editUser = function(userId) {
        const currentPage = new URLSearchParams(window.location.search).get('page') || '1';
        window.location.href = `functionality/update_user_info.php?id=${userId}&page=${currentPage}`;
    }

    window.closeEditUserModal = function() {
        window.location.href = `users.php?page=${currentPage}`;
    }
});

