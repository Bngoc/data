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

require_once ROOT . '/core/function/libgarena.php';
require_once SERVDIR . '/core/cn_core_web.php'; //libs
require_once SERVDIR . '/core/db/flat_web.php';

cn_config_load();
cn_relocation_db_new();
// Call Excuete update Ranking Top50 with Task scheduler
ranking_character_top();
// Call excute update point -10% and -5%
on_off_point_character();
