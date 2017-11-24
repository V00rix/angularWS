<!-- <!doctype html>
<html ng-app="app">
<head>      
	<title>Admin Page</title>          
	<meta charset="utf-8" />
	<meta name="description" content="My angular WebShop">
	<meta name="keywords" content="WebShop">
	<meta name="author" content="Vladyslav Yazykov">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<body>
		<form action="sadlogin.php" method="post"></form>
		<label for="password">Password</label>
		<input name="password" id="password" type="password">
		<button type="submit">Submit</button>
	</body>
</head>
</html> -->
<?php
    session_start();

    $echoedShout = "";

    if(count($_POST) > 0) {
        $_SESSION['shout'] = $_POST['shout'];
        header("HTTP/1.1 303 See Other");
        header("location: index.php");
        die();
    }
    else if (isset($_SESSION['shout'])){
        $echoedShout = $_SESSION['shout'];

        
		echo file_get_contents("./app/app.template.html");

        /*
            Put database-affecting code here.
        */

        session_unset();
        session_destroy();
    }

    echo '<!DOCTYPE html>
<html>
<head><title>PRG Pattern Demonstration</title>

<body>
    <p>' . $echoedShout . '</p>
    <form action="index.php" method="POST">
        <input type="text" name="shout" value="" />
    </form>
</body>
</html>';
?>