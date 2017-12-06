<?php /* Update temporary cart */
/* includes */
$root = $_SERVER['DOCUMENT_ROOT'] . '/angularWS/php/';

// validations
include $root . 'validation/serverMethod.validation.php';
// helpers 
include $root . 'helpers/exceptionToResponse.helper.php';

// main request
try {
	methodAllowed('POST');

	session_start();

	// decode products from request
	$params = file_get_contents('php://input');

	$_SESSION['temporaryCart'] = $params;

	header("HTTP/1.1 200 Success");
}
/* Transform errors to http responses */
catch (Exception $e) {
	transformException($e);
}
?>