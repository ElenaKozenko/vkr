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
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Результаты</title>
</head>
<body>
    <?php
        get_header(); 
        include ('db.php');
    //Вывод перечня студентов из представления
    function getAllStudents($db)
    {
        $inst = $_SESSION['user'];
        if ($_SESSION['status'] === 'instructor' ) {
            $sql="SELECT * FROM students WHERE instructor = $inst;";
        }
        else if ($_SESSION['status'] === 'admin') {
            $sql="SELECT * FROM students;";
        }      
        $result=array();
        $stmt=$db->prepare($sql);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {$result[$row['u_id']] = $row;}
        return $result;
    }
  $students = getAllStudents($db);?>
  <div class="container">
    <p style="margin: 10px;">Выбирете студента из списка, затем нажмите кнопку "Отобразить"</p>
    <div class="col-md-4">
        <form action="std_result.php" method="post" target="_blank">
            <div class="form-group">
                <label for="std">Студент:</label> <!-- перечень студентов -->
                <select id="std" name="std" class="form-control">
                    <?php foreach ($students as $row){
                $id = $row['u_id'];
                $name = $row['fio'];
                echo "<option value=\"".$id.",".$name."\">$name</option>";}?>
                </select>
            </div>
            <input type="submit" value="Отобразить" class="btn btn-secondary">
        </form>
    </div>
</div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>