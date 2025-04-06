<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produkti</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/pages/products.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <script src="assets/js/products.js"></script>
    <script src="assets/js/script.js"></script>
</head>

<?php 
require_once 'assets/functionality/db.php';
include 'includes/header.php';

// Fetch ENUM values from db
$platforms_query = "SHOW COLUMNS FROM products WHERE Field = 'platform'";
$genres_query = "SHOW COLUMNS FROM products WHERE Field = 'genre'";

$platforms_result = $conn->query($platforms_query);
$genres_result = $conn->query($genres_query);

$platforms = [];
$genres = [];

if ($platforms_result && $platforms_row = $platforms_result->fetch_assoc()) {
    preg_match("/^enum\(\'(.*)\'\)$/", $platforms_row['Type'], $matches);
    $platforms = explode("','", $matches[1]);
}

if ($genres_result && $genres_row = $genres_result->fetch_assoc()) {
    preg_match("/^enum\(\'(.*)\'\)$/", $genres_row['Type'], $matches);
    $genres = explode("','", $matches[1]);
}

// Get filter parameters
$platform_filter = $_GET['platform'] ?? '';
$genre_filter = $_GET['genre'] ?? '';
$price_filter = $_GET['price'] ?? '';

// Build query
$query = "SELECT * FROM products WHERE status = 'active'";
$params = [];

if ($platform_filter) {
    $query .= " AND platform = ?";
    $params[] = $platform_filter;
}

if ($genre_filter) {
    $query .= " AND genre = ?";
    $params[] = $genre_filter;
}

if ($price_filter) {
    switch ($price_filter) {
        case '0-10':
            $query .= " AND price_eur <= 10";
            break;
        case '10-20':
            $query .= " AND price_eur > 10 AND price_eur <= 20";
            break;
        case '20-30':
            $query .= " AND price_eur > 20 AND price_eur <= 30";
            break;
        case '30+':
            $query .= " AND price_eur > 30";
            break;
    }
}

$query .= " ORDER BY created_at DESC";

$stmt = $conn->prepare($query);
if (!empty($params)) {
    $stmt->bind_param(str_repeat('s', count($params)), ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?> 

<body>
    <div class="container">
        <!-- Mobile Filter Toggle -->
        <div class="mobile-filter-toggle">
            <button class="filter-toggle-btn">
                <i class="fas fa-filter"></i> Filtri
            </button>
        </div>
        
        <!-- Filter Sidebar -->
        <aside class="filters">
            <form method="GET" id="filter-form">
                <h2>Filtri</h2>
                
                <div class="filter-section">
                    <h3>Platformas</h3>
                    <div class="filter-options">
                        <label>
                            <input type="radio" name="platform" value="" 
                                <?= empty($platform_filter) ? 'checked' : '' ?>
                                onchange="this.form.submit()">
                            Visas platformas
                        </label>
                        <?php foreach ($platforms as $platform): ?>
                            <label>
                                <input type="radio" name="platform" value="<?= htmlspecialchars($platform) ?>" 
                                    <?= $platform_filter === $platform ? 'checked' : '' ?>
                                    onchange="this.form.submit()">
                                <?= htmlspecialchars($platform) ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <div class="filter-section">
                    <h3>Žanri</h3>
                    <div class="filter-options">
                        <label>
                            <input type="radio" name="genre" value=""
                                <?= empty($genre_filter) ? 'checked' : '' ?>
                                onchange="this.form.submit()">
                            Visi žanri
                        </label>
                        <?php foreach ($genres as $genre): ?>
                            <label>
                                <input type="radio" name="genre" value="<?= htmlspecialchars($genre) ?>"
                                    <?= $genre_filter === $genre ? 'checked' : '' ?>
                                    onchange="this.form.submit()">
                                <?= htmlspecialchars($genre) ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="filter-section">
                    <h3>Cena</h3>
                    <div class="filter-options">
                        <label>
                            <input type="radio" name="price" value="" 
                                <?= empty($price_filter) ? 'checked' : '' ?>
                                onchange="this.form.submit()">
                            Visas cenas
                        </label>
                        <label>
                            <input type="radio" name="price" value="0-10"
                                <?= $price_filter === '0-10' ? 'checked' : '' ?>
                                onchange="this.form.submit()">
                            Līdz 10€
                        </label>
                        <label>
                            <input type="radio" name="price" value="10-20"
                                <?= $price_filter === '10-20' ? 'checked' : '' ?>
                                onchange="this.form.submit()">
                            10€ - 20€
                        </label>
                        <label>
                            <input type="radio" name="price" value="20-30"
                                <?= $price_filter === '20-30' ? 'checked' : '' ?>
                                onchange="this.form.submit()">
                            20€ - 30€
                        </label>
                        <label>
                            <input type="radio" name="price" value="30+"
                                <?= $price_filter === '30+' ? 'checked' : '' ?>
                                onchange="this.form.submit()">
                            Vairāk par 30€
                        </label>
                    </div>
                </div>
            </form>
        </aside>

        <!-- Products Grid -->
        <main class="products">
            <?php while ($product = $result->fetch_assoc()): ?>
                <div class="product-card">
                    <img src="<?= htmlspecialchars($product['main_image_path']) ?>" 
                         alt="<?= htmlspecialchars($product['image_alt'] ?? $product['name']) ?>" 
                         class="product-image-products">
                    <h2 class="product-title"><?= htmlspecialchars($product['name']) ?></h2>
                    <p class="product-description">
                        <?php if ($product['platform'] === 'Steam'): ?>
                            <img src="assets/images/steam.svg" alt="Steam"/>
                        <?php endif; ?>
                        <?php if ($product['platform'] === 'Origin'): ?>
                            <img src="assets/images/origin.svg" alt="Origin"/>
                        <?php endif; ?>
                        <?php if ($product['platform'] === 'Ubisoft Connect'): ?>
                            <img src="assets/images/ubisoft.svg" alt="Ubisoft Connect"/>
                        <?php endif; ?>
                    </p>
                    <div class="product-footer">
                        <span class="product-price">
                            €<?= number_format($product['price_eur'], 2) ?>
                        </span>
                        <a href="product.php?id=<?= $product['id'] ?>" class="buy-button">Pirkt</a>
                    </div>
                </div>
            <?php endwhile; ?>
        </main>
    </div>
    <div class="pagination">
    </div>
    <?php include 'includes/footer.php'; ?>
</body>
</html>

