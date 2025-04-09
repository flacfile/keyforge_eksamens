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
    $key_id = $_POST['key_id'] ?? '';
    $page = $_POST['page'] ?? 1;
    $product_id = $_POST['product_id'] ?? '';

    // Validate inputs
    if (empty($key_id)) {
        $_SESSION['error'] = 'Atslēga nav atrasta!';
        header("Location: ../products.php?page=$page&product_id=$product_id");
        exit();
    }

    // Get key details before deletion
    $stmt = $conn->prepare("SELECT `key`, product_id FROM game_keys WHERE id = ?");
    $stmt->bind_param('i', $key_id);
    $stmt->execute();
    $key_details = $stmt->get_result()->fetch_assoc();

    // Delete the key
    $stmt = $conn->prepare("DELETE FROM game_keys WHERE id = ?");
    $stmt->bind_param('i', $key_id);

    if ($stmt->execute()) {
        // Logs
        $admin_id = $_SESSION['user_id'];
        $stmt = $conn->prepare("INSERT INTO logs (user_id, action, details) VALUES (?, ?, ?)");
        $action = "delete_key";
        $details = "Deleted key: " . $key_details['key'] . " for product ID: " . $key_details['product_id'];
        $stmt->bind_param("iss", $admin_id, $action, $details);
        $stmt->execute();

        $_SESSION['success'] = 'Atslēga veiksmīgi izdzēsta!';
    } else {
        $_SESSION['error'] = 'Kļūda dzēšot atslēgu!';
    }

    header("Location: ../products.php?page=$page&product_id=$product_id");
    exit();

} else {
    header('Location: ../products.php');
    exit();
}