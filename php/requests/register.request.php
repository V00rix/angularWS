<?php 

// includes
include_once '../classes/user.class.php';
include_once '../classes/exceptions.php';
include '../helpers/login.helper.php';

// set file path
$filePath = "../../app_data/users.json";
$changes = "../../app_data/changes.json";

if ( !file_exists("../../app_data") )
	mkdir("../../app_data");

// registration 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	try {	
		session_start();
		$passwordMatch = "/^[A-z0-9]{8,16}$/";
		$usernameMatch = "/^[A-z0-9]{4,12}$/";
		$emailMatch = "/^[^ ]+@[^ ]+\.[^ ]+$/";

		// decode params from request
		$params = json_decode(file_get_contents('php://input'));

		// check if params are set
		if (!isset($params->username))
			throw new argumentMissingException("username");

		if (!isset($params->email))
			throw new argumentMissingException("email");

		if (!isset($params->password)) 
			throw new argumentMissingException("password");

		// try to read users from file
		if ( !file_exists($filePath) )
			throw new fileNotFoundException("No user file found");
		$users = json_decode(file_get_contents($filePath));

		// check if registration is possible
		registrationPossible($users, $params->username, $params->email);

		/* Check data formats */
		// check username
		if (!preg_match($usernameMatch, $params->username))
			throw new badUsernameException("Username contains unallowed symbols!");

		// check email
		if (!preg_match($emailMatch, $params->email))
			throw new badEmailException("Invalid password format!");

		// check password
		if (!preg_match($passwordMatch, $params->password))
			throw new badPasswordException("Password contains forbidden symbols!");

		// everything is ok
		array_push($users, new User($params->username, $params->email, $params->password));

		// check if not in use by admin
		if (json_decode(file_get_contents($changes))->open === false)
			throw new inUseException("File is in use by administrator.");

		// write to file
		unlink($filePath); 
		file_put_contents($filePath, json_encode($users));

		// send response
		header("HTTP/1.1 200 Success");		
	}
	catch (fileNotFoundException $e) {
		header("HTTP/1.1 500 Internal Server Error");
		echo $e->getMessage();			
	} 
	catch (inUseException $e) {
		header("HTTP/1.1 503 In Use");
		echo $e->getMessage();			
	} 
	catch (badUsernameException $e) {
		header("HTTP/1.1 400 Bad Username");
		echo $e->getMessage();	
	}
	catch (badEmailException $e) {
		header("HTTP/1.1 400 Bad Email");
		echo $e->getMessage();	
	}
	catch (badPasswordException $e) {
		header("HTTP/1.1 400 Bad Password");
		echo $e->getMessage();	
	}
	catch(argumentMissingException $e) {
		header("HTTP/1.1 400 Bad Request Data");
		echo $e->getMessage();			
	}
	catch (Exception $e) {	
		header("HTTP/1.1 500 Internal Server Error");
		echo $e->getMessage();		
	}
}
// Delete account request (from user!)
else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
	try {	
		session_start();

		// check permissions
		if (!isset($_SESSION['user'])) 
			throw new notAllowedException("Forbidden to delete account");

		// check if session has not yet expired
		sessionNotExpired();

		// decode params from request
		$params = json_decode(file_get_contents('php://input'));

		// check if params are set
		if (!isset($params->username))
			throw new argumentMissingException("Username missing!");

		// try to read users from file
		if (!file_exists($filePath) )
			throw new fileNotFoundException("No user file to delete from");
		$users = json_decode(file_get_contents($filePath));

		// try to delete user
		$users = deleteUser($users, $params->username);

		// check if not in use by admin
		if (json_decode(file_get_contents($changes))->open === false)
			throw new inUseException("File is in use by administrator.");

		// write to file
		unlink($filePath);
		file_put_contents($filePath, json_encode((array)$users));

		// everything ok
		header("HTTP/1.1 200 Success");
		session_unset();
		session_destroy();
	}
	catch (sessionExpiredException $e) {
		header("HTTP/1.1 419 Authentication Timeout");
		echo $e->getMessage();
	}
	catch (notAllowedException $e) {
		header("HTTP/1.1 401 Unauthorized");
		echo $e->getMessage();			
	}
	catch (fileNotFoundException $e) {
		header("HTTP/1.1 500 Internal Server Error");
		echo $e->getMessage();			
	}
	catch (inUseException $e) {
		header("HTTP/1.1 503 In Use");
		echo $e->getMessage();			
	}
	catch (badUsernameException $e) {
		header("HTTP/1.1 400 Bad Username");
		echo $e->getMessage();			
	}
	catch(argumentMissingException $e) {
		header("HTTP/1.1 400 Argument missing");
		echo $e->getMessage();			
	}
	catch(Exception $e) {	
		header("HTTP/1.1 500 Internal Server Error");
		echo $e->getMessage();		
	}
}
else {	
	header("HTTP/1.1 405 Method Not Allowed");
	echo $_SERVER['REQUEST_METHOD'] . " method is not allowed";
}
?>