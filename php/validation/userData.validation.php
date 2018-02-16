<?php /* Validates data */
// includes
$root = $_SERVER['DOCUMENT_ROOT'] . '/angularWS/php/';

// classes
include_once $root . '/classes/Exceptions/exceptions.php';

// validates all users in the list
/**
 * @param $users
 * @param bool $strictMode
 * @throws argumentMissingException
 * @throws badArgumentException
 * @throws badEmailException
 * @throws badPasswordException
 * @throws badUsernameException
 */
function validateUserList($users, $strictMode = true) {
	if (!is_array($users)) 
		throw new badArgumentException("Input is not a users array");

	foreach ($users as $user) 
		validUserFields($user, null, $strictMode);
		// TODO: check if registration is possible (validate duplicate emails, usernames etc.)
}

// validate userlist with from admin's request
/**
 * @param $newUsers
 * @param $oldUsers
 * @throws argumentMissingException
 * @throws badArgumentException
 * @throws badEmailException
 * @throws badPasswordException
 * @throws badUsernameException
 */
function validateEncryptedUserList($newUsers, $oldUsers) {	
	foreach ($newUsers as $user) {
		validUsername($user->username, null);
		validEmail($user->email, null);

		// if admin changed password, then it won't be empty
		if (isset($user->password) && $user->password !== "") {
			// thus we need to validate it
			validPassword($user->password, null);
			// and encrypt
			$user->password = password_hash($user->password, PASSWORD_BCRYPT);
		}
		// if the password is empty, then no changes have been made
		else  {
			// se we find the first user with same (should be unique)
			foreach ($oldUsers as $value) {
				if ($value->username === $user->username) {
					// and copy hashed password
					$user->password = $value->password;
					break;
				}
			}
		} 
	}
}

// validate all user fields
/**
 * @param $user
 * @param null $userList
 * @param bool $strictMode
 * @return stdClass
 * @throws argumentMissingException
 * @throws badArgumentException
 * @throws badEmailException
 * @throws badPasswordException
 * @throws badUsernameException
 */
function validUserFields($user, $userList = null, $strictMode = true) {	
	if (!isset($user)) 
		throw new argumentMissingException("user");

	// break on errors
	if ($strictMode) {
		validUsername($user->username, $userList);
		validEmail($user->email, $userList);
		validPassword($user->password, $userList);
	}
	else {
		// define result
		$result = new stdClass();

		// Check format 
		$result->usernameFound = isset($user->username) && validUsername($user->username, $userList);
		$result->emailFound = isset($user->email) && validEmail($user->email, $userList);
		$result->passwordFound = isset($user->password) && validPassword($user->password, $userList);

		return $result;
	}
}

// checks if username is valid
/**
 * @param $username
 * @param null $userList
 * @return bool
 * @throws argumentMissingException
 * @throws badArgumentException
 * @throws badUsernameException
 */
function validUsername($username, $userList = null) {
	// check if is set
	if (!isset($username))
		throw new argumentMissingException("username");

	// check pattern
	if (!preg_match("/^[A-z0-9]{4,12}$/", $username))
		throw new badUsernameException("Username contains forbidden symbols or the length is above maximum!");

	// if user list is provided, then check uniqueness 
	if (!is_null($userList)) { 
		if (!is_array($userList))
			throw new badArgumentException("Userlist is not a valid Array.");
		else 
			return in_array($username, array_map(function($user) { return $user->username; }, $userList));
	}
	return false;
}

// checks if email is valid
/**
 * @param $email
 * @param null $userList
 * @return bool
 * @throws argumentMissingException
 * @throws badArgumentException
 * @throws badEmailException
 */
function validEmail($email, $userList = null) {
	// check if is set
	if (!isset($email))
		throw new argumentMissingException("email");

	// check pattern
	if (!preg_match("/^[^ ]+@[^ ]+\.[^ ]+$/", $email))
		throw new badEmailException("Invalid email format!");

	// if user list is provided, then check uniqueness 
	if (!is_null($userList)) { 
		if (!is_array($userList))
			throw new badArgumentException("Userlist is not a valid Array.");
		else 
			return in_array($email, array_map(function($user) { return $user->email; }, $userList));
	}
	return false;
}

// checks if password is valid
/**
 * @param $password
 * @param null $userList
 * @return bool
 * @throws argumentMissingException
 * @throws badArgumentException
 * @throws badPasswordException
 */
function validPassword($password, $userList = null) {
	// check if is set
	if (!isset($password)) 
		throw new argumentMissingException("password");

	// check pattern
	if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/", $password))
		throw new badPasswordException("Password should be at least 8 characters long, contain at least one uppercase letter, one lowercase letter and one number.");

	// if user list is provided, then check uniqueness 
	if (!is_null($userList)) { 
		if (!is_array($userList))
			throw new badArgumentException("Userlist is not a valid Array.");
		else {
			foreach ($userList as $user) {
				if (password_verify($password, $user->password)) {
					return true;
				}
			}
		}
	}
	return false;
}
?>