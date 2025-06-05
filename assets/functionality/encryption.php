<?php
require_once __DIR__ . '/../../config/secrets.php';

function encryptKey() {
    global $key, $encrypted_key;
    $cipher = "AES-256-CBC";
    $ivlen = openssl_cipher_iv_length($cipher);
    $iv = openssl_random_pseudo_bytes($ivlen);
    $encrypted = openssl_encrypt($key, $cipher, ENCRYPTION_KEY, 0, $iv);
    $encrypted_key = base64_encode($iv . $encrypted);
}

function decryptKey() {
    global $key, $encrypted_key;
    $cipher = "AES-256-CBC";
    $data = base64_decode($encrypted_key);
    $ivlen = openssl_cipher_iv_length($cipher);
    $iv = substr($data, 0, $ivlen);
    $encrypted = substr($data, $ivlen);
    $key = openssl_decrypt($encrypted, $cipher, ENCRYPTION_KEY, 0, $iv);
} 