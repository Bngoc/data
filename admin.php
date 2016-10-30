<?php

define('AREA', "ADMIN");
//define('ROOT', dirname(__FILE__));

//load lib
//require(ROOT."/admin/security.php"); // ?????????
//include (ROOT.'/includes/functions.php'); //???????

//include ROOT . '/admin/core/init.php';
include dirname(__FILE__) . '/admin/core/init.php';


//cn_sendheaders();
cn_load_skin(); // load skin templa
cn_register_form();

if (cn_login()) {
    hook('index/invoke_module', array($_module));
} else {
     cn_login_form();
}

?>