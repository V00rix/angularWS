<?php 
include_once '../classes/exceptions.php';

function searchUsername($userList, $username) {
	foreach ($userList as $user) {
		if ($user->username === $username)
			return $user;
	}
	throw new badArgumentException("Username not found");
}

function searchProduct($productList, $id) {
	foreach ($productList as $product) {
		if ($product->id === $id)
			return $product;
	}
	throw new badArgumentException("Product with such id doesn't exist");
}

function inRange($intValue, $min, $max, $valName = "Value") {
	if ($intValue < $min)
		throw new badArgumentException($valName . " is less than " . $min);
	if ($intValue > $max)
		throw new badArgumentException($valName . " is higher than " . $max);
}

?>