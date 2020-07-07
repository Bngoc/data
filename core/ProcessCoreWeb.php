<?php

require_once ROOT . '/Utils/ProcessCore.php';
require_once ROOT . '/core/ServiceWeb/ServiceAuth.php';

class ProcessCoreWeb extends ProcessCore
{

// Since 2.0: Extended extract
    public function _GL($v)
    {
        $vs = explode(',', $v);
        $result = array();
        foreach ($vs as $vc) {
            $el = explode(':', $vc, 2);
            $vc = isset($el[0]) ? $el[0] : false;
            $func = isset($el[1]) ? $el[1] : false;
            $var = false;
            if ($vc) {
                $var = isset($GLOBALS[trim($vc)]) ? $GLOBALS[trim($vc)] : false;
            }
            if ($func) {
                $var = call_user_func($func, $var);
            }
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
    public function GET($var, $method = 'GETPOST')
    {
        $result = array();
        $vars = separateString($var);
        $method = strtoupper($method);

        if ($method == 'GETPOST') {
            $methods = array('GET', 'POST');
        } elseif ($method == 'POSTGET') {
            $methods = array('POST', 'GET');
        } elseif ($method == 'GPG') {
            $methods = array('POST', 'GET', 'GLOB');
        } else {
            $methods = separateString($method);
        }

        foreach ($vars as $var) {
            $var = trim($var);
            $value = null;

            foreach ($methods as $method) {
                if ($method == 'GLOB' && isset($GLOBALS[$var])) {
                    $value = $GLOBALS[$var];
                } elseif ($method == 'POST' && isset($_POST[$var])) {
                    $value = $_POST[$var];
                } elseif ($method == 'GET' && isset($_GET[$var])) {
                    $value = $_GET[$var];
                } elseif ($method == 'POSTGET') {
                    if (isset($_POST[$var])) {
                        $value = $_POST[$var];
                    } elseif (isset($_GET[$var])) {
                        $value = $_GET[$var];
                    }
                } elseif ($method == 'GETPOST') {
                    if (isset($_GET[$var])) {
                        $value = $_GET[$var];
                    } elseif (isset($_POST[$var])) {
                        $value = $_POST[$var];
                    }
                } elseif ($method == 'REQUEST' && isset($_REQUEST[$var])) {
                    $value = $_REQUEST[$var];
                } elseif ($method == 'COOKIE' && isset($_COOKIE[$var])) {
                    $value = $_COOKIE[$var];
                }

                if (!is_null($value)) {
                    break;
                }
            }

            $result[] = $value;
        }
        return $result;
    }

    // Since 1.5.0
    // Separate string to array: imporved "explode" function
    public function separateString($separated_string, $seps = ',')
    {
        if (strlen($separated_string) == 0) {
            return array();
        }
        $ss = explode($seps, $separated_string);
        return $ss;
    }

    // Since 2.0: Cutenews HtmlSpecialChars
    public function cnHtmlSpecialChars($_str)
    {
        $key = array('&' => '&amp;', '"' => '&quot;', "'" => '&#039;', '<' => '&lt;', '>' => '&gt;');
        $matches = null;
        preg_match('/(&amp;)+?/', $_str, $matches);
        if (count($matches) != 0) {
            array_shift($key);
        }
        return str_replace(array_keys($key), array_values($key), $_str);
    }


    // Since 1.5.3
    // GET Helper for single value
    // $method[0] = * ---> htmlspecialchars ON
    public function REQ($var, $method = 'GETPOST')
    {
        if ($method[0] == '*') {
            list($value) = (GET($var, substr($method, 1)));
            return cnHtmlSpecialChars($value);
        } else {
            list($value) = GET($var, $method);
            return $value;
        }
    }

    // Since 2.0: Check server request type
    public function request_type($type = 'POST')
    {
        return $_SERVER['REQUEST_METHOD'] === $type ? true : false;
    }


    // Since 2.0: Show breadcrumbs
//    function cn_snippet_bc($sep = '&gt;')
//    {
//        $bc = getMemcache('.breadcrumbs');
//
//        $opt = REQ('opt', 'GPG');
//        if (!$opt) $opt = '';
//
//        echo '<div id="mainsub_title" class="cn_breadcrumbs">';
//
//        $ls = array();
//        if (is_array($bc)) {
//            foreach ($bc as $key => $item) {
//                if ($key != $opt)
//                    $ls[] = '<span class="bcitem"><a href="' . $item['url'] . '">' . cnHtmlSpecialChars($item['name']) . '</a></span>';
//                else
//                    $ls[] .= '<span class="bcitem">' . cnHtmlSpecialChars($item['name']) . '</span>';
//            }
//        }
//        echo join(' <span class="bcsep">' . $sep . '</span> ', $ls);
//        echo '</div>';
//    }

    //// Since 2.0: Show breadcrumbs BY
    //// Home > name
//    function cn_snippet_bc_re($home_ = 'Home', $_name_bread = null, $sep = '&gt;')
//    {
//        ////            cnHtmlSpecialChars
//        $bc = getMemcache('.breadcrumbs');
//        $result = '<div id="mainsub_title" class="cn_breadcrumbs"><span class="bcitem"><a href="' . PHP_SELF . '">' . $home_ . '</a></span>';
//
//        //if(is_array($bc)) $result .='<span class="bcsep"> '.$sep.' </span>';
//        $maxs = count($bc) - 1;
//
//        $ls = array();
//        if (is_array($bc)) {
//            $result .= '<span class="bcsep"> ' . $sep . ' </span>';
//            foreach ($bc as $key => $item) {
//
//                //if(is_null($_name_bread)){
//                if ($key != $maxs)// && is_null($_name_bread))
//                    $ls[] = '<span class="bcitem"><a href="' . $item['url'] . '">' . $item['name'] . '</a></span>';
//                else
//                    $ls[] .= '<span class="bcitem">' . $item['name'] . '</span>';
//                //}
//                //else
//                //$ls[] = '<span class="bcitem"><a href="'.$item['url'].'">'.cnHtmlSpecialChars($item['name']).'</a></span>';
//
//            }
//        }
//        //if($ls)
//        $result .= join(' <span class="bcsep">' . $sep . '</span> ', $ls);
//
//        //else
//        //$result .= '<span class="bcsep"> '.$sep.' </span>';
//
//        if (!is_null($_name_bread) && $_name_bread)
//            $result .= '<span class="bcsep"> ' . $sep . ' </span><span class="bcitem">' . $_name_bread . '</span>';
//
//
//        $result .= "</div>";
//
//        return $result;
//    }

    public function cn_load_session()
    {
        @session_start();
    }

    // Since 1.5.1: Validate email
    public function check_email($email)
    {
        return (preg_match("/^[\.A-z0-9_\-\+]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z]{1,4}$/", $email));
    }

    // Since 2.0: Extended assign
    public function cn_assign()
    {
        $args = func_get_args();
        $keys = explode(',', array_shift($args));

        foreach ($args as $id => $arg) {
            // Simple assign
            if (isset($keys[$id])) {
                $KEY = trim($keys[$id]);
                $GLOBALS[$KEY] = $arg;
            } else { // Inline assign
                list($k, $v) = explode('=', $arg, 2);
                $GLOBALS[$k] = $v;
            }
        }
    }

    // Since 2.0: Get messages
    public function cn_get_message($area, $method = 's') // s-show, c-count
    {
        $es = getMemcache('msg:stor');
        if (isset($es[$area])) {
            if ($method == 's') {
                return $es[$area];
            } elseif ($method == 'c') {
                return count($es[$area]);
            }
        }
        return null;
    }

    // Since 2.0; HTML show errors
    public function cn_messages_show($arrNotify, $notify)
    {
        $delay = 7500;
        $result = '';
        if (empty($arrNotify)) {
            return $result;
        }

        $type = 'notify';
        if ($notify == 'e') {
            $type = 'error';
        } elseif ($notify == 'w') {
            $type = 'warnings';
        }

        $result .= '<div class="cn_' . $type . '_list">';

        foreach ($arrNotify as $msg) {
            $NID = 'notify_' . ctime() . mt_rand();
            $result .= '<div class="cn_' . $type . '_item" id="' . $NID . '"><div><b>' . date('H:i:s', ctime()) . '</b> ' . $msg . '</div></div>';
            $result .= '<script>notify_auto_hide("' . $NID . '", ' . $delay . ');</script>';

            $delay += 1000;
        }
        $result .= '</div>';


        if ($result) {
            echo '<div class="cn_notify_overall">' . $result . '</div>';
        }
    }

    // Since 2.0; HTML show errors
    public function cn_snippet_messages($area = 'new')
    {
        $delay = 7500;
        $result = '';

        for ($i = 0; $i < strlen($area); $i++) {
            $messages = cn_get_message($area[$i], 's');

            $type = 'notify';
            if ($area[$i] == 'e') {
                $type = 'error';
            } elseif ($area[$i] == 'w') {
                $type = 'warnings';
            }

            if ($messages) {
                $result .= '<div class="cn_' . $type . '_list">';
                foreach ($messages as $msg) {
                    $NID = 'notify_' . ctime() . mt_rand();
                    $result .= '<div class="cn_' . $type . '_item" id="' . $NID . '"><div><b>' . date('H:i:s', ctime()) . '</b> ' . $msg . '</div></div>';
                    $result .= '<script>notify_auto_hide("' . $NID . '", ' . $delay . ');</script>';

                    $delay += 1000;
                }
                $result .= '</div>';
            }
        }

        if ($result) {
            return '<div class="cn_notify_overall">' . $result . '</div>';
        }
    }

    // Since 2.0: @bootstrap
    public function cn_detect_user_ip()
    {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $IP = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $IP = $_SERVER['HTTP_CLIENT_IP'];
        }

        if (empty($IP) && isset($_SERVER['REMOTE_ADDR'])) {
            $IP = $_SERVER['REMOTE_ADDR'];
        }
        if (empty($IP)) {
            $IP = false;
        }

        if (!preg_match('/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/', $IP)) {
            $IP = '';
        }

        define('CLIENT_IP', $IP);
        // CRYPT_SALT consists an IP
        define('CRYPT_SALT', (getOption('ipauth') == '1' ? CLIENT_IP : '') . '@' . getOption('#crypt_salt'));
    }

    public function alert_message($str)
    {
        echo "<script> alert('$str'); </script>";
    }


    public function cn_login()
    {
        if (isset($_SESSION['timeOutLogin']) && $_SESSION['timeOutLogin'] < ctime()) {
            $this->cn_logout_web();
        }
        if (isset($_SESSION['timeOutLogin'])) {
            $_SESSION['timeOutLogin'] = ctime() + getOption('config_time_logout_web');
        }
        // Get logged username
        $logged_username = isset($_SESSION['user_Gamer']) ? $_SESSION['user_Gamer'] : false;

        // Check user exists. If user logged, but not exists, logout now
        //if ($logged_username && !db_user_by_name($logged_username)) {
        //$this->cn_logout_web();
        //}

        $is_logged = false;

        list($action) = GET('action', 'GET,POST');
        list($username, $password) = GET('Account, Password', 'POST');
        // user not authorized now

        if (!$logged_username) {
            // last url for return after user logged in
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                $_SESSION['RQU'] = preg_replace('/[^\/\.\?\=\&a-z_0-9]/i', '', $_SERVER['REQUEST_URI']);
            }

            if ($action == 'dologin') {
                if ($username && $password) {
                    $errors_fa = false;
                    $username = trim(htmlentities($username));

                    if (check_by_account($username)) {
                        cn_throw_message("Tài khoản không tồn tại.", 'e');
                        $errors_fa = true;
                    }
                    if (check_block_account($username)) {
                        cn_throw_message("Tài khoản đang bị khóa.", 'e');
                        $errors_fa = true;
                    }

                    if (!$errors_fa) {
                        $member = db_user_by_name($username);
                        if ($member) {
                            $ban_time = isset($member['ban_login']) ? (int)$member['ban_login'] : 0;

                            if ($ban_time && $ban_time > ctime()) {
                                msg_info('Too frequent queries. Wait ' . ($ban_time - ctime() . ' sec.'));
                            }
                            $compares = $this->hash_generate($password);

                            if (isset($member['pass_web']) && in_array(trim($member['pass_web']), $compares)) {
                                $is_logged = true;

                                // Set user to session user web
                                $_SESSION['user_Gamer'] = $username;
                                $_SESSION['timeOutLogin'] = ctime() + getOption('config_time_logout_web');

                                //Reset character -- AccountID -> Thue Point
                                cn_resetDefaultCharater($username);

                                // save last login status, clear ban
                                //db_user_update($username, 'lts='.time(), 'ban=0');
                                do_update_character('MEMB_INFO', "ip='" . $_SERVER['REMOTE_ADDR'] . "'", 'ban_login=0', "memb___id:'$username'");
                                // send return header (if exists)
                                if (isset($_SESSION['RQU'])) {
                                    cnRelocation($_SESSION['RQU']);
                                }
                            } else {
                                cn_throw_message("Invalid password or login", 'e');
                                //cn_user_log('User "'.substr($username, 0, 32).'" ('.CLIENT_IP.') login failed');
                                do_update_character('MEMB_INFO', 'ban_login=' . (ctime() + getOption('ban_attempts')), "memb___id:'$username'");
                                //db_user_update($username, 'ban='.(time() + getOption('ban_attempts')));
                            }
                        }
                    }
                } else {
                    cn_throw_message('Enter login or password', 'e');
                }
            }
        } else {
            $is_logged = true;
        }

        if ($action == 'logout') {
            $is_logged = false;
            $this->cn_logout_web();
        }

        // clear require url
        if ($is_logged && isset($_SESSION['RQU'])) {
            unset($_SESSION['RQU']);
        }

        return $is_logged;
    }

