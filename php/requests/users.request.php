<?php 
// includes
include_once '../helpers/ip.helper.php';

// set path to file
$filePath = "../../app_data/users.json";
if ( !file_exists("../../app_data") )
	mkdir("../../app_data");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	// set responce header
	header('Content-Type: application/json');
	// get products from file
	header("HTTP/1.1 200 Success");
	$data = file_get_contents($filePath);
	echo $data;
}
else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
	try {
		// check for permissions
		if (true) {
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
	} catch (Exception $e) {		
		header("HTTP/1.1 500 Internal Server Error");
		echo $e;
	}
	// // check for permissions
	// if ($GLOBALS['foo']) {
	// 	// decode products from request
	// 	$params = json_decode(file_get_contents('php://input'));
	// 	// put products file
	// 	unlink($filePath);
	// 	file_put_contents($filePath, json_encode($params));
	// 	header("HTTP/1.1 240 Success");
	// 	echo 'Success';
	// }
	// else {
	// 	header("HTTP/1.1 401 Unauthorized");
	// 	echo "No permissions to modify products.";
	// }
};

?>