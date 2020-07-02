<?php
ob_start();

// for visual detect errors
define('DEV_DEBUG', true);
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
define('VERSION_NAME', 'News v.' . VERSION . 'c');

define('SERVDIR', dirname(dirname(__FILE__)));
define('ROOT', dirname(dirname(__FILE__)));
define('MODULE_DIR', SERVDIR . '/core/modules');
define('SKIN', SERVDIR . '/cdata');
define('MODULE_ADM', SERVDIR . '/admin');
define('CN_DEBUG', false);
define('URL_PATH', (isset($_SERVER['HTTPS']) ? "https" : "http") . '://' . dirname($_SERVER['SCRIPT_NAME']));  //custom by bqn
define('URL_PATH_IMG', '/public/images');
define('PHP_SELF', $_SERVER["SCRIPT_NAME"]);
define('MAX_BANK_ZEN', 999999999999999);
define('MAX_TRANS', 2000000000);

// include necessary libs
require_once ROOT . '/vendor/autoload.php';
require_once ROOT . '/Utils/functions/libgarena.php';
require_once ROOT . '/Utils/functions/initialization.php';
require_once ROOT . '/core/function/initialization_web.php';
// libs
require_once ROOT . '/Utils/functions/security.php';
require_once SERVDIR . '/core/db/flat_web.php';
require_once ROOT . '/Utils/email/class.phpmailer.php';
require_once ROOT . '/Utils/email/class.smtp.php';
require_once ROOT . '/Utils/GameBank/CardGameBankAPI.php';
require_once SERVDIR . '/core/ProcessCoreWeb.php';

//require_once SERVDIR . '/core/simple_html_dom.php';

// Create cutenews caches
$_CN_SESS_CACHE = array();
/*
$_CN_cache_block_id = array();
$_CN_cache_block_dt = array();
*/
// Define ALL privileges and behaviors
$_CN_access = array(
    // configs
    'C' => 'Cd,Cvm,Csc,Cp,Cc,Ct,Ciw,Cmm,Cum,Cg,Cb,Ca,Cbi,Caf,Crw,Csl,Cwp,Cmt,Cpc,Can,Cvn,Ccv,Cen,Clc,Csr,Com',
    // news
    'N' => 'Nes,Neg,Nea,Nvs,Nvg,Nva,Nua,Nud,Ncd',
    // comments
    'M' => 'Mes,Meg,Mea,Mds,Mdg,Mda,Mac',
    // behavior
    'B' => 'Bd,Bs',
);

$coreWeb = new ProcessCoreWeb();
// v2.0 init sections
// set default
$is_config = $coreWeb->cn_config_load();
// get url
$coreWeb->cn_parse_url();
$coreWeb->cn_detect_user_ip();
// load session_start
$coreWeb->cn_load_session();
$coreWeb->cn_relocation_db_new();
// connect to forum
//cn_connect_forum();

// 2.0.3 checking existing configuration
if ($is_config) {
    cn_lang_init(ROOT);
    //cn_load_plugins();
//cn_online_counter();
}

//db_installed_check();

// load modules
include SERVDIR . '/core/modules/init.php';
//hook('init/finally');
