<?php
include_once("security.php");

require_once($_SERVER['DOCUMENT_ROOT'] . "/forum/config.php");
session_start();
$name = strip_tags($_REQUEST['names']);
$name = mysqli_real_escape_string($db,$name);

$password = strip_tags($_REQUEST['pwds']);
$password = mysqli_real_escape_string($db,$password);
$sql = "SELECT * FROM admins WHERE username = '" . $name . "' AND password = '" . $password . "';";
	
	$result = $db->query($sql);
	$numrows = $result->num_rows;
		
	if($numrows >= 1) {	
		$row = $result->fetch_assoc();
		
		//session_register("ADMIN");
		$_SESSION['ADMIN'] = true;
		$_SESSION['ADMIN'] = $row['username']; // lay ten  ??
		//$_SESSION['ADMINID'] = $row['id'];
		$_SESSION['USERID'] = $row['id'];
		
		echo 'true';
	}
	else {
		echo 'false';
			
		}

?>