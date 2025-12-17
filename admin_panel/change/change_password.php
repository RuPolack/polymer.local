<?php
session_start();
require_once '../../resource/connect.php';

// Проверка аутентификации администратора
if (!isset($_SESSION['admin_id'])) {
    header('Location: ../login_admin.php');
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $admin_id = $_SESSION['admin_id'];
    
    // Валидация
    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $error = 'Все поля обязательны для заполнения';
    } elseif ($new_password !== $confirm_password) {
        $error = 'Новый пароль и подтверждение не совпадают';
    } else {
        try {
            // Получаем текущие данные администратора
            $stmt = $pdo->prepare("SELECT encrypted_password FROM admin WHERE admin_id = ?");
            $stmt->execute([$admin_id]);
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($admin) {
                // Расшифровываем текущий пароль для проверки
                $stmt = $pdo->prepare("SELECT decrypt_admin_data(?) as current_pass");
                $stmt->execute([$admin['encrypted_password']]);
                $decrypted_current = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($decrypted_current && $decrypted_current['current_pass'] === $current_password) {
                    // Шифруем новый пароль
                    $stmt = $pdo->prepare("SELECT encrypt_admin_data(?) as encrypted_new");
                    $stmt->execute([$new_password]);
                    $encrypted_new = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    // Обновляем пароль в базе данных
                    $update_stmt = $pdo->prepare("UPDATE admin SET encrypted_password = ? WHERE admin_id = ?");
                    $update_stmt->execute([$encrypted_new['encrypted_new'], $admin_id]);
                    
                    $success = 'Пароль успешно изменен!';
                } else {
                    $error = 'Текущий пароль указан неверно';
                }
            } else {
                $error = 'Администратор не найден';
            }
        } catch (PDOException $e) {
            $error = 'Ошибка базы данных: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Смена пароля</title>
</head>
<body>
    <div>
        <h1>Смена пароля администратора</h1>
        
        <?php if ($error): ?>
            <div><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div>
                <label for="current_password">Текущий пароль:</label>
                <input type="password" id="current_password" name="current_password" required>
            </div>
            
            <div>
                <label for="new_password">Новый пароль:</label>
                <input type="password" id="new_password" name="new_password" required>
            </div>
            
            <div>
                <label for="confirm_password">Подтвердите новый пароль:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            
            <button type="submit">Изменить пароль</button>
        </form>
        
        <div>
            <form id="home_admine" action="change_name.php" method="GET">
                <button type="submit" class="btn">Сменить имя</button>
            </form>

            <form id="home_admine" action="../home_admine.php" method="GET">
                <button type="submit" class="btn">Вернуться назад</button>
            </form>
        </div>
        
    </div>
</body>
</html>