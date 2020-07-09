<?php

define('AREA', "ADMIN");
define('BQN_MU', microtime(true));

define('ROOT_CORN_JOB', dirname( dirname(dirname(__FILE__))));

define('URL_PATH', (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] != 'off' || $_SERVER['HTTPS'] == 1) ? "https" : "http") . '://' . dirname($_SERVER['SCRIPT_NAME']));
//define('URL_RESULR_DE', 'http://ketqua.net/');


require_once ROOT_CORN_JOB . '/Utils/functions/security.php';
require_once ROOT_CORN_JOB . '/Utils/functions/libgarena.php';
require_once ROOT_CORN_JOB . '/Utils/functions/initialization.php';
require_once ROOT_CORN_JOB . '/core/db/flat_web.php';


// Call Excuete update Result De with Task scheduler
run_schedule_cn_resultDe();
