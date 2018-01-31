<?php

class userController 
{
	public $model = null;
	public $Twig;
	public function __construct($db, $Twig)
	{
		include 'models/user.php';
		$this->model = new User($db);
		$this->twig = $Twig;
	}

	public function getForm() 
	{
		$errors = 'Введите данные для регистрации или войдите, если уже регистрировались:';
		$template = $this->twig->loadTemplate('user.php');
		echo $template->render(['errors'=>$errors]);

	}

	public function register() 
	{	
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$errors = array();
			if (isset($_POST['register'])) {
				if (!empty($_POST['login']) && !empty($_POST['password'])) {
					$login = strip_tags(trim($_POST['login']));
					$password = md5(strip_tags(trim($_POST['password'])));
					if ($this->model->isUser($login)) {
						$errors = 'Такой пользователь уже существует в базе данных.';
					}
					else {
					$this->model->addUser($login, $password);
					$errors = 'Теперь вы можете войти под своим логином и паролем';
					}
				} else {
					$errors = 'Ошибка регистрации. Введите все необхдоимые данные.';
				}
			}
		}else {
			$errors = 'Введите данные для регистрации или войдите, если уже регистрировались:';
		}
		$template = $this->twig->loadTemplate('user.php');
		echo $template->render(['errors'=>$errors, 'qwerrr'=>$this->model->isUser($login)]);
		
	}

	public function signIn() 
	{
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$errors = array();
			if (isset($_POST['sign_in'])) {
				if (!empty($_POST['login']) && !empty($_POST['password'])) {
					$login = strip_tags(trim($_POST['login']));
					$password = md5(strip_tags(trim($_POST['password'])));
					$user = $this->model->findUser($login, $password);
					if ($this->model->findUser($login, $password)) {
						$_SESSION['user'] = array('user_name'=>$login, 'user_id'=>$user['id']);
						header('Location: ?/taskController/getTask');
					}
					else {
						$errors = 'Такой пользователь не существует, либо неверный пароль.';
					}
				}
				else {
				$errors = 'Ошибка входа. Введите все необхдоимые данные.';
				}
			}
		}else {
			$errors = 'Введите данные для регистрации или войдите, если уже регистрировались:';
		}
		$template = $this->twig->loadTemplate('user.php');
		echo $template->render(['errors'=>$errors]);
	}

	public function logout() 
	{
		session_destroy();
		header("location: index.php");
	}
}
?>