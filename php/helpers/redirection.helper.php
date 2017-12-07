<?php /* Redirect to other page */

// Normal redirect 
function redirectTo($path) {
	header("HTTP/1.1 303 See Other");
	header("location: " . $path);
}

// Refresh instead of redirect (for correct angularjs)
function refreshRedirectTo($path) {
	header('Refresh: '. $path);
}

// Alias for redirecting back
function redirectBack() {
	if (isset($_SERVER['HTTP_REFERER']))
		redirectTo($_SERVER['HTTP_REFERER']);
}

// Aliasa for refreshing back
function refreshRedirectBack() {
	if (isset($_SERVER['HTTP_REFERER']))
		refreshRedirectTo($_SERVER['HTTP_REFERER']);
}
?>