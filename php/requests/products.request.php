<?php 
// includes
include_once '../helpers/ip.helper.php';

// set path to file
$filePath = "../../app_data/products.json";
if ( !file_exists("../../app_data") )
	mkdir("../../app_data");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	// set responce header
	header('Content-Type: application/json');
	// get products from file
	header("HTTP/1.1 200 Success");
	$products = file_get_contents($filePath);
	echo $products;
}
else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
	// check for permissions
	if ($checkAdmin()) {
		// decode products from request
		$params = json_decode(file_get_contents('php://input'));
		// put products file
		unlink($filePath);
		file_put_contents($filePath, json_encode($params));
		header("HTTP/1.1 240 Success");
		echo 'Success';
	}
	else {
		header("HTTP/1.1 401 Unauthorized");
		echo "No permissions to modify products.";
	}
};

?>