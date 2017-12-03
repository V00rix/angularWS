<?php
$changes = "../../app_data/changes.json";
include_once '../../php/classes/exceptions.php';

if ( !file_exists("../app_data") )
	mkdir("../app_data");

if ($_SERVER['REQUEST_METHOD'] === 'GET')
{
	try {
		session_start();
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