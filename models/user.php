<?php

class User 
{
	public $db = null;

	public function __construct($db) 
	{
		$this->db = $db;
	}

	public function findUser() 
	{
		$login = $login;
		$query = 'SELECT login FROM user';
		$sth = $this->db->query($query);
		return $sth;
	}

	public function addUser($login, $password) 
	{
		$query = "INSERT INTO user (login, password) VALUES (?, ?)";
		$sth = $this->db->prepare($query);
		$sth->bindValue(1, $login, PDO::PARAM_STR);
		$sth->bindValue(2, $password, PDO::PARAM_STR);
		return $sth->execute();
	}
	
	public function findAll() 
	{
		$query = 'SELECT * FROM user';
		$sth = $this->db->query($query);
		return $sth;
	}

}

?>