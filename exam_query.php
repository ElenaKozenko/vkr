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
    <title>Результат</title>
</head>
<body>
<?php 
include 'db.php';
get_header(); 

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

function saveResult($db, $a_id, $answ, $status){
    try{ 
        $sql = "UPDATE answers SET answ = :answ, status = :status, end_time = CURRENT_TIMESTAMP WHERE a_id = :a_id";
        $stmt = $db->prepare($sql);
        $stmt->bindValue('answ', $answ, PDO::PARAM_STR);
        $stmt->bindValue('status', $status, PDO::PARAM_INT);
        $stmt->bindValue('a_id', $a_id, PDO::PARAM_INT);
        $stmt->execute();
    }
    catch (PDOException $e) {
        echo "<br>Возникла ошибка при сохранение результата экзамена.";
        echo "You have an error: " . $e->getMessage() . "<br>";
        echo "On line: " . $e->getLine() . "<br>";
    }
}

function getTime($db, $a_id){
    $stmt = $db->prepare("SELECT TIMESTAMPDIFF(SECOND, start_time, end_time) FROM answers WHERE a_id = ?;") ;
        $stmt->execute(array($a_id));
        $seconds = $stmt->fetch(PDO::FETCH_COLUMN);
        $sec = $seconds;
        $minutes = floor($seconds / 60);
        $seconds = $seconds - ($minutes*60);
        if($sec > 1200) echo "<div class=\"loss\">Время выполнения экзамена: ".$minutes.":".$seconds."</div>";  
        else echo "<div class=\"win\">Время выполнения экзамена: ".$minutes.":".$seconds."</div>";  
        return $sec;
}
$user_ans = $_POST['body'];//ответы пользователя
$arr = json_decode($user_ans);

$tkt_id = $_POST['body2'];//номер билета
settype($tkt_id, "integer");

$a_id = $_POST['body3'];//номер записи в таблице ответов
settype($a_id, "integer");

$true_answers = getTrueAns($db, $tkt_id);//массив верных ответов
$err = 0; //количество ошибок
?>
<div class="container">
<h4>Результаты экзамена</h4><hr>

<?php

for($i = 0; $i < count($arr); $i++)
{
    $num = $i + 1;
    if($arr[$i] == $true_answers[$i])
    { 
        echo "<div class=\"win\"> Вопрос №". $num ." Вы ответили верно</div>";
    }
    else 
    {
        echo "<div class=\"loss\"> Вопрос №". $num ." Вы ответили неверно</div>";
        $err++;
    }
    $num = 0;
} 

if($err < 3) {
    echo "<hr>Допущено ошибок: $err.<div class=\"win\"> Достигнуто необходимое количество правильных ответов.</div>"; 
    $status = 1;
}
else {
    echo "<hr>Допущено ошибок: $err .<div class=\"loss\">Не достигнуто необордимое количество правильных ответов</div>";
    $status = 0;
}
$user_ans_str = json_encode($user_ans);
saveResult($db, $a_id, $user_ans_str, $status); //вызов функции сохранения результата
$sec = getTime($db, $a_id); //вызов функции затраченного времени
if($status = 1 && $sec <= 1200) { echo "<div class=\"win\">Экзамен сдан успешно</div>";}
else { echo "<div class=\"loss\">Экзамен сдан неуспешно</div>"; }
?>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>	
</body>
</html>