<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KeyForge - Sākumlapa</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <script src="assets/js/script.js"></script>
</head>

<?php
include 'includes/header.php';
require_once 'assets/functionality/db.php';

$topGamesQuery = "SELECT * FROM products WHERE status = 'active' AND number_of_keys > 0 ORDER BY price_eur DESC LIMIT 5";
$topGamesResult = $conn->query($topGamesQuery);

$bestsellersQuery = "SELECT * FROM products WHERE status = 'active' AND number_of_keys > 0 ORDER BY created_at DESC LIMIT 5";
$bestsellersResult = $conn->query($bestsellersQuery);


$cheapGamesQuery = "SELECT * FROM products WHERE status = 'active' AND number_of_keys > 0 AND price_eur <= 10 ORDER BY price_eur ASC LIMIT 5";
$cheapGamesResult = $conn->query($cheapGamesQuery);


?>

<div class="slideshow-container">
    <div class="slide fade">
        <img src="assets/images/banner_1.jpg" alt="img1">
    </div>
    <div class="slide fade">
        <img src="assets/images/banner_2.jpg" alt="img2">
    </div>
    <div class="slide fade">
        <img src="assets/images/banner_3.jpg" alt="img3">
    </div>
    
    <!-- Navigation arrows -->
    <a class="prev" onclick="changeSlide(-1)">&#10094;</a>
    <a class="next" onclick="changeSlide(1)">&#10095;</a>
    
    <div class="dots">
        <span class="dot" onclick="currentSlide(1)"></span>
        <span class="dot" onclick="currentSlide(2)"></span>
        <span class="dot" onclick="currentSlide(3)"></span>
    </div>
</div>

<!-- Top Games Section -->
<div class="product-container-top">
    <div class="text-heading-for-products">
        <p class="heading-text">TOP SPĒLES</p>
        <a href="products.php" class="see-more-btn">Skatīt Vairāk <i class="fas fa-arrow-right"></i></a>
    </div>
    <div class="all-product-cards">
        <?php while ($product = $topGamesResult->fetch_assoc()): ?>
            <div class="product-card">
                <div class="product-image">
                    <img src="<?= htmlspecialchars($product['main_image_path']) ?>" 
                         alt="<?= htmlspecialchars($product['image_alt'] ?? $product['name']) ?>">
                </div>
                <div class="product-content">
                    <h2 class="product-title"><?= htmlspecialchars($product['name']) ?></h2>
                    <p class="product-description">
                        <?php if ($product['platform'] === 'Steam'): ?>
                            <img src="assets/images/steam.svg" alt="Steam"/>
                        <?php endif; ?>
                        <?php if ($product['platform'] === 'Origin'): ?>
                            <img src="assets/images/origin.svg" alt="Origin"/>
                        <?php endif; ?>
                        <?php if ($product['platform'] === 'Ubisoft Connect'): ?>
                            <img src="assets/images/ubisoft.svg" alt="Ubisoft Connect"/>
                        <?php endif; ?>
                    </p>
                    <div class="product-footer">
                        <span class="product-price">
                                €<?= number_format($product['price_eur'], 2) ?>
                        </span>
                        <a href="product.php?id=<?= $product['id'] ?>" class="buy-button">Apskatīt</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<!-- Bestsellers Section -->
<div class="product-container-top">
    <div class="text-heading-for-products">
        <p class="heading-text">BESTSELLERI</p>
        <a href="products.php" class="see-more-btn">Skatīt Vairāk <i class="fas fa-arrow-right"></i></a>
    </div>
    <div class="all-product-cards">
        <?php while ($product = $bestsellersResult->fetch_assoc()): ?>
            <div class="product-card">
                <div class="product-image">
                    <img src="<?= htmlspecialchars($product['main_image_path']) ?>" 
                         alt="<?= htmlspecialchars($product['image_alt'] ?? $product['name']) ?>">
                </div>
                <div class="product-content">
                    <h2 class="product-title"><?= htmlspecialchars($product['name']) ?></h2>
                    <p class="product-description">
                        <?php if ($product['platform'] === 'Steam'): ?>
                            <img src="assets/images/steam.svg" alt="Steam"/>
                        <?php endif; ?>
                        <?php if ($product['platform'] === 'Origin'): ?>
                            <img src="assets/images/origin.svg" alt="Origin"/>
                        <?php endif; ?>
                        <?php if ($product['platform'] === 'Ubisoft Connect'): ?>
                            <img src="assets/images/ubisoft.svg" alt="Ubisoft Connect"/>
                        <?php endif; ?>
                    </p>
                    <div class="product-footer">
                        <span class="product-price">
                                €<?= number_format($product['price_eur'], 2) ?>
                        </span>
                        <a href="product.php?id=<?= $product['id'] ?>" class="buy-button">Apskatīt</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<!-- Games Under 10 EUR Section -->
<div class="product-container-top">
    <div class="text-heading-for-products">
        <p class="heading-text">SPĒLES LĪDZ 10 EUR</p>
        <a href="products.php" class="see-more-btn">Skatīt Vairāk <i class="fas fa-arrow-right"></i></a>
    </div>
    <div class="all-product-cards">
        <?php while ($product = $cheapGamesResult->fetch_assoc()): ?>
            <div class="product-card">
                <div class="product-image">
                    <img src="<?= htmlspecialchars($product['main_image_path']) ?>" 
                         alt="<?= htmlspecialchars($product['image_alt'] ?? $product['name']) ?>">
                </div>
                <div class="product-content">
                    <h2 class="product-title"><?= htmlspecialchars($product['name']) ?></h2>
                    <p class="product-description">
                        <?php if ($product['platform'] === 'Steam'): ?>
                            <img src="assets/images/steam.svg" alt="Steam"/>
                        <?php endif; ?>
                        <?php if ($product['platform'] === 'Origin'): ?>
                            <img src="assets/images/origin.svg" alt="Origin"/>
                        <?php endif; ?>
                        <?php if ($product['platform'] === 'Ubisoft Connect'): ?>
                            <img src="assets/images/ubisoft.svg" alt="Ubisoft Connect"/>
                        <?php endif; ?>
                    </p>
                    <div class="product-footer">
                        <span class="product-price">
                            €<?= number_format($product['price_eur'], 2) ?>
                        </span>
                        <a href="product.php?id=<?= $product['id'] ?>" class="buy-button">Apskatīt</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
    </div>

    <?php include 'includes/footer.php'; ?>

</body>
</html>