<?php /* Checks for file existance and then performs related action */
// includes
$root = $_SERVER['DOCUMENT_ROOT'] . '/angularWS/php/';

// classes
include_once $root . '/classes/Exceptions/exceptions.php';

// check for file existence
/**
 * @param $filePath
 * @throws fileNotFoundException
 */
function fileExists($filePath) {
	if ( !file_exists($filePath) )
		throw new fileNotFoundException("File " . $filePath ." was not found");
}
?>