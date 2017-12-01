<?php 
// includes
include_once '../helpers/ip.helper.php';

// set path to file
$filePath = "../../app_data/users.json";
if ( !file_exists("../../app_data") )
	mkdir("../../app_data");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	try {
		session_start();
		// admin rights are required to view users list
		if (isset($_SESSION['admin'])) {
			header('Content-Type: application/json');
			header("HTTP/1.1 200 Success");
			// get products from file
			$data = file_get_contents($filePath);
			echo $data;
		}
		else {	
			header("HTTP/1.1 401 Unauthorized");
			echo "No permissions view users data.";
		}
	} catch (Exception $e) {		
		header("HTTP/1.1 500 Internal Server Error");
		echo $e->getMessage();
	}

}
else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
};

?>