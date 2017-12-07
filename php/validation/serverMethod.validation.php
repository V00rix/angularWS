<?php /* Validation for allowed server method */
// includes
$root = $_SERVER['DOCUMENT_ROOT'] . '/angularWS/php/';

// classes
include_once $root . '/classes/Exceptions/exceptions.php';

// checks if method is allowed
// throws a methodNotAllowedException if not
function methodAllowed($method) {
	if ($_SERVER['REQUEST_METHOD'] !== $method)
		throw new methodNotAllowedException("Method '" . $_SERVER['REQUEST_METHOD'] ."' is not allowed.");
}

 ?>