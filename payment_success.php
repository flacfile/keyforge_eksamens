<?php
session_start();
require_once 'assets/functionality/db.php';

// Get the latest order for the current user
$stmt = $conn->prepare("
    WITH latest_order AS (
        SELECT id 
        FROM orders 
        WHERE user_id = ? AND status = 'completed'
        ORDER BY created_at DESC
        LIMIT 1
    )
    SELECT orders.id, 
           orders.total_amount, 
           orders.created_at, 
           products.name as product_name, 
           game_keys.key
    FROM orders
    JOIN latest_order ON orders.id = latest_order.id
    JOIN order_items ON orders.id = order_items.order_id
    JOIN products ON order_items.product_id = products.id
    JOIN game_keys ON game_keys.product_id = products.id AND game_keys.status = 'sold'
    WHERE game_keys.updated_at >= orders.created_at
    ORDER BY products.name ASC, game_keys.id ASC
");

$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paldies par pirkumu!</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/pages/payment_success.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<?php
require_once 'includes/header.php';
?>

<div class="container-payment-success">
    <div class="success-message">
        <h1>Paldies par pirkumu!</h1>
        <p>Jūsu pasūtījums ir veiksmīgi apstrādāts.</p>
    </div>

    <?php if ($result->num_rows > 0): ?>
        <div class="order-details">
            <h2>Jūsu iegādātās spēļu atslēgas:</h2>
            <div class="keys-list">
                <?php
                $current_product = '';
                while ($row = $result->fetch_assoc()):
                    if ($current_product !== $row['product_name']):
                        if ($current_product !== ''): ?>
                    </div>
                    </div><?php
                        endif;
                        $current_product = $row['product_name'];
                        ?>
                        <div class="product-keys">
                        <h3><?= htmlspecialchars($row['product_name']) ?></h3>
                        <div class="keys">
                    <?php endif; ?>
                    <div class="key-item">
                        <span class="key-code"><?= htmlspecialchars($row['key']) ?></span>
                    </div>
                <?php endwhile;
                if ($current_product !== ''): ?>
                    </div></div>
                <?php endif; ?>
            </div>
        </div>
    <?php else: ?>
        <div class="error-message">
            <p>Nav atrasts neviens pasūtījums.</p>
        </div>
    <?php endif; ?>

    <div class="action-buttons">
        <a href="index.php" class="btn btn-primary">Atgriezties uz sākumlapu</a>
        <a href="products.php" class="btn btn-secondary">Turpināt iepirkties</a>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?> 