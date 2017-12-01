<?php 
class Product
{
    // unique per product
	public $id = null;
	// defaults
	public $name = "Nameless product";
	public $description = "No description is available for this product.";
	public $imageUrl = "http://www.p-etalon.ru/global/images/prod/nophoto.png";
	public $quantity = 0;
	public $cost = 0;
	// commentaries from users 
	public $reviews = null;

	/* constructors */
	// default constructor
	function __construct() {
		if (self::$ids == null) {
			$ids = array(1, 2, 3);
		};
	}

	public static $ids = null;

	// argument constructor
	public static function with( $id, 
		$name = null, $description = null,
		$imageUrl = null, $quantity = null, 
		$cost = null, $reviews ) {
		// create new instance
		$instance = new self();
		// id container 
		if (self::$ids == null) {
			$ids = array(1, 2, 3);
		};
		// assign params
		$instance->id = $id;
		$instance->name = $name ? $name : "Nameless product";
		$instance->description = $description ? $description : "No description is available for this product.";
		$instance->imageUrl = $imageUrl ? $imageUrl : "http://www.p-etalon.ru/global/images/prod/nophoto.png";
		$instance->quantity = $quantity ? $quantity : 0;
		$instance->cost = $cost ? $cost : 0;
		$instance->reviews = $reviews;
		// return instance
		return $instance;
	}

    // destructor
	function __destruct() {}
}
?>
