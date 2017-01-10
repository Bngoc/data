<?php

function cn_url_modify()
{
    global $PHP_SELF;
    $GET = $_GET;
    $args = func_get_args();
    $SN = $PHP_SELF;

    // add new params
    foreach ($args as $ks) {
        // 1) Control
        if (is_array($ks)) {
            foreach ($ks as $vs) {
                $id = $val = '';

                if (strpos($vs, '=') !== FALSE) {
                    list($id, $var) = explode('=', $vs, 2);
                } else {
                    $id = $vs;
                }
                if ($id == 'self') {
                    $SN = $var;
                } elseif ($id == 'reset') {
                    $GET = array();
                } elseif ($id == 'group') {
                    foreach ($vs as $a => $b) {
                        $GET[$a] = $b;
                    }
                }
            }
        } // 2) Subtract
        elseif (strpos($ks, '=') === FALSE) {
            $keys = explode(',', $ks);

            foreach ($keys as $key) {
                $key = trim($key);
                if (isset($GET[$key])) {
                    unset($GET[$key]);
                }
            }
        } // 3) Add
        else {
            list($k, $v) = explode('=', $ks, 2);

            $GET[$k] = $v;
            if ($v === '') {
                unset($GET[$k]);
            }
        }
    }

    return cn_pack_url($GET, $SN);
}

