<? //Редактировать профессию
session_start();
require_once 'resource/connect.php';?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактировать профессию</title>
</head>
<body>
    <h1>Редактирование профессии</h1>
    
    <form action="" method="POST">
        <div>
            <label for="profession_id_select">Выберите профессию для редактирования:</label><br>
            <select id="profession_id_select" name="profession_id_select" required>
                <option value="">Выберите профессию</option>
                <option value="1">Программист</option>
                <option value="2">Дизайнер</option>
                <option value="3">Маркетолог</option>
                <option value="4">Менеджер</option>
            </select>
        </div>
        <br>
        
        <div>
            <label for="new_profession_name">Новое название профессии:</label><br>
            <input type="text" id="new_profession_name" name="new_profession_name" required>
        </div>
        <br>
        
        <div>
            <input type="submit" value="Обновить профессию">
            <input type="reset" value="Очистить">
        </div>
    </form>
    
    <h2>Удаление профессии</h2>
    <form action="" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить эту профессию?');">
        <div>
            <label for="delete_profession_id">Выберите профессию для удаления:</label><br>
            <select id="delete_profession_id" name="delete_profession_id" required>
                <option value="">Выберите профессию</option>
                <option value="1">Программист</option>
                <option value="2">Дизайнер</option>
                <option value="3">Маркетолог</option>
                <option value="4">Менеджер</option>
            </select>
        </div>
        <br>
        
        <div>
            <input type="submit" value="Удалить профессию" style="color: red;">
        </div>
    </form>
    
</body>
</html>