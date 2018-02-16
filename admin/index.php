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
	*		-> DISPLAY USUAL LOGIN PAGE
	*
	*		2. Redirect has occurred from $loginAdminPath,
	*		because errors has occurred
	*		-> DISPLAY ERROR IN THE BOTTOM OF LOGIN PAGE			
	*/

	// start session
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}

	if (!isset($_SESSION['username']))
        $_SESSION['username'] = '';
	// display default login header
	echo file_get_contents("./login/login_form_1.template.html");
	echo '<input class="ws-admin-input" id="username" type="text" name="username" value="' . $_SESSION['username'] . '" placeholder="username" />';
	echo file_get_contents("./login/login_form_2.template.html");

	// check for errors while trying to login 
	if (!isset($_SESSION['loginError']) || $_SESSION['loginError'] === "")
		// no errors -> usual login page
		echo file_get_contents("./login/login_success.template.html");
	else {
		// error -> display error
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