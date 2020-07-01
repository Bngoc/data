<?php

// Since 2.0: Add BreadCrumb
function cn_bc_add($name, $url)
{
    $bc = getMemcache('.breadcrumbs');

    $bc[] = array('name' => $name, 'url' => $url);
    setMemcache('.breadcrumbs', $bc);
}

// Since 2.0: Get template (if not exists, create from defaults)
function cn_get_template_by_array($template_name = '', $subtemplate = '')
{
    $templates = getOption('#temp_basic');

    //if(!empty($template_name) && $template_name){
    $template_name = strtolower($template_name);

    // User template not exists in config... get from defaults
    if (isset($templates[$template_name])) {
        return $templates[$template_name];
    }

    $list = cn_template_list();


    if (isset($list[$template_name])) {
        return $list[$template_name];
    }

    return false;
}

// Since 2.0: Short message form
function msg_info($title, $go_back = null)
{
    include SERVDIR . '/skins/default.skin.php';
    echo_header_admin('info', "Permission check");

    if ($go_back === null) {
        $go_back = $_POST['__referer'];
    }
    if (empty($go_back)) {
        $go_back = PHP_SELF;
    }

    $str_ = '<div class="sub_ranking" align="center" style="color: rgb(36, 36, 36);font-size: 15px;line-height: initial;">
				<b><p>' . $title . '</p></b><br>
				<p><b><a href=' . $go_back . '><font size="15" color="red">OK</font></a></b></p>
			</div>';
    echo $str_;
//    $this->echoContent($str_, cn_snippet_bc_re("Home", "Permission check"));

    echofooter();
    die();
}

function cn_sort_menu($opt)
{
    $bc = getMemcache('.menu');
    $result = '<select class="sel-p" onchange="document.location.href=this.value">';
    foreach ($bc as $key => $item) {
        $check = strpos($item['url'], $opt);
        $result .= '<option value="' . $item['url'] . '"';
        if ($check !== false) {
            $result .= 'selected';
        }
        $result .= '>' . cnHtmlSpecialChars($item['name']) . '</option>';
    }

    $result .= "</select>";

    echo $result;
}

// Since 2.0: Read file (or create file)
function cn_read_file($target)
{
    $fn = cn_touch($target, true);
    $fc = file($fn);
    unset($fc[0]);

    if (!$fc) {
        $data = array();
    } else {
        foreach ($fc as $id => $val) {
            $val = trim($val);

            $ctime = substr(md5($val), 3, 11);
            list($code32, $name, $price, $image) = explode("|", $val);

            if (!cn_check_code32(trim($code32))) {
                continue;
            }

            $data[$ctime] = array(
                'code32' => trim($code32),
                'name' => $name,
                'price' => $price,
                'image_mh' => $image,
            );
        }
    }

    return @$data ? $data : array();
}

/**
 * @param $code32
 * @return bool
 */
function cn_check_code32($code32)
{
    if ($code32 == 'FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF' || $code32 == 'ffffffffffffffffffffffffffffffff' || $code32 == '' || strlen($code32) != 32) {
        return false;
    }

    $items_data = getOption('#items_data');
    $id = hexdec(substr($code32, 0, 2));
    $group = hexdec(substr($code32, 18, 2)) / 16;

    if (isset($items_data[$group . '.' . $id])) {
        return true;
    }

    return false;
}

