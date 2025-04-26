<?php
require_once '../assets/functionality/db.php';

function getDashboardStats() {
    global $conn;
    
    $stats = [
        'total_products',
        'available_keys',
        'completed_orders',
        'total_users',
        'monthly_sales',
        'today_orders',
        'avg_order_value'
    ];

    // Total products
    $query = "SELECT COUNT(*) as total FROM products WHERE status = 'active'";
    $result = $conn->query($query);
    if ($result) {
        $stats['total_products'] = $result->fetch_assoc()['total'];
    }

    // Count available keys
    $query = "SELECT COUNT(*) as total FROM game_keys WHERE status = 'available'";
    $result = $conn->query($query);
    if ($result) {
        $stats['available_keys'] = $result->fetch_assoc()['total'];
    }

    // Completed orders (all time)
    $query = "SELECT COUNT(*) as total FROM orders WHERE status = 'completed'";
    $result = $conn->query($query);
    if ($result) {
        $stats['completed_orders'] = $result->fetch_assoc()['total'];
    }

    // Total users
    $query = "SELECT COUNT(*) as total FROM users WHERE status = 'active'";
    $result = $conn->query($query);
    if ($result) {
        $stats['total_users'] = $result->fetch_assoc()['total'];
    }

    // Monthly sales
    $query = "SELECT SUM(total_amount) as total FROM orders 
              WHERE status = 'completed' 
              AND MONTH(created_at) = MONTH(CURRENT_DATE()) 
              AND YEAR(created_at) = YEAR(CURRENT_DATE())";
    $result = $conn->query($query);
    if ($result) {
        $stats['monthly_sales'] = $result->fetch_assoc()['total'] ?? 0;
    }

    // Count today's orders
    $query = "SELECT COUNT(*) as total FROM orders 
              WHERE DATE(created_at) = CURDATE()";
    $result = $conn->query($query);
    if ($result) {
        $stats['today_orders'] = $result->fetch_assoc()['total'];
    }

    // Average order value
    $query = "SELECT AVG(total_amount) as avg_value FROM orders 
              WHERE status = 'completed'";
    $result = $conn->query($query);
    if ($result) {
        $stats['avg_order_value'] = round($result->fetch_assoc()['avg_value'] ?? 0, 2);
    }

    return $stats;
}

function getBestSellers() {
    global $conn;
    
    $query = "SELECT p.name, COUNT(oi.id) as sales_count 
              FROM order_items oi
              JOIN products p ON oi.product_id = p.id
              JOIN orders o ON oi.order_id = o.id
              WHERE o.status = 'completed'
              AND o.created_at >= DATE_SUB(CURRENT_DATE(), INTERVAL 7 DAY)
              GROUP BY p.id
              ORDER BY sales_count DESC
              LIMIT 5";
    
    $result = $conn->query($query);
    $bestSellers = [];
    
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $bestSellers[] = $row;
        }
    }
    
    return $bestSellers;
}

function getSalesData() {
    global $conn;
    
    $query = "SELECT DATE(created_at) as date, SUM(total_amount) as total
              FROM orders
              WHERE status = 'completed'
              AND created_at >= DATE_SUB(CURRENT_DATE(), INTERVAL 30 DAY)
              GROUP BY DATE(created_at)
              ORDER BY date";
    
    $result = $conn->query($query);
    $salesData = [];
    
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $salesData[] = $row;
        }
    }
    
    return $salesData;
}

function getPlatformDistribution() {
    global $conn;
    
    $query = "SELECT platform, COUNT(*) as count 
              FROM products 
              WHERE status = 'active'
              GROUP BY platform 
              ORDER BY count DESC";
    
    $result = $conn->query($query);
    $platformData = [
        'labels' => [],
        'data' => []
    ];
    
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $platformData['labels'][] = $row['platform'];
            $platformData['data'][] = $row['count'];
        }
    }
    
    return $platformData;
}

function getGenreDistribution() {
    global $conn;
    
    // Get genres from db enum
    $genres_query = "SHOW COLUMNS FROM products WHERE Field = 'genre'";
    $genres_result = $conn->query($genres_query);
    $allGenres = [];
    
    if ($genres_result && $genres_row = $genres_result->fetch_assoc()) {
        preg_match("/^enum\(\'(.*)\'\)$/", $genres_row['Type'], $matches);
        $allGenres = explode("','", $matches[1]);
    }
    
    // Initialize the result array with 0 counts for all genres
    $genreData = [
        'labels' => $allGenres,
        'data' => array_fill(0, count($allGenres), 0)
    ];
    
    $query = "SELECT genre, COUNT(*) as count 
              FROM products 
              WHERE status = 'active'
              GROUP BY genre";
    
    $result = $conn->query($query);
    
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            // Find the index of this genre in our labels array
            $index = array_search($row['genre'], $genreData['labels']);
            if ($index !== false) {
                // Update the count for this genre
                $genreData['data'][$index] = (int)$row['count'];
            }
        }
    }
    
    return $genreData;
}
?> 