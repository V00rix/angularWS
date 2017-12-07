<?php /* Admin's request to get users list */
/* includes */
$root = $_SERVER['DOCUMENT_ROOT'] . '/angularWS/php/';
// validations
include $root . 'validation/serverMethod.validation.php';
include $root . 'validation/permissions.validation.php';
// helpers
include $root . 'helpers/files.helper.php';
include $root . 'helpers/exceptionToResponse.helper.php';

/* file paths */
$usersFilePath = '../../../../app_data/users.json';

// main request
try {
	// check method
	methodAllowed('GET');

	// start session
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}

	// check permissions
	isAllowed('admin');

	// set header
	header("HTTP/1.1 200 Success");

	// echo users list
	echoJsonContent($usersFilePath);

}	
catch (Exception $e) {		
	transformException($e);
}

?>