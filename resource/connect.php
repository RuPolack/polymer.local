<?php
session_start();
$host = "shortline.proxy.rlwy.net:31635";
$dbname = "railway";
$username = "postgres";
$password = "VQoehvTWaweugwIiXUwFIhQFbUXakiPQ";

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET client_encoding TO 'UTF8'");
} catch(PDOException $e) {
    die("Ошибка подключения: " . $e->getMessage());
}
?>