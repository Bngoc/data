<?php

define('AREA', "ADMIN");

// load lib
//include dirname(__FILE__) . '/admin/core/security.php';
include dirname(__FILE__) . '/admin/core/init.php';

//cn_sendheaders();
cn_load_skin(); // load skin templa
cn_register_form();

if (cn_login()) {
    hook('index/invoke_module', array($_module));
} else {
    cn_login_form();
}