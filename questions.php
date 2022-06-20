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
    <link rel="shortcut icon" href="pic/logo1.png" type="image/png">
    <link rel="stylesheet" href="style.css" type="text/css" />
    <title>Вопросы</title>
    <!-- Yandex.Metrika counter -->
<script type="text/javascript" >
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(88926432, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/88926432" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
    </head>
<bode>
<?php 
    get_header();
    include 'db.php';
    include 'api.php';
    include 'questions_query.php';
    
    $tkt_id = $_GET['tkt_id'];//получение из tickets.php
    $name = $_GET['name'];
    $que = getQuestionsByTicket($db, $tkt_id); //из questions_query.php
    //$tickets = getAllTickets($db);
    echo '<div class ="container"><h5 style="margin-left: 10px;"><b>'.$name.'</b></h5>';
?>
<a href="#add">Вниз</a>
<table class="table table-striped"><tbody> 
    <?php $n=0;
    foreach ($que as $result){?>
    <tr>
        <td scope="row"><?php $n++; echo $n?></td>
        <td><?php echo $result['task']?></td>
        <td><?php echo "<a style=\"color:green;\" href=\"qedit.php?tkt_id=$tkt_id&q_id=", $result['q_id'], "&n=$n\">Изменить</a>" ?><td> 
        <td><?php echo "<a style=\"color:red;\" href=\"qdelete.php?q_id=".$result['q_id']."&tkt_id=".$tkt_id."\">Удалить</a>" ?><td>          
    </tr>
    <?php } ?>
    </tbody></table>
    
<?php $n++;
echo "<a  name=\"add\" class=\"btn btn-secondary\" href=\"newquestion.php?tkt_id=$tkt_id&n=$n\">Добавить новый вопрос к билету</a>" ?>
<br><br><br>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>	
</body>
</html>