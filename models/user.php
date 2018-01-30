<?php

class User 
{
	public $db = null;

	public function __construct($db) 
	{
		$this->db = $db;
	}

	public function isUser($login) 
	{ 
		$sth = $this->db->prepare("SELECT id FROM user WHERE login=?"); 
		$sth->bindValue(1, $login, PDO::PARAM_STR); 
		$sth->execute();
		$result = $sth->fetch(PDO::FETCH_ASSOC); 
		return $result; 
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