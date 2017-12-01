<?php
// set path to file
$filePath = "../../app_data/products.json";

// common get products data
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	// set responce header
	header('Content-Type: application/json');

	// get products from file
	header("HTTP/1.1 200 Success");
	$data = file_get_contents($filePath);

	// send response
	echo $data;
}
// should be: admin's post to edit all products
else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	try {
		session_start();

		// check permissions
		if (isset($_SESSION['admin'])) {

			// decode products from request
			$params = file_get_contents('php://input');

			// check if folder exists
			if ( !file_exists("../../app_data") )
				mkdir("../../app_data");

			// rewrite products file data		
			if ( file_exists($filePath) )
				unlink($filePath); 
			file_put_contents($filePath, $params);
			header("HTTP/1.1 200 Success");
		}
		else {	
			header("HTTP/1.1 403 Forbidden to edit products");
		}
	} catch (Exception $e) {		
		header("HTTP/1.1 500 Internal Server Error");
		echo $e->getMessage();
	}
}
// should be: user's review update
else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
	try {
		session_start();

		// check permissions
		if (isset($_SESSION['user'])) {

			// decode products from request
			$params = json_decode(file_get_contents('php://input'));

			// get products file data	
			// check if folder exists
			if ( !file_exists("../../app_data") )
				mkdir("../../app_data");

			// try to read users from file
			if ( file_exists($filePath) )
				$previousProducts = json_decode(file_get_contents($filePath));

			// push last review				
			array_push($previousProducts[$params->productId]->reviews, $params->review);

			// rewrite products file data	
			unlink($filePath); 
			file_put_contents($filePath, json_encode($previousProducts));
			header("HTTP/1.1 200 Success");
		}
		else {	
			header("HTTP/1.1 403 Forbidden to edit products");
		}
	} catch (Exception $e) {		
		header("HTTP/1.1 500 Internal Server Error");
		echo $e->getMessage();
	}
}
// unexpected
else {
	header("HTTP/1.1 405 Method Not Allowed");
	echo $_SERVER['REQUEST_METHOD'] . " method is not allowed";
};

?>