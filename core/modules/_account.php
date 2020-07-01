<?php if (!defined('BQN_MU')) {
    die('Access restricted');
}

add_hook('index/invoke_module', '*manager_invoke');

//=====================================================================================================================
function manager_invoke()
{
    $cManger_account = array(
        'manager_account:change_pass:Csc' => 'Đổi pass-Game',
        'manager_account:change_tel:Cp' => 'Đổi Sđt',
        'manager_account:change_email:Ciw' => 'Đổi Email',
        'manager_account:change_pwd:Cg' => 'Đổi pass-Web',
        'manager_account:change_secret:Cb' => 'Đổi Mã Bí mật',
        'manager_account:change_qa:Com' => 'Đổi Câu Trả Lời'
    );

    // Call dashboard extend
    $cManger_account = hook('manager_account', $cManger_account);

    // Exec
    $mod = REQ('mod', 'GETPOST');
    $opt = REQ('opt', 'GETPOST');

    cn_bc_add('Manger Account', cn_url_modify(array('reset'), 'mod=' . $mod));

    foreach ($cManger_account as $id => $_t) {
        list($dl, $do, $acl_module) = explode(':', $id);

        if (function_exists("manager_$do")) {
            cn_bc_menu($_t, cn_url_modify(array('reset'), 'mod=' . $dl, 'opt=' . $do), $do);
        }
    }

    // Request module
    foreach ($cManger_account as $id => $_t) {
        list($dl, $do, $acl_module) = explode(':', $id);

        if ($dl == $mod && $do == $opt && function_exists("manager_$do")) {
            cn_bc_add($_t, cn_url_modify(array('reset'), 'mod=' . $mod, 'opt=' . $opt));
            die(call_user_func("manager_$do"));
        }

        if ($dl == $mod && $do == $opt && !function_exists("manager_$do")) {
            cn_bc_add('Lỗi dữ liệu', cn_url_modify(array('reset'), 'mod=' . $mod, 'opt=' . $opt));
            die(call_user_func("manager_default"));
        }
    }

    echo_header_web('-@my_account/style.css', "Manger Account");

    $images = array(
        'change_pass' => 'change_pass.png',
        'change_tel' => 'change_tel.png',
        'change_email' => 'change_email.png',
        'change_pwd' => 'change_pwd.png',
        'change_secret' => 'change_secret.png',
        'change_qa' => 'change_qa.png'
    );

    // More dashboard images
    $images = hook('extend_dashboard_images', $images);

    foreach ($cManger_account as $id => $name) {
        list($mod, $opt, $acl) = explode(':', $id, 3);

        if (!testRoleWeb($acl)) {
            unset($cManger_account[$id]);
            continue;
        }

        $item = array(
            'name' => $name,
            'img' => isset($images[$opt]) ? $images[$opt] : 'home.gif',
            'mod' => $mod,
            'opt' => $opt
        );

        $cManger_account[$id] = $item;
    }

    cn_assign('dashboard', $cManger_account);
    echo_content_here(exec_tpl('my_account/general'), cn_snippet_bc_re());
    echo_footer_web();
}

function manager_default()
{
    $arr_shop = getMemcache('.breadcrumbs');
    $name__ = array_pop($arr_shop)['name'];
    echo_header_web('-@defaults/style.css', "Error - $name__");
    echo_content_here(exec_tpl('-@defaults/default'), cn_snippet_bc_re());
    echo_footer_web();
}

