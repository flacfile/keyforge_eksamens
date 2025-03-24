<?php
require_once 'db.php';
session_start();

// Validate input
$username = trim($_POST['username'] ?? '');
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$password = $_POST['password'] ?? '';
$password_confirm = $_POST['password_confirm'] ?? '';

// Validation checks
if (empty($username) || !$email || empty($password) || empty($password_confirm)) {
    $_SESSION['flash_message'] = 'Lūdzu, aizpildiet visus laukus.';
    $_SESSION['flash_type'] = 'error';
    header('Location: /eksamens/keyforge_eksamens/register.php');
    exit();
}

if ($password !== $password_confirm) {
    $_SESSION['flash_message'] = 'Paroles nesakrīt.';
    $_SESSION['flash_type'] = 'error';
    header('Location: /eksamens/keyforge_eksamens/register.php');
    exit();
}

if (strlen($password) < 1) {
    $_SESSION['flash_message'] = 'Parolei jābūt vismaz 8 rakstzīmes garai.';
    $_SESSION['flash_type'] = 'error';
    header('Location: /eksamens/keyforge_eksamens/register.php');
    exit();
}

if (strlen($username) < 4) {
    $_SESSION['flash_message'] = 'Lietotājvārdam jābūt vismaz 4 rakstzīmes garam.';
    $_SESSION['flash_type'] = 'error';
    header('Location: /eksamens/keyforge_eksamens/register.php');
    exit();
}

// Check if email exists
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $_SESSION['flash_message'] = 'Šis e-pasts jau reģistrēts.';
    $_SESSION['flash_type'] = 'error';
    header('Location: /eksamens/keyforge_eksamens/register.php');
    exit();
}
$stmt->close();

// Check if username exists
$stmt = $conn->prepare("SELECT id FROM users WHERE name = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $_SESSION['flash_message'] = 'Šis lietotājvārds jau aizņemts.';
    $_SESSION['flash_type'] = 'error';
    header('Location: /eksamens/keyforge_eksamens/register.php');
    exit();
}
$stmt->close();

// Insert new user
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$role_id = 2;
$status = 'active';

$stmt = $conn->prepare("INSERT INTO users (role_id, email, password, name, status) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("issss", $role_id, $email, $hashed_password, $username, $status);

if ($stmt->execute()) {
    $user_id = $conn->insert_id;
    
    // Log the registration
    $action = "register";
    $details = "New user registration";
    $ip = $_SERVER['REMOTE_ADDR'];
    
    $log_stmt = $conn->prepare("INSERT INTO logs (user_id, action, ip_address, details) VALUES (?, ?, ?, ?)");
    $log_stmt->bind_param("isss", $user_id, $action, $ip, $details);
    $log_stmt->execute();
    $log_stmt->close();

    $_SESSION['flash_message'] = 'Reģistrācija veiksmīga. Lūdzu, piesakieties sistēmā.';
    $_SESSION['flash_type'] = 'success';
    header('Location: /eksamens/keyforge_eksamens/login.php');
} else {
    $_SESSION['flash_message'] = 'Kļūda. Lūdzu, mēģiniet vēlreiz.';
    $_SESSION['flash_type'] = 'error';
    header('Location: /eksamens/keyforge_eksamens/register.php');
}

$stmt->close();
$conn->close();
exit();