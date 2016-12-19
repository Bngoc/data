<?php
include_once("security.php");
session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . "/forum/config.php");
//require('../includes/functions.php');

//if(isset($_POST['submit'])) {
	//if(isset($_GET['username']) && isset($_GET['pwd'])) {

//$name = $_POST['names'];
//$password = $_POST['pwds'];

		$name = strip_tags($_REQUEST['names']);
		$name = mysqli_real_escape_string($db,$name);
		
		$password = strip_tags($_REQUEST['pwds']);
		$password = mysqli_real_escape_string($db,$password);
		//echo "user: " . $name . "<br>";
		//echo "password: " . $password . "<br>";
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
						
						case "ad":
							header("Location: " . $config_basedir . "/admin/ad.php");
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
					echo 'true';
			}
			else {
				echo 'false';
					//header("Location: " . $config_basedir . "/admin.php?error=1"); //??????
				}

		//}
		//else {
			//echo 'false';
			/*
			//include('admin/header.php');
			//require('security.php');
			echo "<center><h2>Admin login</h2></center>";
				
			if(isset($_GET['error'])) {
				echo "Incorrect login, please try again!";
			}
			*/

	?>
<?php //$fg = pf_script_with_get($SCRIPT_NAME); echo $fg;?>
	<!--<center>
	<form action="admin.php<?php //echo $fg ?>" method="post">   
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
	</center> -->
	<?php
	//include($_SERVER['DOCUMENT_ROOT']."/forum/footer.php");
	//include('admin/footer.php');
	//exit();
	//}
?>