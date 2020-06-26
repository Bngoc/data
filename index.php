<?php

define('AREA', "ADMIN");

include dirname(__FILE__) . '/core/init.php';

//cn_sendheaders();
// load skin template
$coreWeb->cn_load_skin_web();
$coreWeb->cn_login();
$coreWeb->cn_register_form();

hook('index/invoke_module', array($_module));
