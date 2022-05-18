<?php session_start();
include('header.php'); 
get_session();?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf8mb4">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="style.css" type="text/css" />
    <title>Пользователи</title>
    <style>
        a{color: black;}
    </style>
</head>
<body>
    <?php
    get_header();
    include 'db.php';
    function getAllUsers($db)
{
$sql="SELECT * FROM users ORDER BY surname;";
$result=array();
$stmt=$db->prepare($sql);
$stmt->execute();
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {$result[$row['u_id']] = $row;}
return $result;
}
    $users = getAllUsers($db);
    $n=0;
    ?>
    <div class="container">

  <p>Нажмите имя, чтобы перейти к редактированию данных пользователя.</p><div class="tkt">
  <?php

    foreach ($users as $row) {
        $u_id = $row['u_id'];
        $n++;
        echo "<div><a href=\"uedit.php?u_id=$u_id\">".$n.". ".$row['surname']." ".$row['name']." ".$row['patr']."</a></div>";
    }
echo "</div>";
    ?>
<!--     <div>
        <br><a href="uedit.php?u_id=null" class="btn btn-secondary">Создать нового сотрудника</a>
    </div> -->
</div>
</body>

</html>