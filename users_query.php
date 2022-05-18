<?php
//Вывод перечня преподавателей
function getAllIstructors($db){
    $sql="SELECT u_id, concat(`users`.`surname`,' ',`users`.`name`,' ',`users`.`patr`) 
    AS `fio` FROM users WHERE category = 2 ORDER BY surname";
    $result=array();
    $stmt=$db->prepare($sql);
    $stmt->execute();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {$result[$row['u_id']] = $row;}
    return $result;
}

//Вывод списка категорий
function getAllCaterories($db){
    $sql="SELECT * FROM `category`;";
    $result=array();
    $stmt=$db->prepare($sql);
    $stmt->execute();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {$result[$row['ct_id']] = $row;}
    return $result;
}


//Вывод данных пользователя по его коду
function userFormFill($db, $u_id){
    $sql = "SELECT users.u_id, users.surname, users.name, users.patr, users.login, users.password, users.instructor, 
    users.category, category.name AS 'ct_name' FROM users JOIN category WHERE users.u_id = $u_id AND users.category = category.ct_id";
    $result = array();
    $stmt = $db->prepare($sql);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $result[$row['u_id']] = $row;
    }
    return $result;
}

//Вывод ФИО преподавателя для заполнения 
function userInstructor($db, $instructor)
{
    $stmt = $db->prepare("SELECT  concat(`users`.`surname`,' ',`users`.`name`,' ',`users`.`patr`) 
    AS `fio` FROM users WHERE u_id = ?");
    $stmt->execute(array($instructor));
    $value = $stmt->fetch(PDO::FETCH_COLUMN);
    echo "Преподаватель: $value";
}

//обновление записи в таблице Пользователи
function editUser($db, $u_id, $surname, $name, $patr, $login, $password, $category, $instructor)
{
    try {
        $sql = "UPDATE users SET
        surname = '$surname', name = '$name', patr = '$patr', 
        login = '$login', password = '$password', category = $category, instructor = $instructor WHERE u_id = $u_id";
        $db->exec($sql);
    } catch (PDOException $e) {
        echo "<br>Возникла ошибка при редактировании.<br>";
        echo "You have an error: " . $e->getMessage() . "<br>";
        echo "On line: " . $e->getLine() . "<br>";
    }
}
// md5 encrypted
			// $new_password = md5($_POST['password']);

//удаление пользователя
function deleteUser($db, $u_id)
{
        $sql="DELETE FROM users WHERE u_id=:u_id";
        $stmt=$db->prepare($sql);
        $stmt->bindValue('u_id', $u_id, PDO::PARAM_INT);
        $stmt->execute();   
}
?>