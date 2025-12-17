<?php //Регестрация для админа
require_once '../resource/connect.php';
session_start();
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация админа</title>
    <link rel="stylesheet" href="css_abmin/css_abmin.css">
</head>

<body>

    <form action="../admin_panel/log.php" method="post">
        <input type="text" placeholder="Имя" name="name_admin" required>
        <input type="text" placeholder="Пароль" name="pass_admin" required>
        <button type="submit">Войти в систему</button>
    </form>

</body>

</html>