<?php
session_start();
require_once 'config.php';

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

// Сохраняем ответы и подсчитываем правильные
foreach($questions as $question) {
    $questionId = $question['id'];
    $userAnswer = isset($userAnswers[$questionId]) ? (int)$userAnswers[$questionId] : 0;
    $correctAnswer = $question['correct_option'];
    
    // Сохраняем ответ в базу данных
    $stmt = $pdo->prepare("
        INSERT INTO results (user_name, profession_id, question_id, user_answer) 
        VALUES (?, ?, ?, ?)
    ");
    $stmt->execute([$userName, $professionId, $questionId, $userAnswer]);
    
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
        
        <div class="content">
            <div class="result">
                <h2><?= htmlspecialchars($userName) ?>, ваш результат:</h2>
                <div class="score"><?= $score ?>%</div>
                <p>Правильных ответов: <?= $correctAnswers ?> из <?= $totalQuestions ?></p>
                
                <div class="progress">
                    <div class="progress-bar" style="width: <?= $score ?>%"></div>
                </div>
                
                <?php if($score >= 80): ?>
                    <p style="color: #27ae60; font-size: 1.2em;">Отличный результат!</p>
                <?php elseif($score >= 60): ?>
                    <p style="color: #f39c12; font-size: 1.2em;">Хороший результат!</p>
                <?php else: ?>
                    <p style="color: #e74c3c; font-size: 1.2em;">Попробуйте еще раз!</p>
                <?php endif; ?>
                
                <a href="index.php" class="btn" style="margin-top: 20px;">Пройти еще раз</a>
            </div>
        </div>
    </div>
</body>
</html>