// Since 2.0: Extended extract
function _GL($v)
{
    $vs = explode(',', $v);
    $result = array();
    foreach ($vs as $vc) {
        $el = explode(':', $vc, 2);
        $vc = isset($el[0]) ? $el[0] : false;
        $func = isset($el[1]) ? $el[1] : false;
        $var = false;
        if ($vc) $var = isset($GLOBALS[trim($vc)]) ? $GLOBALS[trim($vc)] : false;
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
    $vars = spsep($var);
    $method = strtoupper($method);

    if ($method == 'GETPOST') {
        $methods = array('GET', 'POST');
    } elseif ($method == 'POSTGET') {
        $methods = array('POST', 'GET');
    } elseif ($method == 'GPG') {
        $methods = array('POST', 'GET', 'GLOB');
    } else {
        $methods = spsep($method);
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
function spsep($separated_string, $seps = ',')
{
    if (strlen($separated_string) == 0) {
        return array();
    }
    $ss = explode($seps, $separated_string);
    return $ss;
}

// Since 2.0: Cutenews HtmlSpecialChars
function cn_htmlspecialchars($_str)
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
function REQ($var, $method = 'GETPOST')
{
    if ($method[0] == '*') {
        list($value) = (GET($var, substr($method, 1)));
        return cn_htmlspecialchars($value);
    } else {
        list($value) = GET($var, $method);
        return $value;
    }
}

// Since 2.0: Check server request type
function request_type($type = 'POST')
{
    return $_SERVER['REQUEST_METHOD'] === $type ? TRUE : FALSE;
}


// Since 2.0: Show breadcrumbs
function cn_snippet_bc($sep = '&gt;')
{
    $bc = mcache_get('.breadcrumbs');

    $opt = REQ('opt', 'GPG');
    if (!$opt) $opt = '';

    echo '<div id="mainsub_title" class="cn_breadcrumbs">';

    $ls = array();
    if (is_array($bc)) {
        foreach ($bc as $key => $item) {
            if ($key != $opt)
                $ls[] = '<span class="bcitem"><a href="' . $item['url'] . '">' . cn_htmlspecialchars($item['name']) . '</a></span>';
            else
                $ls[] .= '<span class="bcitem">' . cn_htmlspecialchars($item['name']) . '</span>';
        }
    }
    echo join(' <span class="bcsep">' . $sep . '</span> ', $ls);
    echo '</div>';
}

// Since 2.0: Show breadcrumbs BY
// Home > name
function cn_snippet_bc_re($home_ = 'Home', $_name_bread = null, $sep = '&gt;')
{
    $bc = mcache_get('.breadcrumbs');
    $result = '<div id="mainsub_title" class="cn_breadcrumbs"><span class="bcitem"><a href="' . PHP_SELF . '">' . cn_htmlspecialchars($home_) . '</a></span>';

    //if(is_array($bc)) $result .='<span class="bcsep"> '.$sep.' </span>';
    $maxs = count($bc) - 1;

    $ls = array();
    if (is_array($bc)) {
        $result .= '<span class="bcsep"> ' . $sep . ' </span>';
        foreach ($bc as $key => $item) {

            //if(is_null($_name_bread)){
            if ($key != $maxs)// && is_null($_name_bread))
                $ls[] = '<span class="bcitem"><a href="' . $item['url'] . '">' . cn_htmlspecialchars($item['name']) . '</a></span>';
            else
                $ls[] .= '<span class="bcitem">' . cn_htmlspecialchars($item['name']) . '</span>';
            //}
            //else
            //$ls[] = '<span class="bcitem"><a href="'.$item['url'].'">'.cn_htmlspecialchars($item['name']).'</a></span>';

        }
    }
    //if($ls)
    $result .= join(' <span class="bcsep">' . $sep . '</span> ', $ls);

    //else
    //$result .= '<span class="bcsep"> '.$sep.' </span>';

    if (!is_null($_name_bread) && $_name_bread)
        $result .= '<span class="bcsep"> ' . $sep . ' </span><span class="bcitem">' . cn_htmlspecialchars($_name_bread) . '</span>';


    $result .= "</div>";

    return $result;
}

function cn_load_session()
{
    @session_start();
}

// Since 1.5.1: Validate email
function check_email($email)
{
    return (preg_match("/^[\.A-z0-9_\-\+]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z]{1,4}$/", $email));
}

// Since 2.0: Extended assign
function cn_assign()
{
    $args = func_get_args();
    $keys = explode(',', array_shift($args));

    foreach ($args as $id => $arg) {
        // Simple assign
        if (isset($keys[$id])) {
            $KEY = trim($keys[$id]);
            $GLOBALS[$KEY] = $arg;
        } else // Inline assign
        {
            list($k, $v) = explode('=', $arg, 2);
            $GLOBALS[$k] = $v;
        }
    }
}

// Since 2.0: Get messages
function cn_get_message($area, $method = 's') // s-show, c-count
{
    $es = mcache_get('msg:stor');
    if (isset($es[$area])) {
        if ($method == 's') return $es[$area];
        elseif ($method == 'c') return count($es[$area]);
    }
    return null;
}

// Since 2.0; HTML show errors
function cn_messages_show($arrNotify, $notify)
{
    $delay = 7500;
    $result = '';
    if (empty($arrNotify))
        return $result;

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
function cn_snippet_messages($area = 'new')
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
function cn_detect_user_ip()
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
    define('CRYPT_SALT', (getoption('ipauth') == '1' ? CLIENT_IP : '') . '@' . getoption('#crypt_salt'));
}

function alert_message($str)
{
    echo "<script> alert('$str'); </script>";
}

function member_get()
{
    // Not authorized
    if (empty($_SESSION['user_Gamer'])) {
        return null;
    }

    // No in cache
    if ($member = mcache_get('#member')) {
        return $member;
    }

    mcache_set('#member', $user = db_user_by_name($_SESSION['user_Gamer']));

    return $user;
}

// Since 1.5.0: Hash type MD5 and SHA256
function hash_generate($password, $md5hash = false)
{
    $md5_ = md5($password);
    $try = array
    (
        0 => $md5_,
        1 => utf8decrypt($password, $md5hash),
        2 => SHA256_hash($password),
        3 => substr($md5_, 10, 10),
    );

    return $try;
}

// Since 1.5.3: UTF8-Cutenews compliant
function utf8decrypt($str, $oldhash)
{
    $len = strlen($str) * 3;
    while ($len >= 16) $len -= 16;
    $len = floor($len / 2);
    $salt = substr($oldhash, $len, 10);
    $pass = SHA256_hash($salt . $str . '`>,');
    $pass = substr($pass, 0, $len) . $salt . substr($pass, $len);
    return $pass;
}

// Since 2.0: Test User ACL. Test for groups [user may consists requested group]
function test($requested_acl, $requested_user = NULL, $is_self = FALSE)
{
    $user = member_get(); // get user menber session

    // Deny ANY access of unathorized member
    if (!$user) return FALSE;

    $acl = $user['acl'];
    $grp = getoption('#grp');
    $ra = spsep($requested_acl);

    // This group not exists, deny all
    if (!isset($grp[$acl]))
        return FALSE;

    // Decode ACL, GRP string
    $gp = spsep($grp[$acl]['G']);
    $rc = spsep($grp[$acl]['A']);


    // ra la bien truyen vao
    // If requested acl not match with real allowed, break
    foreach ($ra as $Ar) {
        if (!in_array($Ar, $rc)) return FALSE;
    }

    // Test group or self
    if ($requested_user) {
        // if self-check, check name requested user and current user
        if ($is_self && $requested_user['user_Gamer'] !== $user['name']) // xac ding user truyen vao <=> user hien tai
            return FALSE;

        // if group check, check: requested uses may be in current user group
        if (!$is_self) {
            if ($gp && !in_array($requested_user['acl'], $gp))  //kiem tra user truyen vao user[acl]  <=> phan quyen trong nhom
                return FALSE;
            elseif (!$gp)                                        //ko ton tai phan quyen
                return FALSE;
        }
    }

    return TRUE;
}


// Since 2.0: Show login form
function cn_login_form($admin = TRUE)
{
    return exec_tpl('_authen/login');
}

function cn_login()
{
    if (isset($_SESSION['timeOutLogin']) && $_SESSION['timeOutLogin'] < ctime()) {
        cn_logout();
    }
    if (isset($_SESSION['timeOutLogin'])) {
        $_SESSION['timeOutLogin'] = ctime() + getoption('config_time_logout_web');
    }
    // Get logged username
    $logged_username = isset($_SESSION['user_Gamer']) ? $_SESSION['user_Gamer'] : FALSE;

    // Check user exists. If user logged, but not exists, logout now
    //if ($logged_username && !db_user_by_name($logged_username))
    //{
    //cn_logout();
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

                if (kiemtra_acc($username)) {
                    cn_throw_message("Tài khoản không tồn tại.", 'e');
                    $errors_fa = true;
                }
                if (kiemtra_block_acc($username)) {
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
                        $compares = hash_generate($password);

                        if (!isset($member['pass_web'])) {
                            $member['pass_web'] = '';
                        }

                        if (in_array(trim($member['pass_web']), $compares)) {
                            $is_logged = true;

                            // set user to session
                            $_SESSION['user_Gamer'] = $username;
                            $_SESSION['timeOutLogin'] = ctime() + getoption('config_time_logout_web');

                            //Reset character -- AccountID -> Thue Point
                            cn_resetDefaultCharater($username);

                            // save last login status, clear ban
                            //db_user_update($username, 'lts='.time(), 'ban=0');
                            do_update_character('MEMB_INFO', 'ban_login=0', "memb___id:'$username'");
                            // send return header (if exists)
                            if (isset($_SESSION['RQU'])) {
                                cn_relocation($_SESSION['RQU']);
                            }
                        } else {
                            cn_throw_message("Invalid password or login", 'e');
                            //cn_user_log('User "'.substr($username, 0, 32).'" ('.CLIENT_IP.') login failed');
                            do_update_character('MEMB_INFO', 'ban_login=' . (ctime() + getoption('ban_attempts')), "memb___id:'$username'");
                            //db_user_update($username, 'ban='.(time() + getoption('ban_attempts')));
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
        cn_logout();
    }

    // clear require url
    if ($is_logged && isset($_SESSION['RQU'])) {
        unset($_SESSION['RQU']);
    }

    return $is_logged;
}

// Since 2.0.3: Logout user and clean session
function cn_logout($relocation = PHP_SELF)
{
    //cn_cookie_unset();
    session_unset();
    session_destroy();
    cn_relocation($relocation);
}

// Since 2.0: Show register form
function cn_register_form($admin = TRUE)
{
    if (isset($_SESSION['user_Gamer'])) {
        return false;
    }

    // Active register
    if (isset($_GET['verifiregist']) && $_GET['verifiregist']) {

        $d_string = base64_decode($_GET['verifiregist']);
        $d_string = xxtea_decrypt($d_string, MD5(CLIENT_IP) . getoption('#crypt_salt'));
        $newHash = substr($d_string, 0, 64);
        $d_string = trim(strtolower(substr($d_string, 64)));

        if ($d_string) {
            $user = do_select_character('MEMB_INFO', 'memb___id,token_regist,date_resgit_email,mail_chek', "memb___id='$d_string'");

            if ($user) {
                if ($newHash != trim($user[0]['token_regist'])) msg_info('Đường dẫn không hợp lệ.');
                if (trim($user[0]['mail_check'])) msg_info('Tài khoản đã được kích hoạt.', 'index.php');

                if (ctime() > $user[0]['date_resgit_email']) {
                    $statusDelete = do_delete_char("DELETE FROM MEMB_INFO WHERE memb___id ='" . $d_string . "'");
                    if ($statusDelete) {
                        msg_info('Bạn có thể sử dụng lại email để đăng ký.', 'index.php?register');
                    } else {
                        msg_info('Đã hết hạn kích hoạt tài khoản.');
                    }
                }

                $statusUp = do_update_character('MEMB_INFO', 'mail_chek=1', "acl=" . ACL_LEVEL_JOURNALIST, "memb___id:'" . $d_string . "'");
                if ($statusUp) {
                    msg_info('Tài khoản đã được kích hoạt....', 'index.php');
                }
            } else {
                msg_info('Fail: Tài khoản không được xác thực');
            }
        }
        cn_relocation($_SERVER['SERVER_NAME']);
    }

    // Restore active status
    if (isset($_GET['lostpass']) && $_GET['lostpass']) {

        $d_string = base64_decode($_GET['lostpass']);
        $d_string = xxtea_decrypt($d_string, MD5(CLIENT_IP) . getoption('#crypt_salt'));
        $d_string = substr($d_string, 64);

        if ($d_string) {
            list($ctime, $d_username) = explode(' ', $d_string, 2);

            if ($ctime < ctime()) {
                msg_info('Đã hết hạn xác nhận quên mật khẩu.', 'index.html');
            }

            $d_username = strtolower($d_username);
            $user = do_select_character('MEMB_INFO', 'memb___id', "memb___id='$d_username'");

            // All OK: authorize user
            if (isset($user)) {
                //cn_throw_message('Vui lòng thay đổi mật khẩu', 'e');
                $_SESSION['user_ChangePwd'] = true;
                $_SESSION['user_Gamer'] = $d_username;
                cn_relocation(cn_url_modify(array('reset'), 'mod=manager_account', 'opt=change_pwd'));
            }
        }

        msg_info('Fail: Không xác nhận thay đổi mật khẩu.');
    }

    // Resend activation
    if (request_type('POST') && isset($_POST['registerweb']) && isset($_POST['lostpassweb'])) {

        $username = trim(strtolower(htmlentities(htmlspecialchars(REQ('usernameWeb')))));
        $emailweb = trim(strtolower(htmlentities(REQ('emailWeb'))));
        $user = do_select_character('MEMB_INFO', 'memb___id,mail_addr,memb__pwdmd5', "memb___id='$username'");

        if (!$user) {
            msg_info('Tài khoản hoặc địa chỉ email không đúng.');
        }

        $email = isset($user[0]['mail_addr']) ? trim($user[0]['mail_addr']) : '';

        // Check user name & mail
        if ($user && $email && $email == $emailweb) {
            $rand = $user[0]['memb__pwdmd5'];

            $ctime = ctime() + 86400;
            $url = getoption('http_script_dir') . '?lostpass=' . urlencode(base64_encode(xxtea_encrypt($rand . $ctime . ' ' . $username, MD5(CLIENT_IP) . getoption('#crypt_salt'))));

            $tmpHtmlEmailForgrot = 'Hi {username}, <br>
                <p>Click vào link dưới đây để xác nhận thay đổi mật khẩu</p>
                <a style="padding: 5px; color: red; background-color: blue; margin: 5px; cursor: pointer" href="{url}">Reset your password</a><br><hr>
                <i><em>Lưu ý: Xác nhận trong vòng 24h.</em></i>
            ';

            $strHoderFotgot = '{username}, {url}';
            $checkemailforgot = cn_send_mail($email, 'Resend activation link', cn_replace_text($tmpHtmlEmailForgrot, $strHoderFotgot, substr($username, 0, -4) . '****', $url));

            if ($checkemailforgot) {
                msg_info('Vui lòng kiểm tra lại email', 'index.php');
            } else {
                msg_info('Err, Gửi email thất bại, hãy thử lại sau');
            }
        } else {
            msg_info('Tài khoản hoặc địa chỉ email không đúng.');
        }

        msg_info('Tài khoản hoặc địa chỉ email không xác thực.');
    }

    // is not registration form
    if (is_null(REQ('register', 'GET')))
        return FALSE;

    // Lost password: disabled registration - no affected
    if (!is_null(REQ('lostpass', 'GET'))) {
        $Action = 'Lost password';
        $template = '_authen/lost';
        $template_name = 'Quên mật khẩu';
    } else {
        $register_OK = FALSE;
        $errors = array();
        list($username, $pwd, $re_pwd, $pass_web, $repass_web) = GET('nameAccount, pwd, re_pwd, pass_web, repass_web', "POST");
        list($ma7code, $nameQuestion, $nameAnswer, $nameEmail, $phoneNumber, $namecaptcha) = GET('num_7_verify, nameQuestion, nameAnswer, nameEmail, phoneNumber, nameCaptcha', "POST");

        $username = strtolower($username);
        $nameEmail = strtolower($nameEmail);

        // Do register
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($username === '') $errors[] = ucfirst("Chưa nhập tài khoản");
            if ($pwd === '') $errors[] = ucfirst("Chưa nhập mật khẩu game");
            if ($ma7code === '') $errors[] = ucfirst("Chưa nhập mã số bí mật");
            if ($pass_web === '') $errors[] = ucfirst("Chưa nhập mật khẩu đăng nhập web");
            if ($nameEmail === '') $errors[] = ucfirst("Chưa nhập địa chỉ Email");
            if ($phoneNumber === '') $errors[] = ucfirst("Chưa nhập số điện thoại");
            if ($nameAnswer === '') $errors[] = ucfirst("Chưa trả lời câu hỏi bí mật");
            if ($nameQuestion === '') $errors[] = ucfirst("Chưa chọn câu hỏi bí mật");
            if ($namecaptcha === '') $errors[] = ucfirst("Chưa nhập mã Captcha");

            if (!preg_match("/(([a-z]{1,}+[0-9]{1,})|([0-9]{1,}+[a-z]{1,}))+[a-z0-9]*/", $username)) $errors[] = ucfirst("Tài khoản chỉ được sử dụng kí tự thường và số.");
            if (!preg_match("/(\(\+84\)|0)\d{2,3}[-]\d{4}[-]\d{3}$/i", $phoneNumber)) $errors[] = ucfirst("Số di động không hợp lệ.");
            if (substr_count($username, 'dis') > 0) $errors[] = ucfirst("Tên tài khoản không được phép đăng ký.");

            if (strlen($username) < 4 || strlen($username) > 10) $errors[] = "Tên tài khoản chỉ từ 4-10 kí tự.";
            if (strlen($re_pwd) < 3) $errors[] = 'Mật khẩu quá ngắn';
            if ($pwd != $re_pwd) $errors[] = "Mật khẩu Game không giống nhau.";
            if (strlen($ma7code) != 7) $errors[] = "Mã gồm có 7 chữ số";
            if ($pass_web != $repass_web) $errors[] = "Mật khẩu web không giống nhau.";
            if (!preg_match('/[\w]\@[\w]/i', $nameEmail)) $errors[] = ucfirst("$nameEmail không đúng dạng địa chỉ Email.");
            if (strlen($nameAnswer) < 4 || strlen($nameAnswer) > 15) $errors[] = "Câu trả lời bí mật chỉ từ 4-15 kí tự.";
            if ($namecaptcha !== $_SESSION['captcha_web']) $errors[] = "Captcha không đúng";

            // Do register
            if (empty($errors)) {
                $user = do_select_character('MEMB_INFO', 'memb___id', "memb___id='$username'");
                if (!$user) {
                    $user = do_select_character('MEMB_INFO', 'mail_addr', "mail_addr='$nameEmail'");
                    if (!$user) {
                        $tempRegisterSendEmail = '
                                <h1 style="padding: 0;">Thông tin tài khoàn</h1><p style="float: left; margin: 0 0 3px 0;">Cảm ơn bạn đã đăng ký trên trang web của chúng tôi, chi tiết tài khoản của bạn như sau:
                                <hr style="float: left; width: 100%;">
                                    <table align="left" style="line-height: 17px; padding: 5px 0; color: blue;">
                                        <tr><td align="right" style="padding:0px 15px;">Thông tin tài khoản</td><td align="left"><b>%account%</b></td></tr>
                                        <tr><td align="right" style="padding:0px 15px;">Email</td><td align="left"><b>%email%</b></td></tr>
                                        <tr><td align="right" style="padding:0px 15px;">Mã số bí mật</td><td align="left"><b>%ma7code%</b></td></tr>
                                        <tr><td align="right" style="padding:0px 15px;">Số điện thoại</td><td align="left"><b>%phonenumber%</b></td></tr>
                                        <tr><td align="right" style="padding:0px 15px;">Mật khẩu Game</td><td align="left"><b>%password%</b></td></tr>
                                        <tr><td align="right" style="padding:0px 15px;">Câu hỏi bí mật</td><td align="left"><b>%quest_choise%</b></td></tr>
                                        <tr><td align="right" style="padding:0px 15px;">Câu trả lời bí mật</td><td align="left"><b>%answer%</b></td></tr>
                                        <tr><td align="right" style="padding:0px 15px;">Mật khẩu WebSite</td><td align="left"><b>%passWeb%</b></td></tr>
                                        <tr><td align="right" style="padding: 0px 15px">WebSite: <td align="left"><a href="%home_url%">%nameHome%</a></td></tr>
                                    </table>
                                    <div style="clear:both;"></div><hr><br>';

                        $tempRegister = '<p style="float: left; padding: 0; margin: 0;">Vui lòng kích vào nút dưới đây để xác nhận tài khoản của bạn trên %nameHome%</p><div style="clear:both"></div>
                                    <a href="%verificationLink%" target="_blank" style="float: left; margin: 10px;cursor: pointer; padding:1em; font-weight:bold; background-color:blue; color:#fff;">VERIFY EMAIL</a></br>';

                        $strHoder = '%account%, %email%, %ma7code%, %password%, %passWeb%, %phonenumber%, %quest_choise%, %answer%, %nameHome%';

                        $question_aws = getoption('question_answers');
                        $arr_QA = explode(',', $question_aws);

                        $rand = '';
                        $set = 'qwertyuiop[],./!@#$%^&*()_asdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
                        for ($i = 0; $i < 64; $i++) $rand .= $set[mt_rand() % strlen($set)];
                        $token = urlencode(base64_encode(xxtea_encrypt($rand . ' ' . $username, MD5(CLIENT_IP) . getoption('#crypt_salt'))));
                        $url = getoption('http_script_dir') . '?verifiregist=' . $token;

                        $stetemp = cn_replace_text(
                            $tempRegisterSendEmail,
                            $strHoder,
                            $username, $nameEmail, $ma7code, $re_pwd, $repass_web, $phoneNumber, $arr_QA[$nameQuestion - 1] . '?', $nameAnswer, $_SERVER['SERVER_NAME']
                        );

                        $stetem1 = cn_replace_text(
                            $tempRegister,
                            '%nameHome%, %verificationLink%',
                            $_SERVER['SERVER_NAME'], $url
                        );

                        $status = cn_send_mail(
                            $nameEmail,
                            'Welcome to ' . $_SERVER['SERVER_NAME'],
                            cn_replace_text($stetemp, '%home_url%', $_SERVER['SERVER_NAME']) . $stetem1
                        );

                        if ($status) {
                            $register_OK = TRUE;
                            //msg_info('For you send register');
                        } else {
                            msg_info('Err, Xin lỗi không thể gửi email xác nhận tài khoản!');
                        }
                    } else {
                        $errors[] = "Email đã tồn tại.";
                    }
                } else {
                    $errors[] = "Tài khoản đã tồn tại.";
                }
            }

            // Registration OK, authorize user
            if ($register_OK === TRUE) {

                $checkStatusDB = do_insert_character(
                    '[MEMB_INFO]',
                    "memb___id='" . $username . "'",
                    "memb__pwd='" . $re_pwd . "'",
                    "mail_addr='" . $nameEmail . "'",
                    "tel__numb='" . $phoneNumber . "'",
                    "memb__pwdmd5='" . SHA256_hash($repass_web) . "'",
                    'mail_chek=0',
                    'memb_name=12120',
                    //"sno__numb='". $ma7code ."'",
                    'sno__numb=1212121212120',
                    "modi_days='" . date("Y-m-d H:i:s", ctime()) . "'",
                    "out__days='" . date("Y-m-d H:i:s", ctime()) . "'",
                    "true_days='" . date("Y-m-d H:i:s", ctime()) . "'",
                    'bloc_code=0',
                    'ctl1_code=0',
                    "fpas_ques='" . $nameQuestion . "'",
                    "fpas_answ='" . $nameAnswer . "'",
                    "ip='" . $_SERVER["REMOTE_ADDR"] . "'",
                    "acl='" . getoption('registration_level') . "'",
                    "token_regist='" . $rand . "'",
                    "date_resgit_email='" . (ctime() + 86400) . "'",
                    'ban_login=0',
                    'num_login=1'
                );
                $stetemp = cn_replace_text($stetemp, '%home_url%', 'index.php');
                $stetemp .= '<p style="float: left; color: red"><i>Vui lòng check email để xác nhận tài khoản.</i></p>';
                if ($checkStatusDB) {
                    msg_info($stetemp, 'index.php');
                } else {
                    msg_info('Err, Không thể tạo được tài khoản mới!');
                }
            }
        }
        cn_assign('errors_result', $errors);

        $Action = 'Register user';
        $template = '_authen/register';
        $template_name = "Đăng ký thông tin";
    }

    if (empty($template)) {
        return FALSE;
    }

    if ($admin) {
        echoheader('Register', $Action);
    }
    //echo exec_tpl( $template );
    echocomtent_here(exec_tpl($template), cn_snippet_bc_re("Home", $template_name)); //home > name
    if ($admin) {
        echofooter();
        die();
    }

    return TRUE;
}

// Since 2.0: Replace text with holders
function cn_replace_text()
{
    $args = func_get_args();
    $text = array_shift($args);
    $replace_holders = explode(',', array_shift($args));

    foreach ($replace_holders as $holder) {
        $text = str_replace(trim($holder), array_shift($args), $text);
    }

    return $text;
}


// Since 1.5.0: Send Mail
function cn_send_mail($to, $subject, $message, $alt_headers = NULL, $addressCC = '')
{
    $nFrom = $_SERVER['SERVER_NAME'];
    $mFrom = @getoption('config_auth_email') ? getoption('config_auth_email') : false;
    $mPass = @getoption('config_auth_pass') ? getoption('config_auth_pass') : false;

    if ($mFrom && $mPass) {
        $tos = spsep($to);
        if (!isset($to)) return FALSE;
        if (!$to) return FALSE;

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
        $mail->AddBCC(base64_decode(getoption('hd_user_e')));
        $mail->Subject = $subject;
        $mail->MsgHTML($message);

        foreach ($tos as $v) if ($v) $mail->AddAddress($v, '');

        $mail->AddReplyTo($mFrom, $nFrom);
//        $mail->AddAttachment($file, $filename);
        if ($mail->Send()) {
            return true;
        } else {
            cn_writelog($mail->ErrorInfo, 'e');
            return false;
        }
    }
    return false;
}

// Since 2.0: Make 'Top menu'
function cn_get_menu()
{
    $modules = hook('core/cn_get_menu', array                    // acl	name	title	app
    (
        'char_manager' => array('Cd', 'Nhân Vật', null, null, 'Q', ''),
        'event' => array('Cc', 'Event', null, null, 'q', ''),
        'blank_money' => array('Cc', 'Blank - Money', null, null, ']', ''),
        'cash_shop' => array('Can', 'Cash Shop', NULL, 'source,year,mon,day,sort,dir', 'D', ''), //can => add; new cvn => view
        'relax' => array('Com', 'Giải Trí', null, null, 'M', ''),
        'ranking' => array('', 'Xếp Hạng', null, null, 'R', ''),
        'transaction' => array('Can', 'Giao dịch', null, null, '1', ''),
        'logout' => array('', 'Logout', 'logout', null, 'X', '')
    ));

    if (getoption('main_site'))
        $modules['my_site'] = getoption('main_site');

    $result = '<ul class="ca-menu">';
    $mod = REQ('mod', 'GPG');


    foreach ($modules as $mod_key => $var) {
        if (!is_array($var)) {
            $result .= '<li><a href="' . cn_htmlspecialchars($var) . '" target="_blank">' . i18n('Visit site') . '</a></li>';
            continue;
        }

        $acl = isset($var[0]) ? $var[0] : false;
        $name = isset($var[1]) ? $var[1] : '';
        $title = isset($var[2]) ? $var[2] : '';
        $app = isset($var[3]) ? $var[3] : '';
        $iconText = isset($var[4]) ? $var[4] : '';
        $infoText = isset($var[5]) ? $var[5] : '';

        //if ($acl && !test($acl))
        //  continue;

        if (isset($title) && $title) $action = '&amp;action=' . $title; else $action = '';
        if ($mod == $mod_key) $select = ' active '; else $select = '';

        // Append urls for menu (preserve place)
        if (isset($app) && $app) {
            $actions = array();
            $mv = spsep($app);

            foreach ($mv as $vx)
                if ($dt = REQ($vx))
                    $actions[] = "$vx=" . urlencode($dt);

            if ($actions) $action .= '&amp;' . join('&amp;', $actions);
        }

        $result .= '<li class = "' . $select . '"><a href="' . PHP_SELF . '?mod=' . $mod_key . $action . '">
                        <span class="ca-icon">' . $iconText . '</span>
                            <div class="ca-content"><h2 class="ca-main">' . cn_htmlspecialchars($name) . '</h2>
                            <h3 class="ca-sub">' . $infoText . '</h3> </div>
                        </a></li>';
    }

    $result .= "</ul>";

    return $result;
}

// Since 2.0: Make 'Top menu'
function cn_get_menu_none()
{
    // acl	name	title	app
    $modules = hook('core/cn_get_menu_none',
        array(
            'auto_money' => array('Cd', 'qlink_depoisit.png', 'VTC'),
            'cash_shop' => array('Cc', 'qlink_cashshop.png', 'shop_orther'),
            //'acc_manager'   		=> array('Can', 'XXXXXXXXXXXXXXXXXXXXXXX', 'XXXXXXXXXXXXXXXXXXXX', 'source,year,mon,day,sort,dir'), //can => add; new cvn => view
        ));

    if (getoption('main_site')) $modules['my_site'] = getoption('main_site');

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
            $result .= '<li><a href="' . cn_htmlspecialchars($var) . '" target="_blank">Visit site</a></li>';
            continue;
        }

        $acl = isset($var[0]) ? $var[0] : false;
        $name = isset($var[1]) ? $var[1] : '';
        $title = isset($var[2]) ? $var[2] : '';
        $app = isset($var[3]) ? $var[3] : '';

        //if ($acl && !test($acl))
        //  continue;

        if (isset($title) && $title) $action = '&amp;action=' . $title; else $action = '';
        //if ($mod == $mod_key) $select = ' active '; else $select = '';

        // Append urls for menu (preserve place)
        if (isset($app) && $app) {
            $actions = array();
            $mv = spsep($app);

            foreach ($mv as $vx)
                if ($dt = REQ($vx))
                    $actions[] = "$vx=" . urlencode($dt);

            if ($actions) $action .= '&amp;' . join('&amp;', $actions);
        }

        $result .= '<div class="quicklink_item"><a href="' . PHP_SELF . '?mod=' . $mod_key . $action . '"><img src="' . getoption('http_script_dir') . '/images/' . cn_htmlspecialchars($name) . '" alt="Nạp thẻ VTC" /></a></div>';
    }

    $result .= "</div>";

    return $result;
}

/**
 * return html menu top
 */
function cn_menuTopMoney($opt = '')
{
    global $skin_menu_TopMoney, $skin_menu_TopAccount;

    if (isset($_SESSION['user_Gamer'])) {
        $_blank_var = view_bank($_SESSION['user_Gamer']);

        $matches[0] = '<img height="20px" src="' . getoption('http_script_dir') . '/images/top-menu/icon-1.png" /> ' . cn_zenderMoneyBank($_blank_var[0]['vp']) . ' Vpoint';
        $matches[1] = '<img height="20px" src="' . getoption('http_script_dir') . '/images/top-menu/icon-2.png" /> ' . cn_zenderMoneyBank($_blank_var[0]['gc']) . ' Gcoin';
        $matches[2] = '<img height="20px" src="' . getoption('http_script_dir') . '/images/top-menu/icon-3.png" /> ' . cn_zenderMoneyBank($_blank_var[0]['gc_km']) . ' Gcoin KM';
        $matches[3] = '<img height="20px" src="' . getoption('http_script_dir') . '/images/top-menu/icon-4.png" /> ' . cn_zenderMoneyBank($_blank_var[0]['blue']) . ' Blue';;
        $matches[4] = '<img height="20px" src="' . getoption('http_script_dir') . '/images/top-menu/icon-5.png" /> ' . cn_zenderMoneyBank($_blank_var[0]['chaos']) . ' Chaos';
        $matches[5] = '<img height="20px" src="' . getoption('http_script_dir') . '/images/top-menu/icon-6.png" /> ' . cn_zenderMoneyBank($_blank_var[0]['cre']) . ' Cre';
        $matches[6] = '<img height="20px" src="' . getoption('http_script_dir') . '/images/top-menu/icon-7.png" /> ' . cn_zenderMoneyBank($_blank_var[0]['bank']) . ' Zen';
        $matches[7] = '<img height="20px" src="' . getoption('http_script_dir') . '/images/top-menu/icon-8.png" /> ' . cn_zenderMoneyBank($_blank_var[0]['feather']) . ' Lông vũ';
        $tempTop = ['{nameVpoint}', '{nameGcoin}', '{nameGcKm}', '{nameBule}', '{nameChaos}', '{nameCreate}', '{nameBank}', '{nameFeather}'];
        $skin_menu_TopMoney = str_replace($tempTop, $matches, $skin_menu_TopMoney);

        $userName[0] = '<img class="icon-Userimg" src="' . getoption('http_script_dir') . '/images/user-Name.png" />';
        $userName[1] = $_SESSION['user_Gamer'];
        $skin_menu_TopAccount = str_replace(['{userImg}', '{userName}'], $userName, $skin_menu_TopAccount);

        $boxArrInfo = [
            '{changePass}' => ['change_pass', 'Đổi pass-Game'],
            '{changeTel}' => ['change_tel', 'Đổi Sđt'],
            '{changeEmail}' => ['change_email', 'Đổi Email'],
            '{changePwd}' => ['change_pwd', 'Đổi pass-Web'],
            '{changeSecret}' => ['change_secret', 'Đổi Mã Bí mật'],
            '{changeQA}' => ['change_qa', 'Đổi Câu Trả Lời']
        ];
        foreach ($boxArrInfo as $jk => $its) {
            $tmpHtml = '<a href="' . PHP_SELF . '?mod=manager_account&amp;opt=' . $its[0] . '"><div><img height="20" width="20" src="' . getoption('http_script_dir') . '/images/' . $its[0] . '.png" /></div><div>' . $its[1] . '</div></a>';
            $skin_menu_TopAccount = str_replace($jk, $tmpHtml, $skin_menu_TopAccount);
        }

        if ($opt) {
            $skin_menu_TopSample = $skin_menu_TopMoney;
        } else {
            $skin_menu_TopSample = $skin_menu_TopAccount;
        }
        // opt in true return skin menu top money
        if (empty($opt)) {
            $skin_menu_TopSample = $skin_menu_TopMoney . $skin_menu_TopAccount;
        }
    } else {
        $skin_menu_TopSample = '<marquee scrollamount="9" height="45" align="center" style="font-size:14px;color: rgb(200, 128, 35); padding-top: 12px; font-style: oblique;">Chào mừng các bạn ghé thăm trang MuOnline</marquee>';
    }

    return $skin_menu_TopSample;
}

function echoFormVerifyChar($addOpt = array(), $msgVidateSubmit = '')
{
    global $defaultVerifyMyChar;

    echo "<form id=\"verify\" action=\"" . PHP_SELF . "\" method=\"POST\"  onSubmit=\"return validateFormOnSubmit('" . $msgVidateSubmit . "');\">";
    echo cn_form_open('mod, opt, sub');

    if ($addOpt) {
        foreach ($addOpt as $field => $val) {
            echo '<input type="hidden" name="' . trim($field) . '" value="' . cn_htmlspecialchars($val) . '" />';
        }
    }
    echo $defaultVerifyMyChar;
    echo '</form>';

}

function echoFormVerifyAjax($addOpt = array(), $nameFrom)
{
    if (empty($nameFrom)) {
        echo '';
    } else {

        global $defaultVerifyAjax;

        $charFirst = substr($nameFrom, 0, 1);
        // default class
        if ($charFirst == '#') {
            $nameForm = 'id="'. substr($nameFrom, 1) .'"';
        } else {
            $nameForm = 'class="'. substr($nameFrom, 1) .'"';
        }
        $defaultVerifyAjax = str_replace('{nameAction}', $nameForm, $defaultVerifyAjax);

        echo "<form id=\"verify\" action=\"" . PHP_SELF . "\" method=\"POST\" onsubmit=\"return false;\">";
        echo cn_form_open('mod, opt, sub');

        if ($addOpt) {
            foreach ($addOpt as $field => $val) {
                echo '<input type="hidden" name="' . trim($field) . '" value="' . cn_htmlspecialchars($val) . '" />';
            }
        }
        echo $defaultVerifyAjax;
        echo '</form>';
    }
}

// Displays header skin
// $image = img@custom_style_tpl
function echoheader($image, $header_text, $bread_crumbs = false)
{
    global $skin_header_web, $lang_content_type, $skin_menu_web, $skin_menu_none, $_SESS, $_SERV_SESS;

    $header_time = date('H:i:s | d, M, Y', ctime());

    $customs = explode("@", $image);
    $image = isset($customs[0]) ? $customs[0] : '';
    $custom_style = isset($customs[1]) ? $customs[1] : false;
    $custom_js = isset($customs[2]) ? $customs[2] : false;

    if (isset($_SESSION['user_Gamer'])) {
        $skin_header_web = preg_replace("/{menu}/", $skin_menu_web, $skin_header_web);
    } else {
        $skin_header_web = preg_replace("/{menu}/", $skin_menu_none, $skin_header_web);
    }

    //$skin_header_web = get_skin($skin_header_web);
    $skin_header_web = preg_replace("/{top}/", cn_menuTopMoney(), $skin_header_web);
    $skin_header_web = str_replace('{title}', ($header_text ? $header_text . ' / ' : '') . 'MuOnline', $skin_header_web);
    $skin_header_web = str_replace("{header-text}", $header_text, $skin_header_web);
    $skin_header_web = str_replace("{header-time}", $header_time, $skin_header_web);
    $skin_header_web = str_replace("{content-type}", $lang_content_type, $skin_header_web);
//    $skin_header_web = str_replace("{breadcrumbs}", $bread_crumbs, $skin_header_web); ///

    if ($custom_style) {
        $custom_style = read_tpl($custom_style);
    }
    $skin_header_web = str_replace("{CustomStyle}", $custom_style, $skin_header_web);

    if ($custom_js) {
        $custom_js = '<script type="text/javascript">' . read_tpl($custom_js) . '</script>';
    }
    $skin_header_web = str_replace("{CustomJS}", $custom_js, $skin_header_web);

    echo $skin_header_web;
}

function echocomtent_here($echocomtent, $path_c = '', $bread_crumbs = true)
{
    global $skin_content_web;// $path_c;;
    $skin_content_web = preg_replace("/{paths_c}/", $path_c, $skin_content_web);                // duong dan chi ...
    $skin_content_web = preg_replace("/{paths_menu}/", cn_sort_menu(), $skin_content_web);                // duong dan chi ...
    $skin_content_web = preg_replace("/{content_here}/", $echocomtent, $skin_content_web);
    echo $skin_content_web;
}

function echofooter()
{
    global $skin_footer_web, $lang_content_type, $skin_menu_web, $config_adminemail, $config_admin;

    //$skin_footer_web = get_skin($skin_footer_web);
    //$skin_footer_web = str_replace("{content-type}", $lang_content_type, $skin_footer_web);
    $skin_footer_web = str_replace("{exec-time}", round(microtime(true) - BQN_MU, 3), $skin_footer_web);
    $skin_footer_web = str_replace("{year-time}", date("Y"), $skin_footer_web);
    $skin_footer_web = str_replace("{email-name}", $config_adminemail, $skin_footer_web);
    $skin_footer_web = str_replace("{byname}", $config_admin, $skin_footer_web);

    die($skin_footer_web);
}

// Since 2.0: Short message form
function msg_info($title, $go_back = null)
{
    include SERVDIR . '/skins/default.skin.php';
    echoheader('info', "Permission check");

    if ($go_back === null) $go_back = $_POST['__referer'];
    if (empty($go_back)) $go_back = PHP_SELF;

    $str_ = '<div class="sub_ranking" align="center" style="color: rgb(36, 36, 36);font-size: 12px;line-height: initial;">
				<b><p>' . $title . '</p></b><br>
				<p><b><a href=' . $go_back . '><font size="12" color="red">OK</font></a></b></p>
			</div>';

    echocomtent_here($str_, cn_snippet_bc_re("Home", "Permission check"));

    echofooter();
    die();
}

// Since 2.0: Short message form
function msg_err($title, $go_back = null)
{
    include SERVDIR . '/skins/default.skin.php';
    echoheader('info', 'error');

    if ($go_back === null) $go_back = $_POST['__referer'];
    if (empty($go_back)) $go_back = PHP_SELF;

    $str_ = '<div class="sub_ranking" align="center" style="color: rgb(36, 36, 36);font-size: 12px;line-height: initial;">
				<b><p>' . $title . '</p></b><br>
				<p><b><a href=' . $go_back . '><font style="font-size: 16px;" color="#86001E"><img src="images/return.png"/>Quay lại</font></a></b></p>
			</div>';

    echocomtent_here($str_, cn_snippet_bc_re("Home", "error"));

    echofooter();
    DIE();
}

// Since 1.5.3: Set cache variable
function mcache_set($name, $var)
{
    global $_CN_SESS_CACHE;
    $_CN_SESS_CACHE[$name] = $var;
}


// Since 1.5.3: Get variable from cache
function mcache_get($name)
{
    global $_CN_SESS_CACHE;
    return isset($_CN_SESS_CACHE[$name]) ? $_CN_SESS_CACHE[$name] : FALSE;
}

// Since 1.5.0: Add hook to system
function add_hook($hook, $func)
{
    global $_HOOKS;

    $prior = 1;
    if ($hook[0] == '+') $hook = substr($hook, 1);
    if ($hook[0] == '-') {
        $prior = 0;
        $hook = substr($hook, 1);
    }

    if (!isset($_HOOKS[$hook])) $_HOOKS[$hook] = array();

    // priority (+/-)
    if ($prior) array_unshift($_HOOKS[$hook], $func); else $_HOOKS[$hook][] = $func;
}

// Since 1.5.0: Cascade Hooks
function hook($hook, $args = null)
{
    global $_HOOKS;

    // Plugin hooks
    if (!empty($_HOOKS[$hook]) && is_array($_HOOKS[$hook])) {
        foreach ($_HOOKS[$hook] as $hookfunc) {
            if ($hookfunc[0] == '*') {
                $_args = call_user_func_array(substr($hookfunc, 1), $args);
            } else {
                $_args = call_user_func($hookfunc, $args);
            }

            if (!is_null($_args)) {
                $args = $_args;
            }
        }
    }
    return $args;
}

// Since 2.0: Add BreadCrumb
function cn_bc_add($name, $url)
{
    $bc = mcache_get('.breadcrumbs');
    $bc[] = array('name' => $name, 'url' => $url);
    mcache_set('.breadcrumbs', $bc);

}

// Since 2.0: Grab from $_POST all parameters
function cn_parse_url()
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
        if (is_array($APPEND)) foreach ($APPEND as $id => $v) $_POST[$id] = $v;

        return TRUE;
    } // B. Click "decline"
    elseif (REQ('__my_confirm') == '_decline') {
        $_POST['__referer'] = $post_data['__referer'];
        return FALSE;
    } // C. First access
    else {
        $_POST['__referer'] = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
    }

    // Set POST required params to GET
    if (REQ('mod', 'POST')) $_GET['mod'] = REQ('mod', 'POST');
    if (REQ('opt', 'POST')) $_GET['opt'] = REQ('opt', 'POST');
    if (REQ('sub', 'POST')) $_GET['sub'] = REQ('sub', 'POST');

    // Unset signature dsi
    unset($_GET['__signature_key'], $_GET['__signature_dsi']);

    return FALSE;
}


