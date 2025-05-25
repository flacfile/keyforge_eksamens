<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../../login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?></title>
    <link rel="stylesheet" href="../assets/css/variables.css">
    <link rel="stylesheet" href="../assets/css/admin/dashboard.css">
    <link rel="stylesheet" href="../assets/css/admin/products.css">
    <link rel="stylesheet" href="../assets/css/admin/users.css">
    <link rel="stylesheet" href="../assets/css/admin/order_details.css">
    <link rel="stylesheet" href="../assets/css/admin/alerts.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2><a href="../index.php" class="company-name">KeyForge</a></h2>
            </div>
            <nav class="sidebar-nav">
                <a href="dashboard.php" class="nav-item <?= $current_page === 'dashboard' ? 'active' : '' ?>">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
                <a href="products.php" class="nav-item <?= $current_page === 'products' ? 'active' : '' ?>">
                    <i class="fas fa-gamepad"></i>
                    <span>Produkti</span>
                </a>
                <a href="orders.php" class="nav-item <?= $current_page === 'orders' ? 'active' : '' ?>">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Pasūtījumi</span>
                </a>
                <a href="users.php" class="nav-item <?= $current_page === 'users' ? 'active' : '' ?>">
                    <i class="fas fa-users"></i>
                    <span>Lietotāji</span>
                </a>
                <!-- <a href="settings.php" class="nav-item <?= $current_page === 'settings' ? 'active' : '' ?>">
                    <i class="fas fa-cog"></i>
                    <span>Iestatījumi</span>
                </a> -->
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <?php if (isset($_SESSION['flash_message'])): ?>
                <div class="alert alert-<?= $_SESSION['flash_type'] ?? 'info' ?>" id="flash-message">
                    <?= htmlspecialchars($_SESSION['flash_message']) ?>
                </div>
                <script src="js/header.js"></script>
                <?php 
                unset($_SESSION['flash_message']);
                unset($_SESSION['flash_type']);
            endif; ?>

            <header class="content-header">
                <div class="header-left">
                    <h1><?= $page_title ?></h1>
                </div>
                <div class="header-right">
                    <div class="admin-profile">
                        <span><?= $_SESSION['user_name'] ?></span>
                        <a href="../assets/functionality/logout.php" class="logout-btn" title="Iziet">
                            <i class="fas fa-sign-out-alt"></i>
                        </a>
                    </div>
                </div>
            </header>