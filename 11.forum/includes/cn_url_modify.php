<?php if (!defined('BQN_MU')) { die('Access restricted'); }
	function cn_url_modify()
	{
		global $PHP_SELF;
		$GET = $_GET;    
		$args = func_get_args();
		$SN   = $PHP_SELF;

		// add new params
		foreach ($args as $ks)
		{
			// 1) Control
			if (is_array($ks))
			{
				foreach ($ks as $vs)
				{
					$id=$val='';
					
					if(strpos($vs, '=')!==FALSE)
					{
						list($id, $var) = explode('=', $vs, 2);
					}
					else
					{
						$id=$vs;
					}
					if ($id == 'self') 
					{
						$SN = $var;
					}
					elseif ($id == 'reset') 
					{
						$GET = array();
					}
					elseif ($id == 'group') 
					{
						foreach ($vs as $a => $b) 
						{
							$GET[$a] = $b;
						}
					}
				}
			}
			// 2) Subtract
			elseif (strpos($ks, '=') === FALSE)
			{
				$keys = explode(',', $ks);

				foreach ($keys as $key)
				{
					$key = trim($key);
					if (isset($GET[$key])) 
					{
						unset($GET[$key]);
					}
				}
			}
			// 3) Add
			else
			{
				list($k, $v) = explode('=', $ks, 2);

				$GET[$k] = $v;
				if ($v === '') 
				{
					unset($GET[$k]);
				}
			}
		}

		return cn_pack_url($GET, $SN);
}

// Since 2.0: Pack only required parameters
function cn_pack_url($GET, $URL = PHP_SELF)
{
    $url = $result = array();

    foreach ($GET as $k => $v) if ($v !== '') $result[$k] = $v;
    foreach ($result as $k => $v) $url[] = "$k=".urlencode($v);

    list($ResURL) = hook('core/url_rewrite', array( $URL . ($url ? '?' . join('&', $url) : '' ), $URL, $GET ) );
    return $ResURL;
}

// Since 1.5.0: Cascade Hooks
function hook($hook, $args = null)
{
	
    global $_HOOKS;

    // Plugin hooks
    if (!empty($_HOOKS[$hook]) && is_array($_HOOKS[$hook]))
    {
        foreach ($_HOOKS[$hook] as $hookfunc)
        {
            if ($hookfunc[0] == '*')
            {
                 $_args = call_user_func_array(substr($hookfunc, 1), $args);
				 echo "---" . $_args; exit();
            }
            else 
            {
                $_args = call_user_func($hookfunc, $args);
            }

            if (!is_null($_args)) 
            {
                $args = $_args;
            }
        }
    }

    return $args;
}

// Since 2.0: Extended extract
function _GL($v)
{
    $vs = explode(',', $v);
    $result = array();
    foreach ($vs as $vc)
    {
        $el=explode(':', $vc, 2);
        $vc=isset($el[0])?$el[0]:false;
        $func = isset($el[1])?$el[1]:false;    
        $var=false;        
        if($vc) $var = isset($GLOBALS[trim($vc)])?$GLOBALS[trim($vc)]:false;
        if ($func) $var = call_user_func($func, $var);
        $result[] = $var;
    }

    return $result;
}

/*  ---------- Sanitize: get POST vars (default) --------
    POST [def] only POST
    GET only GET
    POSTGET -- or POST or GET
    GETPOST -- or GET or POST
    REQUEST -- from REQUEST
    COOKIES -- from COOKIES
    GLOB -- from GLOBALS
    + combination (comma separated)
*/

