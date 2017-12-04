<?php 
// includes
include_once '../classes/exceptions.php';
include_once '../classes/product.class.php';
include '../helpers/login.helper.php';
include '../helpers/validator.helper.php';

// set file path
$productsFilePath = "../../app_data/products.json";
$userFilePath = "../../app_data/users.json";
$changes = "../../app_data/changes.json";

if ( !file_exists("../../app_data") )
	mkdir("../../app_data");

// should be: admin's post to edit all products
else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	try {
		session_start();

		// check permissions and set user
		if (!isset($_SESSION['user'])) 
			throw new notAllowedException("Forbidden to edit products");

		// check if session has not yet expired
		sessionNotExpired();

		// decode products from request
		$params = json_decode(file_get_contents('php://input'));

		// check files
		if ( !file_exists($productsFilePath) )
			throw new fileNotFoundException("No products file found");
		if ( !file_exists($userFilePath) )
			throw new fileNotFoundException("No user file found");

		// read data
		$users =  json_decode(file_get_contents($userFilePath));
		$products = json_decode(file_get_contents($productsFilePath));

		$user = searchUsername($users, $_SESSION['user']);

		if (!isset($user->history))
			$user->history = [];

		// loop through elements of request
		foreach ($params as $prod) {
			// check product id
			if (!isset($prod->id))
				throw new badArgumentException("Product id is not set");
			$product = searchProduct($products, $prod->id);

			// check quantity
			if (!isset($prod->quantity))
				throw new badArgumentException("Quantity is not set");
			inRange($prod->quantity, 0,  $product->quantity, "Product quantity");
			
			// ok
			$product->quantity -= $prod->quantity;	

			// make history!
			$toHistory = Product::from($product);
			$toHistory->quantity = $prod->quantity;
			array_push($user->history, $toHistory);
		}

		// save data
		unlink($userFilePath); 
		file_put_contents($userFilePath, json_encode($users));
		unlink($productsFilePath); 
		file_put_contents($productsFilePath, json_encode($products));

		// check if not in use by admin
		if (json_decode(file_get_contents($changes))->open === false)
			throw new inUseException("File is in use by administrator.");

		// clear temporary cart
		$_SESSION['temporaryCart'] = null;

		header("HTTP/1.1 200 Success");
	} 
	catch (fileNotFoundException $e) {
		header("HTTP/1.1 500 Internal Server Error");
		echo $e->getMessage();			
	} 
	catch (badArgumentException $e) {		
		header("HTTP/1.1 400 Bad Request Parameters");
		echo $e->getMessage();		
	}
	catch (inUseException $e) {
		header("HTTP/1.1 503 In Use");
		echo $e->getMessage();			
	}
	catch (sessionExpiredException $e) {
		header("HTTP/1.1 419 Authentication Timeout");
		echo $e->getMessage();
	} 
	catch (notAllowedException $e) {
		header("HTTP/1.1 401 Forbidden to edit products");
		echo $e->getMessage();
	}
	catch (Exception $e) {		
		header("HTTP/1.1 500 Internal Server Error");
		echo $e->getMessage();
	}
}
else {
	header("HTTP/1.1 405 Method Not Allowed");
	echo $_SERVER['REQUEST_METHOD'] . " method is not allowed";
}

?>