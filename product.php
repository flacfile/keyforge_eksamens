<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <script src="assets/js/script.js"></script>

</head>

<?php 
$pageTitle = "Product";
include 'includes/header.php';
?> 

<body>
<div class="product-container">
    <!-- Product Main Section -->

    <div class="product-main">
        <div class="product-image">
            <img src="assets/images/product1.jpg" alt="Game">
        </div>
        
        <div class="product-info">
            <h1 class="product-title">Red dead redemption 2</h1>
            <p class="product-description">
                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Necessitatibus voluptates culpa nisi ipsum eligendi ab officia ducimus quidem laboriosam accusamus. Itaque delectus aperiam asperiores quaerat! Quod aspernatur, quam aliquid architecto accusantium commodi sequi quasi nobis, quisquam velit soluta? Ab illum unde mollitia earum omnis ipsam, velit dolorem facere ea sunt!
            </p>
            
            <div class="product-actions">
                <div class="price">$59.99</div>
                <button class="btn add-to-cart">Add to Cart</button>
                <button class="btn buy-now">Buy Now</button>
            </div>
        </div>
    </div>

    <!-- System Requirements -->
    <div class="system-requirements">
        <h2>Minimālās sistēmas prasības</h2>
        <div class="requirements-grid">
            <div class="requirement">
                <h3>OS</h3>
                <p>Windows 10 64-bit</p>
            </div>
            <div class="requirement">
                <h3>Processors</h3>
                <p>Intel Core i5</p>
            </div>
            <div class="requirement">
                <h3>RAM</h3>
                <p>8 GB RAM</p>
            </div>
            <div class="requirement">
                <h3>GPU</h3>
                <p>NVIDIA GTX 1060</p>
            </div>
            <div class="requirement">
                <h3>Storage</h3>
                <p>50 GB</p>
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