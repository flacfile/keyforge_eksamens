<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <script src="assets/js/script.js"></script>

</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="slideshow-container">
        <div class="slide fade">
            <img src="assets/images/image-1.jpg" alt="img1">
        </div>
        <div class="slide fade">
            <img src="assets/images/image-2.jpg" alt="img2">
        </div>
        <div class="slide fade">
            <img src="assets/images/image-3.jpg" alt="img3">
        </div>
        
        <!-- Navigation arrows -->
        <a class="prev" onclick="changeSlide(-1)">&#10094;</a>
        <a class="next" onclick="changeSlide(1)">&#10095;</a>
        
        <!-- Dot indicators -->
        <div class="dots">
            <span class="dot" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
            <span class="dot" onclick="currentSlide(3)"></span>
        </div>
    </div>

    <div class="product-container-top">
        <div class="text-heading-for-products">
            <p class="heading-text">TOP SPĒLES</p>
            <a href="products.php" class="see-more-btn">See More <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="all-product-cards">
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
        </div>
    </div>

    <div class="product-container-top">
        <div class="text-heading-for-products">
            <p class="heading-text">BESTSELLERI</p>
            <a href="products.php" class="see-more-btn">See More <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>
    
    <div class="all-product-cards">
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
    </div>
    </div>
      
    <div class="product-container-top">
        <div class="text-heading-for-products">
            <p class="heading-text">SPĒLES LĪDZ 10 EUR</p>
            <a href="products.php" class="see-more-btn">See More <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>
    
    <div class="all-product-cards">
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
    </div>
    </div>

    <?php include 'includes/footer.php'; ?>

</body>
</html>