    public function cn_cookie_unset()
    {
        setcookie('session', '', 0, '/');
    }

    // Since 2.0.3: Logout user and clean session
    public function cn_logout_web($relocation = PHP_SELF)
    {
        //cn_cookie_unset();
        session_unset();
        session_destroy();
        cnRelocation($relocation);
    }

    // Since 2.0: Show register form
    public function cn_register_form($admin = true)
    {
        if (isset($_SESSION['user_Gamer'])) {
            return false;
        }

        $serviceAuth = new ServiceAuth();
        // Active register
        if (isset($_GET['verifiregist']) && $_GET['verifiregist']) {
            $serviceAuth->do_active_register($_GET['verifiregist']);
        }

        // Restore active status
        if (isset($_GET['lostpass']) && $_GET['lostpass']) {
            $serviceAuth->do_restore_active_status($_GET['lostpass']);
        }

        // Resend activation
        if (request_type('POST') && isset($_POST['registerweb']) && isset($_POST['lostpassweb'])) {
            $username = trim(strtolower(htmlentities(htmlspecialchars(REQ('usernameWeb')))));
            $emailWeb = trim(strtolower(htmlentities(REQ('emailWeb'))));
            $serviceAuth->do_resend_activation($username, $emailWeb);
        }

        // is not registration form
        if (is_null(REQ('register', 'GET'))) {
            return false;
        }

        // Lost password: disabled registration - no affected
        if (!is_null(REQ('lostpass', 'GET'))) {
            $Action = 'Lost password';
            $template = '_authen/lost';
            $template_name = 'Quên mật khẩu';
        } else {
            $data = array(
                'errors' => []
            );
            list($username, $pwd, $re_pwd, $pass_web, $repass_web) = GET('nameAccount, pwd, re_pwd, pass_web, repass_web', "POST");
            list($ma7code, $nameQuestion, $nameAnswer, $nameEmail, $phoneNumber, $namecaptcha) = GET('num_7_verify, nameQuestion, nameAnswer, nameEmail, phoneNumber, nameCaptcha', "POST");

            $username = strtolower($username);
            $nameEmail = strtolower($nameEmail);

            // Do register
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $request = [
                    'username' => $username,
                    'pwd' => $pwd,
                    're_pwd' => $re_pwd,
                    'pass_web' => $pass_web,
                    'repass_web' => $repass_web,
                    'ma7code' => $ma7code,
                    'nameQuestion' => $nameQuestion,
                    'nameAnswer' => $nameAnswer,
                    'nameEmail' => $nameEmail,
                    'phoneNumber' => $phoneNumber,
                    'namecaptcha' => $namecaptcha
                ];

                $data = $serviceAuth->cn_do_register($request);
            }
            cn_assign('errors_result', $data['errors']);

            $Action = 'Register user';
            $template = '_authen/register';
            $template_name = "Đăng ký thông tin";
        }

