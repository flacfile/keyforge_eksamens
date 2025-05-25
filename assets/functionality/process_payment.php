<?php
session_start();
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/../../stripe/init.php';
require_once __DIR__ . '/../../config/secrets.php';
\Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);

$session_id = $_GET['session_id'] ?? '';

if (empty($session_id)) {
    $_SESSION['error'] = 'Invalid session ID';
    header('Location: ../../checkout.php');
    exit;
}

try {
    $session = \Stripe\Checkout\Session::retrieve($session_id);
    
    if ($session->payment_status !== 'paid') {
        throw new Exception('Payment not completed');
    }

    $cart = json_decode($session->metadata->cart, true);
    
    // Start database transaction
    $conn->begin_transaction();

    try {
        $user_id = $_SESSION['user_id'];
        $total_amount = $session->amount_total / 100;
        
        $stmt = $conn->prepare("INSERT INTO orders (user_id, total_amount, status, created_at) VALUES (?, ?, 'completed', NOW())");
        $stmt->bind_param("id", $user_id, $total_amount);
        $stmt->execute();
        $order_id = $conn->insert_id;

        // Process each item in cart
        foreach ($cart as $item) {
            $product_id = $item['product_id'];
            $quantity = $item['quantity'];

            // Get product price
            $stmt = $conn->prepare("SELECT price_eur FROM products WHERE id = ?");
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $product = $result->fetch_assoc();
            
            if (!$product) {
                throw new Exception('Product not found: ' . $product_id);
            }
            
            $price = $product['price_eur'];
            
            // Get available keys
            $stmt = $conn->prepare("SELECT id FROM game_keys WHERE product_id = ? AND status = 'available' LIMIT ?");
            $stmt->bind_param("ii", $product_id, $quantity);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $keys = [];
            while ($row = $result->fetch_assoc()) {
                $keys[] = $row['id'];
            }

            if (count($keys) < $quantity) {
                throw new Exception('Not enough keys available for product ID: ' . $product_id);
            }

            // Mark keys as sold
            if (!empty($keys)) {
                $placeholders = str_repeat('?,', count($keys) - 1) . '?';
                $stmt = $conn->prepare("UPDATE game_keys SET status = 'sold' WHERE id IN ($placeholders)");
                $types = str_repeat('i', count($keys));
                $stmt->bind_param($types, ...$keys);
                $stmt->execute();

                // Update number_of_keys in products table
                $stmt = $conn->prepare("UPDATE products SET number_of_keys = number_of_keys - ? WHERE id = ?");
                $stmt->bind_param("ii", $quantity, $product_id);
                $stmt->execute();
            }

            // Insert order item
            $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiid", $order_id, $product_id, $quantity, $price);
            $stmt->execute();
        }

        $conn->commit();
        
        unset($_SESSION['cart']);
        
        header('Location: ../../payment_success.php');
        exit;

    } catch (Exception $e) {
        $conn->rollback();
        throw $e;
    }

} catch (Exception $e) {
    $_SESSION['error'] = 'Payment processing failed: ' . $e->getMessage();
    header('Location: ../../checkout.php');
    exit;
}
?> 