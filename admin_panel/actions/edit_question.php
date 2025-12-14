<? //Редактировать вопрос
session_start();
require_once 'resource/connect.php';?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактировать вопрос</title>
</head>
<body>
    <h1>Редактирование вопроса</h1>
    
    <form action="" method="POST">
        <div>
            <label for="question_id_select">Выберите вопрос для редактирования:</label><br>
            <select id="question_id_select" name="question_id_select" required>
                <option value="">Выберите вопрос</option>
                <option value="1">Что такое HTML?</option>
                <option value="2">Какой язык используется для стилизации веб-страниц?</option>
                <option value="3">Что означает SQL?</option>
                <option value="4">Какой тег используется для создания ссылки в HTML?</option>
            </select>
        </div>
        <br>
        
        <div>
            <label for="edit_question_text">Текст вопроса:</label><br>
            <textarea id="edit_question_text" name="edit_question_text" rows="3" cols="50" required></textarea>
        </div>
        <br>
        
        <div>
            <label for="edit_option1">Вариант ответа 1:</label><br>
            <input type="text" id="edit_option1" name="edit_option1" required>
        </div>
        <br>
        
        <div>
            <label for="edit_option2">Вариант ответа 2:</label><br>
            <input type="text" id="edit_option2" name="edit_option2" required>
        </div>
        <br>
        
        <div>
            <label for="edit_option3">Вариант ответа 3:</label><br>
            <input type="text" id="edit_option3" name="edit_option3" required>
        </div>
        <br>
        
        <div>
            <label for="edit_option4">Вариант ответа 4:</label><br>
            <input type="text" id="edit_option4" name="edit_option4" required>
        </div>
        <br>
        
        <div>
            <label for="edit_correct_option">Правильный вариант:</label><br>
            <select id="edit_correct_option" name="edit_correct_option" required>
                <option value="">Выберите правильный ответ</option>
                <option value="1">Вариант 1</option>
                <option value="2">Вариант 2</option>
                <option value="3">Вариант 3</option>
                <option value="4">Вариант 4</option>
            </select>
        </div>
        <br>
        
        <div>
            <input type="submit" value="Обновить вопрос">
            <input type="reset" value="Очистить форму">
        </div>
    </form>
    
    <h2>Удаление вопроса</h2>
    <form action="" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить этот вопрос?');">
        <div>
            <label for="delete_question_id">Выберите вопрос для удаления:</label><br>
            <select id="delete_question_id" name="delete_question_id" required>
                <option value="">Выберите вопрос</option>
                <option value="1">Что такое HTML?</option>
                <option value="2">Какой язык используется для стилизации веб-страниц?</option>
                <option value="3">Что означает SQL?</option>
                <option value="4">Какой тег используется для создания ссылки в HTML?</option>
            </select>
        </div>
        <br>
        
        <div>
            <input type="submit" value="Удалить вопрос" style="color: red;">
        </div>
    </form>
    
</body>
</html>