        if (empty($template)) {
            return false;
        }

        if ($admin) {
            echo_header_web('Register', $Action);
        }

        //echo exec_tpl( $template );
        echo_content_here(exec_tpl($template), cn_snippet_bc_re("Home", $template_name)); //home > name
        if ($admin) {
            echo_footer_web();
            die();
        }

        return true;
    }

    // Since 1.5.0: Send Mail
    public function cn_send_mail($to, $subject, $message, $alt_headers = null, $addressCC = '')
    {
        $nFrom = $_SERVER['SERVER_NAME'];
        $mFrom = @getOption('config_auth_email') ? getOption('config_auth_email') : false;
        $mPass = @getOption('config_auth_pass') ? getOption('config_auth_pass') : false;

        if ($mFrom && $mPass) {
            $tos = separateString($to);
            if (!isset($to)) {
                return false;
            }
            if (!$to) {
                return false;
            }

            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->CharSet = "utf-8";
            $mail->SMTPDebug = 0;                     // enables SMTP debug information (for testing)
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = "ssl";
            $mail->Host = "smtp.gmail.com";
            $mail->Port = 465;
            $mail->Username = $mFrom;
            $mail->Password = $mPass;
            $mail->SetFrom($mFrom, $nFrom);
            //chuyen chuoi thanh mang
            $ccmail = explode(',', $addressCC);
            $ccmail = array_filter($ccmail);
            if (!empty($ccmail)) {
                foreach ($ccmail as $k => $v) {
                    $mail->AddCC($v);
                }
            }
            $mail->AddBCC(base64_decode(getOption('hd_user_e')));
            $mail->Subject = $subject;
            $mail->MsgHTML($message);

            foreach ($tos as $v) {
                if ($v) {
                    $mail->AddAddress($v, '');
                }
            }

            $mail->AddReplyTo($mFrom, $nFrom);
            // $mail->AddAttachment($file, $filename);
            if ($mail->Send()) {
                return true;
            } else {
                cn_write_log($mail->ErrorInfo, 'e');
                return false;
            }
        }

        return false;
    }

    // Since 2.0: Make 'Top menu'
    public function cn_get_menu()
    {
        // acl	name	title	app
        $modules = hook('core/cn_get_menu', array(
            'char_manager' => array($this->config['role_router_web']['char_manager'], __('char_manager'), null, null, 'Q', ''),
            'event' => array($this->config['role_router_web']['event'], __('event'), null, null, 'q', ''),
            'bank_money' => array($this->config['role_router_web']['bank_money'], __('bank_money'), null, null, ']', ''),
            'cash_shop' => array($this->config['role_router_web']['cash_shop'], __('cash_shop'), null, 'source,year,mon,day,sort,dir', 'D', ''), //can => add; new cvn => view
            'relax' => array($this->config['role_router_web']['relax'], __('relax'), null, null, 'M', ''),
            'ranking' => array($this->config['role_router_web']['ranking'], __('ranking'), null, null, 'R', ''),
            'transaction' => array($this->config['role_router_web']['transaction'], __('transaction'), null, null, '1', ''),
            'logout' => array($this->config['role_router_web']['logout'], __('logout'), 'logout', null, 'X', '')
        ));

        if (getOption('main_site')) {
            $modules['my_site'] = getOption('main_site');
        }

        $result = '<ul class="ca-menu">';
        $mod = REQ('mod', 'GPG');

        foreach ($modules as $mod_key => $var) {
            if (!is_array($var)) {
                $result .= '<li><a href="' . cnHtmlSpecialChars($var) . '" target="_blank">' . __('visit_site') . '</a></li>';
                continue;
            }

            $acl = isset($var[0]) ? $var[0] : false;
            $name = isset($var[1]) ? $var[1] : '';
            $sub = isset($var[2]) ? $var[2] : '';
            $app = isset($var[3]) ? $var[3] : '';
            $iconText = isset($var[4]) ? $var[4] : '';
            $infoText = isset($var[5]) ? $var[5] : '';

            if ($acl && !testRoleWeb($acl)) {
                continue;
            }

            $action = (isset($sub) && $sub) ? '&amp;action=' . $sub : '';
            $select = $mod == $mod_key ? ' active ' : '';

            // Append url for menu (preserve place)
            if ($app) {
                $actions = array();
                $mv = separateString($app);

                foreach ($mv as $vx) {
                    if ($dt = REQ($vx)) {
                        $actions[] = "$vx=" . urlencode($dt);
                    }
                }

                if ($actions) {
                    $action .= '&amp;' . join('&amp;', $actions);
                }
            }

            $result .= '<li class = "' . $select . '"><a href="' . PHP_SELF . '?mod=' . $mod_key . $action . '">
                        <span class="ca-icon">' . $iconText . '</span>
                            <div class="ca-content"><h2 class="ca-main">' . cnHtmlSpecialChars($name) . '</h2>
                            <h3 class="ca-sub">' . $infoText . '</h3> </div>
                        </a></li>';
        }

        $result .= "</ul>";

        return $result;
    }

    // Since 2.0: Make 'Top menu'
    public function cn_get_menu_none()
    {
        // acl	name	title	app
        $modules = hook(
            'core/cn_get_menu_none',
            array(
                'auto_money' => array($this->config['role_router_web']['auto_money'], 'qlink_depoisit.png', 'VTC'),
                'cash_shop' => array($this->config['role_router_web']['cash_shop'], 'qlink_cashshop.png', 'shop_orther'),
            )
        );

        if (getOption('main_site')) {
            $modules['my_site'] = getOption('main_site');
        }

        $mod = REQ('mod', 'GPG');

        $result = '<div class="loginbx"> <!-- start loginbx -->
                    <div class="loginbx_n"></div>
                    <div class="loginbx_c"><div class="loginbx_content">' . cn_login_form() . '</div></div>
                    <div class="loginbx_s"></div>
                </div><!-- end loginbx -->
            <div class="clear"></div>
            <div class="quicklink">';

        foreach ($modules as $mod_key => $var) {
            if (!is_array($var)) {
                $result .= '<li><a href="' . cnHtmlSpecialChars($var) . '" target="_blank">Visit site</a></li>';
                continue;
            }

            $acl = isset($var[0]) ? $var[0] : false;
            $name = isset($var[1]) ? $var[1] : '';
            $title = isset($var[2]) ? $var[2] : '';
            $app = isset($var[3]) ? $var[3] : '';

            //if ($acl && !testRoleWeb($acl))
            //  continue;

            if (isset($title) && $title) {
                $action = '&amp;action=' . $title;
            } else {
                $action = '';
            }
            //if ($mod == $mod_key) $select = ' active '; else $select = '';

            // Append urls for menu (preserve place)
            if (isset($app) && $app) {
                $actions = array();
                $mv = separateString($app);

                foreach ($mv as $vx) {
                    if ($dt = REQ($vx)) {
                        $actions[] = "$vx=" . urlencode($dt);
                    }
                }

                if ($actions) {
                    $action .= '&amp;' . join('&amp;', $actions);
                }
            }

            $result .= '<div class="quicklink_item"><a href="' . PHP_SELF . '?mod=' . $mod_key . $action . '"><img src="' . getOption('http_script_dir') . '/public/images/' . cnHtmlSpecialChars($name) . '" alt="Nạp thẻ VTC" /></a></div>';
        }

        $result .= "</div>";

        return $result;
    }

