<?php

class Task 
{
	public $db = null;

	public function __construct($db) 
	{
		$this->db = $db;
	}

	public function addTask($description, $user_id) 
	{
		$query = "INSERT INTO task (description, date_added, user_id, assigned_user_id) VALUES (?, now(), ?, ?)";
		$sth = $this->db->prepare($query);
		$sth->bindValue(1, $description, PDO::PARAM_STR);
		$sth->bindValue(2, $user_id, PDO::PARAM_INT);
		$sth->bindValue(3, $user_id, PDO::PARAM_INT);
		return $sth->execute();
	}

	public function deleteTask($id) 
	{
		$query = "DELETE FROM task WHERE id = ?";
		$sth = $this->db->prepare($query);
		$sth->bindValue(1, $id, PDO::PARAM_INT);
		return $sth->execute();
	}

	public function doneTask($id) 
	{
		$query = "UPDATE task SET is_done = 1 WHERE id = ?";
		$sth = $this->db->prepare($query);
		$sth->bindValue(1, $id, PDO::PARAM_INT);
		return $sth->execute();
	}

	public function findTask($id)
	{
		$query = "SELECT description FROM task WHERE id = ?";
		$sth = $this->db->prepare($query);
		$sth->bindValue(1, $id, PDO::PARAM_INT);
		$sth->execute();
		$result = $sth->fetch(PDO::FETCH_ASSOC);
		return $result;
	}

	public function updateTask($description, $id) 
	{
		$query = "UPDATE task SET description = ? WHERE id = ?";
		$sth = $this->db->prepare($query);
		$sth->bindValue(1, $description, PDO::PARAM_STR);
		$sth->bindValue(2, $id, PDO::PARAM_INT);
		return $sth->execute();
	}

	public function changeAssignedTask($assign_id, $row_id) 
	{
		$query = "UPDATE task SET assigned_user_id = ? WHERE id = ?";
		$sth = $this->db->prepare($query);
		$sth->bindValue(1, $assign_id, PDO::PARAM_INT);
		$sth->bindValue(2, $row_id, PDO::PARAM_INT);
		return $sth->execute();
	}

	public function findAllTasksSort($sort) 
	{
		$query = "SELECT t.id as task_id, t.description as description, u.id as user_id, u.login as login, au.id as assigned_user_id, au.login as assigned_user_name, t.is_done as is_done, t.date_added as date_added FROM task t INNER JOIN user u ON u.id=t.user_id INNER JOIN user au ON t.assigned_user_id=au.id ORDER BY $sort ASC";
		$sth = $this->db->query($query);
		return $sth;
	}

	public function findAllTasks() {
			$query = "SELECT t.id as task_id, t.description as description, u.id as user_id, u.login as login, au.id as assigned_user_id, au.login as assigned_user_name, t.is_done as is_done, t.date_added as date_added FROM task t INNER JOIN user u ON u.id=t.user_id INNER JOIN user au ON t.assigned_user_id=au.id";
			$sth = $this->db->query($query);
			return $sth;
	}

	public function findAllUsers() {
		$sth = $this->db->prepare("SELECT id, login FROM user"); 
		$sth->execute(); 
		return $result = $sth->fetchAll(PDO::FETCH_ASSOC);
	}
}

?>