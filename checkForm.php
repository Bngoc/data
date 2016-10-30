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
        $xyz = do_select_character($user_table, $user_col, "$user_cont='$id'", ''); ///// viettttttttttttttttttttttttttttttttt

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

/*
$action = $_GET['action'];
$id = $_GET['id'];


$form_data = "action={$action}&id={$id}&account=".$_SESSION['mu_Account']."&passtransfer={$passtransfer}";
$show_reponse = @file_get_contents( $server_url."/checkForm.php?".$form_data );
echo $show_reponse;



$action = $_GET['action'];
$account = $_GET['account'];
$id = $_GET['id'];
$passtransfer = $_GET['passtransfer'];

if ($passtransfer == $transfercode) {
	switch ($action) {
		case 'checkid':
			$sql_username_check = $db->Execute("SELECT memb___id FROM MEMB_INFO WHERE memb___id='$id'"); 
			$username_check = $sql_username_check->numrows();
			if ($username_check > 0) echo '<img style="margin-right:5px" src="images/alert_icon.gif"><span style="color:#FF0000">Tên tài khoản đã có người sử dụng</span>';
			else echo '<img style="margin-right:10px" src="images/checkbullet.gif">';
			break;
		case 'checkemail':
			$sql_email_check = $db->Execute("SELECT mail_addr FROM MEMB_INFO WHERE mail_addr='$id'");
			$email_check = $sql_email_check->numrows();
			if ($email_check > 0) echo '<img style="margin-right:5px" src="images/alert_icon.gif"><span style="color:#FF0000">Email đã có người sử dụng</span>';
			else echo '<img style="margin-right:10px" src="images/checkbullet.gif">';
			break;
		case 'finduser':
			$sql_user_check = $db->Execute("SELECT memb___id FROM MEMB_INFO WHERE memb___id='$id'");
			$user_check = $sql_user_check->numrows();
			if ($user_check == 0) echo '<img style="margin-right:5px" src="images/alert_icon.gif"><span style="color:#FF0000">Tài khoản này không tồn tại</span>';
			else echo '<img style="margin-right:10px" src="images/checkbullet.gif">';
			break;
		case 'findanswer':
			$sql_answ_check = $db->Execute("SELECT fpas_answ FROM MEMB_INFO WHERE memb___id='$account'");
			$answ_check = $sql_answ_check->fetchrow();
			if ($answ_check[0] != $id) echo '<img style="margin-right:5px" src="images/alert_icon.gif"><span style="color:#FF0000">Câu trả lời bí mật không đúng</span>';
			else echo '<img style="margin-right:10px" src="images/checkbullet.gif">';
			break;
		case 'checkname':
			$sql_charname_check = $db->Execute("SELECT Name FROM Character WHERE Name='$id'"); 
			$charname_check = $sql_charname_check->numrows();
			if ($charname_check > 0) echo '<img style="margin-right:5px" src="images/alert_icon.gif"><span style="color:#FF0000">Tên nhân vật đã có người sử dụng</span>';
			else echo '<img style="margin-right:10px" src="images/checkbullet.gif">';
			break;
	}
} else echo "Error";
*/
?>