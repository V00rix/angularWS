<?php
/* includes */
// classes
include './classes/product.class.php';
include './classes/user.class.php';
include './classes/review.class.php';
// helpers
include_once './helpers/ip.helper.php';
include_once './helpers/misc.helper.php';
// include_once './shared/shared.php';
$ip = get_client_ip();
printLine($ip);

// one product
// $prod = Product::with( 23, "Junk", "Simple description", "no image", 50000, 150, null );


// fake products array
$products = array();
for ($i = 1; $i < 51; ++$i) {	
	array_push($products, Product::with($i, null, null, null, null, null, null));
};

$host = '127.0.0.1';
$db   = 'products_db';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);

$stmt = $pdo->query('SELECT name FROM products');
while ($row = $stmt->fetch())
{
    echo $row['name'] . "\n";
};

printLine(Product::$ids);

printLine($products);
// then get from database
?>