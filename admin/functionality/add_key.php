<?php
session_start();
require_once '../../assets/functionality/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    $_SESSION['flash_message'] = 'Nav atļauts veikt šo darbību.';
    $_SESSION['flash_type'] = 'error';
    header('Location: ../products.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'] ?? '';
    $key = trim($_POST['key'] ?? '');
    $page = $_POST['page'] ?? 1;

    if (empty($product_id) || empty($key)) {
        $_SESSION['error'] = 'Lūdzu aizpildiet visus laukus!';
        header("Location: ../products.php?page=$page&product_id=$product_id");
        exit();
    }

    // Check if product exists
    $stmt = $conn->prepare("SELECT id FROM products WHERE id = ?");
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $_SESSION['error'] = 'Produkts nav atrasts!';
        header("Location: ../products.php?page=$page");
        exit();
    }

    // Check if key already exists
    $stmt = $conn->prepare("SELECT id FROM game_keys WHERE `key` = ?");
    $stmt->bind_param('s', $key);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error'] = 'Atslēga jau eksistē!';
        header("Location: ../products.php?page=$page&product_id=$product_id");
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO game_keys (product_id, `key`, status) VALUES (?, ?, 'available')");
    $stmt->bind_param('is', $product_id, $key);

    if ($stmt->execute()) {
         // Logs
        $stmt = $conn->prepare("INSERT INTO logs (user_id, action, details) VALUES (?, ?, ?)");
        $action = "add_key";
        $details = "Added key: $key for product ID: $product_id";
        $stmt->bind_param("iss", $admin_id, $action, $details);
        $stmt->execute();

        $_SESSION['success'] = 'Atslēga veiksmīgi pievienota!';
    } else {
        $_SESSION['error'] = 'Kļūda pievienojot atslēgu!';
    }

    header("Location: ../products.php?page=$page&product_id=$product_id");
    exit();

} else {
    header('Location: ../products.php');
    exit();
}