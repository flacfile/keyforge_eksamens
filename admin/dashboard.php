<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

$page_title = 'Dashboard';
$current_page = 'dashboard';
require_once 'includes/header.php';
require_once 'functionality/dashboard_stats.php';

$stats = getDashboardStats();
$bestSellers = getBestSellers();
$salesData = getSalesData();
$platformData = getPlatformDistribution();
$genreData = getGenreDistribution();

// Prepare data for Chart.js
$chartLabels = [];
$chartData = [];
foreach ($salesData as $data) {
    $chartLabels[] = date('M d', strtotime($data['date']));
    $chartData[] = $data['total'];
}
?>


                <div class="content-body">
                    <div class="dashboard-stats">
                        <div class="stat-card">
                            <i class="fa-solid fa-shop"></i>
                            <div class="stat-info">
                                <h3>Aktīvie produkti</h3>
                                <p><?php echo $stats['total_products']; ?></p>
                            </div>
                        </div>

                        <div class="stat-card">
                            <i class="fas fa-euro-sign"></i>
                            <div class="stat-info">
                                <h3>Mēneša peļņa</h3>
                                <p><?php echo $stats['monthly_sales']; ?> €</p>
                            </div>
                        </div>

                        <div class="stat-card">
                            <i class="fas fa-key"></i>
                            <div class="stat-info">
                                <h3>Pieejamas atslēgas</h3>
                                <p><?php echo $stats['available_keys']; ?> </p>
                            </div>
                        </div>

                        <div class="stat-card">
                            <i class="fa-solid fa-cube"></i>
                            <div class="stat-info">
                                <h3>Šodienas pasūtījumi</h3>
                                <p><?php echo $stats['today_orders']; ?> </p>
                            </div>
                        </div>

                        <div class="stat-card">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <div class="stat-info">
                                <h3>Vidēja pasūtījuma summa</h3>
                                <p><?php echo $stats['avg_order_value']; ?> €</p>
                            </div>
                        </div>

                        <div class="stat-card">
                            <i class="fa-solid fa-box-open"></i>                            
                            <div class="stat-info">
                                <h3>Pasūtījumi kopā</h3>
                                <p><?php echo $stats['completed_orders']; ?> </p>
                            </div>
                        </div>
                    </div>

                <div class="dashboard-charts">
                    <div class="chart-container">
                        <div class="chart-header">
                            <div class="chart-title">Pārdošanas tendences</div>
                        </div>
                        <canvas id="salesChart"></canvas>

                        <div class="chart-header">
                            <div class="chart-title">Cik produkti balstoties uz žanru</div>
                        </div>
                        <canvas id="genreChart"></canvas>
                    </div>

                    <div class="chart-container">
                        <div class="chart-header">
                            <div class="chart-title">Cik aktīvie produkti balstoties uz platformu</div>
                        </div>
                        <canvas id="platformChart"></canvas>
                    </div>
                </div>

                <div class="dashboard-charts">
                    <div class="chart-container">
                        <div class="chart-header">
                            <div class="chart-title">Vispopulārākie produkti (7 dienas)</div>
                        </div>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Produkts</th>
                                    <th>Pārdots</th>
                                    <th>Peļņa</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($bestSellers as $product): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                                    <td><?php echo $product['sales_count']; ?></td>
                                    <td>€<?php echo number_format($product['sales_count'] * $product['price_eur'], 2); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Pārdošanas tendences
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($chartLabels); ?>,
                datasets: [{
                    label: 'Pārdots uz (€)',
                    data: <?php echo json_encode($chartData); ?>,
                    borderColor: '#3498db',
                    backgroundColor: 'rgba(52, 152, 219, 0.1)',

                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                
            }
        });

        // Cik aktīvie produkti balstoties uz platformu
        const platformCtx = document.getElementById('platformChart').getContext('2d');
        new Chart(platformCtx, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($platformData['labels']); ?>,
                datasets: [{
                    data: <?php echo json_encode($platformData['data']); ?>,
                    backgroundColor: ['#3498db', '#2c3e50', '#95a5a6']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: {
                                size: 36,
                                weight: 'bold'
                            },
                            padding: 20
                        },
                        align: 'center'
                    }
                },
                layout: {
                    padding: {
                        top: 100
                    }
                }
            }
        });

        // Cik produkti balstoties uz žanru
        const genreCtx = document.getElementById('genreChart').getContext('2d');
        new Chart(genreCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($genreData['labels']); ?>,
                datasets: [{
                    data: <?php echo json_encode($genreData['data']); ?>,
                    backgroundColor: '#3498db'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>

<?php require_once 'includes/footer.php'; ?> 