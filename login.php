<?php
session_start();

function h($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: ' . ($_SESSION['user_role'] === 'admin' ? '/eksamens/keyforge_eksamens/admin/dashboard.php' : '/eksamens/keyforge_eksamens/cabinet.php'));
    exit();
}
?>
<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - KeyForge</title>
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body class="auth-page">
    <div class="auth-container">
        <div class="auth-box">
            <h1><a href="index.php">KeyForge</a> Pieteikšanās</h1>
            
            <?php if (isset($_SESSION['flash_message'])): ?>
            <div class="alert alert-<?= $_SESSION['flash_type'] ?? 'info' ?>">
                <?= h($_SESSION['flash_message']) ?>
            </div>
            <?php 
                unset($_SESSION['flash_message']);
                unset($_SESSION['flash_type']);
            endif; ?>
            <form action="assets/functionality/login_process.php" method="POST" class="auth-form">
                <div class="form-group">
                    <label for="email">E-pasts</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="password">Parole</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="form-group remember-me">
                    <label>
                        <input type="checkbox" name="remember" value="1">
                        <span>Atcerēties mani</span>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary">Ieiet</button>
            </form>
            <div class="auth-links">
                <p><a href="register.php">Nav konts?</a></p>
            </div>
        </div>
    </div>
</body>
</html> 