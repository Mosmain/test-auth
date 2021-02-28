<?php
require_once 'connect.php';
session_start();

// проверка пустоты полей password и login
if (isset($_POST['password']) and isset($_POST['login'])) {

    // отсечение лишнего у login
    $login = trim($_POST['login']);

    // хеширование пароля
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

    // запись введенных данных
    $data = [
        'login' => $login,
        'password' => $password
    ];

    // выборка логина
    $stmt = $pdo->prepare("SELECT * FROM `users` WHERE `login` = ?");
    $stmt->execute(array($login));
    $checkLogin = $stmt->fetch(PDO::FETCH_ASSOC);

    // проверка на существования логина в бд
    if (empty($checkLogin)) {
        echo 'not exists';
        $sql = "INSERT INTO users (login, password) VALUES (:login, :password)";
        $stmt = $pdo->prepare($sql)->execute($data);
        $_SESSION["user"] = $login;
    } else {
        echo 'exists';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php $_SESSION['user']?></title>
</head>
<body>
<?php if(isset($_SESSION['user'])): ?>

<p>Welcome, <?php echo $_SESSION['user']; ?>!</p>

<p>Wanna go <a href="/test-auth">back</a>?</p>
<p>Wanna <a href="logout.php">exit</a>?</p>

<?php else: ?>

<p>You dont have permissions</p>
<?php echo $_SESSION['user']; ?>

<?php endif; ?>


</body>
</html>