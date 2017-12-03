<?php
// includes
include_once '../classes/exceptions.php';
include '../helpers/login.helper.php';
include '../helpers/validator.helper.php';

// set file path
$filePath = "../../app_data/products.json";
$changes = "../../app_data/changes.json";

// Review title length constraints
$minTitleLength = 5;
$maxTitleLength = 20;

// Review description constraints
$minDescriptionLength = 25;
$maxDescriptionLength = 200;

if ( !file_exists("../../app_data") )
	mkdir("../../app_data");

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
		if (!isset($_SESSION['admin'])) 
			throw new notAllowedException("Forbidden to edit products");

		// check if session has not yet expired
		sessionNotExpired();

		// decode products from request
		$params = json_decode(file_get_contents('php://input'));

		// TODO: validate products input
		// var_dump($params);

		// rewrite products file data		
		if ( file_exists($filePath) )
			unlink($filePath); 
		file_put_contents($filePath, json_encode($params));

		header("HTTP/1.1 200 Success");

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
// should be: user's review update
else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
	try {
		session_start();

		// check permissions
		if (!isset($_SESSION['user'])) 
			throw new notAllowedException("Forbidden to edit products");

		// check if session has not yet expired
		sessionNotExpired();

		// decode products from request
		$params = json_decode(file_get_contents('php://input'));

		// try to read users from file
		if ( !file_exists($filePath) )
			throw new fileNotFoundException("No products file found");

		$products = json_decode(file_get_contents($filePath));

		/* validate input */
		// Product Id
		if (!isset($params->productId))
			throw new argumentMissingException("Missing Product Id");
		$product = searchProduct($products, $params->productId);

		// review object
		if (!isset($params->review))
			throw new argumentMissingException("Missing Review");

		// review title
		if (!isset($params->review->title))
			throw new argumentMissingException("Missing Review Title");
		if (!checkLength($params->review->title, $minTitleLength, $maxTitleLength))
			throw new badArgumentException("Bad Title Length");

		// review description
		if (!isset($params->review->description))
			throw new argumentMissingException("Missing Review Description");
		if (!checkLength($params->review->description, $minDescriptionLength, $maxDescriptionLength))
			throw new badArgumentException("Bad Description Length");

		// review date
		if (!isset($params->review->date))
			throw new argumentMissingException("Missing Review Date");
		// TODO: check date
		
		// review rating
		if (!isset($params->review->rating))
			throw new argumentMissingException("Missing Review Rating");
		if ($params->review->rating < 1 || $params->review->rating > 5)
			throw new badArgumentException("Bad Rating");

		// review user/username
		if (!isset($params->review->user) || !isset($params->review->user->username) )
			throw new argumentMissingException("Missing User");

		/* Everything ok */
		// push last review						
		array_push($product->reviews, $params->review);

		// update product's rating

		// product.rating = (product.rating * product.reviews.count + review.rate) / (product.reviews.cout + 1)
		// great, but works only with properly calculated rating before

		$totalProducts = 0;
		$totalRatings = 0;
		foreach ($product->reviews as $review) {
			$totalProducts++;
			$totalRatings += $review->rating;
		}

		// check if not in use by admin
		if (json_decode(file_get_contents($changes))->open === false)
			throw new inUseException("File is in use by administrator.");	

		// rewrite products file data	
		unlink($filePath); 
		file_put_contents($filePath, json_encode($products));
		header("HTTP/1.1 200 Success");

	} 
	catch (fileNotFoundException $e) {
		header("HTTP/1.1 500 Internal Server Error");
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
	catch (argumentMissingException $e) {
		header("HTTP/1.1 402 Argument Missing");
		echo $e->getMessage();
	} 
	catch (badArgumentException $e) {
		header("HTTP/1.1 402 Bad Argument");
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
// unexpected
else {
	header("HTTP/1.1 405 Method Not Allowed");
	echo $_SERVER['REQUEST_METHOD'] . " method is not allowed";
};


// check field length
function checkLength($str, $min, $max) {
	return (strlen($str) >= $min && strlen($str) <= $max);		
}

// check if date is valid
function validateDate($date, $format = 'Y-m-d')
{
	$d = DateTime::createFromFormat($format, $date);
	return $d && $d->format($format) == $date;
}
?>