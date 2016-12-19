<?php

session_start();
require("../config.php");
//require("config.php");
require("../includes/functions.php");


//$db = mysql_connect($dbhost, $dbuser, $dbpassword);
//mysql_select_db($dbdatabase, $db);
/*
$log  = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
            "Attempt: ".($result[0]['success']=='1'?'Success':'Failed').PHP_EOL.
            "User: ". $_POST['username'].PHP_EOL.
            "Pass: ". $_POST['password'].PHP_EOL.
            "-------------------------".PHP_EOL;
    //-
    file_put_contents('./log/log_login'.date("j.n.Y").'.txt', $log, FILE_APPEND);
*/
	
//include('admin/log.php');
include('../admin/MyLogPHP.class.php');
$log = new MyLogPHP('../log/login.log.csv');

//$log = new MyLogPHP();
/*
$log->info('The program starts here.');
$log->warning('This problem can affect the program logic');
$log->warning('Use this software at your own risk!');
$log->info('Lawrence Lagerlof','AUTHOR');
$log->info('Asimov rulez','FACT');
$log->error('Everything crash and burn','IE');
$log->debug("select * from table",'DB');
*/

//$getid = $_GET['id'];
//echo $getid; exit();

/*
//-------------------------------------------------------------------
$gh = pf_script_with_get($SCRIPT_NAME); echo "SCRIPT_NAME_ham: " . $gh . "<br>"; 
$ghh = pf_script_with_get($_SERVER['HTTP_REFERER']); echo "HTTP_REFERER_SCRIPT_NAME: " . $ghh . "<br>"; //exit();
$ghh = pf_script_with_get($_SERVER['REQUEST_URI']); echo "REQUEST_URI_SCRIPT_NAME: " . $ghh . "<br>"; //exit();
echo 'SCRIPT_NAME: '. $_SERVER['SCRIPT_NAME'].'<br>';
echo 'HTTP_REFERER: '. $_SERVER['HTTP_REFERER'].'<br>';
echo 'PHP_SELF: '. $_SERVER['PHP_SELF'].'<br>';
echo 'REQUEST_URI: '. $_SERVER['REQUEST_URI'].'<br>';
echo 'SERVER_ADMIN: '. $_SERVER['SERVER_ADMIN'].'<br>';
echo 'PHP_AUTH_USER: '. $_SERVER['PHP_AUTH_USER'].'<br>';

//-------------------------------------------------------------------
*/

if(empty($_SESSION['USERADMIN']) || empty($_SESSION['USERNAME'])){
if(isset($_POST['submit'])) {
$sql = "SELECT * FROM users WHERE username = '" . $_POST['username'] . "' AND password = '" . $_POST['password'] . "';";
	$log->debug($sql,'DB');
	$result = mysqli_query($db,$sql);
	$numrows = $result->num_rows;
		
	if($numrows == 1) {	
		$row = $result->fetch_assoc();
		
		if($row['active'] == 1) {
			
			//session_register("USERNAME");
			if($row['username'] == 'Admin')
				$_SESSION['USERADMIN'] = $row['username'];
			
			$_SESSION['USERNAME'] = $row['username'];
			$_SESSION['USERID'] = $row['id']; //gan gia id cua user cho $_SESSION['USERID'];
			
			
			
			switch($_GET['ref']) {
				case "newpost":
					if(isset($_GET['id']) == FALSE) {
						header("Location: " . $config_basedir . "/modules/newtopic.php");
					}
					else {
						header("Location: " . $config_basedir . "/modules/newtopic.php?id=" . $_GET['id']);
					}
				break;
	
				case "reply":
					if(isset($_GET['id']) == FALSE) {
						header("Location: " . $config_basedir . "/modules/newtopic.php");
					}
					else {
						header("Location: " . $config_basedir . "/modules/newtopic.php?id=" . $_GET['id']);
					}
				break;
								
				default:
					header("Location: " . $_SESSION['URL']);
				break;
			}
		}
		else {
			require("../header.php");
			echo "<center>This account is not verified yet. You were emailed a link to verify the account. Please click on the link in the email to continue.</center>";
		}			
	}
	else {
		header("Location: " . $config_basedir . "/modules/login.php?error=1");
	}
}
else {

	require("../header.php");
	
	if(isset($_GET['error'])) {
		echo "<center>Incorrect login, please try again!</center>";
	}
	
?>
	<div id="content" >
		<form action="" method="post" autocomplete="on">
			<h1>Login Form</h1>
			<p class="foru"> To log in on the <a href ="<?php echo $config_basedir ?>/index.php"><?php echo $config_forumsname; ?> </a> forums, fill in the form below.</p>
			<div style=" text-align: center; ">
				<input type="text" name="username" required title="Username" placeholder="Username" required="" id="username" />
				<input type="password" name="password" required title="Password" placeholder="Password" required="" id="password" />
			</div>
			<div>
				<input type="submit" name="submit" value="Log in" />
				<a href="#">Lost your password?</a>
				<a href="register.php">Register</a>
			</div>
		</form><!-- form -->
	</div><!-- content -->

<?php
}
//require("../footer.php");
}
else {
	//jump($_SERVER['HTTP_REFERER']);
}
?>