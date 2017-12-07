<?php 
/**
* Check credentials response
*/
class CCredentialsCheckResponse
{
	/* status fields */
	public $usernameFound = null;
	public $emailFound = null;
	public $passwordFound = null;

	/* Constructors */
	// empty constructor
	public function __construct()
	{
		$this->usernameFound = null;
		$this->emailFound = null;
		$this->passwordFound = null;
	}

	// copy constructor
	public static function from( $another ) {
		$instance = new self();
		$instance->usernameFound = $another->usernameFound;
		$instance->emailFound = $another->emailFound;
		$instance->passwordFound = $another->passwordFound;
		return $instance;
	}		
}
 ?>