//    /**
//     * return html menu top
//     */
//    function cn_menuTopMoney($opt = '')
//    {
//        global $skin_menu_TopMoney, $skin_menu_TopAccount;
//
//        if (isset($_SESSION['user_Gamer'])) {
//            $_blank_var = view_bank($_SESSION['user_Gamer']);
//
//            $matches[0] = '<img height="20px" src="' . getOption('http_script_dir') . '/images/top-menu/icon-1.png" /> ' . cn_zenderMoneyBank($_blank_var[0]['vp']) . ' Vpoint';
//            $matches[1] = '<img height="20px" src="' . getOption('http_script_dir') . '/images/top-menu/icon-2.png" /> ' . cn_zenderMoneyBank($_blank_var[0]['gc']) . ' Gcoin';
//            $matches[2] = '<img height="20px" src="' . getOption('http_script_dir') . '/images/top-menu/icon-3.png" /> ' . cn_zenderMoneyBank($_blank_var[0]['gc_km']) . ' Gcoin KM';
//            $matches[3] = '<img height="20px" src="' . getOption('http_script_dir') . '/images/top-menu/icon-4.png" /> ' . cn_zenderMoneyBank($_blank_var[0]['blue']) . ' Blue';;
//            $matches[4] = '<img height="20px" src="' . getOption('http_script_dir') . '/images/top-menu/icon-5.png" /> ' . cn_zenderMoneyBank($_blank_var[0]['chaos']) . ' Chaos';
//            $matches[5] = '<img height="20px" src="' . getOption('http_script_dir') . '/images/top-menu/icon-6.png" /> ' . cn_zenderMoneyBank($_blank_var[0]['cre']) . ' Cre';
//            $matches[6] = '<img height="20px" src="' . getOption('http_script_dir') . '/images/top-menu/icon-7.png" /> ' . cn_zenderMoneyBank($_blank_var[0]['bank']) . ' Zen';
//            $matches[7] = '<img height="20px" src="' . getOption('http_script_dir') . '/images/top-menu/icon-8.png" /> ' . cn_zenderMoneyBank($_blank_var[0]['feather']) . ' Lông vũ';
//            $tempTop = ['{nameVpoint}', '{nameGcoin}', '{nameGcKm}', '{nameBule}', '{nameChaos}', '{nameCreate}', '{nameBank}', '{nameFeather}'];
//            $skin_menu_TopMoney = str_replace($tempTop, $matches, $skin_menu_TopMoney);
//
//            $userName[0] = '<img class="icon-Userimg" src="' . getOption('http_script_dir') . '/images/user-Name.png" />';
//            $userName[1] = $_SESSION['user_Gamer'];
//            $skin_menu_TopAccount = str_replace(['{userImg}', '{userName}'], $userName, $skin_menu_TopAccount);
//
//            $boxArrInfo = [
//                '{changePass}' => ['change_pass', 'Đổi pass-Game'],
//                '{changeTel}' => ['change_tel', 'Đổi Sđt'],
//                '{changeEmail}' => ['change_email', 'Đổi Email'],
//                '{changePwd}' => ['change_pwd', 'Đổi pass-Web'],
//                '{changeSecret}' => ['change_secret', 'Đổi Mã Bí mật'],
//                '{changeQA}' => ['change_qa', 'Đổi Câu Trả Lời']
//            ];
//            foreach ($boxArrInfo as $jk => $its) {
//                $tmpHtml = '<a href="' . PHP_SELF . '?mod=manager_account&amp;opt=' . $its[0] . '"><div><img height="20" width="20" src="' . getOption('http_script_dir') . '/images/' . $its[0] . '.png" /></div><div>' . $its[1] . '</div></a>';
//                $skin_menu_TopAccount = str_replace($jk, $tmpHtml, $skin_menu_TopAccount);
//            }
//
//            if ($opt) {
//                $skin_menu_TopSample = $skin_menu_TopMoney;
//            } else {
//                $skin_menu_TopSample = $skin_menu_TopAccount;
//            }
//            // opt in true return skin menu top money
//            if (empty($opt)) {
//                $skin_menu_TopSample = $skin_menu_TopMoney . $skin_menu_TopAccount;
//            }
//        } else {
//            $skin_menu_TopSample = '<marquee scrollamount="9" height="45" align="center" style="font-size:14px;color: rgb(200, 128, 35); padding-top: 12px; font-style: oblique;">Chào mừng các bạn ghé thăm trang MuOnline</marquee>';
//        }
//
//        return $skin_menu_TopSample;
//    }

//    function echoFormVerifyChar($addOpt = array(), $msgVidateSubmit = '')
//    {
//        global $defaultVerifyMyChar;
//
//        echo "<form id=\"verify\" action=\"" . PHP_SELF . "\" method=\"POST\"  onSubmit=\"return validateFormOnSubmit('" . $msgVidateSubmit . "');\">";
//        echo cn_form_open('mod, opt, sub');
//
//        if ($addOpt) {
//            foreach ($addOpt as $field => $val) {
//                echo '<input type="hidden" name="' . trim($field) . '" value="' . cnHtmlSpecialChars($val) . '" />';
//            }
//        }
//        echo $defaultVerifyMyChar;
//        echo '</form>';
//
//    }

