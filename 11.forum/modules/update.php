<?php
session_start();
include("../config.php");

//$db = mysql_connect($dbhost, $dbuser, $dbpassword);
//mysql_select_db($dbdatabase, $db);

//if(isset($_SESSION['USERNAME']) == FALSE) {
	//header("Location: " . $config_basedir . "/login.php?ref=update");
//}
require_once('../header.php');
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
	header("Location: " . $config_basedir);
}

switch($_GET['func']) {
	case "uformess":
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
					header("Location: " . $config_basedir . "/modules/viewmessages.php?id=" . $_GET['messages']);
				}
				else{
					die ('Error:'. mysqli_error()) ;
				}
			}
		}
	break;
	
	case "umess":
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
				/*
				$udsql = "UPDATE topics SET subject = '" .$_POST['subject'] ."' WHERE id =" . $uprow[3] . ";";
				if(!mysqli_query($db,$udsql)){ //bqn
					die ('Topic_Error:'. mysqli_error()) ;//bqn
				}
				*/
				$udsql = "UPDATE messages SET subject = '" .$_POST['subject'] ."', body = '" . $_POST['body'] . "' WHERE id =" . $validid . ";";
				//mysql_query($udsql);			
				if(mysqli_query($db,$udsql)){
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
require('../footer.php');
?>