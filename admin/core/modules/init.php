<?php if (!defined('BQN_MU')) die('Access restricted');

$_module = REQ('mod', 'GPG');

// Loading all modules (internal + external)
$_init_modules = hook(
    'modules/init_modules',
    array(
        'editconfig' => array('path' => 'mu_board', 'acl' => 'Cd'),
        //'character'   	=> array('path' => 'mu_character',		'acl' => 'cc'),
        'cashshop' => array('path' => 'mu_cashshop', 'acl' => 'Can'),
        'logout' => array('path' => 'logout', 'acl' => ''),
    )
);

// Required module not exist
if (!isset($_init_modules[$_module])) {
    // external module chk
    $_module = hook('modules/init', 'editconfig', $_module);
}

// Check restrictions, if user is authorized
if (($user = member_get()) && defined('AREA') && AREA == 'ADMIN') {
    if (test($_init_modules[$_module]['acl'])) {
        // Request module
        $_mod_cfg = $_init_modules[$_module];
        if (file_exists($callPath = MODULE_DIR . '/' . $_mod_cfg['path'] . '.php')) {
            include $callPath;
        }
    } else {
        if ($user['acl'] == ACL_LEVEL_BANNED) {
            global $_SESS;
            $_SESSION = array();
        }
        msg_info('Section [' . cn_htmlspecialchars($_module) . '] disabled for you', PHP_SELF);
    }
}
