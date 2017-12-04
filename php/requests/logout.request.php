<?php
$changes = "../../app_data/changes.json";
include_once '../../php/classes/exceptions.php';

if ( !file_exists("../app_data") )
	mkdir("../app_data");

if ($_SERVER['REQUEST_METHOD'] === 'GET')
{
	try {
		session_start();

		// preserve current cart 
		$cart = $_SESSION['temporaryCart'];

		if (isset($_SESSION['admin'])) {			
			// check files
			if ( !file_exists($changes) )
				throw new fileNotFoundException("No status file found");
			$changesData = json_decode(file_get_contents($changes));
			// set as open
			$changesData->open = true;	

			unlink($changes);
			file_put_contents($changes, json_encode($changesData));
		}

		session_unset();
		session_destroy();

		session_start();
		$_SESSION['temporaryCart'] = $cart;

		if (isset($_GET['refresh']))
			header('Refresh: '. $_SERVER['HTTP_REFERER']);
		else 
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