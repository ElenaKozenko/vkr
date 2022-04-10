<!DOCTYPE html>
<html lang="ru">

<head>
<meta charset="utf-8" />
  <title>Билеты</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1" />
</head>

<body>
    <?php
    include 'db.php';
    include 'api.php';
    $tickets = getAllTickets($db);
    

    foreach ($tickets as $row) {
        $tkt_id = $row['tkt_id'];
        $name = $row['name'];
        echo "<a href=\"questions.php?tkt_id=$tkt_id\">$name</a> &nbsp; <a href=\"trainer.php?tkt_id=$tkt_id&name=$name\">Тренировка</a><br>";
    }
    ?>

    <div>
        <form class="form_ed" id="form_ed" name="form_ed">
            <input type="text" name="tkt_name" placeholder="Введите название билета">
            <input type="submit" name ="add" value="Добавить новый билет">
        </form>
    </div> 

    <?php
    if(isset($_POST['add']))  
        {
            $tkt_name=$_POST['tkt_name'];
            addTicket($db, $tkt_name);   
        }
    ?>

</body>
</html>