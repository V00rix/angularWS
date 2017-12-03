<?php 
	// base exception for this application
	class baseException extends Exception {}
	//  when session is no longer active
	class sessionExpiredException extends baseException {}
	// when not enough permissions
	class notAllowedException extends baseException {}
	// when arguments is not valid
	class badArgumentException extends baseException {}
	// when expected to recieve arguments (e.g. as data from Http Request)
	class argumentMissingException extends badArgumentException {}
	// login exceptions
	class loginFailedException extends baseException {}
	class badUsernameException extends loginFailedException {}
	class badPasswordException extends loginFailedException {}
	class badEmailException extends loginFailedException {}
	// file-related exceptions
	class fileNotFoundException extends baseException {}
	class inUseException extends baseException {}
 ?>