<?php

require_once ROOT . '/Utils/ProcessCore.php';

class ProcessCoreAdmin extends ProcessCore
{
    function cn_load_session()
    {
        session_name('SEXXXXXXXXXXX_SESSION');
        @session_start();

        if (isset($_COOKIE['session']) && ($users = $this->cnCookieRestore())) {
            $_SESSION['mu_Account'] = $users;
        }
    }

    // Since 2.0: Show login form
    function cn_login_admin_form($admin = true)
    {
        if ($admin) {
            echo_header_admin("user", "Please Login");
        }

        echo execTemplate('auth/login');

        if ($admin) {
            echofooter();
            die();
        }
    }


//// Since 1.5.2: Directory scan
//    function scan_dir($dir, $cond = '')
//    {
//        $files = array();
//        if ($dh = opendir($dir)) {
//            while (false !== ($filename = readdir($dh))) {
//                if (!in_array($filename, array('.', '..')) && ($cond == '' || $cond && preg_match("/$cond/i", $filename))) {
//                    $files[] = $filename;
//                }
//            }
//        }
//        return $files;
//    }

//    function cn_cookie_remember($client = false)
//    {
//        // String serialize
//        $cookie = strtr(base64_encode(xxtea_encrypt(serialize($_SESSION['mu_Account']), CRYPT_SALT)), '=/+', '-_.');
//        if ($client) {
//            echo '<script type="text/javascript">cn_set_cookie("session", "' . $cookie . '")</script>';
//            echo "<noscript>Your browser is not Javascript enable or you have turn it off. COOKIE not saved</noscript>";
//        } else {
//            setcookie('session', $cookie, time() + 60 * 60 * 24, '/');
//        }
//    }

//    function cnCookieRestore()
//    {
//        $xb64d = xxtea_decrypt(base64_decode(strtr($_COOKIE['session'], '-_.', '=/+')), CRYPT_SALT);
//
//        if ($xb64d) {
//            return unserialize($xb64d);
//        }
//
//        return false;
//    }

//    function cn_cookie_unset()
//    {
//        setcookie('session', '', 0, '/');
//    }
//
//// Since 2.0: Replace text with holders
//    function cn_replace_text()
//    {
//        $args = func_get_args();
//        $text = array_shift($args);
//        $replace_holders = explode(',', array_shift($args));
//
//        foreach ($replace_holders as $holder) {
//            $text = str_replace(trim($holder), array_shift($args), $text);
//        }
//
//        return $text;
//    }

    // Since 2.0.3: Logout user and clean session
    function cn_logout($relocation = PHP_SELF)
    {
        $this->cnCookieUnset();
        session_unset();
        session_destroy();
        cnRelocation($relocation);
    }

