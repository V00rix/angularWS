<?php 
class User {
	// unique per user
	public $ip;
	public $name;
	public $password;
	// history of previous transactions
	public $history;
	// remember current cart in case of front-end crash etc.
	public $currentCart; // = products[] {}
	// some methods
}
?>
