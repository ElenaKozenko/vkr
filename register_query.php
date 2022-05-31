<?php
	session_start();
	require_once 'db.php';
 
	if(ISSET($_POST['register'])){
		
		if($_POST['surname'] != "" || $_POST['name'] != "" || $_POST['login'] != "" || $_POST['password'] != ""){
			$login = $_POST['login'];
			$stmt = $db->prepare("SELECT COUNT(u_id) FROM users  WHERE  users.login='$login';");
			$stmt->execute();
			$value = $stmt->fetch(PDO::FETCH_COLUMN);
			if($value > 0) {
				echo "
				<script>alert('Пользователь с данным логином уже существует')</script>
				<script>window.location = 'registration.php'</script>
			";
			}
			else{
				try{
				$name = $_POST['name'];
				$surname = $_POST['surname'];
				$patr = $_POST['patr'];
				$login = $_POST['login'];
				$category = 3;
				// md5 encrypted
				$password = md5(md5(trim($_POST['password'])));
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql = "INSERT INTO users(surname, name, patr, category, login, password, reg_date) 
				VALUES ('$surname', '$name', '$patr', '$category', '$login', '$password', CURRENT_DATE);";
				$db->exec($sql);
				//echo var_dump($stmt->errorInfo());
			}catch(PDOException $e){
				echo $e->getMessage();
			}
			$_SESSION['message']=array("text"=>"Регистрация прошла успешно","alert"=>"info");
			$db = null;
			//header('location:index.php');
			echo '<script>window.location.href = "index.php";</script>';
			}
		}else{
			echo "
				<script>alert('Пожалуйста, заполните все поля')</script>
				<script>window.location = 'registration.php'</script>
			";
		}
	}
?>