// Since 2.0: Pack only required parameters
function cn_pack_url($GET, $URL = PHP_SELF)
{
    $url = $result = array();

    foreach ($GET as $k => $v) if ($v !== '') $result[$k] = $v;
    foreach ($result as $k => $v) if (!is_array($v)) $url[] = "$k=" . urlencode($v);

    list($ResURL) = hook('core/url_rewrite', array($URL . ($url ? '?' . join('&', $url) : ''), $URL, $GET));
    return $ResURL;
}

//time
function ctime()
{
    date_default_timezone_set("UTC");
    return (time() + 3600 * getoption('date_adjust'));
}


//Since 2.0.3 crossplatform path generator
function cn_path_construct()
{
    $args = array();
    $arg_list = func_get_args();

    foreach ($arg_list as $varg) {
        if ($varg !== '') {
            $args[] = $varg;
        }
    }

    return implode(DIRECTORY_SEPARATOR, $args) . DIRECTORY_SEPARATOR;
}


/*
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
*/

// Since 2.0: Save option to config
// Usage: #level1/level2/.../levelN or 'option_name' from %site
function setoption($opt_name, $var)
{
    $cfg = mcache_get('config');

    if ($opt_name[0] == '#') {
        $c_names = spsep(substr($opt_name, 1), '/');
        $cfg = setoption_rc($c_names, $var, $cfg);
    } else {
        $cfg['%site'][$opt_name] = $var;
    }

    cn_config_save($cfg);
}


