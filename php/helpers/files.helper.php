<?php /* Working with files functionallity */
/* includes */
$root = $_SERVER['DOCUMENT_ROOT'] . '/angularWS/php/';

// validations
include_once $root . 'validation/fileExists.validation.php';

// change editing availability 
function setEditStatus($status, $filePath = "../../../../app_data/changes.json") {
	// check file
	fileExists($filePath);

	// read file 
	$changesData = json_decode(file_get_contents($filePath));
	
	// set edit status as open
	$changesData->open = $status === 'open' ? true : false;	
	
	// update file contents
	unlink($filePath);
	file_put_contents($filePath, json_encode($changesData));
}

// get editing availability
function canEdit($filePath = "../../../../app_data/changes.json") {
	// check file
	fileExists($filePath);

	// read file 
	$changesData = json_decode(file_get_contents($filePath));
	
	// set edit status as open
	if (!$changesData->open)		
		throw new inUseException("File is in use by administrator.");	
}

/* Reading/Writing/Updating file contents */
// Read contents from file as json 
function getFileContents($filePath) {
	// check file
	fileExists($filePath);

	// read and decode 
	return json_decode(file_get_contents($filePath));
}

// Read contents from file as plain text
function getTextFileContents($filePath) {
	// check file
	fileExists($filePath);

	// read and decode 
	return file_get_contents($filePath);
}

// rewrite file contents 
function fileUpdateContents($filePath, $data) {
	// clear file contents if it exists
	if ( file_exists($filePath) )
		unlink($filePath); 
	
	// TODO: directories creation

	// write new content
	file_put_contents($filePath, json_encode($data));
}

/* Read and echo content */
function echoJsonContent($filePath) {
	// check file
	fileExists($filePath);

	// set headers
	header("HTTP/1.1 200 Success");

	// Read and output 
	echo file_get_contents($filePath);
}
?>