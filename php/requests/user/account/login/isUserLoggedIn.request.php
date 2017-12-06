<?php /* Request to know if the user is already logged in */
/* includes */
$root = $_SERVER['DOCUMENT_ROOT'] . '/angularWS/php/';
// validations
include $root . 'validation/serverMethod.validation.php';

// main request
try {
	// check method
	methodAllowed('GET');

	// start session
	session_start();

	// return username if user  is logged in
	echo (isset($_SESSION['user']) ? $_SESSION['user'] : null);
}
/* Transform errors to http responses */
catch (Exception $e) {
	transformException($e);
}
 ?>