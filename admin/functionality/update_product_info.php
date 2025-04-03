<?php
session_start();
require_once '../../assets/functionality/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    $_SESSION['flash_message'] = 'Nav atļauts veikt šo darbību.';
    $_SESSION['flash_type'] = 'error';
    header('Location: ../products.php');
    exit();
}

// Get handler
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['id'])) {
        $_SESSION['flash_message'] = 'Produkta ID nav norādīts.';
        $_SESSION['flash_type'] = 'error';
        header('Location: ../products.php');
        exit();
    }

    $product_id = $_GET['id'];

    try {
        $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            $_SESSION['flash_message'] = 'Produkts nav atrasts.';
            $_SESSION['flash_type'] = 'error';
            header('Location: ../products.php');
            exit();
        }
        
        $product = $result->fetch_assoc();
        
        // Store product data in session for the form
        $_SESSION['edit_product'] = $product;
        header('Location: ../products.php?edit=' . $product_id);
        exit();
        
    } catch (Exception $e) {
        $_SESSION['flash_message'] = 'Kļūda iegūstot produkta datus.';
        $_SESSION['flash_type'] = 'error';
        header('Location: ../products.php');
        exit();
    }
}

// Post handler
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'] ?? '';
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $price_eur = $_POST['price_eur'] ?? 0;
    $platform = $_POST['platform'] ?? '';
    $genre = $_POST['genre'] ?? '';
    $image_alt = $_POST['image_alt'] ?? '';
    $cpu = $_POST['cpu'] ?? '';
    $gpu = $_POST['gpu'] ?? '';
    $ram = $_POST['ram'] ?? '';
    $storage = $_POST['storage'] ?? '';

    if (empty($product_id) || empty($name) || empty($description) || empty($platform) || empty($genre)) {
        $_SESSION['flash_message'] = 'Visi lauki ir obligāti.';
        $_SESSION['flash_type'] = 'error';
        header('Location: ../products.php?edit=' . $product_id);
        exit();
    }

    if (!is_numeric($price_eur) || $price_eur <= 0) {
        $_SESSION['flash_message'] = 'Nederīga EUR cena.';
        $_SESSION['flash_type'] = 'error';
        header('Location: ../products.php?edit=' . $product_id);
        exit();
    }

    try {
        // if new image uploaded
        $image_path = $_SESSION['edit_product']['main_image_path'] ?? '';
        if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] === UPLOAD_ERR_OK) {
            $image = $_FILES['main_image'];
            $allowed_types = ['image/jpeg', 'image/png', 'image/webp'];
            $max_size = 5 * 1024 * 1024; // 5MB

            if (!in_array($image['type'], $allowed_types)) {
                $_SESSION['flash_message'] = 'Nederīgs attēla formāts. Atļautie formāti: JPG, PNG, WEBP';
                $_SESSION['flash_type'] = 'error';
                header('Location: ../products.php?edit=' . $product_id);
                exit();
            }

            if ($image['size'] > $max_size) {
                $_SESSION['flash_message'] = 'Attēla izmērs pārsniedz 5MB.';
                $_SESSION['flash_type'] = 'error';
                header('Location: ../products.php?edit=' . $product_id);
                exit();
            }

            try {
                // generate unique filename
                $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
                $filename = uniqid() . '.' . $extension;
                $upload_path = '../../assets/images/products/';
                
                // create directory if it doesn't exist
                // if (!file_exists($upload_path)) {
                //     mkdir($upload_path, 0777, true);
                // }

                if (!move_uploaded_file($image['tmp_name'], $upload_path . $filename)) {
                    throw new Exception("Kļūda augšupielādējot attēlu");
                }

                // Delete old img
                if (!empty($image_path) && file_exists('../../' . $image_path)) {
                    unlink('../../' . $image_path);
                }

                $image_path = 'assets/images/products/' . $filename;
            } catch (Exception $e) {
                $_SESSION['flash_message'] = 'Kļūda augšupielādējot attēlu: ' . $e->getMessage();
                $_SESSION['flash_type'] = 'error';
                header('Location: ../products.php?edit=' . $product_id);
                exit();
            }
        }

        // Update product in database
        if (!empty($image_path)) {
            $stmt = $conn->prepare("UPDATE products SET 
                name = ?, description = ?, price_eur = ?, 
                platform = ?, genre = ?, main_image_path = ?, image_alt = ?,
                cpu = ?, gpu = ?, ram = ?, storage = ?, updated_at = NOW()
                WHERE id = ?");
            $stmt->bind_param("ssdssssssssi", 
                $name, $description, $price_eur,
                $platform, $genre, $image_path, $image_alt,
                $cpu, $gpu, $ram, $storage, $product_id
            );
        } else {
            $stmt = $conn->prepare("UPDATE products SET 
                name = ?, description = ?, price_eur = ?, 
                platform = ?, genre = ?, image_alt = ?,
                cpu = ?, gpu = ?, ram = ?, storage = ?, updated_at = NOW()
                WHERE id = ?");
            $stmt->bind_param("ssdsssssssi", 
                $name, $description, $price_eur,
                $platform, $genre, $image_alt,
                $cpu, $gpu, $ram, $storage, $product_id
            );
        }
        
        if ($stmt->execute()) {
            // Logs
            $admin_id = $_SESSION['user_id'];
            $stmt = $conn->prepare("INSERT INTO logs (user_id, action, details) VALUES (?, 'update_product', ?)");
            $details = "Updated product ID: $product_id";
            $stmt->bind_param("is", $admin_id, $details);
            $stmt->execute();

            $_SESSION['flash_message'] = 'Produkta informācija ir atjaunināta.';
            $_SESSION['flash_type'] = 'success';
            unset($_SESSION['edit_product']);
            header('Location: ../products.php');
            exit();
        } else {
            throw new Exception("Database error");
        }
    } catch (Exception $e) {
        $_SESSION['flash_message'] = 'Kļūda atjauninot produkta informāciju.';
        $_SESSION['flash_type'] = 'error';
        header('Location: ../products.php?edit=' . $product_id);
        exit();
    }
}

header('Location: ../products.php');
exit(); 