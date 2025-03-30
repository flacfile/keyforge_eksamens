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
include 'includes/header.php';
?> 

<body>
    <div class="container">
        <!-- Filter Sidebar -->
        <aside class="filters">
            <h2>Filtri</h2>
            
            <div class="filter-section">
                <h3>Žanri</h3>
                <div class="filter-options">
                    <label><input type="checkbox"> SMTH</label>
                    <label><input type="checkbox"> SMTH</label>
                    <label><input type="checkbox"> SMTH</label>
                    <label><input type="checkbox"> SMTH</label>
                </div>
            </div>

            <div class="filter-section">
                <h3>Cena</h3>
                <div class="filter-options">
                    <label><input type="radio" name="price"> Under $25</label>
                    <label><input type="radio" name="price"> $25 - $50</label>
                    <label><input type="radio" name="price"> $50 - $100</label>
                    <label><input type="radio" name="price"> Over $100</label>
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
        <img src="assets/images/product1.jpg" alt="gameimg" class="product-image">
        <h2 class="product-title">Red Dead Redemption 2</h2>
        <p class="product-description">
            <!-- <i class="fa-brands fa-steam"></i> -->
            <img src="assets/images/steam.svg"/>
            <img src="assets/images/origin.svg"/>
            <img src="assets/images/ubisoft.svg"/>
        </p>
        <div class="product-footer">
            <span class="product-price">$19.99</span>
            <button class="buy-button">Buy Now</button>
        </div>
      </div>
      <div class="product-card">
        <img src="assets/images/product1.jpg" alt="gameimg" class="product-image">
        <h2 class="product-title">Red Dead Redemption 2</h2>
        <p class="product-description">
            <!-- <i class="fa-brands fa-steam"></i> -->
            <img src="assets/images/steam.svg"/>
            <img src="assets/images/origin.svg"/>
            <img src="assets/images/ubisoft.svg"/>
        </p>
        <div class="product-footer">
            <span class="product-price">$19.99</span>
            <button class="buy-button">Buy Now</button>
        </div>
      </div>
      <div class="product-card">
        <img src="assets/images/product1.jpg" alt="gameimg" class="product-image">
        <h2 class="product-title">Red Dead Redemption 2</h2>
        <p class="product-description">
            <!-- <i class="fa-brands fa-steam"></i> -->
            <img src="assets/images/steam.svg"/>
            <img src="assets/images/origin.svg"/>
            <img src="assets/images/ubisoft.svg"/>
        </p>
        <div class="product-footer">
            <span class="product-price">$19.99</span>
            <button class="buy-button">Buy Now</button>
        </div>
      </div>
      <div class="product-card">
        <img src="assets/images/product1.jpg" alt="gameimg" class="product-image">
        <h2 class="product-title">Red Dead Redemption 2</h2>
        <p class="product-description">
            <!-- <i class="fa-brands fa-steam"></i> -->
            <img src="assets/images/steam.svg"/>
            <img src="assets/images/origin.svg"/>
            <img src="assets/images/ubisoft.svg"/>
        </p>
        <div class="product-footer">
            <span class="product-price">$19.99</span>
            <button class="buy-button">Buy Now</button>
        </div>
      </div>
      <div class="product-card">
        <img src="assets/images/product1.jpg" alt="gameimg" class="product-image">
        <h2 class="product-title">Red Dead Redemption 2</h2>
        <p class="product-description">
            <!-- <i class="fa-brands fa-steam"></i> -->
            <img src="assets/images/steam.svg"/>
            <img src="assets/images/origin.svg"/>
            <img src="assets/images/ubisoft.svg"/>
        </p>
        <div class="product-footer">
            <span class="product-price">$19.99</span>
            <button class="buy-button">Buy Now</button>
        </div>
      </div>
      <div class="product-card">
        <img src="assets/images/product1.jpg" alt="gameimg" class="product-image">
        <h2 class="product-title">Red Dead Redemption 2</h2>
        <p class="product-description">
            <!-- <i class="fa-brands fa-steam"></i> -->
            <img src="assets/images/steam.svg"/>
            <img src="assets/images/origin.svg"/>
            <img src="assets/images/ubisoft.svg"/>
        </p>
        <div class="product-footer">
            <span class="product-price">$19.99</span>
            <button class="buy-button">Buy Now</button>
        </div>
      </div>
      <div class="product-card">
        <img src="assets/images/product1.jpg" alt="gameimg" class="product-image">
        <h2 class="product-title">Red Dead Redemption 2</h2>
        <p class="product-description">
            <!-- <i class="fa-brands fa-steam"></i> -->
            <img src="assets/images/steam.svg"/>
            <img src="assets/images/origin.svg"/>
            <img src="assets/images/ubisoft.svg"/>
        </p>
        <div class="product-footer">
            <span class="product-price">$19.99</span>
            <button class="buy-button">Buy Now</button>
        </div>
      </div>
      <div class="product-card">
        <img src="assets/images/product1.jpg" alt="gameimg" class="product-image">
        <h2 class="product-title">Red Dead Redemption 2</h2>
        <p class="product-description">
            <!-- <i class="fa-brands fa-steam"></i> -->
            <img src="assets/images/steam.svg"/>
            <img src="assets/images/origin.svg"/>
            <img src="assets/images/ubisoft.svg"/>
        </p>
        <div class="product-footer">
            <span class="product-price">$19.99</span>
            <button class="buy-button">Buy Now</button>
        </div>
      </div>
      <div class="product-card">
        <img src="assets/images/product1.jpg" alt="gameimg" class="product-image">
        <h2 class="product-title">Red Dead Redemption 2</h2>
        <p class="product-description">
            <!-- <i class="fa-brands fa-steam"></i> -->
            <img src="assets/images/steam.svg"/>
            <img src="assets/images/origin.svg"/>
            <img src="assets/images/ubisoft.svg"/>
        </p>
        <div class="product-footer">
            <span class="product-price">$19.99</span>
            <button class="buy-button">Buy Now</button>
        </div>
      </div>
      <div class="product-card">
        <img src="assets/images/product1.jpg" alt="gameimg" class="product-image">
        <h2 class="product-title">Red Dead Redemption 2</h2>
        <p class="product-description">
            <!-- <i class="fa-brands fa-steam"></i> -->
            <img src="assets/images/steam.svg"/>
            <img src="assets/images/origin.svg"/>
            <img src="assets/images/ubisoft.svg"/>
        </p>
        <div class="product-footer">
            <span class="product-price">$19.99</span>
            <button class="buy-button">Buy Now</button>
        </div>
      </div>
      <div class="product-card">
        <img src="assets/images/product1.jpg" alt="gameimg" class="product-image">
        <h2 class="product-title">Red Dead Redemption 2</h2>
        <p class="product-description">
            <!-- <i class="fa-brands fa-steam"></i> -->
            <img src="assets/images/steam.svg"/>
            <img src="assets/images/origin.svg"/>
            <img src="assets/images/ubisoft.svg"/>
        </p>
        <div class="product-footer">
            <span class="product-price">$19.99</span>
            <button class="buy-button">Buy Now</button>
        </div>
      </div>
        </main>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>

