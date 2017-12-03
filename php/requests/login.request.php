<?php
// includes
include_once '../classes/exceptions.php';
include '../helpers/login.helper.php';

// set file path
$filePath = "../../app_data/users.json";
if ( !file_exists("../../app_data") )
	mkdir("../../app_data");

/**
* Response
*/
class CResponse
{
	public $usernameStatus = null;
	public $emailStatus = null;
	public $passwordStatus = null;

	function __construct()
	{
		$this->usernameStatus = null;
		$this->emailStatus = null;
		$this->passwordStatus = null;
	}
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	try {	
		$response = new CResponse();
		session_start();

		// decode params from request
		$params = json_decode(file_get_contents('php://input'));

		// try to read users from file 
		if ( !file_exists($filePath) )
			throw new fileNotFoundException("No users file found");
		$users = json_decode(file_get_contents($filePath));

		$response->emailStatus = !isset($params->email) || emailFree($users, $params->email);

		try {
			// try to login as user, auto logout after 10 minutes
			login($users, $params->username, $params->password, 'user', 600, 
				function() use(&$response) {
					header("HTTP/1.1 200 Success");
					$response->usernameStatus = $response->passwordStatus = true;
				},
				function($e) {
					throw $e;
				});
		}
		catch (badUsernameException $e) {
			header("HTTP/1.1 290 Bad Username");
			$response->usernameStatus = false;
		}
		catch (badPasswordException $e) {
			header("HTTP/1.1 291 Wrong Password");
			$response->usernameStatus = true;
			$response->passwordStatus = false;
		}
		finally {
			echo json_encode($response);
		}
	} catch (Exception $e) {	
		header("HTTP/1.1 500 Internal Server Error");
		echo $e->getMessage();		
	}
}
// gets called to know if the user is already logged in and thus
else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	session_start();
	echo (isset($_SESSION['user']) ? $_SESSION['user'] : null);
}
else {	
	header("HTTP/1.1 405 Method Not Allowed");
	echo $_SERVER['REQUEST_METHOD'] . " method is not allowed";
}
?>