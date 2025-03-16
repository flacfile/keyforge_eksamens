<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Lietotāji</title>
    <link rel="stylesheet" href="../assets/css/variables.css">
    <link rel="stylesheet" href="../assets/css/admin/dashboard.css">
    <link rel="stylesheet" href="../assets/css/admin/users.css">
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
                <a href="orders.php" class="nav-item">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Pasūtījumi</span>
                </a>
                <a href="users.php" class="nav-item active">
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
                    <h1>Lietotāju pārvaldība</h1>
                </div>
                <div class="header-right">
                    <button class="btn btn-primary">
                        <i class="fas fa-user-plus"></i> Pievienot lietotāju
                    </button>
                    <button class="btn btn-secondary">
                        <i class="fas fa-user-minus"></i> Aktivizēt/Deaktivizēt lietotāju
                    </button>
                </div>
            </header>

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
        </main>
    </div>
</body>
</html> 