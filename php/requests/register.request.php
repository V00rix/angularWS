<?php 

// includes
include('../helpers/login.helper.php');
include('../classes/exceptions.php');
include('../classes/user.class.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	try {	
		session_start();
		$filePath = "../../app_data/users.json";

		// decode params from request
		$params = json_decode(file_get_contents('php://input'));

		// check if params are set
		if (!isset($params->username) || !isset($params->email) || !isset($params->password))
			throw new argumentMissingException("Some arguments are missing!");

		// check if folder exists
		if ( !file_exists("../../app_data") )
			mkdir("../../app_data");
		
		// try to read users from file
		if ( file_exists($filePath) )
			$users = json_decode(file_get_contents($filePath));
		
		var_dump($users);
		// check if registration is possible
		registrationPossible($users, $params->username, $params->email);

		/* Check data formats */
		// check username
		if (!preg_match("/^[A-z0-9]{4,12}$/",$params->username))
			throw new badUsernameException("Username contains unallowed symbols!");

		// check email
		if (!preg_match("/^[^ ]+@[^ ]+\.[^ ]+$/",$params->email))
			throw new badEmailException("Invalid password format!");

		// check password
		if (!preg_match("/^[A-z0-9]{8,16}$/",$params->password))
			throw new badPasswordException("Password contains unallowed symbols!");

		// everything is ok
		array_push($users, new User($params->username, $params->email, $params->password));

		// write to file
		unlink($filePath); 
		file_put_contents($filePath, json_encode($users));

		// send response
		header("HTTP/1.1 200 Success");		
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
else {	
	header("HTTP/1.1 405 Method Not Allowed");
	echo $_SERVER['REQUEST_METHOD'] . " method is not allowed";
}
?>