<?php /* Session helper */

// update session
/**
 * @param null $expiryTimeSeconds
 */
function updateSession($expiryTimeSeconds = null)
{
    // check if expiry time was set if is more then 0
    if (!is_null($expiryTimeSeconds) && $expiryTimeSeconds > 0)
        // set session expiry duration
        $_SESSION['expiry'] = $expiryTimeSeconds;
    // if expiry time is less than 1 than set it to one week
    else if ($expiryTimeSeconds < 1) {
        // if the session[expiry] is already set, than no need to change
        if (!isset($_SESSION['expiry']))
            $_SESSION['expiry'] = 604800;
    }
    // update last activity time stamp
    $_SESSION['LAST_ACTIVITY'] = time();
}

// check if the session is active
function sessionActive()
{

    // todo: implement
    /*
	if (!isset($_SESSION['expiry']) || (isset($_SESSION['LAST_ACTIVITY']) && 
		(time() - $_SESSION['LAST_ACTIVITY'] > $_SESSION['expiry']))) {

		// Destroy session if not active
		session_unset();
		session_destroy();
		throw new sessionExpiredException("Session Has Expired");
	}
    */
}

?>