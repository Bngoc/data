<?php if (!defined('BQN_MU')) die('Access restricted');

add_hook('index/invoke_module', '*char_invoke');

//=====================================================================================================================
function char_invoke()
{
    $char_board = array
    (
        'char_manager:info_char:Csc' => 'Thông tin nhân vật',
        'char_manager:reset:Cp' => 'Reset',
        'char_manager:resetvip:Ct' => 'Reset Vip',
        'char_manager:relife:Cc' => 'Relife - Tái sinh',
        'char_manager:online:Ciw' => 'Ủy thác Online',
        'char_manager:offline:Cmm' => 'Ủy thác Offline',
        'char_manager:rsdelegate:Cum' => 'Reset Ủy thác',
        'char_manager:rsdelegatevip:Cg' => 'Reset Ủy thác Vip ',
        'char_manager:subpoint:Cb' => 'Rút Point',
        'char_manager:addpoint:Com' => 'Cộng điểm',
        'char_manager:pointtax:Com' => 'Thuê điểm',
        'char_manager:movemap:Ca' => 'Di chuyển - Đổi Map',
        'char_manager:removepk:Cbi' => 'Rửa tội - Xóa PK',
        'char_manager:rspoint:Caf' => 'Reset Point - Cộng lại điểm',
        'char_manager:delepersonalSotre:Cpc' => 'Xóa đồ cửa hàng cá nhân',
        'char_manager:changeclass:Cwp' => 'Đổi giới tính',
        'char_manager:changename:Clc' => 'Đổi tên nhận vật',

        'char_manager:wreplace:Crw' => 'Tẩy tủy - Reset lại',
        'char_manager:logs:Csl' => 'Reset Master Skill',

        'char_manager:maint:Cmt' => 'Khóa đồ - Bảo vệ đồ',

        'char_manager:script:Csr' => 'Chuyển nhân vật',

        'char_manager:level1:Cpc' => 'Làm nhiệm vụ cấp 1',
        'char_manager:level2:Cpc' => 'Làm nhiệm vụ cấp 220',
        'char_manager:level3:Cpc' => 'Làm nhiệm vụ cấp Master',
        'char_manager:selfchkưd:Cpc' => 'Nhiệm vụ ngẫu nhiên',
        'char_manager:selfchkd:Cpc' => 'Đổi điểm Phúc Duyên',
    );

    // Call dashboard extend
    $char_board = hook('extend_dashboard', $char_board);

    // Exec
    $mod = REQ('mod', 'GETPOST');
    $opt = REQ('opt', 'GETPOST');

    // Top level (dashboard)
    cn_bc_add('Nhân vật', cn_url_modify(array('reset'), 'mod=' . $mod));

    foreach ($char_board as $id => $_t) {
        list($dl, $do, $acl_module) = explode(':', $id);
        if (function_exists("char_$do"))
            cn_bc_menu($_t, cn_url_modify(array('reset'), 'mod=' . $dl, 'opt=' . $do), $do);
    }

    // Request module
    foreach ($char_board as $id => $_t) {
        list($dl, $do, $acl_module) = explode(':', $id);

        //if (test($acl_module) && $dl == $mod && $do == $opt && function_exists("char_$opt")) {
        if ($dl == $mod && $do == $opt && function_exists("char_$opt")) {
            cn_bc_add($_t, cn_url_modify(array('reset'), 'mod=' . $mod, 'opt=' . $opt));
            die(call_user_func("char_$opt"));
        }

        if ($dl == $mod && $do == $opt && !function_exists("char_$opt")) {
            cn_bc_add('Lỗi dữ liệu', cn_url_modify(array('reset'), 'mod=' . $mod, 'opt=' . $opt));
            die(call_user_func("char_default"));
        }
    }

    $images = array (
        'info_char' => 'info_char.gif',
        'reset' => 'reset.png',
        'resetvip' => 'resetvip.png',
        'relife' => 'relife.png',
        'online' => 'online.png',
        'offline' => 'offline.png',
        'rsdelegate' => 'rsdelegate.png',
        'rsdelegatevip' => 'rsdelegatevip.png',
        'subpoint' => 'subpoint.png',
        'addpoint' => 'addpoint.png',
        'pointtax' => 'pointtax.png',
        'movemap' => 'movemap.png',
        'removepk' => 'removepk.png',
        'rspoint' => 'rspoint.png',
        'changeclass' => 'changeclass.png',
        'changename' => 'changename.png',
        'level1' => 'level-1.png',
        'level2' => 'level-2.png',
        'level3' => 'level-3.png',
        'delepersonalSotre' => 'dele-personalSotre.png',

        'widgets' => 'widgets.png',
        'wreplace' => 'replace.png',
        'morefields' => 'more.png',
        'maint' => 'settings.png',
        'group' => 'group.png',
        'locale' => 'locale.png',
        'script' => 'script.png',
        'comments' => 'comments.png'
    );

    // More dashboard images
    $images = hook('extend_dashboard_images', $images);

    foreach ($char_board as $id => $name) {
        list($mod, $opt, $acl) = explode(':', $id, 3);

        //if (!test($acl)) {
            // unset($char_board[$id]);
            //continue;
        //}

        $item = array (
            'name' => $name,
            'img' => isset($images[$opt]) ? $images[$opt] : 'home.gif',
            'mod' => $mod,
            'opt' => $opt,
        );

        $char_board[$id] = $item;
    }

    cn_assign('dashboard', $char_board);
    echoheader('-@my_char/style.css', "Character");
    echocomtent_here(exec_tpl('my_char/general'), cn_snippet_bc_re());
    echofooter();
}

function char_default()
{
    $arr_shop = mcache_get('.breadcrumbs');
    $name__ = array_pop($arr_shop)['name'];
    echoheader('defaults/style.css', "Error - $name__");
    echocomtent_here(exec_tpl('defaults/default'), cn_snippet_bc_re());
    echofooter();
}

function char_info_char()
{
    $showchar = cn_character();

    foreach ($showchar as $od => $do) {
        if (!empty($od)) {

            if ($do['point'] > 0) $do_10 = "<a href =" . cn_url_modify('mod=char_manager', 'opt=addpoint', 'sub=' . $od) . " title='cộng Point'>" . number_format($do['point'], 0, ",", ".") . "</a>"; else $do_10 = $do['point'];
            if ($do['point_dutru'] > 0) $do_11 = "<a href =" . cn_url_modify('mod=char_manager', 'opt=subpoint', 'sub=' . $od) . " title='rút Point'>" . number_format($do['point_dutru'], 0, ",", ".") . "</a>"; else $do_11 = $do['point_dutru'];

            if ($do['status_off']) $do_12_20 = "<a href =" . cn_url_modify('mod=char_manager', 'opt=offline', 'sub=' . $od) . " title='Đang ủy thác Offline'><img src='" . URL_PATH_IMG . "/checkbullet.gif'></a>";
            else if ($do['status_on']) $do_12_20 = "<a href =" . cn_url_modify('mod=char_manager', 'opt=online', 'sub=' . $od) . " title='Đang ủy thác Online'><img src='" . URL_PATH_IMG . "/checkbullet.gif'></a>";
            else $do_12_20 = "<img src='" . URL_PATH_IMG . "/alert_icon.gif'>";

            $showchar_[] = array('char_image' => $do['char_image'], 'Name' => $od, 'cclass' => $do['cclass'], 'level' => $do['level'], 'str' => $do['str'], 'dex' => $do['dex'], 'vit' => $do['vit'], 'ene' => $do['ene'], 'com' => $do['com'], 'reset' => $do['reset'], 'relife' => $do['relife'], 'point' => $do_10, 'point_dutru' => $do_11, 'status_uythac' => $do_12_20, 'point_uythac' => $do['point_uythac'], 'pcpoint' => $do['pcpoint']);
        }
    }

    cn_assign('showchar', $showchar_);
    $arr_shop = mcache_get('.breadcrumbs');
    $name__ = array_pop($arr_shop)['name'];
    echoheader('-@my_char/style.css', "Information character - $name__");
    echocomtent_here(exec_tpl('my_char/info_char'), cn_snippet_bc_re());
    echofooter();
}

function char_reset()
{
    $member = member_get();
    list($sub) = GET('sub', 'GPG');

    $arr_class = cn_template_class();
    $options_rs = cn_template_reset();
    $options_rl = cn_template_relife();
    $options_tanthu = cn_template_httt();
    $limit_1 = cn_template_rslimit1();
    $limit_2 = cn_template_rslimit2();

    $showchar = cn_character();
    $_blank_var = view_bank($accc_ = $member['user_name']);

    if (!$sub) {
        $sub = array_keys($showchar)[0];
    } else {
        if (!in_array($sub, array_keys($showchar))) $sub = array_keys($showchar)[0];
    };

    $zen_acc_char = $showchar[$sub]['money'];
    $level_acc_char = $showchar[$sub]['level'];
    $rs_inday = $showchar[$sub]['resetInDay'];
    $rs_top_50 = $showchar[$sub]['top_50'];
    $Resets_Time = $showchar[$sub]['Resets_Time'];
    //$inventory = $showchar[$sub]['shop_inventory'];
    $reset_rs = $showchar[$sub]['reset'];
    $relife_vl = $showchar[$sub]['relife'];
    $class_ = $showchar[$sub]['class'];
    $user_type_gh_rs = getoption('use_gioihanrs');
    $ctime = ctime();
    $set_vp = $_blank_var[0]['vp'];
    $show_blank_chao = $_blank_var[0]['chaos'];
    $show_blank_cre = $_blank_var[0]['cre'];
    $show_blank_blue = $_blank_var[0]['blue'];

    if (isset($options_rs)) {
        $ok_loop = false;
        $resetpoint = $leadership = $rs_index = 0;
        $i_e = $p_e = $ml_e = 0;
        foreach ($options_rs as $aq => $qa) {
            $i_f = $ok_loop ? $i_e : 0;
            $i_e = $qa['reset'];
            $p_f = $ok_loop ? $p_e : 0;
            $p_e = $qa['point'];
            $ml_f = $ok_loop ? $ml_e : 0;
            $ml_e = $qa['command'];
            $ok_loop = true;

            if (($reset_rs > $i_f) && ($reset_rs <= $i_e) || ($reset_rs == 0)) {
                $level = $qa['level'];
                $zen = $qa['zen'];
                $chao = $qa['chaos'];
                $cre = $qa['cre'];
                $blue = $qa['blue'];
                $time_reset_next = $qa['time'];

                $resetpoint += $qa['point'] * ($reset_rs - $i_f);
                $leadership += $qa['command'] * ($reset_rs - $i_f);
                $rs_index = $aq;
                break;
            }

            $resetpoint += ($i_e - $i_f) * $p_e;
            $leadership += ($i_e - $i_f) * $ml_e;
        }

        $level = isset($level) ? $level : $options_rs[count($options_rs) - 1]['level'];
        $zen = isset($zen) ? $zen : $options_rs[count($options_rs) - 1]['zen'];
        $cre = isset($cre) ? $cre : $options_rs[count($options_rs) - 1]['cre'];
        $chao = isset($chao) ? $chao : $options_rs[count($options_rs) - 1]['chaos'];
        $blue = isset($blue) ? $blue : $options_rs[count($options_rs) - 1]['blue'];
        $time_reset_next = isset($time_reset_next) ? $time_reset_next : $options_rs[count($options_rs) - 1]['time'];
    }

    if (isset($options_rl)) {
        foreach ($options_rl as $aq => $qa) {
            if ($relife_vl == $aq) {
                $reset_relifes = $qa['reset'];
                $point_relifes = $qa['point'];
                $ml_relifes = $qa['command'];
                break;
            }
        }

        $reset_relifes = isset($reset_relifes) ? $reset_relifes : $options_rl[count($options_rl) - 1]['reset'];
        $point_relifes = isset($point_relifes) ? $point_relifes : $options_rl[count($options_rl) - 1]['point'];
        $ml_relifes = isset($ml_relifes) ? $ml_relifes : $options_rl[count($options_rl) - 1]['command'];
    }

    if (getoption('hotrotanthu')) {
        if (isset($options_tanthu)) {
            foreach ($options_tanthu as $aq => $qa) {
                if (($qa['reset_min'] <= $reset_rs && $reset_rs <= $qa['reset_max']) && ($qa['relife_min'] <= $relife_vl && $relife_vl <= $qa['relife_max'])) {
                    $giam_lv = $qa['levelgiam'];
                }
            }
        }
    }

//    $inventory = bin2hex($inventory);
//    $inventory3 = substr($inventory, 76 * 32, 32 * 32);
//    $inventory3 = strtoupper($inventory3);
//    $shop_empty = "FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF";

    $abc_level = $level_acc_char - (isset($level) ? $level : 0);

    if (0 <= $get_zen = $zen_acc_char - (isset($zen) ? $zen : 0)) $str_zen = number_format((float)$zen_acc_char, 0, ",", ".") . " (Đủ Zen)"; else {
        $str_zen = number_format((float)$zen_acc_char, 0, ",", ".") . " <font color =red> (Thiếu " . number_format((float)(abs($get_zen)), 0, ",", ".") . " Zen)</font>";
    }
    if (0 <= $get_chao = $show_blank_chao - (isset($chao) ? $chao : 0)) $str_chao = $show_blank_chao . " (Đủ Chaos)"; else {
        $str_chao = $show_blank_chao . '<font color =red> (Thiếu ' . abs($get_chao) . ' Chaos)</font>';
    }
    if (0 <= $get_cre = $show_blank_cre - (isset($cre) ? $cre : 0)) $str_cre = "$show_blank_cre (Đủ Creation)"; else {
        $str_cre = $show_blank_cre . '<font color =red> (Thiếu ' . abs($get_cre) . ' Creation)</font>';
    }
    if (0 <= $get_blue = $show_blank_blue - (isset($blue) ? $blue : 0)) $str_blue = "$show_blank_blue (Đủ Blue)"; else {
        $str_blue = $show_blank_blue . '<font color =red> (Thiếu ' . abs($get_blue) . ' Blue)</font>';
    }

    if (getoption('hotrotanthu')) {
        $g_lv = isset($giam_lv) ? $giam_lv : 0;
        if (0 <= $test_vl = $abc_level + $g_lv) {
            $str_lever = "$level_acc_char (Đủ level)";
            if ($g_lv != 0) $str_lever .= "<font color =#747484><i> Hỗ trợ tân thủ giảm $g_lv level</i></font>";
        } else {
            $thieu_lever = ABS($test_vl);
            $str_lever = "$level_acc_char <font color =red>(Thiếu ". abs($thieu_lever) ." level)</font>";
            if ($g_lv != 0) $str_lever .= "<font color =#747484><i> Hỗ trợ tân thủ giảm $g_lv level</i></font>";
        }
    } else {
        if (0 <= $test_vl = $abc_level)
            $str_lever = "$level_acc_char (Đủ level).";
        else {
            $f_lv = ABS($abc_level);
            $str_lever = "$level_acc_char <font color =red>(Thiếu ". abs($f_lv) ." level)</font>";
        }
    }

    if ($user_type_gh_rs == 1) {
        $i_frist = 0;
        $i_end = 10;
        foreach ($limit_1 as $df => $fd) {
            if ($rs_top_50 > $i_frist && $rs_top_50 <= $i_end) $gioihan_rs = $fd['top'];
            $i_frist = $i_end;
            $i_end = $i_end + 10;
        }

        $gioihan_rs = isset($gioihan_rs) ? $gioihan_rs : $limit_1[count($limit_1) - 1]['top'];
        if ($gioihan_rs > $rs_inday) $rs_day = "$rs_inday / $gioihan_rs";
        else $rs_day = "<font color=red> $rs_inday / $gioihan_rs </font>";
    } else if ($user_type_gh_rs == 2) {
        $okloop = false;

        if (isset($limit_2)) {
            $lv_rs_en = 0;
            foreach ($limit_2 as $d => $val) {
                    $lv_rs_f = $okloop ?  $lv_rs_en : 1;
                    $lv_rs_en = $val['col1'];
                    $okloop = true;
                
                if ($lv_rs_f < $reset_rs && $reset_rs <= $lv_rs_en) {
                    if (0 <= $rs_inday && $rs_inday <= $val['day1']) {
                        $VpointReset = $val['col2'];
                        break;
                    } else if ($val['day1'] < $rs_inday && $rs_inday <= $val['day2']) {
                        $VpointReset = $val['col3'];
                        break;
                    } else if ($val['day2'] < $rs_inday) {
                        $VpointReset = $val['col4'];
                        break;
                    }
                }
            }
        }
        if ($reset_rs > $limit_2[count($limit_2) - 1]['col1']) {
            $abvc = $limit_2[count($limit_2) - 1];
            if (0 <= $rs_inday && $rs_inday <= $abvc['day1']) {
                $VpointReset = $abvc['col2'];
            } else if ($abvc['day1'] < $rs_inday && $rs_inday <= $abvc['day2']) {
                $VpointReset = $abvc['col3'];
            } else if ($abvc['day2'] < $rs_inday) {
                $VpointReset = $abvc['col4'];
            }
        }
        $rs_day = "$rs_inday / ---";
        $get_vp = $set_vp - (isset($VpointReset) ? $VpointReset : 0);
        if ($get_vp >= 0) $str_vp = number_format((float)$set_vp, 0, ",", ".") . "(Đủ Vpoint Reset)"; else {
            $str_vp = number_format((float)$set_vp, 0, ",", ".") . " <font color =red> (Thiếu " . number_format((float)(abs($get_vp)), 0, ",", ".") . " Vpoint Reset)</font>";
        }
    } else {
        $rs_day = "$rs_inday / No limit";
    }

    if (check_online($accc_)) {
        $check_on = true;
        $status = "<font color =red>Online</font>";
    } else {
        $check_on = false;
        $status = "Offline";
    }
    if (check_changecls($accc_, $sub)) {
        $check_change = true;
        $status_change = "Đã đổi";
    } else {
        $check_change = false;
        $status_change = "<font color =red>Chưa đổi</font>";
    }
    $before_info_re = array(
        0 => array('Nhân vật', "<a href=" . cn_url_modify('mod=char_manager', 'opt=info_char', 'sub') . " title='Click info $sub' >$sub </a>"),
        1 => array('Reset', $reset_rs), //lần thứ
        2 => array('Cấp độ', $str_lever),
        3 => array('Zen', $str_zen),
        4 => array('Chaos', $str_chao),
        5 => array('Creation', $str_cre),
        6 => array('Blue Feather', $str_blue),
        7 => array('Vpoint', isset($str_vp) ? $str_vp : null),
        10 => array('Limit Reset', $rs_day),
        11 => array('Đổi nhân vật', $status_change),
        12 => array('Online', $status),
    );

    //-----------------------------------------------
    if (request_type('POST')) {
        if (REQ('action_rs')) {
            cn_dsi_check(true);
            $errors_false = false;

            $resetup = $reset_rs + 1;
            $time_reset_next_ = $Resets_Time + (isset($time_reset_next) ? $time_reset_next : 5) * 60;
            
            list($verifyCaptcha) = GET('verifyCaptcha', 'GPG');
            if ($verifyCaptcha != $_SESSION['captcha_web']) {
                cn_throw_message("Captcah không đúng.", 'e');
                $errors_false = true;
            }
            if ($showchar[$sub]['PkLevel'] > 3) {
                cn_throw_message("Bạn đang là Sát thủ. Phải rửa tội trước khi Reset.", 'e');
                $errors_false = true;
            }
            if ($check_on) {
                cn_throw_message("Nhân vật chưa thoát Game. Hãy thoát Game trước khi thực hiện chức năng này.", 'e');
                $errors_false = true;
            }
            if (!$check_change) {
                cn_throw_message("Nhân vật $sub không được là nhân vật thoát ra sau cùng. Hãy vào Game và chọn nhân vật khác trước khi thực hiện chức năng này.", 'e');
                $errors_false = true;
            }
            if ($user_type_gh_rs == 1) {
                if ($rs_inday >= $gioihan_rs) {
                    cn_throw_message("Bạn đã Reset hết số lần Reset trong ngày. Vui lòng Ủy thác và đợi Reset tiếp vào ngày mai.", 'e');
                    $errors_false = true;
                }
            }
            if ($user_type_gh_rs == 2) {
                if ($get_vp < 0) {
                    cn_throw_message("Không có đủ Vpoint yêu cầu Reset. Bạn đang Reset $reset_rs lần, và đã Reset $rs_inday lần trong ngày hôm nay. Bạn cần có $VpointReset V.Point để Reset lần tiếp theo", 'e');
                    $errors_false = true;
                }
            }
            if ($reset_rs >= (isset($reset_relifes) ? $reset_relifes : 1000)) {
                cn_throw_message("$sub đang ReLife: $relife_vl - Reset: $reset_rs. Để Reset tiếp bạn cần phải ReLife.", 'e');
                $errors_false = true;
            }
            if (($get_blue < 0) OR ($get_cre < 0) OR ($get_chao < 0)) {
                cn_throw_message("Bạn không đủ Jewel trong ngân hàng.", 'e');
                $errors_false = true;
            }
            if ($test_vl < 0) {
                cn_throw_message("$sub cần " . abs($test_vl) . " level để Reset lần $resetup.", 'e');
                $errors_false = true;
            }
            if ($get_zen < 0) {
                cn_throw_message("$sub cần " . number_format((float)$zen, 0, ",", ".") . " Zen để Reset lần $resetup.", 'e');
                $errors_false = true;
            }
            if ($time_reset_next_ > $ctime) {
                $time_free = $time_reset_next_ - $ctime;
                cn_throw_message("$sub cần $time_free giây nữa để Reset lần tiếp theo.", 'e');
                $errors_false = true;
            }

            if (!$errors_false) {
                point_tax($sub);
                $default_class = do_select_character(
                    'DefaultClassType',
                    $arr_cls = 'Strength,Dexterity,Vitality,Energy,Life,MaxLife,Mana,MaxMana,MapNumber,MapPosX,MapPosY',
                    "Class='$class_' Or Class='$class_'-1 Or Class='$class_'-2 Or Class='$class_'-3"
                );
                $pointThue = do_select_character(
                    'Character',
                    'PointThue',
                    "Name='$sub' AND IsThuePoint=1 AND TimeThuePoint>".ctime()
                );

                $vpointnew = isset($get_vp) ? $get_vp : $set_vp;
                $CountNoResetInDay = $rs_inday + 1;
                $resetmoney = $get_zen;
                $resetpoint += (isset($point_relifes) ? $point_relifes : 0) + (empty($pointThue[0]['PointThue']) ? 0 : $pointThue[0]['PointThue']);
                $leadership += (isset($ml_relifes) ? $ml_relifes : 0);
                if ($leadership > 64000) $leadership = 64000;
                if ($resetpoint > 65000) {
                    $pointup = 65000;
                    $resetpoint -= 65000;
                } else {
                    $pointup = $resetpoint;
                    $resetpoint = 0;
                }

                if (($class_ == $arr_class['class_dl_1']) || ($class_ == $arr_class['class_dl_2'])) {
                } else $leadership = 0;

                $get_default_class = '';
                $_arr_cls = spsep($arr_cls);
                foreach ($_arr_cls as $key => $val)
                    $get_default_class .= "$val='" . $default_class[0][$val] . "',";

                $get_default_class = substr($get_default_class, 0, -1);

                //----------------------------------------------------------------
                do_update_character(
                    'Character',
                    'Clevel=1',
                    'Experience=0',
                    "Money=$resetmoney",
                    "LevelUpPoint=$pointup",
                    "pointdutru=$resetpoint",
                    "Resets=$resetup",
                    $get_default_class,
                    "Leadership=$leadership",
                    'MapDir=0',
                    "NoResetInDay=$CountNoResetInDay",
                    'NoResetInMonth=NoResetInMonth+1',
                    "Resets_Time=$ctime",
                    'ResetVIP=0',
                    "name:'$sub'"
                );

                if ($class_ == $arr_class['class_dw_3'] OR $class_ == $arr_class['class_dk_3'] OR $class_ == $arr_class['class_elf_3']) {
                    do_update_character(
                        'Character',
                        'Quest=0xaaeaffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff',
                        "Name:'$sub'"
                    );
                }

                //Add Xoay kiem cho DK
                if ($class_ == $arr_class['class_dk_1'] OR $class_ == $arr_class['class_dk_2'] OR $class_ == $arr_class['class_dk_3'])
                    do_update_character(
                        'Character',
                        'MagicList=0x2c0000430000440000450000460000470000290000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000',
                        "name:'$sub'"
                    );

                //Add Mui ten vo tan cho Elf C3
                if ($class_ == $arr_class['class_elf_3'])
                    do_update_character(
                        'Character',
                        'MagicList=0x2e00004300004400004500004600004700004d0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000',
                        "name:'$sub'"
                    );

                //Add Skill cho Summoner
                if ($class_ == $arr_class['class_sum_1'] OR $class_ == $arr_class['class_sum_2'] OR $class_ == $arr_class['class_sum_3'])
                    do_update_character(
                        'Character',
                        'MagicList=0xda0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000',
                        "name:'$sub'"
                    );

                /*
					//Reset Point Master Skill
					if (($class_ == $arr_class['class_dw_3']) || ($class_ == $arr_class['class_dk_3']) || ($class_ == $arr_class['class_elf_3']) || ($class_ == $arr_class['class_mg_2']) || ($class_ == $arr_class['class_dl_2']) || ($class_ == $arr_class['class_sum_3']) || ($class_ == $arr_class['class_rf_2'])){
						if(getoption('server_type') == "scf")
							do_update_character('Character', "SCFMasterPoints=$fg_123_pop_val", "Name:'$sub'");
								//$sql_reset_master_point = "UPDATE Character SET SCFMasterPoints=$master_check[0] WHERE Name='$character'";
						else if(getoption('server_type') == "ori")
							do_update_character('T_MasterLevelSystem', "ML_POINT=$fg_123_pop_val","CHAR_NAME:'$sub'");
								//$sql_reset_master_point = "UPDATE T_MasterLevelSystem SET ML_POINT=$master_check[0] WHERE CHAR_NAME='$character'";
						else
							do_update_character('Character', "SCFMasterPoints=$fg_123_pop_val","Name:'$sub'");
								//$sql_reset_master_point = "UPDATE Character SET SCFMasterPoints=$master_check[0] WHERE Name='$character'";
						//$result_reset_master_point = $db->Execute($sql_reset_master_point) or die("Lỗi Query: $sql_reset_master_point");
					}
					*/
                do_update_character(
                    'MEMB_INFO',
                    "jewel_chao=$get_chao",
                    "jewel_cre=$get_cre",
                    "jewel_blue=$get_blue",
                    "vpoint=$vpointnew",
                    "memb___id:'$accc_'"
                );

                //use event top test dd/mm/yy -> dd/mm/yy
                if ((getoption('event_toprs_on') == 1))// && (strtotime($event_toprs_begin) < $ctime) && (strtotime($event_toprs_end) + 24*60*60 > $ctime))
                {
                    //Kiem tra da co du lieu trong data Event_TOP_RS
                    $data___ = do_select_character('Event_TOP_RS', '*', "name='$sub'");
                    if ($data___) {
                        //Du lieu da co
                        do_update_character('Event_TOP_RS', 'resets=resets+1', "name:'$sub'");
                    } else {
                        //Du lieu chua co
                        do_insert_character('Event_TOP_RS', "acc='" . $accc_ . "'", "name='" . $sub . "'", 'resets=1');
                    }
                }

                //Ghi vào Log
                $content = "$sub Reset lần thứ $resetup _ lần thứ $CountNoResetInDay trong ngày";
                $Date = date("h:iA, d/m/Y", ctime());
                $file = MODULE_ADM . "/log/modules/character/log_resets.txt";
                $fp = fopen($file, "a+");
                fputs($fp, $accc_ . "|" . $content . "|" . $_blank_var[0]['gc'] . "_" . $set_vp . "|" . $_blank_var[0]['gc'] . "_" . $vpointnew . "|" . $Date . "|\n");
                fclose($fp);
                //End Ghi vào Log

                if ($user_type_gh_rs == 1) {
                    if ($gioihan_rs > $CountNoResetInDay) $rs_day_ = "$CountNoResetInDay / $gioihan_rs";
                    else if ($gioihan_rs == $CountNoResetInDay) $rs_day_ = "<font color=red> $CountNoResetInDay / $gioihan_rs </font>";
                } else if ($user_type_gh_rs == 2) {
                    $okloop = false;
                    if (isset($limit_2)) {
                        $lv_rs_en = 0;
                        foreach ($limit_2 as $d => $val) {
                            $lv_rs_f = $okloop ? $lv_rs_en : 1;
                            $lv_rs_en = $val['col1'];
                            $okloop = true;

                            if ($lv_rs_f < $resetup && $resetup <= $lv_rs_en) {
                                if (0 <= $CountNoResetInDay && $CountNoResetInDay <= $val['day1']) {
                                    $VpointReset = $val['col2'];
                                    break;
                                } else if ($val['day1'] < $CountNoResetInDay && $CountNoResetInDay <= $val['day2']) {
                                    $VpointReset = $val['col3'];
                                    break;
                                } else if ($val['day2'] < $CountNoResetInDay) {
                                    $VpointReset = $val['col4'];
                                    break;
                                }
                            }
                        }
                    }
                    if ($resetup > $limit_2[count($limit_2) - 1]['col1']) {
                        $abvc = $limit_2[count($limit_2) - 1];
                        if (0 <= $CountNoResetInDay && $CountNoResetInDay <= $abvc['day1']) {
                            $VpointReset = $abvc['col2'];
                        } else if ($abvc['day1'] < $CountNoResetInDay && $CountNoResetInDay <= $abvc['day2']) {
                            $VpointReset = $abvc['col3'];
                        } else if ($abvc['day2'] < $CountNoResetInDay) {
                            $VpointReset = $abvc['col4'];
                        }
                    }

                    $get_vpup = $vpointnew - (isset($VpointReset) ? $VpointReset : 0);
                    if ($get_vpup >= 0) $str_vp_ = "$vpointnew (Đủ Vpoint Reset)"; else {
                        $str_vp_ = "$vpointnew <font color =red> (Thiếu " . abs($get_vpup) . " Vpoint Reset)</font>";
                    }
                    $rs_day_ = "$CountNoResetInDay / ---";
                } else {
                    $rs_day_ = "$CountNoResetInDay / No limit";
                }

                if ($rs_index >= count($options_rs) - 1) $rs_index = count($options_rs) - 1;
                else if ($resetup > $i_e) ++$rs_index;

                $level = $options_rs[$rs_index]['level'];
                $zen = $options_rs[$rs_index]['zen'];
                $chao = $options_rs[$rs_index]['chaos'];
                $cre = $options_rs[$rs_index]['cre'];
                $blue = $options_rs[$rs_index]['blue'];

                foreach ($options_tanthu as $aq => $qa) {
                    if (($qa['reset_min'] <= $resetup && $resetup <= $qa['reset_max']) && ($qa['relife_min'] <= $relife_vl && $relife_vl <= $qa['relife_max']))
                        $giam_lvup = $qa['levelgiam'];
                }

                $abc_levelup = 1 - (isset($level) ? $level : 0);
                if (getoption('hotrotanthu')) {
                    $g_lvup = isset($giam_lvup) ? $giam_lvup : 0;
                    $test_vlup = $abc_levelup + $g_lvup;
                    if ($test_vlup >= 0) $str_leverup = "1 (Thiếu level Reset)";
                    else {
                        $thieu_leverup = ABS($test_vlup);
                        $str_leverup = "1 <font color =red>(Thiếu $thieu_leverup level Reset)</font>";
                        if ($g_lvup != 0) $str_leverup .= "<font color =#747484><i> Hỗ trợ tân thủ giảm $g_lvup level</i></font>";
                    }
                } else {
                    $test_vlup = $abc_levelup;
                    if ($test_vl >= 0) $str_leverup = "1 (Thiếu level Reset)";
                    else {
                        $f_lvup = ABS($abc_level);
                        $str_leverup = "1 <font color =red>(Thiếu $f_lvup level Reset)</font>";
                    }
                }
                if (($get_zen - $zen) >= 0) $str_zenup = number_format((float)$get_zen, 0, ",", ".") . " (Đủ Zen Reset)"; else {
                    $str_zenup = number_format((float)$get_zen, 0, ",", ".") . " <font color =red> (Thiếu " . number_format((float)(ABS($get_zen - $zen)), 0, ",", ".") . " Zen Reset)</font>";
                }
                if (($get_chao - $chao) >= 0) $str_chaoup = number_format((float)$get_chao, 0, ",", ".") . " (Đủ Chaos Reset)"; else {
                    $str_chaoup = number_format((float)$get_chao, 0, ",", ".") . " <font color =red> (Thiếu " . number_format((float)(ABS($get_chao - $chao)), 0, ",", ".") . " Chaos Reset)</font>";
                }
                if (($get_cre - $cre) >= 0) $str_creup = number_format((float)$get_cre, 0, ",", ".") . " (Đủ Creation Reset)"; else {
                    $str_creup = number_format((float)$get_cre, 0, ",", ".") . " <font color =red> (Thiếu " . number_format((float)(ABS($get_cre - $cre)), 0, ",", ".") . " Create Reset)</font>";
                }
                if (($get_blue - $blue) >= 0) $str_blueup = number_format((float)$get_blue, 0, ",", ".") . " (Đủ Blue Reset)"; else {
                    $str_blueup = number_format((float)$get_blue, 0, ",", ".") . " <font color =red> (Thiếu " . number_format((float)(ABS($get_blue - $blue)), 0, ",", ".") . " Blue Reset)</font>";
                }

                $before_info_re[1][1] = $resetup;
                $before_info_re[2][1] = $str_leverup;
                $before_info_re[3][1] = $str_zenup;
                $before_info_re[4][1] = $str_chaoup;
                $before_info_re[5][1] = $str_creup;
                $before_info_re[6][1] = $str_blueup;
                $before_info_re[7][1] = isset($str_vp_) ? $str_vp_ : null;
                $before_info_re[10][1] = $rs_day_;
                ++$showchar[$sub]['reset'];
                $showchar[$sub]['level'] = 1;
                ++$showchar[$sub]['resetInDay'];

                cn_throw_message("$sub Reset lần thứ $resetup thành công!");
                if ($resetpoint > 0) $str_rutpoint = "Bạn có " . number_format((float)$pointup, 0, ",", ".") . " Point. Vui lòng <a href='" . cn_url_modify('mod=char_manager', 'opt=addpoint', 'sub=' . $sub) . "' title='cộng Point'> cộng Point </a> trước khi <b><a href ='" . cn_url_modify('mod=char_manager', 'opt=subpoint', 'sub=' . $sub) . "' title='rút Point'> rút Point</a></b> còn lại cho nhân vật $sub.";
                else $str_rutpoint = "Bạn có " . number_format((float)$pointup, 0, ",", ".") . " Point. Vui lòng <a href ='" . cn_url_modify('mod=char_manager', 'opt=addpoint', 'sub=' . $sub) . "'> cộng Point </a> cho nhân vật $sub.";
                $str_rutpoint .= "<br> <font color=red><i><em>Lưu ý</em><i>: Cộng Point mới có Skill!</font>";
            }
        }
    }
    //-----------------------------------------------

    $user_max_rs = getoption('cap_reset_max');
    if ($user_max_rs > 20) $user_max_rs = 20;

    $get_gh_loai1 = isset($limit_1) ? $limit_1 : array();
    $get_gh_loai2 = isset($limit_2) ? $limit_2 : array();
    $options_rs = isset($options_rs) ? $options_rs : array();
    $showchar_ = isset($showchar) ? $showchar : array();
    $show_re_succser = isset($str_rutpoint) ? $str_rutpoint : null;

    cn_assign('user_max_rs, user_type_gh_rs, before_info_re, options_tanthu', $user_max_rs, $user_type_gh_rs, $before_info_re, $options_tanthu);
    cn_assign('gh_loai1, gh_loai2, set_arr_rs, showchar, notify_rs_ok', $get_gh_loai1, $get_gh_loai2, $options_rs, $showchar_, $show_re_succser);
    cn_assign('sub', $sub);

    $arr_shop = mcache_get('.breadcrumbs');
    $name__ = array_pop($arr_shop)['name'];
    echoheader('-@my_char/style.css', "$sub reset thường - $name__");
    echocomtent_here(exec_tpl('my_char/reset'), cn_snippet_bc_re());
    echofooter();
}

