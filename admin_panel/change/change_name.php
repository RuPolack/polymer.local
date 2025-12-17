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

try {
    $admin_id = $_SESSION['admin_id'];
    
    // Получаем текущее имя администратора
    $stmt = $pdo->prepare("SELECT encrypted_name FROM admin WHERE admin_id = ?");
    $stmt->execute([$admin_id]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($admin) {
        // Расшифровываем текущее имя для отображения
        $stmt = $pdo->prepare("SELECT decrypt_admin_data(?) as admin_name");
        $stmt->execute([$admin['encrypted_name']]);
        $decrypted_name = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($decrypted_name && $decrypted_name['admin_name'] !== 'Ошибка дешифровки') {
            $current_name = $decrypted_name['admin_name'];
        }
    }
} catch (PDOException $e) {
    $error = 'Ошибка при получении данных: ' . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_name = trim($_POST['new_name'] ?? '');
    $password = $_POST['password'] ?? '';
    
    // Валидация
    if (empty($new_name)) {
        $error = 'Имя не может быть пустым';
    } elseif (empty($password)) {
        $error = 'Введите пароль для подтверждения';
    } else {
        try {
            // Проверяем пароль
            $stmt = $pdo->prepare("SELECT encrypted_password FROM admin WHERE admin_id = ?");
            $stmt->execute([$admin_id]);
            $admin_pass = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($admin_pass) {
                $stmt = $pdo->prepare("SELECT decrypt_admin_data(?) as admin_pass");
                $stmt->execute([$admin_pass['encrypted_password']]);
                $decrypted_pass = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($decrypted_pass && $decrypted_pass['admin_pass'] === $password) {
                    // Шифруем новое имя
                    $stmt = $pdo->prepare("SELECT encrypt_admin_data(?) as encrypted_name");
                    $stmt->execute([$new_name]);
                    $encrypted_new_name = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    // Обновляем имя в базе данных
                    $update_stmt = $pdo->prepare("UPDATE admin SET encrypted_name = ? WHERE admin_id = ?");
                    $update_stmt->execute([$encrypted_new_name['encrypted_name'], $admin_id]);
                    
                    $success = 'Имя успешно изменено!';
                    $current_name = $new_name;
                } else {
                    $error = 'Пароль указан неверно';
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
    <title>Смена имени</title>
</head>
<body>
    <div>
        <h1>Смена имени администратора</h1>
        
        <?php if ($error): ?>
            <div><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        
        <div>
            <p><strong>Текущее имя:</strong> <?php echo htmlspecialchars($current_name); ?></p>
        </div>
        
        <form method="POST" action="">
            <div>
                <label for="new_name">Новое имя:</label>
                <input type="text" id="new_name" name="new_name" 
                       value="<?php echo htmlspecialchars($_POST['new_name'] ?? ''); ?>" 
                       required>
            </div>
            
            <div>
                <label for="password">Текущий пароль (для подтверждения):</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit">Изменить имя</button>
        </form>
        
        <div>
            <form id="home_admine" action="change_password.php" method="GET">
                <button type="submit" class="btn">Сменить пароль</button>
            </form>

            <form id="home_admine" action="../home_admine.php" method="GET">
                <button type="submit" class="btn">Вернуться назад</button>
            </form>
        </div>
    </div>
</body>
</html>