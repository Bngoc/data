<?php

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
//define('ROOT', dirname(__FILE__));
//define('URL_HTTP', 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);

//load lib
//require(ROOT."/admin/security.php"); // ?????????
//include (ROOT.'/includes/functions.php'); //???????

include dirname(__FILE__) . '/core/init.php';


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
//list($username, $password) = GET('Account, Password');

//cn_sendheaders();
cn_load_skin(); // load skin templa
//cn_register_form();
cn_login();
cn_register_form();
//cn_login();
//if (cn_login())
{
    hook('index/invoke_module', array($_module));
}
//else
{
    // cn_login_form();
}
//require_once('admin/footer.php');


?>