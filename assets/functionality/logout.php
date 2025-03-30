<?php
require_once 'db.php';
session_start();

// Get user data before destroying session
$user_id = $_SESSION['user_id'] ?? null;
$user_role = $_SESSION['user_role'] ?? null;

// Logs
if ($user_id) {
    $stmt = $conn->prepare("INSERT INTO logs (user_id, action, ip_address, details) VALUES (?, 'logout', ?, 'User logged out')");
    $stmt->bind_param("is", $user_id, $_SERVER['REMOTE_ADDR']);
    $stmt->execute();
    $stmt->close();

    // Remove remember token if exists
    if (isset($_COOKIE['remember_token'])) {
        $token = $_COOKIE['remember_token'];
        $stmt = $conn->prepare("DELETE FROM remember_tokens WHERE user_id = ? AND token = ?");
        $stmt->bind_param("is", $user_id, $token);
        $stmt->execute();
        $stmt->close();

        // Remove the cookie
        setcookie('remember_token', '', [
            'expires' => time() - 3600,
            'path' => '/',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Strict'
        ]);
    }
}

session_destroy();
$conn->close();

header('Location: /eksamens/keyforge_eksamens/login.php');
exit(); 