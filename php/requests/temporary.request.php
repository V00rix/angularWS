<?php 
// includes

// get temporary cart
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	session_start();

	if (!isset($_SESSION['temporaryCart']))
		$_SESSION['temporaryCart'] = null;

	// get products
	$data = $_SESSION['temporaryCart'];

	// send response
	echo $data;
}
// update temporary cart
else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	try {
		session_start();

		// decode products from request
		$params = file_get_contents('php://input');
		
		$_SESSION['temporaryCart'] = $params;

		header("HTTP/1.1 200 Success");
	} catch (Exception $e) {		
		header("HTTP/1.1 500 Internal Server Error");
		echo $e->getMessage();
	}
}
else {
	header("HTTP/1.1 405 Method Not Allowed");
	echo $_SERVER['REQUEST_METHOD'] . " method is not allowed";	
}
?>
