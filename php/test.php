<?php
/* includes */
// classes
include './classes/product.class.php';
include './classes/user.class.php';
include './classes/review.class.php';
// helpers
include_once './helpers/ip.helper.php';
include_once './helpers/misc.helper.php';
include_once './helpers/database.helper.php';
// include_once './shared/shared.php';
$ip = get_client_ip();
printLine($ip);

// $getProducts();
// printLine ($_POST);
// echo json_encode($getProducts());

// fake products array
// $products = array();
// for ($i = 1; $i < 51; ++$i) {	
// 	array_push($products, Product::with($i, null, null, null, null, null, null));
// };

// printLine(Product::$ids);

// printLine($getProducts());
// then get from database
?>