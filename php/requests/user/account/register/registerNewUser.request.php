<?php /* Register new user request */
/* includes */
$root = $_SERVER['DOCUMENT_ROOT'] . '/angularWS/php/';

// classes
include_once $root . 'classes/Exceptions/exceptions.php';
include $root . 'classes/LoginResponse/CCredentialsCheckResponse.class.php';
include $root . 'classes/User/CUser.class.php';

// validations
include $root . 'validation/permissions.validation.php';
include $root . 'validation/serverMethod.validation.php';
include $root . 'validation/userData.validation.php';
// helpers 
include $root . 'helpers/files.helper.php';
include $root . 'helpers/accounts.helper.php';
include $root . 'helpers/exceptionToResponse.helper.php';

/* file paths */
$usersFilePath = "../../../../../app_data/users.json";
$changesFilePath = "../../../../../app_data/changes.json";

// main request 
try {	
	methodAllowed('POST');

	session_start();

	// decode params from request
	$params = json_decode(file_get_contents('php://input'));

	// try to read users from file
	$users = getFileContents($usersFilePath);

	$res = CCredentialsCheckResponse::from(validUserFields($params, $users, false));

	// attempt to create new user
	if (!$res->usernameFound && !$res->emailFound);
		array_push($users, new CUser($params->username, $params->email, password_hash($params->password, PASSWORD_BCRYPT)));

	// check if not in use by admin
	canEdit($changesFilePath);
	
	// write to file
	unlink($usersFilePath); 
	file_put_contents($usersFilePath, json_encode((array)$users));

	// send response
	header("HTTP/1.1 200 Success");		
}
/* Transform errors to http responses */
catch (Exception $e) {
	transformException($e);
}
?>