function char_resetvip()
{
    $member = member_get();
    list($sub) = GET('sub', 'GPG');
    $accc_ = $member['user_name'];

    $_blank_var = view_bank($accc_);
    $options_rsvip = cn_template_resetvip();
    $options_gh1 = cn_template_rslimit1();
    $options_gh2 = cn_template_rslimit2();
    $options_tanthu = cn_template_httt();
    $arr_class = cn_template_class();
    $options_rl = cn_template_relife();
    $showchar = cn_character();

    if (!$sub) $sub = array_keys($showchar)[0];
    else {
        if (!in_array($sub, array_keys($showchar)))
            $sub = array_keys($showchar)[0];
    };

    //$zen_acc_char = $showchar[$sub]['money'];
    $level_acc_char = $showchar[$sub]['level'];
    $rsvip_inday = $showchar[$sub]['resetInDay'];
    $rsvip_top_50 = $showchar[$sub]['top_50'];
    $Resets_Time = $showchar[$sub]['Resets_Time'];
    $inventory = $showchar[$sub]['shop_inventory'];
    $reset_rsvip = $showchar[$sub]['reset'];
    $relife_vl = $showchar[$sub]['relife'];
    $class_ = $showchar[$sub]['class'];
    $user_type_gh_rs = getoption('use_gioihanrs');
    $ctime = ctime();

    $blank_vp = $_blank_var[0]['vp'];
    $blank_gcoin = $_blank_var[0]['gc'];
    $blank_gcoin_km = $_blank_var[0]['gc_km'];
    $tong_gcoin = $blank_gcoin + $blank_gcoin_km;

    if (isset($options_rsvip)) {
        $ok_loop = false;
        $resetpoint_vip = $leadership_vip = $rsvip_index = 0;
        $i_e = $p_e = $ml_e = 0;
        foreach ($options_rsvip as $aq => $qa) {
            $i_f = $ok_loop ? $i_e : 0;
            $i_e = $qa['reset'];
            $p_f = $ok_loop ? $p_e : 0;
            $p_e = $qa['point'];
            $ml_f = $ok_loop ? $ml_e : 0;
            $ml_e = $qa['command'];
            $ok_loop = true;

            if (($reset_rsvip > $i_f) && ($reset_rsvip <= $i_e) || ($reset_rsvip == 0)) {
                $level = $qa['level'];
                $kt_vpoint = $qa['vpoint'];
                $kt_gcoin = $qa['gcoin'];
                $time_reset_next = $qa['time'];

                $resetpoint_vip += $qa['point'] * ($reset_rsvip - $i_f);
                $leadership_vip += $qa['command'] * ($reset_rsvip - $i_f);
                $rsvip_index = $aq;
                break;
            }
            $resetpoint_vip += ($i_e - $i_f) * $p_e;
            $leadership_vip += ($i_e - $i_f) * $ml_e;
        }

        $level = isset($level) ? $level : $options_rsvip[count($options_rsvip) - 1]['level'];
        $kt_vpoint = isset($kt_vpoint) ? $kt_vpoint : $options_rsvip[count($options_rsvip) - 1]['vpoint'];
        $kt_gcoin = isset($kt_gcoin) ? $kt_gcoin : $options_rsvip[count($options_rsvip) - 1]['gcoin'];
        $time_reset_next = isset($time_reset_next) ? $time_reset_next : $options_rsvip[count($options_rsvip) - 1]['time'];
    }

    if (isset($options_rl)) {
        foreach ($options_rl as $_aq => $qa) {
            if ($relife_vl == $_aq) {
                $reset_relifes = $qa['reset'];
                $point_relifes = $qa['point'];
                $ml_relifes = $qa['command'];
                break;
            }
        }
        $reset_relifes = isset($reset_relifes) ? $reset_relifes : $options_rl[count($options_rl) - 1]['reset'];
        $point_relifes = isset($point_relifes) ? $point_relifes : $options_rl[count($options_rl) - 1]['point'];
        $ml_relifes = isset($ml_relifes) ? $ml_relifes : $options_rl[count($options_rl) - 1]['command'];
    }

    if (getoption('hotrotanthu')) {
        if (isset($options_tanthu)) {
            foreach ($options_tanthu as $aq => $qa) {
                if (($qa['reset_min'] <= $reset_rsvip && $reset_rsvip <= $qa['reset_max']) && ($qa['relife_min'] <= $relife_vl && $relife_vl <= $qa['relife_max'])) {
                    $giam_lv = $qa['levelgiam'];
                    break;
                }
            }
        }
    }

    $result_rsvip_false = false;
    if ($blank_gcoin_km >= $kt_gcoin) {
        $get_blank_gkm = $blank_gcoin_km - $kt_gcoin;
        $sms_gckm = " (Đủ Gcoin KM)";
    } else if ($blank_gcoin >= $kt_gcoin) {
        $get_blank_g = $blank_gcoin - $kt_gcoin;
        $sms_gc = " (Đủ Gcoin)";
    } else if ($tong_gcoin >= $kt_gcoin) {
        $get_blank_g = $blank_gcoin + $blank_gcoin_km - $kt_gcoin;
        $get_blank_gkm = 0;
        $sms_gc = " (Đủ Gcoin)";
    } else if ($blank_vp >= $kt_vpoint) {
        $get_blank_vp = $blank_vp - $kt_vpoint;
        $sms_vp = " (Đủ Vpoint)";
    } else {
        $result_rsvip_false = true;
        $sms_vp = " <font color=red>(Thiếu " . abs($kt_vpoint - $blank_vp) . " Vpoint)</font>";
    }
    //if(!$result_rsvip_false){$result_rs_blank = "Đủ để Reset Vip";}
    //else{$result_rs_blank = "<font color=red>Không đủ Reset Vip</font>";}

    //$gcoin_rsvip = isset($get_blank_g) ? $get_blank_g : $blank_gcoin;
    //$gcoin_gkm_rsvip = isset($get_blank_gkm) ? $get_blank_gkm : $blank_gcoin_km;
    //$vpoint_rsvip = isset($get_blank_vp) ? $get_blank_vp : $blank_vp;

    $abc_level = $level_acc_char - (isset($level) ? $level : 0);

    if (getoption('hotrotanthu')) {
        $g_lv = isset($giam_lv) ? $giam_lv : 0;
        $test_vl = $abc_level + $g_lv;
        if ($test_vl >= 0) {
            $str_lever = "$level_acc_char (Đủ level)";
            if ($g_lv != 0) $str_lever .= "<font color =#747484><i> Hỗ trợ tân thủ giảm $g_lv level</i></font>";
        } else {
            $thieu_lever = ABS($test_vl);
            $str_lever = "$level_acc_char <font color =red>(Thiếu " . abs($thieu_lever) . " level)</font>";
            if ($g_lv != 0) $str_lever .= "<font color =#747484><i> Hỗ trợ tân thủ giảm $g_lv level</i></font>";
        }
    } else {
        $test_vl = $abc_level;
        if ($test_vl >= 0)
            $str_lever = "$level_acc_char (Đủ level).";
        else {
            $f_lv = ABS($abc_level);
            $str_lever = "$level_acc_char <font color =red>(Thiếu " . abs($f_lv) . " level)</font>";
        }
    }

    if ($user_type_gh_rs == 1) {
        $i_frist = 0;
        $i_end = 10;
        foreach ($options_gh1 as $df => $fd) {
            if ($rsvip_top_50 > $i_frist && $rsvip_top_50 <= $i_end) $gioihan_rsvip = $fd['top'];
            $i_frist = $i_end;
            $i_end = $i_end + 10;
        }
        $gioihan_rsvip = isset($gioihan_rsvip) ? $gioihan_rsvip : $options_gh1[count($options_gh1) - 1]['top'];
        if ($gioihan_rsvip > $rsvip_inday) $rs_day = "$rsvip_inday / $gioihan_rsvip";
        else $rs_day = "<font color=red> $rsvip_inday / $gioihan_rsvip </font>";
    } else if ($user_type_gh_rs == 2) {
        $okloop = false;

        if (isset($options_gh2)) {
            $lv_rs_en = 0;
            foreach ($options_gh2 as $d => $val) {
                if ($okloop) {
                    $lv_rs_f = $lv_rs_en;
                    $lv_rs_en = $val['col1'];
                } else {
                    $lv_rs_f = 1;
                    $lv_rs_en = $val['col1'];
                    $okloop = true;
                }
                if ($lv_rs_f < $reset_rsvip && $reset_rsvip <= $lv_rs_en) {
                    if (0 <= $rsvip_inday && $rsvip_inday <= $val['day1']) {
                        $VpointReset = $val['col2'];
                        break;
                    } else if ($val['day1'] < $rsvip_inday && $rsvip_inday <= $val['day2']) {
                        $VpointReset = $val['col3'];
                        break;
                    } else if ($val['day2'] < $rsvip_inday) {
                        $VpointReset = $val['col4'];
                        break;
                    }
                }
            }
        }

        if ($reset_rsvip > $options_gh2[count($options_gh2) - 1]['col1']) {
            $abvc = $options_gh2[count($options_gh2) - 1];
            if (0 <= $rsvip_inday && $rsvip_inday <= $abvc['day1']) {
                $VpointReset = $abvc['col2'];
            } else if ($abvc['day1'] < $rsvip_inday && $rsvip_inday <= $abvc['day2']) {
                $VpointReset = $abvc['col3'];
            } else if ($abvc['day2'] < $rsvip_inday) {
                $VpointReset = $abvc['col4'];
            }
        }

        $rs_day = "$rsvip_inday / ---";
        $get_vp = (isset($get_blank_vp) ? $get_blank_vp : $blank_vp) - (isset($VpointReset) ? $VpointReset : 0);

        if ($get_vp < 0) {
            $str_vp = " " . number_format((float)$blank_vp, 0, ",", ".") . " <font color =red> (Thiếu " . number_format((float)(abs($get_vp)), 0, ",", ".") . " Vpoint Reset Vip)</font>";
            $sms_vp = " <font color=red>(Thiếu " . abs($get_vp) . " Vpoint)</font>";
        }
    } else {
        $rs_day = "$rsvip_inday / No limit";
    }

    if (check_online($accc_)) {
        $check_on = true;
        $status = "<font color =red>Online</font>";
    } else {
        $check_on = false;
        $status = "Offline";
    }
    if (check_changecls($accc_, $sub)) {
        $check_change = true;
        $status_change = "Đã đổi";
    } else {
        $check_change = false;
        $status_change = "<font color =red>Chưa đổi</font>";
    }
    $before_info_rsvip = array(
        0 => array('Nhân vật', "<a href=" . cn_url_modify('mod=char_manager', 'opt=info_char', 'sub') . " title='Click info $sub'> $sub </a>"),
        1 => array('Reset', $reset_rsvip),
        2 => array('Cấp độ', $str_lever),
        9 => array('Gcoin KM', number_format((float)$blank_gcoin_km, 0, ",", ".") . (isset($sms_gckm) ? $sms_gckm : '')),
        8 => array('Gcoin', number_format((float)$blank_gcoin, 0, ",", ".") . (isset($sms_gc) ? $sms_gc : '')),
        7 => array('Vpoint', number_format((float)$blank_vp, 0, ",", ".") . (isset($sms_vp) ? $sms_vp : '')),
        //13 => array('Config Reset Vip', $result_rs_blank),
        //10 => array('Limit ResetVip',$rs_day.(isset($str_vp) ? $str_vp : '')),
        10 => array('Limit ResetVip', $rs_day),
        11 => array('Đổi nhân vật', $status_change),
        12 => array('Online', $status),
    );

    //-----------------------------------------------
    if (request_type('POST')) {
        if (REQ('action_rsvip')) {
           cn_dsi_check(true);
            $errors_false = false;

            $resetvipup = $reset_rsvip + 1;
            $time_reset_next_ = $Resets_Time + (isset($time_reset_next) ? $time_reset_next : 5) * 60;

            list($verifyCaptcha) = GET('verifyCaptcha', 'GPG');
            if ($verifyCaptcha != $_SESSION['captcha_web']) {
                cn_throw_message("Captcah không đúng.", 'e');
                $errors_false = true;
            }
            if ($showchar[$sub]['PkLevel'] > 3) {
                cn_throw_message("Bạn đang là Sát thủ. Phải rửa tội trước khi Reset Vip.", 'e');
                $errors_false = true;
            }
            if ($check_on) {
                cn_throw_message("Nhân vật chưa thoát Game. Hãy thoát Game trước khi thực hiện chức năng này.", 'e');
                $errors_false = true;
            }
            if (!$check_change) {
                cn_throw_message("Nhân vật $sub không được là nhân vật thoát ra sau cùng. Hãy vào Game và chọn nhân vật khác trước khi thực hiện chức năng này.", 'e');
                $errors_false = true;
            }
            if ($user_type_gh_rs == 1) {
                if ($rsvip_inday >= $gioihan_rsvip) {
                    cn_throw_message("Bạn đã Reset hết số lần Reset Vip trong ngày. Vui lòng Ủy thác và đợi Reset Vip tiếp vào ngày mai.", 'e');
                    $errors_false = true;
                }
            }
            if ($user_type_gh_rs == 2) {
                if ($get_vp < 0) {
                    cn_throw_message("Không có đủ Vpoint yêu cầu Limit ResetVip. Bạn đang Reset Vip $reset_rsvip lần, và đã Reset Vip $rsvip_inday lần trong ngày hôm nay. Bạn cần có " . abs($get_vp) . " V.Point để Reset Vip lần tiếp theo.", 'e');
                    $errors_false = true;
                }
            }
            if ($reset_rsvip >= (isset($reset_relifes) ? $reset_relifes : 1000)) {
                cn_throw_message("$sub đang ReLife: $relife_vl - Reset Vip: $reset_rsvip. Để Reset Vip tiếp bạn cần phải ReLife.", 'e');
                $errors_false = true;
            }
            if ($result_rsvip_false) {
                cn_throw_message("Bạn không đủ Gcoin KM, Gcoin, Vpoint để Reset Vip.", 'e');
                $errors_false = true;
            }
            if ($test_vl < 0) {
                cn_throw_message("$sub cần " . abs($test_vl) . " level để Reset Vip lần $resetvipup.", 'e');
                $errors_false = true;
            }
            if ($time_reset_next_ > $ctime) {
                $time_free = $time_reset_next_ - $ctime;
                cn_throw_message("$sub cần $time_free giây nữa để Reset Vip lần tiếp theo.", 'e');
                $errors_false = true;
            }

            if (!$errors_false) {
                point_tax($sub);
                $default_class = do_select_character(
                    'DefaultClassType',
                    $arr_cls = 'Strength,Dexterity,Vitality,Energy,Life,MaxLife,Mana,MaxMana,MapNumber,MapPosX,MapPosY',
                    "Class='$class_' Or Class='$class_'-1 Or Class='$class_'-2 Or Class='$class_'-3"
                );
                $pointThue = do_select_character(
                    'Character',
                    'PointThue',
                    "Name='$sub' AND IsThuePoint=1 AND TimeThuePoint>".ctime()
                );

                $gcoin_rsvip = isset($get_blank_g) ? $get_blank_g : $blank_gcoin;
                $gcoin_gkm_rsvip = isset($get_blank_gkm) ? $get_blank_gkm : $blank_gcoin_km;
                //$vpoint_rsvip = isset($get_blank_vp) ? $get_blank_vp : $blank_vp;
                //$vpointnew = (isset($get_blank_vp) ? $get_blank_vp : $blank_vp) - (isset($get_vp) ? $get_vp : $set_vp);
                $vpointnew = isset($get_vp) ? $get_vp : $blank_vp;

                $CountNoResetInDay = $rsvip_inday + 1;
                $resetpoint_vip += (isset($point_relifes) ? $point_relifes : 0) + (empty($pointThue[0]['PointThue']) ? 0 : $pointThue[0]['PointThue']);
                $leadership_vip += (isset($ml_relifes) ? $ml_relifes : 0);
                if ($leadership_vip > 64000) $leadership_vip = 64000;
                if ($resetpoint_vip > 65000) {
                    $pointup_vip = 65000;
                    $resetpoint_vip -= 65000;
                } else {
                    $pointup_vip = $resetpoint_vip;
                    $resetpoint_vip = 0;
                }

                if ($class_ == $arr_class['class_dl_1'] || $class_ == $arr_class['class_dl_2']) {
                    $leadership = $leadership_vip;
                } else $leadership = 0;
                $get_default_class = '';
                $_arr_cls = spsep($arr_cls);
                foreach ($_arr_cls as $key => $val) $get_default_class .= "$val=" . $default_class[0][$val] . ",";

                $get_default_class = substr($get_default_class, 0, -1);


                do_update_character(
                    'Character',
                    'Clevel=1',
                    'Experience=0',
                    "LevelUpPoint=$pointup_vip",
                    "pointdutru=$resetpoint_vip",
                    "Resets=$resetvipup",
                    $get_default_class,
                    "Leadership=$leadership",
                    'MapDir=0',
                    "NoResetInDay=$CountNoResetInDay",
                    'NoResetInMonth=NoResetInMonth+1',
                    "Resets_Time=$ctime",
                    'ResetVIP=1',
                    "name:'$sub'"
                );

                //All Quest For Class 3
                if ($class_ == $arr_class['class_dw_3'] OR $class_ == $arr_class['class_dk_3'] OR $class_ == $arr_class['class_elf_3']) {
                    do_update_character(
                        'Character',
                        'Quest=0xaaeaffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff',
                        "Name:'$sub'"
                    );
                }

                //Add Xoay kiem cho DK
                if ($class_ == $arr_class['class_dk_1'] OR $class_ == $arr_class['class_dk_2'] OR $class_ == $arr_class['class_dk_3'])
                    do_update_character(
                        'Character',
                        'MagicList=0x2c0000430000440000450000460000470000290000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000',
                        "name:'$sub'"
                    );

                //Add Mui ten vo tan cho Elf C3
                if ($class_ == $arr_class['class_elf_3'])
                    do_update_character(
                        'Character',
                        'MagicList=0x2e00004300004400004500004600004700004d0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000',
                        "name:'$sub'"
                    );

                //Add Skill cho Summoner
                if ($class_ == $arr_class['class_sum_1'] OR $class_ == $arr_class['class_sum_2'] OR $class_ == $arr_class['class_sum_3'])
                    do_update_character(
                        'Character',
                        'MagicList=0xda0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000',
                        "name:'$sub'"
                    );

                /*
					//Reset Point Master Skill
					if (($class_ == $arr_class['class_dw_3']) || ($class_ == $arr_class['class_dk_3']) || ($class_ == $arr_class['class_elf_3']) || ($class_ == $arr_class['class_mg_2']) || ($class_ == $arr_class['class_dl_2']) || ($class_ == $arr_class['class_sum_3']) || ($class_ == $arr_class['class_rf_2'])){
						if(getoption('server_type') == "scf")
							do_update_character('Character', "SCFMasterPoints=$fg_123_pop_val", "Name:'$sub'");
						else if(getoption('server_type') == "ori")
							do_update_character('T_MasterLevelSystem', "ML_POINT=$fg_123_pop_val","CHAR_NAME:'$sub'");
						else
							do_update_character('Character', "SCFMasterPoints=$fg_123_pop_val","Name:'$sub'");
					}
					*/
                do_update_character(
                    'MEMB_INFO',
                    "gcoin=$gcoin_rsvip",
                    "gcoin_km=$gcoin_gkm_rsvip",
                    "vpoint=$vpointnew",
                    "memb___id:'$accc_'"
                );

                //use event top test dd/mm/yy -> dd/mm/yy
                if ((getoption('event_toprs_on') == 1))// && (strtotime($event_toprs_begin) < $ctime) && (strtotime($event_toprs_end) + 24*60*60 > $ctime))
                {
                    $data___ = do_select_character('Event_TOP_RS', '*', "name='$sub'");
                    if ($data___) {
                        do_update_character('Event_TOP_RS', 'resets=resets+1', "name:'$sub'");
                    } else {
                        do_insert_character('Event_TOP_RS', "acc='" . $accc_ . "'", "name='" . $sub . "'", 'resets=1');
                    }
                }

                if ($user_type_gh_rs == 1) {
                    if ($gioihan_rsvip > $CountNoResetInDay) $rs_day_ = "$CountNoResetInDay / $gioihan_rsvip";
                    else if ($gioihan_rsvip == $CountNoResetInDay) $rs_day_ = "<font color=red> $CountNoResetInDay / $gioihan_rsvip </font>";
                } else if ($user_type_gh_rs == 2) {
                    $okloop = false;
                    if (isset($options_gh2))
                        foreach ($options_gh2 as $d => $val) {
                                $lv_rs_f = $okloop ?  $lv_rs_en : 1;
                                $lv_rs_en = $val['col1'];
                                $okloop = true;

                            if ($lv_rs_f < $resetvipup && $resetvipup <= $lv_rs_en) {
                                if (0 <= $CountNoResetInDay && $CountNoResetInDay <= $val['day1']) {
                                    $VpointReset = $val['col2'];
                                    break;
                                } else if ($val['day1'] < $CountNoResetInDay && $CountNoResetInDay <= $val['day2']) {
                                    $VpointReset = $val['col3'];
                                    break;
                                } else if ($val['day2'] < $CountNoResetInDay) {
                                    $VpointReset = $val['col4'];
                                    break;
                                }
                            }
                        }

                    if ($resetvipup > $options_gh2[count($options_gh2) - 1]['col1']) {
                        $abvc = $options_gh2[count($options_gh2) - 1];
                        if (0 <= $CountNoResetInDay && $CountNoResetInDay <= $abvc['day1']) {
                            $VpointReset = $abvc['col2'];
                        } else if ($abvc['day1'] < $CountNoResetInDay && $CountNoResetInDay <= $abvc['day2']) {
                            $VpointReset = $abvc['col3'];
                        } else if ($abvc['day2'] < $CountNoResetInDay) {
                            $VpointReset = $abvc['col4'];
                        }
                    }

                    $rs_day_ = "$CountNoResetInDay / ---";
                    $get_vp_ = $vpointnew - (isset($VpointReset) ? $VpointReset : 0);
                    if ($get_vp_ < 0)
                        $str_vp_ = " " . number_format((float)$vpointnew, 0, ",", ".") . " <font color =red> (Thiếu " . number_format((float)(abs($get_vp_)), 0, ",", ".") . " Vpoint Reset Vip)</font>";
                } else $rs_day_ = "$CountNoResetInDay / No limit";

                //if($rsvip_index >= count($options_rsvip)-1) $rsvip_index = count($options_rsvip)-1;
                //else
                if ($resetvipup > $i_e) {
                    ++$rsvip_index;
                    $level = $options_rsvip[$rsvip_index]['level'];
                    $kt_vpoint = $options_rsvip[$rsvip_index]['vpoint'];
                    $kt_gcoin = $options_rsvip[$rsvip_index]['gcoin'];
                }
                foreach ($options_tanthu as $aq => $qa) {
                    if (($qa['reset_min'] <= $resetvipup && $resetvipup <= $qa['reset_max']) && ($qa['relife_min'] <= $relife_vl && $relife_vl <= $qa['relife_max']))
                        $giam_lvup = $qa['levelgiam'];
                }

                $abc_levelup = 1 - (isset($level) ? $level : 0);
                if (getoption('hotrotanthu')) {
                    $g_lvup = isset($giam_lvup) ? $giam_lvup : 0;
                    $test_vlup = $abc_levelup + $g_lvup;
                    if ($test_vlup >= 0) $str_leverup = "1 (Thiếu level)";
                    else {
                        $thieu_leverup = ABS($test_vlup);
                        $str_leverup = "1 <font color =red>(Thiếu " . abs($thieu_leverup) . " level)</font>";
                        if ($g_lvup != 0) $str_leverup .= "<font color =#747484><i> Hỗ trợ tân thủ giảm $g_lvup level</i></font>";
                    }
                } else {
                    $test_vlup = $abc_levelup;
                    if ($test_vl >= 0) $str_leverup = "1 (Thiếu level)";
                    else {
                        $f_lvup = ABS($abc_level);
                        $str_leverup = "1 <font color =red>(Thiếu " . abs($f_lvup) . " level)</font>";
                    }
                }
                //>>>>>>>>>>>>>>>>>>>>>> update .... loai 2....
                if (($gcoin_gkm_rsvip > $kt_gcoin) || ($gcoin_rsvip >= $kt_gcoin) || (($gcoin_gkm_rsvip + $gcoin_rsvip) >= $kt_gcoin) || ((isset($get_vp_) ? $get_vp_ : $vpointnew) >= $kt_vpoint)) $result_rsvip_false = true;
                else $result_rsvip_false = false;

                if ($result_rsvip_false) {
                    $result_rs_blank_ = "Đủ để Reset Vip";
                } else {
                    $result_rs_blank_ = "<font color=red>Không đủ Reset Vip</font>";
                }

                $before_info_rsvip[1][1] = $resetvipup;
                $before_info_rsvip[2][1] = $str_leverup;
                $before_info_rsvip[7][1] = number_format((float)$vpointnew, 0, ",", ".");
                $before_info_rsvip[8][1] = number_format((float)$gcoin_rsvip, 0, ",", ".");
                $before_info_rsvip[9][1] = number_format((float)$gcoin_gkm_rsvip, 0, ",", ".");
                $before_info_rsvip[10][1] = $rs_day_ . (isset($str_vp_) ? $str_vp_ : '');
                //$before_info_rsvip[13][1] = $result_rs_blank_;

                $showchar[$sub]['reset'] = $resetvipup;
                $showchar[$sub]['level'] = 1;
                $showchar[$sub]['resetInDay'] = $CountNoResetInDay;

                //Ghi vào Log
                $content = "$sub Reset Vip lần thứ $resetvipup _ lần thứ $CountNoResetInDay trong ngày";
                //$Date = date("h:iA, d/m/Y");
                $Date = date("h:iA, d/m/Y", ctime());
                $file = MODULE_ADM . "/log/modules/character/log_resetsvip.txt";
                $fp = fopen($file, "a+");
                fputs($fp, $accc_ . "|" . $content . "|" . $blank_gcoin . "_" . $blank_vp . "_" . $blank_gcoin_km . "|" . $gcoin_rsvip . "_" . $vpointnew . "_" . $gcoin_gkm_rsvip . "|" . $Date . "|\n");
                fclose($fp);
                //End Ghi vào Log

                cn_throw_message("$sub Reset Vip lần thứ $resetvipup thành công!");
                if ($resetpoint_vip > 0) $str_rutpoint = "Bạn có " . number_format((float)$pointup_vip, 0, ",", ".") . " Point. Vui lòng <a href='" . cn_url_modify('mod=char_manager', 'opt=addpoint', 'sub=' . $sub) . "' title='cộng Point'> cộng Point </a> trước khi <b><a href ='" . cn_url_modify('mod=char_manager', 'opt=subpoint', 'sub=' . $sub) . "' title='rút Point'> rút Point</a></b> còn lại cho nhân vật $sub.";
                else $str_rutpoint = "Bạn có " . number_format((float)$pointup_vip, 0, ",", ".") . " Point. Vui lòng <a href ='" . cn_url_modify('mod=char_manager', 'opt=addpoint', 'sub=' . $sub) . "'> cộng Point </a> cho nhân vật $sub.";
                $str_rutpoint .= "<br><font color=red><i><em>Lưu ý</em><i>: Cộng Point mới có Skill! </font>";
            }
        }
    }
    //-----------------------------------------------

    $user_max_rs = getoption('cap_reset_max');
    if ($user_max_rs > 20) $user_max_rs = 20;

    $get_gh_loai1 = isset($options_gh1) ? $options_gh1 : array();
    $get_gh_loai2 = isset($options_gh2) ? $options_gh2 : array();
    $options_rs = isset($options_rs) ? $options_rs : array();
    $options_gh = isset($options_gh) ? $options_gh : array();
    $showchar_ = isset($showchar) ? $showchar : array();
    $show_re_succser = isset($str_rutpoint) ? $str_rutpoint : null;

    cn_assign('user_max_rs, user_type_gh_rs, before_info_rsvip, options_tanthu', $user_max_rs, $user_type_gh_rs, $before_info_rsvip, $options_tanthu);
    cn_assign('gh_loai1, gh_loai2, set_arr_gh, set_arr_rsvip, showchar, notify_rs_ok', $get_gh_loai1, $get_gh_loai2, $options_gh, $options_rsvip, $showchar_, $show_re_succser);
    cn_assign('sub', $sub);

    $arr_shop = mcache_get('.breadcrumbs');
    $name__ = array_pop($arr_shop)['name'];
    echoheader('-@my_char/style.css', "$sub Reset Vip - $name__");
    echocomtent_here(exec_tpl('my_char/resetvip'), cn_snippet_bc_re());

    echofooter();
}

