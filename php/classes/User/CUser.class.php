<?php 
class CUser {
	// unique per user
	public $username;
	public $email;
	public $password;
	public $history = [];

	function __construct($username, $email, $password)
	{
		$this->username = $username;
		$this->email = $email;
		$this->password = $password;
	}
	// history of previous transactions
}
?>
