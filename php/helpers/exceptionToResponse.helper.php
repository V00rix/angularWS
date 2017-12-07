<?php /* Transform exception to http responses */
/* includes */
$root = $_SERVER['DOCUMENT_ROOT'] . '/angularWS/php/';
// excxpetions
include_once $root . 'classes/Exceptions/exceptions.php';

// Transform errors to http responses
function transformException($e) {
	try {
		throw $e;
	} 
	catch (baseException $e) {	
		$e->header();
		echo $e->getMessage();
	}
	catch (Exception $e) {	
		header("HTTP/1.1 500 Internal Server Error");
		echo $e->getMessage();
	}
}
?>