// =====================================================================================================================

function char_relife()
{
    $member = member_get();
    list($sub) = GET('sub', 'GPG');
    $accc_ = $member['user_name'];
    $showchar = cn_character();

    $arr_class = cn_template_class();
    $options_rl = cn_template_relife();

    if (!$sub) $sub = array_keys($showchar)[0];
    else {
        if (!in_array($sub, array_keys($showchar)))
            $sub = array_keys($showchar)[0];
    };

    $level_acc_char = $showchar[$sub]['level'];
    $reset_rs = $showchar[$sub]['reset'];
    $relife_vl = $showchar[$sub]['relife'];
    $class_ = $showchar[$sub]['class'];
    $ctime = ctime();

    if (isset($options_rl)) {
        foreach ($options_rl as $aq => $qa) {
            if ($relife_vl == $aq) {
                $reset_relifes = $qa['reset'];
                $point_relifes = $qa['point'];
                $ml_relifes = $qa['command'];
                break;
            }
        }
    }
    if (0 < $f_lv = 400 - $level_acc_char) {
        $str_lever = "$level_acc_char <font color =red>(Thiếu ". abs($f_lv) ." level)</font>";
    } else $str_lever = "$level_acc_char (Đủ level)";

    if (0 < $relife_rs = $reset_relifes - $reset_rs) {
        $str_rs = "$reset_rs <font color =red>(Thiếu ". abs($relife_rs) ." Reset)</font>";
    } else $str_rs = "$level_acc_char (Đủ Reset)";

    if (check_online($accc_)) {
        $check_on = true;
        $status = "<font color =red>Online</font>";
    } else {
        $check_on = false;
        $status = "Offline";
    }
    if (check_changecls($accc_, $sub)) {
        $check_change = true;
        $status_change = "Đã đổi";
    } else {
        $check_change = false;
        $status_change = "<font color =red>Chưa đổi</font>";
    }
    $before_info_rl = array(
        0 => array('Nhân vật', "<a href=" . cn_url_modify('mod=char_manager', 'opt=info_char', 'sub') . " title='Click info $sub'> $sub </a>"),
        2 => array('Relife', $relife_vl),
        3 => array('Reset', $str_rs),
        4 => array('Cấp độ', $str_lever),
        5 => array('Đổi nhân vật', $status_change),
        6 => array('Online', $status),
    );

    //-----------------------------------------------
    if (request_type('POST')) {
        if (REQ('action_relife')) {
           cn_dsi_check(true);
            $errors_false = false;

            list($verifyCaptcha) = GET('verifyCaptcha', 'GPG');
            if ($verifyCaptcha != $_SESSION['captcha_web']) {
                cn_throw_message("Captcah không đúng.", 'e');
                $errors_false = true;
            }
            if ($showchar[$sub]['PkLevel'] > 3) {
                cn_throw_message("Bạn đang là Sát thủ. Phải rửa tội trước khi Reset Vip.", 'e');
                $errors_false = true;
            }
            if ($check_on) {
                cn_throw_message("Nhân vật chưa thoát Game. Hãy thoát Game trước khi thực hiện chức năng này.", 'e');
                $errors_false = true;
            }
            if (!$check_change) {
                cn_throw_message("Nhân vật $sub không được là nhân vật thoát ra sau cùng. Hãy vào Game và chọn nhân vật khác trước khi thực hiện chức năng này.", 'e');
                $errors_false = true;
            }
            if (0 < $f_lv) {
                cn_throw_message("Bạn chưa đủ Level để ReLife. Bạn cần phải đạt Level 400 mới có thể ReLife.", 'e');
                $errors_false = true;
            }
            if (0 < $relife_rs) {
                cn_throw_message("$sub cần " . $relife_rs . " Reset để ReLife", 'e');
                $errors_false = true;
            }

            if (!$errors_false) {
                $vp_gc = view_bank($accc_);
                $MapNumber = 0;
                $MapPosX = 143;
                $MapPosY = 134;
                $Mapdir = 0;
                //Summoner
                if ($class_ == $arr_class['class_sum_1'] OR $class_ == $arr_class['class_sum_2'] OR $class_ == $arr_class['class_sum_3']) {
                    $MapNumber = 3;
                    $MapPosX = 51;
                    $MapPosY = 215;
                    $Mapdir = 51;
                }

                $CountRelifeup = $relife_vl + 1;
                $fg_123_pop_val = array_pop($fg_123);

                if ($class_ == $arr_class['class_dl_1'] OR $class_ == $arr_class['class_dl_2']) {
                    $_ml_relifes = $ml_relifes;
                }

                $rl_ml_relifes = isset($_ml_relifes) ? $_ml_relifes : 0;

                if ($rl_ml_relifes > 64000) $rl_ml_relifes = 64000;
                if ($point_relifes > 65000) {
                    $pointup_rl = 65000;
                    $point_relifes -= 65000;
                } else {
                    $pointup_rl = $point_relifes;
                    $point_relifes = 0;
                }

                do_update_character(
                    'character',
                    'Clevel=1',
                    'Experience=0',
                    "LevelUpPoint=$pointup_rl",
                    "pointdutru=$point_relifes",
                    "Relifes=Relifes+1",
                    'Resets=0',
                    'Strength=25',
                    'Dexterity=25',
                    'Vitality=25',
                    'Energy=25',
                    'Life=60',
                    'MaxLife=60',
                    'Mana=60',
                    'MaxMana=60',
                    "MapNumber=$MapNumber",
                    "MapPosX=$MapPosX",
                    "MapPosY=$MapPosY",
                    "MapDir=$Mapdir",
                    'Magiclist=CONVERT(varbinary(180), null)',
                    "Leadership=$rl_ml_relifes",
                    'isThuePoint=0',
                    'ResetVIP=0',
                    'PointThue=0',
                    "Name:'$sub'"
                );

                if ($class_ == $arr_class['class_dw_3'] OR $class_ == $arr_class['class_dk_3'] OR $class_ == $arr_class['class_elf_3']) {
                    do_update_character(
                        'Character',
                        'Quest=0xaaeaffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff',
                        "Name:'$sub'"
                    );
                }

                //Add Xoay kiem cho DK
                if ($class_ == $arr_class['class_dk_1'] OR $class_ == $arr_class['class_dk_2'] OR $class_ == $arr_class['class_dk_3'])
                    do_update_character(
                        'Character',
                        'MagicList=0x2c0000430000440000450000460000470000290000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000',
                        "name:'$sub'"
                    );

                //Add Mui ten vo tan cho Elf C3
                if ($class_ == $arr_class['class_elf_3'])
                    do_update_character(
                        'Character',
                        'MagicList=0x2e00004300004400004500004600004700004d0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000',
                        "name:'$sub'"
                    );

                //Add Skill cho Summoner
                if ($class_ == $arr_class['class_sum_1'] OR $class_ == $arr_class['class_sum_2'] OR $class_ == $arr_class['class_sum_3'])
                    do_update_character(
                        'Character',
                        'MagicList=0xda0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000ff0000',
                        "name:'$sub'"
                    );


                //Reset Point Master Skill
                if (($class_ == $arr_class['class_dw_3']) || ($class_ == $arr_class['class_dk_3']) || ($class_ == $arr_class['class_elf_3']) || ($class_ == $arr_class['class_mg_2']) || ($class_ == $arr_class['class_dl_2']) || ($class_ == $arr_class['class_sum_3']) || ($class_ == $arr_class['class_rf_2'])) {
                    if (getoption('server_type') == "scf")
                        do_update_character('Character', "SCFMasterPoints=$fg_123_pop_val", "Name:'$sub'");
                    else if (getoption('server_type') == "ori")
                        do_update_character('T_MasterLevelSystem', "ML_POINT=$fg_123_pop_val", "CHAR_NAME:'$sub'");
                    else
                        do_update_character('Character', "SCFMasterPoints=$fg_123_pop_val", "Name:'$sub'");
                }

                $before_info_rl[2][1] = $CountRelifeup;
                $before_info_rl[3][1] = "0 <font color =red>(Thiếu " . abs($options_rl[$CountRelifeup]['reset']) . " Reset)</font>";
                $before_info_rl[4][1] = "1 <font color =red>(Thiếu 399 level)</font>";

                //Ghi vào Log
                $content = "$sub Relife lần thứ $CountRelifeup";
                $Date = date("h:iA, d/m/Y", ctime());
                $file = MODULE_ADM . "/log/modules/character/log_relife.txt";
                $fp = fopen($file, "a+");
                fputs($fp, $accc_ . "|" . $content . "|" . $vp_gc[0]['gc'] . "_" . $vp_gc[0]['vp'] . "|" . $vp_gc[0]['gc'] . "_" . $vp_gc[0]['vp'] . "|" . $Date . "|\n");
                fclose($fp);
                //End Ghi vào Log

                cn_throw_message("$sub ReLife lần thứ $CountRelifeup thành công!");
                if ($point_relifes > 0) $str_rutpoint = "Bạn có " . number_format((float)$pointup_rl, 0, ",", ".") . " Point. Vui lòng <a href='#' title='cộng Point'> cộng Point </a> trước khi <b><a href ='#' title='rút Point'> rút Point</a></b> còn lại cho nhân vật $sub.";
                else $str_rutpoint = "Bạn có " . number_format((float)$pointup_rl, 0, ",", ".") . " Point. Vui lòng <a href ='#'> cộng Point </a> cho nhân vật $sub.";
            }
        }
    }

    $show_re_succser = isset($str_rutpoint) ? $str_rutpoint : null;

    cn_assign('before_info_rl', $before_info_rl);
    cn_assign('options_rl, showchar, notify_rs_ok', $options_rl, $showchar, $show_re_succser);
    cn_assign('sub', $sub);

    $arr_shop = mcache_get('.breadcrumbs');
    $name__ = array_pop($arr_shop)['name'];
    echoheader('-@my_char/style.css', "$sub relife - $name__");
    echocomtent_here(exec_tpl('my_char/relife'), cn_snippet_bc_re());
    echofooter();
}

