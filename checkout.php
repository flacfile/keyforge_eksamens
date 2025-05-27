<?php
session_start();
require_once 'assets/functionality/db.php';

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit();
}

$total_price = 0;
$cart_items = [];

foreach ($_SESSION['cart'] as $item) {
    if (is_array($item) && isset($item['product_id'])) {
        $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param("i", $item['product_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($product = $result->fetch_assoc()) {
            $total_price += $product['price_eur'] * $item['quantity'];
            $cart_items[] = [
                'product' => $product,
                'quantity' => $item['quantity']
            ];
        }
    }
}

require_once 'includes/header.php';
?>
<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KeyForge - Labākas cenas</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<div class="checkout-container">
    <div class="checkout-summary">
        <h2>Jūsu pasūtījums</h2>
        <div class="order-items">
            <?php foreach ($cart_items as $cart_item): ?>
                <div class="order-item">
                    <div class="item-details">
                        <h3><?= htmlspecialchars($cart_item['product']['name']) ?></h3>
                        <p>Platforma: <?= htmlspecialchars($cart_item['product']['platform']) ?></p>
                        <p>Daudzums: <?= $cart_item['quantity'] ?></p>
                    </div>
                    <div class="item-price">
                        €<?= number_format($cart_item['product']['price_eur'] * $cart_item['quantity'], 2) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="order-total-checkout">
        <form action="assets/functionality/create_checkout_session.php" method="POST">
            <input type="hidden" name="amount" value="<?= $total_price * 100 ?>">
            <input type="hidden" name="cart" value='<?= json_encode($_SESSION['cart']) ?>'>
            <button type="submit" id="checkout-button">Apmaksāt €<?= number_format($total_price, 2) ?></button>
        </form>
            <h3>Kopā: €<?= number_format($total_price, 2) ?></h3>
        </div>
        
    </div>
</div>

<?php require_once 'includes/footer.php'; ?> 