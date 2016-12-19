<?php

//require('security.php');
//require_once('../config.php');
require('../config.php');
require('../includes/functions.php');
//define('__ROOT__', dirname(dirname(__FILE__))); 
//require_once(__ROOT__.'/config.php');
//if(isset($_POST['submit'])) {
	//$ko .= pf_script_with_get($SCRIPT_NAME);
	//echo pf_script_with_get($SCRIPT_NAME); 
	//echo "Ko " .$ko;
	//exit();
session_start();
	
if(isset($_POST['sumit'])){
	//$pass_admin_sub = md5($_POST[ADMIN]);
	if ($passadmin != md5($_POST['adm'])){
		echo "<center style='color:Red'>Ban khong phai thanh vien quan tri vien!</center>";
	//exit();
	}
	//else{
		//require('index2.php'); //admin.php?ref=add
		//header("Location: " . $config_basedir . "/admin/secu.php?fuc=login&" . pf_script_with_get($SCRIPT_NAME));
		
	//}
}
if (isset($_SESSION['ADMIN']) == FALSE)  {
	echo "
	<center><form action='' method=post>
		Code: <input type=password name=adm>
		<input type=submit name='sumit' value=Submit!>
	</form></center>
	";
	exit();
}
//else{
	//echo "
	//	<script type='text/javascript'> alert('Da dang nhap " . $_SESSION['ADMIN'] . " roi'); window.location='" . $config_basedir . "';</script>
	//";
//}


?>