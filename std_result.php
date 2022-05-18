<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="utf8mb4">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
<?php 
include_once('db.php');
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
     
    $student = explode(',',$_POST['std']);
    $u_id = $student[0];
    $name = $student[1];

    $my_results = getMyResults($db, $u_id);
  echo '<p>'.$name.'</p>';
    ?>

<table class="table table-striped">
<thead>
    <tr>
        <th>№</th>
        <th>Дата</th>
        <th>Билет</th>
        <th>Результат</th>
        <th>Затраченное время</th>
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

<script>
    document.title = '<?php echo $name;?>';
</script>
<html>
</body>