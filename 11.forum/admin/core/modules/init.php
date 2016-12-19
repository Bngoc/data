<?php

if (!defined('BQN_MU')) die('Access restricted');

// Loading filters
require_once SERVDIR . '/core/modules/hooks/common.php';

// Require module -----
$_module = REQ('mod', 'GPG');

print " _module: " . $_module . "<br>";

// Loading all modules (internal + external)
$_init_modules = hook('modules/init_modules', array
(
    'editconfig'      => array('path' => 'dashboard',		'acl' => 'Cd'),
    'editcatagoris'   => array('path' => 'editconfig&opt=category',	'acl' => 'cc'),
    'editforums'  => array('path' => 'forums',	'acl' => 'cc'),
	'addnews'   => array('path' => 'add_news',  'acl' => 'Can'),
    'editnews'  => array('path' => 'edit_news',	'acl' => 'Cvn'),
    'editcomment'  => array('path' => 'comments', 'acl' => 'com'),
    'media'     => array('path' => 'media',     'acl' => 'Cmm'),
    'maint'     => array('path' => 'maint',     'acl' => 'Cmt'),
	'help'      => array('path' => 'help',      'acl' => ''),
    'logout'    => array('path' => 'logout',    'acl' => ''),
));

// Required module not exist
if (!isset($_init_modules[$_module]))
{
    // external module chk
    $_module = hook('modules/init', 'editconfig', $_module);//exit();
}

print "F_init 34 mod_cfg: " . $_module . "<br>"; //exit();
print "F_init 35 mod_cfg: " . $_init_modules[$_module]['acl'] . "<br>"; //exit();

// Check restrictions, if user is authorized
if (($user=member_get()) && defined('AREA') && AREA == 'ADMIN')
{
    if (test($_init_modules[$_module]['acl']))
    {
        // Request module
        $_mod_cfg = $_init_modules[$_module];
		foreach($_mod_cfg as $g =>$k)
		{
			print "F_init 39 mod_cfg: $g => " . $k . "<br>";
		}
		
        include MODULE_DIR . '/'. $_mod_cfg['path'] . '.php';
    }
    
	else
    {        
        //check user for ban group        
        if($user['acl']==ACL_LEVEL_BANNED)
        {
            global $_SESS;
            $_SESSION=array();        
        }
		//include SERVDIR . '/skins/default.skin.php';
        msg_info('Section ['.cn_htmlspecialchars($_module).'] disabled for you', PHP_SELF);        
    } 
	
}
