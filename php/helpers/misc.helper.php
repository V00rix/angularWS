<?php 
	function printLine($data) {
		if (gettype($data) == "array") {
			// $res = "<div><b>Array:</b> [<br />";
			// foreach ($data as $key => $val) {
			// 	$res .= "&nbsp;&nbsp;&nbsp;" . $key . ": {" . $val . "}<br />";
			// }
			// unset($val);
			// $res .= "]</div><br />";
			// echo $res;
			echo "<div><b>Array:</b> [<br />";
				foreach ($data as $key => $val) {
					echo "&nbsp;&nbsp;&nbsp;" . $key . ": {";
					printLine($val);
					echo "}<br />";
					// $res .= "&nbsp;&nbsp;&nbsp;" . $key . ": {" . $val . "}<br />";
				}
			echo "]</div><br />";
		}
		else 
			echo "<p>$data</p>";
	}
	
 ?>