function char_online()
{
    $trust_on = cn_point_trust();

    $member = member_get();
    list($sub) = GET('sub', 'GPG');
    $accc_ = $member['user_name'];
    $showchar = cn_character();
    $_map = cn_get_template_by('map');
    $_blank_var = view_bank($accc_);

    if (!$sub) $sub = array_keys($showchar)[0];
    else {
        if (!in_array($sub, array_keys($showchar)))
            $sub = array_keys($showchar)[0];
    }

    if (getoption('user_delegate') == 0) {
        msg_err('Chức năng không có hoặc không được sử dụng; Xin vui lòng quay trở lại sau.</i>', PHP_SELF);
    }
    $status_online = $trust_on[$sub]['status_on'];
    $status_off = $trust_on[$sub]['status_off'];
    $deleon_time = $trust_on[$sub]['time_begin_on'];
    //$trust_on[$sub]['time_begin_off'];
    $PhutUyThacOn_dutru = $trust_on[$sub]['phut_on_dutru'];
    $UyThacOnline_Daily = $trust_on[$sub]['online_daily'];
    //$trust_on[$sub]['offline_daily'];

    $deleon_point = $trust_on[$sub]['pointuythac'];

    $MapNumber = $showchar[$sub]['MapNumber'];
    $_gcoin = $_blank_var[0]['gc'];
    $uythacon_price = getoption('uythacon_price');

    $check_time = $is_map_on = false;
    if (array_key_exists($MapNumber, $_map)) {
        $local_map = $_map[$MapNumber];
        if ($MapNumber == 0 || $MapNumber == 3) $is_map_on = true;
    } else $local_map = 'Chưa xác định MAP';

    if (check_online($accc_)) {
        $check_on = true;
        $status = "Online";
    } else {
        $check_on = false;
        $status = "<font color =red>Offline</font>";
    }
    //if(check_changecls($accc_, $sub)){ $check_change = true; $status_change = "Đã đổi"; }else{ $check_change = false; $status_change = "<font color =red>Chưa đổi</font>";}

    $ctime = ctime();
    $dbegin = date("Y-M-d", $deleon_time);
    $dend1159 = date("Y-M-d", $ctime);
    $set_time = mktime(0, 0, 0, date("m", $ctime), date("d", $ctime), date("Y", $ctime));
    if ($status_online) {
        $str_status_on = '<img src="' . URL_PATH_IMG . '/checkbullet.gif" title="Online">';
        $dbegin = date("Y-m-d h:ia", $deleon_time);
        $_time = abs(ctime() - strtotime($dbegin));

        if ($_time >= 43200) {
            $Pe = $_point = 720;
            $_point += $PhutUyThacOn_dutru;
            $check_time = true;
        } else {
            $Pe = $_point = floor($_time / 60);
            $_point += $PhutUyThacOn_dutru;
        }
    } else {
        $str_status_on = '<img src="' . URL_PATH_IMG . '/alert_icon.gif" title="Offline">';            // status off
        if ($UyThacOnline_Daily < 720)
            $Pe = 0;
        else {
            $check_time = true;
            $Pe = 720;
        }
    }

    if ($check_time) {
        $_time_limt = "<font color=red> Thời gian ủy thác Online đã tối đa </font>";
    } else {
        $_time_limt = "Còn " . abs(720 - $Pe - $UyThacOnline_Daily) . " Phút ủy thác";
    }

    $str_point_min = isset($_point) ? $_point : 0;

    $before_info_on = array(
        0 => array('Nhân vật', "<a href=" . cn_url_modify('mod=char_manager', 'opt=info_char', 'sub') . " title='Click info $sub'> $sub </a>"),
        2 => array('Điểm ủy thác', number_format($deleon_point, 0, ",", ".") . " phút"),
        7 => array('Phút ủy thác', number_format($str_point_min, 0, ",", ".") . " phút"),
        8 => array('Gcoin', number_format($_gcoin, 0, ",", ".")),
        3 => array('Time limit', $_time_limt),
        //4 => array('Đổi nhân vật',$status_change),
        9 => array('Map', $local_map),
        5 => array('Online', $status),
        6 => array('Tình trạng', $str_status_on),
    );

    if (request_type('POST')) {
        if (REQ('action_deleonline')) {
           cn_dsi_check(true);
            $errors_false = false;

            list($verifyCaptcha) = GET('verifyCaptcha', 'GPG');
            if ($verifyCaptcha != $_SESSION['captcha_web']) {
                cn_throw_message("Captcah không đúng.", 'e');
                $errors_false = true;
            }

            if ($status_online) {// status on
                // kiem tra tien////

                if (!$errors_false) {
                    $gcoin_uythac = $_point * $uythacon_price; // sua
                    if ($_gcoin >= $gcoin_uythac) {
                        $minute_to_point = $_point;
                        $gcoin_after = $_gcoin - $gcoin_uythac;
                    } else {
                        $minute_to_point = $_gcoin;
                        $gcoin_uythac = $_gcoin;
                        $gcoin_after = 0;
                    }
                    //if($check_time){ //"uythaconline_time=$ctime",
                    do_update_character('Character', 'PhutUyThacOn_dutru=0', 'UyThac=0', "PointUyThac=PointUyThac+$minute_to_point", "UyThacOnline_Daily=UyThacOnline_Daily+$Pe", "Name:'$sub'");
                    do_update_character('MEMB_INFO', "gcoin=$gcoin_after", "memb___id:'$accc_'");
                    //}
                    //else{
                    //point in date
                    //}
                    if ($Pe >= 720)
                        $_time_limt_up = "<font color=red> Thời gian ủy thác Online đã tối đa </font>";
                    else
                        $_time_limt_up = "Còn " . abs(720 - $Pe - $UyThacOnline_Daily) . " Phút ủy thác";

                    $before_info_on[6][1] = '<img src="' . URL_PATH_IMG . '/alert_icon.gif" title="Offline">';
                    $before_info_on[2][1] = number_format(($deleon_point + $minute_to_point), 0, ",", ".");
                    $before_info_on[7][1] = "0 phút";
                    $before_info_on[8][1] = number_format($gcoin_after, 0, ",", ".");
                    $before_info_on[3][1] = $_time_limt_up;

                    //Ghi vào Log
                    $content = "$sub kết thúc ủy thác online, nhận được $minute_to_point điểm";
                    $Date = date("h:iA, d/m/Y", ctime());
                    $file = MODULE_ADM . "/log/modules/character/log_uythaconline.txt";
                    $fp = fopen($file, "a+");
                    fputs($fp, $accc_ . "|" . $content . "|" . $_gcoin . "_" .$_blank_var[0]['vp']. "|" . $gcoin_after . "_" .$_blank_var[0]['vp']."|" . $Date . "|\n");
                    fclose($fp);
                    //End Ghi vào Log

                    cn_throw_message("$sub đã kết thúc Ủy thác thành công.");
                    cn_throw_message("Nhận được $minute_to_point Điểm Ủy thác trong $_point phút Ủy thác. Chi phí $gcoin_uythac Gcoin.");
                }
            } else {                            // status OFF
                if (!$check_on) {
                    cn_throw_message("Nhân vật đã thoát Game. Hãy đăng nhập vào Game trước khi thực hiện chức năng này.", 'e');
                    $errors_false = true;
                }
                //if(!$check_change) {
                //cn_throw_message( "Nhân vật $sub không được là nhân vật thoát ra sau cùng. Hãy vào Game và chọn nhân vật khác trước khi thực hiện chức năng này.", 'e');
                //$errors_false = true;
                //}
                if ($check_time) {
                    $errors_false = true;
                    cn_throw_message("Nhân vật đã hết thời gian ủy thác.", 'e');
                }
                if ($status_off) {
                    cn_throw_message("Nhân vật đang sử dụng Ủy thác Offline.", 'e');
                    $errors_false = true;
                }
                if (!$is_map_on) {
                    cn_throw_message("Nhân vật $sub không trong khu vực Lorencia hoặc Noria.", 'e');
                    $errors_false = true;
                }
                // kiem tra map

                if (!$errors_false) {
                    do_update_character('Character', 'uythacoffline_stat=0', 'UyThac=1', "uythaconline_time=$ctime", "Name:'$sub'");

                    //Ghi vào Log
                    $Date = date("h:iA, d/m/Y", ctime());
                    $content = "$sub bắt đầu Ủy thác online lúc $Date";
                    $file = MODULE_ADM . "/log/modules/character/log_uythaconline.txt";
                    $fp = fopen($file, "a+");
                    fputs($fp, $accc_ . "|" . $content . "|" . $_gcoin . "_" .$_blank_var[0]['vp']."|" . $_gcoin . "_" .$_blank_var[0]['vp']."|" . $Date . "|\n");
                    fclose($fp);
                    //End Ghi vào Log

                    $before_info_on[6][1] = '<img src="' . URL_PATH_IMG . '/checkbullet.gif" title="Online">';

                    cn_throw_message("$sub ủy thác Online thành công!");
                }
            }
        }
    }

    $showchar_ = isset($showchar) ? $showchar : array();
    cn_assign('before_info_on', $before_info_on);
    cn_assign('showchar', $showchar_);
    cn_assign('sub', $sub);

    $arr_shop = mcache_get('.breadcrumbs');
    $name__ = array_pop($arr_shop)['name'];
    echoheader('-@my_char/style.css', "$sub ủy thác Online - $name__");
    echocomtent_here(exec_tpl('my_char/dele_online'), cn_snippet_bc_re());
    echofooter();
}

function char_offline()
{
    $trust_off = cn_point_trust();
    $member = member_get();
    list($sub) = GET('sub', 'GPG');
    $accc_ = $member['user_name'];
    $_blank_var = view_bank($accc_);
    $showchar = cn_character();

    if (!$sub) $sub = array_keys($showchar)[0];
    else {
        if (!in_array($sub, array_keys($showchar)))
            $sub = array_keys($showchar)[0];
    }
    $status_online = $trust_off[$sub]['status_on'];
    $status_offline = $trust_off[$sub]['status_off'];
    $deleoff_time = $trust_off[$sub]['time_begin_off'];
    $deleoff_point = $trust_off[$sub]['pointuythac'];
    $UyThacOffline_Daily = $trust_off[$sub]['offline_daily'];
    $PhutUyThac_dutru = $trust_off[$sub]['phut_off_dutru'];
    $_gcoin = $_blank_var[0]['gc'];
    $uythacoff_price = getoption('uythacoff_price');

    if (getoption('user_delegate') == 1) {
        msg_err('Chức năng không có hoặc không được sử dụng; Xin vui lòng quay trở lại sau.</i>', PHP_SELF);
    }

    if (check_online($accc_)) {
        $check_on = true;
        $status = "<font color =red>Online</font>";
    } else {
        $check_on = false;
        $status = "Offline";
    }
    if (check_changecls($accc_, $sub)) {
        $check_change = true;
        $status_change = "Đã đổi";
    } else {
        $check_change = false;
        $status_change = "<font color =red>Chưa đổi</font>";
    }

    $check_time = false;
    $ctime = ctime();

    if ($status_offline) {
        $str_status_on = '<img src="' . URL_PATH_IMG . '/checkbullet.gif" title="Online">';            // status on
        $dbegin = date("Y-m-d h:ia", $deleoff_time);
        $_time = abs(ctime() - strtotime($dbegin));

        if ($_time >= 43200) {
            $Pe = $_point = 720;
            $_point += $PhutUyThac_dutru;
            $check_time = true;
        } else {
            $Pe = $_point = floor($_time / 60);
            $_point += $PhutUyThac_dutru;
        }
    } else {
        $str_status_on = '<img src="' . URL_PATH_IMG . '/alert_icon.gif" title="Offline">';            // status off
        if ($UyThacOffline_Daily < 720) {
            $Pe = 0;
        } else {
            $check_time = true;
            $Pe = 0;
        }
    }

    if ($check_time) {
        $_time_limt = "<font color=red> Thời gian ủy thác Offline đã tối đa </font>";
    } else {
        $_time_limt = "Còn " . abs(720 - $Pe - $UyThacOffline_Daily) . " Phút ủy thác";
    }

    $str_point = isset($_point) ? $_point : 0;

    $before_info_off = array(
        0 => array('Nhân vật', "<a href=" . cn_url_modify('mod=char_manager', 'opt=info_char', 'sub') . " title='Click info $sub'> $sub </a>"),
        2 => array('Điểm ủy thác', number_format($deleoff_point, 0, ",", ".")),
        7 => array('Phút ủy thác', number_format($str_point, 0, ",", ".") . " phút"),
        8 => array('Gcoin', number_format($_gcoin, 0, ",", ".")),
        3 => array('Time limit', $_time_limt),
        4 => array('Đổi nhân vật', $status_change),
        5 => array('Online', $status),
        6 => array('Tình trạng', $str_status_on),
    );

    if (request_type('POST')) {
        if (REQ('action_deleoffline')) {
           cn_dsi_check(true);
            $errors_false = false;

            list($verifyCaptcha) = GET('verifyCaptcha', 'GPG');
            if ($verifyCaptcha != $_SESSION['captcha_web']) {
                cn_throw_message("Captcah không đúng.", 'e');
                $errors_false = true;
            }
            if ($status_offline) {
                //????????????

                if (!$errors_false) {
                    $gcoin_uythac = $_point * $uythacoff_price;
                    if ($_gcoin >= $gcoin_uythac) {
                        $minute_to_point = $_point;
                        $gcoin_after = $_gcoin - $gcoin_uythac;
                    } else {
                        $minute_to_point = $_gcoin;
                        $gcoin_uythac = $_gcoin;
                        $gcoin_after = 0;
                    }

                    //if($check_time){
                    do_update_character('Character', 'PhutUyThacOff_dutru=0', 'uythacoffline_stat=0', "PointUyThac=PointUyThac+$minute_to_point", 'CtlCode=0', "UyThacOffline_Daily=UyThacOffline_Daily+$Pe", "Name:'$sub'");
                    do_update_character('MEMB_INFO', "gcoin=$gcoin_after", "memb___id:'$accc_'");
                    //}
                    //else{
                    //point in date
                    //}
                    if ($Pe >= 720)
                        $_time_limt_up = "<font color=red> Thời gian ủy thác Offline đã tối đa </font>";
                    else
                        $_time_limt_up = "Còn " . abs(720 - $Pe - $UyThacOffline_Daily) . " Phút ủy thác";

                    $before_info_off[6][1] = '<img src="' . URL_PATH_IMG . '/alert_icon.gif" title="Offline">';
                    $before_info_off[2][1] = number_format(($deleoff_point + $minute_to_point), 0, ",", ".");
                    $before_info_off[7][1] = "0 phút";
                    $before_info_off[8][1] = number_format($gcoin_after, 0, ",", ".");
                    $before_info_off[3][1] = $_time_limt_up;

                    //Ghi vào Log
                    $content = "$sub kết thúc ủy thác offline, nhận được $minute_to_point điểm";
                    $Date = date("h:iA, d/m/Y", ctime());
                    $file = MODULE_ADM . "/log/modules/character/log_uythacoffline.txt";
                    $fp = fopen($file, "a+");
                    fputs($fp, $accc_ . "|" . $content . "|" . $_gcoin . "_" .$_blank_var[0]['vp']. "|" . $gcoin_after . "_" .$_blank_var[0]['vp']. "|" . $Date . "|\n");
                    fclose($fp);
                    //End Ghi vào Log

                    cn_throw_message("$sub đã kết thúc Ủy thác thành công.");
                    cn_throw_message("Nhận được $minute_to_point Điểm Ủy thác trong $_point phút Ủy thác. Chi phí $gcoin_uythac gcoin.");
                }
            } else {                            // status OFF
                if ($check_on) {
                    cn_throw_message("Nhân vật chưa thoát Game. Hãy thoát Game trước khi thực hiện chức năng này.", 'e');
                    $errors_false = true;
                }
                if (!$check_change) {
                    cn_throw_message("Nhân vật $sub không được là nhân vật thoát ra sau cùng. Hãy vào Game và chọn nhân vật khác trước khi thực hiện chức năng này.", 'e');
                    $errors_false = true;
                }
                if ($check_time) {
                    $errors_false = true;
                    cn_throw_message("Nhân vật đã hết thời gian ủy thác.", 'e');
                }
                if ($_gcoin < $uythacoff_price) {
                    cn_throw_message('Gcoin hiện có nhỏ hơn chi phí cần thiết để Ủy thác 1 phút', 'e');
                    $errors_false = true;
                }
                if ($status_online) {
                    cn_throw_message("Nhân vật đang sử dụng Ủy thác Online.", 'e');
                    $errors_false = true;
                }

                if (!$errors_false) {

                    do_update_character('Character', 'UyThac=0', 'uythacoffline_stat=1', "uythacoffline_time=$ctime", 'CtlCode=1', "Name:'$sub'");

                    //Ghi vào Log
                    $Date = date("h:iA, d/m/Y", ctime());
                    $content = "$sub bắt đầu Ủy thác offline lúc $Date";
                    $file = MODULE_ADM . "/log/modules/character/log_uythacoffline.txt";
                    $fp = fopen($file, "a+");
                    fputs($fp, $accc_ . "|" . $content . "|" . $_gcoin . "_" .$_blank_var[0]['vp']. "|" . $_gcoin . "_" .$_blank_var[0]['vp']. "|" . $Date . "|\n");
                    fclose($fp);
                    //End Ghi vào Log

                    $before_info_off[6][1] = '<img src="' . URL_PATH_IMG . '/checkbullet.gif" title="Online">';

                    cn_throw_message("$sub ủy thác Offline thành công!");
                }
            }
        }
    }

    $showchar_ = isset($showchar) ? $showchar : array();

    cn_assign('showchar, before_info_off', $showchar_, $before_info_off);
    cn_assign('sub', $sub);

    $arr_shop = mcache_get('.breadcrumbs');
    $name__ = array_pop($arr_shop)['name'];
    echoheader('-@my_char/style.css', "$sub ủy thác Offline - $name__");
    echocomtent_here(exec_tpl('my_char/dele_offline'), cn_snippet_bc_re());
    echofooter();
}

