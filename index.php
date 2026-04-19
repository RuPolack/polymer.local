<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добро пожаловать</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

    <div class="container">
        <div class="header">
            <h1>Добро пожаловать</h1>
        </div>
        <div class="content"> 
            <div class="content-index">

    <div class="content-btn">
    <form action="admin_panel/login_admin.php" method="GET">
        <button type="submit" class="btn">Вход для администратора</button>
    </form></div>

    <div class="content-btn">
    <form action="quiz/start_quiz.php" method="GET">
        <button type="submit" class="btn">Пройти тест</button>
    </form></div>

    <div class="content-btn">
    <form action="quiz/questions.php" method="GET">
        <button type="submit" class="btn">Посмотреть вопросы для подготовки</button>
    </form></div>
    
            </div>
        </div>
    </div>
</body>
</html>
