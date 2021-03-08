<?php
header('Content-type: text/html; charset=utf-8');
require_once 'connect.php';
require_once 'avatar.php';
session_start();

$a = 4;

$path = 'upload/';
$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

// проверка пустоты полей password и login
if (isset($_POST['password']) and isset($_POST['login']) and !empty($_FILES['picture']['name'])) {

    // отсечение лишнего у login
    $login = trim($_POST['login']);

    // хеширование пароля
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // расширение файла по-умному
        $pathinfo = pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);

        // расширение файла как обычно
        // $pathinfo = strrchr($_FILES['picture']['name'], '.');

        // название фото = названиеФото.расширение
        $photoName = substr(str_shuffle($permitted_chars), 0, 20). '.' . $pathinfo;

        if (!@copy($_FILES['picture']['tmp_name'], $path . $photoName)) {
            echo 'Что-то пошло не так';
        } else {
            echo 'Загрузка удачна<br>';
            echo 'путь = ', $path . $photoName, '<br>';
            echo 'name = ', $_FILES['picture']['name'], '<br>';
            echo 'type = ', $_FILES['picture']['type'], '<br>';
            echo 'size = (', $_FILES['picture']['size'], '/1048576)<br>';
            echo 'tmp_name = ', $_FILES['picture']['tmp_name'], '<br>';
            echo 'error = ', $_FILES['picture']['error'], '<br>';
            echo 'file = ', strrchr($_FILES['picture']['name'], '.');

            $avatar = $path . $photoName;
        }
    }

    // запись введенных данных
    $data = [
        'login' => $login,
        'password' => $password,
        'avatar' => $avatar
    ];

    // выборка логина
    $stmt = $pdo->prepare("SELECT * FROM `users` WHERE `login` = ?");
    $stmt->execute(array($login));
    $checkLogin = $stmt->fetch(PDO::FETCH_ASSOC);

    // проверка на существования логина в бд
    if (empty($checkLogin)) {
        $sql = "INSERT INTO users (login, password, avatar) VALUES (:login, :password, :avatar)";
        $stmt = $pdo->prepare($sql)->execute($data);
        $_SESSION["user"] = $login;

        // header('Location: login.php');
    } else {
        echo '<div class="alert alert-danger m-2" role="alert">
                Пользователь уже существует!
              </div>';
    }

}
// echo strrchr('doily.ua.com', '.');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // расширение файла по-умному
    $pathinfo = pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);

    // расширение файла как обычно
    // $pathinfo = strrchr($_FILES['picture']['name'], '.');

    // название фото = названиеФото.расширение
    $photoName = substr(str_shuffle($permitted_chars), 0, 20). '.' . $pathinfo;

    if ($_FILES['picture']['size'] <= 1024*1024) {
        echo 'File done!<br>';
        echo 'size = (', $_FILES['picture']['size'], '/' . (1024*1024) . ')<br>';
    } else {
        echo 'File to weight!<br>';
        echo 'size = (', $_FILES['picture']['size'], '/' . (1024*1024) . ')<br>';
    }

    if (!@copy($_FILES['picture']['tmp_name'], $path . $photoName)) {
        echo 'Что-то пошло не так';
    } else {
        echo 'Загрузка удачна<br>';
        // echo 'путь = ', $path . $photoName, '<br>';
        // echo 'name = ', $_FILES['picture']['name'], '<br>';
        // echo 'type = ', $_FILES['picture']['type'], '<br>';
        // echo 'size = (', $_FILES['picture']['size'], '/1048576)<br>';
        // echo 'tmp_name = ', $_FILES['picture']['tmp_name'], '<br>';
        // echo 'error = ', $_FILES['picture']['error'], '<br>';
        // echo 'file = ', strrchr($_FILES['picture']['name'], '.');
        var_dump($_FILES['picture']);
    }
}


// вывод всех пользователей
$sql = "SELECT * FROM users";
$result = $pdo->query($sql);
$users = $result->fetchAll(PDO::FETCH_ASSOC);

foreach ($users as $user) {
    echo "<p class='m-2'>{$user['id']} {$user['login']} {$user['password']} <img style='width:50px;' src='{$user['avatar']}'></p><hr class='m-2'>";
}

?>

<?php if (!isset($_SESSION['user'])): ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

<style type="text/css">
.tabs { width: auto; padding: 0px; margin: 0 auto; }
.tabs>input { display: none; }
.tabs>div {
    display: none;
    padding: 12px;
    border: 1px solid #C0C0C0;
    background: #FFFFFF;
}
.tabs>label {
    display: inline-block;
    padding: 7px;
    margin: 0 -5px -1px 0;
    text-align: center;
    color: #666666;
    border: 1px solid #C0C0C0;
    background: #E0E0E0;
    cursor: pointer;
}
.tabs>input:checked + label {
    color: #000000;
    border: 1px solid #C0C0C0;
    border-bottom: 1px solid #FFFFFF;
    background: #FFFFFF;
}
#tab_register:checked ~ #register,
#tab_login:checked ~ #login { display: block; }
</style>

<div class="tabs m-2">
    <input type="radio" name="inset" value="" id="tab_register" checked>
    <label for="tab_register">register</label>

    <input type="radio" name="inset" value="" id="tab_login">
    <label for="tab_login">login</label>

    <div id="register">
        <h3>Register</h3>
        <form method='POST' enctype="multipart/form-data">
            <input name='login' placeholder='Login' required />
            <input name='password' type='password' placeholder='Password' required />
            <input type='submit' value='Отправить'><br>
            <input name="picture" type="file" required />
        </form>
        <p>go to <a href="login.php">login.php</a></p>
        <form action='debug.php' method="POST">
            <input type="submit" name="clear" value="clear users" />
        </form>
    </div>
    <div id="login">
        <h3>Login</h3>
        <form action='login.php' method='POST'>
            <input name='login' placeholder='Login'>
            <input name='password' type='password' placeholder='Password'>
            <input type='submit' value='Отправить'>
        </form>
    </div>
</div>

<?php else: ?>

<p>Wanna <a href="logout.php">exit</a>?</p>

<p>go to <a href="login.php">login.php</a></p>

<? if(isset($_SESSION['user'])): ?>
    <p>name you session is <?php echo $_SESSION['user']; ?></p>
<? else: ?>
    <p>your session is <b>broken!</b></p>
<? endif; ?>

<?php endif; ?>
