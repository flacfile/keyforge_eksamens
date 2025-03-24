<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: /eksamens/keyforge_eksamens/login.php');
    exit();
}

$page_title = 'Dashboard';
$current_page = 'dashboard';
require_once 'includes/header.php';
?>
            <div class="content-body">
                <div class="dashboard-stats">
                    <div class="stat-card">
                        <i class="fas fa-gamepad"></i>
                        <div class="stat-info">
                            <h3>Kopējie produkti</h3>
                            <p>123</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <i class="fas fa-key"></i>
                        <div class="stat-info">
                            <h3>Pieejamās atslēgas</h3>
                            <p>123</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <i class="fas fa-shopping-cart"></i>
                        <div class="stat-info">
                            <h3>Pasūtījumi</h3>
                            <p>123</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <i class="fas fa-users"></i>
                        <div class="stat-info">
                            <h3>Lietotāji</h3>
                            <p>123</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="../assets/js/admin/dashboard.js"></script>
</body>
</html>

<?php require_once 'includes/footer.php'; ?> 