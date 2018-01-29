<?php

class taskController 
{
	public $model = null;
	public function __construct($db)
	{
		include 'models/task.php';
		$this->model = new Task($db);
	}

	public function getTask() 
	{
		$users = $this->model->findAllUsers();
		// foreach ($users as $user)
		// {
		// 	$vvv = $user['login'];
		// }
		$user_id = $_SESSION['user']['user_id'];
		$user_name = $_SESSION['user']['user_name'];
		$sort = null;
		$button = 'Добавить';
		if (!empty($_POST['sort_by'])) {
			$sort = $_POST['sort_by'];
			$author = $this->model->findAllTasksSort($sort);
			$responsible = $this->model->findAllTasksSort($sort);
		} else {
			$author = $this->model->findAllTasks();
			$responsible = $this->model->findAllTasks();
		}	
		if (!empty($_POST['task_id']) && isset($_POST['edit'])) {
			$id= strip_tags($_POST['task_id']);
			$result = $this->model->findTask($id);
			$desc_change = $result['description'];
			$button = 'Обновить';
		}	
		include 'views/task.php';

	}

	public function getDelete() 
	{	
		if (!empty($_POST['task_id']) && !empty($_POST['delete'])) {
			$id= strip_tags($_POST['task_id']);
				$this->model->deleteTask($id);
				header("Location: index.php");
		}
	}

	public function getDone() 
	{	
		if (!empty($_POST['task_id']) && !empty($_POST['done'])) {
			$id= strip_tags($_POST['task_id']);
			$this->model->doneTask($id);
			header("Location: index.php");
		}
	}

	public function getEdit() 
	{			
		$this->getTask();
	}

	public function add() 
	{	
		header("Location: index.php");
		if (isset($_POST['save']) and $_POST['save'] == "Добавить") {
			$description = strip_tags($_POST['description']);
			$user_id = $_SESSION['user']['user_id'];
			$this->model->addTask($description, $user_id);
			
		}
		elseif (isset($_POST['save']) and $_POST['save'] == 'Обновить') {
			$description = strip_tags($_POST['description']);
			$id = strip_tags($_POST['id']);
			$this->model->updateTask($description, $id);
			header("Location: index.php");
		}
	}

	public function update() 
	{
		if (!empty($_POST['id']) and !empty($_POST['action']) && $_POST['action'] == 'edit') {
			$button = 'Обновить';
			$description = strip_tags($_POST['description']);
			$id = strip_tags($_POST['id']);
			$this->model->updateTask($description, $id);
			header("Location: index.php");
		}
	}

	public function changeAssigned() 
	{
		if (!empty($_POST['assigned_user_id'])) {
			$assign_id = strip_tags($_POST['assigned_user_id']);
			$row_id = strip_tags($_POST['row_id']);
			$this->model->changeAssignedTask($assign_id, $row_id);
			header("Location: index.php");
		}
	}

}

?>