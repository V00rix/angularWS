<?php /* Checks for permissions */
// includes
$root = $_SERVER['DOCUMENT_ROOT'] . '/angularWS/php/';

// classes
include_once $root . '/classes/Exceptions/exceptions.php';

// helpers
include_once $root . '/helpers/session.helper.php';

// checks if someone has permissions to do anything
// throws an error if not
// updates session afterwards
/**
 * @param $value
 * @param string $msg
 * @throws notAllowedException
 * @throws sessionExpiredException
 */
function isAllowed($value, $msg = "Forbidden.") {
	if (!isset($_SESSION[$value])) 
		throw new notAllowedException($msg);

	// check if session has not yet expired
	sessionActive();

	// update session
	updateSession(); 
}
?>