<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Вход/Регистрация</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="styles/style.css">
</head>
<body>
	<div class="container main-container">
		<h6 class="alert alert-info alert-register">{{ errors }}</h6>
		<form method="POST" action="?/userController/register" class="form-register">
			<div class="form-group">
		    	<input class="form-control" type="text" name="login" placeholder="Логин" />
		    </div>
		    <div class="form-group">
		    	<input class="form-control" type="password" name="password" placeholder="Пароль" />
		    </div>

		    <input type="submit" class="btn btn-primary" name="sign_in" value="Вход" />
		    <input type="submit" class="btn btn-primary" name="register" value="Регистрация" />
		</form>
</div>
</body>
</html>