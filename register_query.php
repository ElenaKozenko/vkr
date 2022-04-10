<?php
	session_start();
	require_once 'db.php';
 
	if(ISSET($_POST['register'])){
		if($_POST['surname'] != "" || $_POST['name'] != "" || $_POST['login'] != "" || $_POST['password'] != ""){
			try{
				$name = $_POST['name'];
				$surname = $_POST['surname'];
				$patr = $_POST['patr'];
				$login = $_POST['login'];
				$category = 'student';
				// md5 encrypted
				// $password = md5($_POST['password']);
				$password = $_POST['password'];
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql = "INSERT INTO users VALUES ('', $surname, $name, $patr, $category, $login, $password)";
			/* 	$sql = "INSERT INTO `testpdd0.users` VALUES ('', :surname, :firstname, :patronumic, :category , :login, :password)";
				$stmt=$db->prepare($sql);
				$stmt->bindValue('surname', $surname, PDO::PARAM_STR);
				$stmt->bindValue('firstname', $firstname, PDO::PARAM_STR);
				$stmt->bindValue('patronumic', $patronumic, PDO::PARAM_STR);
				$stmt->bindValue('category', $category, PDO::PARAM_STR);
				$stmt->bindValue('login', $login, PDO::PARAM_STR);
				$stmt->bindValue('password', $password, PDO::PARAM_STR);
				$stmt->execute(); */
				$db->exec($sql);
				echo var_dump($stmt->errorInfo());
			}catch(PDOException $e){
				echo $e->getMessage();
			}
			$_SESSION['message']=array("text"=>"Регистрация прошла успешно","alert"=>"info");
			$db = null;
			header('location:index.php');
		}else{
			echo "
				<script>alert('Пожалуйста, заполните все поля')</script>
				<script>window.location = 'registration.php'</script>
			";
		}
	}
?>