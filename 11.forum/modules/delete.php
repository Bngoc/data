<?php


include("../config.php");
//include('admin/MyLogPHP.class.php');
//$log = new MyLogPHP('./log/delete.log.csv');
session_start();
//$db = mysql_connect($dbhost, $dbuser, $dbpassword);
//mysql_select_db($dbdatabase, $db);

//if(isset($_SESSION['']) == FALSE) {
	//header("Location: " . $config_basedir . "/admin.php?ref=del");
//}
//if(isset($_SESSION['username']) == FALSE) {
	//header("Location: " . $config_basedir . "/admin/login.php?ref=del");
	//echo "sjsns";
//}


	
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
		
	case "deformess":
		$del_mess_sql = "DELETE FROM messages WHERE topic_id = " . $validid . ";";
		//$db->query($del_mess_sql);
		
		if(!mysqli_query($db,$del_mess_sql)){ //bqn
			die ('Topic_Error:'. mysqli_error()) ;//bqn
		}
		
		$delsql = "DELETE FROM topics WHERE id = " . $validid . ";";
		//$db->query($delsql);
		if(!mysqli_query($db,$delsql)){ //bqn
			die ('Topic_Error:'. mysqli_error()) ;//bqn
		}
		//$log -> debug($delsql,'DB');
		//header("Location: " . $config_basedir . "/modules/viewforum.php?id=" . $_GET['forum']);
		header("Location: " . $_SESSION['URL']);
	break;
	
	case "dmess":
		$delsql = "DELETE FROM messages WHERE id = " . $validid . ";";
		$db->query($delsql);
		//$log -> debug($delsql,'DB');
		header("Location: " . $config_basedir . "/modules/viewmessages.php?id=" . $_GET['messages']);
	break;
	
	default:
		header("Location: " . $config_basedir);
	break;


}
?>