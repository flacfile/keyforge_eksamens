<?php
session_start();
?>
<header>
    <div class="header-bg">
    <div class="header-top-part">
        <div class="header-mobile-row">
            <a href="index.php" class="company-name">KeyForge</a>
            <div class="mobile-menu-toggle">
                <i class="fas fa-bars"></i>
            </div>
        </div>
        
        <div class="header-content">
        <a href="index.php" class="company-name-dekstop">KeyForge</a>

        <div class="header-actions">
                <div class="icons-header">
                    <div class="icons-item">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                        <?php if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])): ?>
                            <span>|</span>
                            <div class="icons-item">
                                <a href="<?php echo (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') ? 'admin/dashboard.php' : 'cabinet.php'; ?>">
                                    <i class="fas fa-user"></i>
                                </a>
                            </div>
                            <div class="icons-item">
                                <a href="assets/functionality/logout.php">
                                    <i class="fas fa-sign-out-alt"></i>
                                </a>
                            </div>
                        <?php else: ?>
                            <a href="/eksamens/keyforge_eksamens/login.php">Log in</a>
                            <span>|</span>
                            <a href="register.php">Register</a>
                        <?php endif; ?>
                </div>
            </div>
            <div class="search-container">
                <i class="fas fa-search search-icon"></i>
                <input type="text" placeholder="Meklēt">
            </div>
        </div>
    </div>
    </div>
    <nav class="main-nav">
        <div class="nav-container">
            <a href="index.php" class="nav-link"><i class="fas fa-home"></i> <span>Sākumlapa</span></a>
            <div class="menu-container">
                <a href="javascript:void(0)" class="menu-trigger nav-link">
                    <i class="fas fa-gamepad"></i> <span>Kategorijas</span>
                    <i class="fas fa-chevron-down"></i>
                </a>
                <div class="menu-content">
                    <div class="menu-section">
                        <h3><i class="fas fa-desktop"></i> Platformas</h3>
                        <a href="">Steam</a>
                        <a href="">Origin</a>
                        <a href="">Ubisoft Connect</a>
                        <a href="">Epic Games</a>
                        <a href="">Battle.net</a>
                        <a href="">EA Play</a>
                        <a href="">Xbox</a>
                        <a href="">PlayStation</a>
                    </div>
                    <div class="menu-section">
                        <h3><i class="fas fa-tags"></i> Žanri</h3>
                        <a href="">Sporta spēles</a>
                        <a href="">Stratēģijas</a>
                        <a href="">RPG</a>
                        <a href="">Simulatori</a>
                        <a href="">Šaušanas spēles</a>
                    </div>
                </div>
            </div>
            <a href="products.php" class="nav-link"><i class="fa-solid fa-shop"></i> <span>Produkti</span></a>
            <!-- <a href="sale.php" class="nav-link"><i class="fas fa-percentage"></i> <span>Atlaides</span></a> -->
            <a href="faq.php" class="nav-link"><i class="fas fa-question-circle"></i> <span>BUJ</span></a>
        </div>
    </nav>
   
    <main> 