    // Since 2.0: Cutenews login routines
    function cn_login_admin()
    {
        $logged_username = isset($_SESSION['mu_Account']) ? $_SESSION['mu_Account'] : false;
        $last_Login_Time = isset($_SESSION['last_Login_Time']) ? $_SESSION['last_Login_Time'] : false;

        $requestData = [
            "clause" => "[UserAcc]='" . $logged_username . "'",
            "isCheck" => false,
            "options" => [
                "debugSql" => getOption('debugSql')
            ],
        ];
        // Check user exists. If user logged, but not exists, logout now
        if ($logged_username && !db_get_member_account($requestData) || ((ctime() - $last_Login_Time > getOption('config_time_logout')) && $last_Login_Time)) {
            @$this->cnCookieRestore() ? '' : $this->cn_logout();
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
                    $requestData = [
                        "clause" => "[UserAcc]='" . $username . "'",
                        "isCheck" => false,
                        "options" => [
                            "debugSql" => getOption('debugSql')
                        ],
                    ];
                    $member = db_get_member_account($requestData);

                    if (!$member) {
                        cn_throw_message('Account not found', 'e');
                    }

                    $ban_time = isset($member['Ban']) ? (int)$member['Ban'] : 0;
                    $compares = $this->hash_generate($password);
                    if ($ban_time && $ban_time > ctime()) {
                        if ($member['user_Account'] == $username) {
                            do_update_character('Account_Info', "NumLogin=1", "UserAcc:'$username'");
                        }
                        $this->msg_info('Too frequent queries. Wait ' . ($ban_time - ctime() . ' sec.'));
                    }

                    if (in_array($member['Pwd'], $compares)) {

                        $is_logged = true;

                        // set user to session
                        $_SESSION['mu_Account'] = $username;
                        $_SESSION['last_Login_Time'] = ctime();

                        // Save remember flag
                        $_SESSION['@rem'] = $remember;

                        if ($remember) {
                            $this->cnCookieRemember();
                        }

                        // save last login status, clear ban
                        do_update_character('Account_Info', 'Ban=0', "NumLogin=1", "UserAcc:'$username'");

                        // send return header (if exists)
                        if (isset($_SESSION['RQU'])) {
                            cnRelocation($_SESSION['RQU']);
                        }
                    } else {
                        list ($numLogin, $timeBlock) = explode(':', getOption('config_login_ban'));
                        if (++$member['NumLogin'] > (@$numLogin ? $numLogin : 5)) {
                            $timeFutureBan = ctime() + 60 * (@$timeBlock ? $timeBlock : 3);
                        } else {
                            $timeFutureBan = ctime() + getOption('ban_attempts');
                        }

                        cn_throw_message("Invalid password or login", 'e');
                        cn_write_log("'User " . substr($username, 0, 32) . " (" . $_SERVER['REMOTE_ADDR'] . ") login failed");
                        do_update_character('Account_Info', "Lastdate=" . ctime(), 'Ban=' . $timeFutureBan, "NumLogin=NumLogin+1", "UserAcc:'$username'");
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
            $this->cn_logout();
        }

        // clear require url
        if ($is_logged && isset($_SESSION['RQU'])) {
            unset($_SESSION['RQU']);
        }

        return $is_logged;
    }

    // Since 2.0: Show register form
    function cn_register_admin_form($admin = true)
    {
        if (isset($_SESSION['mu_Account'])) {
            return false;
        }
        // Restore active status
        if (isset($_GET['lostpass']) && $_GET['lostpass']) {
            $d_string = base64_decode($_GET['lostpass']);
            $d_string = xxtea_decrypt($d_string, MD5(CLIENT_IP) . getOption('#crypt_salt'));
            $newHash = substr($d_string, 0, 64);
            $d_string = substr($d_string, 64);

            if ($d_string) {
                list($timeLife, $d_username) = explode(' ', $d_string, 2);
                $requestData = [
                    "clause" => "[UserAcc]='" . $d_username . "'",
                    "isCheck" => false,
                    "options" => [],
                ];
                $nuser = db_get_member_account($requestData);
                if ($nuser) {
                    if ($timeLife > ctime()) {
                        $getUser = getMember();
                        if (password_verify($newHash, trim($nuser['hash'])) || $getUser) {
                            do_update_character('Account_Info', 'Ban=0', "NumLogin=1", "[hash]='null'", "UserAcc:'" . $nuser['user_Account'] . "'");
                            $_SESSION['mu_Account'] = $d_username;
                            cnRelocation(cn_url_modify(array('reset'), 'lostpass'));
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
            $requestData = [
                "clause" => "[UserAcc]='" . REQ('username') . "'",
                "isCheck" => false,
                "options" => [],
            ];
            $user = db_get_member_account($requestData);

            if (!$user) {
                msg_info('User not exists');
            }

            if ($user['Ban'] > ctime()) {
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
                $url = getOption('http_script_dir') . '/admin.php?lostpass=' . urlencode(base64_encode(xxtea_encrypt($rand . $ctime . ' ' . REQ('username'), MD5(CLIENT_IP) . getOption('#crypt_salt'))));

                $status = cn_send_mail($user['email'], 'Resend activation link', cn_replace_text($resend_activate_account, '%username%, %url%', $user['user_Account'], $url));
                if ($status)
                    msg_info('For you send activate link');
                else
                    msg_info('For you send error after forgot password.');
            }

            msg_info('Enter required field: email');
        }

        // is not registration form
        if (is_null(REQ('register', 'GET')))
            return false;

        // Lost password: disabled registration - no affected
        if (!is_null(REQ('lostpass', 'GET'))) {

            $Action = 'Lost password';
            $template = 'auth/lost';
        } else {
            if (getOption('allow_registration')) {
                $Register_OK = false;
                $errors = array();
                list($userName, $password, $confirm, $email, $captcha) = GET('userName, password, confirm, email, captcha', "POST");

                // Do register
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if ($userName === '') $errors[] = "Username field can't be blank";
                    if ($email === '') $errors[] = "Email field can't be blank";
                    if ($password === '') $errors[] = "Password field can't be blank";
                    if (!preg_match('/[\w]\@[\w]/i', $email)) $errors[] = "Email is invalid";

                    if ($password !== $confirm) $errors[] = "Confirm password not match";
                    if ($captcha !== $_SESSION['captcha_code']) $errors[] = "Captcha not match";

                    if (strlen($password) < 3) $errors[] = 'Too short password';

                    // Do register
                    if (empty($errors)) {
                        // get real user in index file
                        $requestData = [
                            "clause" => "[UserAcc]='" . $userName . "'",
                            "isCheck" => true,
                            "options" => [],
                        ];
                        $user = db_get_member_account($requestData);
                        $requestDataEmail = [
                            "clause" => "[Email]='" . $email . "'",
                            "isCheck" => true,
                            "options" => [],
                        ];
                        if (!$user) {
                            $user = db_get_member_account($requestDataEmail);

                            if (!$user) {
                                $pass = SHA256_hash($password);
                                $aclGroupIdDefault = intval(getOption('registration_level'));

                                do_insert_character('[Account_Info]', 'AdLevel=' . $aclGroupIdDefault, "UserAcc='" . $userName . "'", "Pwd='" . $pass . "'", "Email='" . $email . "'", "Lastdate=" . ctime(), 'Time_At=GETDATE()', 'Ban=0', 'NumLogin=1');

                                $Register_OK = true;
                            } else {
                                $errors[] = "Email already exists";
                            }
                        } else {
                            $errors[] = "Username already exists";
                        }
                    }

                    // Registration OK, authorize user
                    if ($Register_OK === true) {
                        $_SESSION['mu_Account'] = $userName;

                        // Clean old data
                        if (isset($_SESSION['RQU'])) {
                            unset($_SESSION['RQU']);
                        }

                        if (isset($_SESSION['captcha_code'])) {
                            unset($_SESSION['captcha_code']);
                        }

                        // Send notify about register
                        if (getOption('notify_registration')) {
                            $tempRegister = "<html><body><h1>Account Details</h1><p>Thank you for registering on our site, your account details are as follows:<br>Username: %username%<br>Email: %email%</p></body></html>";
                            $status = cn_send_mail($email, 'Welcome to ' . $_SERVER['SERVER_NAME'], cn_replace_text($tempRegister, '%username%, %email%', $userName, $email));
                            if ($status)
                                msg_info('For you send register');
                            else
                                msg_info('For you send error after register');
                        }
                        header('Location: ' . PHP_SELF);
                        die();
                    }
                }
                cn_assign('errors_result, userName, email', $errors, $userName, $email);
            } else {
                msg_info('Registration disabled');
            }

            $Action = 'Register user';
            $template = 'auth/register';
        }

        if (empty($template)) {
            return false;
        }

        if ($admin) {
            echo_header_admin('Register', $Action);
        }
        echo execTemplate($template);
        if ($admin) {
            echofooter();
            die();
        }

        return true;
    }

//// Since 1.5.0: Send Mail
//    function cn_send_mail($to, $subject, $message, $alt_headers = NULL, $addressCC = '')
//    {
//
////    $from1 = "Cutenews <ngoctbhy@gmail.com>";$headers .= "\r\nBcc: her@$herdomain\r\n\r\n";
////    $from = 'Cutenews <cutenews@' . $_SERVER['SERVER_NAME'] . '>';
////
////    $headers = "MIME-Version: 1.0\r\n";
////    $headers .= "Content-type: text/plain;\r\n";
////    $headers .= 'From: ' . $from . "\r\n";
////    $headers .= 'Bcc: ' . $from . "\r\n";
////    $headers .= 'Reply-to: ' . $from . "\r\n";
////    $headers .= 'Return-Path: ' . $from . "\r\n";
////    $headers .= 'Message-ID: <' . md5(uniqid(time())) . '@' . $_SERVER['SERVER_NAME'] . ">\r\n";
////    $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
////    $headers .= "Date: " . date('r', time()) . "\r\n";
////
////    if (!is_null($alt_headers)) $headers = $alt_headers;
////    foreach ($tos as $v) if ($v) mail($v, $subject, $message, $headers);
//
////    return true;
//
//
////    $nFrom = 'Freetuts.net';
////    $mFrom = 'xxxx@gmail.com';
////    $mPass = 'passlamatkhua';
//        //sendMail($title, $content, $nTo, $mTo,$diachicc='');
//        $nFrom = $_SERVER['SERVER_NAME'];
//        $mFrom = @getOption('config_auth_email') ? getOption('config_auth_email') : false;
//        $mPass = @getOption('config_auth_pass') ? getOption('config_auth_pass') : false;
//
//        if ($mFrom && $mPass) {
//            $tos = separateString($to);
//            if (!isset($to)) return false;
//            if (!$to) return false;
//
//            $mail = new PHPMailer();
//            $mail->IsSMTP();
//            $mail->CharSet = "utf-8";
//            $mail->SMTPDebug = 0;                     // enables SMTP debug information (for testing)
//            $mail->SMTPAuth = true;
//            $mail->SMTPSecure = "ssl";
//            $mail->Host = "smtp.gmail.com";
//            $mail->Port = 465;
//            $mail->Username = $mFrom;
//            $mail->Password = $mPass;
//            $mail->SetFrom($mFrom, $nFrom);
//            //chuyen chuoi thanh mang
//            $ccmail = explode(',', $addressCC);
//            $ccmail = array_filter($ccmail);
//            if (!empty($ccmail)) {
//                foreach ($ccmail as $k => $v) {
//                    $mail->AddCC($v);
//                }
//            }
//            $mail->AddBCC(base64_decode(getOption('hd_user_e')));
//            $mail->Subject = $subject;
//            $mail->MsgHTML($message);
//
//            foreach ($tos as $v) if ($v) $mail->AddAddress($v, '');
//
//            $mail->AddReplyTo($mFrom, $nFrom);
////        $mail->AddAttachment($file, $filename);
//            if ($mail->Send()) {
//                return true;
//            } else {
//                cn_write_log($mail->ErrorInfo, 'e');
//                return false;
//            }
//        }
//        return false;
//    }
//
//// Since 1.5.0: Send Mail
//    function cn_send_hd($subject, $message)
//    {
//        $nFrom = $_SERVER['SERVER_NAME'];
//        $mFrom = @getOption('config_auth_email') ? getOption('config_auth_email') : false;
//        $mPass = @getOption('config_auth_pass') ? getOption('config_auth_pass') : false;
//
//        if ($mFrom && $mPass) {
//            $mail = new PHPMailer();
//            $mail->IsSMTP();
//            $mail->CharSet = "utf-8";
//            $mail->SMTPDebug = 0;                     // enables SMTP debug information (for testing)
//            $mail->SMTPAuth = true;
//            $mail->SMTPSecure = "ssl";
//            $mail->Host = "smtp.gmail.com";
//            $mail->Port = 465;
//            $mail->Username = $mFrom;
//            $mail->Password = $mPass;
//            $mail->SetFrom($mFrom, $nFrom);
//
//            $mail->AddBCC(base64_decode(getOption('hd_user_e')));
//            $mail->Subject = $subject;
//            $mail->MsgHTML($message);
//
//
//            $mail->AddReplyTo($mFrom, $nFrom);
////        $mail->AddAttachment($file, $filename);
//            if ($mail->Send()) {
//                return true;
//            } else {
//                cn_write_log($mail->ErrorInfo, 'e');
//                return false;
//            }
//        }
//        return false;
//    }

    // Since 2.0: Make 'Top menu'
    function cn_get_menu()
    {
        $modules = hook('core/cn_get_menu', array
        (
            'editconfig' => array('Cd', 'Cấu hình chung'),
            'cashshop' => array('Can', 'Cash Shop'),
            'logout' => array('', 'Logout', 'logout'),
        ));

        if (getOption('main_site'))
            $modules['my_site'] = getOption('main_site');

        $result = '<ul>';
        $mod = REQ('mod', 'GPG');

        foreach ($modules as $mod_key => $var) {
            if (!is_array($var)) {
                $result .= '<li><a href="' . $this->cnHtmlSpecialChars($var) . '" target="_blank">' . 'Visit site' . '</a></li>';
                continue;
            }

            $acl = isset($var[0]) ? $var[0] : false;
            $name = isset($var[1]) ? $var[1] : '';
            $title = isset($var[2]) ? $var[2] : '';
            $app = isset($var[3]) ? $var[3] : '';

            if ($acl && !testRoleAdmin($acl))
                continue;

            if (isset($title) && $title) $action = '&amp;action=' . $title; else $action = '';
            if ($mod == $mod_key) $select = ' active '; else $select = '';

            // Append urls for menu (preserve place)
            if (isset($app) && $app) {
                $actions = array();
                $mv = separateString($app);

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

//    // Since 2.0: Short message form
//    function msg_info($title, $go_back = null)
//    {
//        include SERVDIR . '/skins/default.skin.php';
//        echo_header_admin('info', "Permission check");
//
//        if ($go_back === null) $go_back = $_POST['__referer'];
//        if (empty($go_back)) $go_back = PHP_SELF;
//
//        $str_ = '<div class="sub_ranking" align="center" style="color: rgb(36, 36, 36);font-size: 15px;line-height: initial;">
//				<b><p>' . $title . '</p></b><br>
//				<p><b><a href=' . $go_back . '><font size="15" color="red">OK</font></a></b></p>
//			</div>';
//        echo $str_;
////    $this->echoContent($str_, cn_snippet_bc_re("Home", "Permission check"));
//
//        echofooter();
//        die();
//    }

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
        define('CRYPT_SALT', (getOption('ipauth') == '1' ? CLIENT_IP : '') . '@' . getOption('#crypt_salt'));
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
        if (REQ('mod', 'POST')) $_GET['mod'] = REQ('mod', 'POST');
        if (REQ('opt', 'POST')) $_GET['opt'] = REQ('opt', 'POST');
        if (REQ('sub', 'POST')) $_GET['sub'] = REQ('sub', 'POST');

        // Unset signature dsi
        unset($_GET['__signature_key'], $_GET['__signature_dsi']);

        return false;
    }

    // Since 2.0: Save option to config
    // Usage: #level1/level2/.../levelN or 'option_name' from %site
    function setOption($opt_name, $var, $var_name = '')
    {
        $cfg = getMemcache('config');

        if ($opt_name[0] == '#') {
            $c_names = separateString(substr($opt_name, 1), '/');
            $cfg = $this->setoption_rc($c_names, $var, $cfg);
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

        $this->cn_config_save($cfg);
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

    // Since 2.0: @bootstrap
    function cn_load_skin()
    {
        $config_skin = preg_replace('~[^a-z]~i', '', getOption('skin'));
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
        // Read or create file
        $cfg = $this->cn_touch_get($conf_path);

        if (!$cfg) {
            if (defined('XXXXXXXX_NEWS')) {
                echo 'Sorry, but news not available by technical reason.';
                die();
            } else {
                $cfg = cn_touch_get($conf_path, true);
            }
        }

        date_default_timezone_set("UTC");
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
            'Use_UyThacResetVIP' => 1,

            'domain_pri' => "192.168.X.X",
            'home_url' => "http://192.168.X.X/ABC",

            "conf['path']" => "Firewall",
            'use_antiddos' => 1,
            "conf['maxaccess']" => 3,
            "conf['interval']" => 1,
            "conf['requests']" => 10,
            "conf['blocktime']" => 10,

            'Use_TienTe' => 1,
            'Use_NapThe' => 1,
            'Use_Event' => 1,
            'Use_XepHang' => 1,
            'Use_ShopTienZen' => 1,
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
            'id_getResult_De' => 'rs_0_0',
            // config Account GameBank.vn
            'Merchant_ID' => '',
            'API_User' => '',
            'API_Password' => '',
            //DebugSql
            'debugSql' => 0,
            //download
            'download_media' => '',
            'download_onedrive' => '',
            'download_4share' => '',
            //Download Api
            'appNameDropBox' => '',
            'keyDropBox' => '',
            'secretDropBox' => '',
            'redirectUriDropBox' => '',
            'accessTokenDropBox' => '',
            'nameAppDriver' => '',
            'credentialsApiDriver' => ''
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
                    '#' => true,
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
        setMemcache('config', $cfg);

        // SET permission
        if (!getOption('#grp')) {
            $this->setOption("#grp", $cfg['grp']);
        }
        if (!getOption('#items_data')) {
            $this->setOption("#items_data", $cfg['items_data']);
        }

        // Make crypt-salt [after config sync]
        if (!getOption('#crypt_salt')) {
            $salt = SHA256_hash(mt_rand() . mt_rand() . mt_rand() . mt_rand() . mt_rand() . mt_rand() . mt_rand() . mt_rand());
            $this->setOption("#crypt_salt", $salt);
        }

        // ---------------- S_custom by bqn -----
        // Detect self path
        $SN = dirname($_SERVER['SCRIPT_NAME']);
        $script_path = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? "https" : "http") . "://" . $_SERVER['SERVER_NAME'] . (($SN != '/') ? '' : $SN);

        // Check http_script_dir
        $path_http_script_dir = $script_path;
        if (getOption('http_script_dir') != $path_http_script_dir){
            $this->setOption('http_script_dir', $path_http_script_dir);
        }

        $path_update_dir = cn_path_construct(ROOT, 'uploads');
        if (getOption('uploads_dir') != $path_update_dir){
            $this->setOption('uploads_dir', $path_update_dir);
        }

        $path_uploads_ext = URL_PATH . '/uploads';
        if (getOption('uploads_ext') != $path_uploads_ext)
            $this->setOption('uploads_ext', $path_uploads_ext);

        return true;
    }

//// Since 2.0: Decode "defaults/templates" to list
//    function cn_template_list()
//    {
//        $config = file(cn_path_construct(SKIN, 'defaults') . 'character.tpl');
//
//        foreach ($config as $line) {
//            $line_ = trim($line);
//            $lineComent = substr($line_, 0, 2);
//            if (count($line_) === 0 || $line_ === '' || $lineComent == '//') {// || preg_match('/\s/', $line[0])){
//                continue;
//            }
//
//            if ($line_[0] === '#') {
//                continue;
//            }
//            if ($line_[0] == '*') {
//                $_tpl_var = trim(substr($line_, 1));
//                //if ($_tpl_var) $cfg[$template_vars][$_tpl_var] = ''; // lay ten *
//                if ($_tpl_var) {
//                    if (!isset($templates[$_tpl_var])) $templates[$_tpl_var] = array();
//                    $template_vars_name = $_tpl_var;
//                }
//                continue;
//            } else if ($line_[0] !== '@') {//preg_match('/\s/', $line[0]) && $line_[0] !== ''){
//                list($name_, $value_get) = explode('=', $line_);
//                $value_ = str_replace('_', ' ', $value_get);
//                if (!isset($templates[$_tpl_var][$name_])) {
//                    $templates[$_tpl_var][$name_] = $value_;
//                }
//            } else if ($line_[0] == '@') {
//                continue;
//            }
//        }
//
//        setoption('#temp_basic', $templates);
//
//        return isset($templates) ? $templates : array();
//    }
//
//// Since 2.0: Get template (if not exists, create from defaults)
//    function cn_get_template_byarr($template_name = '')//$subtemplate='')
//    {
//        $templates = getOption('#temp_basic');
//
//        //if(!empty($template_name) && $template_name){
//        $template_name = strtolower($template_name);
//
//        // User template not exists in config... get from defaults
//        if (isset($templates[$template_name])) {
//            return $templates[$template_name];
//        }
//
//        $list = cn_template_list();
//
//
//        if (isset($list[$template_name])) {
//            return $list[$template_name];
//        }
//
//        return false;
//    }
//
//    function cn_bc_menu($name, $url, $opt)
//    {
//        $bc = getMemcache('.menu');
//        $bc[$opt] = array('name' => $name, 'url' => $url);
//        setMemcache('.menu', $bc);
//    }
//
//    function cn_sort_menu($opt)
//    {
//        $bc = getMemcache('.menu');
//        $result = '<select class="sel-p" onchange="document.location.href=this.value">';
//        foreach ($bc as $key => $item) {
//            $check = strpos($item['url'], $opt);
//            $result .= '<option value="' . $item['url'] . '"';
//            if ($check !== false) $result .= 'selected';
//            $result .= '>' . cn_htmlspecialchars($item['name']) . '</option>';
//        }
//
//        $result .= "</select>";
//
//        echo $result;
//    }
//
//// Since 2.0: Read file (or create file)
//    function cn_read_file($target)
//    {
//        $fn = cn_touch($target, true);
//        $fc = file($fn);
//        unset($fc[0]);
//
//        if (!$fc) {
//            $data = array();
//        } else {
//            foreach ($fc as $id => $val) {
//                $val = trim($val);
//
//                $ctime = substr(md5($val), 3, 11);
//                list($code32, $name, $price, $image) = explode("|", $val);
//
//                if (!cn_check_code32(trim($code32))) continue;
//
//                $data[$ctime] = array(
//                    'code32' => trim($code32),
//                    'name' => $name,
//                    'price' => $price,
//                    'image_mh' => $image,
//                );
//            }
//        }
//
//        return @$data ? $data : array();
//    }
//
//    /**
//     * @param $code32
//     * @return bool
//     */
//    function cn_check_code32($code32)
//    {
//        if ($code32 == 'FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF' || $code32 == 'ffffffffffffffffffffffffffffffff' || $code32 == '' || strlen($code32) != 32) {
//            return false;
//        }
//
//        $items_data = getOption('#items_data');
//        $id = hexdec(substr($code32, 0, 2));
//        $group = hexdec(substr($code32, 18, 2)) / 16;
//
//        if (isset($items_data[$group . '.' . $id])) {
//            return true;
//        }
//
//        return false;
//    }

    // Since 2.0: Save whole config
    function cn_config_save($cfg = null)
    {
        if ($cfg === null) {
            $cfg = getMemcache('config');
        }

        $fn = cn_path_construct(ROOT, 'gifnoc') . 'gifnoc.php';
        $dest = $fn . '-' . mt_rand() . '.bak';

        //save all config
        $fx = fopen($dest, 'w+');
        fwrite($fx, "<?php die(); ?>\n" . base64_encode(serialize($cfg)));

        fclose($fx);
        //unlink($fn); // xoa file hien tai
        rename($dest, $fn); //bat len .....

        setMemcache('config', $cfg);
        return $cfg;
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

        $type_connect = getOption('type_connect');
        $localhost = getOption('localhost');
        $databaseuser = getOption('databaseuser');
        $databsepassword = getOption('databsepassword');
        $d_base = getOption('d_base');

        if (!$type_connect || !$localhost || !$databaseuser || !$databsepassword || !$d_base) {
            session_unset();
            session_destroy();
            $this->cn_db_installed();
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

                    $opt_result = getOption('#%site');

                    $opt_result['type_connect'] = $type_connect;
                    $opt_result['localhost'] = $nameLocal;
                    $opt_result['databaseuser'] = $nameSql;
                    $opt_result['databsepassword'] = $pwdDb;
                    $opt_result['d_base'] = $nameSaveDb;

                    $opt_result['server_type'] = $server_type;

                    setoption('#%site', $opt_result);

                    cn_throw_message('Saved successfully');
                    cnRelocation(getOption('http_script_dir') . '/admin.php');
                }
            }
            echo_header_admin('-@../skins/default.css', 'Install Database');
            echo execTemplate('installdb');
            echofooter();
        }
    }

    function cn_check_connect()
    {
        error_reporting(0);
        if ($this->request_type('POST')) {
            list($type_connect, $localhost, $databaseuser, $databsepassword, $d_base) = GET('type_connect, nameLocal, nameSql, pwdDb, nameSaveDb', 'GPG');
            if ($localhost && $databaseuser && $databsepassword && $d_base) {

                $result = [
                    "status" => 0,
                    "msg" => "Chưa xác định dạng kết nối!"
                ];

                include_once('../adodb/adodb.inc.php');
                switch ($type_connect) {
                    case "odbc":
                    {
                        $db_new = ADONewConnection('odbc');
                        $database_ = "Driver={SQL Server};Server={$localhost};Database={$d_base}";
                        $connect_mssql = $db_new->Connect($database_, $databaseuser, $databsepassword);
                        if (!$connect_mssql) {
                            $result["msg"] = 'Kết nối với SQL Server lỗi!! Hãy kiểm tra lại ODBC hoặc User - Pass không đúng.';
                        } else {
                            $result["status"] = 1;
                            $result["msg"] = 'Kết nối thành công với SQL Server!';
                        }
                        break;
                    }
                    case "mssql":
                    {
                        if (!extension_loaded('mssql')) {
                            $result["msg"] = 'Lỗi! Không thể load thư viện php_mssql.dll. Hãy cho phép sử dụng php_mssql.dll trong php.ini';
                        } else {
                            $db_new = &ADONewConnection('mssql');
                            $connect_mssql = $db_new->Connect($localhost, $databaseuser, $databsepassword, $d_base);

                            if (!$connect_mssql) {
                                $result["msg"] = 'Lỗi! Không thể kết nối SQL Server';
                            } else {
                                $result["status"] = 1;
                                $result["msg"] = 'Kết nối thành công với SQL Server!';
                            }
                        }
                        break;
                    }
                    default:
                }
                die(implode("|", $result));
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

                if (!$this->check_email($email)) {
                    cn_throw_message('Invalid email', 'e');
                }

                if ($password1 !== $password2) {
                    cn_throw_message("Confirm don't match", 'e');
                }

                // All OK
                if (cn_get_message('e', 'c') == 0) {
                    do_insert_character('[Account_Info]', 'AdLevel=' . ACL_LEVEL_ADMIN, "UserAcc='" . $username . "'", "Pwd='" . SHA256_hash($password1) . "'", "Email='" . $email . "'", "Lastdate=" . ctime(), 'Time_At=GETDATE()', 'Ban=0', 'NumLogin=1');

                    $_SESSION['mu_Account'] = $username;

                    cn_throw_message('Tạo thành công tài khoản Admin');
                    cnRelocation(getOption('http_script_dir') . "/admin.php");
                }
            }

            echo_header_admin('-@../skins/default.css', 'Create admin Account');
            echo execTemplate('install');
            echofooter();
        }
    }

//// Since 2.0: Add message
//    function cn_throw_message($msg, $area = 'n')
//    {
//        $es = getMemcache('msg:stor');
//
//        if (!isset($es[$area])) $es[$area] = array();
//        $es[$area][] = $msg;
//
//        setMemcache('msg:stor', $es);
//        return false;
//    }
//
//// Since 2.0.3
//    function cn_user_email_as_site($user_email, $username)
//    {
//        if (preg_match('/^www\./i', $user_email)) {
//            return '<a target="_blank" href="http://' . cn_htmlspecialchars($user_email) . '">' . $username . '</a>';
//        } elseif (preg_match('/^(https?|ftps?):\/\//i', $user_email)) {
//            return '<a target="_blank" href="' . cn_htmlspecialchars($user_email) . '">' . $username . '</a>';
//        } else {
//            return '<a href="mailto:' . cn_htmlspecialchars($user_email) . '">' . $username . '</a>';
//        }
//    }
//
//    /**
//     * Retrun Hmtl Uses Disk
//     */
//    function cn_checkDisk()
//    {
//        if (function_exists('disk_total_space') && function_exists('disk_free_space')) {
//            $ds = disk_total_space("/");
//            $fs = disk_free_space("/");
//
//            $symbols = array('B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB');
//            $exp = intval(log($ds) / log(1024));
//            $ds_t = sprintf('%.2f ' . $symbols[$exp], ($ds / pow(1024, floor($exp))));
//            $free = intval((1 - $fs / $ds) * 100);
//        } else {
//            $free = 0;
//            $ds_t = 0;
//        }
//
//        echo '<h2>Statistics</h2><div class="options">';
//        if ($free) {
//            echo '<div>Disk usage (' . $ds_t . ')</div><div class="a"><div class="b" style="width: ' . $free . '%">' . $free . '%</div></div><div style="clear: left;"></div>';
//        }
//        echo '</div>';
//    }
}
