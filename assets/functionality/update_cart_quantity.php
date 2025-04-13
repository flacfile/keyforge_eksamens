<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $quantity = (int)$_POST['quantity'];

    if ($quantity < 1) {
        $_SESSION['error'] = "Daudzumam jābūt vismaz 1.";
        header("Location: ../../cart.php");
        exit();
    }

    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ? AND status = 'active'");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        $_SESSION['error'] = "Produkts nav atrasts vai nav pieejams.";
        header("Location: ../../cart.php");
        exit();
    }

    $product = $result->fetch_assoc();
    $product_name = $product['title'];
    $product_price = $product['price_eur'];

    $stmt = $conn->prepare("SELECT COUNT(*) FROM game_keys WHERE product_id = ? AND status = 'available'");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $available_keys = $stmt->get_result()->fetch_row()[0];

    if ($quantity > $available_keys) {
        $_SESSION['error'] = "Atvainojiet, bet mums nav tik daudz atslēgu pieejams :(";
        header("Location: ../../cart.php");
        exit();
    }

    if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Create a new array to store the updated items
    $new_cart = [];
    $total_price = 0;
    $found = false;

    // Process each item in the cart
    foreach ($_SESSION['cart'] as $item) {
        if (is_array($item) && isset($item['product_id'])) {
            if ($item['product_id'] == $product_id) {
                // Update the quantity for the matching product
                $new_cart[] = [
                    'product_id' => $product_id,
                    'quantity' => $quantity
                ];
                $found = true;
            } else {
                // Keep other products as they are
                $new_cart[] = $item;
            }
        }
    }

    // If product not found in cart, add it
    if (!$found) {
        $new_cart[] = [
            'product_id' => $product_id,
            'quantity' => $quantity
        ];
    }

    // Update the session cart with the new cart
    $_SESSION['cart'] = $new_cart;

    // Total price
    foreach ($_SESSION['cart'] as $item) {
        if (is_array($item) && isset($item['product_id'])) {
            $stmt = $conn->prepare("SELECT price_eur FROM products WHERE id = ?");
            $stmt->bind_param("i", $item['product_id']);
            $stmt->execute();
            $price_result = $stmt->get_result();
            if ($price_row = $price_result->fetch_assoc()) {
                $total_price += $price_row['price_eur'] * $item['quantity'];
            }
        }
    }

    $_SESSION['cart_total'] = $total_price;

    header("Location: ../../cart.php");
    exit();
} else {
    header('Location: ../../cart.php');
    exit();
}
?> 