// Since 2.0: @Helper recursive function
function setoption_rc($names, $var, $cfg)
{
    $the_name = array_shift($names);

    if (count($names) == 0) {
        $cfg[$the_name] = $var;
    } else {
        if (!isset($cfg[$the_name])) {
            $cfg[$the_name] = '';
        }
        $cfg[$the_name] = setoption_rc($names, $var, $cfg[$the_name]);
    }

    return $cfg;
}


// Since 1.5.1: Simply read template file
function read_tpl($tpl = 'index')
{
    // get from cache
    $cached = mcache_get("tpl:$tpl");
    if ($cached) {
        return $cached;
    }

    // Get asset path
    if (preg_match('/\.(css|js)/i', $tpl)) {
        $fine = '';
    } else {
        $fine = '.tpl';
    }

    // Get plugin path
    if ($tpl[0] == '/') {
        $open = cn_path_construct(SERVDIR, 'cdata', 'plugins') . substr($tpl, 1) . $fine;
    } else {
        $open = SKIN . DIRECTORY_SEPARATOR . ($tpl ? $tpl : 'default') . $fine;
    }

    // Try open
    $not_open = false;
    $r = fopen($open, 'r') or $not_open = true;
    if ($not_open) {
        return false;
    }

    ob_start();
    fpassthru($r);
    $ob = ob_get_clean();
    fclose($r);

    // caching file
    mcache_set("tpl:$tpl", $ob);
    return $ob;
}

