<?php if (!defined('BQN_MU')) {
    die('Access restricted');
}

// ACL: basic access control level
define('ACL_LEVEL_ADMIN', 1);
define('ACL_LEVEL_EDITOR', 2);
define('ACL_LEVEL_JOURNALIST', 3);
define('ACL_LEVEL_COMMENTER', 4);
define('ACL_LEVEL_BANNED', 5);

// Define of system
define('DELEGATE_OFFLINE_START', 0);
define('DELEGATE_OFFLINE_STOP', 1);

define('PK_LEVEL_SUPER_HERO', 1);
define('PK_LEVEL_HERO', 2);
define('PK_LEVEL_NORMAL', 3);
define('PK_LEVEL_ASSASSIN_0', 4);
define('PK_LEVEL_ASSASSIN_1', 5);
define('PK_LEVEL_ASSASSIN_2', 6);


define('PK_CTL_CODE_NORMAL', 0);
define('PK_CTL_CODE_BLOCK', 1);
define('PK_CTL_CODE_GAME_MASTER_8', 8);
define('PK_CTL_CODE_GAME_MASTER_32', 32);
define('PK_CTL_CODE_BLOCK_ITEMS', 18);
