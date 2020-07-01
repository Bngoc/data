<?php

define('AREA', "ADMIN");
define('BQN_MU', microtime(true));
define('SERVDIR', dirname(dirname(__FILE__)));
define('ROOT', dirname(dirname(__FILE__)));
define('MODULE_DIR', SERVDIR . '/core/modules'); // nhan xu li
define('SKIN', SERVDIR . '/cdata'); // chua html
define('MODULE_ADM', SERVDIR . '/admin'); // chua ADMIN
define('CN_DEBUG', false);
define('URL_PATH', (isset($_SERVER['HTTPS']) ? "https" : "http") . '://' . dirname($_SERVER['SCRIPT_NAME']));  //custom by bqn
//define('URL_RESULR_DE', 'http://ketqua.net/');


require_once ROOT . '/core/function/libgarena.php';
require_once SERVDIR . '/core/cn_core_web.php'; //libs
require_once SERVDIR . '/core/db/flat_web.php';

cn_config_load();
cn_relocation_db_new();
// Call Excuete update Result De with Task scheduler
cn_ResultDe();
