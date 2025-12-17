<?php
session_start();
require_once '../resource/connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ панель</title>

</head>
<body>

    <div>
        <form id="1" action="../admin_panel/actions/admin_help.php" method="GET">
            <button type="submit" class="btn">Как пользоваться админом</button>
        </form>
    </div>
 
    <div>
        <form id="2" action="../admin_panel/actions/view_results.php" method="GET">
            <button type="submit" class="btn">Просмотр результатов</button>
        </form>
    </div>

    <div>
        <form id="3" action="../admin_panel/change/change_password.php" method="GET">
            <button type="submit" class="btn">Поменять имя</button>
        </form>
    </div>

    <div>
        <form id="3" action="../admin_panel/change/change_password.php" method="GET">
            <button type="submit" class="btn">Поменять пароль</button>
        </form>
    </div>

    <div>
        <form id="5" action="../admin_panel/actions/add_question.php" method="GET">
            <button type="submit" class="btn">Добавить вопрос</button>
        </form>
        <form id="6" action="../admin_panel/actions/edit_question.php" method="GET">
            <button type="submit" class="btn">Редактировать вопрос</button>
        </form>
    </div>

    <div>
        <form id="7" action="../admin_panel/actions/add_profession.php" method="GET">
            <button type="submit" class="btn">Добавить профессию</button>
        </form>
        <form id="8" action="../admin_panel/actions/edit_profession.php" method="GET">
            <button type="submit" class="btn">Редактировать профессию</button>
        </form>
    </div>




    Приветствие и кнопки что делать добавлять или 
    редактировать профессию и добавить или редактировать вопросы и ответы
</body>
</html>