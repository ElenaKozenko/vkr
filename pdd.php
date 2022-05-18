<?php session_start();
include('header.php'); 
get_session();?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf8mb4">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Главная</title>
    <style>
      p{
        margin: 10px;
      }
    </style>
</head>
<body>

    <?php get_header(); ?>

  <div><br>
  <img src="pic/logo.jpeg" alt="Logo" style="width: 200px; float: left; margin: 10px;"></div>
  <p>Здравствуйте, <b><?php echo $u_name;?></b>! Добро пожаловать в приложение для тренировки экзаменационных билетов по ПДД от Учебного центра "Союз-Авто".</p>
  <p>Для тренировки билетов перейдите на вкладку <i>"Тренажер"</i>. Если Вы желаете сохранять результат, то используйте режим, доступный на вкладке <i>"Экзамен"</i>.</p>
  <p><b>Наш адрес:</b> 347660, Ростовская область, Егорлыкский р-н, ст-ца Егорлыкская, пер. Гагарина, д.4</p>
  <p><b>Директор:</b> Дегтярева Анна Владимировна</p>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>	
</body>
</html>