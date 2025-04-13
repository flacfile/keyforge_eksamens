<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KeyForge - Labākas cenas</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <script src="assets/js/script.js"></script>
</head>

<?php
require_once 'assets/functionality/db.php';
include 'includes/header.php';

$product_id = $_GET['id'] ?? null;

if (!$product_id) {
    header('Location: products.php');
    exit();
}

$stmt = $conn->prepare("SELECT * FROM products WHERE id = ? AND status = 'active'");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header('Location: products.php');
    exit();
}

$product = $result->fetch_assoc();
?> 

<body>
<div class="product-container">
    <!-- Product Main Section -->

    <div class="product-main">
        <div class="product-image-product">
            <img src="<?= htmlspecialchars($product['main_image_path']) ?>" alt="<?= htmlspecialchars($product['image_alt'] ?? $product['name']) ?>">
        </div>
        
        <div class="product-info">
            <h1 class="product-title"><?= htmlspecialchars($product['name']) ?></h1>
            <p class="product-price">€<?= number_format($product['price_eur'], 2) ?></p>
            <p class="product-description">
                <?= htmlspecialchars($product['description']) ?>
            </p>
            
            <form action="assets/functionality/add_to_cart.php" method="POST" class="add-to-cart-form">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn buy-now">
                    <i class="fas fa-shopping-cart"></i> Pievienot grozam
                </button>
            </form>

            <!-- <div class="product-actions">
                <button class="btn buy-now">Pirkt tagad</button>
            </div> -->
        </div>
    </div>

    <!-- System Requirements -->
    <div class="system-requirements">
        <h2>Minimālās sistēmas prasības</h2>
        <div class="requirements-grid">
            <div class="requirement">
                <h3>CPU</h3>
                <p><?= htmlspecialchars($product['cpu']) ?></p>
            </div>
            <div class="requirement">
                <h3>GPU</h3>
                <p><?= htmlspecialchars($product['gpu']) ?></p>
            </div>
            <div class="requirement">
                <h3>RAM</h3>
                <p><?= htmlspecialchars($product['ram']) ?></p>
            </div>
            <div class="requirement">
                <h3>Storage</h3>
                <p><?= htmlspecialchars($product['storage']) ?></p>
            </div>
        </div>
    </div>

    <!-- Reviews  -->
    <div class="reviews-section">
        <h2>Atsauksmes</h2>
        <div class="overall-rating">
            <div class="rating">4/5</div>
            <div class="stars">★★★★</div>
        </div>
        
        <div class="reviews-list">
            <div class="review">
                <div class="review-header">
                    <span class="reviewer-name">Jegors</span>
                    <span class="review-date">Februaris 15, 2025</span>
                    <div class="review-rating">★★★★★</div>
                </div>
                <p class="review-content">
                    SPELE BOMBA LOTI PATIK!!!
                </p>
            </div>
        </div>
    </div>
</div>

</body>

<?php include 'includes/footer.php'; ?> 