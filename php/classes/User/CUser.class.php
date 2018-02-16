<?php /* Represents user model */

/**
 * Class CUser
 */
class CUser {
	// unique per user
	public $username;
	public $email;
	public $password;
	// history of previous transactions
	public $history = [];

    /**
     * CUser constructor.
     * @param $username
     * @param $email
     * @param $password
     */
    function __construct($username, $email, $password)
	{
		$this->username = $username;
		$this->email = $email;
		$this->password = $password;
	}
}
?>
