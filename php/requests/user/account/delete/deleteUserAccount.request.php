<?php /* Delete user's accout request */
/* includes */
$root = $_SERVER['DOCUMENT_ROOT'] . '/angularWS/php/';

// classes
include_once $root . 'classes/Exceptions/exceptions.php';

// validations
include $root . 'validation/permissions.validation.php';
include $root . 'validation/serverMethod.validation.php';
// helpers 
include $root . 'helpers/files.helper.php';
include $root . 'helpers/accounts.helper.php';
include $root . 'helpers/exceptionToResponse.helper.php';

/* file paths */
$usersFilePath = "../../../../../app_data/users.json";
$changesFilePath = "../../../../../app_data/changes.json";

// main reuqest
try {	
	methodAllowed('PUT');

	session_start();

	isAllowed('user');

	// decode params from request
	$params = json_decode(file_get_contents('php://input'));

	// check if params are set
	if (!isset($params->username))
		throw new argumentMissingException("Username missing!");

	// try to read users from file
	$users = getFileContents($usersFilePath);

	// try to delete user
	$users = deleteUser($users, $params->username);

	// check if not in use by admin
	canEdit($changesFilePath);

	// write to file
	fileUpdateContents($usersFilePath, $users);

	// everything ok
	header("HTTP/1.1 200 Success");
	session_unset();
	session_destroy();
}
/* Transform errors to http responses */
catch (Exception $e) {
	transformException($e);
}
?>