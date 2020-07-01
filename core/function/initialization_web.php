<?php

// Since 2.0: Show breadcrumbs BY
// Home > name
function cn_snippet_bc_re($home_ = 'Home', $_name_bread = null, $sep = '&gt;')
{
    ////            cnHtmlSpecialChars
    $bc = getMemcache('.breadcrumbs');
    $result = '<div id="mainsub_title" class="cn_breadcrumbs"><span class="bcitem"><a href="' . PHP_SELF . '">' . $home_ . '</a></span>';

    //if(is_array($bc)) $result .='<span class="bcsep"> '.$sep.' </span>';
    $maxs = count($bc) - 1;

    $ls = array();
    if (is_array($bc)) {
        $result .= '<span class="bcsep"> ' . $sep . ' </span>';
        foreach ($bc as $key => $item) {

            //if(is_null($_name_bread)){
            if ($key != $maxs) {// && is_null($_name_bread))
                $ls[] = '<span class="bcitem"><a href="' . $item['url'] . '">' . $item['name'] . '</a></span>';
            } else {
                $ls[] .= '<span class="bcitem">' . $item['name'] . '</span>';
            }
            //}
            //else
            //$ls[] = '<span class="bcitem"><a href="'.$item['url'].'">'.cnHtmlSpecialChars($item['name']).'</a></span>';
        }
    }
    //if($ls)
    $result .= join(' <span class="bcsep">' . $sep . '</span> ', $ls);

    //else
    //$result .= '<span class="bcsep"> '.$sep.' </span>';

    if (!is_null($_name_bread) && $_name_bread) {
        $result .= '<span class="bcsep"> ' . $sep . ' </span><span class="bcitem">' . $_name_bread . '</span>';
    }


    $result .= "</div>";

    return $result;
}

function echo_content_here($echoContent, $path_c = '', $bread_crumbs = true)
{
    global $skin_content_web;// $path_c;;
    $skin_content_web = preg_replace("/{paths_c}/", $path_c, $skin_content_web);
    $skin_content_web = preg_replace("/{paths_menu}/", cn_sort_menu(), $skin_content_web);
    $skin_content_web = preg_replace("/{content_here}/", $echoContent, $skin_content_web);
    echo $skin_content_web;
}

// Since 2.0: Show login form
function cn_login_form($admin = true)
{
    return execTemplate('_authen/login');
}

// Displays header skin
// $image = img@custom_style_tpl
function echo_header_web($image, $header_text, $bread_crumbs = false)
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

//    function echo_content_here($echocomtent, $path_c = '', $bread_crumbs = true)
//    {
//        global $skin_content_web;// $path_c;;
//        $skin_content_web = preg_replace("/{paths_c}/", $path_c, $skin_content_web);                // duong dan chi ...
//        $skin_content_web = preg_replace("/{paths_menu}/", cn_sort_menu(), $skin_content_web);                // duong dan chi ...
//        $skin_content_web = preg_replace("/{content_here}/", $echocomtent, $skin_content_web);
//        echo $skin_content_web;
//    }

function echo_footer_web()
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

/**
 * return html menu top
 */
