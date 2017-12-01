<?php 
	// base exception for this application
	class baseException extends Exception {}
	// when expected to recieve arguments (e.g. as data from Http Request)
	class argumentMissingException extends baseException {}
	// login exceptions
	class loginFailedException extends baseException {}
	class badUsernameException extends loginFailedException {}
	class badPasswordException extends loginFailedException {}
	class badEmailException extends loginFailedException {}
	// file-related exceptions
	class fileNotFoundException extends baseException {}
 ?>