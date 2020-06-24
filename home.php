<?php
define('AREA', "ADMIN");

// load lib
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

hook('index/invoke_module', array($_module));