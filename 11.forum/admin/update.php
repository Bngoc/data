<?php

require_once('security.php');
include_once('../config.php');
require_once('../header.php');
include('../admin/MyLogPHP.class.php');
//mysql_query("SET NAMES 'UTF8'");
session_start();
$log = new MyLogPHP('../log/update.log.csv');

//$db = mysql_connect($dbhost, $dbuser, $dbpassword);
//mysql_select_db($dbdatabase, $db);
//if((isset($_SESSION['ADMIN']) ==TRUE)) {
//if(isset($_SESSION['ADMIN']) == FALSE) {
	//header("Location: " . $config_basedir . "/admin/secu.php?ref=update");
//}

if(isset($_GET['id']) == TRUE) {
	if(is_numeric($_GET['id']) == FALSE) {
		$error = 1;
	}
	if(isset($error) == 1) {
		header("Location: " . $config_basedir);
	}
	else {
		$validid = $_GET['id'];
	}
}
else {
	header("Location: " . $config_basedir);//. "/admin/secu.php?ref=update"); //xem lai
}
/*
if(isset($_SESSION['ADMIN']) == FALSE) {
	header("Location: " . $config_basedir . "/admin/secu.php?ref=update");
}
*/
switch($_GET['func']) {
	case "cat":
		$upsql = "SELECT name FROM categories WHERE id = " . $validid . " ;";
		$upquery = $db->query($upsql);
		$getnumrows = $upquery->num_rows;
		if($getnumrows != 0) {
			$uprow = $upquery->fetch_row();
			$showcat = $uprow[0];
			
			echo "
			<h2><p><strong>Edit Categories: </strong> <i> $showcat </i></p></h2>
			<form action='' method='POST'>
			<input type =''  name = 'name' value = '$showcat'>
			<input type='submit' name='submit' value='>>'>
			
			</form>
			
			";

			//exit();//UPDATE `categories` SET `id`=[value-1],`name`=[value-2] WHERE 1
			if(isset($_POST['submit'])) {
				$getname = $_POST['name'];
				$udsql = "UPDATE categories SET name = '$getname' WHERE id = " . $validid . ";";
				//mysql_query($udsql);
				
				if(mysqli_query($db,$udsql)){
					$log -> debug($udsql,'DB');
					header("Location: " . $config_basedir);
				}
				else{
					die ('Error:'. mysqli_error()) ;
				}
			}
		}
	break;

	case "forus":
		$upsql = "SELECT name, description FROM forums WHERE id = " . $validid . " ;";
		$upquery = $db->query($upsql);
		$getnumrows =$upquery ->num_rows;
		if($getnumrows != 0) {
			$uprow = $upquery->fetch_row();

			echo "
			<h2><p><strong>Edit Forums: </strong> <i> " . $uprow[0] . " </i></p></h2>
			<form action='' method='POST'>
				<input type ='text'  name = 'name' value = '" . $uprow[0] . "'>
				<textarea name='description' rows='10' cols='50'>" . $uprow[1] . "</textarea>
				<input type='submit' name='submit' value='>>'>
			</form>
			
			";

			if(isset($_POST['submit'])) {
				$getname = $_POST['name'];
				$getdescri = $_POST['description'];
				$udsql = "UPDATE forums SET name = '$getname' , description = '$getdescri' WHERE id = " . $validid . ";";

				if(mysqli_query($db,$udsql)){
					$log -> debug($udsql,'DB');
					header("Location: " . $config_basedir);
				}
				else{
					die ('Error:'. mysqli_error()) ;
				}
			}
		}
	break;
		
	case "mess":
		$upsql = "SELECT * FROM messages WHERE id = " . $validid . " ;";
		$upquery = $db->query($upsql);
		$getnumrows = $upquery->num_rows;
		if($getnumrows != 0) {
			$uprow = $upquery->fetch_row();
			//$showcat = $uprow[4];
			
			echo "
			<h2><p><strong>Edit messages subject: </strong> <i>" . $uprow[4] ." </i></p></h2>
			<form action='' method='POST'>
				<tr><td>Subject</td><td><input type='text' name='subject' value ='" . $uprow[4] ."'></td></tr>
				<tr><td>Body</td><td><textarea name='body' rows='10' cols='50'> " . $uprow[5] . "</textarea></td></tr>
				<tr><td></td><td><input type='submit' name='submit' value='Edit!'></td></tr>
			</form>
			
			";

			//exit();
			if(isset($_POST['submit'])) {
				//$getname = $_POST['updatename'];
				$udsql = "UPDATE topics SET subject = '" .$_POST['subject'] ."' WHERE id =" . $uprow[3] . ";";
				if(!mysqli_query($db,$udsql)){ //bqn
					die ('Topic_Error:'. mysqli_error()) ;//bqn
				}
				$udsql = "UPDATE messages SET subject = '" .$_POST['subject'] ."', body = '" . $_POST['body'] . "' WHERE id =" . $validid . ";";
				//mysql_query($udsql);			
				if(mysqli_query($db,$udsql)){
					$log -> debug($udsql,'DB');
					header("Location: " . $config_basedir . "/modules/viewmessages.php?id=" . $_GET['messages']);
				}
				else{
					die ('Error:'. mysqli_error()) ;
				}
			}
		}
	break;
	
	default:
		header("Location: " . $config_basedir);
	break;

}
/*}
else{
	header("Location: " . $config_basedir);
}*/
require('../footer.php');
?>;