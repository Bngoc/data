<?php if (!defined('BQN_MU')) die('Access restricted');

add_hook('index/invoke_module', '*guide_invoke');

//=====================================================================================================================
function guide_invoke()
{
    $cManger_account = array (
        'guide:cottruyen:Csc' => 'Cốt truyện',
        'guide:tinhnang:Cp' => 'Tính năng',
        'guide:nhanvat:Ciw' => 'Nhân vật',
        'guide:nhiemvu:Cg' => 'Nhiệm vụ',
        'guide:thuhotro:Cb' => 'Thú hỗ trợ',
        'guide:thucuoi:Com' => 'Thú nuôi',
        'guide:quaivat:Com' => 'Quái vật',
        'guide:items:Com' => 'Vật phẩm',
        'guide:npc:Com' => 'NPC',
        'guide:banghoi:Com' => 'Bang hội',
        'guide:sukiengame:Com' => 'Sự kiện game'
    );

    // Call dashboard extend
    $cManger_account = hook('guide', $cManger_account);

    // Exec
    $mod = REQ('mod', 'GETPOST');
    $opt = REQ('opt', 'GETPOST');

    cn_bc_add('Guide', cn_url_modify(array('reset'), 'mod=' . $mod));

    foreach ($cManger_account as $id => $_t) {
        list($dl, $do, $acl_module) = explode(':', $id);

        if (function_exists("guide_$do")) cn_bc_menu($_t, cn_url_modify(array('reset'), 'mod=' . $dl, 'opt=' . $do), $do);
    }

    // Request module
    foreach ($cManger_account as $id => $_t) {
        list($dl, $do, $acl_module) = explode(':', $id);

        if ($dl == $mod && $do == $opt && function_exists("guide_$do")) {
            cn_bc_add($_t, cn_url_modify(array('reset'), 'mod=' . $mod, 'opt=' . $opt));
            die(call_user_func("guide_$do"));
        }

        if ($dl == $mod && $do == $opt && !function_exists("guide_$do")) {
            cn_bc_add('Lỗi dữ liệu', cn_url_modify(array('reset'), 'mod=' . $mod, 'opt=' . $opt));
            die(call_user_func("guide_default"));
        }
    }

    echoheader('-@my_guide/style.css', "Manger Account");

    $images = array (
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

        $item = array (
            'name' => $name,
            'img' => isset($images[$opt]) ? $images[$opt] : 'home.gif',
            'mod' => $mod,
            'opt' => $opt
        );

        $cManger_account[$id] = $item;
    }

    cn_assign('dashboard', $cManger_account);
    echocomtent_here(exec_tpl('my_guide/general'), cn_snippet_bc_re());
    echofooter();
}

function guide_default()
{
    $arr_shop = mcache_get('.breadcrumbs');
    $name__ = array_pop($arr_shop)['name'];
    echoheader('-@defaults/style.css', "Error - $name__");
    echocomtent_here(exec_tpl('-@defaults/default'), cn_snippet_bc_re());
    echofooter();
}

