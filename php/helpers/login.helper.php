<?php 

/* includes */
$root = $_SERVER['DOCUMENT_ROOT'] . '/angularWS/php/';
// excxpetions
include_once $root . 'classes/Exceptions/exceptions.php';
// helpers
include_once $root . 'helpers/session.helper.php';
include_once $root . 'helpers/accounts.helper.php';

/** 
* Login function
* @param {Array} $usersList Array of users to search in
* @param {string} $username Username to be searched for
* @param {string} $password Corrresponding password
* @param {string} $permissionKey Gets set as $_SESSION[$permissionKey] to then identify permissions for this session
* @param {number} $expiryTimeSeconds Session expiry duration, after which it gets reset
* @param {function(loginFailedException $e):any} $exceptionFunction Function, which gets executed if username|password validation failed
* @return {void}
*/
function login($usersList, $username, $password, $permissionKey, $expiryTimeSeconds, $successFunction, $exceptionFunction = null) {
	try {
		// validate credentials
		searchUserPassword($usersList, $username, $password);
		// update session
		updateSession($expiryTimeSeconds);
		// set permissions on current session
		$_SESSION[$permissionKey] = $username;
		// call success
		$successFunction();
	} catch (loginFailedException $e) {
		if (is_null($exceptionFunction))
			throw $e;
		else
			$exceptionFunction($e);
	}
}
?>