<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    
    if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $key => $item) {
            if (isset($item['product_id']) && $item['product_id'] == $product_id) {
                unset($_SESSION['cart'][$key]);
                break;
            }
        }
        
        // Array reindex, cause there could be issue with element index issue (0=> item1, 1=> item3)
        $_SESSION['cart'] = array_values($_SESSION['cart']);
        
        if (empty($_SESSION['cart'])) {
            unset($_SESSION['cart']);
        }
    }
    
    header('Location: ../../cart.php');
    exit();
} else {
    header('Location: ../../cart.php');
    exit();
}
?> 