<?php if (!defined('BQN_MU')) die('Access restricted');

$_module = REQ('mod', 'GPG');
// Loading all modules (internal + external)
$_init_modules = hook('modules/init_modules',
    array(
        'home' => array('path' => 'home', 'acl' => ''),
        'guide' => array('path' => '_guide', 'acl' => ''),

        // 'screenshots' => array('path' => '_screenshots', 'acl' => ''),
        // 'information' => array('path' => '_information', 'acl' => ''),
        'manager_account' => array('path' => '_account', 'acl' => 'Can'),
        'char_manager' => array('path' => '_dashboard', 'acl' => 'Cd'),
        'cash_shop' => array('path' => '_cashshop', 'acl' => 'Cd'),
        'relax' => array('path' => '_relax', 'acl' => 'Cd'),
        'blank_money' => array('path' => '_blank_money', 'acl' => 'Cd'),
        'ranking' => array('path' => '_ranking', 'acl' => 'Cd'),
        'transaction' => array('path' => '_transaction', 'acl' => 'Can'),
        'download' => array('path' => '_download', 'acl' => ''),

        'event' => array('path' => '_event', 'acl' => 'Cd'),
        'auto_money' => array('path' => '_auto_money', 'acl' => ''),
        'help' => array('path' => 'help', 'acl' => ''),

        'logout' => array('path' => 'logout', 'acl' => '')
    )
);

// Required module not exist
if (!isset($_init_modules[$_module])) {
    // external module chk
    $_module = hook('modules/init', 'home', $_module);
}


// Check restrictions, if user is authorized
if (empty($_init_modules[$_module]['acl'])) {
    // Request module
    $_mod_cfg = $_init_modules[$_module];

    if (is_file(MODULE_DIR . '/' . $_mod_cfg['path'] . '.php')) {
        include MODULE_DIR . '/' . $_mod_cfg['path'] . '.php';
    } else {
        include MODULE_DIR . '/default.php';
    }
} else {
    if (testRoleWeb($_init_modules[$_module]['acl'])) {
        // Request module
        $_mod_cfg = $_init_modules[$_module];

        if (is_file(MODULE_DIR . '/' . $_mod_cfg['path'] . '.php')) {
            include MODULE_DIR . '/' . $_mod_cfg['path'] . '.php';
        } else {
            include MODULE_DIR . '/default.php';
        }
    } else {
        $user = getMemberWeb();
        // Check user for ban group
        if ($user['acl'] == ACL_LEVEL_BANNED) {
            global $_SESS;
            $_SESSION = array();
        }

        msg_info('Section <font color="blue">[' . cnHtmlSpecialChars($_module) . '] </font> disabled for you<br><i>Please come back later.</i>', PHP_SELF);
    }
}
