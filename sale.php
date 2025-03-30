<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sale Page</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <script src="assets/js/script.js"></script>
</head>

<?php 
$pageTitle = "Sale";
include 'includes/header.php';
?> 

<body>
    <div class="sale-banner">
        <div class="ticker-wrapper">
            <div class="ticker-content">
                <!-- First set of messages -->
                <span>🔥 MEGA ATLAIDES - 70% ATLAIDES! 🔥</span>
                <span>⚡ TĀDAS CENAS TIKAI ŠODIEN ⚡</span>
                <span>🎮 SUPER SPELES PAR SUPER CENAM 🎮</span>
                <span>💰 EKSTRA 10% ATLAIDE AR KODU: KF2025 💰</span>
                <!-- Duplicate set for seamless loop -->

            </div>
        </div>
    </div>
    <div class="container">
        <!-- Filter Sidebar -->
        <aside class="filters">

            <h2>Filtri</h2>
            
            <div class="filter-section">
                <h3>Discount Range</h3>
                <div class="filter-options">
                    <label><input type="checkbox"> 70% or more</label>
                    <label><input type="checkbox"> 50% - 69%</label>
                    <label><input type="checkbox"> 30% - 49%</label>
                    <label><input type="checkbox"> Up to 29%</label>
                </div>
            </div>

            <div class="filter-section">
                <h3>Price After Discount</h3>
                <div class="filter-options">
                    <label><input type="radio" name="price"> Under $10</label>
                    <label><input type="radio" name="price"> $10 - $20</label>
                    <label><input type="radio" name="price"> $20 - $30</label>
                    <label><input type="radio" name="price"> Over $30</label>
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
            <div class="product-card">
                <div class="discount-badge">-50%</div>
                <img src="assets/images/product1.jpg" alt="gameimg" class="product-image">
                <h2 class="product-title">Red dead redemption 2</h2>
                <p class="product-description">
                    <img src="assets/images/steam.svg"/>
                </p>
                <div class="product-footer">
                    <div class="price-container">
                        <span class="original-price">$59.99</span>
                        <span class="product-price">$29.99</span>
                    </div>
                    <button class="buy-button">Buy Now</button>
                </div>
            </div>
            <div class="product-card">
                <div class="discount-badge">-50%</div>
                <img src="assets/images/product1.jpg" alt="gameimg" class="product-image">
                <h2 class="product-title">Red dead redemption 2</h2>
                <p class="product-description">
                    <img src="assets/images/steam.svg"/>
                </p>
                <div class="product-footer">
                    <div class="price-container">
                        <span class="original-price">$59.99</span>
                        <span class="product-price">$29.99</span>
                    </div>
                    <button class="buy-button">Buy Now</button>
                </div>
            </div>            <div class="product-card">
                <div class="discount-badge">-50%</div>
                <img src="assets/images/product1.jpg" alt="gameimg" class="product-image">
                <h2 class="product-title">Red dead redemption 2</h2>
                <p class="product-description">
                    <img src="assets/images/steam.svg"/>
                </p>
                <div class="product-footer">
                    <div class="price-container">
                        <span class="original-price">$59.99</span>
                        <span class="product-price">$29.99</span>
                    </div>
                    <button class="buy-button">Buy Now</button>
                </div>
            </div>            <div class="product-card">
                <div class="discount-badge">-50%</div>
                <img src="assets/images/product1.jpg" alt="gameimg" class="product-image">
                <h2 class="product-title">Red dead redemption 2</h2>
                <p class="product-description">
                    <img src="assets/images/steam.svg"/>
                </p>
                <div class="product-footer">
                    <div class="price-container">
                        <span class="original-price">$59.99</span>
                        <span class="product-price">$29.99</span>
                    </div>
                    <button class="buy-button">Buy Now</button>
                </div>
            </div>            <div class="product-card">
                <div class="discount-badge">-50%</div>
                <img src="assets/images/product1.jpg" alt="gameimg" class="product-image">
                <h2 class="product-title">Red dead redemption 2</h2>
                <p class="product-description">
                    <img src="assets/images/steam.svg"/>
                </p>
                <div class="product-footer">
                    <div class="price-container">
                        <span class="original-price">$59.99</span>
                        <span class="product-price">$29.99</span>
                    </div>
                    <button class="buy-button">Buy Now</button>
                </div>
            </div>            <div class="product-card">
                <div class="discount-badge">-50%</div>
                <img src="assets/images/product1.jpg" alt="gameimg" class="product-image">
                <h2 class="product-title">Red dead redemption 2</h2>
                <p class="product-description">
                    <img src="assets/images/steam.svg"/>
                </p>
                <div class="product-footer">
                    <div class="price-container">
                        <span class="original-price">$59.99</span>
                        <span class="product-price">$29.99</span>
                    </div>
                    <button class="buy-button">Buy Now</button>
                </div>
            </div>            <div class="product-card">
                <div class="discount-badge">-50%</div>
                <img src="assets/images/product1.jpg" alt="gameimg" class="product-image">
                <h2 class="product-title">Red dead redemption 2</h2>
                <p class="product-description">
                    <img src="assets/images/steam.svg"/>
                </p>
                <div class="product-footer">
                    <div class="price-container">
                        <span class="original-price">$59.99</span>
                        <span class="product-price">$29.99</span>
                    </div>
                    <button class="buy-button">Buy Now</button>
                </div>
            </div>            <div class="product-card">
                <div class="discount-badge">-50%</div>
                <img src="assets/images/product1.jpg" alt="gameimg" class="product-image">
                <h2 class="product-title">Red dead redemption 2</h2>
                <p class="product-description">
                    <img src="assets/images/steam.svg"/>
                </p>
                <div class="product-footer">
                    <div class="price-container">
                        <span class="original-price">$59.99</span>
                        <span class="product-price">$29.99</span>
                    </div>
                    <button class="buy-button">Buy Now</button>
                </div>
            </div>
        </main>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html> 