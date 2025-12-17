<?php
// Редактировать профессию
session_start();
require_once '../../resource/connect.php';

$message = "";

// Получаем список профессий из БД
try {
    $stmt = $pdo->query("SELECT id, name FROM professions ORDER BY id");
    $professions = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $professions = [];
    $message = "Ошибка при получении профессий: " . $e->getMessage();
}

// Редактирование профессии
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['profession_id_select'], $_POST['new_profession_name'])) {
    $profession_id = $_POST['profession_id_select'];
    $new_name = trim($_POST['new_profession_name']);

    if ($new_name) {
        try {
            $stmt = $pdo->prepare("UPDATE professions SET name = ? WHERE id = ?");
            $stmt->execute([$new_name, $profession_id]);
            $message = "Профессия успешно обновлена!";
            // Обновляем список после изменения
            $stmt = $pdo->query("SELECT id, name FROM professions ORDER BY id");
            $professions = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $message = "Ошибка при обновлении профессии: " . $e->getMessage();
        }
    } else {
        $message = "Введите новое название профессии.";
    }
}

// Удаление профессии
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_profession_id'])) {
    $delete_id = $_POST['delete_profession_id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM professions WHERE id = ?");
        $stmt->execute([$delete_id]);
        $message = "Профессия успешно удалена!";
        // Обновляем список после удаления
        $stmt = $pdo->query("SELECT id, name FROM professions ORDER BY id");
        $professions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $message = "Ошибка при удалении профессии: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактировать профессию</title>
</head>
<body>

<h1>Редактирование профессии</h1>

<?php if (!empty($message)): ?>
    <div>
        <strong><?php echo htmlspecialchars($message); ?></strong>
    </div>
    <br>
<?php endif; ?>

<form action="" method="POST">
    <div>
        <label for="profession_id_select">Выберите профессию для редактирования:</label><br>
        <select id="profession_id_select" name="profession_id_select" required>
            <option value="">Выберите профессию</option>
            <?php foreach ($professions as $p): ?>
                <option value="<?php echo $p['id']; ?>"><?php echo htmlspecialchars($p['name']); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <br>

    <div>
        <label for="new_profession_name">Новое название профессии:</label><br>
        <input type="text" id="new_profession_name" name="new_profession_name" required>
    </div>
    <br>

    <div>
        <input type="submit" value="Обновить профессию">
        <input type="reset" value="Очистить">
    </div>
</form>

<h2>Удаление профессии</h2>
<form action="" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить эту профессию?');">
    <div>
        <label for="delete_profession_id">Выберите профессию для удаления:</label><br>
        <select id="delete_profession_id" name="delete_profession_id" required>
            <option value="">Выберите профессию</option>
            <?php foreach ($professions as $p): ?>
                <option value="<?php echo $p['id']; ?>"><?php echo htmlspecialchars($p['name']); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <br>

    <div>
        <input type="submit" value="Удалить профессию" style="color: red;">
    </div>
</form>

<div>
    <form id="home_admine" action="../home_admine.php" method="GET">
        <button type="submit" class="btn">Вернуться назад</button>
    </form>
</div>

</body>
</html>