function cn_menuTopMoney($opt = '')
{
    global $skin_menu_TopMoney, $skin_menu_TopAccount;

    if (isset($_SESSION['user_Gamer'])) {
        $_blank_var = view_bank($_SESSION['user_Gamer']);

        $matches[0] = '<img height="20px" src="' . getOption('http_script_dir') . '/public/images/web/top-menu/icon-1.png" /> ' . cn_zenderMoneyBank($_blank_var[0]['vp']) . ' Vpoint';
        $matches[1] = '<img height="20px" src="' . getOption('http_script_dir') . '/public/images/web/top-menu/icon-2.png" /> ' . cn_zenderMoneyBank($_blank_var[0]['gc']) . ' Gcoin';
        $matches[2] = '<img height="20px" src="' . getOption('http_script_dir') . '/public/images/web/top-menu/icon-3.png" /> ' . cn_zenderMoneyBank($_blank_var[0]['gc_km']) . ' Gcoin KM';
        $matches[3] = '<img height="20px" src="' . getOption('http_script_dir') . '/public/images/web/top-menu/icon-4.png" /> ' . cn_zenderMoneyBank($_blank_var[0]['blue']) . ' Blue';
        ;
        $matches[4] = '<img height="20px" src="' . getOption('http_script_dir') . '/public/images/web/top-menu/icon-5.png" /> ' . cn_zenderMoneyBank($_blank_var[0]['chaos']) . ' Chaos';
        $matches[5] = '<img height="20px" src="' . getOption('http_script_dir') . '/public/images/web/top-menu/icon-6.png" /> ' . cn_zenderMoneyBank($_blank_var[0]['cre']) . ' Cre';
        $matches[6] = '<img height="20px" src="' . getOption('http_script_dir') . '/public/images/web/top-menu/icon-7.png" /> ' . cn_zenderMoneyBank($_blank_var[0]['bank']) . ' Zen';
        $matches[7] = '<img height="20px" src="' . getOption('http_script_dir') . '/public/images/web/top-menu/icon-8.png" /> ' . cn_zenderMoneyBank($_blank_var[0]['feather']) . ' Lông vũ';
        $tempTop = ['{nameVpoint}', '{nameGcoin}', '{nameGcKm}', '{nameBule}', '{nameChaos}', '{nameCreate}', '{nameBank}', '{nameFeather}'];
        $skin_menu_TopMoney = str_replace($tempTop, $matches, $skin_menu_TopMoney);

        $userName[0] = '<img class="icon-Userimg" src="' . getOption('http_script_dir') . '/public/images/user-Name.png" />';
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
            $tmpHtml = '<a href="' . PHP_SELF . '?mod=manager_account&amp;opt=' . $its[0] . '"><div><img height="20" width="20" src="' . getOption('http_script_dir') . '/public/images/' . $its[0] . '.png" /></div><div>' . $its[1] . '</div></a>';
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
            echo '<input type="hidden" name="' . trim($field) . '" value="' . cnHtmlSpecialChars($val) . '" />';
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
            $nameForm = 'id="' . substr($nameFrom, 1) . '"';
        } else {
            $nameForm = 'class="' . substr($nameFrom, 1) . '"';
        }
        $defaultVerifyAjax = str_replace('{nameAction}', $nameForm, $defaultVerifyAjax);

        echo "<form id=\"verify\" action=\"" . PHP_SELF . "\" method=\"POST\" onsubmit=\"return false;\">";
        echo cn_form_open('mod, opt, sub');

        if ($addOpt) {
            foreach ($addOpt as $field => $val) {
                echo '<input type="hidden" name="' . trim($field) . '" value="' . cnHtmlSpecialChars($val) . '" />';
            }
        }
        echo $defaultVerifyAjax;
        echo '</form>';
    }
}

// Since 2.0: Short message form
function msg_info($title, $go_back = null)
{
    include SERVDIR . '/skins/default.skin.php';
    echo_header_web('info', "Permission check");

    if ($go_back === null) {
        $go_back = $_POST['__referer'];
    }
    if (empty($go_back)) {
        $go_back = PHP_SELF;
    }

    $str_ = '<div class="sub_ranking" align="center" style="color: rgb(36, 36, 36);font-size: 12px;line-height: initial;">
				<b><p>' . $title . '</p></b><br>
				<p><b><a href=' . $go_back . '><font size="12" color="red">OK</font></a></b></p>
			</div>';

    echo_content_here($str_, cn_snippet_bc_re("Home", "Permission check"));

    echo_footer_web();
    die();
}

// Since 2.0: Short message form
function msg_err($title, $go_back = null)
{
    include SERVDIR . '/skins/default.skin.php';
    echo_header_web('info', 'error');

    if ($go_back === null) {
        $go_back = $_POST['__referer'];
    }
    if (empty($go_back)) {
        $go_back = PHP_SELF;
    }

    $str_ = '<div class="sub_ranking" align="center" style="color: rgb(36, 36, 36);font-size: 12px;line-height: initial;">
				<b><p>' . $title . '</p></b><br>
				<p><b><a href=' . $go_back . '><font style="font-size: 16px;" color="#86001E"><img src="/public/images/return.png"/>Quay lại</font></a></b></p>
			</div>';

    echo_content_here($str_, cn_snippet_bc_re("Home", "error"));

    echo_footer_web();
    die();
}

