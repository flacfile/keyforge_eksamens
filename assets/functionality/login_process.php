<?php
require_once 'db.php';
session_start();

// Validate input
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$password = $_POST['password'] ?? '';
$remember = isset($_POST['remember']);

// Validation checks
if (!$email || empty($password)) {
    $_SESSION['flash_message'] = 'Lūdzu, ievadiet e-pastu un paroli.';
    $_SESSION['flash_type'] = 'error';
    header('Location: /eksamens/keyforge_eksamens/login.php');
    exit();
}

// Check user credentials
$stmt = $conn->prepare("SELECT u.*, r.name as role_name FROM users u JOIN roles r ON u.role_id = r.id WHERE u.email = ? AND u.status = 'active'");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && password_verify($password, $user['password'])) {
    // Log successful login
    $log_stmt = $conn->prepare("INSERT INTO logs (user_id, action, ip_address, details) VALUES (?, 'login', ?, 'Successful login')");
    $log_stmt->bind_param("is", $user['id'], $_SERVER['REMOTE_ADDR']);
    $log_stmt->execute();
    $log_stmt->close();

    // Update last login
    $update_stmt = $conn->prepare("UPDATE users SET last_login = CURRENT_TIMESTAMP WHERE id = ?");
    $update_stmt->bind_param("i", $user['id']);
    $update_stmt->execute();
    $update_stmt->close();

    // Set session variables
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['name'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['user_role'] = $user['role_name'];

    // Handle remember me
    if ($remember) {
        $token = bin2hex(random_bytes(32));
        $expiry = date('Y-m-d H:i:s', strtotime('+30 days'));
        
        $token_stmt = $conn->prepare("INSERT INTO remember_tokens (user_id, token, expires_at) VALUES (?, ?, ?)");
        $token_stmt->bind_param("iss", $user['id'], $token, $expiry);
        $token_stmt->execute();
        $token_stmt->close();
        
        setcookie('remember_token', $token, [
            'expires' => strtotime('+30 days'),
            'path' => '/',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Strict'
        ]);
    }

    // Redirect based on role
    if ($user['role_name'] === 'admin') {
        header('Location: /eksamens/keyforge_eksamens/admin/dashboard.php');
    } else {
        header('Location: /eksamens/keyforge_eksamens/cabinet.php');
    }
    exit();
} else {
    // Log failed login attempt
    $fail_stmt = $conn->prepare("INSERT INTO logs (action, ip_address, details) VALUES ('login_failed', ?, ?)");
    $details = "Failed login attempt for email: $email";
    $fail_stmt->bind_param("ss", $_SERVER['REMOTE_ADDR'], $details);
    $fail_stmt->execute();
    $fail_stmt->close();

    $_SESSION['flash_message'] = 'Nepareizs e-pasts vai parole.';
    $_SESSION['flash_type'] = 'error';
    header('Location: /eksamens/keyforge_eksamens/login.php');
    exit();
}

$stmt->close();
$conn->close(); 