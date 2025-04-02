<?php
session_start();
require_once '../../assets/functionality/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    $_SESSION['flash_message'] = 'Nav atļauts veikt šo darbību.';
    $_SESSION['flash_type'] = 'error';
    header('Location: ../products.php');
    exit();
}

$product_id = $_POST['product_id'];

try {
    // get img path
    $stmt = $conn->prepare("SELECT main_image_path FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();   
    $product = $result->fetch_assoc();
    
    // Delete the product image if it exists
    if (!empty($product['main_image_path']) && file_exists('../../' . $product['main_image_path'])) {
        unlink('../../' . $product['main_image_path']);
    }
    
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    
    if ($stmt->execute()) {
        // Logs
        $admin_id = $_SESSION['user_id'];
        $stmt = $conn->prepare("INSERT INTO logs (user_id, action, details) VALUES (?, 'delete_product', ?)");
        $details = "Deleted product ID: $product_id";
        $stmt->bind_param("is", $admin_id, $details);
        $stmt->execute();

        $_SESSION['flash_message'] = 'Produkts veiksmīgi izdzēsts.';
        $_SESSION['flash_type'] = 'success';
    } else {
        throw new Exception("Datubāzes kļūda");
    }
} catch (Exception $e) {
    $_SESSION['flash_message'] = 'Kļūda izdzēšot produktu.';
    $_SESSION['flash_type'] = 'error';
}

header('Location: ../products.php');
exit(); 