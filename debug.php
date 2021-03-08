<?php
require_once 'connect.php';
session_start();


if (isset($_POST['clear_yes'])) {
    $sql = "DELETE FROM users";
    $stmt = $pdo->prepare($sql)->execute($data);
    header('Location: index.php');
} elseif(isset($_POST['clear_no'])) {
    header('Location: index.php');
}
?>

<?php if (isset($_POST['clear'])): ?>
    <h3>Вы уверены?</h3>
    <form method="POST">
        <input type="submit" name="clear_yes" value="yes" />
        <input type="submit" name="clear_no" value="no" />
    </form>
<?php else: ?>
    <p>Что-то пошло не так..</p>
    <a href="index.php">домой</a>
<?php endif; ?>