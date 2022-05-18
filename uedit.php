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
    <title>Редактор пользователя</title>
</head>
<body>
    <?php 
    get_header();
    include 'db.php'; 
    include 'users_query.php';
    $u_id = $_GET['u_id'];
    $instructors = getAllIstructors($db); //список преподавателей
    $category = getAllCaterories($db);
    $uform = userFormFill($db, $u_id); //заполнение формы пользователя  
?>
    <div class="container">
        <form name="uedit" method="post" enctype="multipart/form-data">
            <br>
            <?php foreach ($uform as $row1){ 
    //surname name patr login password instructor category
    switch($row1['ct_name']){
        case 'admin': echo "Категория пользователя: <b>администратор</b><br>"; break;
        case 'instructor': echo "Категория пользователя: <b>преподаватель</b><br>"; break;
        case 'student': echo "Категория пользователя: <b>студент</b><br>"; break;
    }
    if($row1['instructor'] != null){userInstructor($db, $row1['instructor']);}
    $old_cat = $row1['category'];
    $old_inst = $row1['instructor'];
    $old_password = $row1['password'];
 ?>
            <br><br>
            <h5>Общие данные:</h5>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="surname">Фамилия:</label>
                    <input type="text" class="form-control" id="surname" name="surname"
                        value="<?php echo $row1['surname'];?>">
                </div>
                <div class="form-group col-md-4">
                    <label for="name">Имя:</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $row1['name'];?>">
                </div>
                <div class="form-group col-md-4">
                    <label for="patr">Отчество:</label>
                    <input type="text" class="form-control" id="patr" name="patr" value="<?php echo $row1['patr'];?>">
                </div>
            </div>
            <h5>Смена логина и пароля:</h5>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="login">Логин:</label>
                    <input type="text" class="form-control" id="login" name="login"
                        value="<?php echo $row1['login'];?>">
                </div>
                <div class="form-group col-md-3">
                    <label for="password">Введите новый пароль:</label>
                    <input type="password" id="password" name="password" class="form-control">
                </div>
            </div>
            <h5>Смена категории и инструктора:</h5>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="category">Выбор новой категории пользователя:</label>
                    <select id="category" name="category" class="form-control">
                        <?php foreach ($category as $row){
            $id = $row['ct_id'];
            $name = $row['name'];
            echo "<option value=\"$id\">$name</option>";}?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="category">Выберите преподавателя, если пользователь является студентом:</label>
                    <select id="instructor" name="instructor" class="form-control">
                        echo "<option value=\"NULL\">Без преподавателя</option>";
                        <?php foreach ($instructors as $row){
            echo "<option value=\"".$row['u_id']."\">".$row['fio']."</option>";}?>
                    </select>
                </div>
            </div>
            <?php } ?>
            <br>
            <div>
                <input type="submit" name="edit" value="Сохранить" class="btn btn-success" style="float: left;">
                <a href="user_delete.php?u_id=<?php echo $u_id;?>" class="btn btn-danger" style="float: right;">Удалить пользователя</a>
            </div>
        </form>
        <?php 
if(ISSET($_POST['edit'])){

    $surname = $_POST['surname'];
    $name = $_POST['name'];
    $patr = $_POST['patr'];
    $login = $_POST['login'];

    // md5 encrypted
    //$password = md5($_POST['password']);
   if ($_POST['password']!='') $password = $_POST['password']; 
   else $password = $old_password; 

    if (ISSET($_POST['category'])) $category = $_POST['category']; else $category = $old_cat;
    if (ISSET($_POST['instructor'])) $instructor = $_POST['instructor']; else $instructor = $old_inst;

    editUser($db, $u_id, $surname, $name, $patr, $login, $password, $category, $instructor);
}
?>
        
    </div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>	
</body>
</html>