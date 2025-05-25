<?php
require_once '../../assets/functionality/db.php';
session_start();

$product_id = $_POST['product_id'] ?? '';
$status = $_POST['status'] ?? '';

if (empty($product_id) || empty($status) || !in_array($status, ['active', 'inactive'])) {
    $_SESSION['flash_message'] = 'Nederīgi dati.';
    $_SESSION['flash_type'] = 'error';
    header('Location: ../products.php');
    exit();
}

$stmt = $conn->prepare("UPDATE products SET status = ? WHERE id = ?");
$stmt->bind_param("si", $status, $product_id);



// Logs
if ($stmt->execute()) {
    $action = $status === 'inactive' ? 'product_deactivated' : 'product_activated';
    $details = "Product ID: $product_id status changed to $status";
    
    $log_stmt = $conn->prepare("INSERT INTO logs (user_id, action, ip_address, details) VALUES (?, ?, ?, ?)");
    $log_stmt->bind_param("isss", $_SESSION['user_id'], $action, $_SERVER['REMOTE_ADDR'], $details);
    $log_stmt->execute();
    
    $_SESSION['flash_message'] = 'Produkta status atjaunots.';
    $_SESSION['flash_type'] = 'success';
} else {
    $_SESSION['flash_message'] = 'Kļūda atjauninot produkta statusu.';
    $_SESSION['flash_type'] = 'error';
}



$stmt->close();
$conn->close();

header('Location: ../products.php');
exit(); 