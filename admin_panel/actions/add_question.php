<?php // Добавить вопрос
require_once '../../resource/connect.php';
require_once '../../admin_panel/login_verification_admin/login_verification_admin.php';

$message = "";

// Получаем список профессий для динамического select
try {
    $stmt = $pdo->query("SELECT id, name FROM professions ORDER BY name");
    $professions = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $professions = [];
    $message = "Ошибка при получении списка профессий: " . $e->getMessage();
}

// Проверка отправки формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $profession_id = $_POST['profession_id'] ?? '';
    $question_text = trim($_POST['question_text'] ?? '');
    $option1 = trim($_POST['option1'] ?? '');
    $option2 = trim($_POST['option2'] ?? '');
    $option3 = trim($_POST['option3'] ?? '');
    $option4 = trim($_POST['option4'] ?? '');
    $correct_option = $_POST['correct_option'] ?? '';

    if ($profession_id && $question_text && $option1 && $option2 && $option3 && $option4 && $correct_option) {
        try {
            $sql = "INSERT INTO questions (profession_id, question_text, option1, option2, option3, option4, correct_option)
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$profession_id, $question_text, $option1, $option2, $option3, $option4, $correct_option]);

            $message = "Вопрос успешно добавлен!";
        } catch (PDOException $e) {
            $message = "Ошибка при добавлении: " . $e->getMessage();
        }
    } else {
        $message = "Заполните все поля формы.";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Добавить вопрос</title>
    <link rel="stylesheet" href="../css_abmin/css_abmin.css">
</head>

<body>

    <h1>Добавление нового вопроса</h1>

    <?php if (!empty($message)): ?>
        <div>
            <strong><?php echo htmlspecialchars($message); ?></strong>
        </div>
        <br>
    <?php endif; ?>

    <form action="" method="POST">
        <div>
            <label for="profession_id">Профессия:</label><br>
            <select id="profession_id" name="profession_id" required>
                <option value="">Выберите профессию</option>
                <?php foreach ($professions as $profession): ?>
                    <option value="<?php echo $profession['id']; ?>">
                        <?php echo htmlspecialchars($profession['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <br>

        <div>
            <label for="question_text">Текст вопроса:</label><br>
            <textarea id="question_text" name="question_text" rows="3" cols="50" required><?php echo htmlspecialchars($_POST['question_text'] ?? ''); ?></textarea>
        </div>
        <br>

        <div>
            <label for="option1">Вариант ответа 1:</label><br>
            <input type="text" id="option1" name="option1" value="<?php echo htmlspecialchars($_POST['option1'] ?? ''); ?>" required>
        </div>
        <br>

        <div>
            <label for="option2">Вариант ответа 2:</label><br>
            <input type="text" id="option2" name="option2" value="<?php echo htmlspecialchars($_POST['option2'] ?? ''); ?>" required>
        </div>
        <br>

        <div>
            <label for="option3">Вариант ответа 3:</label><br>
            <input type="text" id="option3" name="option3" value="<?php echo htmlspecialchars($_POST['option3'] ?? ''); ?>" required>
        </div>
        <br>

        <div>
            <label for="option4">Вариант ответа 4:</label><br>
            <input type="text" id="option4" name="option4" value="<?php echo htmlspecialchars($_POST['option4'] ?? ''); ?>" required>
        </div>
        <br>

        <div>
            <label for="correct_option">Правильный вариант:</label><br>
            <select id="correct_option" name="correct_option" required>
                <option value="">Выберите правильный ответ</option>
                <option value="1" <?php if (($_POST['correct_option'] ?? '') === '1') echo 'selected'; ?>>Вариант 1</option>
                <option value="2" <?php if (($_POST['correct_option'] ?? '') === '2') echo 'selected'; ?>>Вариант 2</option>
                <option value="3" <?php if (($_POST['correct_option'] ?? '') === '3') echo 'selected'; ?>>Вариант 3</option>
                <option value="4" <?php if (($_POST['correct_option'] ?? '') === '4') echo 'selected'; ?>>Вариант 4</option>
            </select>
        </div>
        <br>

        <div>
            <input type="submit" value="Добавить вопрос">
            <input type="reset" value="Очистить форму">
        </div>
    </form>

    <div>
        <form id="home_admine" action="../home_admine.php" method="GET">
            <button type="submit" class="btn">Вернуться назад</button>
        </form>
    </div>
</body>

</html>