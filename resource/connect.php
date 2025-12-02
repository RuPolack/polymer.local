<?php
$host = "localhost";
$dbname = "polymer";
$username = "postgres";
$password = "postgres";

// Функция для шифрования имени на стороне PHP
function encryptName($name) {
    return base64_encode(openssl_encrypt(
        $name, 
        'AES-256-CBC', 
        'ванпис', 
        OPENSSL_RAW_DATA, 
        substr(hash('sha256', 'ванпис'), 0, 16)
    ));
}

// Функция для расшифровки имени (для администратора)
function decryptName($encryptedName) {
    return openssl_decrypt(
        base64_decode($encryptedName), 
        'AES-256-CBC', 
        'ванпис', 
        OPENSSL_RAW_DATA, 
        substr(hash('sha256', 'ванпис'), 0, 16)
    );
}

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Ошибка подключения: " . $e->getMessage());
}
?>