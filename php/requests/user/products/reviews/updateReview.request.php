<?php /* Request to update existing review */

// main request
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
	
}
else {
	header("HTTP/1.1 405 Method Not Allowed");
	echo $_SERVER['REQUEST_METHOD'] . " method is not allowed";
}
 ?>