function guide_cottruyen() {
    $errors = array();

    // Do change pass-game
    if (request_type('POST')) {
        list($nameQuestion, $nameAnswer, $pwd, $re_pwd, $namecaptcha) = GET('cnameQuestion, cnameAnswer, cpwd, cre_pwd, cnameCaptcha', "POST");

        $nameAnswer = strtolower($nameAnswer);

        if ($pwd === '') $errors[] = ucfirst("Chưa nhập mật khẩu game.");
        if ($nameAnswer === '') $errors[] = ucfirst("Chưa trả lời câu hỏi bí mật.");
        if ($nameQuestion === '') $errors[] = ucfirst("Chưa chọn câu hỏi bí mật.");
        if ($namecaptcha === '') $errors[] = ucfirst("Chưa nhập mã Captcha.");

        if (strlen($re_pwd) < 3) $errors[] = 'Mật khẩu quá ngắn';
        if ($pwd != $re_pwd) $errors[] = "Mật khẩu Game không giống nhau.";
        if (strlen($nameAnswer) < 4 || strlen($nameAnswer) > 15) $errors[] = "Câu trả lời bí mật chỉ từ 4-15 kí tự.";
        if ($namecaptcha !== $_SESSION['captcha_web']) $errors[] = "Captcha không đúng";


        $user = do_select_character('MEMB_INFO', 'memb___id,fpas_ques,fpas_answ,mail_addr', "memb___id='". $_SESSION['user_Gamer'] ."'");

        if (trim($user[0][1]) != $nameQuestion){
            $errors[] = 'Câu hỏi không đúng.';
        }
        if (trim($user[0][2]) != $nameAnswer){
            $errors[] = 'Câu trả lời không đúng.';
        }

        if (empty($errors)) {
            $statusUp = do_update_character('MEMB_INFO', "memb__pwd='". $re_pwd ."'", "memb___id:'". $_SESSION['user_Gamer'] ."'");

            if ($statusUp) {
                $changePassWebEmail = 'Hi {username}, <br><p>Change your password</p><hr><p>Mật khẩu Game mới: {pass_game} </p>';
                $strHoderFotgot = '{username}, {pass_game}';

                $checkemailforgot = cn_send_mail($user[0][3], 'Thay đổi mật khẩu Game', cn_replace_text($changePassWebEmail, $strHoderFotgot, substr($user[0][0], 0, -4) . '****', $re_pwd));
                cn_throw_message('Bạn đã thay đổi mật khẩu Game thành công.');
            }
        }
    }

    cn_assign('errors_result', $errors);

    echoheader('-@my_account/style.css', "Thay đổi mật khẩu Game");
    echocomtent_here(exec_tpl('-@my_guide/_cottruyen'), cn_snippet_bc_re());
    echofooter();
}

function guide_tinhnang() {
    $errors = array();

    // Do change pass-game


//    cn_assign('errors_result', $errors);

    echoheader('-@my_account/style.css', "Thay đổi mật khẩu Game");
    echocomtent_here(exec_tpl('-@my_guide/_tinhnang'), cn_snippet_bc_re());
    echofooter();
}

function guide_nhanvat() {
    $errors = array();

    // Do change pass-game


//    cn_assign('errors_result', $errors);

    echoheader('-@my_account/style.css', "Thay đổi mật khẩu Game");
    echocomtent_here(exec_tpl('-@my_guide/_nhanvat'), cn_snippet_bc_re());
    echofooter();
}

function guide_nhiemvu() {
    $errors = array();

    // Do change pass-game


//    cn_assign('errors_result', $errors);

    echoheader('-@my_account/style.css', "Thay đổi mật khẩu Game");
    echocomtent_here(exec_tpl('-@my_guide/_nhiemvu'), cn_snippet_bc_re());
    echofooter();
}

function guide_thuhotro() {
    $errors = array();

    // Do change pass-game


//    cn_assign('errors_result', $errors);

    echoheader('-@my_account/style.css', "Thay đổi mật khẩu Game");
    echocomtent_here(exec_tpl('-@my_guide/_thuhotro'), cn_snippet_bc_re());
    echofooter();
}
function guide_quaivat() {
    $errors = array();

    // Do change pass-game


//    cn_assign('errors_result', $errors);

    echoheader('-@my_account/style.css', "Thay đổi mật khẩu Game");
    echocomtent_here(exec_tpl('-@my_guide/_quaivat'), cn_snippet_bc_re());
    echofooter();
}
function guide_items() {
    $errors = array();

    // Do change pass-game


//    cn_assign('errors_result', $errors);

    echoheader('-@my_account/style.css', "Thay đổi mật khẩu Game");
    echocomtent_here(exec_tpl('-@my_guide/_items'), cn_snippet_bc_re());
    echofooter();
}
function guide_npc() {
    $errors = array();

    // Do change pass-game


//    cn_assign('errors_result', $errors);

    echoheader('-@my_account/style.css', "Thay đổi mật khẩu Game");
    echocomtent_here(exec_tpl('-@my_guide/_npc'), cn_snippet_bc_re());
    echofooter();
}
function guide_banghoi() {
    $errors = array();

    // Do change pass-game


//    cn_assign('errors_result', $errors);

    echoheader('-@my_account/style.css', "Thay đổi mật khẩu Game");
    echocomtent_here(exec_tpl('-@my_guide/_banghoi'), cn_snippet_bc_re());
    echofooter();
}

function guide_sukiengame() {
    $errors = array();

    // Do change pass-game


//    cn_assign('errors_result', $errors);

    echoheader('-@my_account/style.css', "Thay đổi mật khẩu Game");
    echocomtent_here(exec_tpl('-@my_guide/_sukiengame'), cn_snippet_bc_re());
    echofooter();
}