function char_rsdelegate()
{
    $member = member_get();
    list($sub) = GET('sub', 'GPG');
    $accc_ = $member['user_name'];
    $arr_trust = cn_point_trust();
    $showchar = cn_character();
    $_blank_var = view_bank($accc_);
    $options_uythacrs = cn_template_uythacrs();
    $options_rl = cn_template_relife();

    if (!$sub) $sub = array_keys($showchar)[0];
    else {
        if (!in_array($sub, array_keys($showchar)))
            $sub = array_keys($showchar)[0];
    }

    $zen_acc_char = $showchar[$sub]['money'];

    //$rs_top_50 = $showchar[$sub]['top_50'];

    $Resets_Time = $showchar[$sub]['Resets_Time'];
    $point_uythac = $arr_trust[$sub]['pointuythac'];
    $reset_rs = $showchar[$sub]['reset'];
    $relife_vl = $showchar[$sub]['relife'];
    $level = $showchar[$sub]['level'];
    $set_vp = $_blank_var[0]['vp'];
    $show_blank_chao = $_blank_var[0]['chaos'];
    $show_blank_cre = $_blank_var[0]['cre'];
    $show_blank_blue = $_blank_var[0]['blue'];
    if (date('d', ctime()) != date('d', $showchar[$sub]['Resets_Time'])) {
        $rs_inday = 0;
        $showchar[$sub]['resetInDay'] = 0;
    }
    //--------------------------------------------------
    if (isset($options_uythacrs)) {
        $ok_loop = false;
        $rsuythac_index = 0;
        $i_e = 0;
        foreach ($options_uythacrs as $aq => $qa) {
            $i_f = $ok_loop ? $i_e : 0;
            $i_e = $qa['reset'];
            $ok_loop = true;

            if (($reset_rs > $i_f) && ($reset_rs <= $i_e) || ($reset_rs == 0)) {
                $point = $qa['point'];
                $zen = $qa['zen'];
                $chao = $qa['chaos'];
                $cre = $qa['cre'];
                $blue = $qa['blue'];

                //$resetpoint += $qa['id_7_val']*($reset_rs - ($i_f -1));
                //$leadership += $qa['id_8_val']*($reset_rs - ($i_f -1));
                //$resetpoint += $qa['point']*($reset_rs - $i_f);
                //$leadership += $qa['command']*($reset_rs - $i_f);
                //echo "525 >>>".$qa['point'].">>>>>>".$qa['command'].">>>>$leadership>>$reset_rs>>> $i_f> i_e = $i_e>> $resetpoint <br>";
                $rsuythac_index = $aq;
                break;
            }

            //$resetpoint += ($i_e - $i_f)*$p_e;
            //$leadership += ($i_e - $i_f)*$ml_e;
            //echo "592 >> $i_f >>$i_e>>$leadership>>$reset_rs>>> $i_f>>> $resetpoint <br>";
        }
        $point = isset($point) ? $point : $options_uythacrs[count($options_uythacrs) - 1]['point'];
        $zen = isset($zen) ? $zen : $options_uythacrs[count($options_uythacrs) - 1]['zen'];
        $cre = isset($cre) ? $cre : $options_uythacrs[count($options_uythacrs) - 1]['cre'];
        $chao = isset($chao) ? $chao : $options_uythacrs[count($options_uythacrs) - 1]['chaos'];
        $blue = isset($blue) ? $blue : $options_uythacrs[count($options_uythacrs) - 1]['blue'];
    }

    if (isset($options_rl)) {
        foreach ($options_rl as $aq => $qa) {
            if ($relife_vl == $aq) {
                $reset_relifes = $qa['reset'];
                //$point_relifes = $qa['point'];
                //$ml_relifes = $qa['command'];
                break;
            }
        }

        $reset_relifes = isset($reset_relifes) ? $reset_relifes : $options_rl[count($options_rl) - 1]['reset'];
        //$point_relifes = isset($point_relifes) ? $point_relifes : $options_rl[count($options_rl)-1]['point'];
        //$ml_relifes = isset($ml_relifes) ? $ml_relifes : $options_rl[count($options_rl)-1]['command'];
    }

    //$get_zen = $zen_acc_char - (isset($zen) ? $zen: 0);
    //$get_chao = $show_blank_chao - (isset($chao) ? $chao: 0);
    //$get_cre = $show_blank_cre - (isset($cre) ? $cre: 0);
    //$get_blue = $show_blank_blue - (isset($blue) ? $blue: 0);
    //$get_point_uythac = $point_uythac - (isset($point) ? $point: 0);

    if (0 <= $get_point_uythac = $point_uythac - (isset($point) ? $point : 0)) $str_point_uythac = number_format((float)$point_uythac, 0, ",", ".") . " (Đủ Point)"; else {
        $str_point_uythac = number_format((float)($point_uythac), 0, ",", ".") . " <font color =red> (Thiếu " . number_format((float)(abs($get_point_uythac)), 0, ",", ".") . " Point)</font>";
    }
    if (0 <= $get_zen = $zen_acc_char - (isset($zen) ? $zen : 0)) $str_zen = number_format((float)$zen_acc_char, 0, ",", ".") . " (Đủ Zen)"; else {
        $str_zen = number_format((float)$zen_acc_char, 0, ",", ".") . " <font color =red> (Thiếu " . number_format((float)(ABS($get_zen)), 0, ",", ".") . " Zen)</font>";
    }
    if (0 <= $get_chao = $show_blank_chao - (isset($chao) ? $chao : 0)) $str_chao = number_format((float)$show_blank_chao, 0, ",", ".") . " (Đủ Chaos)"; else {
        $str_chao = number_format((float)$show_blank_chao, 0, ",", ".") . " <font color =red> (Thiếu " . number_format((float)(ABS($get_chao)), 0, ",", ".") . " Chaos)</font>";
    }
    if (0 <= $get_cre = $show_blank_cre - (isset($cre) ? $cre : 0)) $str_cre = number_format((float)$show_blank_cre, 0, ",", ".") . " (Đủ Creation)"; else {
        $str_cre = number_format((float)$show_blank_cre, 0, ",", ".") . " <font color =red> (Thiếu " . number_format((float)(ABS($get_cre)), 0, ",", ".") . " Cre)</font>";
    }
    if (0 <= $get_blue = $show_blank_blue - (isset($blue) ? $blue : 0)) $str_blue = number_format((float)$show_blank_blue, 0, ",", ".") . " (Đủ Blue)"; else {
        $str_blue = number_format((float)$show_blank_blue, 0, ",", ".") . " <font color =red> (Thiếu " . number_format((float)(ABS($get_blue)), 0, ",", ".") . " Blue)</font>";
    }

    if (check_online($accc_)) {
        $check_on = true;
        $status = "<font color =red>Online</font>";
    } else {
        $check_on = false;
        $status = "Offline";
    }
    if (check_changecls($accc_, $sub)) {
        $check_change = true;
        $status_change = "Đã đổi";
    } else {
        $check_change = false;
        $status_change = "<font color =red>Chưa đổi</font>";
    }
    $before_info_trust = array(
        0 => array('Nhân vật', "<a href=" . cn_url_modify('mod=char_manager', 'opt=info_char', 'sub') . " title='Click info $sub' >$sub </a>"),
        1 => array('Reset', $reset_rs),
        2 => array('Cấp độ', $level),
        13 => array('Điểm ủy thác', $str_point_uythac),
        3 => array('Zen', $str_zen),
        4 => array('Chaos', $str_chao),
        5 => array('Creation', $str_cre),
        6 => array('Blue Feather', $str_blue),
        7 => array('Vpoint', isset($str_vp) ? $str_vp : null),
        11 => array('Đổi nhân vật', $status_change),
        12 => array('Online', $status),
    );

    if (request_type('POST')) {
        if (REQ('action_rsuythac')) {
           cn_dsi_check(true);
            
            $resetup = $reset_rs + 1;
            $time_reset_next_ = $Resets_Time + 120;
            $ctime = ctime();
            $errors_false = false;
            /*if ($pk_y_n[0] > 0) { //???
				cn_throw_message( "Bạn đang là Sát thủ. Phải rửa tội trước khi Reset.", 'e');
				$errors_false = true;
			}*/

            list($verifyCaptcha) = GET('verifyCaptcha', 'GPG');
            if ($verifyCaptcha != $_SESSION['captcha_web']) {
                cn_throw_message("Captcah không đúng.", 'e');
                $errors_false = true;
            }

            if ($check_on) {
                cn_throw_message("Nhân vật chưa thoát Game. Hãy thoát Game trước khi thực hiện chức năng này.", 'e');
                $errors_false = true;
            }
            if (!$check_change) {
                cn_throw_message("Nhân vật $sub không được là nhân vật thoát ra sau cùng. Hãy vào Game và chọn nhân vật khác trước khi thực hiện chức năng này.", 'e');
                $errors_false = true;
            }

            if ($reset_rs >= $reset_relifes) {
                cn_throw_message("$sub đang ReLife: $relife_vl - Reset: $reset_rs. Để Reset tiếp bạn cần phải ReLife.", 'e');
                $errors_false = true;
            }
            if (($get_blue < 0) OR ($get_cre < 0) OR ($get_chao < 0)) {
                cn_throw_message("Bạn không đủ Jewel trong ngân hàng.", 'e');
                $errors_false = true;
            }
            if ($get_point_uythac < 0) {
                cn_throw_message("$sub cần " . abs($get_point_uythac) . " Điểm ủy thác để Reset ủy thác lần $resetup.", 'e');
                $errors_false = true;
            }
            if ($get_zen < 0) {
                cn_throw_message("$sub cần " . number_format((float)$zen, 0, ",", ".") . " Zen để Reset lần $resetup.", 'e');
                $errors_false = true;
            }
            if ($time_reset_next_ > $ctime) {
                $time_free = $time_reset_next_ - $ctime;
                cn_throw_message("$sub cần $time_free giây nữa để Reset ủy thác lần tiếp theo.", 'e');
                $errors_false = true;
            }
            if (!$errors_false) {

                do_update_character(
                    'Character',
                    "Money=$get_zen",
                    "Resets=$resetup",
                    'NoResetInMonth=NoResetInMonth+1',
                    "Resets_Time=$ctime",
                    "PointUyThac=$get_point_uythac",
                    "name:'$sub'"
                );
                do_update_character(
                    'MEMB_INFO',
                    "jewel_chao=$get_chao",
                    "jewel_cre=$get_cre",
                    "jewel_blue=$get_blue",
                    "memb___id:'$accc_'"
                );

                //Ghi vào Log
                $content = "$sub Reset ủy thác lần thứ $resetup";
                $Date = date("h:iA, d/m/Y", $ctime);
                $file = MODULE_ADM . "/log/modules/character/log_rsuythac.txt";
                $fp = fopen($file, "a+");
                fputs($fp, $accc_ . "|" . $content . "|" . $_blank_var[0]['gc'] . "_" . $set_vp . "|" . $_blank_var[0]['gc'] . "_" . $set_vp . "|" . $Date . "|\n");
                fclose($fp);
                //End Ghi vào Log


                if ($rsuythac_index >= count($options_uythacrs) - 1) $rsuythac_index = count($options_uythacrs) - 1;
                else if ($rsuythac_index > $i_e) ++$rsuythac_index;

                $point = $options_uythacrs[$rsuythac_index]['point'];
                $zen = $options_uythacrs[$rsuythac_index]['zen'];
                $chao = $options_uythacrs[$rsuythac_index]['chaos'];
                $cre = $options_uythacrs[$rsuythac_index]['cre'];
                $blue = $options_uythacrs[$rsuythac_index]['blue'];

                if (0 <= $get_point_uythacup = $get_point_uythac - $point) $str_point_uythac = number_format((float)$get_point_uythac, 0, ",", ".") . " (Đủ Point)"; else {
                    $str_point_uythac = number_format((float)$get_point_uythac, 0, ",", ".") . " <font color =red> (Thiếu " . number_format((float)(ABS($get_point_uythacup)), 0, ",", ".") . " Point)</font>";
                }
                if (0 <= $get_zenup = $get_zen - $zen) $str_zen = number_format((float)$get_zen, 0, ",", ".") . " (Đủ Zen)"; else {
                    $str_zen = number_format((float)$get_zen, 0, ",", ".") . " <font color =red> (Thiếu " . number_format((float)(ABS($get_zenup)), 0, ",", ".") . " Zen)</font>";
                }
                if (0 <= $get_chaoup = $get_chao - $chao) $str_chao = number_format((float)$get_chao, 0, ",", ".") . " (Đủ Chaos)"; else {
                    $str_chao = number_format((float)$get_chao, 0, ",", ".") . " <font color =red> (Thiếu " . number_format((float)(abs($get_chaoup)), 0, ",", ".") . " Chaos)</font>";
                }
                if (0 <= $get_creup = $get_cre - $cre) $str_cre = number_format((float)$get_cre, 0, ",", ".") . " (Đủ Creation)"; else {
                    $str_cre = number_format((float)$get_cre, 0, ",", ".") . " <font color =red> (Thiếu " . number_format((float)(ABS($get_creup)), 0, ",", ".") . " Create)</font>";
                }
                if (0 <= $get_blueup = $get_blue - $blue) $str_blue = number_format((float)$get_blue, 0, ",", ".") . " (Đủ Blue)"; else {
                    $str_blue = number_format((float)$get_blue, 0, ",", ".") . " <font color =red> (Thiếu " . number_format((float)(ABS($get_blueup)), 0, ",", ".") . " Blue)</font>";
                }

                ++$before_info_trust[1][1];
                $before_info_trust[1][13] = $str_point_uythac;
                $before_info_trust[1][3] = $str_zen;
                $before_info_trust[1][4] = $str_chao;
                $before_info_trust[1][5] = $str_cre;
                $before_info_trust[1][6] = $str_blue;
                ++$showchar[$sub]['reset'];

                cn_throw_message("$sub Reset ủy thác lần thứ $resetup thành công!");
            }
        }
    }
    //--------------------------------------------------

    cn_assign('showchar, before_info_trust,options_rs_trust', $showchar, $before_info_trust, $options_uythacrs);
    cn_assign('sub', $sub);

    $arr_shop = mcache_get('.breadcrumbs');
    $name__ = array_pop($arr_shop)['name'];
    echoheader('-@my_char/style.css', "$sub Reset ủy thác - $name__");
    echocomtent_here(exec_tpl('my_char/trust_reset'), cn_snippet_bc_re());
    echofooter();
}

function char_rsdelegatevip()
{
    $member = member_get();
    list($sub) = GET('sub', 'GPG');
    $accc_ = $member['user_name'];
    $arr_trust = cn_point_trust();
    $_blank_var = view_bank($accc_);
    $showchar = cn_character();

    if (!$sub) $sub = array_keys($showchar)[0];
    else {
        if (!in_array($sub, array_keys($showchar)))
            $sub = array_keys($showchar)[0];
    }
    $options_rsvip_trust = cn_template_uythacrsvip();
    $options_rl = cn_template_relife();
    $arr_class = cn_template_class();

    $point_uythac = $arr_trust[$sub]['pointuythac'];
    $Resets_Time = $showchar[$sub]['Resets_Time'];
    $level = $showchar[$sub]['level'];
    $reset_rsvip = $showchar[$sub]['reset'];
    $relife_vl = $showchar[$sub]['relife'];
    $ctime = ctime();
    $_blank_vpoint = $_blank_var[0]['vp'];
    $_blank_gcoin = $_blank_var[0]['gc'];

    if (date('d', ctime()) != date('d', $showchar[$sub]['Resets_Time'])) {
        $rs_inday = 0;
        $showchar[$sub]['resetInDay'] = 0;
    }
    if (isset($options_rsvip_trust)) {
        $ok_loop = false;
        $rsvipuythac_index = $i_e = 0;

        foreach ($options_rsvip_trust as $aq => $qa) {
                $i_f = $ok_loop ? $i_e : 0;
                $i_e = $qa['reset'];
                $ok_loop = true;

            if (($reset_rsvip > $i_f) && ($reset_rsvip <= $i_e) || ($reset_rsvip == 0)) {
                $_point_trust = $qa['point'];
                $_vpoint_trust = $qa['vpoint'];
                $_gcoin_trust = $qa['gcoin'];

                $rsvipuythac_index = $aq;
                //$resetpoint_vip += $qa['id_5_val']*($reset_rsvip - $i_f);
                //$leadership_vip += $qa['id_6_val']*($reset_rsvip - $i_f);
                break;
            }
            //$resetpoint_vip += ($i_e - $i_f)*$p_e;
            //$leadership_vip += ($i_e - $i_f)*$ml_e;
            //++$_index_rs;
        }
        $_point_trust = isset($_point_trust) ? $_point_trust : $options_rsvip_trust[count($options_rsvip_trust) - 1]['point'];
        $_vpoint_trust = isset($_vpoint_trust) ? $_vpoint_trust : $options_rsvip_trust[count($options_rsvip_trust) - 1]['vpoint'];
        $_gcoin_trust = isset($_gcoin_trust) ? $_gcoin_trust : $options_rsvip_trust[count($options_rsvip_trust) - 1]['gcoin'];
    }

    if (isset($options_rl)) {
        foreach ($options_rl as $aq => $qa) {
            if ($relife_vl == $aq) {
                $_relifes_trust = $qa['reset'];
                break;
            }
        }
        $_relifes_trust = isset($_relifes_trust) ? $_relifes_trust : $options_rl[count($options_rl) - 1]['reset'];
    }

    $result_rsvip_trust = false;
    if ($_blank_gcoin >= $_gcoin_trust) {
        $get_blank_g = $_blank_gcoin - $_gcoin_trust;
        $sms_gc = "(Đủ Gcoin)";
    } else if ($_blank_vpoint >= $_vpoint_trust) {
        $get_blank_vp = $_blank_vpoint - $_vpoint_trust;
        $sms_vp = "(Đủ Vpoint)";
    } else {
        $result_rsvip_trust = true;
        $sms_vp = "<font color=red>(Thiếu ". abs($_vpoint_trust) ." Vpoint)</font>";
    }

    $get_point_uythac = $point_uythac - (isset($_point_trust) ? $_point_trust : 0);
    if ($get_point_uythac >= 0) $str_point_uythac = number_format((float)$point_uythac, 0, ",", ".") . " (Đủ Point)"; else {
        $str_point_uythac = number_format((float)$point_uythac, 0, ",", ".") . " <font color =red> (Thiếu " . number_format((float)(abs($get_point_uythac)), 0, ",", ".") . " Point)</font>";
    }

    if (check_online($accc_)) {
        $check_on = true;
        $status = "<font color =red>Online</font>";
    } else {
        $check_on = false;
        $status = "Offline";
    }
    if (check_changecls($accc_, $sub)) {
        $check_change = true;
        $status_change = "Đã đổi";
    } else {
        $check_change = false;
        $status_change = "<font color =red>Chưa đổi</font>";
    }
    $before_info_trustvip = array(
        0 => array('Nhân vật Reset', "<a href=" . cn_url_modify('mod=char_manager', 'opt=info_char', 'sub') . " title='Click info $sub'> $sub </a>"),
        1 => array('Reset', $reset_rsvip),
        2 => array('Cấp độ', $level),
        9 => array('Điểm ủy thác', $str_point_uythac),
        8 => array('Gcoin', number_format((float)$_blank_gcoin, 0, ",", ".") . " " . (isset($sms_gc) ? $sms_gc : '')),
        7 => array('Vpoint', number_format((float)$_blank_vpoint, 0, ",", ".") . " " . (isset($sms_vp) ? $sms_vp : '')),
        //13 => array('Config trsut Reset Vip', $result_rs_blank),
        11 => array('Đổi nhân vật', $status_change),
        12 => array('Online', $status),
    );

    if (request_type('POST')) {
        if (REQ('action_rsvipuythac')) {
           cn_dsi_check(true);
            $resetvipup = $reset_rsvip + 1;
            $time_reset_next_ = $Resets_Time + 120;
            $ctime = ctime();
            $errors_false = false;
            /*if ($pk_y_n[0] > 0) { //???
				cn_throw_message( "Bạn đang là Sát thủ. Phải rửa tội trước khi Reset.", 'e');
				$errors_false = true;
			}*/

            list($verifyCaptcha) = GET('verifyCaptcha', 'GPG');
            if ($verifyCaptcha != $_SESSION['captcha_web']) {
                cn_throw_message("Captcah không đúng.", 'e');
                $errors_false = true;
            }
            if ($check_on) {
                cn_throw_message("Nhân vật chưa thoát Game. Hãy thoát Game trước khi thực hiện chức năng này.", 'e');
                $errors_false = true;
            }
            if (!$check_change) {
                cn_throw_message("Nhân vật $sub không được là nhân vật thoát ra sau cùng. Hãy vào Game và chọn nhân vật khác trước khi thực hiện chức năng này.", 'e');
                $errors_false = true;
            }
            if ($reset_rsvip >= $_relifes_trust) {
                cn_throw_message("$sub đang ReLife: $relife_vl - Reset: $reset_rsvip. Để Reset tiếp bạn cần phải ReLife.", 'e');
                $errors_false = true;
            }
            if ($get_point_uythac < 0) {
                cn_throw_message("$sub cần " . abs($get_point_uythac) . " Điểm ủy thác để Reset ủy thác lần $resetvipup.", 'e');
                $errors_false = true;
            }
            if ($result_rsvip_trust) {
                cn_throw_message("Bạn không đủ Gcoin, Vpoint để ủy thác Reset Vip.", 'e');
                $errors_false = true;
            }
            if ($time_reset_next_ > $ctime) {
                $time_free = $time_reset_next_ - $ctime;
                cn_throw_message("$sub cần $time_free giây nữa để Reset ủy thác lần tiếp theo.", 'e');
                $errors_false = true;
            }

            if (!$errors_false) {
                $gcoin_rsvip = isset($get_blank_g) ? $get_blank_g : $_blank_gcoin;
                $vpointnew = isset($get_blank_vp) ? $get_blank_vp : $_blank_vpoint;

                do_update_character('Character', "Resets=$resetvipup", 'NoResetInMonth=NoResetInMonth+1', "Resets_Time=$ctime", "PointUyThac=$get_point_uythac", "name:'$sub'");
                do_update_character('MEMB_INFO', "gcoin=$gcoin_rsvip", "vpoint=$vpointnew", "memb___id:'$accc_'");

                //Ghi vào Log
                $content = "$sub Reset Vip lần thứ $resetvipup";
                $Date = date("h:iA, d/m/Y", $ctime);
                $file = MODULE_ADM . "/log/modules/character/log_rsuythacvip.txt";
                $fp = fopen($file, "a+");
                fputs($fp, $accc_ . "|" . $content . "|" . $_blank_gcoin . "_" . $_blank_vpoint . "|" . $gcoin_rsvip . "_" . $vpointnew . "|" . $Date . "|\n");
                fclose($fp);
                //End Ghi vào Log

                if ($rsvipuythac_index >= count($options_rsvip_trust) - 1) $rsvipuythac_index = count($options_rsvip_trust) - 1;
                else if ($rsvipuythac_index > $i_e) ++$rsvipuythac_index;

                $_point_trust = $options_rsvip_trust[$rsvipuythac_index]['point'];
                $_vpoint_trust = $options_rsvip_trust[$rsvipuythac_index]['vpoint'];
                $_gcoin_trust = $options_rsvip_trust[$rsvipuythac_index]['gcoin'];

                if (($gcoin_rsvip >= $_gcoin_trust) || ($vpointnew >= $_vpoint_trust))
                    $result_rs_blank = "(Đủ để Reset ủy thác Vip)";
                else
                    $result_rs_blank = "<font color=red>(Thiếu $_vpoint_trust Vpoint)</font>";

                $get_point_uythacup = $get_point_uythac - (isset($_point_trust) ? $_point_trust : 0);
                if ($get_point_uythacup >= 0) $str_point_uythacup = number_format((float)$get_point_uythac, 0, ",", ".") . " (Đủ Point)"; else {
                    $str_point_uythacup = number_format((float)$get_point_uythac, 0, ",", ".") . " <font color =red> (Thiếu " . number_format((float)(abs($get_point_uythacup)), 0, ",", ".") . " Point)</font>";
                }

                $before_info_trustvip[1][1] = $resetvipup;
                $before_info_trustvip[9][1] = $str_point_uythacup;
                $before_info_trustvip[8][1] = number_format((float)$gcoin_rsvip, 0, ",", ".");
                $before_info_trustvip[7][1] = number_format((float)$vpointnew, 0, ",", "." . " " . $$result_rs_blank);
                //$before_info_trustvip[13][1] = $result_rs_blank;
                ++$showchar[$sub]['reset'];

                cn_throw_message("$sub Reset ủy thác vip lần thứ $resetvipup thành công!");
            }
        }
    }

    cn_assign('showchar, before_info_trustvip,options_rsvip_trust', $showchar, $before_info_trustvip, $options_rsvip_trust);
    cn_assign('sub', $sub);

    $arr_shop = mcache_get('.breadcrumbs');
    $name__ = array_pop($arr_shop)['name'];
    echoheader('-@my_char/style.css', "$sub Reset ủy thác vip - $name__");
    echocomtent_here(exec_tpl('my_char/trust_resetvip'), cn_snippet_bc_re());
    echofooter();
}

