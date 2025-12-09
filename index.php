<?php
session_start();
require_once 'resource/connect.php';

// Получаем список профессий
$stmt = $pdo->query("SELECT * FROM professions");
$professions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Тестирование профессий</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<?php //Кнопка админа ?>
    <form id="admin" action="admin_panel/login_admin.php" method="GET">
        <button type="submit" class="btn">Администратор</button>
    </form>



    <div class="container">
        <div class="header">
            <h1>Тестирование по профессиям</h1>
            <p>Выберите профессию и пройдите тест</p>
        </div>
        
        <div class="content">
            <form id="userForm">
                <div class="form-group">
                    <label for="userName">Ваше имя:</label>
                    <input type="text" id="userName" name="userName" required>
                </div>
                
                <div class="form-group">
                    <label for="profession">Выберите профессию:</label>
                    <select id="profession" name="profession" required>
                        <option value="">-- Выберите профессию --</option>
                        <?php foreach($professions as $profession): ?>
                            <option value="<?= $profession['id'] ?>"><?= $profession['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <button type="submit" class="btn">Начать тест</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('userForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const userName = document.getElementById('userName').value;
            const profession = document.getElementById('profession').value;
            
            if(userName && profession) {
                window.location.href = `quiz.php?name=${encodeURIComponent(userName)}&profession=${profession}`;
            }
        });
    </script>
</body>
</html>
