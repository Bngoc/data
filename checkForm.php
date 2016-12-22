<?php
require_once(dirname(__FILE__) . '/core/init.php');

list($id, $action, $check_) = GET('id, action, check');

//if(isset()) goi member_get.... get table.... //action=...&check=...&id=...
if ($action) {
    $str_null = "không tồn tại.";
    $str_char = "đã tồn tại.";
    $str_ans = "Câu trả lời bí mật không đúng.";

    if ($action == "checkid")
        $user_table = "MEMB_INFO";
    elseif ($action == "checkname")
        $user_table = "Character";
    else
        $user_table = '';

    if ($check_ == "check_user") {
        $user_col = $user_cont = "memb___id";
        $notify = "Tài khoản " . $str_char;
    } elseif ($check_ == "check_email") {
        $user_col = $user_cont = "mail_addr";
        $notify = "Email " . $str_char;
    } elseif ($check_ == "check_answer") {
        $user_col = "fpas_answ";
        $user_cont = "memb___id";
        $notify = $str_ans;
    } elseif ($check_ == "check_finduser") {
        $user_col = $user_cont = "memb___id";
        $notify = "Tài khoản " . $str_null;
    } elseif ($check_ == "check_char") {
        $user_col = $user_cont = "Name";
        $notify = $str_char;
    } else {
        $user_col = $user_col = $notify = '';
    }

    //$notify_accept ='<img style="margin-right:10px" src="images/checkbullet.gif">';
    $notify_accept = 'OK';
    $notify_deline = $notify;
    //$notify_deline = '<img style="margin-right:5px" src="images/alert_icon.gif"><span style="color:#FF0000">'.$notify.'</span>';

    if ($user_table && $user_cont && $user_col && $id) {
        $xyz = do_select_character($user_table, $user_col, "$user_cont='$id'", '');

        if (!$xyz) {
            if ($check_ == "check_finduser") { // tim kiem character ko co
                $re_str = $notify_deline;
            } else
                $re_str = $notify_accept;
        } else {
            if ($check_ == "check_finduser") { // tim thay character
                if ($xyz[0][0] == $id)
                    $re_str = $notify_accept;
                else $re_str = $notify_deline;
            } else
                $re_str = $notify_deline;
        }
        echo $re_str;
    }
}
?>