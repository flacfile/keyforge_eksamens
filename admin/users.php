<?php
$page_title = 'Lietotāju pārvaldība';
$current_page = 'users';
require_once 'includes/header.php';
require_once '../assets/functionality/db.php';

// Get filters from URL parameters
$role_filter = $_GET['role'] ?? '';
$status_filter = $_GET['status'] ?? '';
$search = $_GET['search'] ?? '';

$query = "SELECT u.*, r.name as role_name, 
          COUNT(DISTINCT o.id) as order_count,
          COALESCE(SUM(o.product_price), 0) as total_spent
          FROM users u 
          LEFT JOIN roles r ON u.role_id = r.id
          LEFT JOIN orders o ON u.id = o.user_id";

$where_conditions = [];
$params = [];

if ($search) {
    $where_conditions[] = "(u.name LIKE ? OR u.email LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

if ($role_filter) {
    $where_conditions[] = "r.name = ?";
    $params[] = $role_filter;
}

if ($status_filter) {
    $where_conditions[] = "u.status = ?";
    $params[] = $status_filter;
}

if (!empty($where_conditions)) {
    $query .= " WHERE " . implode(" AND ", $where_conditions);
}

$query .= " GROUP BY u.id ORDER BY u.created_at DESC";

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
            <input type="text" name="search" placeholder="Meklēt pēc vārda vai e-pasta..." value="<?= htmlspecialchars($search) ?>">
        </form>
        <form method="GET" class="filters">
            <?php if ($search): ?>
                <input type="hidden" name="search" value="<?= htmlspecialchars($search) ?>">
            <?php endif; ?>
            <select name="role" class="filter-select" onchange="this.form.submit()">
                <option value="">Visas lomas</option>
                <option value="admin" <?= $role_filter === 'admin' ? 'selected' : '' ?>>Administrators</option>
                <option value="client" <?= $role_filter === 'client' ? 'selected' : '' ?>>Lietotājs</option>
            </select>
            <select name="status" class="filter-select" onchange="this.form.submit()">
                <option value="">Visi statusi</option>
                <option value="active" <?= $status_filter === 'active' ? 'selected' : '' ?>>Aktīvs</option>
                <option value="blocked" <?= $status_filter === 'blocked' ? 'selected' : '' ?>>Bloķēts</option>
            </select>
            <button type="button" class="btn btn-primary" onclick="document.getElementById('addUserModal').style.display='block'">
                <i class="fas fa-plus"></i> Pievienot lietotāju
            </button>
        </form>
    </div>

    <!-- Users Table -->
    <div class="table-container">
        <table class="users-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Lietotājs</th>
                    <th>Reģistrācijas datums</th>
                    <th>Pasūtījumi</th>
                    <th>Loma</th>
                    <th>Status</th>
                    <th>Darbības</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($user = $result->fetch_assoc()): ?>
                <tr>
                    <td>#<?= str_pad($user['id'], 3, '0', STR_PAD_LEFT) ?></td>
                    <td>
                        <div class="user-info">
                            <div class="user-details">
                                <span class="name"><?= htmlspecialchars($user['name']) ?></span>
                                <span class="email"><?= htmlspecialchars($user['email']) ?></span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="date-info">
                            <span class="date"><?= date('d.m.Y', strtotime($user['created_at'])) ?></span>
                            <span class="time"><?= date('H:i', strtotime($user['created_at'])) ?></span>
                        </div>
                    </td>
                    <td>
                        <div class="user-stats">
                            <span class="orders-count"><?= $user['order_count'] ?> pasūtījumi</span>
                            <span class="total-spent">€<?= number_format($user['total_spent'], 2) ?> kopā</span>
                        </div>
                    </td>
                    <td>
                        <span class="role-badge <?= $user['role_name'] ?>"><?= $user['role_name'] === 'admin' ? 'Administrators' : 'Lietotājs' ?></span>
                    </td>
                    <td>
                        <span class="status-badge <?= $user['status'] ?>"><?= ucfirst($user['status']) ?></span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-icon" onclick="viewUser(<?= $user['id'] ?>)">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn-icon" onclick="editUser(<?= $user['id'] ?>)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <?php if ($user['status'] === 'active'): ?>
                                <form action="functionality/update_user_status.php" method="POST" style="display: inline;">
                                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                    <input type="hidden" name="status" value="blocked">
                                    <button type="submit" class="btn-icon warning" onclick="return confirm('Vai tiešām vēlaties bloķēt šo lietotāju?');">
                                        <i class="fas fa-ban"></i>
                                    </button>
                                </form>
                            <?php else: ?>
                                <form action="functionality/update_user_status.php" method="POST" style="display: inline;">
                                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                    <input type="hidden" name="status" value="active">
                                    <button type="submit" class="btn-icon success" onclick="return confirm('Vai tiešām vēlaties atbloķēt šo lietotāju?');">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
    <div class="pagination">
        
    </div>

<!-- Edit User Modal -->
<div id="editUserModal" class="modal" <?= (isset($_GET['edit']) && isset($_SESSION['edit_user'])) ? 'style="display: block;"' : '' ?>>
    <div class="modal-content">
        <div class="modal-header">
            <h2>Rediģēt lietotāju</h2>
            <span class="close"><a href="users.php">&times;</a></span>
        </div>
        <form action="functionality/update_user_info.php" method="POST" class="modal-form">
            <input type="hidden" name="user_id" value="<?= $_SESSION['edit_user']['id'] ?? '' ?>">
            <div class="form-group">
                <label for="edit_name">Lietotājvārds</label>
                <input type="text" id="edit_name" name="name" value="<?= htmlspecialchars($_SESSION['edit_user']['name'] ?? '') ?>" required>
            </div>
            
            <div class="form-group">
                <label for="edit_email">E-pasts</label>
                <input type="email" id="edit_email" name="email" value="<?= htmlspecialchars($_SESSION['edit_user']['email'] ?? '') ?>" required>
            </div>
            
            <div class="form-group">
                <label for="edit_password">Parole (atstājiet tukšu, lai saglabātu esošo)</label>
                <input type="password" id="edit_password" name="password" minlength="3">
                <small class="form-text text-muted">Minimālais garums: 3 simboli</small>
            </div>
            
            <div class="form-group">
                <label for="edit_role">Loma</label>
                <select id="edit_role" name="role_id">
                    <option value="1" <?= ($_SESSION['edit_user']['role_id'] ?? '') == 1 ? 'selected' : '' ?>>Administrators</option>
                    <option value="2" <?= ($_SESSION['edit_user']['role_id'] ?? '') == 2 ? 'selected' : '' ?>>Lietotājs</option>
                </select>
            </div>
            <div class="form-actions">
                <a href="users.php" class="btn btn-secondary">Atcelt</a>
                <button type="submit" class="btn btn-primary">Saglabāt</button>
            </div>
        </form>
    </div>
</div>

<!-- Add User Modal -->
<div id="addUserModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Pievienot jaunu lietotāju</h2>
            <span class="close"><a href="users.php">&times;</a></span>
        </div>
        <form action="functionality/add_user.php" method="POST" class="modal-form">
            <div class="form-group">
                <label for="name">Lietotājvārds</label>
                <input type="text" id="name" name="name" required>
            </div>
            
            <div class="form-group">
                <label for="email">E-pasts</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="password">Parole</label>
                <input type="password" id="password" name="password" minlength="3" required>
                <small class="form-text text-muted">Minimālais garums: 3 simboli</small>
            </div>
            
            <div class="form-group">
                <label for="role">Loma</label>
                <select id="role" name="role_id">
                    <option value="2">Lietotājs</option>
                    <option value="1">Administrators</option>
                </select>
            </div>

            <div class="form-actions">
                <a href="users.php" class="btn btn-secondary">Atcelt</a>
                <button type="submit" class="btn btn-primary">Pievienot</button>
            </div>
        </form>
    </div>
</div>

<script src="js/users.js"></script>
<script src="js/pagination.js"></script>
</body>
</html>

