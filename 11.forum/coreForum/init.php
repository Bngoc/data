<?php
// check PHP version
if (substr(PHP_VERSION, 0, 5) < '4.1.0') {
    die('PHP Version is ' . PHP_VERSION . ', need great than PHP &gt;= 4.1.0 to start cutenews');
}

define('DEV_DEBUG', false); // for visual detect errors
if (DEV_DEBUG) {
    ini_set('display_errors', '1');
    error_reporting(E_ALL | E_STRICT);
} else {
    error_reporting(E_ALL ^ E_NOTICE);
}

// definitions
define('BQN_MU', microtime(true));
define('VERSION', '1.0.3');
define('VERSION_ID', 103);
define('VERSION_NAME', 'Admin Forum  v.' . VERSION . 'c');

define('SERVDIR', dirname(dirname(__FILE__)));
define('ROOT', dirname(dirname(dirname(__FILE__))));
define('MODULE_DIR', SERVDIR . '/coreForum/modules'); // nhan xu li
define('SKIN', SERVDIR . '/cdataforum'); // chua html
define('CN_DEBUG', FALSE);
//define('URL_PATH', 		cn_path_uri());  //custom by bqn
define('URL_PATH_', dirname($_SERVER['SCRIPT_NAME']));  //custom by bqn ===>root
define('URL_PATH', dirname($_SERVER['SCRIPT_NAME']) . '/forum');  //custom by bqn===>admin
define('PHP_SELF', $_SERVER["SCRIPT_NAME"]);



// include necessary libs
require_once ROOT . '/core/function/libgarena.php';
require_once ROOT . '/forum/coreForum/cn_core_forum.php'; //libs
require_once ROOT . '/core/security.php';
//require_once ROOT . '/core/news.php';
require_once ROOT . '/core/class.phpmailer.php';
require_once ROOT . '/core/class.smtp.php';
require_once ROOT . '/core/db/flat_web.php';


/*
// magic quotes = ON, filtering it
if (ini_get('magic_quotes_gpc'))
{
    cn_filter_magic_quotes();
}
*/
/*
if (!DEV_DEBUG)
{
    // catch errors
    set_error_handler("user_error_handler");
}
*/
// create cutenews caches
$_CN_SESS_CACHE = array();
/*
$_CN_cache_block_id = array();
$_CN_cache_block_dt = array();
*/
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

// v2.0 init sections
$is_config = cn_config_load();



cn_parse_url();
cn_detect_user_ip();
cn_load_session(); //load session_start
cn_relocation_db_new();

// 2.0.3 checking existing configuration
if ($is_config) {
    //cn_load_plugins();
    //cn_online_counter();
}

//cn_require_install();
db_installed_check();

// load modules
include ROOT . '/forum/coreForum/modules/init.php';

//hook('init/finally');
