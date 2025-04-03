document.addEventListener('DOMContentLoaded', function() {    
    window.showAddUserModal = function() {
        document.getElementById('addUserModal').style.display = 'flex';
    }

    window.closeAddUserModal = function() {
        document.getElementById('addUserModal').style.display = 'none';
    }

    window.editUser = function(userId) {
        window.location.href = `functionality/update_user_info.php?id=${userId}`;
    }

    window.closeEditUserModal = function() {
        document.getElementById('editUserModal').style.display = 'none';
    }
});