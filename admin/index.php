<?php /* Admin login entry point */
/* includes */
$root = $_SERVER['DOCUMENT_ROOT'] . '/angularWS/php/';

// helpers
include $root . 'helpers/redirection.helper.php';

/* redirection paths */ 
$loginAdminPath = "../php/requests/admin/login/loginAdmin.request.php";

// main request
if($_SERVER['REQUEST_METHOD'] === 'POST') {
	// start session
	session_start();

	// read form data
	$_SESSION['username'] = $_POST['username'];
	$_SESSION['password'] = $_POST['password'];

	// redirect to main login logic
	redirectTo($loginAdminPath);
}
// login form (watch description inside for more info)
else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	/* 
	*	When GET occurs, there are only two possible options:
	*
	*		1. The page is loaded for the first time
	*		so we $_SESSION['loginError'] is not yet set.
	*		-> DISPLAY USUSAL LOGIN PAGE
	*
	*		2. Redirect has occured from $loginAdminPath,
	*		because errors has occured
	*		-> DISPLAY ERROR IN THE BOTTOM OF LOGIN PAGE			
	*/

	// display default login header
	echo file_get_contents("./login/login_form.template.html");	

	// start session
	session_start();

	// check for errors while trying to login 
	if (!isset($_SESSION['loginError']) || $_SESSION['loginError'] === "")
		// no errors -> usual login page
		echo file_get_contents("./login/login_success.template.html");
	else {
		// error -> display errror
		echo file_get_contents("./login/error/login_error_0.template.html");
		echo $_SESSION['loginError'];
		echo file_get_contents("./login/error/login_error_1.template.html");
	}
}
// not allowed
else {
	header("HTTP/1.1 405 Method Not Allowed");
	echo $_SERVER['REQUEST_METHOD'] . " method is not allowed";
}
?>