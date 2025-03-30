document.addEventListener('DOMContentLoaded', function() {    
    window.editUser = function(userId) {
        window.location.href = `functionality/update_user_info.php?id=${userId}`;
    }
});