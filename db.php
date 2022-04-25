<?php
try {
    $host = 'localhost';
    $port = 3307;
    $dbname = 'testpdd0';
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname";
    $username = 'root';
    $passwd = 'root';
    $opt = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
/*         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false, */
    ];
    $db = new PDO($dsn, $username, $passwd, $opt);
} 
catch (PDOException $e)
 { echo $e->getMessage(); }
?>


<!-- $host = '127.0.0.1';
    $db   = 'test';
    $user = 'root';
    $pass = '';
    $charset = 'utf8';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $opt = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new PDO($dsn, $user, $pass, $opt);
    Плюс очень удобно задать FETCH_MODE по умолчанию, чтобы не писать его в КАЖДОМ запросе, как это очень любят делать прилежные хомячки. -->