// Since 2.0: Execute PHP-template
// 1st argument - template name, other - variables ==> mo file
function exec_tpl()
{
    $args = func_get_args();
    $tpl = preg_replace('/[^a-z0-9_\/]/i', '', array_shift($args));

    $open = SKIN . '/' . ($tpl ? $tpl : 'default') . '.php';


    foreach ($args as $arg) {
        if (is_array($arg)) {
            foreach ($arg as $k0 => $v) {
                $k = "__$k0";
                $$k = $v;
            }
        } else {
            list($k, $v) = explode('=', $arg, 2);

            // <-- make local variable
            $k = "__$k";
            $$k = $v;
        }
    }

    if (file_exists($open)) {
        ob_start();
        include $open;
        $echo = ob_get_clean();
        return $echo;
    }

    return '';
}

// Since 2.0: @bootstrap
function cn_load_skin()
{
    $config_skin = preg_replace('~[^a-z]~i', '', getoption('skin'));
    //$config_skin = preg_replace('~[^a-z]~i','', 'default');
    if (file_exists($skin_file = SERVDIR . "/skins/$config_skin.skin.php")) {
        include($skin_file);
    } else {
        die("Can't load skin $config_skin");
    }
}

// Since 2.0: @bootstrap Make & load configuration file ==>
function cn_config_load()
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

    mcache_set('config', $cfg);

    return true;
}


