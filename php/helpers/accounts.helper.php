<?php /* Accounts related functions */
/* includes */
$root = $_SERVER['DOCUMENT_ROOT'] . '/angularWS/php/';

// classes
include_once $root . 'classes/Exceptions/exceptions.php';
include_once $root . 'classes/Product/CProduct.class.php';

/* functions */

function deleteUser($dataList, $username) {
	$i = 0;
	foreach ($dataList as $key => $user) {
		$i++;
		if ($username === $user->username) {
			array_splice($dataList, $key, 1);
			return $dataList;
		}
	}
	return $dataList;
	throw new badUsernameException("Username Not Found");
}

function searchUsername($userList, $username) {
	foreach ($userList as $user) {
		if ($user->username === $username)
			return $user;
	}
	throw new badArgumentException("Username not found");
}

function searchUserPassword($dataList, $username, $password) {
	if (!isset($username)) 
		throw new badUsernameException("No username recieved");
	foreach ($dataList as $user) {
		if ($username === $user->username) {
			if (!isset($password))
				throw new badPasswordException("No password recieved");
			if (password_verify($password, $user->password))
				return true;
			else 
				throw new badPasswordException("Wrong password");
		}
	}
	throw new badUsernameException("Username not found");
}
?>