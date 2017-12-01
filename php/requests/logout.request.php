<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET')
{
	try {
		session_start();
		session_unset();
		session_destroy();
		header('Location: '. $_SERVER['HTTP_REFERER']);
	} catch (Exception $e) {	
		header("HTTP/1.1 500 Internal Server Error");
		echo $e->getMessage();
	}
}
else {
	header("HTTP/1.1 405 Method Not Allowed");
	echo $_SERVER['REQUEST_METHOD'] . " method is not allowed";
}
?>