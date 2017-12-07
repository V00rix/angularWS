<?php /* Common validation functions */

// check if value is in range
function inRange($intValue, $min, $max, $valName = "Value") {
	if ($intValue < $min)
		throw new badArgumentException($valName . " is less than " . $min);
	if ($intValue > $max)
		throw new badArgumentException($valName . " is higher than " . $max);
}

// check string length range
function checkStringLength($str, $min, $max, $valName = "String Length") {
	inRange(strlen($str), $min, $max, $valName);
}

// check if date is valid
function validateDate($date, $format = 'Y-m-d')
{
	$d = DateTime::createFromFormat($format, $date);
	return $d && $d->format($format) == $date;
}
?>