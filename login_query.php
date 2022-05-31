<?php
	session_start();
	
	require_once 'db.php';
	
	if(ISSET($_POST['log_in']))
	{
		if($_POST['login'] != "" || $_POST['password'] != "")
		{
			//извлечение пароля по логину
			$login=$_POST['login'];
			$stmt = $db->prepare("SELECT users.password FROM users WHERE users.login = '$login' LIMIT 1");
			$stmt->execute();
			$n = $stmt->rowCount();
			//$u_pass = $stmt->fetch(PDO::FETCH_COLUMN);
			$u_pass = $stmt->fetchColumn();
			if($n > 0) //если логин верный и пароль есть
			{
				if($u_pass === md5(md5($_POST['password']))) //проверка пароля
				{
				$sql = "SELECT users.u_id, users.surname, users.name, users.patr, users.login, users.password, users.instructor, category.name as 'status'  
				FROM users JOIN category WHERE users.category = category.ct_id AND users.login='$login' AND users.password='$u_pass';";
				
				$query = $db->prepare($sql);
				$query->execute();
				$row = $query->rowCount();
				$fetch = $query->fetch();
					if($row > 0) 
					{
						$_SESSION['user'] = $fetch['u_id'];
						$_SESSION['u_name'] = $fetch['name'];
						$_SESSION['u_surname'] = $fetch['surname'];
						$_SESSION['u_patr'] = $fetch['patr'];
						$_SESSION['status'] = $fetch['status'];
						echo "<script>window.location = 'pdd.php';</script>";
					}
				} 
				else
				{
				echo " <script>alert('Неверный пароль')</script>
				<script>window.location = 'index.php';</script>";
				}	
			}
			else
			{
				echo " <script>alert('Нет данного логина. Зарегестрируйтесь')</script>
				<script>window.location = 'registration.php';</script>";
			}	
		}
		else
		{
			echo "
				<script>alert('Пожалуйста, заполните все поля')</script>
				<script>window.location = 'index.php'</script>
			";
		}
	}
	
?>