<!DOCTYPE html>
<html lang="en">
	<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="shortcut icon" href="pic/logo1.png" type="image/png">
	<title>Регистрация</title>
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
<div class="container">	
<div class="row">
<div class="col-sm"></div>
<div class="col-sm">

			<form action="register_query.php" method="POST">	
				<h4>Регистрация</h4>
				<hr style="border-top:1px groovy #000;">
				<div class="form-group">
					<label>Фамилия</label>
					<input type="text" class="form-control" name="surname" maxlength="30">
				</div>
				<div class="form-group">
					<label>Имя</label>
					<input type="text" class="form-control" name="name" maxlength="30">
				</div>

				<div class="form-group">
					<label>Отчество</label>
					<input type="text" class="form-control" name="patr" maxlength="30">
				</div>
				
				<div class="form-group">
					<label>Логин</label>
					<input type="text" class="form-control" name="login" maxlength="50">
				</div>
				<div class="form-group">
					<label>Пароль</label>
					<input type="password" class="form-control" name="password" maxlength="15">
				</div>
				<br />
				<div class="form-group">
					<button class="btn btn-primary form-control" name="register">Зарегистрироваться</button>
				</div>
				<a href="index.php">Авторизация</a>
			</form>
	</div>
<div class="col-sm"></div>
</div>
</div>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>	
</body>
</html>