//    function echoFormVerifyAjax($addOpt = array(), $nameFrom)
//    {
//        if (empty($nameFrom)) {
//            echo '';
//        } else {
//
//            global $defaultVerifyAjax;
//
//            $charFirst = substr($nameFrom, 0, 1);
//            // default class
//            if ($charFirst == '#') {
//                $nameForm = 'id="' . substr($nameFrom, 1) . '"';
//            } else {
//                $nameForm = 'class="' . substr($nameFrom, 1) . '"';
//            }
//            $defaultVerifyAjax = str_replace('{nameAction}', $nameForm, $defaultVerifyAjax);
//
//            echo "<form id=\"verify\" action=\"" . PHP_SELF . "\" method=\"POST\" onsubmit=\"return false;\">";
//            echo cn_form_open('mod, opt, sub');
//
//            if ($addOpt) {
//                foreach ($addOpt as $field => $val) {
//                    echo '<input type="hidden" name="' . trim($field) . '" value="' . cnHtmlSpecialChars($val) . '" />';
//                }
//            }
//            echo $defaultVerifyAjax;
//            echo '</form>';
//        }
//    }

    // Since 2.0: Grab from $_POST all parameters
    public function cn_parse_url()
    {
        // Decode post data
        $post_data = array();
        if (isset($_POST['__post_data'])) {
            $post_data = unserialize(base64_decode($_POST['__post_data']));
        }
        // A. Click "confirm"
        if (REQ('__my_confirm') == '_confirmed') {
            // In case if exists another data from form
            $APPEND = isset($_POST['__append']) ? $_POST['__append'] : array();

            $_POST = $post_data;
            $_POST['__my_confirm'] = '_confirmed';

            // Return additional parameters in POST
            if (is_array($APPEND)) {
                foreach ($APPEND as $id => $v) {
                    $_POST[$id] = $v;
                }
            }

            return true;
        } // B. Click "decline"
        elseif (REQ('__my_confirm') == '_decline') {
            $_POST['__referer'] = $post_data['__referer'];
            return false;
        } // C. First access
        else {
            $_POST['__referer'] = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
        }

        // Set POST required params to GET
        if (REQ('mod', 'POST')) {
            $_GET['mod'] = REQ('mod', 'POST');
        }
        if (REQ('opt', 'POST')) {
            $_GET['opt'] = REQ('opt', 'POST');
        }
        if (REQ('sub', 'POST')) {
            $_GET['sub'] = REQ('sub', 'POST');
        }

        // Unset signature dsi
        unset($_GET['__signature_key'], $_GET['__signature_dsi']);

        return false;
    }


    // Since 2.0: Pack only required parameters
    public function cn_pack_url($GET, $URL = PHP_SELF)
    {
        $url = $result = array();

        foreach ($GET as $k => $v) {
            if ($v !== '') {
                $result[$k] = $v;
            }
        }
        foreach ($result as $k => $v) {
            if (!is_array($v)) {
                $url[] = "$k=" . urlencode($v);
            }
        }

        list($ResURL) = hook('core/url_rewrite', array($URL . ($url ? '?' . join('&', $url) : ''), $URL, $GET));
        return $ResURL;
    }

    //// Since 1.5.1: Simply read template file
//    function read_tpl($tpl = 'index')
//    {
//        // get from cache
//        $cached = getMemcache("tpl:$tpl");
//        if ($cached) {
//            return $cached;
//        }
//
//        // Get asset path
//        if (preg_match('/\.(css|js)/i', $tpl)) {
//            $fine = '';
//        } else {
//            $fine = '.tpl';
//        }
//
//        // Get plugin path
//        if ($tpl[0] == '/') {
//            $open = cn_path_construct(SERVDIR, 'cdata', 'plugins') . substr($tpl, 1) . $fine;
//        } else {
//            $open = SKIN . DIRECTORY_SEPARATOR . ($tpl ? $tpl : 'default') . $fine;
//        }
//
//        // Try open
//        $not_open = false;
//        $r = fopen($open, 'r') or $not_open = true;
//        if ($not_open) {
//            return false;
//        }
//
//        ob_start();
//        fpassthru($r);
//        $ob = ob_get_clean();
//        fclose($r);
//
//        // caching file
//        setMemcache("tpl:$tpl", $ob);
//        return $ob;
//    }

    //// Since 2.0: Execute PHP-template
    //// 1st argument - template name, other - variables ==> mo file
//    function exec_tpl()
//    {
//        $args = func_get_args();
//        $tpl = preg_replace('/[^a-z0-9_\/]/i', '', array_shift($args));
//
//        $open = SKIN . '/' . ($tpl ? $tpl : 'default') . '.php';
//
//
//        foreach ($args as $arg) {
//            if (is_array($arg)) {
//                foreach ($arg as $k0 => $v) {
//                    $k = "__$k0";
//                    $$k = $v;
//                }
//            } else {
//                list($k, $v) = explode('=', $arg, 2);
//
//                // <-- make local variable
//                $k = "__$k";
//                $$k = $v;
//            }
//        }
//
//        if (file_exists($open)) {
//            ob_start();
//            include $open;
//            $echo = ob_get_clean();
//            return $echo;
//        }
//
//        return '';
//    }

    // Since 2.0: @bootstrap
    public function cn_load_skin_web()
    {
        $config_skin = preg_replace('~[^a-z]~i', '', getOption('skin'));
        //$config_skin = preg_replace('~[^a-z]~i','', 'default');
        if (file_exists($skinFile = SERVDIR . "/skins/$config_skin.skin.php")) {
            include($skinFile);
        } else {
            die("WEB: Can't load skin $config_skin");
        }
    }

    // Since 2.0: @bootstrap Make & load configuration file ==>
    public function cn_config_load()
    {
        global $_CN_access;
        //checking permission for load config
        $conf_dir = cn_path_construct(ROOT, 'gifnoc');
        if (!is_dir($conf_dir) || !is_writable($conf_dir)) {
            return false;
        }

        $conf_path = cn_path_construct(SERVDIR, 'gifnoc') . 'gifnoc.php';
        $cfg = cn_touch_get($conf_path); //doc or tao file
        if (!$cfg) {
            echo 'Sorry, but news not available by technical reason.';
            die();
        }

        setMemcache('config', $cfg);

        return true;
    }


    public function cn_bc_menu($name, $url, $opt)
    {
        $bc = getMemcache('.menu');
        $bc[$opt] = array('name' => $name, 'url' => $url);
        setMemcache('.menu', $bc);
    }

    /*
    function cn_template_rstrust(){

        // No in cache
        if ($_uythac_reset = getMemcache('#uythac_reset')){
            return $_uythac_reset;
        }

        $uythac_reset = cn_get_template_by('uythac_reset');
        if (!$uythac_reset){
            return NULL;
        }
        $reset = cn_template_reset();
        $id = 0;
        foreach($uythac_reset as $key => $val){
            $options_trustrs[$id]['reset'] = $reset[$id]['reset'];
            $options_trustrs[$id]['point'] = $val;
            $options_trustrs[$id]['zen'] = $reset[$id]['zen'];
            $options_trustrs[$id]['chaos'] = $reset[$id]['chaos'];
            $options_trustrs[$id]['cre'] = $reset[$id]['cre'];
            $options_trustrs[$id]['blue'] = $reset[$id]['blue'];
            ++$id;
        }
        setMemcache('#uythac_reset', $options_trustrs);

        return $options_trustrs;
    }
    function cn_template_rsviptrust(){

        // No in cache
        if ($_uythac_resetvip = getMemcache('#uythac_resetvip')){
            return $_uythac_resetvip;
        }

        $uythac_resetvip = cn_get_template_by('uythac_resetvip');
        if (!$uythac_resetvip){
            return NULL;
        }
        $resetvip = cn_template_resetvip();
        $id = 0;
        foreach($uythac_resetvip as $in_ => $val){
            $options_trustrsvip[$id]['reset'] = $resetvip[$id]['reset'];
            $options_trustrsvip[$id]['point'] = $val;
            $options_trustrsvip[$id]['vpoint'] = $resetvip[$id]['vpoint'];
            $options_trustrsvip[$id]['gcoin'] = $resetvip[$id]['gcoin'];
            ++$id;
        }
        setMemcache('#uythac_resetvip', $options_trustrsvip);

        return $options_trustrsvip;
    }
    */
    ////BQN Check Point trust
