<?php
require_once '../../assets/functionality/db.php';
session_start();

$user_id = $_POST['user_id'] ?? '';
$status = $_POST['status'] ?? '';

if (empty($user_id) || empty($status) || !in_array($status, ['active', 'blocked'])) {
    $_SESSION['flash_message'] = 'Nederīgi dati.';
    $_SESSION['flash_type'] = 'error';
    header('Location: ../users.php');
    exit();
}

$stmt = $conn->prepare("UPDATE users SET status = ? WHERE id = ?");
$stmt->bind_param("si", $status, $user_id);



// Logs
if ($stmt->execute()) {
    $action = $status === 'blocked' ? 'user_blocked' : 'user_unblocked';
    $details = "User ID: $user_id status changed to $status";
    
    $log_stmt = $conn->prepare("INSERT INTO logs (user_id, action, ip_address, details) VALUES (?, ?, ?, ?)");
    $log_stmt->bind_param("isss", $_SESSION['user_id'], $action, $_SERVER['REMOTE_ADDR'], $details);
    $log_stmt->execute();
    
    $_SESSION['flash_message'] = 'Lietotāja status atjaunots.';
    $_SESSION['flash_type'] = 'success';
} else {
    $_SESSION['flash_message'] = 'Kļūda atjauninot lietotāja statusu.';
    $_SESSION['flash_type'] = 'error';
}



$stmt->close();
$conn->close();

header('Location: ../users.php');
exit(); 