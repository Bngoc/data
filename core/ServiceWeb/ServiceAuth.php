<?php

class ServiceAuth
{
    function do_active_register($d_string)
    {
        $d_string = xxtea_decrypt($d_string, md5(CLIENT_IP) . getOption('#crypt_salt'));
        $newHash = substr($d_string, 0, 64);
        $d_string = trim(strtolower(substr($d_string, 64)));

        if ($d_string) {
            $user = do_select_character('MEMB_INFO', 'memb___id,token_regist,date_resgit_email,mail_chek', "memb___id='$d_string'");

            if ($user) {
                if ($newHash != trim($user[0]['token_regist'])) {
                    msg_info('Đường dẫn không hợp lệ.');
                }
                if (trim($user[0]['mail_check'])) {
                    msg_info('Tài khoản đã được kích hoạt.', 'index.php');
                }

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

        cnRelocation($_SERVER['SERVER_NAME']);
    }

    function do_restore_active_status($d_string)
    {
        $d_string = xxtea_decrypt($d_string, MD5(CLIENT_IP) . getOption('#crypt_salt'));
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
                cnRelocation(cn_url_modify(array('reset'), 'mod=manager_account', 'opt=change_pwd'));
            }
        }

        msg_info('Fail: Không xác nhận thay đổi mật khẩu.');
    }

    function do_resend_activation($username, $emailWeb)
    {
        $user = do_select_character('MEMB_INFO', 'memb___id,mail_addr,memb__pwdmd5', "memb___id='$username'");

        if (!$user) {
            msg_info('Tài khoản hoặc địa chỉ email không đúng.');
        }

        $email = isset($user[0]['mail_addr']) ? trim($user[0]['mail_addr']) : '';

        // Check user name & mail
        if ($user && $email && $email == $emailWeb) {
            $rand = $user[0]['memb__pwdmd5'];

            $ctime = ctime() + 86400;
            $url = getOption('http_script_dir') . '?lostpass=' . urlencode(base64_encode(xxtea_encrypt($rand . $ctime . ' ' . $username, MD5(CLIENT_IP) . getOption('#crypt_salt'))));

            $tmpHtmlEmailForgrot = 'Hi {username}, <br>
                <p>Click vào link dưới đây để xác nhận thay đổi mật khẩu</p>
                <a style="padding: 5px; color: red; background-color: blue; margin: 5px; cursor: pointer" href="{url}">Reset your password</a><br><hr>
                <i><em>Lưu ý: Xác nhận trong vòng 24h.</em></i>
            ';

            $strHeaderForgot = '{username}, {url}';
            $checkEmailForgot = cn_send_mail($email, 'Resend activation link', cn_replace_text($tmpHtmlEmailForgrot, $strHeaderForgot, substr($username, 0, -4) . '****', $url));

            if ($checkEmailForgot) {
                msg_info('Vui lòng kiểm tra lại email', 'index.php');
            } else {
                msg_info('Err, Gửi email thất bại, hãy thử lại sau');
            }
        } else {
            msg_info('Tài khoản hoặc địa chỉ email không đúng.');
        }

        msg_info('Tài khoản hoặc địa chỉ email không xác thực.');
    }

