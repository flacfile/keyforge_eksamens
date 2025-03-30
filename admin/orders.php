<?php
$page_title = 'Pasūtījumu pārvaldība';
$current_page = 'orders';
require_once 'includes/header.php';
?>

<div class="content-body">
    <!-- Filters and Search -->
    <div class="filters-section">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Meklēt pēc pasūtījuma ID vai e-pasta...">
        </div>
        <div class="filters">
            <select class="filter-select">
                <option value="">Visi statusi</option>
                <option value="pending">Gaida apstiprinājumu</option>
                <option value="processing">Apstrādē</option>
                <option value="completed">Pabeigts</option>
                <option value="cancelled">Atcelts</option>
            </select>
            <select class="filter-select">
                <option value="">Visi datumi</option>
                <option value="today">Šodien</option>
                <option value="week">Šonedēļ</option>
                <option value="month">Šomēnes</option>
            </select>
        </div>
    </div>

    <div class="table-container">
        <table class="orders-table">
            <thead>
                <tr>
                    <th>Pasūtījuma ID</th>
                    <th>Datums</th>
                    <th>Klients</th>
                    <th>Produkti</th>
                    <th>Kopējā summa</th>
                    <th>Status</th>
                    <th>Darbības</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>#ORD-001</td>
                    <td>
                        <div class="date-info">
                            <span class="date">13.03.2025</span>
                            <span class="time">19:30</span>
                        </div>
                    </td>
                    <td>
                        <div class="customer-info">
                            <span class="name">Jānis Bērziņš</span>
                            <span class="email">janis@example.com</span>
                        </div>
                    </td>
                    <td>
                        <div class="order-products">
                            <span class="product">Red Dead Redemption 2 (Steam)</span>
                            <span class="quantity">x1</span>
                        </div>
                    </td>
                    <td>€59.99</td>
                    <td>
                        <span class="status-badge pending">Pabeigts</span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-icon">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn-icon">
                                <i class="fas fa-edit"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="pagination">
        
    </div>
</div>

<?php require_once 'includes/footer.php'; ?> 