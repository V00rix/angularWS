<?php /* Checks for file existance and then performs related action */
// includes
$root = $_SERVER['DOCUMENT_ROOT'] . '/angularWS/php/';
include_once $root . '/classes/Exceptions/exceptions.php';

function fileExists($filePath) {
	if ( !file_exists($filePath) )
		throw new fileNotFoundException("File " . $filePath ." was not found");
}
?>