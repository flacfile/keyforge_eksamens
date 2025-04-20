<?php
require_once '../assets/functionality/db.php';

$page_title = 'Pasūtījuma detaļas';
$current_page = 'orders';

$order_id = $_GET['id'] ?? 0;

$query = "
    SELECT 
        orders.*,
        users.name,
        users.email
    FROM orders
    JOIN users ON orders.user_id = users.id
    WHERE orders.id = ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if (!$order) {
    header('Location: orders.php');
    exit;
}

// Get order items
$query = "
    SELECT 
        order_items.*,
        products.name as product_name,
        products.platform
    FROM order_items
    JOIN products ON order_items.product_id = products.id
    WHERE order_items.order_id = ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$items = $stmt->get_result();

// Get game keys for products, which are in this order
$query = "
    SELECT 
        gk.*,
        p.name as product_name,
        p.platform,
        oi.order_id
    FROM game_keys gk
    JOIN products p ON gk.product_id = p.id
    JOIN order_items oi ON oi.product_id = gk.product_id
    WHERE oi.order_id = ?
    AND gk.status = 'sold'
    AND gk.updated_at >= oi.created_at
    AND gk.updated_at <= DATE_ADD(oi.created_at, INTERVAL 1 MINUTE)
    ORDER BY p.name, gk.created_at
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$keys = $stmt->get_result();
?>

<?php require_once 'includes/header.php'; ?>
    <div class="admin-container">
        <div class="admin-content">
            <div class="order-header">
                <h1>
                    <i class="fas fa-file-invoice"></i> 
                    Pasūtījums #<?= str_pad($order['id'], 3, '0', STR_PAD_LEFT) ?>
                </h1>
                <div class="order-actions">
                    <a href="orders.php" class="btn btn-primary">
                        <i class="fas fa-arrow-left"></i> Atpakaļ
                    </a>
                </div>
            </div>

            <div class="order-details-container">
                <div class="order-info-section">
                    <div class="order-info">
                        <h2>Pasūtījuma informācija</h2>
                        <div class="info-group">
                            <label>Status:</label>
                            <span class="status-badge status-<?= $order['status'] ?>">
                                <?= ucfirst($order['status']) ?>
                            </span>
                        </div>
                        <div class="info-group">
                            <label>Datums:</label>
                            <div class="date-time">
                                <span class="date"><?= date('d.m.Y', strtotime($order['created_at'])) ?></span>
                                <span class="time"><?= date('H:i', strtotime($order['created_at'])) ?></span>
                            </div>
                        </div>
                        <div class="info-group">
                            <label>Kopējā summa:</label>
                            <span class="price">€<?= number_format($order['total_amount'], 2) ?></span>
                        </div>
                    </div>

                    <div class="customer-info">
                        <h2>Klienta informācija</h2>
                        <div class="info-group">
                            <label>Lietotājvārds:</label>
                            <span><?= htmlspecialchars($order['name']) ?></span>
                        </div>
                        <div class="info-group">
                            <label>E-pasts:</label>
                            <span><?= htmlspecialchars($order['email']) ?></span>
                        </div>
                    </div>
                </div>

                <div class="order-items">
                    <h2>Pasūtītās preces</h2>
                    <table class="items-table">
                        <thead>
                            <tr>
                                <th>Prece</th>
                                <th>Platforma</th>
                                <th>Daudzums</th>
                                <th>Cena</th>
                                <th>Kopā</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($item = $items->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($item['product_name']) ?></td>
                                    <td><?= htmlspecialchars($item['platform']) ?></td>
                                    <td><?= $item['quantity'] ?></td>
                                    <td class="price">€<?= number_format($item['price'], 2) ?></td>
                                    <td class="total">€<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

                <div class="order-items">
                    <h2>Spēļu atslēgas</h2>
                    <table class="items-table">
                        <thead>
                            <tr>
                                <th>Spēle</th>
                                <th>Platforma</th>
                                <th>Atslēga</th>
                                <th>Datums</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($key = $keys->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($key['product_name']) ?></td>
                                    <td><?= htmlspecialchars($key['platform']) ?></td>
                                    <td class="key-value">
                                        <div class="game-key">
                                            <i class="fas fa-key"></i>
                                            <span><?= htmlspecialchars($key['key']) ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="date-time">
                                            <span class="date"><?= date('d.m.Y', strtotime($key['created_at'])) ?></span>
                                            <span class="time"><?= date('H:i', strtotime($key['created_at'])) ?></span>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php require_once 'includes/footer.php'; ?>