function manager_change_pass()
{
    $errors = array();

    // Do change pass-game
    if (request_type('POST')) {
        list($nameQuestion, $nameAnswer, $pwd, $re_pwd, $namecaptcha) = GET('cnameQuestion, cnameAnswer, cpwd, cre_pwd, cnameCaptcha', "POST");

        $nameAnswer = strtolower($nameAnswer);

        if ($pwd === '') {
            $errors[] = ucfirst("Chưa nhập mật khẩu game.");
        }
        if ($nameAnswer === '') {
            $errors[] = ucfirst("Chưa trả lời câu hỏi bí mật.");
        }
        if ($nameQuestion === '') {
            $errors[] = ucfirst("Chưa chọn câu hỏi bí mật.");
        }
        if ($namecaptcha === '') {
            $errors[] = ucfirst("Chưa nhập mã Captcha.");
        }

        if (strlen($re_pwd) < 3) {
            $errors[] = 'Mật khẩu quá ngắn';
        }
        if ($pwd != $re_pwd) {
            $errors[] = "Mật khẩu Game không giống nhau.";
        }
        if (strlen($nameAnswer) < 4 || strlen($nameAnswer) > 15) {
            $errors[] = "Câu trả lời bí mật chỉ từ 4-15 kí tự.";
        }
        if ($namecaptcha !== $_SESSION['captcha_web']) {
            $errors[] = "Captcha không đúng";
        }


        $user = do_select_character('MEMB_INFO', 'memb___id,fpas_ques,fpas_answ,mail_addr', "memb___id='" . $_SESSION['user_Gamer'] . "'");

        if (trim($user[0][1]) != $nameQuestion) {
            $errors[] = 'Câu hỏi không đúng.';
        }
        if (trim($user[0][2]) != $nameAnswer) {
            $errors[] = 'Câu trả lời không đúng.';
        }

        if (empty($errors)) {
            $statusUp = do_update_character('MEMB_INFO', "memb__pwd='" . $re_pwd . "'", "memb___id:'" . $_SESSION['user_Gamer'] . "'");

            if ($statusUp) {
                $changePassWebEmail = 'Hi {username}, <br><p>Change your password</p><hr><p>Mật khẩu Game mới: {pass_game} </p>';
                $strHoderFotgot = '{username}, {pass_game}';

                $checkemailforgot = cn_send_mail($user[0][3], 'Thay đổi mật khẩu Game', cn_replace_text($changePassWebEmail, $strHoderFotgot, substr($user[0][0], 0, -4) . '****', $re_pwd));
                cn_throw_message('Bạn đã thay đổi mật khẩu Game thành công.');
            }
        }
    }

    cn_assign('errors_result', $errors);

    echo_header_web('-@my_account/style.css', "Thay đổi mật khẩu Game");
    echo_content_here(exec_tpl('-@my_account/_changePass'), cn_snippet_bc_re());
    echo_footer_web();
}

function manager_change_tel()
{
    $errors = array();

    // Do change tel-phone
    if (request_type('POST')) {
        list($nameQuestion, $nameAnswer, $phoneNumber, $namecaptcha) = GET('cnameQuestion, cnameAnswer, cphoneNumber, cnameCaptcha', "POST");

        $nameAnswer = strtolower($nameAnswer);

        if ($phoneNumber === '') {
            $errors[] = ucfirst("Chưa nhập số điện thoại.");
        }
        if ($nameAnswer === '') {
            $errors[] = ucfirst("Chưa trả lời câu hỏi bí mật.");
        }
        if ($nameQuestion === '') {
            $errors[] = ucfirst("Chưa chọn câu hỏi bí mật.");
        }
        if ($namecaptcha === '') {
            $errors[] = ucfirst("Chưa nhập mã Captcha.");
        }

        if (!preg_match("/(\(\+84\)|0)\d{2,3}[-]\d{4}[-]\d{3}$/i", $phoneNumber)) {
            $errors[] = ucfirst("Số di động không hợp lệ.");
        }
        if (strlen($nameAnswer) < 4 || strlen($nameAnswer) > 15) {
            $errors[] = "Câu trả lời bí mật chỉ từ 4-15 kí tự.";
        }
        if ($namecaptcha !== $_SESSION['captcha_web']) {
            $errors[] = "Captcha không đúng";
        }


        $user = do_select_character('MEMB_INFO', 'memb___id,fpas_ques,fpas_answ,mail_addr', "memb___id='" . $_SESSION['user_Gamer'] . "'");

        if (trim($user[0][1]) != $nameQuestion) {
            $errors[] = 'Câu hỏi không đúng.';
        }
        if (trim($user[0][2]) != $nameAnswer) {
            $errors[] = 'Câu trả lời không đúng.';
        }

        if (empty($errors)) {
            $statusUp = do_update_character('MEMB_INFO', "tel__numb='" . $phoneNumber . "'", "memb___id:'" . $_SESSION['user_Gamer'] . "'");

            if ($statusUp) {
                $changePassWebEmail = 'Hi {username}, <br><hr><p>Số điện thoại mới: {pass_tel}</p>';
                $strHoderFotgot = '{username}, {pass_tel}';

                $checkemailforgot = cn_send_mail($user[0][3], 'Thay đổi số điện thoại.', cn_replace_text($changePassWebEmail, $strHoderFotgot, substr($user[0][0], 0, -4) . '****', $phoneNumber));

                cn_throw_message('Bạn đã thay đổi số điện thoại thành công.');
            }
        }
    }

    cn_assign('errors_result', $errors);
    echo_header_web('-@my_account/style.css', "Thay đổi số điện thoại");
    echo_content_here(exec_tpl('-@my_account/_changeTel'), cn_snippet_bc_re());
    echo_footer_web();
}

