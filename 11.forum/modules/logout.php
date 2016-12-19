<?php
session_start();
if (isset($_SESSION['USERADMIN'])) {
	unset($_SESSION["USERADMIN"]);
	session_destroy();
}

if (isset($_SESSION['USERNAME'])) {
	unset($_SESSION["USERNAME"]);
	session_destroy();
}

require("../config.php");

header("Location: " . $config_basedir);

?>
