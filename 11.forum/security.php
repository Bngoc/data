<?php
foreach ($_GET as $check_get) {
	if (preg_match("[^a-zA-Z0-9_\.@$]", $check_get)) exit();
}
//include ('config.php');
if ( !in_array($_SERVER['REMOTE_ADDR'], $list_ip) ) {
	echo "Khong co quyen truy cap!";
	exit();
}
?>