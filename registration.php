<!DOCTYPE html>
<html lang="en">
	<head>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
		<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1"/>
	</head>
<body>

	<div class="col-md-3"></div>
	<div class="col-md-6 well">

		<div class="col-md-8">
			<form action="register_query.php" method="POST">	
				<h4 class="text-success">Регистрация</h4>
				<hr style="border-top:1px groovy #000;">
				<div class="form-group">
					<label>Фамилия</label>
					<input type="text" class="form-control" name="surname">
				</div>
				<div class="form-group">
					<label>Имя</label>
					<input type="text" class="form-control" name="name">
				</div>

				<div class="form-group">
					<label>Отчество</label>
					<input type="text" class="form-control" name="patr">
				</div>
				
				<div class="form-group">
					<label>Логин</label>
					<input type="text" class="form-control" name="login">
				</div>
				<div class="form-group">
					<label>Пароль</label>
					<input type="password" class="form-control" name="password">
				</div>
				<br />
				<div class="form-group">
					<button class="btn btn-primary form-control" name="register">Зарегистрироваться</button>
				</div>
				<a href="index.php">Авторизация</a>
			</form>
		</div>
	</div>
</body>
</html>