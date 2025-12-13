<?php
require_once '../resource/connect.php';
session_start();

try {
    $name_admin = $_POST['name_admin'];
    $pass_admin = $_POST['pass_admin'];

    // Запрос для проверки администратора с расшифровкой
    $sql = "SELECT 
                admin_id,
                decrypt_admin_data(encrypted_name) as admin_name,
                decrypt_admin_data(encrypted_password) as admin_password,
                created_at
            FROM admin
            WHERE decrypt_admin_data(encrypted_name) = :admin_name AND decrypt_admin_data(encrypted_password) = :admin_password";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':admin_name' => $name_admin,
        ':admin_password' => $pass_admin
    ]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Проверка пользователя и пароля
    if(!$user) {
        echo "Ошибка входа не верно указаны данные";
        exit;
    }
    
    if($pass_admin !== $user['admin_password']){
        echo "Ошибка входа не верно указаны данные";
        exit;
    }

    // Сохраняем данные в сессию
    $_SESSION['admin_id'] = $user['admin_id'];
    $_SESSION['admin_name'] = $user['admin_name'];
    $_SESSION['admin_password'] = $user['admin_password'];
    $_SESSION['created_at'] = $user['created_at'];

    // Успешный вход
    header('Location: ../admin_panel/home_admine.php');
    exit;
    
} catch (PDOException $e) {
    die("Ошибка входа: " . $e->getMessage());
}