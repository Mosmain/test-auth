<?php

$host = '127.0.0.1';
$db   = 'test_auth';
$user = 'root';
$pass = '';
$port = "3306";
$charset = 'utf8mb4';

$options = [
    // Режим сообщений об ошибках => Выбрасывать исключения
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    // режим выборки данных => массив, индексированный именами столбцов результирующего набора
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    // Выключение эмуляции подготавливаемых запросов
    PDO::ATTR_EMULATE_PREPARES   => false,
];

$dsn = "mysql:host=$host;dbname=$db;charset=$charset;port=$port";

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}
?>