    function cn_do_register($request)
    {
        $errors = [];
        $register_OK = false;
        $username = $request['username'];
        $pwd = $request['pwd'];
        $re_pwd = $request['re_pwd'];
        $pass_web = $request['pass_web'];
        $repass_web = $request['repass_web'];
        $ma7code = $request['ma7code'];
        $nameQuestion = $request['nameQuestion'];
        $nameAnswer = $request['nameAnswer'];
        $nameEmail = $request['nameEmail'];
        $phoneNumber = $request['phoneNumber'];
        $namecaptcha = $request['namecaptcha'];

        $array_QA = convert_question_answer();
        if ($username === '') {
            $errors[] = ucfirst("Chưa nhập tài khoản");
        }
        if ($pwd === '') {
            $errors[] = ucfirst("Chưa nhập mật khẩu game");
        }
        if ($ma7code === '') {
            $errors[] = ucfirst("Chưa nhập mã số bí mật");
        }
        if ($pass_web === '') {
            $errors[] = ucfirst("Chưa nhập mật khẩu đăng nhập web");
        }
        if ($nameEmail === '') {
            $errors[] = ucfirst("Chưa nhập địa chỉ Email");
        }
        if ($phoneNumber === '') {
            $errors[] = ucfirst("Chưa nhập số điện thoại");
        }
        if (trim($nameAnswer) === '') {
            $errors[] = ucfirst("Chưa trả lời câu hỏi bí mật");
        }
        if ($nameQuestion === '' || !isset($array_QA[$nameQuestion])) {
            $errors[] = ucfirst("Chưa chọn câu hỏi bí mật");
        }
        if ($namecaptcha === '') {
            $errors[] = ucfirst("Chưa nhập mã Captcha");
        }

        if (!preg_match("/(([a-z]{1,}+[0-9]{1,})|([0-9]{1,}+[a-z]{1,}))+[a-z0-9]*/", $username)) {
            $errors[] = ucfirst("Tài khoản chỉ được sử dụng kí tự thường và số.");
        }
        if (!preg_match("/(\(\+84\)|0)\d{2,3}[-]\d{4}[-]\d{3}$/i", $phoneNumber)) {
            $errors[] = ucfirst("Số di động không hợp lệ.");
        }
        if (substr_count($username, 'dis') > 0) {
            $errors[] = ucfirst("Tên tài khoản không được phép đăng ký.");
        }

        if (strlen($username) < 4 || strlen($username) > 10) {
            $errors[] = "Tên tài khoản chỉ từ 4-10 kí tự.";
        }
        if (strlen($re_pwd) < 3) {
            $errors[] = 'Mật khẩu quá ngắn';
        }
        if ($pwd != $re_pwd) {
            $errors[] = "Mật khẩu Game không giống nhau.";
        }
        if (strlen($ma7code) != 7) {
            $errors[] = "Mã gồm có 7 chữ số";
        }
        if ($pass_web != $repass_web) {
            $errors[] = "Mật khẩu web không giống nhau.";
        }
        if (!preg_match('/[\w]\@[\w]/i', $nameEmail)) {
            $errors[] = ucfirst("$nameEmail không đúng dạng địa chỉ Email.");
        }
        if (strlen($nameAnswer) < 4 || strlen($nameAnswer) > 15) {
            $errors[] = "Câu trả lời bí mật chỉ từ 4-15 kí tự.";
        }
        if ($namecaptcha !== $_SESSION['captcha_web']) {
            $errors[] = "Captcha không đúng";
        }

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

                    $strHolder = '%account%, %email%, %ma7code%, %password%, %passWeb%, %phonenumber%, %quest_choise%, %answer%, %nameHome%';

                    $rand = '';
                    $set = 'qwertyuiop[],./!@#$%^&*()_asdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
                    for ($i = 0; $i < 64; $i++) {
                        $rand .= $set[mt_rand() % strlen($set)];
                    }
                    $token = urlencode(base64_encode(xxtea_encrypt($rand . ' ' . $username, MD5(CLIENT_IP) . getOption('#crypt_salt'))));
                    $url = getOption('http_script_dir') . '?verifiregist=' . $token;

                    $strTemp = cn_replace_text(
                        $tempRegisterSendEmail,
                        $strHolder,
                        $username,
                        $nameEmail,
                        $ma7code,
                        $re_pwd,
                        $repass_web,
                        $phoneNumber,
                        $array_QA[$nameQuestion],
                        $nameAnswer,
                        $_SERVER['SERVER_NAME']
                    );

                    $strTemp2 = cn_replace_text(
                        $tempRegister,
                        '%nameHome%, %verificationLink%',
                        $_SERVER['SERVER_NAME'],
                        $url
                    );

                    $status = cn_send_mail(
                        $nameEmail,
                        'Welcome to ' . $_SERVER['SERVER_NAME'],
                        cn_replace_text($strTemp, '%home_url%', $_SERVER['SERVER_NAME']) . $strTemp2
                    );

                    if ($status) {
                        $register_OK = true;
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
        if ($register_OK === true) {
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
                "fpas_ques='" . trim($nameQuestion) . "'",
                "fpas_answ='" . $nameAnswer . "'",
                "ip='" . $_SERVER["REMOTE_ADDR"] . "'",
                "acl='" . getOption('registration_level') . "'",
                "token_regist='" . $rand . "'",
                "date_resgit_email='" . (ctime() + 86400) . "'",
                'ban_login=0',
                'num_login=1'
            );
            $strTemp = cn_replace_text($strTemp, '%home_url%', 'index.php');
            $strTemp .= '<p style="float: left; color: red"><i>Vui lòng check email để xác nhận tài khoản.</i></p>';
            if ($checkStatusDB) {
                msg_info($strTemp, 'index.php');
            } else {
                msg_info('Err, Không thể tạo được tài khoản mới!');
            }
        }

        return ['errors' => $errors];
    }
}