// Since 2.0: Save option to config
// Usage: #level1/level2/.../levelN or 'option_name' from %site
function setOption($opt_name, $var)// $var_name ='')
{
    $cfg = getMemcache('config');

    if ($opt_name[0] == '#') {
        $c_names = separateString(substr($opt_name, 1), '/');
        $cfg = setoption_rc($c_names, $var, $cfg);
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

    cn_config_save($cfg);
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

// Displays header skin
// $image = img@custom_style_tpl
function echo_header_admin($image, $header_text, $bread_crumbs = false)
{
    global $skin_header, $lang_content_type, $skin_menu, $digitalSignature, $skin_menu_none, $_SESS, $_SERV_SESS;
    $header_time = date('H:i:s | d, M, Y', ctime());

    $customs = explode("@", $image);
    $image = isset($customs[0]) ? $customs[0] : '';
    $custom_style = isset($customs[1]) ? $customs[1] : false;
    $custom_js = isset($customs[2]) ? $customs[2] : false;

    if (isset($_SESSION['mu_Account'])) {
        $skin_header = preg_replace("/{menu}/", $skin_menu, $skin_header);
    } else {
        $skin_header = preg_replace("/{menu}/", "<div style='padding: 5px;'><a href='" . PHP_SELF . "'>" . VERSION_NAME . "</a></div>", $skin_header);
    }

    //$skin_header = get_skin($skin_header);
    $skin_header = str_replace('{title}', ($header_text ? $header_text . ' / ' : '') . 'Admin Dashboard ', $skin_header);
    $skin_header = str_replace('{signature}', $digitalSignature, $skin_header);
    //$skin_header = str_replace("{image-name}", $skin_prefix.$image, $skin_header);
    $skin_header = str_replace("{header-text}", $header_text, $skin_header);
    $skin_header = str_replace("{header-time}", $header_time, $skin_header);
    $skin_header = str_replace("{content-type}", $lang_content_type, $skin_header);
    $skin_header = str_replace("{breadcrumbs}", $bread_crumbs, $skin_header);

    if ($custom_style) {
        $custom_style = read_tpl($custom_style);
    }
    $skin_header = str_replace("{CustomStyle}", $custom_style, $skin_header);

    if ($custom_js) {
        $custom_js = '<script type="text/javascript">' . read_tpl($custom_js) . '</script>';
    }
    $skin_header = str_replace("{CustomJS}", $custom_js, $skin_header);

    echo $skin_header;
}

function echofooter()
{
    global $is_loged_in, $skin_footer, $lang_content_type, $skin_menu, $config_adminemail, $config_admin;

    if ($is_loged_in == TRUE) {
        $skin_footer = str_replace("{menu}", $skin_menu, $skin_footer);
    } else {
        $skin_footer = str_replace("{menu}", " &nbsp; ", $skin_footer);
    }

    //$skin_footer = get_skin($skin_footer);
    //$skin_footer = str_replace("{content-type}", $lang_content_type, $skin_footer);
    $skin_footer = str_replace("{exec-time}", round(microtime(true) - BQN_MU, 3), $skin_footer);
    $skin_footer = str_replace("{year-time}", date("Y"), $skin_footer);
    $skin_footer = str_replace("{email-name}", $config_adminemail, $skin_footer);
    $skin_footer = str_replace("{byname}", $config_admin, $skin_footer);

    die($skin_footer);
}

function getMember()
{
    // Not authorized
    if (empty($_SESSION['mu_Account'])) {
        return null;
    }

    // No in cache
    if ($member = getMemcache('#member')) {
        return $member;
    }
    $requestData = [
        "clause" => "[UserAcc]='" . $_SESSION['mu_Account'] . "'",
        "isCheck" => false,
        "options" => [],
    ];
    $user = db_get_member_account($requestData);
    $user['user_Account'] = $user['UserAcc'];
    $user['acl'] = $user['AdLevel'];

    setMemcache('#member', $user);

    return $user;
}

/**
 * Call cn_snippet_digital_signature_admin_or_web
 */
function cn_before_digital_signature_admin_or_web()
{
    cn_snippet_digital_signature(getMember());
}

// Since 2.0: Get template (if not exists, create from defaults)
function cn_get_template($subTemplate, $template_name = 'default')
{
    $templates = getOption('#templates');

    $template_name = strtolower($template_name);

    // User template not exists in config... get from defaults
    if (isset($templates[$template_name])) {
        return $templates[$template_name][$subTemplate];
    }

    $list = cn_template_list();

    if (isset($list[$template_name][$subTemplate])) {
        return $list[$template_name][$subTemplate];
    }

    return false;
}

// Since 2.0: Decode "defaults/templates" to list
function cn_template_list()
{
    $config = file(cn_path_construct(SKIN, 'defaults') . 'character.tpl');

    foreach ($config as $line) {
        $line_ = trim($line);
        $lineComent = substr($line_, 0, 2);
        if (count($line_) === 0 || $line_ === '' || $lineComent == '//') {// || preg_match('/\s/', $line[0])){
            continue;
        }

        if ($line_[0] === '#') {
            continue;
        }
        if ($line_[0] == '*') {
            $_tpl_var = trim(substr($line_, 1));
            //if ($_tpl_var) $cfg[$template_vars][$_tpl_var] = ''; // lay ten *
            if ($_tpl_var) {
                if (!isset($templates[$_tpl_var])) $templates[$_tpl_var] = array();
                $template_vars_name = $_tpl_var;
            }
            continue;
        } else if ($line_[0] !== '@') {//preg_match('/\s/', $line[0]) && $line_[0] !== ''){
            list($name_, $value_get) = explode('=', $line_);
            $value_ = str_replace('_', ' ', $value_get);
            if (!isset($templates[$_tpl_var][$name_])) {
                $templates[$_tpl_var][$name_] = $value_;
            }
        } else if ($line_[0] == '@') {
            continue;
        }
    }

    setOption('#temp_basic', $templates);

    return isset($templates) ? $templates : array();
}

// Since 2.0: Decode "defaults/templates" to list
function cn_template_list_fail_check()
{
    $config = file(cn_path_construct(SKIN, 'defaults') . 'templates.tpl');
    $basic = getOption('#templates_basic');
    $basic['hash'] = isset($tbasic['hash']) ? $basic['hash'] : '';

    // template file is changed
    if ($basic['hash'] !== ($hash = md5(join(',', $config)))) {
        $templates = array();
        $current_tpl_name = $_tpl_var = '';

        foreach ($config as $line) {
            if ($line[0] == '#') {
                $current_tpl_name = trim(substr($line, 1));
                $templates[$current_tpl_name] = array();
                continue;
            }

            // Sub template markers
            if ($line[0] == '*') {
                $_tpl_var = trim(substr($line, 1));
                if ($_tpl_var) {
                    $template_vars[$_tpl_var] = '';
                }
            } elseif (preg_match('/\s/', $line[0]) || $line[0] === '') {
                // Subtemplate codes
                if (isset($templates[$current_tpl_name][$_tpl_var])) {
                    $templates[$current_tpl_name][$_tpl_var] .= substr($line, 1);
                } else {
                    $templates[$current_tpl_name][$_tpl_var] = substr($line, 1);
                }
            }
        }

        // set <change hash> var and parsed templates
        $basic['hash'] = $hash;
        $basic['templates'] = $templates;

        //setoption('#templates_basic', $tbasic);
    }

    return isset($tbasic['templates']) ? $basic['templates'] : array();
}

// Since 2.0: Simple paginate snippet
function cn_snippet_paginate($st, $per_page = 100, $showed = NULL)
{
    echo '<div class="snippet_paginate">';

    echo '<span class="next">';
    if ($st - $per_page < 0) echo '&lt;&lt; Prev';
    else echo '<a href="' . cn_url_modify('st=' . ($st - $per_page)) . '">&lt;&lt; Prev</a> ';
    echo '</span>';

    echo ' <span class="pages">[page <b>' . intval($st / $per_page) . '</b>]</span> ';

    echo '<span class="next">';
    if ($showed == $per_page) echo '<a href="' . cn_url_modify('st=' . ($st + $per_page)) . '">Next &gt;&gt;</a>';
    else echo 'Next &gt;&gt;';
    echo '</span>';

    echo '</div>';
}


// Since 2.0: Create snippet for open external window
function cn_snippet_open_win($url, $params = array(), $title = 'CN Window')
{
    if (empty($params['w'])) {
        $params['w'] = 550;
    }
    if (empty($params['h'])) {
        $params['h'] = 500;
    }
    if (empty($params['t'])) {
        $params['t'] = 100;
    }
    if (empty($params['l'])) {
        $params['l'] = 100;
    }
    if (empty($params['sb'])) {
        $params['sb'] = 1;
    }
    if (empty($params['rs'])) {
        $params['rs'] = 1;
    }

    $echo = '';
    if ($params['l'] === 'auto') {
        $echo .= 'var lp=(window.innerWidth - ' . $params['w'] . ') / 2; ';
    } else {
        $echo .= 'var lp=' . $params['l'] . '; ';
    }

    return $echo . "window.open('$url', '$title', 'scrollbars={$params['sb']},resizable={$params['rs']},width={$params['w']},height={$params['h']},left='+lp+',top={$params['t']}'); return false;";
}
