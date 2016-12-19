<?php
//define('BQN_MU',	true);
define('BQN_MU',     microtime(true));
//require_once './includes/cn_url_modify.php';
//require_once './includes/core.php';
//require("config.php");
//session_start();


//----------------------------------------'Ban khong phai thanh vien quan tri vien!'
/*
if(isset($_POST['sumit'])){
	if ($passadmin != md5($_POST['ADM'])){
		$notice = "Ban khong phai thanh vien quan tri vien!";
		echo "
			<script type='text/javascript'> alert('$notice');</script>
		";
	}
	else {
		$_SESSION['ADM'] =$passadmin;
		//echo "<script type='text/javascript'>alert('$passadmin');</script>";
		
	}
}
if (!isset($_SESSION['ADM'])){
	echo "
		<center><form action='' method=post>
		Code: <input type=password name=ADM>
		<input type=submit name='sumit' value=Submit!>
		</form></center>
	";
	exit();
}	
*/
//----------------------------------------
//require_once("C:/xampp/htdocs/forum/config.php");

//require_once($_SERVER['DOCUMENT_ROOT'] .'/forum/config.php');



//echo $['DOCUMENT_ROOT'];
echo "dd : " .$actual_link = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'] ."<br>";
echo "dd : " .$actual_link = 'http://'.$_SERVER['HTTP_HOST'] ."<br>";

$actual_linkk = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
echo 'actual_linkk: '. $actual_linkk .'<br>';

//define('ROOT',		$_SERVER['DOCUMENT_ROOT']);
//define('PHP_SELF',    $_SERVER['PHP_SELF']);

//define('MODULE_DIR',    SERVDIR . '/core/modules'); // nhan xu li
//define('SKIN',          SERVDIR . '/forum/admin'); // chua html 
//define('__ROOT__', dirname(dirname(__FILE__))); 
//echo __ROOT__ . "<br>";


echo '1: '. $_SERVER["SCRIPT_FILENAME"] .'<br>';
echo '2: '. $_SERVER["PHP_SELF"] .'<br>';
echo '3: '. $_SERVER["DOCUMENT_ROOT"] .'<br>';
echo '4: '. $_SERVER["SERVER_NAME"] .'<br>';
echo '5:'. dirname($_SERVER['SCRIPT_NAME']) .'<br>';
echo '6:'. dirname($_SERVER["SCRIPT_FILENAME"]) .'<br>';
echo '7:' .$_SERVER['SCRIPT_NAME'] .'<br>';

echo '$_SERVER[PHP_SELF]: ' . $_SERVER['PHP_SELF'] . '<br />';
echo 'Dirname($_SERVER[PHP_SELF]: ' . dirname($_SERVER['PHP_SELF']) . '<br>';
echo 'Dirname($actual_linkk =>cut: ' . dirname($actual_linkk) . '<br>';


/*
//-------------------------------------------------------------------
//$gh = pf_script_with_get($SCRIPT_NAME); echo "SCRIPT_NAME_ham: " . $gh . "<br>";
//$ghh = pf_script_with_get($_SERVER['HTTP_REFERER']); echo "HTTP_REFERER_SCRIPT_NAME: " . $ghh . "<br>"; //exit();
//$ghh = pf_script_with_get($_SERVER['REQUEST_URI']); echo "REQUEST_URI_SCRIPT_NAME: " . $ghh . "<br>"; //exit();
echo 'SCRIPT_NAME: '. $_SERVER['SCRIPT_NAME'].'<br>';
echo 'HTTP_REFERER: '. $_SERVER['HTTP_REFERER'].'<br>';

echo 'REQUEST_URI: '. $_SERVER['REQUEST_URI'].'<br>';
echo 'SERVER_ADMIN: '. $_SERVER['SERVER_ADMIN'].'<br>';
echo 'PHP_AUTH_USER: '. $_SERVER['PHP_AUTH_USER'].'<br>';

*/

//-------------------------------------------------------------------

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


if(!isset($_SESSION['ADMIN'])){
	//C1:include('admin/header.php');
	//C1:include('admin/footer.php');
	
	 header('location:' . $root . '/admin/2.php');

}

*/



//require_once('admin/header.php');
//if(isset($_GET['mod'])){
	//$mod = $_GET['mod'];
//}

//echo "ffd " .dirname(dirname(__FILE__).'.html');

//echo "Root " . Root;
define('AREA', "ADMIN");
define('ROOT',       dirname(__FILE__));

//load lib
require(ROOT."/admin/security.php"); // ?????????
include (ROOT.'/includes/functions.php'); //???????

include ROOT.'/admin/core/init.php';


/*

if((isset($_GET['mod']))) {
	if ( !preg_match("[^a-zA-Z0-9_$]", $mod) ) {
		if (is_file('admin/'.$mod.".php")) require_once('admin/'.$mod.".php");
		else require_once("admin/errorfile.php");
	}
	else require_once("admin/errorfile.php");
}
else include('admin/checkwrite.php');

*/

//cn_sendheaders();
cn_load_skin();
cn_register_form();

if (cn_login())
{
    hook('index/invoke_module', array($_module));
}
else
{
    cn_login_form();
}
//require_once('admin/footer.php');


?>