function char_subpoint()
{
    $member = member_get();
    list($rut_point) = GET('rut_point');
    $rut_point = intval($rut_point);
    list($sub) = GET('sub', 'GPG');
    $showchar = cn_character();

    if (!$sub) $sub = array_keys($showchar)[0];
    else {
        if (!in_array($sub, array_keys($showchar)))
            $sub = array_keys($showchar)[0];
    }

    $point_dutru_false = $point_false65k = $point_false2 = $point_false1 = $point_false = false;
    $point_set = $point = $showchar[$sub]['point'];
    $point_dutru_set = $point_dutru = $showchar[$sub]['point_dutru'];
    $level = $showchar[$sub]['level'];
    $reset_ = $showchar[$sub]['reset'];

    ///		p  > 65k ..... dt > 65k  => 0
    ///		p  > 65k ..... dt < 65k  => 0
    ///		p  < 65k ..... dt > 65k  => 65k - p
    ///		p  < 65k ..... dt < 65k  => ??
    //p + dt >= 65k  ====>   kq[65k - p]
    // [kq] < dt ===> kq
    // [kq] > dt ===> dt
    //p + dt < 65k   ====> dt
    if (65000 <= $point) $use_point_dt = 0;
    //else if(65000 >= $point && $point_dutru >= 65000) $use_point_dt = 65000 - $point;
    //else if(65000 < $point && $point_dutru < 65000){
    //else if(65000 < $point){
    else {
        if (65000 <= $total_val = $point + $point_dutru) {
            if ($point_dutru > $_tempt = 65000 - $point) $use_point_dt = $_tempt;
            else  $use_point_dt = $point_dutru;
        } else $use_point_dt = $point_dutru;
    }

    echo "2410 point =$point use_point_dt =$use_point_dt point_dutru = $point_dutru REQ =====" . REQ('rut_point') . "rut_point = $rut_point <br>";

    if ($rut_point) $point_false1 = true;
    if ($rut_point <= $point_dutru) $point_false = true;
    if (65000 >= $point_set += $rut_point) {
        $point_false2 = true;
        $point_dutru_set -= $rut_point;
    }

    if ($point >= 65000) {
        $_strpoint = number_format((float)$point, 0, ",", ".") . "<a href=" . cn_url_modify('mod=char_manager', 'opt=addpoint', "sub=$sub") . " title='Click add point to $sub'> <font color=red>(Cộng point trước khi rút point dự trự)</font> </a>";
        $point_false65k = true;
    } else $_strpoint = "<a href=" . cn_url_modify('mod=char_manager', 'opt=addpoint', "sub=$sub") . " title='Click add point to $sub'>" . (string)number_format((float)$point, 0, ",", ".") . "</a>";

    if ($point_dutru > 0) $str_point_dutru = number_format((float)$point_dutru, 0, ",", ".");
    else {
        $str_point_dutru = $point_dutru . " <font color=red> (Không đủ point dự trữ để rút) </font>";
        $point_dutru_false = $point_false65k = true;
    }

    if (check_changecls($member['user_name'], $sub)) {
        $check_change = true;
        $status_change = "Đã đổi";
    } else {
        $check_change = false;
        $status_change = "<font color =red>Chưa đổi</font>";
    }
    $before_info_subpoint = array(
        0 => array('Nhân vật', "<a href=" . cn_url_modify('mod=char_manager', 'opt=info_char', 'sub') . " title='Click info $sub'> $sub </a>"),
        1 => array('Reset', $reset_),
        2 => array('Cấp độ', $level),
        9 => array('Point', $_strpoint),
        8 => array('Point dự trữ', $str_point_dutru),
        11 => array('Đổi nhân vật', $status_change),
        //12 => array('Online',$status),
    );

    if (request_type('POST')) {
        if (REQ('action_subpoint')) {
           cn_dsi_check(true);
            $errors_false = false;

            list($verifyCaptcha) = GET('verifyCaptcha', 'GPG');
            if ($verifyCaptcha != $_SESSION['captcha_web']) {
                cn_throw_message("Captcah không đúng.", 'e');
                $errors_false = true;
            }
            if (!$check_change) {
                cn_throw_message("Nhân vật $sub không được là nhân vật thoát ra sau cùng. Hãy vào Game và chọn nhân vật khác trước khi thực hiện chức năng này.", 'e');
                $errors_false = true;
            }
            if (!$point_false) {
                cn_throw_message("Bạn rút số Point lớn hơn số dư Point dư trữ (" . number_format((float)$point_dutru, 0, ",", ".") . ").", 'e');
                $errors_false = true;
            }
            if (!$point_false1) {
                cn_throw_message("Vui lòng rút Point cho nhân vật $sub.", 'e');
                $errors_false = true;
            }
            if (!$point_false2) {
                cn_throw_message("Số Point chưa cộng trên nhân vật $sub lớn hơn 65000.", 'e'); //32000
                $errors_false = true;
            }
            if ($point_dutru_false) {
                cn_throw_message("Nhân vật $sub không có Point dự trữ để rút.", 'e');
                $errors_false = true;
            }


            if (!$errors_false) {

                do_update_character('Character', "LevelUpPoint=$point_set", "pointdutru=$point_dutru_set", "name:'$sub'");

                if ($point_set >= 65000) {
                    $_strpointup = "<a href=" . cn_url_modify('mod=char_manager', 'opt=addpoint', "sub=$sub") . " title='Click add point to $sub'><font color=red>" . number_format((float)$point_set, 0, ",", ".") . " (Cộng point trước khi rút point dự trự) </font> </a>";
                    $point_false65k = true;
                } else $_strpointup = "<a href=" . cn_url_modify('mod=char_manager', 'opt=addpoint', "sub=$sub") . " title='Click add point to $sub'>" . number_format((float)$point_set, 0, ",", ".") . "</a>";

                if ($point_dutru_set > 0) $str_point_dutruup = number_format((float)$point_dutru_set, 0, ",", ".");
                else {
                    $str_point_dutruup = $point_dutru_set . " <font color=red> (Không đủ point dự trữ để rút) </font>";
                    $point_false65k = true;
                }

                $before_info_subpoint[8][1] = $str_point_dutruup;
                $before_info_subpoint[9][1] = $_strpointup;

                $sms_rutpoint = "Bạn có " . number_format((float)$point_set, 0, ",", ".") . " Point. Vui lòng <a href ='" . cn_url_modify('mod=char_manager', 'opt=addpoint', 'sub=' . $sub) . "'> cộng Point </a> cho nhân vật $sub.";
                cn_throw_message("$sub đã rút Point thành công!");
            }
        }
    }

    $sms_rp = isset($sms_rutpoint) ? $sms_rutpoint : '';

    cn_assign('showchar, before_info_subpoint, sd_pointdutru, sms_notify', $showchar, $before_info_subpoint, $use_point_dt, $sms_rp);
    cn_assign('sub,point_false65k', $sub, $point_false65k);

    $arr_shop = mcache_get('.breadcrumbs');
    $name__ = array_pop($arr_shop)['name'];
    echoheader('-@my_char/style.css', "Rút point cho nhân vật $sub - $name__");
    echocomtent_here(exec_tpl('my_char/subpoint]'), cn_snippet_bc_re());
    echofooter();
}

function char_addpoint()
{
    $member = member_get();
    list($point_str, $point_agi, $point_vit, $point_ene, $point_cmd) = GET('addstr, addagi, addvit, addene, addcmd');
    $point_str = intval($point_str);
    $point_agi = intval($point_agi);
    $point_vit = intval($point_vit);
    $point_ene = intval($point_ene);
    $point_cmd = intval($point_cmd);

    list($sub) = GET('sub', 'GPG');
    $showchar = cn_character();
    $arr_class = cn_template_class();

    if (!$sub) $sub = array_keys($showchar)[0];
    else {
        if (!in_array($sub, array_keys($showchar)))
            $sub = array_keys($showchar)[0];
    }

    $point = $total_point = $rootPoint = 0;
    $is_classDl = $point_false1 = $point_false = false;
    $point = $showchar[$sub]['point'];
    $point_dutru = $showchar[$sub]['point_dutru'];
    $_class = $showchar[$sub]['class'];

    $_str_ = $showchar[$sub]['str'];
    $_agi_ = $showchar[$sub]['dex']; //agi
    $_vit_ = $showchar[$sub]['vit'];
    $_ene_ = $showchar[$sub]['ene'];
    $_cmd_ = $showchar[$sub]['com'];

    $rootPoint = $_str_ + $_agi_ + $_vit_ + $_ene_;
    $total_point = $point_str + $point_agi + $point_vit + $point_ene;

    if ($_class == $arr_class['class_dl_1'] OR $_class == $arr_class['class_dl_2']) {
        $is_classDl = true;
        $rootPoint += $_cmd_;
        $str_com = number_format((float)$_cmd_, 0, ",", ".");
        $total_point += $point_cmd;
        if ($_cmd_ < 0) $_cmd_ = 0;
//        $_cmd_ += $point_cmd;
    }

    $totalMaxPoint = $point + $rootPoint;
    $pointMaxNew = $totalMaxPoint - $total_point;

    if ($total_point <= ($rootPoint + $point)) $point_false = true;
    if ($total_point) $point_false1 = true;

    if ($point != 0) $_strpoint_dutru = "<a href=" . cn_url_modify('mod=char_manager', 'opt=subpoint', "sub=$sub") . " title='Rút point $sub'>" . number_format((float)$point_dutru, 0, ",", ".") . "</a>";
    else {
        $_strpoint_dutru = 0;//$point_dutru;//"<a href=". cn_url_modify('mod=char_manager', 'opt=subpoint',"sub=$sub")." title='Rút point $sub'><font color=red>". number_format((float)$point_dutru,0,",",".") . "  ..... ko cong dk </font> </a>";
        //$point_false = true;
    }

    //else if($point_dutru) $_strpoint_dutru = "<a href=". cn_url_modify('mod=char_manager', 'opt=subpoint',"sub=$sub")." title='Rút point $sub'>". number_format((float)$point_dutru,0,",",".") . " <font color=red> ..... ko rut dk </font> </a>";
    //else{}


    if (check_changecls($member['user_name'], $sub)) {
        $check_change = true;
        $status_change = "Đã đổi";
    } else {
        $check_change = false;
        $status_change = "<font color =red>Chưa đổi</font>";
    }
    $before_info_addpoint = array(
        0 => array('Nhân vật ', "<a href=" . cn_url_modify('mod=char_manager', 'opt=info_char', 'sub') . " title='Click info $sub'> $sub </a>"),
        8 => array('Point', number_format((float)$point, 0, ",", ".")),
        9 => array('Point dự trữ', $_strpoint_dutru),
        7 => array('Sức mạnh', number_format((float)$_str_, 0, ",", ".")),
        3 => array('Nhanh nhẹn', number_format((float)$_agi_, 0, ",", ".")),
        4 => array('Sức khỏe', number_format((float)$_vit_, 0, ",", ".")),
        5 => array('Năng lượng', number_format((float)$_ene_, 0, ",", ".")),
        6 => array('Mệnh lệnh', isset($str_com) ? $str_com : null),
        11 => array('Đổi nhân vật', $status_change)
    );

    if (request_type('POST')) {
        if (REQ('action_addpoint')) {
            cn_dsi_check(true);
            $errors_false = false;

            list($verifyCaptcha) = GET('verifyCaptcha', 'GPG');
            if ($verifyCaptcha != $_SESSION['captcha_web']) {
                cn_throw_message("Captcah không đúng.", 'e');
                $errors_false = true;
            }

            if (!$check_change) {
                cn_throw_message("Nhân vật $sub không được là nhân vật thoát ra sau cùng. Hãy vào Game và chọn nhân vật khác trước khi thực hiện chức năng này.", 'e');
                $errors_false = true;
            }
            if (!$point_false) {
                cn_throw_message("Tổng số Point cộng (" . number_format((float)($total_point), 0, ",", ".") . ") lớn hơn số dư Point hiện có (" . number_format((float)($point), 0, ",", ".") . ").", 'e');
                $errors_false = true;
            }
            if (!$point_false1) {
                cn_throw_message("Vui lòng nhập Point cho nhận vậy $sub.", 'e');
                $errors_false = true;
            }

            if (!$errors_false) {

                do_update_character(
                    'Character',
                    "Strength=$point_str",
                    "Dexterity=$point_agi",
                    "LevelUpPoint=$pointMaxNew",
                    "Vitality=$point_vit",
                    "Energy=$point_ene",
                    "Leadership=$point_cmd",
                    "Name:'$sub'"
                );

                $before_info_addpoint[4][1] = number_format((float)$point_vit, 0, ",", ".");
                $before_info_addpoint[5][1] = number_format((float)$point_ene, 0, ",", ".");
                $before_info_addpoint[8][1] = number_format((float)(abs($pointMaxNew)), 0, ",", ".");
                $before_info_addpoint[7][1] = number_format((float)$point_str, 0, ",", ".");
                $before_info_addpoint[3][1] = number_format((float)$point_agi, 0, ",", ".");

                if ($is_classDl) $before_info_addpoint[6][1] = number_format((float)$_cmd_, 0, ",", ".");
                $point = $pointMaxNew;
                $rootPoint = $total_point;
                cn_throw_message("$sub đã cộng điểm thành công!");
            }
        }
    }

    cn_assign('showchar, before_info_addpoint, is_classDl, sd_point, rootPoint', $showchar, $before_info_addpoint, $is_classDl, $point, $rootPoint);
    cn_assign('sub', $sub);

    $arr_shop = mcache_get('.breadcrumbs');
    $name__ = array_pop($arr_shop)['name'];
    echoheader('-@my_char/style.css', "Cộng point cho nhân vật $sub - $name__");
    echocomtent_here(exec_tpl('my_char/addpoint'), cn_snippet_bc_re());
    echofooter();
}

function char_rspoint()
{
    $member = member_get();
    list($sub) = GET('sub', 'GPG');
    //$arr_class = cn_template_class();
    $showchar = cn_character();
    $_blank_var = view_bank($accc_ = $member['user_name']);
    $options_rsvip = cn_template_resetvip();

    if (!$sub) $sub = array_keys($showchar)[0];
    else {
        if (!in_array($sub, array_keys($showchar)))
            $sub = array_keys($showchar)[0];
    }

    $point_false1 = $point_false = false;
    $point = $showchar[$sub]['point'];
    $point_dutru = $showchar[$sub]['point_dutru'];

    $_loop_rs = false;
    $level = $showchar[$sub]['level'];
    $reset_ = $showchar[$sub]['reset'];
    $_class = $showchar[$sub]['class'];
    $_gcoin = $_blank_var[0]['gc'];
    $_vpoint = $_blank_var[0]['vp'];
    $total_point = $_str = $showchar[$sub]['str'];
    $total_point += $_agi = $showchar[$sub]['dex'];
    $total_point += $_vit = $showchar[$sub]['vit'];
    $total_point += $_ene = $showchar[$sub]['ene'];
    $total_point += $_cmd = $showchar[$sub]['com'];
    //$total_point = $_str + $_agi + $_vit + $_ene;
    //------------------------------------------------
    //$addd[0] = array('vpoint'=>45544, 'gcoin'=>67665);
    //$addd[2] = array('gcoin_km'=>49999);
    //do_update_character1('MEMB_INFO', $addd, "memb___id='bqngoc'");
    //------------------------------------------------

    $default_class = do_select_character(
        'DefaultClassType',
        'Class,Strength,Dexterity,Vitality,Energy,Life,MaxLife,Mana,MaxMana,MapNumber,MapPosX,MapPosY,Leadership',
        "Class=$_class Or Class=$_class - 1 Or Class=$_class - 2"
    );
    $d_class = $default_class[0]['Class'];
    $default_total = $d_str = $default_class[0]['Strength'];
    $default_total += $d_agi = $default_class[0]['Dexterity'];
    $default_total += $d_vit = $default_class[0]['Vitality'];
    $default_total += $d_ene = $default_class[0]['Energy'];
    $d_5 = $default_class[0]['Life'];
    $d_6 = $default_class[0]['MaxLife'];
    $d_7 = $default_class[0]['Mana'];
    $d_8 = $default_class[0]['MaxMana'];
    $d_9 = $default_class[0]['MapNumber'];
    $d_10 = $default_class[0]['MapPosX'];
    $d_11 = $default_class[0]['MapPosY'];
    $default_total += $d_cmd = $default_class[0]['Leadership'];

    $i_e = 0;
    foreach ($options_rsvip as $aq => $qa) {
        $i_f = $_loop_rs ? $i_e : 0;
        $i_e = $qa['reset'];
        $_loop_rs = true;

        if (($reset_ > $i_f) && ($reset_ <= $i_e) || ($reset_ == 0)) {
            $_vpoint_test = $qa['vpoint'];
            $_gcoin_test = $qa['gcoin'];
            break;
        }
    }
    //25% Gcoin or Vpoint
    $_vpoint_test = ceil(0.25 * (isset($_vpoint_test) ? $_vpoint_test : $options_rsvip[count($options_rsvip) - 1]['vpoint']));
    $_gcoin_test = ceil(0.25 * (isset($_gcoin_test) ? $_gcoin_test : $options_rsvip[count($options_rsvip) - 1]['gcoin']));

    if ($_gcoin >= $_gcoin_test) {
        $get_gc = $_gcoin - $_gcoin_test;
        $sms_gc = " (Đủ Gcoin)";
    } else if (0 <= $get_vp = $_vpoint - $_vpoint_test) {
        $sms_vp = " (Đủ Vpoint)";
    } else {
        $point_false1 = true;
        $sms_vp = " <font color=red>(Thiếu $get_vp Vpoint)</font>";
    }

    if (0 <= ($_point_var = $default_total - $total_point)) {
        $point_false = true;
        $_sts_dt = " <font color=red>(Bạn chưa cộng điểm)</font>";
    }


    if (check_changecls($member['user_name'], $sub)) {
        $check_change = true;
        $status_change = "Đã đổi";
    } else {
        $check_change = false;
        $status_change = "<font color =red>Chưa đổi</font>";
    }
    $before_info_rspoint = array(
        0 => array('Nhân vật', "<a href=" . cn_url_modify('mod=char_manager', 'opt=info_char', 'sub') . " title='Click info $sub'> $sub </a>"),
        1 => array('Reset', $reset_),
        2 => array('Cấp độ', $level),
        8 => array('Gcoin', number_format((float)$_gcoin, 0, ",", ".") . (isset($sms_gc) ? $sms_gc : '')),
        9 => array('Vpoint', number_format((float)$_vpoint, 0, ",", ".") . (isset($sms_vp) ? $sms_vp : '')),
        7 => array('Point đã cộng', number_format((float)(abs($_point_var)), 0, ",", ".") . (isset($_sts_dt) ? $_sts_dt : '')),
        //4 => array('Point dự trữ', number_format((float)$point_dutru,0,",",".")),
        //5 => array('Năng lượng', number_format((float)$_ene_,0,",",".")),
        //6 => array('Mệnh lệnh', isset($str_com) ? $str_com : null),
        11 => array('Đổi nhân vật', $status_change),
    );


    if (request_type('POST')) {
        if (REQ('action_rspoint')) {
           cn_dsi_check(true);
            $errors_false = false;

            list($verifyCaptcha) = GET('verifyCaptcha', 'GPG');
            if ($verifyCaptcha != $_SESSION['captcha_web']) {
                cn_throw_message("Captcah không đúng.", 'e');
                $errors_false = true;
            }
            if (!$check_change) {
                cn_throw_message("Nhân vật $sub không được là nhân vật thoát ra sau cùng. Hãy vào Game và chọn nhân vật khác trước khi thực hiện chức năng này.", 'e');
                $errors_false = true;
            }
            if ($point_false) {
                cn_throw_message("Bạn chưa cộng điểm cho nhân vật $sub.", 'e');
                $errors_false = true;
            }
            if ($point_false1) {
                cn_throw_message("Bạn không đủ Gcoin hoặc Vpoint để Reset Point.", 'e');
                $errors_false = true;
            }

            if (!$errors_false) {
                if (abs($_point_var) >= 65000) {
                    $lvup_point = 65000;
                    $point_dutru += $_templ = abs($total_point) - 65000;
                } else $lvup_point = abs($_point_var) + $point;
                $gcoin_new = isset($get_gc) ? $get_gc : $_gcoin;
                $vpoint_new = isset($get_vp) ? $get_vp : $_vpoint;

                do_update_character(
                    'Character',
                    "LevelUpPoint=$lvup_point",
                    "pointdutru=$point_dutru",
                    "Strength=$d_str",
                    "Dexterity=$d_agi",
                    "Vitality=$d_vit",
                    "Energy=$d_ene",
                    "Life=$d_5",
                    "MaxLife=$d_6",
                    "Mana=$d_7",
                    "MaxMana=$d_8",
                    "MapNumber=$d_9",
                    "MapPosX=$d_10",
                    "MapPosY=$d_11",
                    'MapDir=0',
                    "Leadership=$d_cmd",
                    "Name:'$sub'"
                );
                do_update_character('MEMB_INFO', "gcoin=$gcoin_new", "vpoint=$vpoint_new", "memb___id:'$accc_'");

                //Ghi vào Log
                $content = "$sub đã tẩy điểm với 25% Gcoin hoặc 25% Vpoint tương ứng với số cấp Reset Vip";
                $Date = date("h:iA, d/m/Y", time());
                $file = MODULE_ADM . "/log/modules/character/log_rspoint.txt";
                $fp = fopen($file, "a+");
                fputs($fp, $accc_ . "|" . $content . "|" . $_blank_var[0]['gc'] . "_" . $_blank_var[0]['vp'] . "|" . $gcoin_new . "_" . $vpoint_new . "|" . $Date . "|\n");
                fclose($fp);
                //End Ghi vào Log


                if ($gcoin_new >= $_gcoin_test) $sms_gc = "(Đủ Gcoin)";
                else if ($vpoint_new >= $_vpoint_test) $sms_vp = "(Đủ Vpoint)";
                else $sms_vp = "<font color=red>(Thiếu $_vpoint_test Vpoint)</font>";

                $before_info_rspoint[9][1] = number_format((float)$vpoint_new, 0, ",", ".") . " " . (isset($sms_vp) ? $sms_vp : '');
                $before_info_rspoint[8][1] = number_format((float)$gcoin_new, 0, ",", ".") . " " . (isset($sms_gc) ? $sms_gc : '');
                $before_info_rspoint[7][1] = 0;

                //if($resetpoint > 0) $str_rutpoint = "Bạn có ".number_format((float)$pointup,0,",",".")." Point. Vui lòng <a href='".cn_url_modify('mod=char_manager', 'opt=addpoint','sub='.$sub) ."' title='cộng Point'> cộng Point </a> trước khi <b><a href ='".cn_url_modify('mod=char_manager', 'opt=subpoint','sub='.$sub) ."' title='rút Point'> rút Point</a></b> còn lại cho nhân vật $sub.";
                $sms_notify = "Bạn có " . number_format((float)$lvup_point, 0, ",", ".") . " Point. Vui lòng <a href ='" . cn_url_modify('mod=char_manager', 'opt=addpoint', 'sub=' . $sub) . "'> cộng Point </a> cho nhân vật $sub.";
                cn_throw_message("$sub đã reset Point thành công!");
            }
        }
    }

    cn_assign('showchar, sub, before_info_rspoint, sms_notify', $showchar, $sub, $before_info_rspoint, (isset($sms_notify) ? $sms_notify : ''));

    $arr_shop = mcache_get('.breadcrumbs');
    $name__ = array_pop($arr_shop)['name'];
    echoheader('-@my_char/style.css', "Reset Point - Cộng lại điểm - $name__");
    echocomtent_here(exec_tpl('my_char/rspoint'), cn_snippet_bc_re());
    echofooter();
}

