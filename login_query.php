<?php
	session_start();
	
	require_once 'db.php';
	
	if(ISSET($_POST['log_in'])){
		if($_POST['login'] != "" || $_POST['password'] != ""){
			$login= $_POST['login'];
			// md5 encrypted
			// $password = md5($_POST['password']);
			$password = $_POST['password'];
			$sql = "SELECT * FROM `users` WHERE `login`='$login' AND `password`='$password' ";
			$query = $db->prepare($sql);
			$query->execute(array($login,$password));
			$row = $query->rowCount();
			$fetch = $query->fetch();
			if($row > 0) {
				$_SESSION['user'] = $fetch['u_id'];
				header("location: pdd.php");
			} else{
				echo "
				<script>alert('Неверный логин или пароль')</script>
				<script>window.location = 'index.php'</script>
				";
			}
		}else{
			echo "
				<script>alert('Пожалуйста, заполните все поля')</script>
				<script>window.location = 'index.php'</script>
			";
		}
	}
?>