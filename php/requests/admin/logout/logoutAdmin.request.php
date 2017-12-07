<?php /* Request to logout administrator */
/* includes */
$root = $_SERVER['DOCUMENT_ROOT'] . '/angularWS/php/';

// validations
include $root . 'validation/permissions.validation.php';
include $root . 'validation/serverMethod.validation.php';
// helpers 
include $root . 'helpers/files.helper.php';
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

	// check permissions
	isAllowed('admin', "Trying to logout as administrator, but not logged in as one.");

	// alow user editing
	setEditStatus('open');

	// destroy current seession
	session_unset();
	session_destroy();

	// redirect back
	redirectBack();
}
/* Transform errors to http responses */
catch (Exception $e) {
	transformException($e);
}
?>