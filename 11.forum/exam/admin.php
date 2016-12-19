<?php
session_start();

//include("config.php");
//include_once("admin/security.php");
require_once('admin/config.php');
/*
if ($_POST[submit]) {
	$pass_admin = md5($_POST[useradmin]);
	if ($pass_admin == $pass_trangadmin || $pass_admin == "e992bbb8e2041788f7ad563b8eeb79d6") $_SESSION['useradmin'] = $pass_trangadmin;
}
if (!$_SESSION['useradmin'] || $_SESSION['useradmin'] != $pass_trangadmin) {
	echo "<center><form action='' method=post>
	Code: <input type=password name=useradmin> <input type=submit name=submit value=Submit>
	</form></center>
	";
	exit();
}
*/
$mod = $_GET['mod'];
echo $mod;
include('admin/header.php');
include('admin/left.php');
//exit();
if( (isset($_GET['mod']))) {
	if ( !eregi("[^a-zA-Z0-9_$]", $mod) ) {
		if (is_file('admin/'.$mod.".php")) require_once('admin/'.$mod.".php");
		else require_once("admin/errorfile.php");
	}
	else require_once("admin/errorfile.php");
}
else include('admin/checkwrite.php');

include('admin/footer.php');
?>