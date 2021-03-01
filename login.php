<?php
header('Content-type: text/html; charset=utf-8');
require_once 'connect.php';
session_start();

// проверка пустоты полей password и login
if (isset($_POST['password']) and isset($_POST['login'])) {

    // отсечение лишнего у login
    $login = trim($_POST['login']);

    // запись введенных данных
    $data = [
        'login' => $login
    ];

    // выборка логина
    $stmt = $pdo->prepare("SELECT * FROM `users` WHERE `login` = ?");
    $stmt->execute(array($login));
    $check = $stmt->fetch(PDO::FETCH_ASSOC);

    // проверка на существования логина в бд
    if (($check['login'] == $login) and (password_verify($_POST['password'], $check['password']))) {
        $_SESSION["user"] = $login;
        
        echo password_verify($_POST['password'], $password);
        echo $_POST['password'], '<br>';
        echo $check['password'];
    } else {
        echo '<div class="alert alert-danger m-2" role="alert">
                Неверно введен логин или пароль!
              </div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $_SESSION['user']; ?></title>
</head>
<body>

<? if (isset($_SESSION['user'])): ?>

    <h1>Session name <?php echo $_SESSION['user']; ?></h1>
    <p>Wanna go <a href="/test-auth">back</a>?</p>
    <p>Wanna <a href="logout.php">exit</a>?</p>

<? else: ?>

    <h1>Session <b>broken!</b></h1>
    <p>you dont have permissions</p>
    <p>Wanna go <a href="/test-auth">back</a>?</p>

<? endif; ?>

</body>
</html>