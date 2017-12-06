<?php /* Request to login user */
/* includes */
$root = $_SERVER['DOCUMENT_ROOT'] . '/angularWS/php/';

// validations
include $root . 'validation/serverMethod.validation.php';
// helpers 
include $root . 'helpers/files.helper.php';
include $root . 'helpers/login.helper.php';
include $root . 'helpers/exceptionToResponse.helper.php';

/* file paths */
$usersFilePath = "../../../../../app_data/users.json";

// main request
try {
	// check method
	methodAllowed('POST');

	// decode params from request
	$params = json_decode(file_get_contents('php://input'));

	// read users from file
	$users = getFileContents($usersFilePath);

	// login
	login($users, $params->username, $params->password, 'user', 600, 
		function() {
			header("HTTP/1.1 200 Success");
		});
}
/* Transform errors to http responses */
catch (Exception $e) {
	transformException($e);
}
?>