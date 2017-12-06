<?php /* Redirect to other page */
function redirectTo($path) {
	header("HTTP/1.1 303 See Other");
	header("location: " . $path);
}

function refreshRedirectTo($path) {
	header('Refresh: '. $path);
}

function redirectBack() {
	if (isset($_SERVER['HTTP_REFERER']))
		redirectTo($_SERVER['HTTP_REFERER']);
}

function refreshRedirectBack() {
	if (isset($_SERVER['HTTP_REFERER']))
		refreshRedirectTo($_SERVER['HTTP_REFERER']);
}
?>