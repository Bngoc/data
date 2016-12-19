<?php
session_start();
$username = $_POST['names'];
$password = ($_POST['pwds']);


$mysqli=mysqli_connect('localhost','root','','forum');

$query = "SELECT * FROM admins WHERE username='$username' AND password='$password'";
$result = mysqli_query($mysqli,$query)or die(mysqli_error());
$num_row = mysqli_num_rows($result);
		$row=mysqli_fetch_array($result);
		if( $num_row >=1 ) {
			echo 'true';
			$_SESSION['ADMIN']=$row['username'];
		}
		else{
			echo 'false';
		}
?>