function manager_change_email()
{

    //cn_assign('errors_result' , $errors);
    echo_header_web('-@my_account/style.css', "Đổi pass-Web");
    echo_content_here(exec_tpl('-@my_account/_changeEmail'), cn_snippet_bc_re());
    echo_footer_web();
}

function manager_change_pwd()
{
    if (isset($_SESSION['user_ChangePwd']) && $_SESSION['user_ChangePwd']) {
        $isAuthEmail = true;
    }
    $isAuthEmail = isset($isAuthEmail) ? $isAuthEmail : false;
    $errors = array();

    // Do change pass-web
    if (request_type('POST')) {
        list($nameEmail, $pass_web, $repass_web, $namecaptcha) = GET('cnameEmail, cpass_web, crepass_web, cnameCaptcha', "POST");

        $nameEmail = strtolower($nameEmail);

        if ($pass_web === '') {
            $errors[] = ucfirst("Chưa nhập mật khẩu đăng nhập web");
        }
        if ($nameEmail === '' && !$isAuthEmail) {
            $errors[] = ucfirst("Chưa nhập địa chỉ Email");
        }
        if ($namecaptcha === '') {
            $errors[] = ucfirst("Chưa nhập mã Captcha");
        }

        if ($pass_web != $repass_web) {
            $errors[] = "Mật khẩu web không giống nhau.";
        }
        if (!$isAuthEmail && !preg_match('/[\w]\@[\w]/i', $nameEmail)) {
            $errors[] = ucfirst("$nameEmail không đúng dạng địa chỉ Email.");
        }
        if ($namecaptcha !== $_SESSION['captcha_web']) {
            $errors[] = "Captcha không đúng";
        }

        $user = do_select_character('MEMB_INFO', 'memb___id,mail_addr', "memb___id='" . $_SESSION['user_Gamer'] . "'");

        if (!$isAuthEmail && trim($user[0][1]) != $nameEmail) {
            $errors[] = 'Email không đúng.';
        }

        if (empty($errors)) {
            $statusUp = do_update_character('MEMB_INFO', "memb__pwdmd5='" . SHA256_hash($repass_web) . "'", "memb___id:'" . $_SESSION['user_Gamer'] . "'");

            if ($statusUp) {
                $user = do_select_character('MEMB_INFO', 'memb___id,mail_addr', "memb___id='" . $_SESSION['user_Gamer'] . "'");

                $changePassWebEmail = 'Hi {username}, <br>
                    <p>Thay đổi mật khẩu</p>
                    <hr>
                    <p>Mật khẩu Web mới: {pass_web} </p>
                ';

                $strHoderFotgot = '{username}, {pass_web}';
                $checkemailforgot = cn_send_mail($user[0][1], 'Thay đổi mật khẩu web', cn_replace_text($changePassWebEmail, $strHoderFotgot, substr($user[0][0], 0, -4) . '****', $repass_web));

                cn_throw_message('Bạn đã thay đổi mật khẩu Web thành công.');
            }
        }
    }

    cn_assign('isAuthEmail, errors_result', $isAuthEmail, $errors);

    echo_header_web('-@my_account/style.css', "Thay đổi mật khẩu web");
    echo_content_here(exec_tpl('-@my_account/_changePassWeb'), cn_snippet_bc_re());
    echo_footer_web();
}

