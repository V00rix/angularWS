<?php /* Admin's request to update product list */
/* includes */
$root = $_SERVER['DOCUMENT_ROOT'] . '/angularWS/php/';
// validations
include $root . 'validation/serverMethod.validation.php';
include $root . 'validation/permissions.validation.php';
// helpers
include $root . 'helpers/files.helper.php';
include $root . 'helpers/exceptionToResponse.helper.php';

/* file paths */
$productsFilePath = '../../../../app_data/products.json';

// main request
try {
	// check method
	methodAllowed('POST');

	// start session
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}

	// check permissions
	isAllowed('admin');

	// decode params from request
	$params = json_decode(file_get_contents('php://input'));

	// TODO: validate products input

	// update products content
	fileUpdateContents($productsFilePath, $params);

	// send response
	header("HTTP/1.1 200 Success");		
}
catch (Exception $e) {	
	transformException($e);
}
?>