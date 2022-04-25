<?php include('header.php'); 
  get_session();
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Результаты</title>
    <style>
    table,
    td {
        border: 1px solid black;
    }
    </style>
</head>

<body>
    <?php
        get_header(); 
        include ('db.php');


    //Вывод перечня студентов из представления
    function getAllStudents($db)
    {
        $sql="SELECT * FROM students;";
        $result=array();
        $stmt=$db->prepare($sql);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {$result[$row['u_id']] = $row;}
        return $result;
    }

  $students = getAllStudents($db);
    ?>
    <p>Выбирете студента из списка, затем нажмите кнопку "Отобразить"</p>
<form action="std_result.php" method="post" target="_blank">
    <label for="std">Студент:</label> <!-- перечень студентов -->
    <select id="std" name="std">
        <?php foreach ($students as $row){
                $id = $row['u_id'];
                $name = $row['fio'];
                echo "<option value=\"".$id.",".$name."\">$name</option>";}?>
    </select>
<input type="submit" value="Отобразить">
   </form> 

    </script>
</body>
</html>