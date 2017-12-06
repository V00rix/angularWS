<?php /* Validation for allowed server method */
// includes
$root = $_SERVER['DOCUMENT_ROOT'] . '/angularWS/php/';
include_once $root . '/classes/Exceptions/exceptions.php';

function methodAllowed($method) {
	if ($_SERVER['REQUEST_METHOD'] !== $method)
		throw new methodNotAllowedException("Method '" . $_SERVER['REQUEST_METHOD'] ."' is not allowed.");
}

 ?>