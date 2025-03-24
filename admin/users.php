<?php
$page_title = 'Lietotāju pārvaldība';
$current_page = 'users';
require_once 'includes/header.php';
?>

<div class="content-body">
    <!-- Filters and Search -->
    <div class="filters-section">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Meklēt pēc vārda vai e-pasta...">
        </div>
        <div class="filters">
            <select class="filter-select">
                <option value="">Visas lomas</option>
                <option value="admin">Administrators</option>
                <option value="user">Lietotājs</option>
            </select>
            <select class="filter-select">
                <option value="">Visi statusi</option>
                <option value="active">Aktīvs</option>
                <option value="inactive">Neaktīvs</option>
                <option value="blocked">Bloķēts</option>
            </select>
        </div>
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
                <tr>
                    <td>#001</td>
                    <td>
                        <div class="user-info">
                            <div class="user-details">
                                <span class="name">Jānis Bērziņš</span>
                                <span class="email">janis@example.com</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="date-info">
                            <span class="date">15.03.2024</span>
                            <span class="time">14:30</span>
                        </div>
                    </td>
                    <td>
                        <div class="user-stats">
                            <span class="orders-count">5 pasūtījumi</span>
                            <span class="total-spent">€299.95 kopā</span>
                        </div>
                    </td>
                    <td>
                        <span class="role-badge user">Lietotājs</span>
                    </td>
                    <td>
                        <span class="status-badge active">Aktīvs</span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-icon">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn-icon">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-icon warning">
                                <i class="fas fa-ban"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="pagination">
        <button class="btn-page"><i class="fas fa-chevron-left"></i></button>
        <button class="btn-page active">1</button>
        <button class="btn-page">2</button>
        <button class="btn-page">3</button>
        <button class="btn-page"><i class="fas fa-chevron-right"></i></button>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?> 