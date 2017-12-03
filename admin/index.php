<?php
// includes
include_once '../php/helpers/login.helper.php';
include_once '../php/classes/exceptions.php';

// set file path
$filePath = "../app_data/admins.json";
$changes = "../app_data/changes.json";

if ( !file_exists("../app_data") )
	mkdir("../app_data");

session_start();

if($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (file_exists($filePath)) {
		$adminsList = json_decode(file_get_contents($filePath));
		
		// try to login as admin, auto logout after 5 minutes
		login($adminsList, $_POST['username'], $_POST['password'], 'admin', 300, 
			function() use ($changes) {
				try {		
					$_SESSION['loginError'] = "";

					// check files
					if ( !file_exists($changes) )
						throw new fileNotFoundException("No status file found");
					$changesData = json_decode(file_get_contents($changes));
					// set as in use
					$changesData->open = false;

					var_dump($changes);
					var_dump($changesData);

					unlink($changes);
					file_put_contents($changes, json_encode($changesData));

					echo file_get_contents("./app/app.template.html");
				} 
				catch (fileNotFoundException $e) {
					header("HTTP/1.1 500 File Not Found");
					echo $e->getMessage();			
				} 
				catch (Exception $e) {
					header("HTTP/1.1 500 Internal Server Error");
					echo $e->getMessage();					
				}
			},
			function($e) {
				$_SESSION['loginError'] = $e->getMessage();
			});
	}
	else
		$_SESSION['loginError'] = "No users file found";
	header("HTTP/1.1 303 See Other");
	header("location: index.php");
}
else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	try {
		if (!isset($_SESSION['loginError']))
			throw new notAllowedException("");
		
		if(!isset($_SESSION['admin'])) 
			throw new notAllowedException($_SESSION['loginError']);
		
		// check if the session is active
		sessionNotExpired();

		echo file_get_contents("./app/app.template.html");

	} catch (baseException $e) {
		// when trying to get the page, but not logged in as admin
		echo file_get_contents("./login/login_form.template.html");
		$msg = $e->getMessage();
		if (strlen($msg) < 1)
			echo file_get_contents("./login/login_success.template.html");
		else {
			echo file_get_contents("./login/error/login_error_0.template.html");
			echo $msg;
			echo file_get_contents("./login/error/login_error_1.template.html");
		}
	}
}
else{
	header("HTTP/1.1 405 Method Not Allowed");
	echo $_SERVER['REQUEST_METHOD'] . " method is not allowed";
}
?>