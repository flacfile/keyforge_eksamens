<?php
error_reporting(E_ALL & ~E_NOTICE);  //ignore notifications fron php
session_start();
require_once 'assets/functionality/db.php';

// Fetch ENUM values from db
$platforms_query = "SHOW COLUMNS FROM products WHERE Field = 'platform'";
$genres_query = "SHOW COLUMNS FROM products WHERE Field = 'genre'";

$platforms_result = $conn->query($platforms_query);
$genres_result = $conn->query($genres_query);

$platforms = [];
$genres = [];

if ($platforms_result && $platforms_row = $platforms_result->fetch_assoc()) {
    preg_match("/^enum\(\'(.*)\'\)$/", $platforms_row['Type'], $matches);
    $platforms = explode("','", $matches[1]);
}

if ($genres_result && $genres_row = $genres_result->fetch_assoc()) {
    preg_match("/^enum\(\'(.*)\'\)$/", $genres_row['Type'], $matches);
    $genres = explode("','", $matches[1]);
}
?>
    <div class="header-bg">
    <div class="header-top-part">
        <div class="header-mobile-row">
            <a href="index.php" class="company-name">KeyForge</a>
            
        <div class="header-actions">
                <div class="icons-header">
                    <div class="icons-item">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <a href="cart.php"><i class="fas fa-shopping-cart"></i></a>
                        <?php else: ?>
                            <a href="login.php?redirect=cart.php"><i class="fas fa-shopping-cart"></i></a>
                        <?php endif; ?>
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
                        <a href="login.php">Pieteikties</a>
                        <span>|</span>
                        <a href="register.php">Reģistrēties</a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="mobile-menu-toggle">
                <i class="fas fa-bars"></i>
            </div>
        </div>
        
        <div class="search-container-mobile">
            <form action="products.php" method="GET" class="search-form">
                <input type="text" name="search" placeholder="Meklēt" 
                    value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                <button type="submit" class="search-button">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </div>

        <div class="header-content">
        <a href="index.php" class="company-name-dekstop">KeyForge</a>

    <div class="header-actions">
            <div class="icons-header">
                <div class="icons-item">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="cart.php"><i class="fas fa-shopping-cart"></i></a>
                    <?php else: ?>
                        <a href="login.php?redirect=cart.php"><i class="fas fa-shopping-cart"></i></a>
                    <?php endif; ?>
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
                    <a href="login.php">Pieteikties</a>
                    <span>|</span>
                    <a href="register.php">Reģistrēties</a>
                <?php endif; ?>
            </div>
        </div>
        <div class="search-container">
            <form action="products.php" method="GET" class="search-form">
                <input type="text" name="search" placeholder="Meklēt"
                    value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                <button type="submit" class="search-button">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </div>
</div>
</div>
<nav class="main-nav active">
    <div class="nav-container">
        <a href="index.php" class="nav-link"><i class="fas fa-home"></i> <span>Sākumlapa</span></a>
        <div class="menu-container">
            <a href="#" class="menu-trigger nav-link">
                <i class="fas fa-gamepad"></i> <span>Kategorijas</span>
                <i class="fas fa-chevron-down"></i>
            </a>
            <div class="menu-content">
                <div class="menu-section">
                    <h3><i class="fas fa-desktop"></i> Platformas</h3>
                    <?php foreach ($platforms as $platform): ?>
                        <a href="products.php?platform=<?= urlencode($platform) ?>"><?= htmlspecialchars($platform) ?></a>
                    <?php endforeach; ?>
                </div>
                <div class="menu-section">
                    <h3><i class="fas fa-tags"></i><br> Žanri</h3>
                    <?php foreach ($genres as $genre): ?>
                        <a href="products.php?genre=<?= urlencode($genre) ?>"><?= htmlspecialchars($genre) ?></a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <a href="products.php" class="nav-link"><i class="fa-solid fa-shop"></i> <span>Produkti</span></a>
        <!-- <a href="sale.php" class="nav-link"><i class="fas fa-percentage"></i> <span>Atlaides</span></a> -->
        <a href="faq.php" class="nav-link"><i class="fas fa-question-circle"></i> <span>BUJ</span></a>
    </div>
</nav>
   
<main> 