<?php //Добавить профессию
require_once '../../resource/connect.php';
require_once '../../admin_panel/login_verification_admin/login_verification_admin.php';

$message = "";

// Проверка отправки формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $professionName = trim($_POST['professionName'] ?? '');

    if ($professionName) {
        try {
            $stmt = $pdo->prepare("INSERT INTO professions(name) VALUES (?)");
            $stmt->execute([$professionName]);
            $message = "Профессия успешно добавлена!";
        } catch (PDOException $e) {
            $message = "Ошибка при добавлении профессии: " . $e->getMessage();
        }
    } else {
        $message = "Введите название профессии.";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Добавление профессии</title>
    <link rel="stylesheet" href="../css_abmin/css_abmin.css">
</head>

<body>

    <h1>Добавление новой профессии</h1>

    <?php if (!empty($message)): ?>
        <div>
            <strong><?php echo htmlspecialchars($message); ?></strong>
        </div>
        <br>
    <?php endif; ?>

    <form action="" method="POST">
        <div>
            <label for="professionName">Название профессии:</label><br>
            <input type="text" id="professionName" name="professionName" required>
        </div>
        <br>
        <div>
            <input type="submit" value="Добавить профессию">
        </div>
    </form>

    <br>
    <div>
        <form id="home_admine" action="../home_admine.php" method="GET">
            <button type="submit" class="btn">Вернуться назад</button>
        </form>
    </div>

</body>

</html>