<?php

// check PHP version
if (substr(PHP_VERSION, 0, 5) < '4.1.0') {
    die('PHP Version is ' . PHP_VERSION . ', need great than PHP &gt;= 4.1.0 to start cutenews');
}

define('DEV_DEBUG', true); // for visual detect errors
if (DEV_DEBUG) {
    ini_set('display_errors', '1');
    error_reporting(E_ALL | E_STRICT);
} else {
    error_reporting(E_ALL ^ E_NOTICE);
}

// definitions
define('BQN_MU', microtime(true));
define('VERSION', '2.0.3');
define('VERSION_ID', 203);
define('VERSION_NAME', 'Admin Dashboard  v.' . VERSION . 'c');

define('ROOT_ADMIN', __DIR__);
define('SERVDIR', dirname(dirname(__FILE__)));
define('ROOT', dirname(dirname(dirname(__FILE__))));
define('MODULE_DIR', SERVDIR . '/core/modules');
define('SKIN', SERVDIR . '/cdata');
define('CN_DEBUG', FALSE);
//define('URL_PATH', 		cn_path_uri());  //custom by bqn
define('URL_PATH_', (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . dirname($_SERVER['SCRIPT_NAME']));  //custom by bqn ===>root
define('URL_PATH', (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . dirname($_SERVER['SCRIPT_NAME']) . '/admin');  //custom by bqn===>admin
define('PHP_SELF', $_SERVER["SCRIPT_NAME"]);

// include necessary libs
require_once ROOT . '/vendor/autoload.php';
require_once ROOT . '/core/function/initialization.php';
require_once SERVDIR . '/core/libAdmin/initialization_admin.php';
require_once ROOT . '/core/function/libgarena.php';
require_once SERVDIR . '/core/security.php';
require_once SERVDIR . '/core/news.php';
require_once ROOT . '/core/class.phpmailer.php';
require_once ROOT . '/core/class.smtp.php';
require_once SERVDIR . '/core/ProcessCoreAdmin.php';

// create cutenews caches
$_CN_SESS_CACHE = array();

$_CN_cache_block_id = array();
$_CN_cache_block_dt = array();

// Define ALL privileges and behaviors
$_CN_access = array
(
    // configs
    'C' => 'Cd,Cvm,Csc,Cp,Cc,Ct,Ciw,Cmm,Cum,Cg,Cb,Ca,Cbi,Caf,Crw,Csl,Cwp,Cmt,Cpc,Can,Cvn,Ccv,Cen,Clc,Csr,Com,Aci,Arm,Win,Rin,Shi,Cro,Wea,Sce,Sta,Spe,Fen,Tic,Ocas',
    // news
    'N' => 'Nes,Neg,Nea,Nvs,Nvg,Nva,Nua,Nud,Ncd',
    // comments
    'M' => 'Mes,Meg,Mea,Mds,Mdg,Mda,Mac',
    // behavior
    'B' => 'Bd,Bs',
);

$coreAdmin = new ProcessCoreAdmin();
global $coreAdmin;

// v2.0 init sections
$is_config = $coreAdmin->cn_config_load();


$coreAdmin->cn_db_init(); //database
//cn_rewrite_load(); //??

$coreAdmin->cn_parse_url();
$coreAdmin->cn_detect_user_ip();
$coreAdmin->cn_load_session();
$coreAdmin->cn_relocation_db();

// 2.0.3 checking existing configuration
if ($is_config) {
    //cn_load_plugins();
    //cn_online_counter();
}

//cn_require_install();
if (!db_installed_check()) {
    $coreAdmin->cn_require_install();
};

// load modules
include SERVDIR . '/core/modules/init.php';

//hook('init/finally');

$coreAdmin->cn_load_skin();
$coreAdmin->cn_register_admin_form();

if ($coreAdmin->cn_login_admin()) {
    hook('index/invoke_module', array($_module));
} else {
    $coreAdmin->cn_login_admin_form();
}


$name_function = '';
if (isset($_REQUEST['name_function'])) {
    $name_function = $_GET['name_function'];
}

if ($name_function == 'cn_check_conncet') {
    $coreAdmin->cn_check_connect();
}
