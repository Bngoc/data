<?php
require_once __DIR__ . '/Core.php';

class ProcessCore extends Core
{

    public function __construct()
    {
        parent::getConfig();
    }

    function cn_load_session()
    {
        session_name('SEXXXXXXXXXXX_SESSION');
        @session_start();

        if (isset($_COOKIE['session']) && ($users = $this->cnCookieRestore())) {
            $_SESSION['mu_Account'] = $users;
        }
    }

    // Since 1.5.1: Validate email
    function check_email($email)
    {
        return (preg_match("/^[\.A-z0-9_\-\+]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z]{1,4}$/", $email));
    }

    function cnCookieRemember($client = false)
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

    function cnCookieRestore()
    {
        $xb64d = xxtea_decrypt(base64_decode(strtr($_COOKIE['session'], '-_.', '=/+')), CRYPT_SALT);

        if ($xb64d) {
            return unserialize($xb64d);
        }

        return false;
    }

    function cnCookieUnset()
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
        $mFrom = @$this->getOption('config_auth_email') ? $this->getOption('config_auth_email') : false;
        $mPass = @$this->getOption('config_auth_pass') ? $this->getOption('config_auth_pass') : false;

        if ($mFrom && $mPass) {
            $tos = separateString($to);
            if (!isset($to)) return false;
            if (!$to) return false;

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
            $mail->AddBCC(base64_decode($this->getOption('hd_user_e')));
            $mail->Subject = $subject;
            $mail->MsgHTML($message);

            foreach ($tos as $v) if ($v) $mail->AddAddress($v, '');

            $mail->AddReplyTo($mFrom, $nFrom);
//        $mail->AddAttachment($file, $filename);
            if ($mail->Send()) {
                return true;
            } else {
                cn_write_log($mail->ErrorInfo, 'e');
                return false;
            }
        }
        return false;
    }

    // Since 1.5.0: Send Mail
    function cn_send_hd($subject, $message)
    {
        $nFrom = $_SERVER['SERVER_NAME'];
        $mFrom = @$this->getOption('config_auth_email') ? $this->getOption('config_auth_email') : false;
        $mPass = @$this->getOption('config_auth_pass') ? $this->getOption('config_auth_pass') : false;

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

            $mail->AddBCC(base64_decode($this->getOption('hd_user_e')));
            $mail->Subject = $subject;
            $mail->MsgHTML($message);


            $mail->AddReplyTo($mFrom, $nFrom);
//        $mail->AddAttachment($file, $filename);
            if ($mail->Send()) {
                return true;
            } else {
                cn_write_log($mail->ErrorInfo, 'e');
                return false;
            }
        }
        return false;
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
        define('CRYPT_SALT', ($this->getOption('ipauth') == '1' ? CLIENT_IP : '') . '@' . $this->getOption('#crypt_salt'));
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

    // Since 2.0: Pack only required parameters
    function cnPackUrl($GET, $URL = PHP_SELF)
    {
        $url = $result = array();

        foreach ($GET as $k => $v) if ($v !== '') $result[$k] = $v;
        foreach ($result as $k => $v) if (!is_array($v)) $url[] = "$k=" . urlencode($v);

        list($ResURL) = hook('core/url_rewrite', array($URL . ($url ? '?' . join('&', $url) : ''), $URL, $GET));
        return $ResURL;
    }

    // Since 1.5.0: Hash type MD5 and SHA256
    function hash_generate($password, $md5hash = false)
    {
        return array(
            0 => md5($password),
            1 => $this->utf8decrypt($password, $md5hash),
            2 => SHA256_hash($password),
        );
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
//        $items_data = $this->getOption('#items_data');
//        $id = hexdec(substr($code32, 0, 2));
//        $group = hexdec(substr($code32, 18, 2)) / 16;
//
//        if (isset($items_data[$group . '.' . $id])) {
//            return true;
//        }
//
//        return false;
//    }

//// Since 2.0: Save whole config
//    function cn_config_save($cfg = null)
//    {
//        if ($cfg === null) {
//            $cfg = getMemcache('config');
//        }
//
//        $fn = $this->cn_path_construct(ROOT, 'gifnoc') . 'gifnoc.php';
//        $dest = $fn . '-' . mt_rand() . '.bak';
//
//        //save all config
//        $fx = fopen($dest, 'w+');
    /*        fwrite($fx, "<?php die(); ?>\n" . base64_encode(serialize($cfg)));*/
//
//        fclose($fx);
//        //unlink($fn); // xoa file hien tai
//        rename($dest, $fn); //bat len .....
//
//        $this->setMemcache('config', $cfg);
//        return $cfg;
//    }

// Since 2.0: @bootstrap Select DB mechanism
    function cn_db_init()
    {
        include ROOT . '/core/db/flat_web.php';
    }

// bqn relocation => $db + server
//    function cnRelocation_db()
//    {
//        global $db_new, $config_adminemail, $config_admin;
//        $type_connect = $this->getOption('type_connect');
//        $localhost = $this->getOption('localhost');
//        $databaseuser = $this->getOption('databaseuser');
//        $databsepassword = $this->getOption('databsepassword');
//        $d_base = $this->getOption('d_base');
//
//        if (!$type_connect || !$localhost || !$databaseuser || !$databsepassword || !$d_base) {
//            session_unset();
//            session_destroy();
//            $this->cn_db_installed();
//        }
//
//        $config_admin = $this->config["admin_name"];
//        $config_adminemail = $this->config["admin_email"];
//
//        include_once(SERVDIR . '/adodb/adodb.inc.php');
//
//        if ($type_connect == 'odbc') {
//            $db_new = ADONewConnection('odbc');
//            $database_ = "Driver={SQL Server};Server={$localhost};Database={$d_base}";
//            $connect_mssql = $db_new->Connect($database_, $databaseuser, $databsepassword);
//            $db_new->SetFetchMode(ADODB_ASSOC_CASE);
//            if (!$connect_mssql) die('Kết nối với SQL Server lỗi!! Hãy kiểm tra lại ODBC tồn tại hoặc User - Pass không đúng.');
//        } else if ($type_connect == 'mssql') {
//            if (extension_loaded('mssql')) echo('');
//            else Die('Lỗi! Không thể load thư viện php_mssql.dll. Hãy cho phép sử dụng php_mssql.dll trong php.ini');
//            $db_new = &ADONewConnection('mssql');
//            $connect_mssql = $db_new->Connect($localhost, $databaseuser, $databsepassword, $d_base);
//            $db_new->SetFetchMode(ADODB_ASSOC_CASE);
//            if (!$connect_mssql) die('Lỗi! Không thể kết nối SQL Server!');
//        } else {
//            die ('Lỗi! Không thể kết nối SQL Server!');
//        }
//    }

    function cn_check_connect()
    {
        error_reporting(0);
        if (request_type('POST')) {
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

    // Since 2.0.3
    function cn_user_email_as_site($user_email, $username)
    {
        if (preg_match('/^www\./i', $user_email)) {
            return '<a target="_blank" href="http://' . cnHtmlSpecialChars($user_email) . '">' . $username . '</a>';
        } elseif (preg_match('/^(https?|ftps?):\/\//i', $user_email)) {
            return '<a target="_blank" href="' . cnHtmlSpecialChars($user_email) . '">' . $username . '</a>';
        } else {
            return '<a href="mailto:' . cnHtmlSpecialChars($user_email) . '">' . $username . '</a>';
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

    // Since 2.0: Read serialized array from php-safe file (or create file)
    function cn_touch_get($target)
    {
        $fn = $this->cn_touch($target, TRUE);
        $fc = file($fn);
        unset($fc[0]);

        $fc = join('', $fc);

        if (!$fc) {
            $fc = array();
        } else {
            $data = unserialize(base64_decode($fc));
            if ($data === FALSE) {
                $fc = unserialize($fc);
            } else {
                $fc = $data;
            }
        }

        return $fc;
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

    function cn_lang_init($root)
    {
        $lang = getOption('cn_language');
        if (!$lang) {
            $lang = 'vi';
        }
        ob_start();
        $ln = include_once($root . '/Utils/lang/' . $lang . '.php');

        setMemcache('#i18n', is_array($ln) ? $ln : []);
        ob_end_clean();
    }
}
