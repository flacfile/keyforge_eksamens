<?php
require_once '../../assets/functionality/db.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    $_SESSION['flash_message'] = 'Nav atļauts veikt šo darbību.';
    $_SESSION['flash_type'] = 'error';
    header('Location: ../products.php');
    exit();
}

$required_fields = ['name', 'description', 'price_eur', 'platform', 'genre', 'image_alt', 'cpu', 'gpu', 'ram', 'storage'];
foreach ($required_fields as $field) {
    if (!isset($_POST[$field]) || empty($_POST[$field])) {
        $_SESSION['flash_message'] = 'Visi lauki ir obligāti.';
        $_SESSION['flash_type'] = 'error';
        header('Location: ../products.php');
        exit();
    }
}

if (!is_numeric($_POST['price_eur']) || $_POST['price_eur'] <= 0) {
    $_SESSION['flash_message'] = 'Nederīga EUR cena.';
    $_SESSION['flash_type'] = 'error';
    header('Location: ../products.php');
    exit();
}

if (!isset($_FILES['main_image']) || $_FILES['main_image']['error'] !== UPLOAD_ERR_OK) {
    $_SESSION['flash_message'] = 'Lūdzu augšupielādējiet produktu attēlu.';
    $_SESSION['flash_type'] = 'error';
    header('Location: ../products.php');
    exit();
}

$image = $_FILES['main_image'];
$allowed_types = ['image/jpeg', 'image/png', 'image/webp'];

if (!in_array($image['type'], $allowed_types)) {
    $_SESSION['flash_message'] = 'Nederīgs attēla formāts. Atļautie formāti: JPG, PNG, WEBP';
    $_SESSION['flash_type'] = 'error';
    header('Location: ../products.php');
    exit();
}

try {
    $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '.' . $extension;
    $upload_path = '../../assets/images/products/';
    
    // Create directory if it doesn't exist
    // if (!file_exists($upload_path)) {
    //     mkdir($upload_path, 0777, true);
    // }

    // Move uploaded file
    if (!move_uploaded_file($image['tmp_name'], $upload_path . $filename)) {
        throw new Exception("Kļūda augšupielādējot attēlu");
    }

    // Insert product into database using prepared statement
    $stmt = $conn->prepare("INSERT INTO products (
        name, description, price_eur, platform, genre, 
        main_image_path, image_alt, cpu, gpu, ram, storage, 
        created_at, updated_at
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");

    $image_path = 'assets/images/products/' . $filename;
    
    $stmt->bind_param("ssdssssssss", 
        $_POST['name'],
        $_POST['description'],
        $_POST['price_eur'],
        $_POST['platform'],
        $_POST['genre'],
        $image_path,
        $_POST['image_alt'],
        $_POST['cpu'],
        $_POST['gpu'],
        $_POST['ram'],
        $_POST['storage']
    );

    if ($stmt->execute()) {
        $admin_id = $_SESSION['user_id'];
        $new_product_id = $conn->insert_id;
        
        // Logs
        $stmt = $conn->prepare("INSERT INTO logs (user_id, action, details) VALUES (?, ?, ?)");
        $action = "create_product";
        $details = "Created new product ID: $new_product_id";
        $stmt->bind_param("iss", $admin_id, $action, $details);
        $stmt->execute();

        $_SESSION['flash_message'] = 'Produkts veiksmīgi pievienots.';
        $_SESSION['flash_type'] = 'success';
    } else {
        throw new Exception("Database error");
    }
} catch (Exception $e) {
    $_SESSION['flash_message'] = 'Kļūda pievienojot produktu.';
    $_SESSION['flash_type'] = 'error';
}

header('Location: ../products.php');
exit(); 