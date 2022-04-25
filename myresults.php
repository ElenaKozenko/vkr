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
    <title>Мои результаты</title>
    <style>
table, td { border: 1px solid black;}
    </style>
</head>
<body>
    <?php
        get_header(); 
        include ('db.php');
        $u_id = $_SESSION['user'];

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
<table>
    <tr>
        <th>№</th>
        <th>Дата</th>
        <th>Билет</th>
        <th>Результат</th>
        <th>Затраченное время</th>
    </tr>
    <?php $n=0;
    foreach ($my_results as $result){
        $minutes = floor($result['time'] / 60);
        $seconds = $result['time'] - ($minutes*60);
        $originalDate = $result['date'];
        $newDate = date("d.m.Y", strtotime($originalDate));
        ?>
    <tr>
        <td><?php $n++; echo $n;?></td>
        <td><?php echo $newDate;?></td>
        <td><?php echo $result['name'];?></td> 
        <td><?php if ($result['status'] == 1) echo "Выполнен успешно"; else echo "Выполнен неуспешно"; ?></td> 
        <td><?php echo $minutes.' минут '.$seconds.' секунд';?></td>       
    </tr>
    <?php } ?>
</table>
</body>
</html>

