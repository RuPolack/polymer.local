<?php // Просмотр профессий и вопросов
session_start();
require_once '../../resource/connect.php';


// Определяем, что показывать: профессии или вопросы
$view = $_GET['view'] ?? 'professions';

$error = '';
$professions = [];
$questions = [];

// Получаем данные из базы
try {
    if ($view === 'professions') {
        $stmt = $pdo->query("SELECT * FROM professions ORDER BY id");
        $professions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } elseif ($view === 'questions') {
        $sql = "
            SELECT q.id, q.profession_id, p.name AS profession_name, q.question_text,
                   q.option1, q.option2, q.option3, q.option4, q.correct_option
            FROM questions q
            LEFT JOIN professions p ON q.profession_id = p.id
            ORDER BY q.id
        ";
        $stmt = $pdo->query($sql);
        $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    $error = "Ошибка при получении данных: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<title>Просмотр записей</title>
</head>
<body>

<h1>Просмотр записей</h1>

<!-- Кнопки -->
<div>
    <a href="?view=professions"><button>Профессии</button></a>
    <a href="?view=questions"><button>Вопросы</button></a>
</div>

<hr>

<?php if ($error) echo "<div>Ошибка: ".htmlspecialchars($error)."</div>"; ?>

<?php if ($view === 'professions'): ?>
<h2>Профессии</h2>
<?php if($professions): ?>
<table border="1" cellpadding="5" cellspacing="0">
<tr><th>ID</th><th>Название профессии</th></tr>
<?php foreach($professions as $p): ?>
<tr><td><?php echo $p['id']; ?></td><td><?php echo htmlspecialchars($p['name']); ?></td></tr>
<?php endforeach; ?>
</table>
<?php else: ?>
<p>Нет профессий.</p>
<?php endif; ?>

<?php elseif ($view === 'questions'): ?>
<h2>Вопросы</h2>
<?php if($questions): ?>
<table border="1" cellpadding="5" cellspacing="0">
<tr><th>ID</th><th>Профессия</th><th>Вопрос</th><th>Вариант1</th><th>Вариант2</th><th>Вариант3</th><th>Вариант4</th><th>Правильный вариант</th></tr>
<?php foreach($questions as $q): ?>
<tr>
<td><?php echo $q['id']; ?></td>
<td><?php echo htmlspecialchars($q['profession_name']); ?></td>
<td><?php echo htmlspecialchars($q['question_text']); ?></td>
<td><?php echo htmlspecialchars($q['option1']); ?></td>
<td><?php echo htmlspecialchars($q['option2']); ?></td>
<td><?php echo htmlspecialchars($q['option3']); ?></td>
<td><?php echo htmlspecialchars($q['option4']); ?></td>
<td><?php echo $q['correct_option']; ?></td>
</tr>
<?php endforeach; ?>
</table>
<?php else: ?>
<p>Нет вопросов.</p>
<?php endif; ?>
<?php endif; ?>

<br>
<form action="../home_admine.php" method="GET">
    <button type="submit">Вернуться назад</button>
</form>

</body>
</html>