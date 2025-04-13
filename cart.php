<?php
require_once 'assets/functionality/db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$cart_items = $_SESSION['cart'] ?? [];
$products = [];
$total_price = 0;

if (!empty($cart_items)) {
    //cart_items is an array of arrays with product_id and quantity
    $product_ids = [];
    foreach ($cart_items as $item) {
        if (is_array($item) && isset($item['product_id'])) {
            $product_ids[] = $item['product_id'];
        }
    }

    // If there are product IDs, get the products from the database
    if (count($product_ids) > 0) {
        $placeholders = str_repeat('?,', count($product_ids) - 1) . '?';
        $stmt = $conn->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
        $stmt->bind_param(str_repeat('i', count($product_ids)), ...$product_ids);
        $stmt->execute();
        $result = $stmt->get_result();
        
        while ($product = $result->fetch_assoc()) {
            $products[$product['id']] = $product;
        }

        // Price calculation
        foreach ($cart_items as $item) {
            if (is_array($item) && isset($item['product_id']) && isset($products[$item['product_id']])) {
                $total_price += $products[$item['product_id']]['price_eur'] * $item['quantity'];
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grozs</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/pages/faq.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <script src="assets/js/script.js"></script>
</head>
<?php
require_once 'includes/header.php';
?>

<div class="container-cart">
    <h1>Jūsu grozs</h1>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="error-message">
            <?php 
                echo $_SESSION['error'];
                unset($_SESSION['error']);
            ?>
        </div>
    <?php endif; ?>

    <?php if (empty($cart_items)): ?>
        <div class="empty-cart">
            <i class="fas fa-shopping-cart"></i>
            <p>Jūsu grozs ir tukšs</p>
            <a href="products.php" class="btn btn-primary">Apskatīt produktus</a>
        </div>
    <?php else: ?>
        <div class="cart-items">
            <?php foreach ($cart_items as $item): 
                if (is_array($item) && isset($item['product_id']) && isset($products[$item['product_id']])):
                    $product = $products[$item['product_id']];
            ?>
                <div class="cart-item">
                    <div class="cart-product-image">
                        <img src="<?= htmlspecialchars($product['main_image_path']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                    </div>
                    <div class="product-details">
                        <h3><?= htmlspecialchars($product['name']) ?></h3>
                        <p class="platform"><?= htmlspecialchars($product['platform']) ?></p>
                        <div class="quantity-controls">
                            <form action="assets/functionality/update_cart_quantity.php" method="POST" class="quantity-form" id="quantity-form-<?php echo $product['id']; ?>">
                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" max="<?php echo $available_keys; ?>" class="quantity-input" onchange="this.form.submit()">
                            </form>
                        </div>
                    </div>
                    <div class="product-price">
                        <span class="price">€<?= number_format($product['price_eur'] * $item['quantity'], 2) ?></span>
                        <form action="assets/functionality/delete_from_cart.php" method="POST">
                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                            <button type="submit" class="btn-icon warning">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            <?php 
                endif;
            endforeach; ?>
        </div>

        <div class="cart-summary">
            <div class="total">
                <span>Kopā:</span>
                <span class="total-price">€<?= number_format($total_price, 2) ?></span>
            </div>
            <a href="checkout.php" class="btn btn-primary">Turpināt uz norēķiniem</a>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'includes/footer.php'; ?> 