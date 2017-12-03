<?php 
// includes
include_once '../classes/exceptions.php';
include '../helpers/login.helper.php';

// set path to file
$filePath = "../../app_data/users.json";
$changes = "../../app_data/changes.json";

if ( !file_exists("../../app_data") )
	mkdir("../../app_data");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	try {
		session_start();

		// check for permissions
		if (!isset($_SESSION['admin'])) 
			throw new notAllowedException("Forbidden to view users");

		// check if session has not yet expired
		sessionNotExpired();

		header('Content-Type: application/json');
		header("HTTP/1.1 200 Success");
		
		// try to read users from file
		if ( !file_exists($filePath) )
			throw new fileNotFoundException("No user file found");
		$data = file_get_contents($filePath);
		echo $data;
	}	
	catch (fileNotFoundException $e) {
		header("HTTP/1.1 500 Internal Server Error");
		echo $e->getMessage();			
	} 
	catch (sessionExpiredException $e) {
		header("HTTP/1.1 419 Authentication Timeout");
		echo $e->getMessage();
	}
	catch (notAllowedException $e) {
		header("HTTP/1.1 401 Not Allowed");
		echo $e->getMessage();	
	}
	catch (Exception $e) {		
		header("HTTP/1.1 500 Internal Server Error");
		echo $e->getMessage();
	}
}
else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	try {
		session_start();

		// check for permissions
		if (!isset($_SESSION['admin'])) 
			throw new notAllowedException("Forbidden to edit users");

		// check if session has not yet expired
		sessionNotExpired();

		$passwordMatch = "/^[A-z0-9]{8,16}$/";
		$usernameMatch = "/^[A-z0-9]{4,12}$/";
		$emailMatch = "/^[^ ]+@[^ ]+\.[^ ]+$/";

		// decode params from request
		$params = json_decode(file_get_contents('php://input'));

		if (!is_array($params)) 
			throw new badArgumentException("Input is not a users array");


		foreach ($params as $user) {		
			// check if params are set
			if (!isset($user->username))
				throw new argumentMissingException("username");

			if (!isset($user->email))
				throw new argumentMissingException("email");

			if (!isset($user->password)) 
				throw new argumentMissingException("password");

			/* Check data formats */
			// check username
			if (!preg_match($usernameMatch, $user->username))
				throw new badUsernameException("Username contains unallowed symbols!");

			// check email
			if (!preg_match($emailMatch, $user->email))
				throw new badEmailException("Invalid password format!");

			// check password
			if (!preg_match($passwordMatch, $user->password))
				throw new badPasswordException("Password contains forbidden symbols!");

			// TODO: check if registration is possible (validate duplicate emails, usernames etc.)
		}

		// everything is ok
		// write to file
		unlink($filePath); 
		file_put_contents($filePath, json_encode($params));

		// send response
		header("HTTP/1.1 200 Success");		
	} 
	catch (sessionExpiredException $e) {
		header("HTTP/1.1 419 Authentication Timeout");
		echo $e->getMessage();
	}
	catch (notAllowedException $e) {
		header("HTTP/1.1 401 Not Allowed");
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
	catch(badArgumentException $e) {
		header("HTTP/1.1 400 Bad Users Array");
		echo $e->getMessage();			
	}
	catch (Exception $e) {	
		header("HTTP/1.1 500 Internal Server Error");
		echo $e->getMessage();		
	}
};

?>