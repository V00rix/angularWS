<?php /* Successful login destination */
/* includes */
$root = $_SERVER['DOCUMENT_ROOT'] . '/angularWS/php/';
// validations
include $root . 'validation/serverMethod.validation.php';
include $root . 'validation/permissions.validation.php';

$templatePath = "./app/app.template.html";

// main request
try {
	// check method
	methodAllowed('GET');
	
	// start session
	session_start();
	
	// check permissions
	isAllowed('admin', "");

	echo file_get_contents($templatePath);
}
catch (Exception $e) {
	$_SESSION['loginError'] = $e->getMessage();
	header("HTTP/1.1 303 See Other");
	header("location: ./index.php");
}
?>
