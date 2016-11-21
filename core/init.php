<?php
ob_start();

define('DEV_DEBUG', false); // for visual detect errors
if (DEV_DEBUG){
    ini_set('display_errors', '1');
    error_reporting(E_ALL | E_STRICT);
} else {
    error_reporting(E_ALL ^ E_NOTICE);
}


// definitions
define('BQN_MU', microtime(true));
///define('EXEC_TIME ',     microtime(true));
define('VERSION', '2.0.3');
define('VERSION_ID', 203);
define('VERSION_NAME', 'News v.' . VERSION . 'c');

define('SERVDIR', dirname(dirname(__FILE__)));
define('ROOT', dirname(dirname(__FILE__)));
define('MODULE_DIR', SERVDIR . '/core/modules'); // nhan xu li
define('SKIN', SERVDIR . '/cdata'); // chua html
define('MODULE_ADM', SERVDIR . '/admin'); // chua ADMIN
define('CN_DEBUG', FALSE);
define('URL_PATH', dirname($_SERVER['SCRIPT_NAME']));  //custom by bqn
define('URL_PATH_IMG', '/images');  //custom by bqn
//define('URL_PATH_IMG', dirname($_SERVER['SCRIPT_NAME']) . '/images');  //custom by bqn
define('PHP_SELF', $_SERVER["SCRIPT_NAME"]);

// include necessary libs
require_once ROOT . '/core/function/libgarena.php';
require_once SERVDIR . '/core/cn_core_web.php'; //libs
require_once SERVDIR . '/core/security.php';
require_once SERVDIR . '/core/db/flat_web.php';
//require_once MODULE_ADM . '/core/captcha/phptextClass.php';


//echo '$_SERVER[PHP_SELF] ->in init: ' . $_SERVER['PHP_SELF'] . '<br />';
//echo 'Dirname($_SERVER[PHP_SELF] -> in init: ' . dirname($_SERVER['PHP_SELF']) . '<br>';


//echo 'ROOT: '. ROOT .'<br>';
//echo 'SERVDIR: '. MODULE_ADM .'<br>';
/*
 * echo 'SKIN: '. SKIN .'<br>';
echo "URLS: ". URL_PATH. "<br>";
echo "BQN_MU: ". BQN_MU. "<br>";
echo "00000000000\$_SERVER['SCRIPT_NAME']00000000000000000000: ". $_SERVER['SCRIPT_NAME']. "<br>";
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
    'C' => 'Cd,Cvm,Csc,Cp,Cc,Ct,Ciw,Cmm,Cum,Cg,Cb,Ca,Cbi,Caf,Crw,Csl,Cwp,Cmt,Cpc,Can,Cvn,Ccv,Cen,Clc,Csr,Com',
    // news
    'N' => 'Nes,Neg,Nea,Nvs,Nvg,Nva,Nua,Nud,Ncd',
    // comments
    'M' => 'Mes,Meg,Mea,Mds,Mdg,Mda,Mac',
    // behavior
    'B' => 'Bd,Bs',
);

// v2.0 init sections
//$is_config = cn_config_load();
cn_config_load();                //set default......
/*
cn_lang_init();
cn_db_init(); //database
*/


cn_parse_url(); // get url
cn_detect_user_ip();
cn_load_session(); //load session_start
cn_relocation_db_new();
// 2.0.3 checking existing configuration
//if ($is_config)
{
    //cn_load_plugins();
    //cn_online_counter();
}

//db_installed_check();

//

// load modules
include SERVDIR . '/core/modules/init.php';

//hook('init/finally');
