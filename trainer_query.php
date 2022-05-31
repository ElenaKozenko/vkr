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
    <link rel="shortcut icon" href="pic/logo1.png" type="image/png">
    <title>Результат</title>
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

<body>
    <div>
        <?php get_header(); ?>
    </div>
    <?php 
include 'db.php';

function getTrueAns($db, $tkt_id) //функция для создания массива верных ответов к этому билету
{
$sql="SELECT true_ans FROM questions WHERE questions.tkt_id = $tkt_id";
$result=array();
$stmt=$db->prepare($sql);
$stmt->execute();
$i=0;
while($row = $stmt->fetchColumn()) 
{
    $result[$i] = $row;
    $i++;
}
return $result;
}

//ответы пользователя
$user_ans = $_POST['body'];
$arr = json_decode($user_ans);

//номер билета
$tkt_id = $_POST['body2'];
settype($tkt_id, "integer");

//массив верных ответов
$true_answers = getTrueAns($db, $tkt_id);
?>
<div class="container"><h4>Результаты тренировки</h4><hr>
<?php
for($i = 0; $i < count($arr); $i++)
{
    $num = $i + 1;
    if($arr[$i] == $true_answers[$i])
     { echo "<div class=\"win\"> Вопрос №". $num ." Вы ответили верно</div>";}
    else 
    {echo "<div class=\"loss\"> Вопрос №". $num ." Вы ответили неверно</div>";}
    $num = 0;
} 
?>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>	
</body>
</html>

<!-- получение информации после тестирования в exam.php
/* var_dump($_POST); 
echo '<hr>';
$user_ans = $_POST['body'];
echo "ответы пользователя без json <br>";
var_dump($user_ans);
echo '<hr>';
echo "ответы пользователя json <br>";
$arr = json_decode($user_ans);
var_dump($arr);

echo '<hr>';
echo "номер билета <br>";
$tkt_id = $_POST['body2'];
settype($tkt_id, "integer");
echo $tkt_id;

echo '<hr>';
$true_answers = getTrueAns($db, $tkt_id);
echo "массив верных ответов <br>";
var_dump($true_answers);
echo '<hr>';  -->