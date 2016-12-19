<?php
$opensite	= 1;
$passadmin	= 'e10adc3949ba59abbe56e057f20f883e';
$type_connect = 'mssql';

//$type_connect = 'mysql';
$dbhost_ = "(local)";
$dbhost = "127.0.0.1";
$dbuser = "sa";
$dbpassword = "emngockt93";
$dbdatabase = 'MuOnline';
$dbdatabase_ = "Driver={SQL Server};Server=(local);Database=MuOnline";
$dsn = "Driver=FreeTDS;Server=(local);Port=1433;Database=MuOnline;";
/*

$type_connect	= 'mssql';
$dbhost	= '(local)';
$dbuser	= 'sa';
$dbpassword	= 'emngockt93';
$dbdatabase = 'Forum';
*/
// Add the name of the forums below
$config_forumsname = "CineForums";

// Add your name below
$config_admin = "BUI NGOC";
$config_adminemail = "jono AT jonobacon DOT org";

// Add the location of your forums below
$config_basedir = "http://localhost/forum";



$list_ip = array (
	'127.0.0.1',
	'::1'
);

/*
$timestamp = time()-3600;
$day = date('d',$timestamp);
$month = date('m',$timestamp);
$year = date('Y',$timestamp);
*/


include_once('adodb/adodb.inc.php');
if($type_connect=='odbc') {
	$db = ADONewConnection('odbc');
	$db->debug = true;
	$connect_mssql = $db->Connect($dbdatabase_,$dbuser,$dbpassword);
	if (!$connect_mssql) die('Ket noi voi SQL Server loi! Hay kiem tra lai ODBC ton tai hoac User & Pass SQL dung.');
}
else if($type_connect=='mssql') {//mssql
	//if (extension_loaded('mssql')) echo('');
	//else Die('Loi! Khong the load thu vien php_mssql.dll. Hay cho phep su dung php_mssql.dll trong php.ini');
	
	$db = ADONewConnection('mssql');
	$db->debug = true;
	//mssql_connect()
	//$connect_mssql = $db->Connect($dbhost,$dbuser,$dbpassword,$dbdatabase);
	$connect_mssql = $db->Connect($dbhost,$dbuser,$dbpassword,$dbdatabase);
	if (!$connect_mssql) die('Loi! Khong the ket noi SQL Server');
}
/*
else if($type_connect=='mysql') {
	
	$db = mysqli_connect($dbhost,$dbuser,$dbpassword,$dbdatabase);
	if (mysqli_connect_errno()){
		echo "Connect failed: " . $dbdatabase;
		exit();
	}
	
	//or die("cannot connect");
	//mysql_select_db($dbdatabase)or die("Cannot select ".$dbdatabase);
	//mysql_query("SET NAMES 'UTF8'");
	$db->set_charset("utf8");
//}
*/
?>
