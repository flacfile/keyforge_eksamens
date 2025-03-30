<?php
session_start();
?>
<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - KeyForge</title>
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body class="auth-page">
    <div class="auth-container">
        <div class="auth-box">
            <h1><a href="index.php">KeyForge</a> Reģistrācija</h1>
            
            <?php if (isset($_SESSION['flash_message'])): ?>
            <div class="alert alert-<?= $_SESSION['flash_type'] ?? 'info' ?>">
                <?= htmlspecialchars($_SESSION['flash_message'], ENT_QUOTES, 'UTF-8') ?>
            </div>
            <?php 
                unset($_SESSION['flash_message']);
                unset($_SESSION['flash_type']);
            endif; ?>

            <form action="assets/functionality/register_process.php" method="POST" class="auth-form">
                <div class="form-group">
                    <label for="username">Lietotājvārds</label>
                    <input type="text" id="username" name="username" required>
                </div>

                <div class="form-group">
                    <label for="email">E-pasts</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="password">Parole</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="form-group">
                    <label for="password_confirm">Apstiprināt paroli</label>
                    <input type="password" id="password_confirm" name="password_confirm" required>
                </div>

                <button type="submit" class="btn btn-primary">Reģistrēties</button>
            </form>

                <div class="auth-links">
                    <p><a href="login.php">Jau ir konts?</a></p>
                </div>
            
        </div>
    </div>
</body>
</html> 