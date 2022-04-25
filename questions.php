<?php include('header.php'); 
  get_session();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="widtd=device-widtd, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Вопросы</title>
    </head>
<bode>

<?php 
    get_header();
    include 'db.php';
    include 'api.php';
    include 'questions_query.php';
    
    $tkt_id = $_GET['tkt_id'];//получение из tickets.php
    
    $que = getQuestionsByTicket($db, $tkt_id);
    $tickets = getAllTickets($db);
    echo "Билет №$tkt_id";
?>
<table>
    <?php $n=0;
    foreach ($que as $result){?>
    <tr>
        <td><?php $n++; echo $n?></td>
        <td><?php echo $result['task']?></td>
        <td><?php echo "<a href=\"qedit.php?tkt_id=$tkt_id&q_id=", $result['q_id'], "&n=$n\">Редактировать</a>" ?><td> 
        <td><?php echo "<a href=\"qdelete.php?q_id=", $result['q_id'],"\">Удалить</a>" ?><td>          
    </tr>
    <?php } ?>
</table>
<?php $n++;
echo "<a href=\"newquestion.php?tkt_id=$tkt_id&n=$n\">Добавить новый вопрос к билету</a>" ?>
</body>
</html>