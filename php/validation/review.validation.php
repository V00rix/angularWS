<?php /* Review related validations */
// check field length
function checkLength($str, $min, $max) {
	return (strlen($str) >= $min && strlen($str) <= $max);		
}

// check if date is valid
function validateDate($date, $format = 'Y-m-d')
{
	$d = DateTime::createFromFormat($format, $date);
	return $d && $d->format($format) == $date;
}
?>