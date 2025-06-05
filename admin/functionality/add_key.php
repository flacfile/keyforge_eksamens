<?php
session_start();
require_once '../../assets/functionality/db.php';
require_once '../../assets/functionality/encryption.php';

// Pārbaudīt, vai lietotājs ir pieteicies un vai tam ir administratora loma
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    $_SESSION['flash_message'] = 'Nav atļauts veikt šo darbību.';
    $_SESSION['flash_type'] = 'error';
    header('Location: ../products.php');
    exit();
}

// Apstrādāt formas iesniegšanu
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get formas datus
    $product_id = $_POST['product_id'] ?? '';
    $key = trim($_POST['key'] ?? '');
    $page = $_POST['page'] ?? 1;

    // Pārbaudīt, vai ir aizpildīti obligātie lauki
    if (empty($product_id) || empty($key)) {
        $_SESSION['error'] = 'Lūdzu aizpildiet visus laukus!';
        header("Location: ../products.php?page=$page&product_id=$product_id");
        exit();
    }

    // Pārbaudīt, vai produkts eksistē datubāzē
    $stmt = $conn->prepare("SELECT id FROM products WHERE id = ?");
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $_SESSION['error'] = 'Produkts nav atrasts!';
        header("Location: ../products.php?page=$page");
        exit();
    }

    // Šifrēt atslēgu pirms salīdzināšanas
    encryptKey();

    // Pārbaudīt, vai atslēga jau eksistē datubāzē
    $stmt = $conn->prepare("SELECT id FROM game_keys WHERE `key` = ?");
    $stmt->bind_param('s', $encrypted_key);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error'] = 'Atslēga jau eksistē!';
        header("Location: ../products.php?page=$page&product_id=$product_id");
        exit();
    }

    // Ievietot jaunu atslēgu datubāzē (šifrētu)
    $stmt = $conn->prepare("INSERT INTO game_keys (product_id, `key`, status) VALUES (?, ?, 'available')");
    $stmt->bind_param('is', $product_id, $encrypted_key);
    
    if ($stmt->execute()) {
        // Atjaunināt produkta atslēgu skaitu produktam
        $stmt = $conn->prepare("UPDATE products SET number_of_keys = number_of_keys + 1 WHERE id = ?");
        $stmt->bind_param('i', $product_id);
        $stmt->execute();

        // Auditēšana
        $admin_id = $_SESSION['user_id'];
        $stmt = $conn->prepare("INSERT INTO logs (user_id, action, details) VALUES (?, ?, ?)");
        $action = "add_key";
        $details = "Added key for product ID: $product_id";
        $stmt->bind_param("iss", $admin_id, $action, $details);
        $stmt->execute();

        // Iestatīt veiksmīgas darbības ziņojumu
        $_SESSION['flash_message'] = 'Atslēga veiksmīgi pievienota!';
        $_SESSION['flash_type'] = 'success';
    } else {
        // Iestatīt kļūdas ziņojumu, ja ievietošana neizdodas
        $_SESSION['flash_message'] = 'Kļūda pievienojot atslēgu!';
        $_SESSION['flash_type'] = 'error';
    }

    // Redirectēt atpakaļ uz produktu tabulu uz lapu, kurā bijis lietotājs
    header("Location: ../products.php?page=$page&product_id=$product_id");
    exit();
} else {
    // Redirectēt uz produktu tabulu, ja tiek pieprasīts bez POST pieprasījuma
    header('Location: ../products.php');
    exit();
}