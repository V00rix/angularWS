<?php
// includes
include '../php/helpers/login.helper.php';

session_start();

if(count($_POST) > 0) {
	$_SESSION['username'] = $_POST['username'];
	$_SESSION['password'] = $_POST['password'];
	header("HTTP/1.1 303 See Other");
	header("location: index.php");
	die();
}
else if (isset($_SESSION['username'])) {
	$adminsList = json_decode(file_get_contents("../app_data/admins.json"));
	// try to login as admin, auto logout after 5 minutes
	login($adminsList, $_SESSION['username'], null, $_SESSION['password'], 'admin', 300, 
		function() {
			echo file_get_contents("./app/app.template.html");
		},
		function($e) {
			echo file_get_contents("./login/login_form.template.html");
			echo file_get_contents("./login/error/login_error_0.template.html");
			echo $e->getMessage();
			echo file_get_contents("./login/error/login_error_1.template.html");
		});

}
else  {
	echo file_get_contents("./login/login_form.template.html");
	echo file_get_contents("./login/login_success.template.html");
}
?>