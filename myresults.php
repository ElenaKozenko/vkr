<?php session_start();
include('header.php'); 
get_session();?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="utf8mb4">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Мои результаты</title>
</head>
<body>
    <?php
        get_header(); 
        include ('db.php');
        $u_id = $_SESSION['user'];
    echo '<p style="margin: 10px;"><b>'.$u_name.'</b>';
        function getMyResults($db, $u_id)
        {
            $sql = "SELECT * FROM `std_results` WHERE u_id = $u_id"; //вывод из представления
            $result = array();
            $stmt = $db->prepare($sql);
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $result[$row['a_id']] = $row;
            }
            return $result;
        }

        $my_results = getMyResults($db, $u_id);
    ?>
<table class="table table-striped">
<thead>
    <tr>
        <th scope="col">№</th>
        <th scope="col">Дата</th>
        <th scope="col">Билет</th>
        <th scope="col">Результат</th>
        <th scope="col">Затраченное время</th>
    </tr>
    </thead>  <tbody> 
    <?php $n=0;
    foreach ($my_results as $result){
        $minutes = floor($result['time'] / 60);
        $seconds = $result['time'] - ($minutes*60);
        $originalDate = $result['date'];
        $newDate = date("d.m.Y", strtotime($originalDate));
        ?>
    <tr>
        <td scope="row"><?php $n++; echo $n;?></td>
        <td><?php echo $newDate;?></td>
        <td><?php echo $result['name'];?></td> 
        <td><?php if ($result['status'] == 1) echo "Выполнен успешно"; else echo "Выполнен неуспешно"; ?></td> 
        <td><?php echo $minutes.' минут '.$seconds.' секунд';?></td>       
    </tr>
    <?php } ?>
    </tbody></table>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>	
</body>
</html>

