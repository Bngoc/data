<?php
/*
define('DEV_DEBUG', false); // for visual detect errors
if (DEV_DEBUG)
{
    ini_set('display_errors', '1');
    error_reporting(E_ALL | E_STRICT);
}
else 
{
    error_reporting(E_ALL ^ E_NOTICE);
}
*/

// definitions
//define('BQN_MU',     microtime(true));
///define('EXEC_TIME ',     microtime(true));
define('VERSION',       '2.0.3');
define('VERSION_ID',    203);
define('VERSION_NAME',  'CuteNews v.' . VERSION . 'c');

define('SERVDIR',       dirname(dirname(__FILE__).'.html'));
define('MODULE_DIR',    SERVDIR . '/core/modules'); // nhan xu li
define('SKIN',          SERVDIR . '/cdata'); // chua html
define('CN_DEBUG',      FALSE);

//define('URL_PATH', 		cn_path_uri());  //custom by bqn
define('URL_PATH', 	dirname($_SERVER['SCRIPT_NAME']));  //custom by bqn ===>root

// include necessary libs
//require_once SERVDIR . '/core/core.php';
require_once SERVDIR . '/core/cn_url_modify.php'; //libs
require_once SERVDIR.'/core/config.php'; //load config
require_once SERVDIR . '/core/security.php';
require_once SERVDIR . '/core/news.php';
//require_once SERVDIR . '/core/captcha/captcha.php';

echo '$_SERVER[PHP_SELF]init: ' . $_SERVER['PHP_SELF'] . '<br />';
echo 'Dirname($_SERVER[PHP_SELF]init: ' . dirname($_SERVER['PHP_SELF']) . '<br>';

echo 'ROOT: '. ROOT .'<br>';
echo 'SERVDIR: '. SERVDIR .'<br>';
echo 'SKIN: '. SKIN .'<br>';
echo "URLS: ". URL_PATH. "<br>";
echo "BQN_MU: ". BQN_MU. "<br>";
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
$_CN_SESS_CACHE     = array();
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
$is_config = cn_config_load();

cn_lang_init();
cn_db_init(); //database
cn_rewrite_load(); //??

cn_parse_url();
cn_detect_user_ip();
cn_load_session(); //load session_start


// 2.0.3 checking existing configuration
if ($is_config)
{    
    //cn_load_plugins();
    cn_online_counter();
}

db_installed_check();

// load modules
include SERVDIR.'/core/modules/init.php';

//hook('init/finally');
