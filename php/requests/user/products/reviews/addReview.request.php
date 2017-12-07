<?php /* Request to add existing review */
/* includes */
$root = $_SERVER['DOCUMENT_ROOT'] . '/angularWS/php/';

// classes
include $root . 'classes/LoginResponse/CCredentialsCheckResponse.class.php';

// helpers
include $root . 'helpers/files.helper.php';
include $root . 'helpers/products.helper.php';
include $root . 'helpers/exceptionToResponse.helper.php';

// validations
include $root . 'validation/permissions.validation.php';
include $root . 'validation/serverMethod.validation.php';

/* file paths */
$productsFilePath = "../../../../../app_data/products.json";
$usersFilePath = "../../../../../app_data/users.json";
$changesFilePath = "../../../../../app_data/changes.json";

// main request
try {
	methodAllowed('PUT');

	// start session
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}

	// check permissions
	isAllowed('user');

	// decode products from request
	$params = json_decode(file_get_contents('php://input'));

	// read users from file
	$products = getFileContents($productsFilePath);

	//validate input
	addReview($params->productId, $products, $params->review);

	// check if not in use by admin
	canEdit($changesFilePath);

	// update products content
	fileUpdateContents($productsFilePath, $products);

	// send response
	header("HTTP/1.1 200 Success");
} catch (Exception $e) {	
	transformException($e);	
}
?>