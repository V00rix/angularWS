<?php /* Product related functions */
/* includes */
$root = $_SERVER['DOCUMENT_ROOT'] . '/angularWS/php/';

// classes
include_once $root . 'classes/Exceptions/exceptions.php';
include_once $root . 'classes/Product/CProduct.class.php';

// validation
include_once $root . 'validation/common.validation.php';
include_once $root . 'validation/product.validation.php';

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
	$prod = findProduct($productsList, $product->id);

	// check quantity range
	inRange($product->quantity, 0,  $prod->quantity, "Product quantity");

	$prod->quantity -= $product->quantity;	

	// add product to user's history
	$toHistory = CProduct::from($prod);
	$toHistory->reviews = null;
	$toHistory->quantity = $product->quantity;

	array_push($user->history, $toHistory);
}

// find first product with such id
function findProduct($productList, $id) {
	foreach ($productList as $product) {
		if ($product->id === $id)
			return $product;
	}
	throw new badArgumentException("Product with such id doesn't exist");
}

// add review to a product
function addReview($productId, $products, $review) {
	// check product id and try to find product
	if (!isset($productId))
		throw new argumentMissingException("Missing Product Id");
	$product = findProduct($products, $productId);

	// validate review
	validateReview($review);

	// push last review						
	array_push($product->reviews, $review);

	/* Update product's rating */
	// product.rating = (product.rating * product.reviews.count + review.rate) / (product.reviews.cout + 1)
	// great, but works only with properly calculated rating before
	// so we use this
	$totalProducts = 0;
	$totalRatings = 0;
	foreach ($product->reviews as $rev) {
		$totalProducts++;
		$totalRatings += $rev->rating;
	}
}
?>