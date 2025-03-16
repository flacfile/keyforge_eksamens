<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Pasūtījumi</title>
    <link rel="stylesheet" href="../assets/css/variables.css">
    <link rel="stylesheet" href="../assets/css/admin/dashboard.css">
    <link rel="stylesheet" href="../assets/css/admin/orders.css">
    <link rel="stylesheet" href="../assets/css/admin/products.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="admin-container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2><a href="../index.php" class="company-name">KeyForge</a></h2>
            </div>
            <nav class="sidebar-nav">
                <a href="dashboard.php" class="nav-item">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
                <a href="products.php" class="nav-item">
                    <i class="fas fa-gamepad"></i>
                    <span>Produkti</span>
                </a>
                <a href="orders.php" class="nav-item active">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Pasūtījumi</span>
                </a>
                <a href="users.php" class="nav-item">
                    <i class="fas fa-users"></i>
                    <span>Lietotāji</span>
                </a>
                <a href="settings.php" class="nav-item">
                    <i class="fas fa-cog"></i>
                    <span>Iestatījumi</span>
                </a>
            </nav>
        </aside>

        <main class="main-content">
            <header class="content-header">
                <div class="header-left">
                    <h1>Pasūtījumu pārvaldība</h1>
                </div>
                <div class="header-right">
                    <div class="admin-profile">
                        <span>Admin User</span>
                        <a href="logout.php" class="logout-btn">
                            <i class="fas fa-sign-out-alt"></i>
                        </a>
                    </div>
                </div>
            </header>

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

                <!-- Pagination -->
                <div class="pagination">
                    <button class="btn-page"><i class="fas fa-chevron-left"></i></button>
                    <button class="btn-page active">1</button>
                    <button class="btn-page">2</button>
                    <button class="btn-page">3</button>
                    <button class="btn-page"><i class="fas fa-chevron-right"></i></button>
                </div>
            </div>
        </main>
    </div>
</body>
</html> 