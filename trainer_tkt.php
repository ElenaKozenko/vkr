<?php include('header.php'); 
  get_session();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" type="text/css"/>
    <title>Тренажер</title>
</head>

<body>
    <?php get_header(); ?>
<p>Для тренировки билета нажмите на его название.</p>

    <?php
    include 'db.php';
    include 'api.php';
    $tickets = getAllTickets($db);

echo "<div class=\"tkt\">";
    foreach ($tickets as $row) {
        $tkt_id = $row['tkt_id'];
        $name = $row['name'];
        echo "<div class=\"block\"><a href=\"trainer.php?tkt_id=$tkt_id&name=$name\">$name</a></div>";
    }
echo "</div>";
    ?>
</body>
</html>