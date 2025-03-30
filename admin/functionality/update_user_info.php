<?php
session_start();
require_once '../../assets/functionality/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    $_SESSION['flash_message'] = 'Nav atļauts veikt šo darbību.';
    $_SESSION['flash_type'] = 'error';
    header('Location: ../users.php');
    exit();
}

// Handle GET request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['id'])) {
        $_SESSION['flash_message'] = 'Lietotāja ID nav norādīts.';
        $_SESSION['flash_type'] = 'error';
        header('Location: ../users.php');
        exit();
    }

    $user_id = $_GET['id'];

    try {
        $stmt = $conn->prepare("SELECT id, name, email, role_id FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            $_SESSION['flash_message'] = 'Lietotājs nav atrasts.';
            $_SESSION['flash_type'] = 'error';
            header('Location: ../users.php');
            exit();
        }
        
        $user = $result->fetch_assoc();
        
        // Store user data in session for the form
        $_SESSION['edit_user'] = $user;
        header('Location: ../users.php?edit=' . $user_id);
        exit();
        
    } catch (Exception $e) {
        $_SESSION['flash_message'] = 'Kļūda iegūstot lietotāja datus.';
        $_SESSION['flash_type'] = 'error';
        header('Location: ../users.php');
        exit();
    }
}

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'] ?? '';
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $role_id = $_POST['role_id'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($user_id) || empty($name) || empty($email) || empty($role_id)) {
        $_SESSION['flash_message'] = 'Visi lauki ir obligāti.';
        $_SESSION['flash_type'] = 'error';
        header('Location: ../users.php?edit=' . $user_id);
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['flash_message'] = 'Nederīgs e-pasta formāts.';
        $_SESSION['flash_type'] = 'error';
        header('Location: ../users.php?edit=' . $user_id);
        exit();
    }

    if (!empty($password)) {
        if (strlen($password) < 3) {
            $_SESSION['flash_message'] = 'Parolei jābūt vismaz 3 simbolus garai.';
            $_SESSION['flash_type'] = 'error';
            header('Location: ../users.php?edit=' . $user_id);
            exit();
        }
    }

    try {
        // Check if email is already taken by another user
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
        $stmt->bind_param("si", $email, $user_id);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            $_SESSION['flash_message'] = 'Šis e-pasts jau ir reģistrēts.';
            $_SESSION['flash_type'] = 'error';
            header('Location: ../users.php?edit=' . $user_id);
            exit();
        }

        if (!empty($password)) {
            // Update with new password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, role_id = ? password = ? WHERE id = ?");
            $stmt->bind_param("ssisi", $name, $email, $role_id, $hashed_password, $user_id);
        } else {
            // Update without changing password
            $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, role_id = ? WHERE id = ?");
            $stmt->bind_param("ssii", $name, $email, $role_id, $user_id);
        }
        
        if ($stmt->execute()) {
            // Logs
            $admin_id = $_SESSION['user_id'];
            $stmt = $conn->prepare("INSERT INTO logs (user_id, action, details) VALUES (?, 'update_user', ?)");
            $details = "Updated user ID: $user_id" . (!empty($password) ? " (including password)" : "");
            $stmt->bind_param("is", $admin_id, $details);
            $stmt->execute();

            $_SESSION['flash_message'] = 'Lietotāja informācija ir atjaunināta.';
            $_SESSION['flash_type'] = 'success';
            unset($_SESSION['edit_user']);
            header('Location: ../users.php');
            exit();
        } else {
            throw new Exception("Database error");
        }
    } catch (Exception $e) {
        $_SESSION['flash_message'] = 'Kļūda atjauninot lietotāja informāciju.';
        $_SESSION['flash_type'] = 'error';
        header('Location: ../users.php?edit=' . $user_id);
        exit();
    }
}

header('Location: ../users.php');
exit();
