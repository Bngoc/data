<?php
session_start();
require("../config.php");
//Include The Database Connection File 

if(isset($_POST['username'])){//If a username has been submitted 
	$Username = stripslashes($_POST['username']);
	$Username = mysqli_real_escape_string($db,$Username);
	//$username = mysql_real_escape_string($_POST['username']);//Some clean up :)

	$check_for_username = $db ->query("SELECT id FROM users WHERE username='$Username';");
//Query to check if username is available or not 
	$record =$check_for_username->num_rows;
	if($record >0 ){
		echo '1';//If there is a  record match in the Database - Not Available
	}
	else{
		echo '0';//No Record Found - Username is available 
	}
}

if(isset($_POST['email'])){//If a username has been submitted 
	$Email = stripslashes($_POST['email']);
	$Email = mysqli_real_escape_string($db,$Email);
	//$email = mysql_real_escape_string($_POST['email']);//Some clean up :)

	$check_for_username = $db ->query("SELECT id FROM users WHERE email='$Email';");
//Query to check if username is available or not 
	$record =$check_for_username->num_rows;
	if($record >0 ){
		echo '1';
	}
	else{
		echo '0';
	}
}
?>