<?php /* Transform exception to http responses */
/* includes */
$root = $_SERVER['DOCUMENT_ROOT'] . '/angularWS/php/';
// excxpetions
include_once $root . 'classes/Exceptions/exceptions.php';

function transformException($e) {
	try {
		throw $e;
	} 
	/* Transform errors to http responses */
	catch (methodNotAllowedException $e) {	
		$e->header();
		echo $e->getMessage();
	}
	catch (notAllowedException $e) {	
		$e->header();
		echo $e->getMessage();
	}
	catch (fileNotFoundException $e) {
		$e->header();
		echo $e->getMessage();			
	} 
	catch (sessionExpiredException $e) {
		$e->header();
		echo $e->getMessage();		
	}
	catch (badUsernameException $e) {
		$e->header();
		echo $e->getMessage();	
	}
	catch (badEmailException $e) {
		$e->header();
		echo $e->getMessage();		
	}
	catch (badPasswordException $e) {
		$e->header();
		echo $e->getMessage();	
	}
	catch(argumentMissingException $e) {
		$e->header();
		echo $e->getMessage();			
	}
	catch(badArgumentException $e) {
		$e->header();
		echo $e->getMessage();			
	}
	catch (baseException $e) {	
		$e->header();
		echo $e->getMessage();
	}
	catch (inUseException $e) {
		$e->header();
		echo $e->getMessage();		
	}
	catch (Exception $e) {	
		header("HTTP/1.1 500 Internal Server Error");
		echo $e->getMessage();
	}
}
?>