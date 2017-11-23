<?php 
// includes
// include '../helpers/ip.helper.php';

// $currentIp = get_client_ip();

// echo $currentIp;




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		// decode products from request
	$params = json_decode(file_get_contents('php://input'));
	// echo json_encode($params->username);
	// echo json_encode($params->login);
	
	// read users from file 
	if ( file_exists("../../app_data/users.json") ) {
		// $users = file_get_contents("../../app_data/users.json");
		$users = [
			"user1" => "123123"
		];

		if (array_key_exists($params->username, $users)) {
			if ($users[$params->username] == $params->password) {
				header("HTTP/1.1 240 Success");
				echo "Password is correct.";
			}
			else {				
				header("HTTP/1.1 400 Bad Request");
				echo "Incorrect password for user '" . $params->username . "'.";
			}
		}
		else {
			header("HTTP/1.1 400 Bad Request");
			echo 'Username not found';
		}
	}
	else {
		header("HTTP/1.1 500 Internal Server Error");
		echo 'No users file found';
	}
}
else {
	header("HTTP/1.1 405 Method Not Allowed");
	echo 'Method Not Allowed';
}
?>