<?php
session_start();
require_once 'resource/connect.php';

if(!isset($_SESSION['quiz_data']) || !isset($_POST['answers'])) {
    header('Location: index.php');
    exit();
}

$quizData = $_SESSION['quiz_data'];
$userAnswers = $_POST['answers'];
$userName = $quizData['user_name'];
$professionId = $quizData['profession_id'];
$questions = $quizData['questions'];

$correctAnswers = 0;
$totalQuestions = count($questions);

// Альтернативный вариант - шифрование через PostgreSQL функцию
$stmt = $pdo->prepare("SELECT encrypt_name(?) as encrypted_name");
$stmt->execute([$userName]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$pgEncryptedName = $result['encrypted_name'];

// Сохраняем ответы и подсчитываем правильные
foreach($questions as $question) {
    $questionId = $question['id'];
    $userAnswer = isset($userAnswers[$questionId]) ? (int)$userAnswers[$questionId] : 0;
    $correctAnswer = $question['correct_option'];

    // Сохраняем ответ в базу данных с шифрованным именем
    $stmt = $pdo->prepare("
        INSERT INTO results (encrypted_name, profession_id, question_id, user_answer) 
        VALUES (?, ?, ?, ?)
    ");
    $stmt->execute([$pgEncryptedName, $professionId, $questionId, $userAnswer]);
    
    if($userAnswer === $correctAnswer) {
        $correctAnswers++;
    }
}

$score = round(($correctAnswers / $totalQuestions) * 100);

// Очищаем сессию
unset($_SESSION['quiz_data']);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Результаты теста</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Результаты теста</h1>
        </div>
        
        <div>
            <div class="result">
                <?php if($score >= 70): ?>
                    <div class="result-score"><h1 style="color: #27ae60; font-size: 32px;">ВЫ СДАЛИ</p></div>
                <?php else: ?>
                    <div class="result-score"><h1 style="color: #e74c3c; font-size: 32px;">ВЫ НЕ СДАЛИ</p></div>
                <?php endif; ?>

                <h2><?= htmlspecialchars($userName) ?>, ваш результат:</h2>
                <div class="score"><?= $score ?>%</div>
                <p>Правильных ответов: <?= $correctAnswers ?> из <?= $totalQuestions ?></p>
                
                <div class="progress">
                    <div class="progress-bar" style="width: <?= $score ?>%"></div>
                </div>
                
                <div style="padding-top: 20px;"><a href="index.php" class="btn">Пройти еще раз</a></div>
            </div>
        </div>
    </div>
</body>
</html>