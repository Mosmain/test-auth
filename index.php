<?php 
header('Content-type: text/html; charset=utf-8');
session_start(); 
require_once 'connect.php';

// вывод всех пользователей
$sql = "SELECT * FROM users";
$result = $pdo->query($sql);
$users = $result->fetchAll(PDO::FETCH_ASSOC);

foreach ($users as $user) {
    echo "{$user['id']} {$user['login']} {$user['password']} <hr />";
}

// проверка пустоты полей password и login
if (!empty($_REQUEST['password']) and !empty($_REQUEST['login'])) {
    
    // отсечение лишнего у login
    $login = trim($_REQUEST['login']);

    // хеширование пароля
    $password = password_hash(trim($_REQUEST['password']), PASSWORD_DEFAULT);

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
    } else {
        echo 'exists';
    }

}

?>

<form action='index.php' method='POST'>
    <input name='login'>
    <input name='password' type='password'>
    <input type='submit' value='Отправить'>
</form>
