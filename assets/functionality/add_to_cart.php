<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'] ?? 1;

    //Check if product exists and active
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ? AND status = 'active'");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        $_SESSION['error'] = "Produkts nav atrasts vai nav pieejams.";
        header("Location: ../../cart.php");
        exit();
    }

    // Check available keys
    $stmt = $conn->prepare("SELECT COUNT(*) FROM game_keys WHERE product_id = ? AND status = 'available'");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $available_keys = $stmt->get_result()->fetch_row()[0];

    // Check if there are enough keys available
    if ($available_keys < $quantity) {
        $_SESSION['error'] = "Atvainojiet, bet mums nav tik daudz atslēgu pieejams :(";
        header("Location: ../../cart.php");
        exit();
    }

    if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // If already in cart quantity++
    $total_in_cart = 0;
    foreach ($_SESSION['cart'] as $item) {
        if (isset($item['product_id']) && $item['product_id'] == $product_id) {
            $total_in_cart += (int)$item['quantity'];
        }
    }

    // Extra check when adding the key and not enough keys in DB
    if (($total_in_cart + $quantity) > $available_keys) {
        $_SESSION['error'] = "Atvainojiet, bet mums nav tik daudz atslēgu pieejams :(";
        header("Location: ../../cart.php");
        exit();
    }

    // Add to cart
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if (isset($item['product_id']) && $item['product_id'] == $product_id) {
            $item['quantity'] = (int)$item['quantity'] + (int)$quantity;
            $found = true;
            break;
        }
    }

    if (!$found) {
        $_SESSION['cart'][] = [
            'product_id' => (int)$product_id,
            'quantity' => (int)$quantity
        ];
    }

    header("Location: ../../cart.php");
    exit();
} else {
    header('Location: ../../index.php');
    exit;
} 