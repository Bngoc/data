<?php
;
	
if (isset($_SESSION['user'])) {
	unset($_SESSION["user"]);
	session_unset();
	session_destroy();
	
}
//require(SERVDIR . '/forum/config.php');

//header("Location: " . $config_basedir);

?>
