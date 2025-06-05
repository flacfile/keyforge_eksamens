<?php
require_once 'includes/header.php';
?>
<?php
session_start();
require_once 'assets/functionality/db.php';
require_once 'assets/functionality/encryption.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Get user information
$query = "
    SELECT name, email, created_at
    FROM users
    WHERE id = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// Get user's orders with their items and keys
$query = "
    SELECT 
        o.id as order_id,
        o.total_amount,
        o.status as order_status,
        o.created_at as order_date,
        oi.product_id,
        oi.quantity,
        oi.price,
        p.name as product_name,
        p.platform,
        GROUP_CONCAT(
            DISTINCT 
            CASE 
                WHEN gk.status = 'sold' 
                AND gk.updated_at >= oi.created_at 
                AND gk.updated_at <= DATE_ADD(oi.created_at, INTERVAL 1 MINUTE)
                THEN gk.key
            END
        ) as game_keys
    FROM orders o
    JOIN order_items oi ON o.id = oi.order_id
    JOIN products p ON oi.product_id = p.id
    LEFT JOIN game_keys gk ON gk.product_id = oi.product_id
    WHERE o.user_id = ?
    GROUP BY o.id, oi.id
    ORDER BY o.created_at DESC, p.name
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$orders = [];
while ($row = $result->fetch_assoc()) {
    $order_id = $row['order_id'];
    if (!isset($orders[$order_id])) {
        $orders[$order_id] = [
            'id' => $order_id,
            'total_amount' => $row['total_amount'],
            'status' => $row['order_status'],
            'date' => $row['order_date'],
            'items' => []
        ];
    }

    // Get the game keys
    $game_keys = [];
    if (!empty($row['game_keys'])) {
        $game_keys = explode(',', $row['game_keys']);
    }

    $orders[$order_id]['items'][] = [
        'product_name' => $row['product_name'],
        'platform' => $row['platform'],
        'quantity' => $row['quantity'],
        'price' => $row['price'],
        'keys' => $game_keys
    ];
}
?>
<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kabinēts</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <script src="assets/js/script.js"></script>
</head>

<div class="container">
        <div class="profile-container">
            <div class="profile-header">
                <h1>Mans Profils</h1>
                <div class="user-info">
                    <div class="info-group">
                        <label>Lietotājvārds:</label>
                        <span><?= htmlspecialchars($user['name']) ?></span>
                    </div>
                    <div class="info-group">
                        <label>E-pasts:</label>
                        <span><?= htmlspecialchars($user['email']) ?></span>
                    </div>
                    <div class="info-group">
                        <label>Reģistrējies:</label>
                        <span><?= date('d.m.Y', strtotime($user['created_at'])) ?></span>
                    </div>
                </div>
            </div>

            <div class="orders-section">
                <h2>Mani Pasūtījumi</h2>
                <?php if (empty($orders)): ?>
                    <div class="no-orders">
                        <p>Jums vēl nav neviens pasūtījums.</p>
                        <a href="index.php" class="btn btn-primary">Sākt iepirkties</a>
                    </div>
                <?php else: ?>
                    <?php foreach ($orders as $order): ?>
                        <div class="order-card">
                            <div class="order-header">
                                <div class="order-info">
                                    <h3>Pasūtījums #<?= str_pad($order['id'], 3, '0', STR_PAD_LEFT) ?></h3>
                                    <span class="order-date"><?= date('d.m.Y H:i', strtotime($order['date'])) ?></span>
                                </div>
                                <div class="order-status">
                                    <span class="order-total">€<?= number_format($order['total_amount'], 2) ?></span>
                                </div>
                            </div>

                            <div class="order-items">
                                <table class="items-table">
                                    <thead>
                                        <tr>
                                            <th>Spēle</th>
                                            <th>Platforma</th>
                                            <th>Atslēga</th>
                                            <th>Cena</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($order['items'] as $item): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($item['product_name']) ?></td>
                                                <td><?= htmlspecialchars($item['platform']) ?></td>
                                                <td>
                                                    <?php if (!empty($item['keys'])): ?>
                                                        <div class="key-list">
                                                            <?php 
                                                            foreach ($item['keys'] as $encrypted_key): 
                                                                $key = null;
                                                                if (!empty($encrypted_key)) {
                                                                    decryptKey();
                                                                    echo '<span class="key-value">' . htmlspecialchars($key) . '</span>';
                                                                }
                                                            endforeach; 
                                                            ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </td>
                                                <td>€<?= number_format($item['price'], 2) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

<?php require_once 'includes/footer.php'; ?>