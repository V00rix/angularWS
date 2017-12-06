<?php /* Get temporary cart products */
/* includes */
$root = $_SERVER['DOCUMENT_ROOT'] . '/angularWS/php/';

// validations
include $root . 'validation/serverMethod.validation.php';
// helpers 
include $root . 'helpers/exceptionToResponse.helper.php';

// main request
try {
	methodAllowed('GET');

	session_start();

	if (!isset($_SESSION['temporaryCart']))
		$_SESSION['temporaryCart'] = null;

	// get products
	$data = $_SESSION['temporaryCart'];

	// send response
	echo $data;
}
/* Transform errors to http responses */
catch (Exception $e) {
	transformException($e);
}
?>