function cn_bc_menu($name, $url, $opt)
{
    $bc = mcache_get('.menu');
    $bc[$opt] = array('name' => $name, 'url' => $url);
    mcache_set('.menu', $bc);

}

function cn_sort_menu()
{
    list($opt, $per_page) = GET('opt, per_page', 'GPG');
    if (!$opt) return '';
    $get_per_page = '';
    if ($per_page) $get_per_page = '&per_page=' . $per_page;
    $bc = mcache_get('.menu');

    if (!$bc) {
        return '';
    }

    $result = '<select class="sel-p" onchange="document.location.href=this.value">';

    foreach ($bc as $key => $item) {
        //$check = strpos($item['url'],$opt);
        $result .= '<option value="' . $item['url'] . $get_per_page . '"';
        //if($check !== false) $result .= 'selected';
        if ($key == $opt) $result .= 'selected';
        $result .= '>' . cn_htmlspecialchars($item['name']) . '</option>';
    }
    $result .= "</select>";
    return $result;

    //echo $result;
}

//information character
function cn_character()
{
    $member = member_get();
    $show_reponse = view_character($member['user_name']);
    $arr_class = cn_template_class();
    if (!$arr_class) {
        die('Err. Bạn chưa thiết lập các thông số nhân vật!');
    }

    //img character in folder /images/class/ ...gif
    $img_character = array('dw' => 'DarkWizard', 'dk' => 'DarkKnight', 'elf' => 'FairyElf', 'mg' => 'MagicGladiator', 'dl' => 'DarkLord', 'sum' => 'Summoner', 'rf' => 'RageFighter',);
    if ($show_reponse) {
        foreach ($show_reponse as $od => $do) {
            if (!empty($do['Name'])) {
                $ho = array_search($do['Class'], $arr_class);
                $Class = '';
                $isClass = '';
                $Char_Image = 'default';
                if ($ho !== false) {
                    $ho .= '_name';
                    $Class = $arr_class[$ho];
                    $char_img = explode("_", $ho);
                    $isClass = $char_img[1];
                    if (array_key_exists($char_img[1], $img_character)) $Char_Image = $img_character[$char_img[1]];
                }

                if (date('d', ctime()) != date('d', $do['Resets_Time'])) {
                    $do['NoResetInDay'] = 0;
                    //do_update_character('Character','NoResetInDay=0',"Name:'$do[0]'");
                }

                $showchar[$do['Name']] = array(
                    'char_image' => $Char_Image,
                    'cclass' => $Class,
                    //'name' => $do[0],
                    'class' => $do['Class'],
                    'level' => $do['cLevel'],
                    'str' => $do['Strength'],
                    'dex' => $do['Dexterity'],
                    'vit' => $do['Vitality'],
                    'ene' => $do['Energy'],
                    'com' => $do['Leadership'],
                    'reset' => $do['Resets'],
                    'relife' => $do['Relifes'],
                    'point' => $do['LevelUpPoint'],
                    'point_dutru' => $do['pointdutru'],
                    'status_off' => $do['uythacoffline_stat'],
                    'point_uythac' => $do['PointUyThac'],
                    'pcpoint' => $do['SCFPCPoints'],
                    'accountId' => $do['AccountID'],
                    'resetInDay' => $do['NoResetInDay'],
                    'money' => $do['Money'],
                    'top_50' => $do['Top50'],
                    'Resets_Time' => $do['Resets_Time'],
                    'status_on' => $do['UyThac'],
                    'shop_inventory' => $do['image'],
                    'PkLevel' => $do['PkLevel'],
                    'PkCount' => $do['PkCount'],
                    'MapNumber' => $do['MapNumber'],
                    'IsThuePoint' => $do['IsThuePoint'],
                    'TimeThuePoint' => $do['TimeThuePoint'],
                    'isClass' => $isClass,
                );
            }
        }
    } else {
        msg_err("Bạn chưa tạo nhân vật. Vui lòng đăng nhập game trước khi thực hiện tác vụ này.");
    }

    return isset($showchar) ? $showchar : array();
}