// Since 1.5.3
function GET($var, $method = 'GETPOST')
{
    $result = array();
    $vars   = spsep($var);
    $method = strtoupper($method);

    if ($method == 'GETPOST') 
    {
        $methods = array('GET','POST');
    }
    elseif ($method == 'POSTGET') 
    {
        $methods = array('POST','GET');
    }
    elseif ($method == 'GPG') 
    {
        $methods = array('POST','GET','GLOB');
    }
    else 
    {
        $methods = spsep($method);
    }

    foreach ( $vars as $var )
    {
        $var = trim($var);
        $value = null;

        foreach ($methods as $method)
        {
            if ($method == 'GLOB' && isset($GLOBALS[$var])) 
            {
                $value = $GLOBALS[$var];
            }
            elseif ($method == 'POST' && isset($_POST[$var])) 
            {
                $value = $_POST[$var];
            }
            elseif ($method == 'GET' && isset($_GET[$var])) 
            {
                $value = $_GET[$var];
            }
            elseif ($method == 'POSTGET')
            {
                if (isset($_POST[$var])) 
                {
                    $value = $_POST[$var];
                }
                elseif (isset($_GET[$var])) 
                {
                    $value = $_GET[$var];
                }
            }
            elseif ($method == 'GETPOST')
            {
                if (isset($_GET[$var]))
                {
                    $value = $_GET[$var];
                }
                elseif (isset($_POST[$var])) 
                {
                    $value = $_POST[$var];
                }
            }
            elseif ($method == 'REQUEST' && isset($_REQUEST[$var])) 
            {
                $value = $_REQUEST[$var];
            }
            elseif ($method == 'COOKIE' && isset($_COOKIE[$var])) 
            {
                $value = $_COOKIE[$var];
            }

            if (!is_null($value)) 
            {
                break;
            }
        }

        $result[] = $value;
    }
    return $result;
}

// Since 1.5.0
// Separate string to array: imporved "explode" function
function spsep($separated_string, $seps = ',')
{
    if (strlen($separated_string) == 0 ) 
    {
        return array();
    }
    $ss = explode($seps, $separated_string);
    return $ss;
}

// Since 2.0: convert all GET to hidden fields
function cn_snippet_get_hidden($ADD = array())
{
    $hid = '';
    $GET = $_GET + $ADD;
    foreach ($GET as $k => $v)
    {
        if ($v !== '')
        {
            $hid .= '<input type="hidden" name="'.cn_htmlspecialchars($k).'" value="'.cn_htmlspecialchars($v).'" />';
        }
    }
    
    return $hid;
}

// Since 2.0: Cutenews HtmlSpecialChars
function cn_htmlspecialchars($str)
{
    $key = array('&'=>'&amp;','"' => '&quot;', "'" => '&#039;', '<' => '&lt;', '>' => '&gt;');
    $matches=null;
    preg_match('/(&amp;)+?/', $str,$matches);
    if(count($matches)!=0) 
    {
        array_shift($key);
    }
    return str_replace(array_keys($key), array_values($key), $str);
}


// Since 2.0: Unpack cookie for ACP
function cn_cookie_unpack($cookie)
{
    $list = array();

    $cookies = explode(',', $cookie);
    foreach ($cookies as $c)
    {
        $c = trim($c);
        if (isset($_COOKIE[$c]))
        {
            $list[] = unserialize( base64_decode($_COOKIE[$c]) );
        }
        else
        {
            $list[] = array();
        }
    }

    return $list;
}

// Since 2.0: Pack cookie for ACP
function cn_cookie_pack()
{
    $args   = func_get_args();
    $cookie = array_shift($args);

    $cookies = explode(',', $cookie);
	//print "bqn cooki " . $cookie . "<br>";
    foreach ($cookies as $id => $cookie)
    {
		print "bqn cooki " . $cookie . "<br>";
		print "bqn cooki id " . $id . "<br>";
        $cookie = trim($cookie);
        if ($args[$id])
        {
			
            $data = base64_encode( serialize($args[$id]) ); 
        }
        else
        {
            $data = null;
        }
		print "bqn cooki of data " . $data . "<br>";
        setcookie($cookie, $data);
    }
}

