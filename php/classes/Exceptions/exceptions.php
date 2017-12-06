<?php 
// base exception for this application
class baseException extends Exception {
	public function header() {
		header("HTTP/1.1 500 Unexpected Error");
	}
}

// when http method is not supported
class methodNotAllowedException extends baseException {
	public function header() {
		header("HTTP/1.1 405 Method Not Allowed");
	}	
}

//  when session is no longer active
class sessionExpiredException extends baseException {
	public function header() {
		header("HTTP/1.1 419 Authentication Timeout");
	}
}

// when not enough permissions
class notAllowedException extends baseException {
	public function header() {
		header("HTTP/1.1 401 Not Allowed");
	}
}

// when arguments is not valid
class badArgumentException extends baseException {
	public function header() {
		header("HTTP/1.1 400 Bad Request Parameters");
	}
}

// when expected to recieve arguments (e.g. as data from Http Request)
class argumentMissingException extends badArgumentException {
	public function header() {
		header("HTTP/1.1 400 Request Parameters Missing");
	}
}

// login exceptions
class loginFailedException extends baseException {}
class badUsernameException extends loginFailedException {
	public function header() {
		header("HTTP/1.1 490 Bad Username");
	}
}
class badPasswordException extends loginFailedException {
	public function header() {
		header("HTTP/1.1 491 Bad Password");
	}
}
class badEmailException extends loginFailedException {
	public function header() {
		header("HTTP/1.1 492 Bad Email");
	}
}

// file-related exceptions
class fileException extends baseException {}
class fileNotFoundException extends fileException {
	public function header() {
		header("HTTP/1.1 502 File Not Found");
	}
}
class inUseException extends fileException {
	public function header() {
		header("HTTP/1.1 503 In Use");
	}
}

?>