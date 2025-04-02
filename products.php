<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Page</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <script src="assets/js/script.js"></script>
</head>

<?php 
$pageTitle = "Products";
require_once 'assets/functionality/db.php';
include 'includes/header.php';

// Fetch products from database
$query = "SELECT * FROM products WHERE status = 'active' ORDER BY created_at DESC";
$result = $conn->query($query);
?> 

<body>
    <div class="container">
        <!-- Filter Sidebar -->
        <aside class="filters">
            <h2>Filtri</h2>
            
            <div class="filter-section">
                <h3>Žanri</h3>
                <div class="filter-options">
                    <?php
                    $genres_query = "SELECT DISTINCT genre FROM products ORDER BY genre";
                    $genres_result = $conn->query($genres_query);
                    while ($genre = $genres_result->fetch_assoc()) {
                        echo '<label><input type="checkbox" name="genre" value="' . htmlspecialchars($genre['genre']) . '"> ' . htmlspecialchars($genre['genre']) . '</label>';
                    }
                    ?>
                </div>
            </div>

            <div class="filter-section">
                <h3>Cena</h3>
                <div class="filter-options">
                    <label><input type="radio" name="price" value="0-25"> Under $25</label>
                    <label><input type="radio" name="price" value="25-50"> $25 - $50</label>
                    <label><input type="radio" name="price" value="50-100"> $50 - $100</label>
                    <label><input type="radio" name="price" value="100+"> Over $100</label>
                </div>
            </div>

            <div class="filter-section">
                <h3>Reitings</h3>
                <div class="filter-options">
                    <label><input type="checkbox"> 5</label>
                    <label><input type="checkbox"> 4</label>
                    <label><input type="checkbox"> 3</label>
                    <label><input type="checkbox"> 2</label>
                    <label><input type="checkbox"> 1</label>
                </div>
            </div>
        </aside>


        <!-- Products Grid -->
        <main class="products">
            <?php while ($product = $result->fetch_assoc()): ?>
                <div class="product-card">
                    <img src="<?= htmlspecialchars($product['main_image_path']) ?>" 
                         alt="<?= htmlspecialchars($product['image_alt'] ?? $product['name']) ?>" 
                         class="product-image">
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
                            <?php if ($product['on_sale']): ?>
                                <span class="original-price">$<?= number_format($product['price_usd'], 2) ?></span>
                                <span class="sale-price">$<?= number_format($product['on_sale_price_eur'], 2) ?></span>
                            <?php else: ?>
                                $<?= number_format($product['price_usd'], 2) ?>
                            <?php endif; ?>
                        </span>
                        <button class="buy-button">Buy Now</button>
                    </div>
                </div>
            <?php endwhile; ?>
        </main>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>

