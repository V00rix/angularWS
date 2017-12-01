<?php 
class User {
	// unique per user
	public $username;
	public $email;
	public $password;

	function __construct($username, $email, $password)
	{
		$this->username = $username;
		$this->email = $email;
		$this->password = $password;
	}
	// history of previous transactions
	// public $history;
	// remember current cart in case of front-end crash etc.
	// public $currentCart; // = products[] {}
	// some methods
}
?>
