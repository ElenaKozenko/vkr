<?php
try {
    $host = 'localhost';
    $port = 3307; //3307
    //TCP-порт 3306 для MYSQL   
   // $dbname = 'testpdd0';
    $dbname = 'testpdd1';
    $charset = 'utf8';
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=$charset";
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