<?php 
/* includes */
$root = $_SERVER['DOCUMENT_ROOT'] . '/angularWS/php/';

// validations
include $root . 'validation/serverMethod.validation.php';
include $root . 'validation/permissions.validation.php';

// helpers 
include $root . 'helpers/files.helper.php';
include $root . 'helpers/accounts.helper.php';
include $root . 'helpers/products.helper.php';
include $root . 'helpers/exceptionToResponse.helper.php';

/* file paths */
$usersFilePath = "../../../../app_data/users.json";
$productsFilePath = "../../../../app_data/products.json";
$changesFilePath = "../../../../app_data/changes.json";

// main request
try {
	methodAllowed('POST');

	session_start();
	isAllowed('user');

	// decode products from request
	$params = json_decode(file_get_contents('php://input'));

	// read data
	$users =  getFileContents($usersFilePath);
	$products = getFileContents($productsFilePath);

	$user = searchUsername($users, $_SESSION['user']);

	if (!isset($user->history))
		$user->history = [];

	var_dump($params);

	// loop through elements of request
	foreach ($params as $prod) {
		buyProduct($prod, $products, $user);
	}

	// check if not in use by admin
	canEdit($changesFilePath);

	// save data
	fileUpdateContents($usersFilePath, $users);
	fileUpdateContents($productsFilePath, $products);

	// clear temporary cart
	$_SESSION['temporaryCart'] = null;

	header("HTTP/1.1 200 Success");
} 
/* Transform errors to http responses */
catch (Exception $e) {
	transformException($e);
}

?>