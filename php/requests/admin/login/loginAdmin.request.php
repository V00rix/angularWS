<?php /* Admin's login request */
/* includes */
$root = $_SERVER['DOCUMENT_ROOT'] . '/angularWS/php/';
// validations
include $root . 'validation/serverMethod.validation.php';
// helpers
include $root . 'helpers/files.helper.php';
include $root . 'helpers/login.helper.php';
include $root . 'helpers/redirection.helper.php';

/* file paths */
$adminsFilePath = '../../../../app_data/admins.json';
/* redirection */
$successRedirectPath = "../../../../admin/main.php";
$errorRedirectPath = "../../../../admin/index.php";

// main request
try {
	// check method
	methodAllowed('GET');

	// start session
	session_start();

	// try to login as admin, auto logout after 5 minutes
	login(getFileContents($adminsFilePath), $_SESSION['username'], $_SESSION['password'], 'admin', 300, 
		function() use($successRedirectPath) {			
			setEditStatus('closed');
			redirectTo($successRedirectPath);
		});
}
catch (Exception $e) {
	$_SESSION['loginError'] = $e->getMessage();
	redirectTo($errorRedirectPath);
}
?>