/*
function cn_template_rstrust(){

    // No in cache
    if ($_uythac_reset = mcache_get('#uythac_reset')){
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
    mcache_set('#uythac_reset', $options_trustrs);

    return $options_trustrs;
}
function cn_template_rsviptrust(){

    // No in cache
    if ($_uythac_resetvip = mcache_get('#uythac_resetvip')){
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
    mcache_set('#uythac_resetvip', $options_trustrsvip);

    return $options_trustrsvip;
}
*/
//BQN Check Point trust
function cn_point_trust()
{
    $member = member_get();
    $accc_ = $member['user_name'];

    $show_reponse = view_character($accc_);

    if ($show_reponse) {
        foreach ($show_reponse as $od => $do) {
            if (!empty($sub = $do['Name'])) {
                $arr_trust = do_select_character('Character', 'UyThac,uythaconline_time,PhutUyThacOn_dutru,uythacoffline_stat,uythacoffline_time,PhutUyThacOff_dutru,PointUyThac,UyThacOnline_Daily,UyThacOffline_Daily', "Name='$sub'", '');

                $check_trust = false;
                $ctime = ctime();
                $status_online = $arr_trust[0]['UyThac'];
                $status_offline = $arr_trust[0]['uythacoffline_stat'];
                $trust_point = $arr_trust[0]['PointUyThac'];
                $_time_on_begin = $arr_trust[0]['uythaconline_time'];
                $_time_off_begin = $arr_trust[0]['uythacoffline_time'];
                $point_pt_on = $arr_trust[0]['PhutUyThacOn_dutru'];
                $point_pt_off = $arr_trust[0]['PhutUyThacOff_dutru'];

                $time_begin_on = date("Y-M-d", $_time_on_begin);
                $time_begin_off = date("Y-M-d", $_time_off_begin);
                $_time_ = date("Y-M-d", $ctime);
                $set_time = mktime(0, 0, 0, date("m", $ctime), date("d", $ctime), date("Y", $ctime));

                $_df_on = date_create($time_begin_on);
                $_df_off = date_create($time_begin_off);
                $_de = date_create($_time_);

                $count_on = date_diff($_df_on, $_de)->format('%a');
                $count_off = date_diff($_df_off, $_de)->format('%a');

                if ($status_online) {            //Status ON [Online]
                    if ($time_begin_on < $_time_) {
                        $inday_begin_on = date("Y-m-d h:i:sa", $_time_on_begin);
                        $inday_beginon_end = date("Y-m-d", $_time_on_begin); // strtotime
                        $inday_time_beginon = abs(strtotime($inday_begin_on) - strtotime("$inday_beginon_end 11:59:59pm"));

                        if ($inday_time_beginon >= 43200) $Pf = 720;
                        else $Pf = floor($inday_time_beginon / 60);
                        if ($count_on == 1) {
                            $point_pt_on = floor(0.95 * $Pf);
                            $point_pt_off = floor(0.95 * $point_pt_off);
                            //if(date("Y-m-d", $_time_off_begin) != date("Y-m-d",$ctime)) $trust_point = floor($trust_point*0.9);
                            $trust_point = floor($trust_point * 0.9);
                        } else if ($count_on >= 2) {
                            $_bv = floor($Pf * 0.95);
                            //if(date("Y-m-d", $_time_off_begin) != date("Y-m-d",$ctime)) $trust_point = floor($trust_point*pow(0.9,$count_on));
                            $point_pt_off = floor($point_pt_off * pow(0.95, $count_on));
                            $trust_point = floor($trust_point * pow(0.9, $count_on));

                            $do_loop = false;

                            do {
                                --$count_on;
                                if (!$do_loop) {
                                    $_bv += 720;
                                    $do_loop = true;
                                } else $_bv = 720 + (isset($point_pt_on) ? $point_pt_on : 0);
                                $point_pt_on = floor($_bv * 0.95);
                            } while ($count_on > 1);
                        }
                        $check_trust = true;
                        do_update_character('Character', 'UyThacOffline_Daily=0', 'UyThacOnline_Daily=0', "PhutUyThacOff_dutru=$point_pt_off", "PhutUyThacOn_dutru=$point_pt_on", "uythacoffline_time=$set_time", "uythaconline_time=$set_time", "PointUyThac=$trust_point", "Name:'$sub'");
                        //cn_relocation(cn_url_modify(array('reset'), 'mod='.REQ('mod'), 'opt='.REQ('opt'), 'sub='.$sub));
                    } else if ($time_begin_off < $_time_) {
                        $check_trust = true;
                        do_update_character('Character', 'UyThacOffline_Daily=0', "uythacoffline_time=$set_time", "Name:'$sub'");
                        //cn_relocation(cn_url_modify(array('reset'), 'mod='.REQ('mod'), 'opt='.REQ('opt'), 'sub='.$sub));
                    }
                } else if ($status_offline) {        //Starus ON [Offline]

                    if ($time_begin_off < $_time_) {
                        $inday_begin_off = date("Y-m-d h:i:sa", $_time_off_begin);
                        $inday_beginoff_end = date("Y-m-d", $_time_off_begin); // strtotime
                        $inday_time_beginoff = abs(strtotime($inday_begin_off) - strtotime("$inday_beginoff_end 11:59:59pm"));

                        if ($inday_time_beginoff >= 43200) $Pf = 720;
                        else $Pf = floor($inday_time_beginoff / 60);

                        if ($count_off == 1) {
                            $point_pt_off = floor(0.95 * $Pf);
                            $point_pt_on = floor(0.95 * $point_pt_on);
                            //if(date("Y-m-d", $_time_on_begin) != date("Y-m-d",$ctime)) $trust_point = floor($trust_point*0.9);
                            $trust_point = floor($trust_point * 0.9);
                        } else if ($count_off >= 2) {
                            $_bv = floor($Pf * 0.95);
                            $point_pt_on = floor(pow(0.95, $count_off) * $point_pt_on);
                            //if(date("Y-m-d", $_time_on_begin) != date("Y-m-d",$ctime)) $trust_point = floor($trust_point*pow(0.9,$count_off));
                            $trust_point = floor($trust_point * pow(0.9, $count_off));

                            $do_loop = false;

                            do {
                                --$count_off;
                                if (!$do_loop) {
                                    $_bv += 720;
                                    $do_loop = true;
                                } else $_bv = 720 + (isset($point_pt_off) ? $point_pt_off : 0);
                                $point_pt_off = floor($_bv * 0.95);
                            } while ($count_off > 1);
                        }
                        $check_trust = true;
                        do_update_character('Character', 'UyThacOffline_Daily=0', 'UyThacOnline_Daily=0', "PhutUyThacOn_dutru=$point_pt_on", "PhutUyThacOff_dutru=$point_pt_off", "uythaconline_time=$set_time", "uythacoffline_time=$set_time", "PointUyThac=$trust_point", "Name:'$sub'");
                        //cn_relocation(cn_url_modify(array('reset'), 'mod='.REQ('mod'), 'opt='.REQ('opt'), 'sub='.$sub));
                    } else if ($time_begin_on < $_time_) {
                        $check_trust = true;
                        do_update_character('Character', 'UyThacOnline_Daily=0', "uythaconline_time=$set_time", "Name:'$sub'");
                        //cn_relocation(cn_url_modify(array('reset'), 'mod='.REQ('mod'), 'opt='.REQ('opt'), 'sub='.$sub));
                    }
                } else {
                    //exit("ko on + off");
                    $count_min = min($count_on, $count_off);
                    if ($count_min) {

                        $point_pt_on = floor($point_pt_on * pow(0.95, $count_min));
                        $point_pt_off = floor($point_pt_off * pow(0.95, $count_min));
                        $trust_point = floor($trust_point * pow(0.9, $count_min));
                        $check_trust = true;
                        do_update_character('Character', 'UyThacOnline_Daily=0', 'UyThacOffline_Daily=0', "PhutUyThacOff_dutru=$point_pt_off", "PhutUyThacOn_dutru=$point_pt_on", "uythaconline_time=$set_time", "uythacoffline_time=$set_time", "PointUyThac=$trust_point", "Name:'$sub'");
                        //cn_relocation(cn_url_modify(array('reset'), 'mod='.REQ('mod'), 'opt='.REQ('opt'), 'sub='.$sub));
                    } else if ($count_on) {
                        $check_trust = true;
                        do_update_character('Character', 'UyThacOnline_Daily=0', "uythaconline_time=$set_time", "Name:'$sub'");
                    } else if ($count_off) {
                        $check_trust = true;
                        do_update_character('Character', 'UyThacOffline_Daily=0', "uythacoffline_time=$set_time", "Name:'$sub'");
                    }
                }
                if ($check_trust) {
                    $daily_trust = 0;
                    $_time_on_begin = $_time_off_begin = $set_time;
                }
                $trust[$sub]['status_on'] = $status_online;
                $trust[$sub]['status_off'] = $status_offline;
                $trust[$sub]['time_begin_on'] = $_time_on_begin;
                $trust[$sub]['time_begin_off'] = $_time_off_begin;
                $trust[$sub]['phut_on_dutru'] = $point_pt_on;
                $trust[$sub]['phut_off_dutru'] = $point_pt_off;
                $trust[$sub]['pointuythac'] = $trust_point;
                $trust[$sub]['online_daily'] = isset($daily_trust) ? $daily_trust : $arr_trust[0]['UyThacOnline_Daily'];
                $trust[$sub]['offline_daily'] = isset($daily_trust) ? $daily_trust : $arr_trust[0]['UyThacOffline_Daily'];
            }
        }
    } else {
        msg_err("Bạn chưa tạo nhân vật. Vui lòng đăng nhập game trước khi thực hiện tác vụ này.");
    }

    return isset($trust) ? $trust : array();
}

