<?php if (!defined('BQN_MU')) die('Access restricted');

// Loading filters
//require_once SERVDIR . '/core/modules/hooks/common.php';

$_module = REQ('mod', 'GPG');

// Loading all modules (internal + external)
$_init_modules = hook('modules/init_modules', array
(
    'home' => array('path' => 'home', 'acl' => ''),
    'guide' => array('path' => '_guide', 'acl' => ''),

    //'screenshots' => array('path' => '_screenshots', 'acl' => ''),
//    'information' => array('path' => '_information', 'acl' => ''),
    'manager_account' => array('path' => '_account', 'acl' => 'Can'),
    'char_manager' => array('path' => '_dashboard', 'acl' => 'Cd'),
    'cash_shop' => array('path' => '_cashshop', 'acl' => 'Can'),
    'relax' => array('path' => '_relax', 'acl' => 'Cvn'),
    'blank_money' => array('path' => '_blank_money', 'acl' => 'Cd'),
    'ranking' => array('path' => '_ranking', 'acl' => 'Cd'),

    'event' => array('path' => '_event', 'acl' => 'Cd'),
    'auto_money' => array('path' => '_auto_money', 'acl' => ''),
    'transaction' => array('path' => '_transaction', 'acl' => 'Cc'),
    'help' => array('path' => 'help', 'acl' => ''),

    'logout' => array('path' => 'logout', 'acl' => '')
));

// Required module not exist
if (!isset($_init_modules[$_module])) {
    // external module chk
    $_module = hook('modules/init', 'home', $_module);
}


// Check restrictions, if user is authorized
//if (($user=member_get()) && defined('AREA') && AREA == 'ADMIN')
{
    if (empty($_init_modules[$_module]['acl'])) {
        // Request module
        $_mod_cfg = $_init_modules[$_module];

        //if ( !eregi( "[^a-zA-Z0-9_\$]", $_module ) ) {
        if (is_file(MODULE_DIR . '/' . $_mod_cfg['path'] . '.php')) include MODULE_DIR . '/' . $_mod_cfg['path'] . '.php';
        else include MODULE_DIR . '/default.php';
        //}
        //else include MODULE_DIR . '/home.php';

        //include MODULE_DIR . '/'. $_mod_cfg['path'] . '.php';
    } else {
        if (test($_init_modules[$_module]['acl'])) {
            // Request module
            $_mod_cfg = $_init_modules[$_module];


            //if ( !eregi( "[^a-zA-Z0-9_\$]", $_module ) ) {
            if (is_file(MODULE_DIR . '/' . $_mod_cfg['path'] . '.php')) include MODULE_DIR . '/' . $_mod_cfg['path'] . '.php';
            else include MODULE_DIR . '/default.php';
            //}
            //else include MODULE_DIR . '/home.php';

            //include MODULE_DIR . '/'. $_mod_cfg['path'] . '.php';
        } else {
            //check user for ban group
            //if($user['acl']==ACL_LEVEL_BANNED)
            {
                global $_SESS;
                $_SESSION = array();
            }
            msg_info('Section <font color="blue">[' . cn_htmlspecialchars($_module) . '] </font> disabled for you<br><i>Please come back later.</i>', PHP_SELF);
        }
    }
}