/*
// Since 2.0: Test category accessible for current user
function test_cat($cat)
{
    $user = member_get();
    $grp = getoption('#grp');

    if (!$user) return FALSE;

    // Get from cache
    if ($cc = mcache_get('#categories'))
        $catgl = $cc;
    else
    {
        $catgl = getoption('#category');
        mcache_set('#categories', $catgl);
    }

    // View all category
    if (test('Ccv'))
        return TRUE;

    $acl = $user['acl'];
    $cat = spsep($cat) ;

    // Overall ACL test, with groups + own
    $acl = array_unique(array_merge(array($acl), spsep($grp[$acl]['G'])));

    foreach ($cat as $ct)
    {
        // Requested cat not exists, skip
        if (!isset($catgl[$ct])) continue;

        // Group list included (partially/fully) in group list for category
        $sp = spsep($catgl[$ct]['acl']);
        $is = array_intersect($sp, $acl);
        if (!$is) return FALSE;
    }

    return TRUE;
}

// Since 2.0: Get option from #CFG or [%site][<opt_name>]
// Usage: #level1/level2/.../levelN or 'option_name' from %site
function getoption($opt_name = '')
{
    $cfg = mcache_get('config');

    if ($opt_name === '')
    {
        return $cfg;
    }
    if ($opt_name[0] == '#')
    {
        $cfn = spsep(substr($opt_name, 1), '/');
        foreach ($cfn as $id)
        {
            if (isset($cfg[$id])) 
            {
                $cfg = $cfg[$id];
            }
            else
            {
                $cfg = array();
                break;
            }
        }

        return $cfg;
    }
    else
    {
        return isset($cfg['%site'][$opt_name]) ? $cfg['%site'][$opt_name] : FALSE;
    }
}

// Since 1.5.3: Get variable from cache
function mcache_get($name)
{
    global $_CN_SESS_CACHE;
    return isset($_CN_SESS_CACHE[$name]) ? $_CN_SESS_CACHE[$name] : FALSE;
}
*/

// Since 2.0: Extended assign
function cn_assign()
{
    $args = func_get_args();
    $keys = explode(',', array_shift($args));

    foreach ($args as $id => $arg)
    {
        // Simple assign
        if (isset($keys[$id]))
        {
            $KEY = trim($keys[$id]);
            $GLOBALS[ $KEY ] = $arg;
        }
        else // Inline assign
        {
            list($k, $v) = explode('=', $arg, 2);
            $GLOBALS[$k] = $v;
        }
    }
}


// Since 2.0: Execute PHP-template
// 1st argument - template name, other - variables ==> mo file
function exec_tpl() 
{
    $args = func_get_args();
    $tpl  = preg_replace('/[^a-z0-9_\/]/i', '', array_shift($args));
    $open = SKIN.'/'.($tpl?$tpl:'default').'.php';

    foreach ($args as $arg)
    {
        if (is_array($arg))
        {
            foreach ($arg as $k0 => $v) 
            { 
                $k = "__$k0"; 
                $$k = $v;                 
            }
        }
        else
        {
            list($k, $v) = explode('=', $arg, 2);

            // <-- make local variable
            $k = "__$k";
            $$k = $v;
        }
    }

    if (file_exists($open))
    {        
        ob_start(); include $open; $echo = ob_get_clean();
        return $echo;
    }

    return '';
}


// Since 1.5.0: Add hook to system
function add_hook($hook, $func)
{
    global $_HOOKS;

    $prior = 1;
    if ($hook[0] == '+') $hook = substr($hook, 1);
    if ($hook[0] == '-')
    {
        $prior = 0;
        $hook = substr($hook, 1);
    }

    if (!isset($_HOOKS[$hook])) $_HOOKS[$hook] = array();

    // priority (+/-)
    if ($prior) array_unshift($_HOOKS[$hook], $func); else $_HOOKS[$hook][] = $func;
}


