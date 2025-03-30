<?php
require_once '../../assets/functionality/db.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    $_SESSION['flash_message'] = 'Nav atļauts veikt šo darbību.';
    $_SESSION['flash_type'] = 'error';
    header('Location: ../users.php');
    exit();
}

// Get form data
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$role_id = $_POST['role_id'] ?? '';

if (empty($name) || empty($email) || empty($password) || empty($role_id)) {
    $_SESSION['flash_message'] = 'Visi lauki ir obligāti.';
    $_SESSION['flash_type'] = 'error';
    header('Location: ../users.php');
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['flash_message'] = 'Nederīgs e-pasta formāts.';
    $_SESSION['flash_type'] = 'error';
    header('Location: ../users.php');
    exit();
}

if (strlen($password) < 3) {
    $_SESSION['flash_message'] = 'Parolei jābūt vismaz 3 simbolus garai.';
    $_SESSION['flash_type'] = 'error';
    header('Location: ../users.php');
    exit();
}

try {
    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        $_SESSION['flash_message'] = 'Šis e-pasts jau ir reģistrēts.';
        $_SESSION['flash_type'] = 'error';
        header('Location: ../users.php');
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role_id, status, created_at) VALUES (?, ?, ?, ?, 'active', NOW())");
    $stmt->bind_param("sssi", $name, $email, $hashed_password, $role_id);
    
    // logs
    if ($stmt->execute()) {
        $admin_id = $_SESSION['user_id'];
        $new_user_id = $conn->insert_id;
        $stmt = $conn->prepare("INSERT INTO logs (user_id, action, details) VALUES (?, ?, ?)");
        $action = "create_user";
        $details = "Created new user ID: $new_user_id";
        $stmt->bind_param("iss", $admin_id, $action, $details);
        $stmt->execute();

        $_SESSION['flash_message'] = 'Lietotājs veiksmīgi pievienots.';
        $_SESSION['flash_type'] = 'success';
    } else {
        throw new Exception("Database error");
    }
} catch (Exception $e) {
    $_SESSION['flash_message'] = 'Kļūda pievienojot lietotāju.';
    $_SESSION['flash_type'] = 'error';
}

header('Location: ../users.php');
exit(); 