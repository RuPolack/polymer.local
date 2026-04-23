<?php
session_start();
$host = "localhost";
$dbname = "postgres";
$username = "postgres";
$password = "postgres";

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET client_encoding TO 'UTF8'");
} catch(PDOException $e) {
    die("Ошибка подключения: " . $e->getMessage());
}
?>
