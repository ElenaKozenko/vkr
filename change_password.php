<?php session_start();
include('header.php'); 
get_session();?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf8mb4">
	<link rel="shortcut icon" href="pic/logo1.png" type="image/png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Смена пароля</title>
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
<?php get_header(); ?>
<div class="container">
<div class="row">
<div class="col-sm"></div>
<div class="col-sm">
		
			<form method="POST">	
				<div class="form-group">
					<label>Логин</label>
					<input type="text" class="form-control" name="login">
				</div>
				<div class="form-group">
					<label>Новый пароль</label>
					<input type="password" class="form-control" name="password">
				</div>
                <div class="form-group">
					<label>Введите пароль повторно</label>
					<input type="password" class="form-control" name="password2">
				</div>
				<br />
				<div class="form-group">
					
					<input type="submit" name="submit" value="Сменить пароль" class="btn btn-warning">
				</div>
				<a href="pdd.php">Главная страница</a>
			</form>
		
	</div>
	<div class="col-sm"></div>
</div>
</div>
<?php 
require_once 'db.php';
if ($_POST['submit'])
{
	session_start();
	$u_id = $_SESSION['user'];
	
	$stmt = $db->prepare("SELECT login FROM `users` WHERE users.u_id = ?;");
    $stmt->execute(array($u_id));	
    $login_db = $stmt->fetch(PDO::FETCH_COLUMN);
	//echo var_dump($stmt->errorInfo()); 

	$login = $_POST['login'];
	$new_password = $_POST['password'];
	$new_password2 = $_POST['password2'];


	if($login == $login_db){

		if($new_password == $new_password2){
			if($new_password == '')	{echo '<p>Вы не ввели пароль</p>'; }
			else{		
			// md5 encrypted
			$new_password = md5(md5(trim($_POST['password'])));
			$sql = "UPDATE users SET password = '$new_password' WHERE users.u_id = $u_id;";
			$db->exec($sql);
			echo '<p>Пароль успешно изменен</p>';}
		}
		else{
			echo '<p>Пароли не совпадают</p>';
		}
	}
	else {
		echo '<p>Неверно введен логин</p>';
	}

}

?>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>	
</body>
</html>