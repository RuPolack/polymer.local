<?php
session_start();
require_once '../resource/connect.php';

if(!isset($_GET['name']) || !isset($_GET['profession'])) {
    header('Location: index.php');
    exit();
}

$userName = $_GET['name'];
$professionId = $_GET['profession'];

// Получаем 10 случайных вопросов для выбранной профессии
$stmt = $pdo->prepare("
    SELECT * FROM questions 
    WHERE profession_id = ? 
    ORDER BY RANDOM() 
    LIMIT 10
");
$stmt->execute([$professionId]);
$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

if(empty($questions)) {
    die("Вопросы для этой профессии не найдены.");
}

// Сохраняем вопросы в сессии
$_SESSION['quiz_data'] = [
    'user_name' => $userName,
    'profession_id' => $professionId,
    'questions' => $questions,
    'start_time' => date('Y-m-d H:i:s')
];
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Тестирование</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Тестирование</h1>
            <p>Пользователь: <?= htmlspecialchars($userName) ?></p>
        </div>
        
        <div class="content">
            <form id="quizForm" action="process_quiz.php" method="POST">
                <?php foreach($questions as $index => $question): ?>
                <div class="question">
                    <h3>Вопрос <?= $index + 1 ?>: <?= htmlspecialchars($question['question_text']) ?></h3>
                    <div class="options">
                        <?php for($i = 1; $i <= 4; $i++): ?>
                            <div class="option" onclick="selectOption(this, <?= $question['id'] ?>, <?= $i ?>)">
                                <?= htmlspecialchars($question['option' . $i]) ?>
                            </div>
                        <?php endfor; ?>
                    </div>
                    <input type="hidden" name="answers[<?= $question['id'] ?>]" id="answer_<?= $question['id'] ?>">
                </div>
                <?php endforeach; ?>
                
                <button type="submit" class="btn btn-success">Завершить тест</button>
            </form>
        </div>
    </div>

    <script>
        function selectOption(element, questionId, optionNumber) {
            // Снимаем выделение с других вариантов в этом вопросе
            const options = element.parentElement.querySelectorAll('.option');
            options.forEach(opt => opt.classList.remove('selected'));
            
            // Выделяем выбранный вариант
            element.classList.add('selected');
            
            // Сохраняем выбор в скрытом поле
            document.getElementById('answer_' + questionId).value = optionNumber;
        }
    </script>
</body>
</html>