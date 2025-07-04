<?php
session_start();
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/../../stripe/init.php';
require_once __DIR__ . '/../../config/secrets.php';
\Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);

$amount = $_POST['amount'] ?? 0;
$cart = json_decode($_POST['cart'], true) ?? [];

if (empty($amount) || empty($cart)) {
    $_SESSION['error'] = 'Invalid data';
    header('Location: ../../cart.php');
    exit;
}

try {
    $success_url = 'http://' . $_SERVER['HTTP_HOST'] . '/keyforge_eksamens/assets/functionality/process_payment.php?session_id={CHECKOUT_SESSION_ID}';
    $cancel_url = 'http://' . $_SERVER['HTTP_HOST'] . '/keyforge_eksamens/cart.php';

    $checkout_session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
                'currency' => 'eur',
                'unit_amount' => $amount,
                'product_data' => [
                    'name' => 'Spēles atslēgas pirkums',
                    'description' => 'Spēles atslēgas pirkums KeyForge platformā',
                ],
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => $success_url,
        'cancel_url' => $cancel_url,
        'locale' => 'lv',
        'metadata' => [
            'cart' => json_encode($cart)
        ]
    ]);

    header("Location: " . $checkout_session->url);
    exit;
} catch (Exception $e) {
    $_SESSION['error'] = 'Error creating checkout session: ' . $e->getMessage();
    header('Location: ../../cart.php');
    exit;
} 