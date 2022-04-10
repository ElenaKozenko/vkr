<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
		<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1"/>
	</head>
<body>
		<div class="col-md-8">
			<?php if(isset($_SESSION['message'])): ?>
				<div class="alert alert-<?php echo $_SESSION['message']['alert'] ?> msg"><?php echo $_SESSION['message']['text'] ?></div>
			<script>
				(function() {
					// removing the message 3 seconds after the page load
					setTimeout(function(){
						document.querySelector('.msg').remove();
					},3000)
				})();
			</script>
			<?php 
				endif;
				// clearing the message
				unset($_SESSION['message']);
			?>
			<form action="login_query.php" method="POST">	
				<h4 class="text-success">Авторизация</h4>
				<hr style="border-top:1px groovy #000;">
				<div class="form-group">
					<label>Логин</label>
					<input type="text" class="form-control" name="login" />
				</div>
				<div class="form-group">
					<label>Пароль</label>
					<input type="password" class="form-control" name="password" />
				</div>
				<br />
				<div class="form-group">
					<button class="btn btn-primary form-control" name="log_in">Вход</button>
				</div>
				<a href="registration.php">Регистрация</a>
			</form>
		</div>
	</div>
</body>
</html>