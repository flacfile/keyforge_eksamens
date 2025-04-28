<?php
require_once 'assets/functionality/db.php';
session_start();

$product_id = $_GET['id'] ?? null;

if (!$product_id) {
    header('Location: products.php');
    exit();
}

$stmt = $conn->prepare("SELECT * FROM products WHERE id = ? AND status = 'active'");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header('Location: products.php');
    exit();
}

$product = $result->fetch_assoc();

// Fetch reviews for this product
$reviews = [];
$avg_rating = 0;

$review_query = "
    SELECT reviews.*, users.name AS reviewer_name
    FROM reviews
    JOIN users ON reviews.user_id = users.id
    WHERE reviews.product_id = ?
    ORDER BY reviews.created_at DESC
";
$stmt = $conn->prepare($review_query);
$stmt->bind_param('i', $product_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $reviews[] = $row;
}

// avg rating
$avg_query = "SELECT AVG(rating) as avg_rating FROM reviews WHERE product_id = ?";
$stmt = $conn->prepare($avg_query);
$stmt->bind_param('i', $product_id);
$stmt->execute();
$avg_result = $stmt->get_result();
$avg_rating = round($avg_result->fetch_assoc()['avg_rating'] ?? 0, 2);

// review submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['review_content'], $_POST['review_rating']) && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $content = trim($_POST['review_content']);
    $rating = (int)$_POST['review_rating'];

    $check_stmt = $conn->prepare("SELECT id FROM reviews WHERE product_id = ? AND user_id = ?");
    $check_stmt->bind_param('ii', $product_id, $user_id);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows === 0 && $rating >= 1 && $rating <= 5 && $content !== '') {
        $insert_stmt = $conn->prepare("INSERT INTO reviews (product_id, user_id, rating, content) VALUES (?, ?, ?, ?)");
        $insert_stmt->bind_param('iiis', $product_id, $user_id, $rating, $content);
        $insert_stmt->execute();
        header("Location: product.php?id=$product_id");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KeyForge - Labākas cenas</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <script src="assets/js/script.js"></script>
</head>

<?php
include 'includes/header.php';
?> 

<body>
<div class="product-container">
    <!-- Product Main Section -->

    <div class="product-main">
        <div class="product-image-product">
            <img src="<?= htmlspecialchars($product['main_image_path']) ?>" alt="<?= htmlspecialchars($product['image_alt'] ?? $product['name']) ?>">
        </div>
        
        <div class="product-info">
            <h1 class="product-title-product"><?= htmlspecialchars($product['name']) ?></h1>
            <p class="product-price">€<?= number_format($product['price_eur'], 2) ?></p>
            <p class="product-description">
                <?= htmlspecialchars($product['description']) ?>
            </p>
            
            <form action="assets/functionality/add_to_cart.php" method="POST" class="add-to-cart-form">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn buy-now">
                    <i class="fas fa-shopping-cart"></i> Pievienot grozam
                </button>
            </form>
        </div>
    </div>

    <!-- System Requirements -->
    <div class="system-requirements">
        <h2>Minimālās sistēmas prasības</h2>
        <div class="requirements-grid">
            <div class="requirement">
                <h3>CPU</h3>
                <p><?= htmlspecialchars($product['cpu']) ?></p>
            </div>
            <div class="requirement">
                <h3>GPU</h3>
                <p><?= htmlspecialchars($product['gpu']) ?></p>
            </div>
            <div class="requirement">
                <h3>RAM</h3>
                <p><?= htmlspecialchars($product['ram']) ?></p>
            </div>
            <div class="requirement">
                <h3>Storage</h3>
                <p><?= htmlspecialchars($product['storage']) ?></p>
            </div>
        </div>
    </div>

    <!-- Reviews  -->
    <div class="reviews-section">
        <h2>Atsauksmes</h2>
        <div class="overall-rating">
            <div class="rating"><?= $avg_rating ? $avg_rating . '/5' : 'Nav atsauksmju' ?></div>
            <div class="stars">
                <?php
                $full_stars = floor($avg_rating);
                for ($i = 0; $i < $full_stars; $i++) echo '★';
                for ($i = $full_stars; $i < 5; $i++) echo '☆';
                ?>
            </div>
        </div>

        <?php if (isset($_SESSION['user_id'])): ?>
            <form method="POST" class="review-form">
                <label for="review_rating">Vērtējums:</label>
                <select name="review_rating" id="review_rating" required>
                    <option value="">Izvēlies</option>
                    <?php for ($i = 5; $i >= 1; $i--): ?>
                        <option value="<?= $i ?>"><?= $i ?></option>
                    <?php endfor; ?>
                </select>
                <label for="review_content">Atsauksme:</label>
                <textarea name="review_content" id="review_content" rows="3" required></textarea>
                <button type="submit" class="btn buy-now">Iesniegt</button>
            </form>
        <?php else: ?>
            <p>Lai rakstītu atsauksmi, lūdzu, <a href="login.php">ielogojieties</a>.</p>
        <?php endif; ?>

        <div class="reviews-list">
            <?php if (count($reviews)): ?>
                <?php foreach ($reviews as $review): ?>
                    <div class="review">
                        <div class="review-header">
                            <span class="reviewer-name"><?= htmlspecialchars($review['reviewer_name']) ?></span>
                            <span class="review-date"><?= date('d.m.Y', strtotime($review['created_at'])) ?></span>
                            <div class="review-rating">
                                <?php for ($i = 0; $i < $review['rating']; $i++) echo '★'; ?>
                                <?php for ($i = $review['rating']; $i < 5; $i++) echo '☆'; ?>
                            </div>
                        </div>
                        <p class="review-content"><?= nl2br(htmlspecialchars($review['content'])) ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Nav atsauksmju :(</p>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>

<?php include 'includes/footer.php'; ?> 