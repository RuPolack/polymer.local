<? //Просмотр результатов
session_start();
require_once 'resource/connect.php';?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Просмотр результатов</title>
</head>
<body>
    <h1>Просмотр результатов тестирования</h1>
    
    <form action="" method="POST">
        <div>
            <label for="filter_profession">Фильтр по профессии:</label><br>
            <select id="filter_profession" name="filter_profession">
                <option value="">Все профессии</option>
                <option value="1">Программист</option>
                <option value="2">Дизайнер</option>
                <option value="3">Маркетолог</option>
                <option value="4">Менеджер</option>
            </select>
        </div>
        <br>
        
        <div>
            <label for="filter_date_from">Дата от:</label>
            <input type="date" id="filter_date_from" name="filter_date_from">
            
            <label for="filter_date_to">Дата до:</label>
            <input type="date" id="filter_date_to" name="filter_date_to">
        </div>
        <br>
        
        <div>
            <input type="submit" value="Применить фильтры">
            <input type="reset" value="Сбросить фильтры">
        </div>
    </form>
    
    <br>
    <hr>
    
    <h2>Результаты тестирования</h2>
    
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Имя пользователя</th>
                <th>Профессия</th>
                <th>Вопрос</th>
                <th>Ответ пользователя</th>
                <th>Дата ответа</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Иван Иванов</td>
                <td>Программист</td>
                <td>Что такое HTML?</td>
                <td>1 ✓</td>
                <td>2024-01-15 10:30:00</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Петр Петров</td>
                <td>Дизайнер</td>
                <td>Что такое RGB?</td>
                <td>1 ✓</td>
                <td>2024-01-15 11:45:00</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Анна Сидорова</td>
                <td>Маркетолог</td>
                <td>Что такое SEO?</td>
                <td>2 ✗</td>
                <td>2024-01-16 09:20:00</td>
            </tr>
            <tr>
                <td>4</td>
                <td>Сергей Кузнецов</td>
                <td>Менеджер</td>
                <td>Что такое SWOT-анализ?</td>
                <td>1 ✓</td>
                <td>2024-01-16 14:15:00</td>
            </tr>
        </tbody>
    </table>
    
    <p><strong>Статистика:</strong> Всего ответов: 100 | Правильных: 75 (75%) | Неправильных: 25 (25%)</p>
    
</body>
</html>