function manager_change_secret()
{
    $errors = array();

    // Do change pass-web
    if (request_type('POST')) {
        list($nameQuestion, $nameAnswer, $ma7code, $namecaptcha) = GET('cnameQuestion, cnameAnswer, cnum_7_verify, cnameCaptcha', "POST");

        $nameAnswer = strtolower($nameAnswer);

        if ($ma7code === '') {
            $errors[] = ucfirst("Chưa nhập mã số bí mật.");
        }
        if ($nameAnswer === '') {
            $errors[] = ucfirst("Chưa trả lời câu hỏi bí mật.");
        }
        if ($nameQuestion === '') {
            $errors[] = ucfirst("Chưa chọn câu hỏi bí mật.");
        }
        if ($namecaptcha === '') {
            $errors[] = ucfirst("Chưa nhập mã Captcha.");
        }
        if (strlen($ma7code) != 7) {
            $errors[] = "Mã gồm có 7 chữ số";
        }
        if (strlen($nameAnswer) < 4 || strlen($nameAnswer) > 15) {
            $errors[] = "Câu trả lời bí mật chỉ từ 4-15 kí tự.";
        }
        if ($namecaptcha !== $_SESSION['captcha_web']) {
            $errors[] = "Captcha không đúng";
        }


        $user = do_select_character('MEMB_INFO', 'memb___id,fpas_ques,fpas_answ,mail_addr', "memb___id='" . $_SESSION['user_Gamer'] . "'");

        if (trim($user[0][1]) != $nameQuestion) {
            $errors[] = 'Câu hỏi không đúng.';
        }
        if (trim($user[0][2]) != $nameAnswer) {
            $errors[] = 'Câu trả lời không đúng.';
        }

        if (empty($errors)) {
            $statusUp = do_update_character('MEMB_INFO', "sno__numb='" . $ma7code . "'", "memb___id:'" . $_SESSION['user_Gamer'] . "'");

            if ($statusUp) {
                $changePassWebEmail = 'Hi {username},<br><hr><p>Thay đổi mã số bí mật</p><p>Mã số bí mật mới: {pass_secret} </p>';
                $strHoderFotgot = '{username}, {pass_secret}';
                $checkemailforgot = cn_send_mail($user[0][3], 'Thay đổi mã số bí mật', cn_replace_text($changePassWebEmail, $strHoderFotgot, substr($user[0][0], 0, -4) . '****', $ma7code));

                cn_throw_message('Bạn đã thay đổi mật khẩu Web thành công.');
            }
        }
    }

    cn_assign('errors_result', $errors);
    echo_header_web('-@my_account/style.css', "Thay đổi mã số bí mật");
    echo_content_here(exec_tpl('-@my_account/_changeSecret'), cn_snippet_bc_re());
    echo_footer_web();
}

function manager_change_qa()
{
    $errors = array();
    $nameActive = 'A';
    // Do change q-a
    if (request_type('POST')) {
        list($nameActive, $nameQuestion, $nameAnswer, $namecaptcha, $nameEmail) = GET('nameActive, cnameQuestion, cnameAnswer, cnameCaptcha, xnameEmail', "POST");

        $nameAnswer = strtolower(htmlentities($nameAnswer));

        if ($nameAnswer === '') {
            $errors[] = ucfirst("Chưa trả lời câu hỏi bí mật.");
        }
        if ($nameQuestion === '') {
            $errors[] = ucfirst("Chưa chọn câu hỏi bí mật.");
        }
        if ($namecaptcha === '') {
            $errors[] = ucfirst("Chưa nhập mã Captcha.");
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


        $user = do_select_character('MEMB_INFO', 'memb___id,fpas_ques,fpas_answ,mail_addr', "memb___id='" . $_SESSION['user_Gamer'] . "'");

        if (trim($user[0][3]) != $nameEmail) {
            $errors[] = 'Email không đúng.';
        }

        if ($nameActive == 'Q') {
            $setValEmail = $nameQuestion;
            $myExcQuery = "fpas_ques='" . $setValEmail . "'";
            $notify = 'câu hỏi';
            $showStrEmail = 'Câu hỏi mới';
        } elseif ($nameActive == 'A') {
            $setValEmail = $nameAnswer;
            $myExcQuery = "fpas_answ='" . $setValEmail . "'";
            $notify = 'câu trả lời';
            $showStrEmail = 'Câu trả lời mới';
        } else {
            $errors[] = ucfirst('Err, Server không xử lý yêu cầu này.');
        }

        if (empty($errors)) {
            $statusUp = do_update_character('MEMB_INFO', $myExcQuery, "memb___id:'" . $_SESSION['user_Gamer'] . "'");

            if ($statusUp) {
                $changePassWebEmail = 'Hi {username},<br><hr><p>Thay đổi ' . $notify . '</p><p>' . $showStrEmail . ': {q_a} </p>';
                $strHoderFotgot = '{username}, {q_a}';
                $checkemailforgot = cn_send_mail($user[0][3], 'Thay đổi ' . $notify, cn_replace_text($changePassWebEmail, $strHoderFotgot, substr($user[0][0], 0, -4) . '****', $setValEmail));

                cn_throw_message('Bạn đã thay đổi ' . $notify . ' thành công.');
            }
        }
    }

    cn_assign('errors_result, tabActive', $errors, $nameActive);
    echo_header_web('-@my_account/style.css@my_account/customjs.js', "Thay đổi câu hỏi - trả lời bí mật");
    echo_content_here(exec_tpl('-@my_account/_changeQa'), cn_snippet_bc_re());
    echo_footer_web();
}
