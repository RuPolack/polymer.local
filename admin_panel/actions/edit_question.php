<?php // Редактировать вопрос
session_start();
require_once '../../resource/connect.php'; ?>

<?php
$message = "";

// Получаем список вопросов из БД
try {
    $stmt = $pdo->query("SELECT id, question_text FROM questions ORDER BY id");
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $questions = [];
    $message = "Ошибка при получении вопросов: " . $e->getMessage();
}

// Редактирование вопроса
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['question_id_select'])) {
    $question_id = $_POST['question_id_select'];
    $edit_question_text = $_POST['edit_question_text'] ?? '';
    $edit_option1 = $_POST['edit_option1'] ?? '';
    $edit_option2 = $_POST['edit_option2'] ?? '';
    $edit_option3 = $_POST['edit_option3'] ?? '';
    $edit_option4 = $_POST['edit_option4'] ?? '';
    $edit_correct_option = $_POST['edit_correct_option'] ?? '';

    if ($edit_question_text && $edit_option1 && $edit_option2 && $edit_option3 && $edit_option4 && $edit_correct_option) {
        try {
            $sql = "UPDATE questions
                    SET question_text = ?, option1 = ?, option2 = ?, option3 = ?, option4 = ?, correct_option = ?
                    WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$edit_question_text, $edit_option1, $edit_option2, $edit_option3, $edit_option4, $edit_correct_option, $question_id]);
            $message = "Вопрос успешно обновлен!";
        } catch (PDOException $e) {
            $message = "Ошибка при обновлении: " . $e->getMessage();
        }
    } else {
        $message = "Заполните все поля для редактирования.";
    }
}

// Удаление вопроса
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_question_id'])) {
    $delete_question_id = $_POST['delete_question_id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM questions WHERE id = ?");
        $stmt->execute([$delete_question_id]);
        $message = "Вопрос успешно удален!";
        // Обновляем список вопросов после удаления
        $stmt = $pdo->query("SELECT id, question_text FROM questions ORDER BY id");
        $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $message = "Ошибка при удалении: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Редактировать вопрос</title>
    <link rel="stylesheet" href="../css_abmin/css_abmin.css">
</head>

<body>

    <h1>Редактирование вопроса</h1>

    <?php if (!empty($message)): ?>
        <div>
            <strong><?php echo htmlspecialchars($message); ?></strong>
        </div>
        <br>
    <?php endif; ?>

    <form action="" method="POST">
        <div>
            <label for="question_id_select">Выберите вопрос для редактирования:</label><br>
            <select id="question_id_select" name="question_id_select" required>
                <option value="">Выберите вопрос</option>
                <?php foreach ($questions as $q): ?>
                    <option value="<?php echo $q['id']; ?>"><?php echo htmlspecialchars($q['question_text']); ?></option>
                <?php endforeach; ?>
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
                <?php foreach ($questions as $q): ?>
                    <option value="<?php echo $q['id']; ?>"><?php echo htmlspecialchars($q['question_text']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <br>

        <div>
            <input type="submit" value="Удалить вопрос">
        </div>
    </form>

    <div>
        <form id="home_admine" action="../home_admine.php" method="GET">
            <button type="submit" class="btn">Вернуться назад</button>
        </form>
    </div>
</body>

</html>