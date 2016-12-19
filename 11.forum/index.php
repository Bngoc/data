<?php

define('AREA', "ADMINFORM");

include dirname(__FILE__) . '/coreForum/init.php';

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
cn_load_skinForum(); // load skin forum
//cn_register_form();
            //cn_loginForum();
            //cn_register_formForum();
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