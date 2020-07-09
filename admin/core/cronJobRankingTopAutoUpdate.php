<?php

define('AREA', "ADMIN");
define('BQN_MU', microtime(true));
define('ROOT_CORN_JOB', dirname( dirname(dirname(__FILE__))));

require_once ROOT_CORN_JOB . '/Utils/functions/security.php';
require_once ROOT_CORN_JOB . '/Utils/functions/libgarena.php';
require_once ROOT_CORN_JOB . '/Utils/functions/initialization.php';
require_once ROOT_CORN_JOB . '/core/db/flat_web.php';

// Call Excuete update Ranking Top50 with Task scheduler
run_schedule_ranking_character_top();
// Call excute update point -10% and -5%
run_schedule_on_off_point_character();
