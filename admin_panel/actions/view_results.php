<?php
// Просмотр результатов
session_start();
require_once '../../resource/connect.php';
?>

<?php
// Инициализация переменных
$results = [];
$total_count = ['total' => 0];
$correct_count = ['correct_count' => 0];
$professions = [];
$where_conditions = "1=1";
$params = [];

// Обработка сброса фильтров
if (isset($_GET['clear'])) {
    unset($_SESSION['filters']);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Фильтр по профессии
    if (!empty($_POST['filter_profession'])) {
        $where_conditions .= " AND r.profession_id = ?";
        $params[] = $_POST['filter_profession'];
    }
    
    // Фильтр по дате от
    if (!empty($_POST['filter_date_from'])) {
        $where_conditions .= " AND r.answer_date >= ?";
        $params[] = $_POST['filter_date_from'] . ' 00:00:00';
    }
    
    // Фильтр по дате до
    if (!empty($_POST['filter_date_to'])) {
        $where_conditions .= " AND r.answer_date <= ?";
        $params[] = $_POST['filter_date_to'] . ' 23:59:59';
    }
    
    // Сохраняем фильтры в сессию
    $_SESSION['filters'] = [
        'profession' => $_POST['filter_profession'] ?? '',
        'date_from' => $_POST['filter_date_from'] ?? '',
        'date_to' => $_POST['filter_date_to'] ?? ''
    ];
}

// Если GET запрос и есть сохраненные фильтры
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_SESSION['filters'])) {
    $filters = $_SESSION['filters'];
    
    if (!empty($filters['profession'])) {
        $where_conditions .= " AND r.profession_id = ?";
        $params[] = $filters['profession'];
    }
    
    if (!empty($filters['date_from'])) {
        $where_conditions .= " AND r.answer_date >= ?";
        $params[] = $filters['date_from'] . ' 00:00:00';
    }
    
    if (!empty($filters['date_to'])) {
        $where_conditions .= " AND r.answer_date <= ?";
        $params[] = $filters['date_to'] . ' 23:59:59';
    }
}

// Получаем список профессий
try {
    $sql_professions = "SELECT id, name FROM professions ORDER BY name";
    $stmt_professions = $pdo->prepare($sql_professions);
    $stmt_professions->execute();
    $professions = $stmt_professions->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Ошибка при получении списка профессий: " . $e->getMessage();
}

// Проверка подключения
if (!isset($pdo)) {
    die("Ошибка: Подключение к базе данных не установлено. Проверьте файл connect.php");
}

// Получаем данные
try {
    $sql = "
        SELECT 
            r.id,
            decrypt_name(r.encrypted_name) AS user_name,
            r.profession_id,
            p.name AS profession_name,
            q.question_text,
            r.user_answer,
            q.correct_option,
            r.answer_date
        FROM results r
        LEFT JOIN professions p ON r.profession_id = p.id
        LEFT JOIN questions q ON r.question_id = q.id
        WHERE $where_conditions
        ORDER BY r.answer_date, r.id DESC
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sql_count = "SELECT COUNT(*) AS total FROM results r WHERE $where_conditions";
    $stmt_count = $pdo->prepare($sql_count);
    $stmt_count->execute($params);
    $total_count = $stmt_count->fetch(PDO::FETCH_ASSOC) ?: ['total' => 0];

    $sql_correct = "
        SELECT COUNT(*) AS correct_count
        FROM results r
        JOIN questions q ON r.question_id = q.id
        WHERE $where_conditions AND r.user_answer = q.correct_option
    ";
    $stmt_correct = $pdo->prepare($sql_correct);
    $stmt_correct->execute($params);
    $correct_count = $stmt_correct->fetch(PDO::FETCH_ASSOC) ?: ['correct_count' => 0];

} catch (PDOException $e) {
    $error = "Ошибка при получении данных: " . $e->getMessage();
}
?>









<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Просмотр результатов</title>
</head>
<body>
    <div>
        <form id="home_admine" action="../home_admine.php" method="GET">
            <button type="submit" class="btn">Вернуться назад</button>
        </form>
    </div>

    <h1>Просмотр результатов тестирования</h1>
    
    <?php if (isset($error)): ?>
        <div style="color: red; margin: 10px 0; padding: 10px; border: 1px solid red;">
            <strong>Ошибка:</strong> <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>
    
    <form method="POST" action="">
        <div>
            <label for="filter_profession">Фильтр по профессии:</label><br>
            <select id="filter_profession" name="filter_profession">
                <option value="">Все профессии</option>
                <?php foreach ($professions as $profession): ?>
                    <option value="<?php echo $profession['id']; ?>" 
                        <?php echo (isset($_SESSION['filters']['profession']) && $_SESSION['filters']['profession'] == $profession['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($profession['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <br>
        
        <div>
            <label for="filter_date_from">Дата от:</label>
            <input type="date" id="filter_date_from" name="filter_date_from" 
                   value="<?php echo isset($_SESSION['filters']['date_from']) ? htmlspecialchars($_SESSION['filters']['date_from']) : ''; ?>">
            
            <label for="filter_date_to">Дата до:</label>
            <input type="date" id="filter_date_to" name="filter_date_to" 
                   value="<?php echo isset($_SESSION['filters']['date_to']) ? htmlspecialchars($_SESSION['filters']['date_to']) : ''; ?>">
        </div>
        <br>
        
        <div>
            <input type="submit" value="Применить фильтры">
            <input type="button" value="Сбросить все" onclick="location.href='?clear=true'">
        </div>
    </form>
    
    <br>
    <hr>
    
    <h2>Статистика</h2>
    <p>Всего записей: <?php echo $total_count['total']; ?></p>
    <p>Правильных ответов: <?php echo $correct_count['correct_count']; ?></p>
    <?php if ($total_count['total'] > 0): ?>
        <p>Процент правильных: <?php echo round(($correct_count['correct_count'] / $total_count['total']) * 100, 2); ?>%</p>
    <?php endif; ?>
    
    <h2>Результаты тестирования</h2>
    
    <div class="tabl">
        <table border="2" cellpadding="10" cellspacing="0">
            <tr>
                <th>ID</th>
                <th>Имя пользователя</th>
                <th>Профессия</th>
                <th>Вопрос</th>
                <th>Ответ пользователя</th>
                <th>Правильный ответ</th>
                <th>Статус</th>
                <th>Дата и время</th>
            </tr>
            
            <?php if (count($results) > 0): ?>
                <?php foreach ($results as $result): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($result['id']); ?></td>
                        <td><?php echo htmlspecialchars($result['user_name']); ?></td>
                        <td><?php echo htmlspecialchars($result['profession_name']); ?></td>
                        <td><?php echo htmlspecialchars(mb_substr($result['question_text'], 0, 50)); ?></td>
                        <td><?php echo htmlspecialchars($result['user_answer']); ?></td>
                        <td><?php echo htmlspecialchars($result['correct_option']); ?></td>
                        <td>
                            <?php 
                            if ($result['user_answer'] == $result['correct_option']) {
                                echo '✓ Верно';
                            } else {
                                echo '✗ Неверно';
                            }
                            ?>
                        </td>
                        <td><?php echo htmlspecialchars($result['answer_date']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">Нет данных для отображения</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>

</body>
</html>