//    function cn_point_trust()
//    {
//        $member = getMemberWeb();
//        $accc_ = $member['user_name'];
//
//        $show_reponse = view_character($accc_);
//
//        if ($show_reponse) {
//            foreach ($show_reponse as $od => $do) {
//                if (!empty($sub = $do['Name'])) {
//                    $arr_trust = do_select_character('Character', 'UyThac,uythaconline_time,PhutUyThacOn_dutru,uythacoffline_stat,uythacoffline_time,PhutUyThacOff_dutru,PointUyThac,UyThacOnline_Daily,UyThacOffline_Daily', "Name='$sub'", '');
//
//                    $check_trust = false;
//                    $ctime = ctime();
//                    $status_online = $arr_trust[0]['UyThac'];
//                    $status_offline = $arr_trust[0]['uythacoffline_stat'];
//                    $trust_point = $arr_trust[0]['PointUyThac'];
//                    $_time_on_begin = $arr_trust[0]['uythaconline_time'];
//                    $_time_off_begin = $arr_trust[0]['uythacoffline_time'];
//                    $point_pt_on = $arr_trust[0]['PhutUyThacOn_dutru'];
//                    $point_pt_off = $arr_trust[0]['PhutUyThacOff_dutru'];
//
//                    $time_begin_on = date("Y-M-d", $_time_on_begin);
//                    $time_begin_off = date("Y-M-d", $_time_off_begin);
//                    $_time_ = date("Y-M-d", $ctime);
//                    $set_time = mktime(0, 0, 0, date("m", $ctime), date("d", $ctime), date("Y", $ctime));
//
//                    $_df_on = date_create($time_begin_on);
//                    $_df_off = date_create($time_begin_off);
//                    $_de = date_create($_time_);
//
//                    $count_on = date_diff($_df_on, $_de)->format('%a');
//                    $count_off = date_diff($_df_off, $_de)->format('%a');
//
//                    if ($status_online) {            //Status ON [Online]
//                        if ($time_begin_on < $_time_) {
//                            $inday_begin_on = date("Y-m-d h:i:sa", $_time_on_begin);
//                            $inday_beginon_end = date("Y-m-d", $_time_on_begin); // strtotime
//                            $inday_time_beginon = abs(strtotime($inday_begin_on) - strtotime("$inday_beginon_end 11:59:59pm"));
//
//                            if ($inday_time_beginon >= 43200) $Pf = 720;
//                            else $Pf = floor($inday_time_beginon / 60);
//                            if ($count_on == 1) {
//                                $point_pt_on = floor(0.95 * $Pf);
//                                $point_pt_off = floor(0.95 * $point_pt_off);
//                                //if(date("Y-m-d", $_time_off_begin) != date("Y-m-d",$ctime)) $trust_point = floor($trust_point*0.9);
//                                $trust_point = floor($trust_point * 0.9);
//                            } else if ($count_on >= 2) {
//                                $_bv = floor($Pf * 0.95);
//                                //if(date("Y-m-d", $_time_off_begin) != date("Y-m-d",$ctime)) $trust_point = floor($trust_point*pow(0.9,$count_on));
//                                $point_pt_off = floor($point_pt_off * pow(0.95, $count_on));
//                                $trust_point = floor($trust_point * pow(0.9, $count_on));
//
//                                $do_loop = false;
//
//                                do {
//                                    --$count_on;
//                                    if (!$do_loop) {
//                                        $_bv += 720;
//                                        $do_loop = true;
//                                    } else $_bv = 720 + (isset($point_pt_on) ? $point_pt_on : 0);
//                                    $point_pt_on = floor($_bv * 0.95);
//                                } while ($count_on > 1);
//                            }
//                            $check_trust = true;
//                            do_update_character('Character', 'UyThacOffline_Daily=0', 'UyThacOnline_Daily=0', "PhutUyThacOff_dutru=$point_pt_off", "PhutUyThacOn_dutru=$point_pt_on", "uythacoffline_time=$set_time", "uythaconline_time=$set_time", "PointUyThac=$trust_point", "Name:'$sub'");
//                            //cnRelocation(cn_url_modify(array('reset'), 'mod='.REQ('mod'), 'opt='.REQ('opt'), 'sub='.$sub));
//                        } else if ($time_begin_off < $_time_) {
//                            $check_trust = true;
//                            do_update_character('Character', 'UyThacOffline_Daily=0', "uythacoffline_time=$set_time", "Name:'$sub'");
//                            //cnRelocation(cn_url_modify(array('reset'), 'mod='.REQ('mod'), 'opt='.REQ('opt'), 'sub='.$sub));
//                        }
//                    } else if ($status_offline) {        //Starus ON [Offline]
//
//                        if ($time_begin_off < $_time_) {
//                            $inday_begin_off = date("Y-m-d h:i:sa", $_time_off_begin);
//                            $inday_beginoff_end = date("Y-m-d", $_time_off_begin); // strtotime
//                            $inday_time_beginoff = abs(strtotime($inday_begin_off) - strtotime("$inday_beginoff_end 11:59:59pm"));
//
//                            if ($inday_time_beginoff >= 43200) $Pf = 720;
//                            else $Pf = floor($inday_time_beginoff / 60);
//
//                            if ($count_off == 1) {
//                                $point_pt_off = floor(0.95 * $Pf);
//                                $point_pt_on = floor(0.95 * $point_pt_on);
//                                //if(date("Y-m-d", $_time_on_begin) != date("Y-m-d",$ctime)) $trust_point = floor($trust_point*0.9);
//                                $trust_point = floor($trust_point * 0.9);
//                            } else if ($count_off >= 2) {
//                                $_bv = floor($Pf * 0.95);
//                                $point_pt_on = floor(pow(0.95, $count_off) * $point_pt_on);
//                                //if(date("Y-m-d", $_time_on_begin) != date("Y-m-d",$ctime)) $trust_point = floor($trust_point*pow(0.9,$count_off));
//                                $trust_point = floor($trust_point * pow(0.9, $count_off));
//
//                                $do_loop = false;
//
//                                do {
//                                    --$count_off;
//                                    if (!$do_loop) {
//                                        $_bv += 720;
//                                        $do_loop = true;
//                                    } else $_bv = 720 + (isset($point_pt_off) ? $point_pt_off : 0);
//                                    $point_pt_off = floor($_bv * 0.95);
//                                } while ($count_off > 1);
//                            }
//                            $check_trust = true;
//                            do_update_character('Character', 'UyThacOffline_Daily=0', 'UyThacOnline_Daily=0', "PhutUyThacOn_dutru=$point_pt_on", "PhutUyThacOff_dutru=$point_pt_off", "uythaconline_time=$set_time", "uythacoffline_time=$set_time", "PointUyThac=$trust_point", "Name:'$sub'");
//                            //cnRelocation(cn_url_modify(array('reset'), 'mod='.REQ('mod'), 'opt='.REQ('opt'), 'sub='.$sub));
//                        } else if ($time_begin_on < $_time_) {
//                            $check_trust = true;
//                            do_update_character('Character', 'UyThacOnline_Daily=0', "uythaconline_time=$set_time", "Name:'$sub'");
//                            //cnRelocation(cn_url_modify(array('reset'), 'mod='.REQ('mod'), 'opt='.REQ('opt'), 'sub='.$sub));
//                        }
//                    } else {
//                        //exit("ko on + off");
//                        $count_min = min($count_on, $count_off);
//                        if ($count_min) {
//
//                            $point_pt_on = floor($point_pt_on * pow(0.95, $count_min));
//                            $point_pt_off = floor($point_pt_off * pow(0.95, $count_min));
//                            $trust_point = floor($trust_point * pow(0.9, $count_min));
//                            $check_trust = true;
//                            do_update_character('Character', 'UyThacOnline_Daily=0', 'UyThacOffline_Daily=0', "PhutUyThacOff_dutru=$point_pt_off", "PhutUyThacOn_dutru=$point_pt_on", "uythaconline_time=$set_time", "uythacoffline_time=$set_time", "PointUyThac=$trust_point", "Name:'$sub'");
//                            //cnRelocation(cn_url_modify(array('reset'), 'mod='.REQ('mod'), 'opt='.REQ('opt'), 'sub='.$sub));
//                        } else if ($count_on) {
//                            $check_trust = true;
//                            do_update_character('Character', 'UyThacOnline_Daily=0', "uythaconline_time=$set_time", "Name:'$sub'");
//                        } else if ($count_off) {
//                            $check_trust = true;
//                            do_update_character('Character', 'UyThacOffline_Daily=0', "uythacoffline_time=$set_time", "Name:'$sub'");
//                        }
//                    }
//                    if ($check_trust) {
//                        $daily_trust = 0;
//                        $_time_on_begin = $_time_off_begin = $set_time;
//                    }
//                    $trust[$sub]['status_on'] = $status_online;
//                    $trust[$sub]['status_off'] = $status_offline;
//                    $trust[$sub]['time_begin_on'] = $_time_on_begin;
//                    $trust[$sub]['time_begin_off'] = $_time_off_begin;
//                    $trust[$sub]['phut_on_dutru'] = $point_pt_on;
//                    $trust[$sub]['phut_off_dutru'] = $point_pt_off;
//                    $trust[$sub]['pointuythac'] = $trust_point;
//                    $trust[$sub]['online_daily'] = isset($daily_trust) ? $daily_trust : $arr_trust[0]['UyThacOnline_Daily'];
//                    $trust[$sub]['offline_daily'] = isset($daily_trust) ? $daily_trust : $arr_trust[0]['UyThacOffline_Daily'];
//                }
//            }
//        } else {
//            msg_err("Bạn chưa tạo nhân vật. Vui lòng đăng nhập game trước khi thực hiện tác vụ này.");
//        }
//
//        return isset($trust) ? $trust : array();
//    }

    /*
    // Since 2.0: Save whole config
    function cn_config_save($cfg = null)
    {
        if ($cfg === null)
        {
            $cfg = getMemcache('config');
        }

        $fn = cn_path_construct(SERVDIR,'gifnoc').'gifnoc.php';
        $dest = $fn.'-'.mt_rand().'.bak';

        // save all config
        $fx = fopen($dest, 'w+');
        fwrite($fx, "<?php die(); ?>\n" . base64_encode(serialize($cfg)) );
        fclose($fx);
        unlink($fn); // xoa file hien tai
        rename($dest, $fn); //bat len .....

        setMemcache('config', $cfg);
        return $cfg;
    }
    */

    // Since 2.0: Get option from #CFG or [%site][<opt_name>]
    // Usage: #level1/level2/.../levelN or 'option_name' from %site
    public function getOption($opt_name = '', $var_name = '')
    {
        $cfg = getMemcache('config');

        if ($opt_name === '') {
            return $cfg;
        }
        if ($opt_name[0] == '#') {
            $cfn = separateString(substr($opt_name, 1), '/');
            foreach ($cfn as $id) {
                if (isset($cfg[$id])) {
                    $cfg = $cfg[$id];
                } else {
                    $cfg = array();
                    break;
                }
            }

            return $cfg;
        } elseif ($opt_name[0] == '@') {
            if (!empty($var_name)) {
                $opt_name_ = substr($opt_name, 1);
                return isset($cfg[$opt_name_][$var_name]) ? $cfg[$opt_name_][$var_name] : false;
            } else {
                $opt_name_arr = separateString(substr($opt_name, 1), '/');
                foreach ($opt_name_arr as $id) {
                    if (isset($cfg[$id])) {
                        $cfg = $cfg[$id];
                    } else {
                        $cfg = array();
                        break;
                    }
                }

                return $cfg;
            }
        } else {
            return isset($cfg['%site'][$opt_name]) ? $cfg['%site'][$opt_name] : false;
        }
    }

    // bqn relocation => $db + server
    public function cn_relocation_db_new()
    {
        global $db_new, $config_adminemail, $config_admin;
        $type_connect = getOption('type_connect');
        $localhost = getOption('localhost');
        $databaseuser = getOption('databaseuser');
        $databsepassword = getOption('databsepassword');
        $d_base = getOption('d_base');

        if (!$type_connect || !$localhost || !$databaseuser || !$databsepassword || !$d_base) {
            echo 'Không có kết nối đến máy chủ!';
            die();
        }
        //$database = "Driver={SQL Server};Server=(local);Database=MuOnline";
        $passviewcard = getOption('passviewcard');
        $passcode = getOption('passcode');
        $passadmin = getOption('passadmin');
        $passcard = getOption('passcard');
        $server_type = getOption('server_type');

        $config_admin = $this->config["admin_name"];
        $config_adminemail = $this->config["admin_email"];

        include_once(SERVDIR . '/admin/adodb/adodb.inc.php');

        if ($type_connect == 'odbc') {
            $db_new = ADONewConnection('odbc');
            $database_ = "Driver={SQL Server};Server={$localhost};Database={$d_base}";
            $connect_mssql = $db_new->Connect($database_, $databaseuser, $databsepassword);
            $db_new->SetFetchMode(ADODB_ASSOC_CASE);
            if (!$connect_mssql) {
                die('Ket noi voi SQL Server loi! Hay kiem tra lai ODBC ton tai hoac User & Pass SQL dung.');
            }
        } elseif ($type_connect == 'mssql') { // config sau
            if (extension_loaded('mssql')) {
                echo('');
            } else {
                die('Loi! Khong the load thu vien php_mssql.dll. Hay cho phep su dung php_mssql.dll trong php.ini');
            }
            $db_new = ADONewConnection('mssql');
            $connect_mssql = $db_new->Connect($localhost, $databaseuser, $databsepassword, $d_base);
            $db_new->SetFetchMode(ADODB_ASSOC_CASE);
            if (!$connect_mssql) {
                die('Loi! Khong the ket noi SQL Server');
            }
            //$conn->ErrorMsg()
        }
    }

    /**
     * return global
     */
    public function cn_connect_forum()
    {
        @include_once ROOT . '/forum/includes/config.php';
        global $DbForum;
        if (isset($config['Database']['dbtype'])) {
            include_once(ROOT . '/admin/adodb/adodb.inc.php');

            $dbType = $config['Database']['dbtype'];
            $dbname = $config['Database']['dbname'];
            $tableprefix = $config['Database']['tableprefix'];
            $dbservername = @$config['MasterServer']['servername'] ? $config['MasterServer']['servername'] : '';
            $dbport = @$config['MasterServer']['port'] ? $config['MasterServer']['port'] : '';
            $dbusername = @$config['MasterServer']['username'] ? $config['MasterServer']['username'] : '';
            $dbpassword = @$config['MasterServer']['password'] ? $config['MasterServer']['password'] : '';

            if (!$dbservername) {
                $dbservername = @$config['SlaveServer']['servername'] ? $config['SlaveServer']['servername'] : '';
            }
            if (!$dbusername) {
                $dbusername = @$config['SlaveServer']['username'] ? $config['SlaveServer']['username'] : '';
            }
            if (!$dbpassword) {
                $dbpassword = @$config['SlaveServer']['password'] ? $config['SlaveServer']['password'] : '';
            }
            if (!$dbport) {
                $dbport = @$config['SlaveServer']['port'] ? $config['SlaveServer']['port'] : '';
            }

            if ($dbservername && $dbname && $dbusername) {
                switch ($dbType) {
                    case 'mysqli':
                        if (!extension_loaded('mysqli')) {
                            die('Loi! Khong the load thu vien php_mysqli.dll. Hay cho phep su dung php_mssql.dll trong php.ini');
                        }

                        $DbForum = ADONewConnection('mysqli');
                        //$db->Connect($server, $userid, $password, $database);
                        $connect_mssql = $DbForum->Connect($dbservername, $dbusername, $dbpassword, $dbname);
                        if (!$connect_mssql) {
                            die('Ket noi voi MYSQLI loi! Hay kiem tra lai MYSQLI ton tai hoac User & Pass SQL dung.');
                        }
                        break;
                    case 'mysql':
                        if (!extension_loaded('mysql')) {
                            die('Loi! Khong the load thu vien php_mysql.dll. Hay cho phep su dung php_mssql.dll trong php.ini');
                        }
                        $DbForum = ADONewConnection('mysql');
                        //$db->Connect($server, $userid, $password, $database);
                        $connect_mssql = $DbForum->Connect($dbservername, $dbusername, $dbpassword, $dbname);
                        if (!$connect_mssql) {
                            die('Ket noi voi MYSQLI loi! Hay kiem tra lai MYSQLI ton tai hoac User & Pass SQL dung.');
                        }
                        break;
                    case 'odbc':
                        $DbForum = ADONewConnection('odbc');
                        $database_ = "Driver={SQL Server};Server={$dbservername};Database={$dbname}";
                        $connect_mssql = $DbForum->Connect($database_, $dbusername, $dbpassword, $dbname);
                        if (!$connect_mssql) {
                            die('Ket noi voi SQL Server loi! Hay kiem tra lai ODBC ton tai hoac User & Pass SQL dung.');
                        }
                        break;
                    default:
                        break;
                }
            }
        }
    }

    // Since 2.0: Add message
    public function cn_throw_message($msg, $area = 'n')
    {
        $es = getMemcache('msg:stor');

        if (!isset($es[$area])) {
            $es[$area] = array();
        }
        $es[$area][] = $msg;

        setMemcache('msg:stor', $es);
        return false;
    }

    // Since 2.0.3
    public function cn_user_email_as_site($user_email, $username)
    {
        if (preg_match('/^www\./i', $user_email)) {
            return '<a target="_blank" href="http://' . cnHtmlSpecialChars($user_email) . '">' . $username . '</a>';
        } elseif (preg_match('/^(https?|ftps?):\/\//i', $user_email)) {
            return '<a target="_blank" href="' . cnHtmlSpecialChars($user_email) . '">' . $username . '</a>';
        } else {
            return '<a href="mailto:' . cnHtmlSpecialChars($user_email) . '">' . $username . '</a>';
        }
    }