// Since 2.0: Add BreadCrumb
function cn_bc_add($name, $url)
{
    $bc = getMemcache('.breadcrumbs');
    $bc[] = array('name' => $name, 'url' => $url);
    setMemcache('.breadcrumbs', $bc);
}

//// Since 2.0: Save option to config
//// Usage: #level1/level2/.../levelN or 'option_name' from %site
//    function setOption($opt_name, $var)
//    {
//        $cfg = getMemcache('config');
//
//        if ($opt_name[0] == '#') {
//            $c_names = separateString(substr($opt_name, 1), '/');
//            $cfg = setoption_rc($c_names, $var, $cfg);
//        } else {
//            $cfg['%site'][$opt_name] = $var;
//        }
//
//        cn_config_save($cfg);
//    }

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

function cn_sort_menu()
{
    list($opt, $per_page) = GET('opt, per_page', 'GPG');
    if (!$opt) {
        return '';
    }
    $get_per_page = '';
    if ($per_page) {
        $get_per_page = '&per_page=' . $per_page;
    }
    $bc = getMemcache('.menu');

    if (!$bc) {
        return '';
    }

    $result = '<select class="sel-p" onchange="document.location.href=this.value">';

    foreach ($bc as $key => $item) {
        //$check = strpos($item['url'],$opt);
        $result .= '<option value="' . $item['url'] . $get_per_page . '"';
        //if($check !== false) $result .= 'selected';
        if ($key == $opt) {
            $result .= 'selected';
        }
        $result .= '>' . ($item['name']) . '</option>';
    }
    $result .= "</select>";

    return $result;
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

function getMemberWeb()
{
    // Not authorized
    if (empty($_SESSION['user_Gamer'])) {
        return null;
    }

    // No in cache
    if ($member = getMemcache('#memberWeb')) {
        return $member;
    }

    $user = db_user_by_name($_SESSION['user_Gamer']);

    setMemcache('#memberWeb', $user);

    return $user;
}

// Since 2.0: Test User ACL. Test for groups [user may consists requested group]
function testRoleWeb($requested_acl, $requested_user = null, $is_self = false)
{
    $user = getMemberWeb(); // get user menber session

    // Deny ANY access of unauthorized member
    if (!$user) {
        return false;
    }

    $acl = $user['acl'];
    $grp = getOption('#grp');
    $ra = separateString($requested_acl);

    // This group not exists, deny all
    if (!isset($grp[$acl])) {
        return false;
    }
    // Decode ACL, GRP string
    $gp = separateString($grp[$acl]['G']);
    $rc = separateString($grp[$acl]['A']);


    // ra la bien truyen vao
    // If requested acl not match with real allowed, break
    foreach ($ra as $Ar) {
        if (!in_array($Ar, $rc)) {
            return false;
        }
    }

    // Test group or self
    if ($requested_user) {
        // if self-check, check name requested user and current user
        if ($is_self && $requested_user['user_Gamer'] !== $user['name']) {
            return false;
        }
        // if group check, check: requested uses may be in current user group
        if (!$is_self) {
            //kiem tra user truyen vao user[acl]  <=> phan quyen trong nhom
            if ($gp && !in_array($requested_user['acl'], $gp)) {
                return false;
            } elseif (!$gp) {
                //ko ton tai phan quyen
                return false;
            }
        }
    }

    return true;
}

/**
 * Call cn_snippet_digital_signature_admin_or_web
 */
function cn_before_digital_signature_admin_or_web()
{
    cn_snippet_digital_signature(getMemberWeb());
}

//information character
function cn_character()
{
    $member = getMemberWeb();
    $show_reponse = view_character($member['user_name']);
    $arr_class = cn_template_class();
    if (!$arr_class) {
        msg_err('Err. Bạn chưa thiết lập các thông số nhân vật!');
        return;
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
                    if (array_key_exists($char_img[1], $img_character)) {
                        $Char_Image = $img_character[$char_img[1]];
                    }
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

//BQN Check Point trust
function cn_point_trust()
{
    $member = getMemberWeb();
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

                        if ($inday_time_beginon >= 43200) {
                            $Pf = 720;
                        } else {
                            $Pf = floor($inday_time_beginon / 60);
                        }
                        if ($count_on == 1) {
                            $point_pt_on = floor(0.95 * $Pf);
                            $point_pt_off = floor(0.95 * $point_pt_off);
                            //if(date("Y-m-d", $_time_off_begin) != date("Y-m-d",$ctime)) $trust_point = floor($trust_point*0.9);
                            $trust_point = floor($trust_point * 0.9);
                        } elseif ($count_on >= 2) {
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
                                } else {
                                    $_bv = 720 + (isset($point_pt_on) ? $point_pt_on : 0);
                                }
                                $point_pt_on = floor($_bv * 0.95);
                            } while ($count_on > 1);
                        }
                        $check_trust = true;
                        do_update_character('Character', 'UyThacOffline_Daily=0', 'UyThacOnline_Daily=0', "PhutUyThacOff_dutru=$point_pt_off", "PhutUyThacOn_dutru=$point_pt_on", "uythacoffline_time=$set_time", "uythaconline_time=$set_time", "PointUyThac=$trust_point", "Name:'$sub'");
                    //cnRelocation(cn_url_modify(array('reset'), 'mod='.REQ('mod'), 'opt='.REQ('opt'), 'sub='.$sub));
                    } elseif ($time_begin_off < $_time_) {
                        $check_trust = true;
                        do_update_character('Character', 'UyThacOffline_Daily=0', "uythacoffline_time=$set_time", "Name:'$sub'");
                        //cnRelocation(cn_url_modify(array('reset'), 'mod='.REQ('mod'), 'opt='.REQ('opt'), 'sub='.$sub));
                    }
                } elseif ($status_offline) {        //Starus ON [Offline]

                    if ($time_begin_off < $_time_) {
                        $inday_begin_off = date("Y-m-d h:i:sa", $_time_off_begin);
                        $inday_beginoff_end = date("Y-m-d", $_time_off_begin); // strtotime
                        $inday_time_beginoff = abs(strtotime($inday_begin_off) - strtotime("$inday_beginoff_end 11:59:59pm"));

                        if ($inday_time_beginoff >= 43200) {
                            $Pf = 720;
                        } else {
                            $Pf = floor($inday_time_beginoff / 60);
                        }

                        if ($count_off == 1) {
                            $point_pt_off = floor(0.95 * $Pf);
                            $point_pt_on = floor(0.95 * $point_pt_on);
                            //if(date("Y-m-d", $_time_on_begin) != date("Y-m-d",$ctime)) $trust_point = floor($trust_point*0.9);
                            $trust_point = floor($trust_point * 0.9);
                        } elseif ($count_off >= 2) {
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
                                } else {
                                    $_bv = 720 + (isset($point_pt_off) ? $point_pt_off : 0);
                                }
                                $point_pt_off = floor($_bv * 0.95);
                            } while ($count_off > 1);
                        }
                        $check_trust = true;
                        do_update_character('Character', 'UyThacOffline_Daily=0', 'UyThacOnline_Daily=0', "PhutUyThacOn_dutru=$point_pt_on", "PhutUyThacOff_dutru=$point_pt_off", "uythaconline_time=$set_time", "uythacoffline_time=$set_time", "PointUyThac=$trust_point", "Name:'$sub'");
                    //cnRelocation(cn_url_modify(array('reset'), 'mod='.REQ('mod'), 'opt='.REQ('opt'), 'sub='.$sub));
                    } elseif ($time_begin_on < $_time_) {
                        $check_trust = true;
                        do_update_character('Character', 'UyThacOnline_Daily=0', "uythaconline_time=$set_time", "Name:'$sub'");
                        //cnRelocation(cn_url_modify(array('reset'), 'mod='.REQ('mod'), 'opt='.REQ('opt'), 'sub='.$sub));
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
                    //cnRelocation(cn_url_modify(array('reset'), 'mod='.REQ('mod'), 'opt='.REQ('opt'), 'sub='.$sub));
                    } elseif ($count_on) {
                        $check_trust = true;
                        do_update_character('Character', 'UyThacOnline_Daily=0', "uythaconline_time=$set_time", "Name:'$sub'");
                    } elseif ($count_off) {
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
