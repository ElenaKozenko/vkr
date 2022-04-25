<?php include('header.php'); 
  get_session();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Результат</title>
</head>
<style>
.win {
color: green;
}

.loss{
color: red;
}
</style> 
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
        $minutes = floor($seconds / 60);
        $seconds = $seconds - ($minutes*60);
        echo "<div>Время выполнения экзамена: ".$minutes.":".$seconds."</div>";    
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

//номер записи в таблице ответов
$a_id = $_POST['body3'];
settype($a_id, "integer");

//массив верных ответов
$true_answers = getTrueAns($db, $tkt_id);

$err = 0; //количество ошибок

echo "<h1>Результаты экзамена</h1><hr>";
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
    echo "<hr>Допущено ошибок: $err .<div class=\"win\"> Экзамен пройден успешно.</div>"; 
    $status = 1;
}
else {
    echo "<hr>Допущено ошибок: $err .<div class=\"loss\">Экзамен не пройден.</div>";
    $status = 0;
}
$user_ans_str = json_encode($user_ans);
saveResult($db, $a_id, $user_ans_str, $status); //вызов функции сохранения результата
getTime($db, $a_id); //вызов функции затраченного времени
?>

</body>
</html> 