<?php if (!defined('BQN_MU')) {
    die('Access restricted');
}

$_module = REQ('mod', 'GPG');
$role_router_web = $config['role_router_web'];
// Loading all modules (internal + external)
$_init_modules = hook(
    'modules/init_modules',
    array(
        'home' => array('path' => 'home', 'acl' => $role_router_web['home']),
        'guide' => array('path' => '_guide', 'acl' => $role_router_web['guide']),
        'help' => array('path' => 'help', 'acl' => $role_router_web['help']),
        // 'screenshots' => array('path' => '_screenshots', 'acl' => $role_router_web['screenshots']),
        // 'information' => array('path' => '_information', 'acl' => $role_router_web['information']),
        'manager_account' => array('path' => '_account', 'acl' => $role_router_web['manager_account']),
        'char_manager' => array('path' => '_dashboard', 'acl' => $role_router_web['char_manager']),
        'cash_shop' => array('path' => '_cashshop', 'acl' => $role_router_web['cash_shop']),
        'relax' => array('path' => '_relax', 'acl' => $role_router_web['relax']),
        'bank_money' => array('path' => '_blank_money', 'acl' => $role_router_web['bank_money']),
        'ranking' => array('path' => '_ranking', 'acl' => $role_router_web['ranking']),
        'transaction' => array('path' => '_transaction', 'acl' => $role_router_web['transaction']),
        'download' => array('path' => '_download', 'acl' => $role_router_web['download']),

        'event' => array('path' => '_event', 'acl' => $role_router_web['event']),
        'auto_money' => array('path' => '_auto_money', 'acl' => $role_router_web['auto_money']),

        'logout' => array('path' => 'logout', 'acl' => $role_router_web['logout'])
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
