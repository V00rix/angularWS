<?php

/**
 * Class CProduct
 */
class CProduct
{
    // unique per product
	public $id = null;
	// defaults
	public $name = "Nameless product";
	public $description = "No description is available for this product.";
	public $imageUrl = "http://www.p-etalon.ru/global/images/prod/nophoto.png";
	public $quantity = 1;
	public $cost = 150;
	// commentaries from users 
	public $reviews = null;

	/* constructors */
	// empty constructor
	function __construct() {
	}

	// argument constructor

    /**
     * @param $id
     * @param null $name
     * @param null $description
     * @param null $imageUrl
     * @param null $quantity
     * @param null $cost
     * @param $reviews
     * @return CProduct
     */
    public static function with($id,
                                $name = null, $description = null,
                                $imageUrl = null, $quantity = null,
                                $cost = null, $reviews ) {

		// create new instance
		$instance = new self();

		// assign params
		$instance->id = $id;
		$instance->name = $name ? $name : "Nameless product";
		$instance->description = $description ? $description : "No description is available for this product.";
		$instance->imageUrl = $imageUrl ? $imageUrl : "http://www.p-etalon.ru/global/images/prod/nophoto.png";
		$instance->quantity = $quantity ? $quantity : 1;
		$instance->cost = $cost ? $cost : 150;
		$instance->reviews = $reviews;
		// return instance
		return $instance;
	}

	// copy constructor

    /**
     * @param $another
     * @return CProduct
     */
    public static function from($another ) {
		$instance = new self();
		$instance->id = $another->id;
		$instance->name = $another->name ? $another->name : "Nameless product";
		$instance->description = $another->description ? $another->description : "No description is available for this product.";
		$instance->imageUrl = $another->imageUrl ? $another->imageUrl : "http://www.p-etalon.ru/global/images/prod/nophoto.png";
		$instance->quantity = $another->quantity ? $another->quantity : 1;
		$instance->cost = $another->cost ? $another->cost : 150;
		$instance->reviews = $another->reviews;
		return $instance;
	}

    // destructor
	function __destruct() {}
}
?>
