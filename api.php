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
function UploadImage(){
global $_FILES, $_POST;

$fileName = $_POST['ticket'].'_'.$_POST['question'].'.jpg';
if ( 0 < $_FILES['upload_img']['error'] ) {
    echo 'Error: ' . $_FILES['upload_img']['error'] . '<br>';
}else if(
    isset($_FILES['upload_img']) &&
    $_FILES['upload_img']['size'] < 10000000 && 
    ($_FILES['upload_img']['type'] == 'image/png' || $_FILES['upload_img']['type'] == 'image/jpeg') &&
    (exif_imagetype($_FILES['upload_img']['tmp_name']) == IMAGETYPE_JPEG || exif_imagetype($_FILES['upload_img']['tmp_name']) == IMAGETYPE_PNG)
){
    @copy($_FILES['upload_img']['tmp_name'], IMAGE_UPLOADED_PATH.$fileName );
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

    echo var_dump($stmt->errorInfo());
}


?>