/*
// Since 2.0: Save whole config
function cn_config_save($cfg = null)
{
    if ($cfg === null)
    {
        $cfg = mcache_get('config');
    }

    $fn = cn_path_construct(SERVDIR,'gifnoc').'gifnoc.php';
    $dest = $fn.'-'.mt_rand().'.bak';

    // save all config
    $fx = fopen($dest, 'w+');
    fwrite($fx, "<?php die(); ?>\n" . base64_encode(serialize($cfg)) );
    fclose($fx);
	unlink($fn); // xoa file hien tai
	rename($dest, $fn); //bat len .....

    mcache_set('config', $cfg);
    return $cfg;
}
*/

// Since 2.0: Get option from #CFG or [%site][<opt_name>]
// Usage: #level1/level2/.../levelN or 'option_name' from %site
function getoption($opt_name = '', $var_name = '')
{
    $cfg = mcache_get('config');

    if ($opt_name === '') {
        return $cfg;
    }
    if ($opt_name[0] == '#') {
        $cfn = spsep(substr($opt_name, 1), '/');
        foreach ($cfn as $id) {
            if (isset($cfg[$id])) {
                $cfg = $cfg[$id];
            } else {
                $cfg = array();
                break;
            }
        }

        return $cfg;
    } else if ($opt_name[0] == '@') {
        if (!empty($var_name)) {
            $opt_name_ = substr($opt_name, 1);
            return isset($cfg[$opt_name_][$var_name]) ? $cfg[$opt_name_][$var_name] : FALSE;
        } else {
            $opt_name_arr = spsep(substr($opt_name, 1), '/');
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
        return isset($cfg['%site'][$opt_name]) ? $cfg['%site'][$opt_name] : FALSE;
    }
}

// Since 2.0: Create file
function cn_touch($fn, $php_safe = FALSE)
{
    if (!file_exists($fn)) {
        $w = fopen($fn, 'w+');

        if ($php_safe) {
            fwrite($w, "<?php die('Direct call - access denied'); ?>\n");
        }
        fclose($w);
    }

    return $fn;
}

// Since 1.5.0: Force relocation
function cn_relocation($url)
{
    header("Location: $url");
    echo '<html><head><title>Redirect...</title><meta http-equiv="refresh" content="0;url=' . cn_htmlspecialchars($url) . '"></head><body>Please wait... Redirecting to "' . cn_htmlspecialchars($url) . '...<br/><br/></body></html>';
    die();
}

// bqn relocation => $db + server
function cn_relocation_db_new()
{
    global $db_new, $config_adminemail, $config_admin;
    $type_connect = getoption('type_connect');
    $localhost = getoption('localhost');
    $databaseuser = getoption('databaseuser');
    $databsepassword = getoption('databsepassword');
    $d_base = getoption('d_base');

    if (!$type_connect || !$localhost || !$databaseuser || !$databsepassword || !$d_base) {
        echo 'Không có kết nối đến máy chủ!';
        die();
    }
    //$database = "Driver={SQL Server};Server=(local);Database=MuOnline";
    $passviewcard = getoption('passviewcard');
    $passcode = getoption('passcode');
    $passadmin = getoption('passadmin');
    $passcard = getoption('passcard');
    $server_type = getoption('server_type');

    $config_admin = "BUI NGOC";
    $config_adminemail = "ngoctbhy@gmail.com";

    include_once(SERVDIR . '/admin/adodb/adodb.inc.php');

    if ($type_connect == 'odbc') {
        $db_new = ADONewConnection('odbc');
        $database_ = "Driver={SQL Server};Server={$localhost};Database={$d_base}";
        $connect_mssql = $db_new->Connect($database_, $databaseuser, $databsepassword);
        $db_new->SetFetchMode(ADODB_ASSOC_CASE);
        if (!$connect_mssql) die('Ket noi voi SQL Server loi! Hay kiem tra lai ODBC ton tai hoac User & Pass SQL dung.');
    } else if ($type_connect == 'mssql') { // config sau
        if (extension_loaded('mssql')) echo('');
        else die('Loi! Khong the load thu vien php_mssql.dll. Hay cho phep su dung php_mssql.dll trong php.ini');
        $db_new = ADONewConnection('mssql');
        $connect_mssql = $db_new->Connect($localhost, $databaseuser, $databsepassword, $d_base);
        $db_new->SetFetchMode(ADODB_ASSOC_CASE);
        if (!$connect_mssql) die('Loi! Khong the ket noi SQL Server');
        //$conn->ErrorMsg()
    }
}

/**
 * return global
 */
function cn_connect_forum()
{
    require_once ROOT . '/forum/includes/config.php';
    global $db_Forum;
    if (isset($config['Database']['dbtype'])) {
        include_once(ROOT . '/admin/adodb/adodb.inc.php');

        $dbType = $config['Database']['dbtype'];
        $dbname = $config['Database']['dbname'];
        $tableprefix = $config['Database']['tableprefix'];
        $dbservername = @$config['MasterServer']['servername'] ? $config['MasterServer']['servername'] : '';
        $dbport = @$config['MasterServer']['port'] ? $config['MasterServer']['port'] : '';
        $dbusername = @$config['MasterServer']['username'] ? $config['MasterServer']['username'] : '';
        $dbpassword = @$config['MasterServer']['password'] ? $config['MasterServer']['password'] : '';

        if (!$dbservername) $dbservername = @$config['SlaveServer']['servername'] ? $config['SlaveServer']['servername'] : '';
        if (!$dbusername) $dbusername = @$config['SlaveServer']['username'] ? $config['SlaveServer']['username'] : '';
        if (!$dbpassword) $dbpassword = @$config['SlaveServer']['password'] ? $config['SlaveServer']['password'] : '';
        if (!$dbport) $dbport = @$config['SlaveServer']['port'] ? $config['SlaveServer']['port'] : '';

        if ($dbservername && $dbname && $dbusername) {
            switch ($dbType) {
                case 'mysqli':
                    if (extension_loaded('mysqli')) echo('');
                    else die('Loi! Khong the load thu vien php_mysqli.dll. Hay cho phep su dung php_mssql.dll trong php.ini');
                    $db_Forum = ADONewConnection('mysqli');
                    //$db->Connect($server, $userid, $password, $database);
                    $connect_mssql = $db_Forum->Connect($dbservername, $dbusername, $dbpassword, $dbname);
                    if (!$connect_mssql) die('Ket noi voi MYSQLI loi! Hay kiem tra lai MYSQLI ton tai hoac User & Pass SQL dung.');
                    break;
                case 'mysql':
                    if (extension_loaded('mysql')) echo('');
                    else die('Loi! Khong the load thu vien php_mysql.dll. Hay cho phep su dung php_mssql.dll trong php.ini');
                    $db_Forum = ADONewConnection('mysql');
                    //$db->Connect($server, $userid, $password, $database);
                    $connect_mssql = $db_Forum->Connect($dbservername, $dbusername, $dbpassword, $dbname);
                    if (!$connect_mssql) die('Ket noi voi MYSQLI loi! Hay kiem tra lai MYSQLI ton tai hoac User & Pass SQL dung.');
                    break;
                case 'odbc':
                    $db_Forum = ADONewConnection('odbc');
                    $database_ = "Driver={SQL Server};Server={$dbservername};Database={$dbname}";
                    $connect_mssql = $db_Forum->Connect($database_, $dbusername, $dbpassword, $dbname);
                    if (!$connect_mssql) die('Ket noi voi SQL Server loi! Hay kiem tra lai ODBC ton tai hoac User & Pass SQL dung.');
                    break;
                default:
                    break;
            }
        }
    }
}

// Since 2.0: Add message
function cn_throw_message($msg, $area = 'n')
{
    $es = mcache_get('msg:stor');

    if (!isset($es[$area])) $es[$area] = array();
    $es[$area][] = $msg;

    mcache_set('msg:stor', $es);
    return FALSE;
}

// Since 2.0.3
function cn_user_email_as_site($user_email, $username)
{
    if (preg_match('/^www\./i', $user_email)) {
        return '<a target="_blank" href="http://' . cn_htmlspecialchars($user_email) . '">' . $username . '</a>';
    } elseif (preg_match('/^(https?|ftps?):\/\//i', $user_email)) {
        return '<a target="_blank" href="' . cn_htmlspecialchars($user_email) . '">' . $username . '</a>';
    } else {
        return '<a href="mailto:' . cn_htmlspecialchars($user_email) . '">' . $username . '</a>';
    }
}

//
//function CheckSlotInventory($inventory, $itemX, $itemY)
//{
//    $items_data = getoption('#items_data');
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

?>