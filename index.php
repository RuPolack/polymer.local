<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добро пожаловать</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>

<?php //Кнопка админа ?>
    <form id="admin" action="admin_panel/login_admin.php" method="GET">
        <button type="submit" class="btn">Администратор</button>
    </form>



    <div class="container">
        <div class="header">
            <h1>Добро пожаловать</h1>
        </div>
        <div class="content"> 
            <div class="content-index">
<div class="content-btn">
    <a class="link_class" href="admin_panel/login_admin.php">Вход для администратора</a></div>
<div class="content-btn">
    <a class="link_class" href="quiz/start_quiz.php">Пройти тест</a></div>
<div class="content-btn">
    <a class="link_class" href="quiz/questions.php">Посмотреть вопросы для подготовки</a></div>

            </div>
        </div>
    </div>
</body>
</html>
