<?php /* Session helper */

// update session
function updateSession($expiryTimeSeconds) {
	session_start();

	// set session expiry duration
	$_SESSION['expiry'] = $expiryTimeSeconds;

	// update last activity time stamp	
	$_SESSION['LAST_ACTIVITY'] = time();
}

// check if the session is actove
function sessionActive() {
	if (!isset($_SESSION['expiry']) || (isset($_SESSION['LAST_ACTIVITY']) && 
		(time() - $_SESSION['LAST_ACTIVITY'] > $_SESSION['expiry']))) {

		// Destroy session if not active
		session_unset();
		session_destroy();
		throw new sessionExpiredException("Session Has Expired");
	}
}
?>