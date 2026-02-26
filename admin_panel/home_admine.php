<?php // Домашняя страница админа
require_once '../resource/connect.php';
require_once '../admin_panel/login_verification_admin/login_verification_admin.php';
?>



<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ панель</title>
    <link rel="stylesheet" href="css_abmin/css_abmin.css">
</head>

<body>

    <h1>Админ-панель</h1>
    <p>Привет! Здесь вы можете управлять вопросами, профессиями, менять свои данные и просматривать записи.</p>

    <div class="admin-menu">
        <!-- Справка -->
        <div>
            <form action="../admin_panel/actions/admin_help.php" method="GET">
                <button type="submit" class="btn">Как пользоваться админом</button>
            </form>
        </div>

        <!-- Просмотр результатов -->
        <div>
            <form id="2" action="../admin_panel/actions/view_results.php" method="GET">
                <button type="submit" class="btn">Просмотр результатов</button>
            </form>
        </div>

        <!-- Управление вопросами -->
        <div>
            <form action="../admin_panel/actions/add_question.php" method="GET">
                <button type="submit" class="btn">Добавить вопрос</button>
            </form>
            <form action="../admin_panel/actions/edit_question.php" method="GET">
                <button type="submit" class="btn">Редактировать/удалить вопрос</button>
            </form>
        </div>

        <!-- Управление профессиями -->
        <div>
            <form action="../admin_panel/actions/add_profession.php" method="GET">
                <button type="submit" class="btn">Добавить профессию</button>
            </form>
            <form action="../admin_panel/actions/edit_profession.php" method="GET">
                <button type="submit" class="btn">Редактировать/удалить профессию</button>
            </form>
        </div>

        <!-- Просмотр записей -->
        <div>
            <form action="../admin_panel/actions/view_records.php" method="GET">
                <button type="submit" class="btn">Просмотр профессий и вопросов</button>
            </form>
        </div>

        <!-- Смена имени и пароля -->
        <div>
            <form action="../admin_panel/change/change_name.php" method="GET">
                <button type="submit" class="btn">Сменить имя</button>
            </form>
            <form action="../admin_panel/change/change_password.php" method="GET">
                <button type="submit" class="btn">Сменить пароль</button>
            </form>
        </div>

        <!-- Главная -->
        <div>
            <form action="../index.php" method="GET">
                <button type="submit" class="btn">Вернуться на главную страницу</button>
            </form>
        </div>
    </div>

</body>

</html>