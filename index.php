<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	</head>
<body>

<div class="row">
<div class="col-md-3"></div>
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
	<div class="col-md-6 well">	
		<div class="col-md-8">
			<form  action="login_query.php" method="POST" >	
				<h4>Авторизация</h4>
				<hr style="border-top:1px groovy #000;">
				<p align="center"><img src="pic/logo.jpeg" alt="Logo" style="width:50%;"><p>
				<div class="form-group">
					<label for="exampleInputEmail1">Логин</label>
					<input type="text" class="form-control" name="login"  id="exampleInputEmail1" aria-describedby="emailHelp" >
				</div>
				<div class="form-group">
					<label for="exampleInputPassword1">Пароль</label>
					<input type="password" class="form-control" name="password" id="exampleInputPassword1"/>
				</div>
				<br />
				<div class="form-group">
				<button type="submit" name="log_in" class="btn btn-primary">Вход</button>
				</div>
				<a type="button" class="btn btn-link" href="registration.php">Регистрация</a>
			</form>
		</div>
	<div>	

</div>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>	
</body>
</html>