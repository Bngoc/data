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
            if ($key != $maxs)// && is_null($_name_bread))
                $ls[] = '<span class="bcitem"><a href="' . $item['url'] . '">' . $item['name'] . '</a></span>';
            else
                $ls[] .= '<span class="bcitem">' . $item['name'] . '</span>';
            //}
            //else
            //$ls[] = '<span class="bcitem"><a href="'.$item['url'].'">'.cnHtmlSpecialChars($item['name']).'</a></span>';

        }
    }
    //if($ls)
    $result .= join(' <span class="bcsep">' . $sep . '</span> ', $ls);

    //else
    //$result .= '<span class="bcsep"> '.$sep.' </span>';

    if (!is_null($_name_bread) && $_name_bread)
        $result .= '<span class="bcsep"> ' . $sep . ' </span><span class="bcitem">' . $_name_bread . '</span>';


    $result .= "</div>";

    return $result;
}

function echo_content_here($echocomtent, $path_c = '', $bread_crumbs = true)
{
    global $skin_content_web;// $path_c;;
    $skin_content_web = preg_replace("/{paths_c}/", $path_c, $skin_content_web);                // duong dan chi ...
    $skin_content_web = preg_replace("/{paths_menu}/", cn_sort_menu(), $skin_content_web);                // duong dan chi ...
    $skin_content_web = preg_replace("/{content_here}/", $echocomtent, $skin_content_web);
    echo $skin_content_web;
}

// Since 2.0: Show login form
function cn_login_form($admin = TRUE)
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

        $matches[0] = '<img height="20px" src="' . getOption('http_script_dir') . '/images/top-menu/icon-1.png" /> ' . cn_zenderMoneyBank($_blank_var[0]['vp']) . ' Vpoint';
        $matches[1] = '<img height="20px" src="' . getOption('http_script_dir') . '/images/top-menu/icon-2.png" /> ' . cn_zenderMoneyBank($_blank_var[0]['gc']) . ' Gcoin';
        $matches[2] = '<img height="20px" src="' . getOption('http_script_dir') . '/images/top-menu/icon-3.png" /> ' . cn_zenderMoneyBank($_blank_var[0]['gc_km']) . ' Gcoin KM';
        $matches[3] = '<img height="20px" src="' . getOption('http_script_dir') . '/images/top-menu/icon-4.png" /> ' . cn_zenderMoneyBank($_blank_var[0]['blue']) . ' Blue';;
        $matches[4] = '<img height="20px" src="' . getOption('http_script_dir') . '/images/top-menu/icon-5.png" /> ' . cn_zenderMoneyBank($_blank_var[0]['chaos']) . ' Chaos';
        $matches[5] = '<img height="20px" src="' . getOption('http_script_dir') . '/images/top-menu/icon-6.png" /> ' . cn_zenderMoneyBank($_blank_var[0]['cre']) . ' Cre';
        $matches[6] = '<img height="20px" src="' . getOption('http_script_dir') . '/images/top-menu/icon-7.png" /> ' . cn_zenderMoneyBank($_blank_var[0]['bank']) . ' Zen';
        $matches[7] = '<img height="20px" src="' . getOption('http_script_dir') . '/images/top-menu/icon-8.png" /> ' . cn_zenderMoneyBank($_blank_var[0]['feather']) . ' Lông vũ';
        $tempTop = ['{nameVpoint}', '{nameGcoin}', '{nameGcKm}', '{nameBule}', '{nameChaos}', '{nameCreate}', '{nameBank}', '{nameFeather}'];
        $skin_menu_TopMoney = str_replace($tempTop, $matches, $skin_menu_TopMoney);

        $userName[0] = '<img class="icon-Userimg" src="' . getOption('http_script_dir') . '/images/user-Name.png" />';
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
            $tmpHtml = '<a href="' . PHP_SELF . '?mod=manager_account&amp;opt=' . $its[0] . '"><div><img height="20" width="20" src="' . getOption('http_script_dir') . '/images/' . $its[0] . '.png" /></div><div>' . $its[1] . '</div></a>';
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

    if ($go_back === null) $go_back = $_POST['__referer'];
    if (empty($go_back)) $go_back = PHP_SELF;

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

    if ($go_back === null) $go_back = $_POST['__referer'];
    if (empty($go_back)) $go_back = PHP_SELF;

    $str_ = '<div class="sub_ranking" align="center" style="color: rgb(36, 36, 36);font-size: 12px;line-height: initial;">
				<b><p>' . $title . '</p></b><br>
				<p><b><a href=' . $go_back . '><font style="font-size: 16px;" color="#86001E"><img src="images/return.png"/>Quay lại</font></a></b></p>
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
    if (!$opt) return '';
    $get_per_page = '';
    if ($per_page) $get_per_page = '&per_page=' . $per_page;
    $bc = getMemcache('.menu');

    if (!$bc) {
        return '';
    }

    $result = '<select class="sel-p" onchange="document.location.href=this.value">';

    foreach ($bc as $key => $item) {
        //$check = strpos($item['url'],$opt);
        $result .= '<option value="' . $item['url'] . $get_per_page . '"';
        //if($check !== false) $result .= 'selected';
        if ($key == $opt) $result .= 'selected';
        $result .= '>' . ($item['name']) . '</option>';
    }
    $result .= "</select>";

    return $result;
}
