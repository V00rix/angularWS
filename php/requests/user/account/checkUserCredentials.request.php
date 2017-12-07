<?php /* Check user credentials */
/* includes */
$root = $_SERVER['DOCUMENT_ROOT'] . '/angularWS/php/';

// classes
include $root . 'classes/LoginResponse/CCredentialsCheckResponse.class.php';
// validations
include $root . 'validation/serverMethod.validation.php';
include $root . 'validation/userData.validation.php';
// helpers
include $root . 'helpers/files.helper.php';
include $root . 'helpers/exceptionToResponse.helper.php';

/* file paths */
$usersFilePath = "../../../../app_data/users.json";

// main request
try {	
	// check method
	methodAllowed('POST');

	// start session
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}

	// decode params from request
	$params = json_decode(file_get_contents('php://input'));
	
	// read users from file 
	$users = getFileContents($usersFilePath);

	// validate all fields, set $strictMode to false
	$response = CCredentialsCheckResponse::from(validUserFields($params, $users, false));

	// return response
	echo json_encode($response);
} catch (Exception $e) {	
	transformException($e);	
}
?>