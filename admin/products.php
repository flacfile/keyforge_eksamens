<?php
$page_title = 'Produktu pārvaldība';
$current_page = 'products';
require_once 'includes/header.php';
?>

<div class="content-body">
    <!-- Filters and Search -->
    <div class="filters-section">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Meklēt produktus...">
        </div>
        <div class="filters">
            <select class="filter-select">
                <option value="">Visas platformas</option>
                <option value="steam">Steam</option>
                <option value="origin">Origin</option>
                <option value="ubisoft">Ubisoft Connect</option>
                <option value="epic">Epic Games</option>
            </select>
            <select class="filter-select">
                <option value="">Visi žanri</option>
                <option value="action">Action</option>
                <option value="rpg">RPG</option>
                <option value="strategy">Strategy</option>
                <option value="sports">Sports</option>
            </select>
        </div>
    </div>

    <!-- Products Table -->
    <div class="table-container">
        <table class="products-table">
            <thead>
                <tr>
                    <th><input type="checkbox" id="selectAll"></th>
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
                <tr>
                    <td><input type="checkbox" class="product-select"></td>
                    <td>#01</td>
                    <td><img src="../assets/images/product1.jpg" alt="Game" class="game-thumbnail"></td>
                    <td>Red dead redemption 2</td>
                    <td>Steam</td>
                    <td>€99.99</td>
                    <td>45</td>
                    <td><span class="status-badge active">Aktīvs</span></td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-icon" onclick="editProduct()">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-icon" onclick="manageKeys()">
                                <i class="fas fa-key"></i>
                            </button>
                            <button class="btn-icon" onclick="changeStatus()">
                                <i class="">statuss noamina</i>
                            </button>
                            <button class="btn-icon delete" onclick="deleteProduct()">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <button class="btn btn-secondary" onclick="openImportModal()">
                        <i class="fas fa-file-import"></i> Importēt atslēgas
                    </button>
    <!-- Pagination -->
    <div class="pagination">
        <button class="btn-page"><i class="fas fa-chevron-left"></i></button>
        <button class="btn-page active">1</button>
        <button class="btn-page">2</button>
        <button class="btn-page">3</button>
        <button class="btn-page"><i class="fas fa-chevron-right"></i></button>
    </div>
</div>

<!-- Import Keys Modal -->
<div class="modal" id="importModal">
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
</div>

<?php require_once 'includes/footer.php'; ?> 