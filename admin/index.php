<?php
	// includes
	// include '../php/helpers/misc.helper.php';

    session_start();

    if(count($_POST) > 0) {
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['password'] = $_POST['password'];
        header("HTTP/1.1 303 See Other");
        header("location: index.php");
        die();
    }
    else if (isset($_SESSION['username'])){
        $adminsList = json_decode(file_get_contents("../app_data/admins.json"));
        foreach ($adminsList as $value) {
        	echo $value->username . " " . $value->password . "<br/>";
        }
        try {
        	echo json_decode(file_get_contents("../app_data/admins.json"))[$_SESSION['username']];
        } catch (Exception $e) {
        	echo $e;
        }
		// echo file_get_contents("./app/app.template.html");

        /*
            Put database-affecting code here.
        */

        session_unset();
        session_destroy();
    }
	else 
	    echo file_get_contents("./login.template.html");
?>