<?php 
	function printLine($data) {
		if (gettype($data) == "array") {
			$res = "<div><b>Array:</b> [ ";
			foreach ($data as &$val) {
				$res .= "{" . $val . "} ";
			}
			unset($val);
			$res .= "]</div><br/>";
			echo $res;
		}
		else 
			echo "<p>$data</p>";
	}
	
 ?>