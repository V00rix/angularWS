<?php /* Custom exceptions */ 

// base exception for this application

/**
 * Class baseException
 */
class baseException extends Exception {
	public function header() {
		header("HTTP/1.1 500 Unexpected Error");
	}
}

// when http method is not supported

/**
 * Class methodNotAllowedException
 */
class methodNotAllowedException extends baseException {
	public function header() {
		header("HTTP/1.1 405 Method Not Allowed");
	}	
}

//  when session is no longer active

/**
 * Class sessionExpiredException
 */
class sessionExpiredException extends baseException {
	public function header() {
		header("HTTP/1.1 419 Authentication Timeout");
	}
}

// when not enough permissions

/**
 * Class notAllowedException
 */
class notAllowedException extends baseException {
	public function header() {
		header("HTTP/1.1 401 Not Allowed");
	}
}

// when arguments is not valid

/**
 * Class badArgumentException
 */
class badArgumentException extends baseException {
	public function header() {
		header("HTTP/1.1 400 Bad Request Parameters");
	}
}

// when expected to receive arguments (e.g. as data from Http Request)

/**
 * Class argumentMissingException
 */
class argumentMissingException extends badArgumentException {
	public function header() {
		header("HTTP/1.1 400 Request Parameters Missing");
	}
}

/* base for login exceptions */

/**
 * Class loginFailedException
 */
class loginFailedException extends baseException {}
// based on situation this might refer to either not found username, or when one is already taken
// or when username is not set, or doesn't pass validation check 

/**
 * Class badUsernameException
 */
class badUsernameException extends loginFailedException {
	public function header() {
		header("HTTP/1.1 490 Bad Username");
	}
}
// this should normally refer to not found password for selected username 
// or when password is not set, or doesn't pass validation check 

/**
 * Class badPasswordException
 */
class badPasswordException extends loginFailedException {
	public function header() {
		header("HTTP/1.1 491 Bad Password");
	}
}
// based on situation this might refer to either not found email, or when one is already taken
// or when email is not set, or doesn't pass validation check

/**
 * Class badEmailException
 */
class badEmailException extends loginFailedException {
	public function header() {
		header("HTTP/1.1 492 Bad Email");
	}
}

/* base for file-related exceptions */

/**
 * Class fileException
 */
class fileException extends baseException {}
// file doesn't exist at location

/**
 * Class fileNotFoundException
 */
class fileNotFoundException extends fileException {
	public function header() {
		header("HTTP/1.1 502 File Not Found");
	}
}
// file is in use by admin, thus no cahnges can be made

/**
 * Class inUseException
 */
class inUseException extends fileException {
	public function header() {
		header("HTTP/1.1 503 In Use");
	}
}
?>