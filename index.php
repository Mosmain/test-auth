<?php
header('Content-type: text/html; charset=utf-8');
require_once 'connect.php';
session_start();

// вывод всех пользователей
$sql = "SELECT * FROM users";
$result = $pdo->query($sql);
$users = $result->fetchAll(PDO::FETCH_ASSOC);

foreach ($users as $user) {
    echo "{$user['id']} {$user['login']} {$user['password']} <hr />";
}

?>

<?php if (!isset($_SESSION['user'])): ?>

<!-- <form action='index.php' method='POST'>
    <input name='login'>
    <input name='password' type='password'>
    <input type='submit' value='Отправить'>
</form> -->

<style type="text/css">
.tabs { width: 100%; padding: 0px; margin: 0 auto; }
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

<div class="tabs">
    <input type="radio" name="inset" value="" id="tab_register" checked>
    <label for="tab_register">register</label>

    <input type="radio" name="inset" value="" id="tab_login">
    <label for="tab_login">login</label>

    <div id="register">
        <form action='login.php' method='POST'>
            <input name='login'>
            <input name='password' type='password'>
            <input type='submit' value='Отправить'>
        </form>
    </div>
    <div id="login">
    <form action='index.php' method='POST'>
        <input name='login'>
        <input name='password' type='password'>
        <input type='submit' value='Отправить'>
    </form>
    </div>
</div>

<?php else: ?>

<p>Wanna <a href="logout.php">exit</a>?</p>
<p>you session is <?php $_SESSION['user']; ?></p>

<?php endif; ?>
