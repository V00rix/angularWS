<?php /* User's request to get products list */
/* includes */
$root = $_SERVER['DOCUMENT_ROOT'] . '/angularWS/php/';
// validations
include $root . 'validation/serverMethod.validation.php';
// helpers
include $root . 'helpers/files.helper.php';
include $root . 'helpers/exceptionToResponse.helper.php';

/* file paths */
$productFilePath = '../../../../app_data/products.json';

// main request
try {
	// check method
	methodAllowed('GET');

	// check method
	echoJsonContent($productFilePath);
}
catch (Exception $e) {
	transformException($e);
}	
?>