<?php 
function inRange($intValue, $min, $max, $valName = "Value") {
	if ($intValue < $min)
		throw new badArgumentException($valName . " is less than " . $min);
	if ($intValue > $max)
		throw new badArgumentException($valName . " is higher than " . $max);
}
?>