function char_movemap()
{
    $member = member_get();
    list($sub, $move_map) = GET('sub, move_map', 'GPG');

    $showchar = cn_character();
    $_map = cn_get_template_by('map');

    if (!$sub) $sub = array_keys($showchar)[0];
    else {
        if (!in_array($sub, array_keys($showchar)))
            $sub = array_keys($showchar)[0];
    }

    $no_move = false;

    $level = $showchar[$sub]['level'];
    $reset_ = $showchar[$sub]['reset'];
    $MapNumber = $showchar[$sub]['MapNumber'];

    if (array_key_exists($MapNumber, $_map)) $local_map = $_map[$MapNumber];
    else $local_map = 'Chưa xác định MAP';

    if (check_changecls($member['user_name'], $sub)) {
        $check_change = true;
        $status_change = "Đã đổi";
    } else {
        $check_change = false;
        $status_change = "<font color =red>Chưa đổi</font>";
    }
    $before_info_map = array(
        0 => array('Nhân vật', "<a href=" . cn_url_modify('mod=char_manager', 'opt=info_char', 'sub') . " title='Click info $sub'> $sub </a>"),
        1 => array('Reset', $reset_),
        2 => array('Cấp độ', $level),
        3 => array('Vị trí', $local_map),
        //9 => array('Gcoin', number_format((float)$_gcoin,0,",","."). (isset($sms_gc) ? $sms_gc : '')),
        //9 => array('Vpoint', number_format((float)$_vpoint,0,",","."). (isset($sms_vp) ? $sms_vp : '')),
        //7 => array('Point đã cộng', number_format((float)(abs($_point_var)),0,",",".").(isset($_sts_dt) ? $_sts_dt : '')),
        //4 => array('Point dự trữ', number_format((float)$point_dutru,0,",",".")),
        //5 => array('Năng lượng', number_format((float)$_ene_,0,",",".")),
        //6 => array('Mệnh lệnh', isset($str_com) ? $str_com : null),
        11 => array('Đổi nhân vật', $status_change),
        //12 => array('Online',$status),
    );

    $set_map = array(0 => 'Lorencia', 3 => 'Noria', 51 => 'Elbeland');
    if ($move_map == $MapNumber) $no_move = true;

    if (request_type('POST')) {
        if (REQ('action_movemap')) {
           cn_dsi_check(true);
            $errors_false = false;

            list($verifyCaptcha) = GET('verifyCaptcha', 'GPG');
            if ($verifyCaptcha != $_SESSION['captcha_web']) {
                cn_throw_message("Captcah không đúng.", 'e');
                $errors_false = true;
            }

            if (!$check_change) {
                cn_throw_message("Nhân vật $sub không được là nhân vật thoát ra sau cùng. Hãy vào Game và chọn nhân vật khác trước khi thực hiện chức năng này.", 'e');
                $errors_false = true;
            }
            if ($no_move) {
                cn_throw_message("Nhân vật $sub đang trong khu vực $local_map.", 'e');
                $errors_false = true;
            }

            if (!$errors_false) {

                $_arr_map = array(
                    0 => array('MapPosX' => 143, 'MapPosY' => 134),
                    3 => array('MapPosX' => 175, 'MapPosY' => 115),
                    51 => array('MapPosX' => 53, 'MapPosY' => 226),
                );

                foreach ($_arr_map as $key => $val)
                    if ($key == $move_map) {
                        $_Px = $val['MapPosX'];
                        $_Py = $val['MapPosY'];
                        break;
                    }
                $_Px = isset($_Px) ? $_Px : 143;
                $_Py = isset($_Py) ? $_Py : 134;


                do_update_character('Character', "MapNumber=$move_map", "MapPosX=$_Px", "MapPosY=$_Py", "Name:'$sub'");

                $MapNumber = $move_map;
                $before_info_map[3][1] = $_vt_map = $_map[$MapNumber];

                cn_throw_message("Nhận vật $sub đã chuyển tới khu vực $_vt_map thành công!");
            }
        }
    }

    cn_assign('showchar, sub, before_info_map, set_map, num_map', $showchar, $sub, $before_info_map, $set_map, $MapNumber);

    $arr_shop = mcache_get('.breadcrumbs');
    $name__ = array_pop($arr_shop)['name'];
    echoheader('-@my_char/style.css', "Di chuyển - Đổi Map - $name__");
    echocomtent_here(exec_tpl('my_char/movemap'), cn_snippet_bc_re());
    echofooter();
}

function char_removepk()
{
    $member = member_get();
    list($sub, $move_map) = GET('sub, move_map', 'GPG');
    $showchar = cn_character();
    $_blank_var = view_bank($accc_ = $member['user_name']);

    $_pk = cn_get_template_by('pk');

    if (!$sub) $sub = array_keys($showchar)[0];
    else {
        if (!in_array($sub, array_keys($showchar)))
            $sub = array_keys($showchar)[0];
    }

    $is_pk_money = $is_pk_vp = $is_pk = false;
    $is_vp = true;
    $vpoint_ = $_blank_var[0]['vp'];

    $level = $showchar[$sub]['level'];
    $reset_ = $showchar[$sub]['reset'];
    $money = $showchar[$sub]['money'];
    $PkLevel = $showchar[$sub]['PkLevel']; //???????????????
    $PkCount = $showchar[$sub]['PkCount']; //>>>>>>>>>>>>??/
    $ui = $_pk['pk_zen_vpoint'];

    $option_pk = array(
        0 => array(
            'pkcount' => $_pk['pk_zen_vpoint'],
            'pk' => $_pk['pk_zen']
        ),
        1 => array(
            'pkcount' => $_pk['pk_zen_vpoint'],
            'pk' => $_pk['pk_vpoint']
        )
    );

    if ($PkCount) {
        $is_pk = true;
        if ($PkCount <= $_pk['pk_zen_vpoint']) {
            if (0 <= $kttien = $money - $PkCount * $_pk['pk_zen']) $sms_money = " (Đủ Money)";
            else {
                $sms_money = " <font color=red>(Thiếu " . number_format((float)($kttien = abs($kttien)), 0, ",", ".") . " Money)</font>";
                $is_pk_money = true;
            }
        } else {
            $numVpPK = $PkCount * $_pk['pk_vpoint'];
            if (0 <= $ktvpoint = $vpoint_ - $PkCount * $_pk['pk_vpoint']) {
                $is_vp = false;
                $sms_vp = " (Đủ Vpoint)";
            } else {
                $sms_vp = " <font color=red>(Thiếu " . number_format((float)($ktvpoint = abs($ktvpoint)), 0, ",", ".") . " Vpoint)</font>";
                $is_pk_vp = true;
            }
        }
        $sms_pk = " (Sát thủ)";
    } else {
        $sms_pk = " <font color=red>(Không phải sát thủ)</font>";
    } 

    if (check_changecls($member['user_name'], $sub)) {
        $check_change = true;
        $status_change = "Đã đổi";
    } else {
        $check_change = false;
        $status_change = "<font color =red>Chưa đổi</font>";
    }
    $before_info_pk = array(
        0 => array('Nhân vật', "<a href=" . cn_url_modify('mod=char_manager', 'opt=info_char', 'sub') . " title='Click info $sub'> $sub </a>"),
        1 => array('Reset', $reset_),
        2 => array('Cấp độ', $level),
        3 => array('Money', number_format((float)$money, 0, ",", ".") . (isset($sms_money) ? $sms_money : '')),
        9 => array('Vpoint', number_format((float)$vpoint_, 0, ",", ".") . (isset($sms_vp) ? $sms_vp : '')),
        7 => array('Số lần Pk', number_format((float)($PkCount), 0, ",", ".") . (isset($sms_pk) ? $sms_pk : '')),
        11 => array('Đổi nhân vật', $status_change),
    );

    if (request_type('POST')) {
        if (REQ('action_removepk')) {
            cn_dsi_check(true);
            $errors_false = false;
            list($verifyCaptcha) = GET('verifyCaptcha', 'GPG');
            if ($verifyCaptcha != $_SESSION['captcha_web']) {
                cn_throw_message("Captcah không đúng.", 'e');
                $errors_false = true;
            }

            if (!$check_change) {
                cn_throw_message("Nhân vật $sub không được là nhân vật thoát ra sau cùng. Hãy vào Game và chọn nhân vật khác trước khi thực hiện chức năng này.", 'e');
                $errors_false = true;
            }
            if (!$is_pk) {
                cn_throw_message("Nhân vật $sub không phải sát thủ.", 'e');
                $errors_false = true;
            }
            if ($is_pk_money) {
                cn_throw_message("Nhân vật $sub thiếu tiền Zen (money).", 'e');
                $errors_false = true;
            }
            if ($is_pk_vp) {
                cn_throw_message("Bạn không đủ Vpoint để rửa tội.", 'e');
                $errors_false = true;
            }

            if (!$errors_false) {
                $kttien = isset($kttien) ? $kttien : $money;

                do_update_character('Character', 'PkLevel = 3', 'PkTime = 0', 'pkcount = 0', "Money = $kttien", "AccountID:'$accc_'", "Name:'$sub'");

                if (!$is_vp) {
                    $ktvpoint = isset($ktvpoint) ? $ktvpoint : $vpoint_;
                    //$msquery = "UPDATE Character SET [PkLevel] = '3',[PkTime] = '0',[pkcount] = '0' WHERE AccountID = '$account' AND Name = '$character'";
                    //$msresults= $db->Execute($msquery);

                    do_update_character('MEMB_INFO', "vpoint = $ktvpoint", "memb___id:'$accc_'");
                    //$msresults1= $db->Execute($msquery1);

                    //Ghi vào Log
                    $content = "$sub đã rửa tội giết $PkCount mạng với" . @$numVpPK . " V.Point";
                    $Date = date("h:iA, d/m/Y", ctime());
                    $file = MODULE_ADM . "/log/modules/character/log_ruatoi.txt";
                    $fp = fopen($file, "a+");
                    fputs($fp, $accc_ . "|" . $content . "|" . $_blank_var[0]['gc'] . "_" . $vpoint_ . "|" . $_blank_var[0]['gc'] . "_" . $ktvpoint . "|" . $Date . "|\n");
                    fclose($fp);
                    //End Ghi vào Log
                    $before_info_pk[9][1] = number_format((float)($ktvpoint), 0, ",", ".");
                }

                $before_info_pk[7][1] = "0 <font color=red>(Không phải sát thủ)</font>";
                $before_info_pk[3][1] = number_format((float)($kttien), 0, ",", ".");
            }
        }
    }
    cn_assign('showchar, sub, before_info_pk, option_pk', $showchar, $sub, $before_info_pk, $option_pk);

    $arr_shop = mcache_get('.breadcrumbs');
    $name__ = array_pop($arr_shop)['name'];
    echoheader('-@my_char/style.css', "Rửa tội - Xóa PK - $name__");
    echocomtent_here(exec_tpl('my_char/removepk'), cn_snippet_bc_re());
    echofooter();
}

function char_pointtax()
{
    $member = member_get();
    list($sub, $_point_tax) = GET('sub, point_tax', 'GPG');
    //list($_point_tax) = GET('point_tax','GETPOST');
    $_blank_var = view_bank($accc_ = $member['user_name']);

    $showchar = cn_character();

    if (!$sub) $sub = array_keys($showchar)[0];
    else {
        if (!in_array($sub, array_keys($showchar)))
            $sub = array_keys($showchar)[0];
    }
    // Xu ly NV thue Point
    point_tax($sub);

    $is_vp = $is_tax = true;
    $vpoint_ = $_blank_var[0]['vp'];

    $level = $showchar[$sub]['level'];
    $reset_ = $showchar[$sub]['reset'];
    $IsThuePoint = $showchar[$sub]['IsThuePoint'];
    $time_tax = $showchar[$sub]['TimeThuePoint']; //???????????????
    //$PkCount = $showchar[$sub]['PkCount']; //>>>>>>>>>>>>??/
    //$ui = $_pk['pk_zen_vpoint'];

    $opt_pointtax = array(
        '10k' => 10000,
        '20k' => 20000,
        '30k' => 30000,
        '40k' => 40000,
        '50k' => 50000,
    );

    if (!$IsThuePoint) {
        if (array_key_exists($_point_tax, $opt_pointtax)) $var_vp = $opt_pointtax[$_point_tax];
        else $var_vp = $opt_pointtax[$_point_tax = '50k'];

        if (0 <= $ktvpoint = $vpoint_ - $var_vp) $sms_vp = " (Đủ Vpoint)";
        else {
            $is_vp = false;
            $sms_vp = " <font color=red>(Thiếu " . number_format((float)($ktvpoint = abs($ktvpoint)), 0, ",", ".") . " Vpoint)</font>";
        }
        $sms_tax = " (Không thuê)";
    } else {
        $is_tax = false;
        $sms_tax = " (Thuê còn " . date("H:i:s", ($time_tax - ctime())) . ")";
    }

    if (check_changecls($member['user_name'], $sub)) {
        $check_change = true;
        $status_change = "Đã đổi";
    } else {
        $check_change = false;
        $status_change = "<font color =red>Chưa đổi</font>";
    }
    $before_info_pointtax = array(
        0 => array('Nhân vật', "<a href=" . cn_url_modify('mod=char_manager', 'opt=info_char', 'sub') . " title='Click info $sub'> $sub </a>"),
        1 => array('Reset', $reset_),
        2 => array('Cấp độ', $level),
        9 => array('Vpoint', number_format((float)$vpoint_, 0, ",", ".") . (isset($sms_vp) ? $sms_vp : '')),
        6 => array('Tình trạng', $sms_tax),
        11 => array('Đổi nhân vật', $status_change)
    );

    if (request_type('POST')) {
        if (REQ('action_pointtax')) {
            cn_dsi_check(true);
            $errors_false = false;

            list($verifyCaptcha) = GET('verifyCaptcha', 'GPG');
            if ($verifyCaptcha != $_SESSION['captcha_web']) {
                cn_throw_message("Captcah không đúng.", 'e');
                $errors_false = true;
            }

            if (!$check_change) {
                cn_throw_message("Nhân vật $sub không được là nhân vật thoát ra sau cùng. Hãy vào Game và chọn nhân vật khác trước khi thực hiện chức năng này.", 'e');
                $errors_false = true;
            }
            if (!$is_tax) {
                cn_throw_message("Nhân vật $sub đã thuê điểm.", 'e');
                $errors_false = true;
            }
            if (!$is_vp) {
                cn_throw_message("Bạn không đủ Vpoint để thuê.", 'e');
                $errors_false = true;
            }

            if (!$errors_false) {
                $ktvpoint = isset($ktvpoint) ? $ktvpoint : $vpoint_;
                $ctime = ctime();
                do_update_character(
                    'Character',
                    'IsThuePoint=1',
                    "TimeThuePoint=$ctime",
                    "PointThue=$var_vp",
                    "Name:'$sub'"
                );
                do_update_character(
                    'MEMB_INFO',
                    "vpoint = $ktvpoint",
                    "memb___id:'$accc_'"
                );

                //Ghi vào Log
                $content = "$sub đã thuê $var_vp point với $var_vp V.Point";
                $Date = date("h:iA, d/m/Y", $ctime);
                $file = MODULE_ADM . "/log/modules/character/log_thuepoint.txt";
                $fp = fopen($file, "a+");
                fputs($fp, $accc_ . "|" . $content . "|". $_blank_var[0]['gc'] .'_'. $vpoint_ . "|". $_blank_var[0]['gc'] . '_' . $ktvpoint . "|" . $Date . "|\n");
                fclose($fp);
                //End Ghi vào Log

                $before_info_pointtax[6][1] = "(Thuê còn " . date("H:i:s", $ctime) . ")";
                cn_throw_message("Nhân vật $sub đã thuê điểm thành công.");
            }
        }
    }

    cn_assign('showchar, sub, before_info_pointtax, opt_pointtax, is_tax', $showchar, $sub, $before_info_pointtax, $opt_pointtax, $_point_tax);

    $arr_shop = mcache_get('.breadcrumbs');
    $name__ = array_pop($arr_shop)['name'];
    echoheader('-@my_char/style.css', "Thuê điểm - $name__");
    echocomtent_here(exec_tpl('my_char/pointtax'), cn_snippet_bc_re());
    echofooter();

}

function char_changename()
{
    $member = member_get();
    list($sub, $c_name) = GET('sub, c_name', 'GPG');
    $c_name = strtolower($c_name);
    // kiem chu va so ......????
    $_blank_var = view_bank($accc_ = $member['user_name']);

    $showchar = cn_character();
    $_array_name = do_select_character('Character', 'Name');

    if (!$sub) $sub = array_keys($showchar)[0];
    else {
        if (!in_array($sub, array_keys($showchar)))
            $sub = array_keys($showchar)[0];
    }


    $cn_false = $is_namenew = $is_cname = $is_cn = false;
    $gcoin_ = $_blank_var[0]['gc'];
    $vpoint_ = $_blank_var[0]['vp'];

    $level = $showchar[$sub]['level'];
    $reset_ = $showchar[$sub]['reset'];
    
    if (!$c_name) $is_cn = true;
    if (preg_match('/\W+/', $c_name)) {
        $is_cname = true; 
    }

    foreach ($_array_name as $key => $var) {
        if ($var[0] == $c_name) {
            $is_namenew = true;
            break;
        }
    }

    if ($gcoin_ >= $_gcoin_test = round(0.01 * getoption('vptogc') * ($_vpoint_test = getoption('changename_vpoint')))) {
        $get_gc = $gcoin_ - $_gcoin_test;
        $sms_gc = " (Đủ Gcoin)";
    } else if (0 <= $get_vp = $vpoint_ - $_vpoint_test) {
        $sms_vp = " (Đủ Vpoint)";
    } else {
        $cn_false = true;
        $sms_vp = " <font color=red>(Thiếu " . number_format((float)(abs($get_vp)), 0, ",", ".") . " Vpoint)</font>";
    }

    if (check_changecls($member['user_name'], $sub)) {
        $check_change = true;
        $status_change = "Đã đổi";
    } else {
        $check_change = false;
        $status_change = "<font color =red>Chưa đổi</font>";
    }
    $before_info_cn = array(
        0 => array('Nhân vật', "<a href=" . cn_url_modify('mod=char_manager', 'opt=info_char', 'sub') . " title='Click info $sub'> $sub </a>"),
        1 => array('Reset', $reset_),
        2 => array('Cấp độ', $level),
        3 => array('Gcoin', number_format((float)$gcoin_, 0, ",", ".") . (isset($sms_gc) ? $sms_gc : '')),
        9 => array('Vpoint', number_format((float)$vpoint_, 0, ",", ".") . (isset($sms_vp) ? $sms_vp : '')),
        11 => array('Đổi nhân vật', $status_change)
    );

    if (request_type('POST')) {
        if (REQ('action_cname')) {
            cn_dsi_check(true);
            $errors_false = false;

            list($verifyCaptcha) = GET('verifyCaptcha', 'GPG');
            if ($verifyCaptcha != $_SESSION['captcha_web']) {
                cn_throw_message("Captcah không đúng.", 'e');
                $errors_false = true;
            }

            if (!$check_change) {
                cn_throw_message("Nhân vật $sub không được là nhân vật thoát ra sau cùng. Hãy vào Game và chọn nhân vật khác trước khi thực hiện chức năng này.", 'e');
                $errors_false = true;
            }
            if ($is_cn) {
                cn_throw_message("Vui lòng nhập tên mới.", 'e');
                $errors_false = true;
            }
            if ($is_cname) {
                cn_throw_message("Tên nhân vật mới có chứa kí tự không cho phép.", 'e');
                $errors_false = true;
            }
            if ($is_namenew) {
                cn_throw_message("Tên nhân vật đã tồn tại.", 'e');
                $errors_false = true;
            }
            if ($cn_false) {
                cn_throw_message("Bạn không đủ Vpoint để đổi tên.", 'e');
                $errors_false = true;
            }

            if (!$errors_false) {
                $ktgcoin = isset($get_gc) ? $get_gc : $gcoin_;
                $ktvpoint = isset($get_vp) ? $get_vp : $vpoint_;

                if ($ktvpoint == $vpoint_) $var_vp = @$_gcoin_test . " Gcoin";
                else $var_vp = @$_vpoint_test . " Vpoint";

                do_update_character('Character', "Name='$c_name'", "Name:'$sub'");
                do_update_character('AccountCharacter', "GameID1='$c_name'", "GameID1:'$sub'");
                do_update_character('AccountCharacter', "GameID2='$c_name'", "GameID2:'$sub'");
                do_update_character('AccountCharacter', "GameID3='$c_name'", "GameID3:'$sub'");
                do_update_character('AccountCharacter', "GameID4='$c_name'", "GameID4:'$sub'");
                do_update_character('AccountCharacter', "GameID5='$c_name'", "GameID5:'$sub'");
                do_update_character('AccountCharacter', "GameIDC='$c_name'", "GameIDC:'$sub'");
                do_update_character('Guild', "G_Master='$c_name'", "G_Master:'$sub'");
                do_update_character('GuildMember', "Name='$c_name'", "Name:'$sub'");
                do_update_character('T_WaitFriend', "FriendName='$c_name'", "FriendName:'$sub'");
                do_update_character('T_FriendMail', "FriendName='$c_name'", "FriendName:'$sub'");
                do_update_character('T_FriendMain', "Name='$c_name'", "Name:'$sub'");
                do_update_character('T_CGuid', "Name='$c_name'", "Name:'$sub'");
                do_update_character('OptionData', "Name='$c_name'", "Name:'$sub'");

                do_update_character('MEMB_INFO', "vpoint = $ktvpoint", "gcoin = $ktgcoin", "memb___id:'$accc_'");

                //Ghi vào Log
                $content = "$sub đã đổi $sub sang $c_name với $var_vp";
                $Date = date("h:iA, d/m/Y", ctime());
                $file = MODULE_ADM . "/log/modules/character/log_changename.txt";
                $fp = fopen($file, "a+");
                fputs($fp, $accc_ . "|" . $content . "|" . $gcoin_ . '_' . $vpoint_ . "|" . $var_vp . "|" . $Date . "|\n");
                fclose($fp);
                //End Ghi vào Log

                $before_info_cn[3][1] = number_format((float)$ktgcoin, 0, ",", ".");
                $before_info_cn[9][1] = number_format((float)$ktvpoint, 0, ",", ".");
                $before_info_cn[0][1] = "<a href=" . cn_url_modify('mod=char_manager', 'opt=info_char', 'sub') . " title='Click info $c_name'> $c_name </a>";

                $showchar[$c_name] = $showchar[$sub];
                unset($showchar[$sub]);
                cn_throw_message("Nhân vật $sub đã đổi thành $c_name thành công.");
            }
        }
    }
    cn_assign('showchar, sub, before_info_cn, cn_false', $showchar, $sub, $before_info_cn, $cn_false);
    $arr_shop = mcache_get('.breadcrumbs');
    $name__ = array_pop($arr_shop)['name'];
    echoheader('-@my_char/style.css', "Đổi tên nhân vật - $name__");
    echocomtent_here(exec_tpl('my_char/cname'), cn_snippet_bc_re());
    echofooter();
}

