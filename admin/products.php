<?php
$page_title = 'Produktu pārvaldība';
$current_page = 'products';
require_once 'includes/header.php';
require_once '../assets/functionality/db.php';

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

$platform_filter = $_GET['platform'] ?? '';
$genre_filter = $_GET['genre'] ?? '';
$search = $_GET['search'] ?? '';

$query = "SELECT * FROM products";

$where_conditions = [];
$params = [];

if ($search) {
    $where_conditions[] = "(name LIKE ?)";
    $params[] = "%$search%";
}

if ($platform_filter) {
    $where_conditions[] = "platform = ?";
    $params[] = $platform_filter;
}

if ($genre_filter) {
    $where_conditions[] = "genre = ?";
    $params[] = $genre_filter;
}

if (!empty($where_conditions)) {
    $query .= " WHERE " . implode(" AND ", $where_conditions);
}

$query .= " ORDER BY created_at DESC";

$stmt = $conn->prepare($query);
if (!empty($params)) {
    $stmt->bind_param(str_repeat('s', count($params)), ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="content-body">
    <!-- Filters and Search -->
    <div class="filters-section">
        <form method="GET" class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" name="search" placeholder="Meklēt produktus..." value="<?= htmlspecialchars($search) ?>">
        </form>
        <form method="GET" class="filters">
            <?php if ($search): ?>
                <input type="hidden" name="search" value="<?= htmlspecialchars($search) ?>">
            <?php endif; ?>
            <select name="platform" class="filter-select" onchange="this.form.submit()">
                <option value="">Visas platformas</option>
                <?php foreach ($platforms as $platform): ?>
                    <option value="<?= htmlspecialchars($platform) ?>" <?= $platform_filter === $platform ? 'selected' : '' ?>>
                        <?= htmlspecialchars($platform) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <select name="genre" class="filter-select" onchange="this.form.submit()">
                <option value="">Visi žanri</option>
                <?php foreach ($genres as $genre): ?>
                    <option value="<?= htmlspecialchars($genre) ?>" <?= $genre_filter === $genre ? 'selected' : '' ?>>
                        <?= htmlspecialchars($genre) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="button" class="btn btn-primary-save" onclick="showAddProductModal()">
                <i class="fas fa-plus"></i> Pievienot produktu
            </button>
        </form>
    </div>

    <!-- Products Table -->
    <div class="table-container">
        <table class="products-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Attēls</th>
                    <th>Nosaukums</th>
                    <th>Platforma</th>
                    <th>Cena</th>
                    <th>Pieejamās atslēgas</th>
                    <th>Status</th>
                    <th>Darbības</th>
                </tr>
            </thead>      
            <tbody>
                <?php while ($product = $result->fetch_assoc()): ?>
                <tr>
                    <td>#<?= str_pad($product['id'], 3, '0', STR_PAD_LEFT) ?></td>
                    <td>
                        <img src="<?= '../' . htmlspecialchars($product['main_image_path']) ?>" 
                             alt="<?= htmlspecialchars($product['image_alt'] ?? $product['name']) ?>" 
                             class="game-thumbnail">
                    </td>
                    <td><?= htmlspecialchars($product['name']) ?></td>
                    <td><?= htmlspecialchars($product['platform']) ?></td>
                    <td>
                        €<?= number_format($product['price_eur'], 2) ?>
                    </td>
                    <td><?= $product['number_of_keys'] ?? 0 ?></td>
                    <td>
                        <span class="status-badge <?= $product['status'] ?>">
                            <?= $product['status'] === 'active' ? 'Aktīvs' : 'Neaktīvs' ?>
                        </span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-icon" onclick="editProduct(<?= $product['id'] ?>)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-icon" onclick="manageKeys(<?= $product['id'] ?>)">
                                <i class="fas fa-key"></i>
                            </button>
                            <form action="functionality/update_product_status.php" method="POST" style="display: inline;">
                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                <input type="hidden" name="status" value="<?= $product['status'] === 'active' ? 'inactive' : 'active' ?>">
                                <button type="submit" class="btn-icon <?= $product['status'] === 'active' ? 'warning' : 'success' ?>" 
                                        onclick="return confirm('Vai tiešām vēlaties <?= $product['status'] === 'active' ? 'deaktivizēt' : 'aktivizēt' ?> šo produktu?');">
                                    <i class="fas fa-<?= $product['status'] === 'active' ? 'ban' : 'check' ?>"></i>
                                </button>
                            </form>
                            <form action="functionality/delete_product.php" method="POST" style="display: inline;">
                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                <button type="submit" class="btn-icon warning" onclick="return confirm('Vai tiešām vēlaties izdzēst šo produktu?');">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div class="pagination">

    </div>
</div>

<!-- Add Product Modal -->
<div id="addProductModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Pievienot jaunu produktu</h2>
            <span class="close"><a href="products.php">&times;</a></span>
        </div>
        <div class="modal-body">
            <form action="functionality/add_product.php" method="POST" enctype="multipart/form-data" class="modal-form">
                <div class="form-group">
                    <label for="name">Nosaukums</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="description">Apraksts</label>
                    <textarea id="description" name="description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="price_eur">Cena (EUR)</label>
                    <input type="number" id="price_eur" name="price_eur" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="platform">Platforma</label>
                    <select id="platform" name="platform" required>
                        <option value="">Izvēlieties platformu</option>
                        <?php foreach ($platforms as $platform): ?>
                            <option value="<?= htmlspecialchars($platform) ?>"><?= htmlspecialchars($platform) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="genre">Žanrs</label>
                    <select id="genre" name="genre" required>
                        <option value="">Izvēlieties žanru</option>
                        <?php foreach ($genres as $genre): ?>
                            <option value="<?= htmlspecialchars($genre) ?>"><?= htmlspecialchars($genre) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="main_image">Galvenā bilde</label>
                    <input type="file" id="main_image" name="main_image" accept="image/*" required>
                </div>
                <div class="form-group">
                    <label for="image_alt">Bildes alternatīvais teksts</label>
                    <input type="text" id="image_alt" name="image_alt" required>
                </div>
                <div class="form-group">
                    <label for="cpu">CPU</label>
                    <input type="text" id="cpu" name="cpu" required>
                </div>
                <div class="form-group">
                    <label for="gpu">GPU</label>
                    <input type="text" id="gpu" name="gpu" required>
                </div>
                <div class="form-group">
                    <label for="ram">RAM</label>
                    <input type="text" id="ram" name="ram" required>
                </div>
                <div class="form-group">
                    <label for="storage">Storage</label>
                    <input type="text" id="storage" name="storage" required>
                </div>
                <div class="form-actions">
                    <a href="products.php" class="btn btn-secondary">Atcelt</a>
                    <button type="submit" class="btn btn-primary">Saglabāt</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Import Keys Modal -->
<!-- <div class="modal" id="importModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Importēt atslēgas</h2>
            <button class="close-modal">&times;</button>
        </div>
        <div class="modal-body">
            <form id="importForm">
                <div class="form-group">
                    <label>Produkts</label>
                    <select name="product" required>
                        <option value="">Izvēlieties produktu</option>
                        <option value="1">The Witcher 3</option>
                        <option value="2">Cyberpunk 2077</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>CSV fails</label>
                    <input type="file" name="csv_file" accept=".csv" required>
                </div>
                <div class="form-info">
                    <p>CSV faila formāts:</p>
                    <code>product_id,key</code>
                    <p>Piemērs: 01,XXXXX-XXXXX-XXXXX</p>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">Atcelt</button>
                    <button type="submit" class="btn btn-primary">Importēt</button>
                </div>
            </form>
        </div>
    </div>
</div> -->

<!-- Edit Product Modal -->
<div id="editProductModal" class="modal" <?= (isset($_GET['edit']) && isset($_SESSION['edit_product'])) ? 'style="display: block;"' : '' ?>>
    <div class="modal-content">
        <div class="modal-header">
            <h2>Rediģēt produktu</h2>
            <span class="close"><a href="products.php">&times;</a></span>
        </div>
        <form action="functionality/update_product_info.php" method="POST" class="modal-form" enctype="multipart/form-data">
            <input type="hidden" name="product_id" value="<?= $_SESSION['edit_product']['id'] ?? '' ?>">
            
            <div class="form-group">
                <label for="edit_name">Nosaukums</label>
                <input type="text" id="edit_name" name="name" value="<?= htmlspecialchars($_SESSION['edit_product']['name'] ?? '') ?>" required>
            </div>
            
            <div class="form-group">
                <label for="edit_description">Apraksts</label>
                <textarea id="edit_description" name="description" required><?= htmlspecialchars($_SESSION['edit_product']['description'] ?? '') ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="edit_price_eur">Cena (EUR)</label>
                <input type="number" id="edit_price_eur" name="price_eur" step="0.01" min="0" value="<?= htmlspecialchars($_SESSION['edit_product']['price_eur'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label for="edit_platform">Platforma</label>
                <select id="edit_platform" name="platform" required>
                    <?php foreach ($platforms as $p): ?>
                        <option value="<?= htmlspecialchars($p) ?>" <?= ($_SESSION['edit_product']['platform'] ?? '') === $p ? 'selected' : '' ?>>
                            <?= htmlspecialchars($p) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="edit_genre">Žanrs</label>
                <select id="edit_genre" name="genre" required>
                    <?php foreach ($genres as $g): ?>
                        <option value="<?= htmlspecialchars($g) ?>" <?= ($_SESSION['edit_product']['genre'] ?? '') === $g ? 'selected' : '' ?>>
                            <?= htmlspecialchars($g) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="edit_main_image">Galvenais attēls</label>
                <input type="file" id="edit_main_image" name="main_image" accept="image/jpeg,image/png,image/webp">
                <small class="form-text text-muted">Atstājiet tukšu, lai saglabātu esošo attēlu. Atļautie formāti: JPG, PNG, WEBP (max 5MB)</small>
            </div>
            
            <div class="form-group">
                <label for="edit_image_alt">Attēla alt teksts</label>
                <input type="text" id="edit_image_alt" name="image_alt" value="<?= htmlspecialchars($_SESSION['edit_product']['image_alt'] ?? '') ?>" required>
            </div>
            
            <div class="form-group">
                <label for="edit_cpu">CPU</label>
                <input type="text" id="edit_cpu" name="cpu" value="<?= htmlspecialchars($_SESSION['edit_product']['cpu'] ?? '') ?>" required>
            </div>
            
            <div class="form-group">
                <label for="edit_gpu">GPU</label>
                <input type="text" id="edit_gpu" name="gpu" value="<?= htmlspecialchars($_SESSION['edit_product']['gpu'] ?? '') ?>" required>
            </div>
            
            <div class="form-group">
                <label for="edit_ram">RAM</label>
                <input type="text" id="edit_ram" name="ram" value="<?= htmlspecialchars($_SESSION['edit_product']['ram'] ?? '') ?>" required>
            </div>
            
            <div class="form-group">
                <label for="edit_storage">Storage</label>
                <input type="text" id="edit_storage" name="storage" value="<?= htmlspecialchars($_SESSION['edit_product']['storage'] ?? '') ?>" required>
            </div>

            <div class="form-actions">
                <a href="products.php" class="btn btn-secondary">Atcelt</a>
                <button type="submit" class="btn btn-primary-save">Saglabāt</button>
            </div>
        </form>
    </div>
</div>
<script src="js/pagination.js"></script>
<script src="js/products.js"></script>
<?php require_once 'includes/footer.php'; ?> 