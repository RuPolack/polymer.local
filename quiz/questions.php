<?php
require_once '../resource/connect.php';

$stmt = $pdo->query("SELECT * FROM professions ORDER BY id");
$professions = $stmt->fetchAll(PDO::FETCH_ASSOC);

$professionId = isset($_GET['profession_id']) ? (int)$_GET['profession_id'] : 0;

$questions = [];
$professionName = '';

if ($professionId > 0) {
    $stmt = $pdo->prepare("
        SELECT q.*, p.name as profession_name 
        FROM questions q
        LEFT JOIN professions p ON q.profession_id = p.id
        WHERE q.profession_id = ?
        ORDER BY q.id
    ");
    $stmt->execute([$professionId]);
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (!empty($questions)) {
        $professionName = $questions[0]['profession_name'];
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вопросы для подготовки</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container preparation-container">
        <div class="header">
            <h1>Вопросы для подготовки</h1>
            <p>Выберите профессию для просмотра вопросов</p>
        </div>
        <div class="content">
            <div class="profession-selector">
                <h3>Выберите профессию:</h3>
                <div class="selector-grid">
                    <div class="profession-btn <?= $professionId == 0 ? 'active' : '' ?>" 
                         onclick="window.location.href='questions.php'">
                        Все профессии
                    </div>
                    <?php foreach($professions as $prof): ?>
                        <div class="profession-btn <?= $professionId == $prof['id'] ? 'active' : '' ?>" 
                             onclick="window.location.href='questions.php?profession_id=<?= $prof['id'] ?>'">
                            <?= htmlspecialchars($prof['name']) ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <div style="text-align: center; margin-bottom: 30px;">
                <a href="../index.php" class="btn">
                    Вернуться
                </a>
            </div>

            <?php if(!empty($questions)): ?>
                <div class="questions-header">
                    <h2>Вопросы для профессии: <?= htmlspecialchars($professionName) ?></h2>
                    <p>Количество вопросов: <?= count($questions) ?></p>
                </div>
                
                <?php foreach($questions as $index => $question): ?>
                    <div class="question-card">
                        <div class="question-text">
                            Вопрос <?= $index + 1 ?> - 
                            <?= nl2br(htmlspecialchars($question['question_text'])) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
                
            <?php elseif($professionId > 0): ?>
                <div class="empty-state">
                    <h3>Вопросы не найдены</h3>
                    <p>Для выбранной профессии пока нет вопросов.</p>
                    <p>Попробуйте выбрать другую профессию.</p>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <h3>Выберите профессию</h3>
                    <p>Для просмотра вопросов выберите профессию из списка выше.</p>
                    <p>Вы увидите все доступные вопросы для подготовки.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>