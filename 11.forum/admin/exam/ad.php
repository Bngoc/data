<?php
session_start();
require("security.php");
include('../includes/functions.php');
require_once("../config.php");

//----------------------------------------
if(isset($_SESSION['ADMIN']) == FALSE) {
	header("Location: " . $config_basedir . "/admin.php?ref=ad");
}

/*
if(isset($_POST['sumit'])){
	if ($passadmin != md5($_POST['ADM'])){
		$notice = "<center style='color:Red'>Ban khong phai thanh vien quan tri vien!</center>";
		echo "
			<script type='text/javascript'> alert('" . $notice . "');</script>
		";
	}
	else $_SESSION['ADM'] =$passadmin;
}
if (!(isset($_SESSION['ADM']))){
	echo "
		<center><form action='' method=post>
		Code: <input type=password name=ADM>
		<input type=submit name='sumit' value=Submit!>
		</form></center>
	";
	exit();
}
*/
echo $_SERVER['DOCUMENT_ROOT'];

define('__ROOT__', dirname(dirname(__FILE__))); 
echo __ROOT__;
//require_once(__ROOT__.'/config.php'); 
/*
$path = realpath(dirname(__FILE__)).'/../libraries';
set_include_path($path . PATH_SEPARATOR . get_include_path());
require_once($path."/Config.php");

echo $path;
*/

//$db = mysql_connect($dbhost, $dbuser, $dbpassword);
//mysql_select_db($dbdatabase, $db);
/*
if (isset($_SESSION['USERADMIN'])) {
	unset($_SESSION["USERADMIN"]);
}

if (isset($_SESSION['USERNAME'])) {
	unset($_SESSION["USERNAME"]);
}
*/
//if (isset($_SESSION['ADMIN']) == FALSE)  {
	/*if(isset($_POST['submit'])) {
			$sql = "SELECT * FROM admins WHERE username = '" . $_POST['username'] . "' AND password = '" . $_POST['password'] . "';";
			
			$result = $db->query($sql);
			$numrows = $result->num_rows;
				
			if($numrows == 1) {	
				$row = $result->fetch_assoc();
				
				//session_register("ADMIN");
				$_SESSION['ADMIN'] = $row['username']; // lay ten  ??
				//$_SESSION['ADMINID'] = $row['id'];
				$_SESSION['USERID'] = $row['id'];
				/* ************************************ */
				/*
					switch($_GET['ref']) {
						case "cat":
							header("Location: " . $config_basedir . "/admin/addcat.php");
						break;
						
						case "forum":
							header("Location: " . $config_basedir . "/admin/addforum.php");
						break;
						case "div":
							header("Location: " . $config_basedir . "/admin/div.php");
						break;

						case "del":
							echo " cai gi  delete"; exit();
							if(isset($_GET['id']) == FALSE) {
								//header("Location: " . $config_basedir . "/admin/delete.php");
							}
							else{
								//header("Location: " . $config_basedir . "/admin/delete.php");
							}
						break;
						
						case "update":
							echo " ve update";
							//header("Location: " . $config_basedir);
						break;
						
						default:
							header("Location: " . $config_basedir);
						break;
					}
				*/
				/* ***************************************** */
				$mod = $_GET['mod'];
				echo $mod;
				include('tr.php');
				include('left.php');
				//exit();
				if( (isset($_GET['mod']))) {
					if ( !eregi("[^a-zA-Z0-9_$]", $mod) ) {
						if (is_file($mod.".php")) require_once($mod . ".php");
						else require_once('errorfile.php');
					}
					else require_once("errorfile.php");
				}
				//else include('admin/checkwrite.php');
				
				include('footer.php');
				
			/*	
				
			}
			else {
					header("Location: " . $config_basedir . "/admin.php?error=1"); //??????
				}

		}
		else {

			require('header.php');
			//require('security.php');
			echo "<center><h2>Admin login</h2></center>";
				
			if(isset($_GET['error'])) {
				echo "Incorrect login, please try again!";
			}
		
		

	?>

	<center>
	<form action="" method="post">   <?php echo pf_script_with_get($SCRIPT_NAME) ?>

	<table>
	<tr>
		<td>Username</td>
		<td><input type="text" name="username"></td>
	</tr>
	<tr>
		<td>Password</td>
		<td><input type="password" name="password"></td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit" name="submit" value="Login!"></td>
	</tr>
	</table>
	</form>
	</center>
	<?php
	include($_SERVER['DOCUMENT_ROOT']."/forum/footer.php");
	}
//}
/*
else{
	echo "
	<script type='text/javascript'> alert('Da dang nhap " . $_SESSION['ADMIN'] . " roi'); window.location='" . $config_basedir . "';</script>
	";
}
*/
?>