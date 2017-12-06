<?php /* Product related functions */
/* includes */
$root = $_SERVER['DOCUMENT_ROOT'] . '/angularWS/php/';

// classes
include_once $root . 'classes/Exceptions/exceptions.php';
include_once $root . 'classes/Product/CProduct.class.php';

// validation
include_once $root . 'validation/common.validation.php';

/* Functions */
// buy product
function buyProduct($product, $productsList, $user) {
	// check product id
	if (!isset($product->id))
		throw new badArgumentException("Product id is not set");

	// check quantity
	if (!isset($product->quantity))
		throw new badArgumentException("Quantity is not set");
	
	// find related product
	$prod = searchProduct($productsList, $product->id);

	var_dump($prod);

	// check quantity range
	inRange($product->quantity, 0,  $prod->quantity, "Product quantity");

	$prod->quantity -= $product->quantity;	

	$toHistory =  CProduct::from($prod);
	$toHistory->reviews = null;
	$toHistory->quantity = $product->quantity;

	array_push($user->history, $toHistory);
}

// find first product with such id
function searchProduct($productList, $id) {
	foreach ($productList as $product) {
		if ($product->id === $id)
			return $product;
	}
	throw new badArgumentException("Product with such id doesn't exist");
}
?>