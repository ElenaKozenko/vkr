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
    <title>Результат</title>
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

//получение информации после тестирования в exam.php
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
echo '<hr>'; */

//ответы пользователя
$user_ans = $_POST['body'];
$arr = json_decode($user_ans);

//номер билета
$tkt_id = $_POST['body2'];
settype($tkt_id, "integer");

//массив верных ответов
$true_answers = getTrueAns($db, $tkt_id);

echo "<h1>Результаты тренировки</h1><hr>";
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

</body>

</html>