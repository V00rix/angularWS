<?php 
// includes
 // include 'C:/Users/User/source/webP/angularWS/php/classes/exceptions.php';
if ( file_exists('../php/classes/exceptions.php')) {
	include '../php/classes/exceptions.php';
}
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
function login($usersList, $username, $password, $permissionKey, $expiryTimeSeconds, $successFunction, $exceptionFunction) {
	try {
		// validate credentials
		searchUserPassword($usersList, $username, $password);
		// permissions on current session
		$_SESSION[$permissionKey] = true;
		$successFunction();
	} catch (loginFailedException $e) {
		$exceptionFunction($e);
	}
	finally {
		// Destroy session if last activity was more then 5 minutes ago
		if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $expiryTimeSeconds)) {
			session_unset();
			session_destroy();
		}
		// update last activity time stamp	
		$_SESSION['LAST_ACTIVITY'] = time(); 
	}
}

/**
* Checks if email is free
* @param {Array} Array of users to search in
* @param {string} Email to be searched for
*/
function emailFree($dataList, $email) {
	foreach ($dataList as $user) {
		if ($email === $user->email)
			return false;
	}
	return true;
}

function searchUserPassword($dataList, $username, $password) {
	if (!isset($username)) 
		throw new badUsernameException("No username recieved");
	foreach ($dataList as $user) {
		if ($username === $user->username) {
			if (!isset($password))
				throw new badPasswordException("No password recieved");
			if ($password === $user->password)
				return true;
			else 
				throw new badPasswordException("Wrong password");
		}
		else 
			throw new badUsernameException("Username not found");
	}
}

function registrationPossible($dataList, $username, $email) {
	foreach ($dataList as $user) {
		if ($username === $user->username) 
			throw new badUsernameException("Username is already taken");
		if ($email === $user->email) 
			throw new badEmailException("Email is already taken");
	}
}
?>