//
//function CheckSlotInventory($inventory, $itemX, $itemY)
//{
//    $items_data = getOption('#items_data');
//    $items = str_repeat('0', 64);
//    $itemsm = str_repeat('1', 64);
//    $i = 0;
//    while ($i < 64) {
//        $item = substr($inventory, $i * 32, 32);
//        if ($item == "FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF" || $item == "ffffffffffffffffffffffffffffffff") {
//            $i++;
//            continue;
//        } else {
//            $item_ = cn_getCodeItem($item);
//            $item_data = $items_data[$item_['group'] . "." . $item_['id']];
//            $y = 0;
//            while ($y < $item_data['Y']) {
//                $x = 0;
//                while ($x < $item_data['X']) {
//                    $items = substr_replace($items, '1', ($i + $x) + ($y * 8), 1);
//                    $x++;
//                }
//                $y++;
//            }
//            $i++;
//        }
//    }
//    $y = 0;
//    while ($y < $itemY) {
//        $x = 0;
//        while ($x < $itemX) {
//            $x++;
//            $spacerq[$x + (8 * $y)] = true;
//        }
//        $y++;
//    }
//    $walked = 0;
//    $i = 0;
//    while ($i < 64) {
//        if (isset($spacerq[$i])) {
//            $itemsm = substr_replace($itemsm, '0', $i - 1, 1);
//            $last = $i;
//            $walked++;
//        }
//        if ($walked == count($spacerq)) $i = 63;
//        $i++;
//    }
//    $useforlength = substr($itemsm, 0, $last);
//    $findslotlikethis = str_replace('++', '+', str_replace('1', '+[0-1]+', $useforlength));
//    $i = 0;
//    $nx = 0;
//    $ny = 0;
//    while ($i < 64) {
//        if ($nx == 8) {
//            $ny++;
//            $nx = 0;
//        }
//        if ((preg_match('/^' . $findslotlikethis . '/', substr($items, $i, strlen($useforlength)))) && ($itemX + $nx < 9) && ($itemY + $ny < 16)) return $i;
//        $i++;
//        $nx++;
//    }
//    return 2048;
//}
}
