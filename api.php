<?php
include 'db.php';

define('IMAGE_UPLOADED_PATH', 'uploaded/');

//РАБОТА С ТАБЛИЦЕЙ "Темы"  ВЫВОД ВСЕЙ ИНФОРМАЦИИ ИЗ "Темы"
function getAllTopics($db)
{
$sql="SELECT * FROM topics;";
$result=array();
$stmt=$db->prepare($sql);
$stmt->execute();
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {$result[$row['tp_id']] = $row;}
return $result;
}

//РАБОТА С КАРТИНКАМИ
//загрузка
function UploadImage($tkt_id, $q_id){
global $_FILES, $_POST;

$fileName = $tkt_id.'_'.$q_id.'.jpg';
if ( 0 < $_FILES['upload_img']['error'] ) {
    if($_FILES['upload_img']['error']  != '4')
    echo 'Error: ' . $_FILES['upload_img']['error'] . '<br>'; //файл не был загружен
}else if(
    isset($_FILES['upload_img']) &&
    $_FILES['upload_img']['size'] < 10000000 && 
    ($_FILES['upload_img']['type'] == 'image/png' || $_FILES['upload_img']['type'] == 'image/jpeg') &&
    (exif_imagetype($_FILES['upload_img']['tmp_name']) == IMAGETYPE_JPEG || exif_imagetype($_FILES['upload_img']['tmp_name']) == IMAGETYPE_PNG)
){
    @copy($_FILES['upload_img']['tmp_name'], IMAGE_UPLOADED_PATH.$fileName );
}
}

//удаление картинки
function deleteImg($pathImg){
   try{
   unlink($pathImg);
   }
    catch (PDOException $e) {
        echo "You have an error: " . $e->getMessage() . "<br>";
        echo "On line: " . $e->getLine() . "<br>";
    }
}


//РАБОТА С ТАБЛИЦЕЙ "Билеты"
//Вывод всей информации из "Билеты"
function getAllTickets($db)
{
$sql="SELECT * FROM tickets;";
$result=array();
$stmt=$db->prepare($sql);
$stmt->execute();
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {$result[$row['tkt_id']] = $row;}
return $result;
}
//Добавление нового билета
function  addTicket($db, $tkt_name)
{
    try {
        $sql = "INSERT INTO tickets(name) VALUES(:tkt_name);";
        $stmt = $db->prepare($sql);
        $stmt->bindValue('tkt_name', $tkt_name, PDO::PARAM_STR);
        $stmt->execute();
        echo "<br>Билет успешно добавлен<br>";
        
    } catch (PDOException $e) {
        echo "<br>Возникла ошибка при добавлении билета<br>";
        echo "You have an error: " . $e->getMessage() . "<br>";
        echo "On line: " . $e->getLine() . "<br>";
    }
}

//РАБОТА С ТАБЛИЦЕЙ "Вопросы"  ВЫВОД ИНФОРМАЦИИ ИЗ "Вопросы" по коду билета
function getQuestByTicket($db, $tkt_id)
{
$sql="SELECT q_id, task, ans1, ans2, ans3, ans4, ans5, questions.description FROM questions WHERE questions.tkt_id = $tkt_id";
$result=array();
$stmt=$db->prepare($sql);
$stmt->execute();
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
{
    $result[$row['q_id']] = $row;
}
return $result;
}

//РАБОТА С ТАБЛИЦЕЙ "Ответы" добавление времени начала экзамена, пользователя, кода билета
function addNewAnswer($db, $u_id, $tkt_id){
    try {
        $sql = "INSERT INTO answers(u_id, tkt_id, start_time) VALUES(:u_id, :tkt_id, CURRENT_TIMESTAMP);";
        $stmt = $db->prepare($sql);
        $stmt->bindValue('u_id', $u_id, PDO::PARAM_INT);
        $stmt->bindValue('tkt_id', $tkt_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $stmt = $db->prepare("SELECT LAST_INSERT_ID();") ;
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_COLUMN);
        return $result;
     

    } catch (PDOException $e) {
        echo "<br>Возникла ошибка при добавлении ответа<br>";
        echo "You have an error: " . $e->getMessage() . "<br>";
        echo "On line: " . $e->getLine() . "<br>";
    }
}
?>