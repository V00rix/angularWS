<?php /* Checks for permissions */
// includes
$root = $_SERVER['DOCUMENT_ROOT'] . '/angularWS/php/';

// classes
include_once $root . '/classes/Exceptions/exceptions.php';

// helpers
include_once $root . '/helpers/session.helper.php';

function isAllowed($value, $msg = "Forbidden.") {
	if (!isset($_SESSION[$value])) 
		throw new notAllowedException($msg);

	// check if session has not yet expired
	sessionActive();
}
?>