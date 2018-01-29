<?php

class userController 
{
	public $model = null;
	public function __construct($db)
	{
		include 'models/user.php';
		$this->model = new User($db);
	}

	public function getForm() 
	{
		$errors[] = 'Введите данные для регистрации или войдите, если уже регистрировались:';
		include 'views/user.php';

	}

	public function register() 
	{	
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$errors = array();
			if (isset($_POST['register'])) {
				if (!empty($_POST['login']) && !empty($_POST['password'])) {
					$login = strip_tags(trim($_POST['login']));
					$password = md5(strip_tags(trim($_POST['password'])));
					$data = $this->model->findUser($login);
					foreach ($data as $logins) {$login_name = $logins['login'];}
					if ($login_name == $login) {
						$errors[] = 'Такой пользователь уже существует в базе данных.';
					}
					else {
					$this->model->addUser($login, $password);
					$errors[] = 'Теперь вы можете войти под своим логином и паролем';
					}
				} else {
					$errors[] = 'Ошибка регистрации. Введите все необхдоимые данные.';
				}
			}
		}else {
			$errors[] = 'Введите данные для регистрации или войдите, если уже регистрировались:';
		}
		include 'views/user.php';
		
	}

	public function signIn() 
	{
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$errors = array();
			if (isset($_POST['sign_in'])) {
				if (!empty($_POST['login']) && !empty($_POST['password'])) {
					$login = strip_tags(trim($_POST['login']));
					$password = md5(strip_tags(trim($_POST['password'])));
					foreach ($this->model->findAll() as $logins) {
						$login_name = $logins['login'];
						$login_pass = $logins['password'];
						$login_id = $logins['id'];
					
					if (($login_name == $login) && ($login_pass == $password)) {
						$_SESSION['user'] = array('user_name'=>$login_name, 'user_id'=>$login_id);
						// include 'views/task.php';
						header('Location: ?/taskController/getTask');
					}
					else {
						$errors[] = 'Такой пользователь не существует, либо неверный пароль.';
					}}
				}
				else {
				$errors[] = 'Ошибка входа. Введите все необхдоимые данные.';
				}
			}
		}else {
			$errors[] = 'Введите данные для регистрации или войдите, если уже регистрировались:';
		}
		include 'views/user.php';
	}

	public function logout() 
	{
		session_destroy();
		header("location: index.php");
	}
}
?>