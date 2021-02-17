<?php

$dsn = 'mysql:dbname=test_auth;host=127.0.0.1:3306';
$user = 'root';
$password = '';

try {
    $db = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>
