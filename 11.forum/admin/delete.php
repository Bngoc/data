<?php

require_once('security.php');
include("../config.php");
//include('admin/MyLogPHP.class.php');
//$log = new MyLogPHP('./log/delete.log.csv');
session_start();
//$db = mysql_connect($dbhost, $dbuser, $dbpassword);
//mysql_select_db($dbdatabase, $db);

if(isset($_SESSION['ADMIN']) == FALSE) {
	header("Location: " . $config_basedir . "/admin.php?ref=del");
}
//if(isset($_SESSION['username']) == FALSE) {
	//header("Location: " . $config_basedir . "/admin/login.php?ref=del");
	//echo "sjsns";
//}

{
	
	if(isset($_GET['id']) == TRUE) {
	if(is_numeric($_GET['id']) == FALSE) {
		$error = 1;
	}
	if($error == 1) {
		header("Location: " . $config_basedir);
	}
	else {
		$validid = $_GET['id'];
	}
}
else {
	header("Location: " . $config_basedir);
}
switch($_GET['func']) {
	case "cat":
		$delsql = "DELETE FROM categories WHERE id = " . $validid . ";";
		$db->query($delsql);
		//$log -> debug($delsql,'DB');
		header("Location: " . $config_basedir);
	break;

	case "forum":
		$delsql = "DELETE FROM forums WHERE id = " . $validid . ";";
		$db->query($delsql);
		//$log -> debug($delsql,'DB');
		header("Location: " . $config_basedir);
	break;
//bqn
	case "thread":
		$delsql = "DELETE FROM topics WHERE id = " . $validid . ";";
		$db->query($delsql);
		//$log -> debug($delsql,'DB');
		header("Location: " . $config_basedir . "/modules/viewforum.php?id=" . $_GET['forum']);
	break;
	
	/*
	case "forumprive":
		$delsql = "DELETE FROM topics WHERE id = " . $validid . ";";
		$db->query($delsql);
		//$log -> debug($delsql,'DB');
		header("Location: " . $config_basedir . "/viewforum.php?id=" . $_GET['forum']);
	break;
	*/
	case "mes":
		$delsql = "DELETE FROM messages WHERE id = " . $validid . ";";
		$db->query($delsql);
		//$log -> debug($delsql,'DB');
		header("Location: " . $config_basedir . "/modules/viewmessages.php?id=" . $_GET['messages']);
	break;
	/*
	case "messaprive":
		$delsql = "DELETE FROM messages WHERE id = " . $validid . ";";
		$db->query($delsql);
		//$log -> debug($delsql,'DB');
		header("Location: " . $config_basedir . "/modules/viewmessages.php?id=" . $_GET['messages']);
	break;
	*/
	default:
		header("Location: " . $config_basedir);
	break;

}
}
?>