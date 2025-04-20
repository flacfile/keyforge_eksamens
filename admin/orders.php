<?php
require_once '../assets/functionality/db.php';

$query = "
    SELECT 
        orders.id,
        orders.user_id,
        users.name,
        orders.total_amount,
        orders.status,
        orders.created_at,
        COUNT(order_items.id) as item_count
    FROM orders
    JOIN users ON orders.user_id = users.id
    LEFT JOIN order_items ON orders.id = order_items.order_id
    GROUP BY orders.id
    ORDER BY orders.created_at DESC
";

$result = $conn->query($query);
?>
<?php
$page_title = 'Pasūtījumi';
$current_page = 'orders';
require_once 'includes/header.php'; ?>            
            <div class="table-container">
                <table class="users-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Lietotājs</th>
                            <th>Summa</th>
                            <th>Status</th>
                            <th>Preces</th>
                            <th>Datums</th>
                            <th>Darbības</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($order = $result->fetch_assoc()): ?>
                            <tr>
                                <td>#<?= str_pad($order['id'], 3, '0', STR_PAD_LEFT) ?></td>
                                <td><?= htmlspecialchars($order['name']) ?></td>
                                <td>€<?= number_format($order['total_amount'], 2) ?></td>
                                <td>
                                    <span class="status-badge status-<?= $order['status'] ?>">
                                        <?= ucfirst($order['status']) ?>
                                    </span>
                                </td>
                                <td><?= $order['item_count'] ?></td>
                                <td>
                                <div class="date-info">
                                    <span class="date"><?= date('d.m.Y', strtotime($order['created_at'])) ?></span>
                                    <span class="time"><?= date('H:i', strtotime($order['created_at'])) ?></span>
                                </div>
                                </td>
                                <td>
                                    <a href="order_details.php?id=<?= $order['id'] ?>" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i> Skatīt
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <div class="pagination">
        
            </div>
            <script src="js/pagination.js"></script>

 