<? //Добавить профессию
session_start();
require_once 'resource/connect.php';?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавление профессии</title>
</head>
<body>
    <h1>Добавление новой профессии</h1>
    
    <form action="" method="POST">
        <div>
            <label for="professionName">Название профессии:</label><br>
            <input type="text" id="professionName" name="professionName" required>
        </div>
        <br>
        <div>
            <input type="submit" value="Добавить профессию">
        </div>
    </form>
    
    
    
    
    
    
</body>
</html>