// Since 2.0: @bootstrap Make & load configuration file ==> chua goi
function cn_config_load()  
{
    global $_CN_access;
    //checking permission for load config 
    $conf_dir=cn_path_construct(SERVDIR,'cdata');
    if(!is_dir($conf_dir)||!is_writable($conf_dir))
    {
        return false;
    }
                    
    $conf_path=cn_path_construct(SERVDIR,'cdata').'conf.php';
    $cfg = cn_touch_get($conf_path);
    if(!$cfg) 
    {
        if(defined('SHOW_NEWS'))
        {
            echo 'Sorry, but news not available by technical reason.';
            die();
        }
        else
        {
            //echo 'Need convert data - run migration_update_data.php';
            $cfg=  cn_touch_get($conf_path, true);
            
        }
    }
    // make site section
    $cfg['%site'] = isset($cfg['%site']) ? $cfg['%site'] : array();

    $default_conf = array
    (
        'skin'                          => 'default',
        'frontend_encoding'             => 'UTF-8',
        'useutf8'                       => 1,
        'utf8html'                      => 1,
        'wysiwyg'                       => 0,
        'news_title_max_long'           => 100,
        'date_adjust'                   => 0,
        'smilies'                       => 'smile,wink,wassat,tongue,laughing,sad,angry,crying',
        'allow_registration'            => 1,
        'registration_level'            => 4,
        'ban_attempts'                  => 3,
        'allowed_extensions'            => 'gif,jpg,png,bmp,jpe,jpeg',
        'reverse_active'                => 0,
        'full_popup'                    => 0,
        'full_popup_string'             => 'HEIGHT=400,WIDTH=650,resizable=yes,scrollbars=yes',
        'show_comments_with_full'       => 1,
        'timestamp_active'              => 'd M Y',
        'use_captcha'                   => 1,
        'reverse_c  omments'            => 0,
        'flood_time'                    => 15,
        'comments_std_show'             => 1,
        'comment_max_long'              => 1500,
        'comments_per_page'             => 5,
        'only_registered_comment'       => 0,
        'allow_url_instead_mail'        => 1,
        'comments_popup'                => 0,
        'comments_popup_string'         => 'HEIGHT=400,WIDTH=650,resizable=yes,scrollbars=yes',
        'show_full_with_comments'       => 1,
        'timestamp_comment'             => 'd M Y h:i a',
        'mon_list'                      => 'January,February,March,April,May,June,July,August,September,October,November,December',
        'week_list'                     => 'Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
        'active_news_def'               => 20,
        'thumbnail_with_upload'         => 0,
        'max_thumbnail_width'            => 256,
        'auto_news_alias'               =>0,                    
        // 'phpself_full'                  => '',
        // 'phpself_popup'                 => '',
        // 'phpself_paginate'              => '',

        // Notifications
        'notify_registration'           => 0,
        'notify_comment'                => 0,
        'notify_unapproved'             => 0,
        'notify_archive'                => 0,
        'notify_postponed'              => 0,

        // Social buttons
        'i18n'                          => 'en_US',
        'gplus_width'                   => 350,
        'fb_comments'                   => 3,
        'fb_box_width'                  => 550,

        // CKEditor settings
        'ck_ln1'                        => "Source,Maximize,Scayt,PasteText,Undo,Redo,Find,Replace,-,SelectAll,RemoveFormat,NumberedList,BulletedList,Outdent,Indent",
        'ck_ln2'                        => "Image,Table,HorizontalRule,Smiley",
        'ck_ln3'                        => "Link,Unlink,Anchor",
        'ck_ln4'                        => "Format,FontSize,TextColor,BGColor",
        'ck_ln5'                        => "Bold,Italic,Underline,Strike,Blockquote",
        'ck_ln6'                        => "JustifyLeft,JustifyCenter,JustifyRight,JustifyBlock",
        'ck_ln7'                        => "",
        'ck_ln8'                        => "",

        // Rewrite
        'rw_htaccess'                   => '',
        'rw_prefix'                     => '/news/',
    );

    // Set default values
    foreach ($default_conf as $k => $v) 
    {
        if (!isset($cfg['%site'][$k])) 
        {
            $cfg['%site'][$k] = $v;
        }
    }

    // Set basic groups
    if (!isset($cfg['grp'])) 
    {
        $cfg['grp'] = array();
    }

    // Make default groups
    $cgrp = file(cn_path_construct(SKIN,'defaults').'groups.tpl');
    foreach ($cgrp as $G)
    {
        $G = trim($G);
        if ($G[0] === '#') 
        {
            continue;
        }

        list($id, $name, $group, $access) = explode('|', $G);
        $id = intval($id);

        // Is empty row
        if (empty($cfg['grp'][$id]))
        {
            $cfg['grp'][$id] = array
            (
                'N' => $name,
                'G' => $group,
                '#' => TRUE,
                'A' => ($access === '*') ? $_CN_access['C'].','.$_CN_access['N'].','.$_CN_access['M'] : $access,
            );
        }
    }

    // Admin has ALL privilegies
    $cfg['grp'][1]['A'] = $_CN_access['C'].','.$_CN_access['N'].','.$_CN_access['M'];
    
    // Set config
    mcache_set('config', $cfg);

    // Make crypt-salt [after config sync]
    if (!getoption('#crypt_salt'))
    {
        $salt = SHA256_hash(mt_rand().mt_rand().mt_rand().mt_rand().mt_rand().mt_rand().mt_rand().mt_rand());
        setoption("#crypt_salt", $salt);
    }

    if (!getoption('#grp'))
    {
        setoption("#grp", $cfg['grp']);
    }
    
    return TRUE;
}




?>