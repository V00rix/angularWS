<?php /* Request to logout user */
/* includes */
$root = $_SERVER['DOCUMENT_ROOT'] . '/angularWS/php/';

// validations
include $root . 'validation/serverMethod.validation.php';
// helpers 
include $root . 'helpers/redirection.helper.php';
include $root . 'helpers/exceptionToResponse.helper.php';

// main request
try {
	// check method
	methodAllowed('GET');

	// start session
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}

	// preserve current cart 
	$cart = $_SESSION['temporaryCart'];

	// destroy current seession
	session_unset();
	session_destroy();

	// start new session
	session_start();
	
	// save temporary cart to new session
	$_SESSION['temporaryCart'] = $cart;

	// redirect back
	refreshRedirectBack();
}
/* Transform errors to http responses */
catch (Exception $e) {
	transformException($e);
}
?>