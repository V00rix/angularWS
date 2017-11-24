<?php 
// Validate password
function validate($password) {
	if ($password === "password") 
		return true;
	else 
		return false;
}
?>