/**
 *Change class
 */
function char_changeclass()
{
    $changeClass = explode(':', getoption('changeClass_str'));
    $showchar = cn_character();
    $infoClass = cn_template_class();

    $member = member_get();
    list($sub, $nameClass) = GET('sub, nameClass', 'GPG');
    $nameClass = strtolower($nameClass);

    // kiem chu va so ......????
    $_blank_var = view_bank($accc_ = $member['user_name']);

    if (!$sub) $sub = array_keys($showchar)[0];
    else {
        if (!in_array($sub, array_keys($showchar)))
            $sub = array_keys($showchar)[0];
    }

    $cn_false = $is_cname = false;
    $gcoin_ = $_blank_var[0]['gc'];
    $vpoint_ = $_blank_var[0]['vp'];

    $level = $showchar[$sub]['level'];
    $reset_ = $showchar[$sub]['reset'];
    $isClass = $showchar[$sub]['isClass'];
    $class_ = $showchar[$sub]['class'];

    $tempClass = ['dw', 'dk', 'elf', 'mg', 'dl', 'sum', 'rf'];
    $temp = [];
    foreach ($infoClass as $key => $val) {
        $strA = explode('_', $key);
        if (in_array($strA[1], $tempClass)) {
            if(!isset($temp[$strA[1]]) && $strA[1] != $isClass) {
                $temp[$strA[1]] = [$strA[1].'_code' => $infoClass[$key], $strA[1].'_name' => $infoClass[$key.'_name']];
            }
        }
    }

    if($reset_ >= $changeClass[2]){
        $sms_reset_ = $reset_ . '(Đủ Reset)';
        $is_cname = true;
    } else {
        $sms_reset_ = $reset_ . ' <font color=red>(Thiếu ' .abs($changeClass[2]- $reset_). ' Reset) </font>';
    }

    list ($get_gc, $sms_gc, $get_vp, $sms_vp, $cn_false) = checkGcoinVpoint($gcoin_, $vpoint_, $changeClass[0]);

    if (check_changecls($member['user_name'], $sub)) {
        $check_change = true;
        $status_change = "Đã đổi";
    } else {
        $check_change = false;
        $status_change = "<font color =red>Chưa đổi</font>";
    }
    $before_info_cn = array(
        0 => array('Nhân vật', "<a href=" . cn_url_modify('mod=char_manager', 'opt=info_char', 'sub') . " title='Click info $sub'> $sub </a>"),
        1 => array('Reset', $sms_reset_),
        2 => array('Cấp độ', $level),
        3 => array('Gcoin', number_format((float)$get_gc, 0, ",", ".") . (isset($sms_gc) ? $sms_gc : '')),
        9 => array('Vpoint', number_format((float)$get_vp, 0, ",", ".") . (isset($sms_vp) ? $sms_vp : '')),
        11 => array('Đổi nhân vật', $status_change)
    );

    if (request_type('POST')) {
        if (REQ('action_className')) {
           cn_dsi_check(true);
            $errors_false = false;

            list($verifyCaptcha) = GET('verifyCaptcha', 'GPG');
            if ($verifyCaptcha != $_SESSION['captcha_web']) {
                cn_throw_message("Captcah không đúng.", 'e');
                $errors_false = true;
            }
            if(!isset($infoClass['class_'.$nameClass.'_1'])) {
                cn_throw_message("Lỗi hệ thống khi thay đổi giới tính, vui lòng liên hệ với admin", 'e');
            }

            if (!$check_change) {
                cn_throw_message("Nhân vật $sub không được là nhân vật thoát ra sau cùng. Hãy vào Game và chọn nhân vật khác trước khi thực hiện chức năng này.", 'e');
                $errors_false = true;
            }
            if (!$is_cname) {
                cn_throw_message("Yêu cầu tối thiểu " . $changeClass[2]. " reset", 'e');
                $errors_false = true;
            }

            if ($cn_false) {
                cn_throw_message("Bạn không đủ Vpoint để đổi tên.", 'e');
                $errors_false = true;
            }

            if (!$errors_false) {
//                $ktgcoin = isset($get_gc) ? $get_gc : $gcoin_;
//                $ktvpoint = isset($get_vp) ? $get_vp : $vpoint_;

                $ktvpoint = $get_vp;
                $ktgcoin = $get_gc;
                $newReset = $reset_ - ceil(0.01*$changeClass[1]*$reset_);
                if ($ktvpoint == $vpoint_) $var_vp = ($_blank_var[0]['gc']- $get_gc) . " Gcoin";
                else $var_vp = ($_blank_var[0]['vp']- $get_vp) . " Vpoint";

                $_codeClass = $infoClass['class_'.$nameClass.'_1'];

                $default_class = do_select_character('DefaultClassType', $arr_cls = 'Strength,Dexterity,Vitality,Energy,Life,MaxLife,Mana,MaxMana,MapNumber,MapPosX,MapPosY,Leadership', "Class='$class_' Or Class='$class_'-1 Or Class='$class_'-2 Or Class='$class_'-3");
                $get_default_class = '';
                $_arr_cls = spsep($arr_cls);
                foreach ($_arr_cls as $key => $val)
                    $get_default_class .= "$val=" . $default_class[0][$key] . ",";

                $get_default_class = substr($get_default_class, 0, -1);

                $inventory_nothing ='';
                for($i = 0; $i < 3456; $i++){
                    $inventory_nothing .= 'F';
                }
                $quest_nothing = substr($inventory_nothing, 0, 100);

                do_update_character('Character', 'Clevel=400', "Resets=$newReset", 'Experience=0', "Class=$_codeClass", "LevelUpPoint=0", "pointdutru=0", "$get_default_class", "MapDir=0", "MagicList=CONVERT(varbinary(180), null)", "Quest=0x$quest_nothing", "Inventory=0x$inventory_nothing", "name:'$sub'");

                //Reset Point Master Skill
                if ( ($class_ == $infoClass['class_dw_3']) || ($class_ == $infoClass['class_dk_3']) || ($class_ == $infoClass['class_elf_3']) || ($class_ == $infoClass['class_mg_2']) || ($class_ == $infoClass['class_dl_2']) || ($class_ == $infoClass['class_sum_3']) || ($class_ == $infoClass['class_rf_2']) ) {
                    if (getoption('server_type') == "scf")
                        do_update_character('Character', 'SCFMasterLevel=0', 'SCFMasterPoints=0', "SCFMasterSkills=CONVERT(varbinary(300), null)", "Name:'$sub'");
                    else if (getoption('server_type') == "ori")
                        do_update_character('T_MasterLevelSystem', 'MASTER_LEVEL=0', 'ML_POINT=0', "SCFMasterSkills=CONVERT(varbinary(300), null)", "Name:'$sub'");
                    else
                        do_update_character('Character', 'SCFMasterLevel=0', 'SCFMasterPoints=0', "SCFMasterSkills=CONVERT(varbinary(300), null)", "Name:'$sub'");
                }

                do_update_character('MEMB_INFO', "vpoint = $ktvpoint", "gcoin = $ktgcoin", "memb___id:'$accc_'");

                //Ghi vào Log
                $content = "Nhân vật $sub đã đổi ". strtoupper($isClass) ." sang " .  strtoupper($nameClass) ." với $var_vp";
                $Date = date("h:iA, d/m/Y", ctime());
                $file = MODULE_ADM . "/log/modules/character/log_changeclass.txt";
                $fp = fopen($file, "a+");
                fputs($fp, $accc_ . "|" . $content . "|" . $gcoin_ . '_' . $vpoint_ . "|" . $get_gc . "_" . $get_vp . "|" . $Date . "|\n");
                fclose($fp);
                //End Ghi vào Log

                $before_info_cn[1][1] = number_format((float)$newReset, 0, ",", ".");
                $before_info_cn[3][1] = number_format((float)$ktgcoin, 0, ",", ".");
                $before_info_cn[9][1] = number_format((float)$ktvpoint, 0, ",", ".");

                unset($temp[$nameClass]);
                $temp[$isClass] = [$isClass.'_code' => $infoClass['class_'.$isClass.'_1'], $isClass.'_name' => $infoClass['class_'.$isClass.'_1_name']];

                cn_throw_message("Nhân vật $sub đã đổi ". strtoupper($isClass) ." sang " .  strtoupper($nameClass) ." thành công.");
            }
        }
    }
    cn_assign('showchar, sub, before_info_cn, infoClass', $showchar, $sub, $before_info_cn, $temp);

    $arr_shop = mcache_get('.breadcrumbs');
    $name__ = array_pop($arr_shop)['name'];
    echoheader('-@my_char/style.css', "Đổi giới tính nhân vật");
    echocomtent_here(exec_tpl('my_char/changeclass'), cn_snippet_bc_re());
    echofooter();
}

function char_level1(){
die('11111');
    // nv nao...
    // l2-l3 -> ?
    // phi //?
}

function char_level2(){}

function char_level3(){}

function char_delepersonalSotre()
{
    list($sub) = GET('sub', 'GPG');

    $sub = htmlentities($sub);
    $showchar = cn_character();

    if (!$sub) {
        $sub = array_keys($showchar)[0];
    } else {
        if (!in_array($sub, array_keys($showchar))) $sub = array_keys($showchar)[0];
    }

    $inventory = $showchar[$sub]['shop_inventory'];
    // All - 12 - 64 (8*8) - 32 (4*8) [last]
    //Session > 6.
    $ceilInventoryShopPresonal = 1024; // 32*32
    $inventoryRaw = strtoupper(bin2hex($inventory));
    //$inventoryDele = substr($inventoryRaw, 76 * 32, 32 * 32);
    $inventoryDele = substr($inventoryRaw, (-1)*$ceilInventoryShopPresonal);

    $check_change = false;
    if (check_changecls($_SESSION['user_Gamer'], $sub)) {
        $check_change = true;
    }

    $checkExistItem =  mcache_get("#existItem");

    $isCheckAction = false;
    if (request_type('POST')) {
        if (REQ('action_personalSotre')) {
            if (empty($checkExistItem)) {
                cn_throw_message("Cửa hàng cá nhân không có vật phẩm nào.", 'e');
            } else {
                cn_dsi_check(true);
                $errors_false = false;
                
                list($verifyCaptcha) = GET('verifyCaptcha', 'GPG');
                if ($verifyCaptcha != $_SESSION['captcha_web']) {
                    cn_throw_message("Captcah không đúng.", 'e');
                    $errors_false = true;
                }
                if (!$check_change) {
                    cn_throw_message("Đổi nhân vật " . $sub . "  trước khi thực hiện thac tác này.", 'e');
                    $errors_false = true;
                }


                if (!$errors_false) {
                    $changeInventory = '';
                    for ($id = 0; $id < $ceilInventoryShopPresonal; $id++) $changeInventory .= 'F';

                    $newInventory = substr($inventoryRaw, 0, (-1) * $ceilInventoryShopPresonal) . $changeInventory;
                    $checkUpdate = do_update_character('Character', "Inventory=0x" . $newInventory, "Name:'" . $sub . "'");
                    if ($checkUpdate) {
                        cn_throw_message('Đã xóa thành công cửa hàng cá nhân.');
                        $isCheckAction = true;
                        #Remove exist tItem
                        mcache_set('#existItem', 0);
                    } else {
                        cn_throw_message('Err, Lỗi xử lý xóa cửa hàng cá nhân.', 'e');
                    }
                }
            }
        }
    }

    if (!$isCheckAction) {
        $lenghtInventoryDel = strlen($inventoryDele);
        $itemInfo = array();
        for ($jk = 0; $jk < $lenghtInventoryDel; $jk += 32) {
            $strItem = substr($inventoryDele, $jk, 32);
            $itemInfo[] = cn_analysis_code32($strItem, '', '', '');
        }
    }

    $x = -1;
    $show_warehouse = "<div id='warehouse' style='width:282px; margin:0px auto; padding-top:57px; padding-left:25px; height:343px; background-image: url(/images/inventory.jpg)'>";

    if ($itemInfo && !$isCheckAction) {
        foreach ($itemInfo as $i => $item32) {
            //Set item exist
            mcache_set('#existItem', 1);

            ++$x;
            if ($x == 8) $x = 0;
            if (isset($item32['name'])) {
                if (!$item32['y']) $itemy = 1;
                else $itemy = $item32['y'];

                if (!$item32['x']) $itemx = 1;
                else $itemx = $item32['x'];

                $show_warehouse .= "<div style='margin-top:" . ((floor($i / 8) * 32) + 82) . "px; margin-left:" . ($x * 32) . "px; position:absolute; width:" . ($itemx * 32) . "px; height:" . ($itemy * 32) . "px; cursor:pointer; background-image: url(images/wh_bg_on.jpg);'>
									<img src='images/items/" . $item32['image'] . ".gif' style=\"height:" . (31 * $itemy - $itemy - 1) . "px; width:" . (31 * $itemx) . "px;\"></div>";
            }
        }
    }
    $wwname = "<font color='#ffffff'>Cửa hàng cá nhân</font>";
    $show_warehouse .= "<div style='margin-top:-42px; position:absolute; text-align:center; width:256px; border:0px;'>" . $wwname . "</div>";
    $show_warehouse .= "</div>";

    cn_assign('sub, show_warehouse, showchar, check_change', $sub, $show_warehouse, $showchar, $check_change);

    echoheader('-@my_char/style.css', "Xóa cửa hàng cá nhân - Personal Store");
    echocomtent_here(exec_tpl('my_char/personalSotre'), cn_snippet_bc_re());
    echofooter();
}


//function char_()
//{
//    $infoClas = cn_template_class();
//
//    $member = member_get();
//    list($sub, $c_name) = GET('sub, c_name', 'GPG');
//    $c_name = strtolower($c_name);
//    // kiem chu va so ......????
//    $_blank_var = view_bank($accc_ = $member['user_name']);
//
//    $showchar = cn_character();
//    $_array_name = do_select_character('Character', 'Name');
//
//    if (!$sub) $sub = array_keys($showchar)[0];
//    else {
//        if (!in_array($sub, array_keys($showchar)))
//            $sub = array_keys($showchar)[0];
//    }
//
//
//    $cn_false = $is_namenew = $is_cname = $is_cn = false;
//    $gcoin_ = $_blank_var[0]['gc'];
//    $vpoint_ = $_blank_var[0]['vp'];
//
//    $level = $showchar[$sub]['level'];
//    $reset_ = $showchar[$sub]['reset'];
//
//    array_push($infoClas, ['selected' => $showchar[$sub]['class']]);
//
//
//    //$rule = '/\W+/';
//    if (!$c_name) $is_cn = true;
//    if (preg_match('/\W+/', $c_name)) {
//        $is_cname = true; // ton tai cac ki tu ko cho phep.
//        echo "3169 thong bao ton tai ki tu ko cho phep <br>";
//    }
//
//    foreach ($_array_name as $key => $var) {
//        if ($var[0] == $c_name) {
//            $is_namenew = true;
//            break; // co ton tai
//        }
//    }
//
//    if ($gcoin_ >= $_gcoin_test = round(0.01 * getoption('vptogc') * ($_vpoint_test = getoption('changename_vpoint')))) {
//        $get_gc = $gcoin_ - $_gcoin_test;
//        $sms_gc = " (Đủ Gcoin)";
//    } else if (0 <= $get_vp = $vpoint_ - $_vpoint_test) {
//        $sms_vp = " (Đủ Vpoint)";
//    } else {
//        $cn_false = true;
//        $sms_vp = " <font color=red>(Thiếu " . number_format((float)(abs($get_vp)), 0, ",", ".") . " Vpoint)</font>";
//    }
//
//    /*
//	if(!$IsThuePoint){
//	if(array_key_exists($_point_tax, $opt_pointtax)) $var_vp = $opt_pointtax[$_point_tax];
//	else $var_vp = $opt_pointtax[$_point_tax = '50k'];
//
//	if(0 <= $ktvpoint = $vpoint_ - $var_vp) $sms_vp = " (Đủ Vpoint)";
//	else {
//		$is_vp = false;
//		$sms_vp = " <font color=red>(Thiếu ". number_format((float)($ktvpoint = abs($ktvpoint)),0,",",".") ." Vpoint)</font>";
//	}
//	$sms_tax = " (Không thuê)";
//	}
//	else {
//	$is_tax = false;
//	$sms_tax = " (Thuê còn ". date("H:i:s", ($time_tax - ctime())) .")";
//	}
//*/
//    if (check_changecls($member['user_name'], $sub)) {
//        $check_change = true;
//        $status_change = "Đã đổi";
//    } else {
//        $check_change = false;
//        $status_change = "<font color =red>Chưa đổi</font>";
//    }
//    $before_info_cn = array(
//        0 => array('Nhân vật', "<a href=" . cn_url_modify('mod=char_manager', 'opt=info_char', 'sub') . " title='Click info $sub'> $sub </a>"),
//        1 => array('Reset', $reset_),
//        2 => array('Cấp độ', $level),
//        //3 => array('Money', $local_map),
//        3 => array('Gcoin', number_format((float)$gcoin_, 0, ",", ".") . (isset($sms_gc) ? $sms_gc : '')),
//        9 => array('Vpoint', number_format((float)$vpoint_, 0, ",", ".") . (isset($sms_vp) ? $sms_vp : '')),
//        //7 => array('Số lần Pk', number_format((float)($PkCount),0,",",".") . (isset($sms_pk) ? $sms_pk : '')),
//        //4 => array('Point dự trữ', number_format((float)$point_dutru,0,",",".")),
//        //5 => array('Năng lượng', number_format((float)$_ene_,0,",",".")),
//        //6 => array('Tình trạng', $sms_tax),
//        11 => array('Đổi nhân vật', $status_change),
//        //12 => array('Online',$status),
//    );
//
//    if (request_type('POST')) {
//        if (REQ('action_cname')) {
//            //cn_dsi_check(true);
//
//            $errors_false = false;
//
//            if (!$check_change) {
//                cn_throw_message("Nhân vật $sub không được là nhân vật thoát ra sau cùng. Hãy vào Game và chọn nhân vật khác trước khi thực hiện chức năng này.", 'e');
//                $errors_false = true;
//            }
//            if ($is_cn) {
//                cn_throw_message("Vui lòng nhập tên mới.", 'e');
//                $errors_false = true;
//            }
//            if ($is_cname) {
//                cn_throw_message("Tên nhân vật mới có chứa kí tự không cho phép.", 'e');
//                $errors_false = true;
//            }
//            if ($is_namenew) {
//                cn_throw_message("Tên nhân vật đã tồn tại.", 'e');
//                $errors_false = true;
//            }
//            if ($cn_false) {
//                cn_throw_message("Bạn không đủ Vpoint để đổi tên.", 'e');
//                $errors_false = true;
//            }
//
//
//            if (!$errors_false) {
//                $ktgcoin = isset($get_gc) ? $get_gc : $gcoin_;
//                $ktvpoint = isset($get_vp) ? $get_vp : $vpoint_;
//
//                if ($ktvpoint == $vpoint_) $var_vp = $get_gc . " Gcoin";
//                else $var_vp = $get_vp . " Vpoint";
//
//                do_update_character('Character', "Name='$c_name'", "Name:'$sub'");
//                do_update_character('AccountCharacter', "GameID1='$c_name'", "GameID1:'$sub'");
//                do_update_character('AccountCharacter', "GameID2='$c_name'", "GameID2:'$sub'");
//                do_update_character('AccountCharacter', "GameID3='$c_name'", "GameID3:'$sub'");
//                do_update_character('AccountCharacter', "GameID4='$c_name'", "GameID4:'$sub'");
//                do_update_character('AccountCharacter', "GameID5='$c_name'", "GameID5:'$sub'");
//                do_update_character('AccountCharacter', "GameIDC='$c_name'", "GameIDC:'$sub'");
//                do_update_character('Guild', "G_Master='$c_name'", "G_Master:'$sub'");
//                do_update_character('GuildMember', "Name='$c_name'", "Name:'$sub'");
//                do_update_character('T_WaitFriend', "FriendName='$c_name'", "FriendName:'$sub'");
//                do_update_character('T_FriendMail', "FriendName='$c_name'", "FriendName:'$sub'");
//                do_update_character('T_FriendMain', "Name='$c_name'", "Name:'$sub'");
//                do_update_character('T_CGuid', "Name='$c_name'", "Name:'$sub'");
//                do_update_character('OptionData', "Name='$c_name'", "Name:'$sub'");
//
//
//                do_update_character('MEMB_INFO', "vpoint = $ktvpoint", "gcoin = $ktgcoin", "memb___id:'$accc_'");
//
//                //Ghi vào Log
//                $content = "$sub đã đổi $sub sang $c_name với $var_vp";
//                $Date = date("h:iA, d/m/Y", ctime());
//                $file = MODULE_ADM . "/log/modules/character/log_changename.txt";
//                $fp = fopen($file, "a+");
//                fputs($fp, $accc_ . "|" . $content . "|" . $gcoin_ . '_' . $vpoint_ . "|" . $var_vp . "|" . $Date . "|\n");
//                fclose($fp);
//                //End Ghi vào Log
//
//                $before_info_cn[3][1] = number_format((float)$ktgcoin, 0, ",", ".");
//                $before_info_cn[9][1] = number_format((float)$ktvpoint, 0, ",", ".");
//                $before_info_cn[0][1] = "<a href=" . cn_url_modify('mod=char_manager', 'opt=info_char', 'sub') . " title='Click info $c_name'> $c_name </a>";
//
//                cn_throw_message("Nhân vật $sub đã đổi thành $c_name thành công.");
//            }
//        }
//    }
//    cn_assign('showchar, sub, before_info_cn, cn_false, infClas', $showchar, $sub, $before_info_cn, $cn_false, $infoClas);
//
//    $arr_shop = mcache_get('.breadcrumbs');
//    $name__ = array_pop($arr_shop)['name'];
//    echoheader('-@my_char/style.css', "Đổi tên nhân vật");
//    echocomtent_here(exec_tpl('my_char/changeclass'), cn_snippet_bc_re());
//    echofooter();
//}


function checkGcoinVpoint($gcRoot, $vpRoot, $parVpoint) {
    $get_vp = $vpRoot;
    $get_gc = $gcRoot;
    $sms_gc = $sms_vp = '';
    $cn_false = false;

    if ($gcRoot >= $_gcoin_test = round(0.01 * getoption('vptogc') * $parVpoint)) {
        $get_gc = $gcRoot - $_gcoin_test;
        $sms_gc = " (Đủ Gcoin)";

    } else if (0 <= $get_vp = $vpRoot - $parVpoint) {
        $sms_vp = " (Đủ Vpoint)";
    } else {
        $cn_false = true;
        $sms_vp = " <font color=red>(Thiếu " . number_format((float)(abs($get_vp)), 0, ",", ".") . " Vpoint)</font>";
    }

    return array($get_gc, $sms_gc, $get_vp, $sms_vp, $cn_false);
}

