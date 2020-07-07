<?php

define('AREA', "ADMIN");

// load lib
include dirname(__FILE__) . '/admin/core/init_admin.php';

$coreAdmin->cn_load_skin();
$coreAdmin->cn_register_admin_form();

if ($coreAdmin->cn_login_admin()) {
    hook('index/invoke_module', array($_module));
} else {
    $coreAdmin->cn_login_admin_form();
}
