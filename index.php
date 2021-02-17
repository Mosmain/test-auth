<?php header('Content-type: text/html; charset=utf-8'); 
require_once 'connect.php';

$sql = "SELECT * FROM users";
$result = $db->query($sql);
$users = $result->fetchAll(PDO::FETCH_ASSOC);

foreach ($users as $user) {
    echo "{$user['id']} {$user['login']} {$user['pass']}. <hr />";
}

// $sql = "INSERT INTO users (login, pass) VALUES (:login, :pass)";
// $stmt = $db->prepare($sql);

// $login = "kek";
// $pass = "puk";

// $stmt->bindValue(':login', $login);
// $stmt->bindValue(':pass', $pass);
// $stmt->execute();

// проверка пустоты полей password и login
if (!empty($_REQUEST['password']) and !empty($_REQUEST['login'])) {
    
    $login = trim($_REQUEST['login']);
    $password = trim($_REQUEST['password']);

    echo $login, $password;
}

?>

<form action='index.php' method='POST'>
    <input name='login'>
    <input name='password' type='password'>
    <input type='submit' value='Отправить'>
</form>
