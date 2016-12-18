﻿<?php if (!defined('BQN_MU')) die('Access restricted');

add_hook('index/invoke_module', '*account_invoke');

// =====================================================================================================================

function account_invoke()
{
    $dashboard = array
    (
        'editconfig:sysconf:Csc' => 'Cấu hình Hệ thống',
        'editconfig:templates:Ct' => 'Cấu hình chức năng',
        'editconfig:category:Can' => 'Cấu hình DDOS',
        /*'editconfig:iserverz:Ciw'     => 'SERVER',*/
        'editconfig:ischaracter:Ciw' => 'Character',
        /*'editconfig:iswebshop:Ciw'     => 'CashShop',
        'editconfig:iseverz:Ciw'     => 'Thẻ nạp',*/
        'editconfig:personal:Cp' => 'Personal options',
        'editconfig:userman:Cum' => 'Users manager',
        'editconfig:group:Cg' => 'Groups',
        'editconfig:logs:Csl' => 'Logs',
        'editconfig:statistics:Csl' => 'Thống kê'
    );

    // Call dashboard extend
    $dashboard = hook('extend_dashboard', $dashboard);

    // Exec
    $mod = REQ('mod', 'GETPOST');
    $opt = REQ('opt', 'GETPOST');

    // Top level (dashboard)
    cn_bc_add('Cấu hình', cn_url_modify(array('reset'), 'mod=' . $mod));

    // Request module
    foreach ($dashboard as $id => $_t) {
        list($dl, $do, $acl_module) = explode(':', $id);

        if (test($acl_module) && $dl == $mod && $do == $opt && function_exists("board_$opt")) {
            cn_bc_add($_t, cn_url_modify(array('reset'), 'mod=' . $mod, 'opt=' . $opt));
            die(call_user_func("board_$opt"));
        }
    }

    echoheader('-@com_board/style.css', "Mu Online dashboard");

    $images = array
    (
        'personal' => 'user.gif',
        'userman' => 'users.gif',
        'sysconf' => 'options.gif',
        'category' => 'category.png',
        'templates' => 'template.png',
        'backup' => 'archives.gif',
        'archives' => 'arch.png',
        'media' => 'images.gif',
        'intwiz' => 'wizard.gif',
        'logs' => 'list.png',
        'selfchk' => 'check.png',
        'ipban' => 'block.png',
        'widgets' => 'widgets.png',
        'wreplace' => 'replace.png',
        'morefields' => 'more.png',
        'maint' => 'settings.png',
        'group' => 'group.png',
        'locale' => 'locale.png',
        'script' => 'script.png',
        'ischaracter' => 'ischaracter.png',
    );

    // More dashboard images
    $images = hook('extend_dashboard_images', $images);

    foreach ($dashboard as $id => $name) {
        list($mod, $opt, $acl) = explode(':', $id, 3);

        if (!test($acl)) {
            unset($dashboard[$id]);
            continue;
        }

        $item = array
        (
            'name' => $name,
            'img' => isset($images[$opt]) ? $images[$opt] : 'home.gif',
            'mod' => $mod,
            'opt' => $opt,
        );

        $dashboard[$id] = $item;
    }


    $member = member_get();

    //$meta_draft = db_index_meta_load('draft');
    //$drafts =isset($meta_draft['locs'])? intval(array_sum($meta_draft['locs'])):false;

    //if ($drafts && test('Cvn'))
    //{
    //$greeting_message = i18n('News in draft: %1', '<a href="'.cn_url_modify('mod=editnews', 'source=draft').'"><b>'.$drafts.'</b></a>');
    //}
    //else
    //{
    //$greeting_message = i18n('Have a nice day!');
    //}

    $greeting_message = 'Have a nice day!';
    cn_assign('dashboard, username, greeting_message', $dashboard, $member['user_Account'], $greeting_message);
    //echo exec_tpl('header');
    echo exec_tpl('com_board/general');

    echofooter();
}

// =====================================================================================================================
// Since 2.0: System configurations

function board_sysconf()
{

    $lng = $grps = $all_skins = array();
    //$skins = scan_dir(cn_path_construct(SERVDIR,'skins'));
    //$langs = scan_dir(cn_path_construct(SERVDIR,'core','lang'), 'txt');
    $_grps = getoption('#grp');
    //$conf_class_ = cn_get_template('class_dw_1_name','config_class');
    //$conf_class = cn_get_template_byarr('config_class');

    //echo "000000000000000000000 142 =>". $conf_class['class_dw_1_name'] ."<br>";
    //echo "000000000000000000000 143 =>". $conf_class_ ."<br>";


    /*
    // fetch skins
    foreach ($skins as $skin)
    {
        if (preg_match('/(.*)\.skin\.php/i', $skin, $c)) //<=> *.skin.php
        {
            $all_skins[$c[1]] = $c[1];
        }
    }

    // fetch lang packets
    foreach ($langs as  $lf)
    {
        if (preg_match('/(.*)\.txt/i', $lf, $c))
        {
            $lng[$c[1]] = $c[1];
        }
    }
*/
    // fetch groups
    foreach ($_grps as $id => $vn) {
        $grps[$id] = ucfirst($vn['N']);
    }

    $options_list = array
    (
        // Section
        'general' => array
        (
            // Option -> 0=Type(text [Y/N] int select), 1=Title|Description, [2=Optional values]

            '_GENERAL' => array('title', 'General site settings'),
            'http_script_dir' => array('text', 'Full URL to CuteNews directory|example: http://yoursite.com/cutenews'),
            'main_site' => array('text', 'URL to your site|example: http://yoursite.com/ (optional)'),

            'useutf8' => array('Y/N', 'Use UTF-8 for ACP|with this option, admin panel uses utf-8 charset'),
            'utf8html' => array('Y/N', "Convert UTF8 symbols to HTML entities|E.g. &aring to &amp;aring;"),
            'comment_utf8html' => array('Y/N', 'Convert UTF8 symbols for comments|if this option is set, utf-8 entities convert to html entities'),
            'date_adjust' => array('int', 'Time adjustment|in hours; eg. : +3 hours =180 minutes; -2 hours = -120 minutes'),

            'allow_registration' => array('Y/N', 'Allow self-Registration|allow users to register automatically'),
            'notify_registration' => array('Y/N', 'Allow Send Email Registration|allow send email for users to register'),
            'registration_level' => array('select', 'Self-registration level', $grps),
            'config_time_logout' => array('int', 'Second Time Auto Logout After |eg: 900 (Automatic Logout after 15 minutes)'),
            'config_login_ban' => array('text', 'Limit the number of login attempts - Minute Time Blocks |eg: 5:360 (user block after failed 5 login template within 6 hours)'),
            'ban_attempts' => array('int', 'Second between login attempts'),
            'config_auth_email' => array('text', 'Account from send email'),
            'config_auth_pass' => array('password', 'Password account from send email'),

            '_COM' => array('title', 'General:'),

//            'i18n' => array('text', 'Language code|by default en_US. See: <a href="http://en.wikipedia.org/wiki/Language_localization#Language_tags_and_codes">codes</a>'),

//            '_FB' => array('title', 'Facebook:'),
            'use_fbcomments' => array('Y/N', 'Use facebook comments for post|if yes, facebook comments will be shown'),
            'fb_inactive' => array('Y/N', 'In active news|Show in active news list'),
            'fb_appid' => array('text', 'Facebook application ID|<a href="https://developers.facebook.com/apps" target="_blank">https://developers.facebook.com/apps</a>'),

//            '_FB_c' => array('title', 'Facebook comments:'),
            'fb_comments' => array('int', 'Comments number|Count comment under top box'),
            'fb_box_width' => array('int', 'Box width|In pixels'),
            'fbcomments_color' => array('select', 'Color scheme|The color scheme of the plugin', array("light" => "Light", "dark" => "Dark")),

//            '_FB_lb' => array('title', 'Facebook Like button:'),
            'use_fblike' => array('Y/N', 'Use facebook like button|if yes, facebook button will be shown'),
            'fblike_send_btn' => array('Y/N', 'Send Button|include a send button'),
            'fblike_style' => array('select', 'Layout style|determines the size and amount of social context next to the button', array("standard" => "standard", "button_count" => "button_count", "box_count" => "box_count")),
            'fblike_width' => array('int', 'Box width|In pixels'),
            'fblike_show_faces' => array('Y/N', 'Show faces|if yes, profile pictures below the button will be shown'),
            'fblike_font' => array('select', 'Font|The font of the plugin', array("arial" => "Arial", "lucida grande" => "Lucida grande", "segoe ui" => "Segoe ui", "tahoma" => "Tahoma", "trebuchet ms" => "Trebuchet ms", "verdana" => "Verdana")),
            'fblike_color' => array('select', 'Color scheme|The color scheme of the plugin', array("light" => "Light", "dark" => "Dark")),
            'fblike_verb' => array('select', 'Verb to display|The verb to display in the button', array("like" => "Like", "recommend" => "Recommend")),

//            '_TW' => array('title', 'Twitter button:'),
//            'use_twitter' => array('Y/N', 'Use twitter button|if yes, twitter button will be shown'),
//            'tw_url' => array('text', 'Share URL|if empty, use the page URL'),
//            'tw_text' => array('text', 'Tweet text|if empty, use the title of the page'),
//            'tw_show_count' => array('Y/N', 'Show count|if yes, count of tweets will be shown near button', array("horisontal" => "Horisontal", "vertical" => "Vertical", "none" => "None")),
//            'tw_via' => array('text', 'Via @|Screen name of the user to attribute the Tweet to'),
//            'tw_recommended' => array('text', 'Recommended @|Accounts suggested to the user after tweeting, comma-separated.'),
            'tw_hashtag' => array('text', 'Hashtag #|Comma-separated hashtags appended to the tweet text'),
            'tw_large' => array('Y/N', 'Large button|if yes, the twitter button will be large'),
            'tw_lang' => array('select', 'Language|The language of button text', array("en" => "English", "fr" => "French", "ar" => "Arabic", "ja" => "Japanese", "es" => "Spanish", "de" => "German", "it" => "Italian", "id" => "Indonesian", "pt" => "Portuguese", "ko" => "Korean", "tr" => "Turkish", "ru" => "Russian", "nl" => "Dutch", "fil" => "Filipino", "msa" => "Malay", "zh-tw" => "Traditional Chinese", "zh-cn" => "Simplified Chinese", "hi" => "Hindi", "no" => "Norwegian", "sv" => "Swedish", "fi" => "Finnish", "da" => "Danish", "pl" => "Polish", "hu" => "Hungarian", "fa" => "Farsi", "he" => "Hebrew", "ur" => "Urdu", "th" => "Thai", "uk" => "Ukrainian", "ca" => "Catalan", "el" => "Greek", "eu" => "Basque", "cs" => "Czech", "gl" => "Galician", "ro" => "Romanian")),

            // use_gplus + gplus_i18n
//            '_G+' => array('title', 'Google+ button:'),
//            'use_gplus' => array('Y/N', 'Use +1 button'),
//            'gplus_size' => array('select', 'Button size', array("small" => "Small", "medium" => "Medium", "standard" => "Standard", "tall" => "Tall")),
            'gplus_annotation' => array('select', 'Annotation|Sets the annotation to display next to the button.', array('inline' => 'Inline', 'bubble' => 'Bubble', 'none' => 'None')),
            'gplus_width' => array('int', 'Box width, in pixels'),

            'allowed_extensions' => array('text', 'Allowed extensions|Used by file manager. Enter by comma without space'),
            'uploads_dir' => array('text', 'Server upload dir|Real path on server'),
            'uploads_ext' => array('text', 'Frontend upload dir|Frontend path for uploads'),


        ),

        'websites' => array
        (
            'news_title_max_long' => array('int', 'Max. Length of news title in characters|enter <b>0</b> to disable chacking.'),
            'active_news_def' => array('int', 'Count active news, by default|If 0, show all list, with archives'),
            'reverse_active' => array('Y/N', 'Reverse News|if yes, older news will be shown on the top'),
            'full_popup' => array('Y/N', 'Show full story in popup|full Story will be opened in PopUp window'),
            'full_popup_string' => array('text', "Settings for full story popup|only if 'Show Full Story In PopUp' is enabled"),
            'auto_news_alias' => array('Y/N', 'Autocomplete page alias|Set news title as page alias'),
            'show_comments_with_full' => array('Y/N', 'Show comments when showing full story|if yes, comments will be shown under the story'),
            'timestamp_active' => array('text', 'Time format for news|view help for time formatting <a href="http://www.php.net/manual/en/function.date.php" target="_blank">here</a>'),
            'use_captcha' => array('Y/N', 'Use CAPTCHA|on registration and comments'),
            'hide_captcha' => array('Y/N', 'Hide captcha source path from visitors'),
            'disable_pagination' => array('Y/N', 'Disable pagination|Use it to disable pagination'),
            'mon_list' => array('text', 'Month list|comma separated, 12 variables'),
            'question_answers' => array('text', 'Câu hỏi|Liệt kê các câu hỏi ngăn cách nhau bằng dấu \',\''),


            'vptogc' => array('int', 'Công thức Gcoin = X% Vpoint|VD: X = 80 => [Gcoin = 80% Vpoint]'),
            //'gctovp'         => array('int', 'Title field will not be required|VD: 1 Vpoint = 1 Gcoin'),

            'changename_vpoint' => array('int', 'Thay đổi tên nhân vật Vpoint|VD: 50000'),
            'changeClass_str' => array('text', 'Thay đổi Class = Vpoint:-X% Reset:MinReset |VD: 50000:15:100 (50k Vpoint, -15% số reset, min reset 100)'),

            'user_rs_uythac' => array('Y/N', 'Sử dụng Reset ủy thác |...............'),
            'taytuy_vpoint' => array('int', 'Sử dụng ủy thác tay tuy vpoint|...............'),
            'uythacon_price' => array('int', '1 Điểm ủy Thác = X Gcoin / 1 Phút ủy thác Online|VD: X = 10 => [1 Điểm ủy Thác = 10 Gcoin / 1 Phút ủy thác]'),
            'uythacoff_price' => array('int', '1 Điểm ủy Thác = X Gcoin / 1 Phút ủy thác Offline|VD: X = 10 =>[1 Điểm ủy Thác = 10 Gcoin / 1 Phút ủy thác]'),
            'user_delegate' => array('select', 'Sử dụng ủy thác|chọn ủy thác với nhu cầu', array(0 => "Offline", 1 => "Online", 2 => "Online + Offline",)),
            'user_resetvip......' => array('Y/N', 'Sử dụng top ResetVip|.........Short story field will not be required'),
            'event_toprs_on' => array('Y/N', 'Sử dụng top reset|.........Short story field will not be required'),
            'hotrotanthu' => array('Y/N', 'Hỗ trợ tân thủ| nếu sử dụng hỗ trợ tân thủ sẽ được giảm level theo cấp độ (có 5 cấp)'),
            'cap_relife_max' => array('int', 'Số cấp Relife hiển thị dành cho người chơi|Số cấp Relife từ cấp 1 đến cấp 10'),
            'cap_reset_max' => array('int', 'Số cấp Reset hiển thị dành cho người chơi|Số cấp Reset từ cấp 1 đến cấp 20'),
            'use_gioihanrs' => array('select', 'Sử dụng giới hạn Reset|chọn giới hạn reset với nhu cầu', array(0 => "Không sử dụng", 1 => "Loại 1", 2 => "Loại 2",)),
        ),

        'server' => array
        (
            'type_connect' => array('select', 'Dạng kết nối Database|show/hide standart comment system', array("odbc" => "Odbc", "mssql" => "Mssql")),
            'localhost' => array('text', 'Localhost|newest comments will be shown at the top'),
            'databaseuser' => array('text', 'User quản lý SQL (thường là sa)|in seconds; 0 = no protection'),
            'databsepassword' => array('password', 'Mật khẩu quản lý SQL|enter <b>0</b> to disable checking'),
            'd_base' => array('text', 'Database sử dụng để lưu trữ thông tin MU|enter <b>0</b> or leave empty to disable pagination'),
//            'passviewcard' => array('password', 'Mật khẩu để vào trang Log, Admin|if yes, only registered users can post comments'),
//            'passadmin' => array('password', 'Mật khẩu để vào trang Online, CheckIP|visitors will be able to put their site URL instead of an email'),
//            'passcard' => array('password', 'Mật khẩu để vào trang CardPhone|comments will be opened in PopUp window'),
//            'passcode' => array('password', "Mật khẩu để vào trang ViewCard|only if 'Show Comments In PopUp' is enabled"),
            'server_type' => array('select', 'Loại Server đang sử dụng|if yes, comments will be shown under the story', array("scf" => "SCF", "original" => "Original")),
            'type_acc' => array('select', 'Qui định khi tạo Tài khoản|if yes, comments will be shown under the story', array(1 => "Sử dụng Chữ & Số", 0 => "Chỉ sử dụng số")),
        ),
        'Napthe' => array
        (
            'napthe_list' => array('text', 'Nap the list [VTC - GATE - VIETTEL - MOBI - VINA]| 1 => Yes, 0 => No, VD: 1,1,1,1,1'),
            'napthe_gate' => array('text', 'Card Gate list [10k - 20k - 30k - 50k - 100k - 200k - 300k -500k]| 1 => Yes, 0 => No, VD: 0,1,0,1,1,0,1,1'),
            'napthe_vtc' => array('text', 'Card Vtc list [10k - 20k - 30k - 50k - 100k - 200k - 300k -500k]| 1 => Yes, 0 => No, VD: 0,1,0,1,1,0,1,1'),
            'napthe_viettel' => array('text', 'Card Viettel list [10k - 20k - 30k - 50k - 100k - 200k - 300k -500k]| 1 => Yes, 0 => No, VD: 0,1,0,1,1,0,1,1'),
            'napthe_mobi' => array('text', 'Card Mobi list [10k - 20k - 30k - 50k - 100k - 200k - 300k -500k]| 1 => Yes, 0 => No, VD: 0,1,0,1,1,0,1,1'),
            'napthe_vina' => array('text', 'Card Vina list [10k - 20k - 30k - 50k - 100k - 200k - 300k -500k]| 1 => Yes, 0 => No, VD: 0,1,0,1,1,0,1,1'),
        ),
        'Money' => array
        (
            '_MONEY' => array('title', 'Money:'),
            'config_itemvpoint' => array('text', 'Frontend upload dir|Frontend path for uploads'),
            'config_buyzen' => array('text', 'Frontend upload dir|Frontend path for uploads'),
            'trans_itemvp' => array('text', 'Frontend upload dir|Frontend path for uploads'),
            'config_vp2gc' => array('text', 'Frontend upload dir|Frontend path for uploads'),
            'config_gc2vp' => array('text', 'Frontend upload dir|Frontend path for uploads'),
            'config_gc2wc' => array('text', 'Frontend upload dir|Frontend path for uploads'),
            'config_gc2wcp' => array('text', 'Frontend upload dir|Frontend path for uploads'),
            'config_gc2gob' => array('text', 'Frontend upload dir|Frontend path for uploads'),
        )

    );

    // System help
    $help = hook('sysconf/helper', array
    (
        'http_script_dir' => 'Necessary in order to embed in websites scripts determined where the administrative panel for the correct CN obtaining the necessary resources, such as smilies or images.',
    ));

    // Static rewrite path
    $cfg = mcache_get('config');


    // Save cached copy
    mcache_set('config', $cfg);

    // ------------------
    $sub = REQ('sub', "GETPOST");
    if (!isset($options_list[$sub])) {
        $sub = 'general';
    }

    // Save data
    if (request_type('POST')) {
        cn_dsi_check();

        $post_cfg = $_POST['config'];
        $opt_result = getoption('#%site');
        $by_default = $options_list[$sub];

        // Detect selfpath
        $SN = dirname($_SERVER['SCRIPT_NAME']);
        $script_path = "http://" . $_SERVER['SERVER_NAME'] . (($SN == '/' || $SN == '\\') ? '' : $SN);

        // Fill empty fields
        if (empty($post_cfg['http_script_dir'])) {
            $post_cfg['http_script_dir'] = $script_path;
        }
        if (empty($post_cfg['uploads_dir'])) {
            //$post_cfg['uploads_dir'] =  cn_path_construct( SERVDIR , 'uploads');
            $post_cfg['uploads_dir'] = cn_path_construct(($SN == DIRECTORY_SEPARATOR) ? SERVDIR : substr(SERVDIR, 0, -strlen($SN)), 'uploads');
        }
        if (empty($post_cfg['uploads_ext'])) {
            $post_cfg['uploads_ext'] = $script_path . '/uploads';
        }


        // all
        foreach ($by_default as $id => $var) {
            if ($var[0] == 'text' || $var[0] == 'select') {
                $opt_result[$id] = $post_cfg[$id];
            } elseif ($var[0] == 'int') {
                $opt_result[$id] = intval($post_cfg[$id]);
            } elseif ($var[0] == 'password') {
                if ($post_cfg[$id]) {
                    $opt_result[$id] = $post_cfg[$id];
                } else {
                    $opt_result[$id] = getoption($id);
                }
            } elseif ($var[0] == 'Y/N') {
                $opt_result[$id] = (isset($post_cfg[$id]) && 'Y' == $post_cfg[$id]) ? 1 : 0;
            } elseif (isset($post_cfg[$id])) {
                unset($opt_result[$id]);
            }
        }

        setoption('#%site', $opt_result);

        cn_load_skin();
        cn_throw_message('Saved successfully');
    }

    $options = $options_list[$sub];
    foreach ($options as $id => $vo) {
        $options[$id]['var'] = getoption($id);

        $text_parths = explode('|', $vo[1], 2);
        $title = isset($text_parths[0]) ? $text_parths[0] : '';
        $desc = isset($text_parths[1]) ? $text_parths[1] : '';
        $options[$id]['title'] = $title;
        $options[$id]['desc'] = $desc;
        $options[$id]['help'] = isset($help[$id]) ? $help[$id] : '';

        unset($options[$id][1]);
    }

    if (REQ('message', 'GET') == 'saved') {
        unset($_GET['message']);
        cn_throw_message('Successfully saved');
    }


    cn_assign('options, sub, options_list', $options, $sub, $options_list);


    echoheader('-@com_board/style.css', "System configurations");
    //echo exec_tpl('header');
    echo exec_tpl('com_board/sysconf');
    echofooter();
}

// =====================================================================================================================
// Since 2.0: Personal options
function board_personal()
{
    $member = member_get();

    // Additional fields for user
    $personal_more = array
    (
        'site' => array('name' => 'Personal site', 'type' => 'text'),
        'about' => array('name' => 'About me', 'type' => 'textarea'),
    );

    if (request_type('POST')) {
        cn_dsi_check();

        $clause = '';
        $any_changes = FALSE;
        list($editpassword, $confirmpassword, $editnickname, $edithidemail, $more) = GET('editpassword, confirmpassword, editnickname, edithidemail, more', 'POST');
        $avatar_file = isset($_FILES['avatar_file']) ? $_FILES['avatar_file'] : null;

        if ((!isset($member['nick']) && !empty($editnickname)) || (isset($member['nick']) && $member['nick'] !== $editnickname)) {
            $any_changes = TRUE;
        }

        if ((!isset($member['e-hide']) && !empty($edithidemail)) || (isset($member['e-hide']) && $member['e-hide'] !== $edithidemail)) {
            $any_changes = TRUE;
        }

        if ($editpassword) {
            if ($editpassword === $confirmpassword) {
                $any_changes = TRUE;
                db_user_update($member['name'], "pass=" . SHA256_hash($editpassword));

                // Send mail if password changed
                $notification = cn_replace_text(cn_get_template('password_change', 'mail'), '%username%, %password%', $member['name'], $editpassword);

                $clause = "Check your email.";
                cn_send_mail($member['email'], i18n("Password was changed"), $notification);
            } else {
                cn_throw_message('Password and confirm do not match', 'e');
            }
        }

        // Update additional fields for personal data
        $o_more = base64_encode(serialize($member['more']));
        $n_more = base64_encode(serialize($more));

        if ($o_more !== $n_more) {
            $any_changes = TRUE;
            db_user_update($member['name'], "more=" . $n_more);
        }
        // Set an avatar
        if (!empty($avatar_file) && $avatar_file['error'] == 0) {
            $uploads_dir = getoption('uploads_dir');
            if ($uploads_dir) {
                $file_name = 'avatar_' . $member['name'] . '_' . $avatar_file['name'];
                if (isset($member['avatar']) && $member['avatar'] != $file_name) {
                    // remove old avatar
                    unlink($uploads_dir . $member['avatar']);
                }
                move_uploaded_file($avatar_file['tmp_name'], $uploads_dir . $file_name);
                db_user_update($member['name'], "avatar=" . $file_name);
                $any_changes = TRUE;
            }
        }
        // Has changes?
        if ($any_changes) {
            db_user_update($member['name'], "nick=$editnickname", "e-hide=$edithidemail");

            // Update & Get member from DB
            mcache_set('#member', NULL);
            $member = member_get();

            cn_throw_message("User info updated! $clause");
        } else {
            cn_throw_message("No changes", 'w');
        }
    }

    $grp = getoption('#grp');
    $acl_desc = $grp[$member['acl']]['N'];

    // Get info from personal data
    foreach ($personal_more as $name => $pdata) {
        if (isset($member['more'][$name])) {
            $personal_more[$name]['value'] = $member['more'][$name];
        }
    }

    cn_assign('member, acl_write_news, acl_desc, personal_more', $member, test('Can'), $acl_desc, $personal_more);
    echoheader('-@dashboard/style.css', "Personal options");
    echo exec_tpl('dashboard/personal');
    echofooter();
}

// =====================================================================================================================
// Since 2.0: Template management

function board_ischaracter()
{
    list($template, $sub) = GET('template, sub', 'GPG'); //bat
    //$all_temp_basic  = array();
    // Default templates
    //$list = cn_template_list();
    //$acx = cn_template_list();

    if (!$sub) {
        $sub = 'class';
    }

    $acv = cn_get_template_byarr($sub); // get array $sub
    // User changes
    //$tuser = getoption('#templates');
    $acx = getoption('#temp_basic');// get all

    $options_list = array
    (
        // Section
        'class' => array
        (
            // Option -> 0=Type(text [Y/N] int select), 1=Title|Description, [2=Optional values]

            'class_dw_1:class_dw_1_name' => array('int,text', 'Mã nhân vật DarkWizard cấp 1|Tên hiển thị nhân vật DarkWizard cấp 1'),
            //'class_dw_1_name'			=> array('text', 'Tên hiển thị nhân vật DarkWizard cấp 1|example: http://yoursite.com/cutenews'),
            'class_dw_2:class_dw_2_name' => array('int,text', 'Mã nhân vật DarkWizard cấp 2|Tên hiển thị nhân vật DarkWizard cấp 2'),
            //'class_dw_2_name'			=> array('text', 'Tên hiển thị nhân vật DarkWizard cấp 2'),
            'class_dw_3:class_dw_3_name:end' => array('int,text', 'Mã nhân vật DarkWizard cấp 3|Tên hiển thị nhân vật DarkWizard cấp 3'),
            //'class_dw_3_name'           => array('text', 'Tên hiển thị nhân vật DarkWizard cấp 3'),

            'class_dk_1:class_dk_1_name' => array('int,text', 'Mã nhân vật DarkKnight cấp 1|with this option, admin panel uses utf-8 charset'),
            //'class_dk_1_name'			=> array('text', "Tên hiển thị nhân vật DarkKnight cấp 1|E.g. &aring to &amp;aring;"),
            'class_dk_2:class_dk_2_name' => array('int,text', 'Mã nhân vật DarkKnight cấp 2|Tên hiển thị nhân vật DarkKnight cấp 2'),
            //'class_dk_2_name'			=> array('text', 'Tên hiển thị nhân vật DarkKnight cấp 2'),
            'class_dk_3:class_dk_3_name:end' => array('int,text', 'Mã nhân vật DarkKnight cấp 3|Tên hiển thị nhân vật DarkKnight cấp 3'),
            //'class_dk_3_name'           => array('text', 'Tên hiển thị nhân vật DarkKnight cấp 3|in minutes; eg. : 180 = +3 hours; -120 = -2 hours'),

            'class_elf_1:class_elf_1_name' => array('int,text', 'Mã nhân vật ELF cấp 1|Tên hiển thị nhân vật ELF cấp 1'),
            //'class_elf_1_name'			=> array('text', 'Tên hiển thị nhân vật ELF cấp 1|Hide smiles path'),
            'class_elf_2:class_elf_2_name' => array('int,text', 'Mã nhân vật ELF cấp 2|Tên hiển thị nhân vật ELF cấp 2'),
            //'class_elf_2_name'			=> array('text', 'Tên hiển thị nhân vật ELF cấp 2'),
            'class_elf_3:class_elf_3_name:end' => array('int,text', 'Mã nhân vật ELF cấp 3|Tên hiển thị nhân vật ELF cấp 3'),
            //'class_elf_3_name'			=> array('text', 'Tên hiển thị nhân vật ELF cấp 3|stronger authenticate (by changing this setting, you will be logged out)'),

            'class_mg_1:class_mg_1_name' => array('int,text', 'Mã nhân vật MG cấp 1|Tên hiển thị nhân vật MG cấp 1'),
            //'class_mg_1_name'			=> array('text', 'Tên hiển thị nhân vật MG cấp 1|Used by file manager. Enter by comma without space'),
            'class_mg_2:class_mg_2_name:end' => array('int,text', 'Mã nhân vật MG cấp 2|Tên hiển thị nhân vật MG cấp 2'),
            //'class_mg_2_name'			=> array('text', 'Tên hiển thị nhân vật MG cấp 2'),

            'class_dl_1:class_dl_1_name' => array('int,text', 'Mã nhân vật DarkLord cấp 1|Tên hiển thị nhân vật DarkLord cấp 1'),
            //'class_dl_1_name'			=> array('text', 'Tên hiển thị nhân vật DarkLord cấp 1|If 0, client online disabled'),
            'class_dl_2:class_dl_2_name:end' => array('int,text', 'Mã nhân vật DarkLord cấp 2|Tên hiển thị nhân vật DarkLord cấp 2'),
            //'class_dl_2_name'			=> array('text', 'Tên hiển thị nhân vật DarkLord cấp 2'),

            'class_sum_1:class_sum_1_name' => array('int,text', 'Mã nhân vật Summoner cấp 1|Larger than the specified size is considered a big'),
            //'class_sum_1_name'			=> array('text', 'Tên hiển thị nhân vật Summoner cấp 1|Real path on server'),
            'class_sum_2:class_sum_2_name' => array('int,text', 'Mã nhân vật Summoner cấp 2|Tên hiển thị nhân vật Summoner cấp 2'),
            //'class_sum_2_name'			=> array('text', 'Tên hiển thị nhân vật Summoner cấp 2|Frontend path for uploads'),
            'class_sum_3:class_sum_3_name:end' => array('int,text', 'Mã nhân vật Summoner cấp 3|Tên hiển thị nhân vật Summoner cấp 3'),
            //'class_sum_3_name'			=> array('text', 'Tên hiển thị nhân vật Summoner cấp 3|Frontend path for uploads'),

            'class_rf_1:class_rf_1_name' => array('int,text', 'Mã nhân vật RageFighter cấp 1|Tên hiển thị nhân vật RageFighter cấp 1'),
            //'class_rf_1_name'			=> array('text', 'Tên hiển thị nhân vật RageFighter cấp 1|Frontend path for uploads'),
            'class_rf_2:class_rf_2_name:end' => array('int,text', 'Mã nhân vật RageFighter cấp 2|Tên hiển thị nhân vật RageFighter cấp 2'),
            // 'class_rf_2_name'           => array('text', 'Tên hiển thị nhân vật RageFighter cấp 2|Frontend path for uploads'),
        ),

        'reset' => array
        (
            'reset_cap_1:level_cap_1:zen_cap_1:chao_cap_1:cre_cap_1:blue_cap_1:point_cap_1:ml_cap_1:time_reset_next_1' => array('int,text', 'Mã nhân vật DarkWizard cấp 1|Tên hiển thị nhân vật DarkWizard cấp 1'),
            'reset_cap_2:level_cap_2:zen_cap_2:chao_cap_2:cre_cap_2:blue_cap_2:point_cap_2:ml_cap_2:time_reset_next_2' => array('int,text', 'Mã nhân vật DarkWizard cấp 1|Tên hiển thị nhân vật DarkWizard cấp 1'),
            'reset_cap_3:level_cap_3:zen_cap_3:chao_cap_3:cre_cap_3:blue_cap_3:point_cap_3:ml_cap_3:time_reset_next_3' => array('int,text', 'Mã nhân vật DarkWizard cấp 1|Tên hiển thị nhân vật DarkWizard cấp 1'),
            'reset_cap_4:level_cap_4:zen_cap_4:chao_cap_4:cre_cap_4:blue_cap_4:point_cap_4:ml_cap_4:time_reset_next_4' => array('int,text', 'Mã nhân vật DarkWizard cấp 1|Tên hiển thị nhân vật DarkWizard cấp 1'),
            'reset_cap_5:level_cap_5:zen_cap_5:chao_cap_5:cre_cap_5:blue_cap_5:point_cap_5:ml_cap_5:time_reset_next_5:end' => array('int,text', 'Mã nhân vật DarkWizard cấp 1|Tên hiển thị nhân vật DarkWizard cấp 1'),
            'reset_cap_6:level_cap_6:zen_cap_6:chao_cap_6:cre_cap_6:blue_cap_6:point_cap_6:ml_cap_6:time_reset_next_6' => array('int,text', 'Mã nhân vật DarkWizard cấp 1|Tên hiển thị nhân vật DarkWizard cấp 1'),
            'reset_cap_7:level_cap_7:zen_cap_7:chao_cap_7:cre_cap_7:blue_cap_7:point_cap_7:ml_cap_7:time_reset_next_7' => array('int,text', 'Mã nhân vật DarkWizard cấp 1|Tên hiển thị nhân vật DarkWizard cấp 1'),
            'reset_cap_8:level_cap_8:zen_cap_8:chao_cap_8:cre_cap_8:blue_cap_8:point_cap_8:ml_cap_8:time_reset_next_8' => array('int,text', 'Mã nhân vật DarkWizard cấp 1|Tên hiển thị nhân vật DarkWizard cấp 1'),
            'reset_cap_9:level_cap_9:zen_cap_9:chao_cap_9:cre_cap_9:blue_cap_9:point_cap_9:ml_cap_9:time_reset_next_9' => array('int,text', 'Mã nhân vật DarkWizard cấp 1|Tên hiển thị nhân vật DarkWizard cấp 1'),
            'reset_cap_10:level_cap_10:zen_cap_10:chao_cap_10:cre_cap_10:blue_cap_10:point_cap_10:ml_cap_10:time_reset_next_10:end' => array('int,text', 'Mã nhân vật DarkWizard cấp 1|Tên hiển thị nhân vật DarkWizard cấp 1'),
            'reset_cap_11:level_cap_11:zen_cap_11:chao_cap_11:cre_cap_11:blue_cap_11:point_cap_11:ml_cap_11:time_reset_next_11' => array('int,text', 'Mã nhân vật DarkWizard cấp 1|Tên hiển thị nhân vật DarkWizard cấp 1'),
            'reset_cap_12:level_cap_12:zen_cap_12:chao_cap_12:cre_cap_12:blue_cap_12:point_cap_12:ml_cap_12:time_reset_next_12' => array('int,text', 'Mã nhân vật DarkWizard cấp 1|Tên hiển thị nhân vật DarkWizard cấp 1'),
            'reset_cap_13:level_cap_13:zen_cap_13:chao_cap_13:cre_cap_13:blue_cap_13:point_cap_13:ml_cap_13:time_reset_next_13' => array('int,text', 'Mã nhân vật DarkWizard cấp 1|Tên hiển thị nhân vật DarkWizard cấp 1'),
            'reset_cap_14:level_cap_14:zen_cap_14:chao_cap_14:cre_cap_14:blue_cap_14:point_cap_14:ml_cap_14:time_reset_next_14' => array('int,text', 'Mã nhân vật DarkWizard cấp 1|Tên hiển thị nhân vật DarkWizard cấp 1'),
            'reset_cap_15:level_cap_15:zen_cap_15:chao_cap_15:cre_cap_15:blue_cap_15:point_cap_15:ml_cap_15:time_reset_next_15:end' => array('int,text', 'Mã nhân vật DarkWizard cấp 1|Tên hiển thị nhân vật DarkWizard cấp 1'),
            'reset_cap_16:level_cap_16:zen_cap_16:chao_cap_16:cre_cap_16:blue_cap_16:point_cap_16:ml_cap_16:time_reset_next_16' => array('int,text', 'Mã nhân vật DarkWizard cấp 1|Tên hiển thị nhân vật DarkWizard cấp 1'),
            'reset_cap_17:level_cap_17:zen_cap_17:chao_cap_17:cre_cap_17:blue_cap_17:point_cap_17:ml_cap_17:time_reset_next_17' => array('int,text', 'Mã nhân vật DarkWizard cấp 1|Tên hiển thị nhân vật DarkWizard cấp 1'),
            'reset_cap_18:level_cap_18:zen_cap_18:chao_cap_18:cre_cap_18:blue_cap_18:point_cap_18:ml_cap_18:time_reset_next_18' => array('int,text', 'Mã nhân vật DarkWizard cấp 1|Tên hiển thị nhân vật DarkWizard cấp 1'),
            'reset_cap_19:level_cap_19:zen_cap_19:chao_cap_19:cre_cap_19:blue_cap_19:point_cap_19:ml_cap_19:time_reset_next_19' => array('int,text', 'Mã nhân vật DarkWizard cấp 1|Tên hiển thị nhân vật DarkWizard cấp 1'),
            'reset_cap_20:level_cap_20:zen_cap_20:chao_cap_20:cre_cap_20:blue_cap_20:point_cap_20:ml_cap_20:time_reset_next_20:end' => array('int,text', 'Mã nhân vật DarkWizard cấp 1|Tên hiển thị nhân vật DarkWizard cấp 1'),
        ),

        'reset_vip' => array(
            'reset_cap_1:level_cap_1_vip:vpoint_cap_1_vip:gcoin_cap_1_vip:point_cap_1_vip:ml_cap_1_vip' => array('int,text', 'help|help'),
            'reset_cap_2:level_cap_2_vip:vpoint_cap_2_vip:gcoin_cap_2_vip:point_cap_2_vip:ml_cap_2_vip' => array('int,text', 'help|help'),
            'reset_cap_3:level_cap_3_vip:vpoint_cap_3_vip:gcoin_cap_3_vip:point_cap_3_vip:ml_cap_3_vip' => array('int,text', 'help|help'),
            'reset_cap_4:level_cap_4_vip:vpoint_cap_4_vip:gcoin_cap_4_vip:point_cap_4_vip:ml_cap_4_vip' => array('int,text', 'help|help'),
            'reset_cap_5:level_cap_5_vip:vpoint_cap_5_vip:gcoin_cap_5_vip:point_cap_5_vip:ml_cap_5_vip:end' => array('int,text', 'help|help'),
            'reset_cap_6:level_cap_6_vip:vpoint_cap_6_vip:gcoin_cap_6_vip:point_cap_6_vip:ml_cap_6_vip' => array('int,text', 'help|help'),
            'reset_cap_7:level_cap_7_vip:vpoint_cap_7_vip:gcoin_cap_7_vip:point_cap_7_vip:ml_cap_7_vip' => array('int,text', 'help|help'),
            'reset_cap_8:level_cap_8_vip:vpoint_cap_8_vip:gcoin_cap_8_vip:point_cap_8_vip:ml_cap_8_vip' => array('int,text', 'help|help'),
            'reset_cap_9:level_cap_9_vip:vpoint_cap_9_vip:gcoin_cap_9_vip:point_cap_9_vip:ml_cap_9_vip' => array('int,text', 'help|help'),
            'reset_cap_10:level_cap_10_vip:vpoint_cap_10_vip:gcoin_cap_10_vip:point_cap_10_vip:ml_cap_10_vip:end' => array('int,text', 'help|help'),
            'reset_cap_11:level_cap_11_vip:vpoint_cap_11_vip:gcoin_cap_11_vip:point_cap_11_vip:ml_cap_11_vip' => array('int,text', 'help|help'),
            'reset_cap_12:level_cap_12_vip:vpoint_cap_12_vip:gcoin_cap_12_vip:point_cap_12_vip:ml_cap_12_vip' => array('int,text', 'help|help'),
            'reset_cap_13:level_cap_13_vip:vpoint_cap_13_vip:gcoin_cap_13_vip:point_cap_13_vip:ml_cap_13_vip' => array('int,text', 'help|help'),
            'reset_cap_14:level_cap_14_vip:vpoint_cap_14_vip:gcoin_cap_14_vip:point_cap_14_vip:ml_cap_14_vip' => array('int,text', 'help|help'),
            'reset_cap_15:level_cap_15_vip:vpoint_cap_15_vip:gcoin_cap_15_vip:point_cap_15_vip:ml_cap_15_vip:end' => array('int,text', 'help|help'),
            'reset_cap_16:level_cap_16_vip:vpoint_cap_16_vip:gcoin_cap_16_vip:point_cap_16_vip:ml_cap_16_vip' => array('int,text', 'help|help'),
            'reset_cap_17:level_cap_17_vip:vpoint_cap_17_vip:gcoin_cap_17_vip:point_cap_17_vip:ml_cap_17_vip' => array('int,text', 'help|help'),
            'reset_cap_18:level_cap_18_vip:vpoint_cap_18_vip:gcoin_cap_18_vip:point_cap_18_vip:ml_cap_18_vip' => array('int,text', 'help|help'),
            'reset_cap_19:level_cap_19_vip:vpoint_cap_19_vip:gcoin_cap_19_vip:point_cap_19_vip:ml_cap_19_vip' => array('int,text', 'help|help'),
            'reset_cap_20:level_cap_20_vip:vpoint_cap_20_vip:gcoin_cap_20_vip:point_cap_20_vip:ml_cap_20_vip:end' => array('int,text', 'help|help'),
        ),
        'thue_point' => array(
            'thuepoint_point1:thuepoint_vpoint1:thuepoint_relife1' => array('int,text', 'help|help'),
            'thuepoint_point2:thuepoint_vpoint2:thuepoint_relife2' => array('int,text', 'help|help'),
            'thuepoint_point3:thuepoint_vpoint3:thuepoint_relife3' => array('int,text', 'help|help'),
            'thuepoint_point4:thuepoint_vpoint4:thuepoint_relife4' => array('int,text', 'help|help'),
            'thuepoint_point5:thuepoint_vpoint5:thuepoint_relife5:end' => array('int,text', 'help|help'),
            'thuepoint_point6:thuepoint_vpoint6:thuepoint_relife6' => array('int,text', 'help|help'),
            'thuepoint_point7:thuepoint_vpoint7:thuepoint_relife7' => array('int,text', 'help|help'),
            'thuepoint_point8:thuepoint_vpoint8:thuepoint_relife8' => array('int,text', 'help|help'),
            'thuepoint_point9:thuepoint_vpoint9:thuepoint_relife9' => array('int,text', 'help|help'),
            'thuepoint_point10:thuepoint_vpoint10:thuepoint_relife10:end' => array('int,text', 'help|help'),
        ),
        'hotro_tanthu' => array(
            'cap1_reset_min:cap1_reset_max:cap1_relife_min:cap1_relife_max:cap1_levelgiam' => array('int,text', 'help|help'),
            'cap2_reset_min:cap2_reset_max:cap2_relife_min:cap2_relife_max:cap2_levelgiam' => array('int,text', 'help|help'),
            'cap3_reset_min:cap3_reset_max:cap3_relife_min:cap3_relife_max:cap3_levelgiam' => array('int,text', 'help|help'),
            'cap4_reset_min:cap4_reset_max:cap4_relife_min:cap4_relife_max:cap4_levelgiam' => array('int,text', 'help|help'),
            'cap5_reset_min:cap5_reset_max:cap5_relife_min:cap5_relife_max:cap5_levelgiam:end' => array('int,text', 'help|help'),
        ),
        'pk' => array(
            'pk_zen_vpoint:pk_zen' => array('int,text', 'help|help'),
            'pk_zen_vpoint:pk_vpoint:end' => array('int,text', 'help|help'),
        ),
        'gioihan_rs' => array(
            'VpointReset0_GioiHan0:VpointReset1_GioiHan0:VpointReset2_GioiHan0:GioiHanReset1' => array('int,text', 'help|help'),
            'VpointReset0_GioiHan1:VpointReset1_GioiHan1:VpointReset2_GioiHan1:GioiHanReset2' => array('int,text', 'help|help'),
            'VpointReset0_GioiHan2:VpointReset1_GioiHan2:VpointReset2_GioiHan2:GioiHanReset3' => array('int,text', 'help|help'),
            'VpointReset0_GioiHan3:VpointReset1_GioiHan3:VpointReset2_GioiHan3:GioiHanReset4' => array('int,text', 'help|help'),
            'VpointReset0_GioiHan4:VpointReset1_GioiHan4:VpointReset2_GioiHan4:GioiHanReset5' => array('int,text', 'help|help'),
            'VpointReset0_GioiHan5:VpointReset1_GioiHan5:VpointReset2_GioiHan5:GioiHanReset6:end' => array('int,text', 'help|help'),
        ),
        'relife' => array(
            'rl_reset_relife1:rl_point_relife1:rl_ml_relife1' => array('int,text', 'help|help'),
            'rl_reset_relife2:rl_point_relife2:rl_ml_relife2' => array('int,text', 'help|help'),
            'rl_reset_relife3:rl_point_relife3:rl_ml_relife3' => array('int,text', 'help|help'),
            'rl_reset_relife4:rl_point_relife4:rl_ml_relife4' => array('int,text', 'help|help'),
            'rl_reset_relife5:rl_point_relife5:rl_ml_relife5:end' => array('int,text', 'help|help'),
            'rl_reset_relife6:rl_point_relife6:rl_ml_relife6' => array('int,text', 'help|help'),
            'rl_reset_relife7:rl_point_relife7:rl_ml_relife7' => array('int,text', 'help|help'),
            'rl_reset_relife8:rl_point_relife8:rl_ml_relife8' => array('int,text', 'help|help'),
            'rl_reset_relife9:rl_point_relife9:rl_ml_relife9' => array('int,text', 'help|help'),
            'rl_reset_relife10:rl_point_relife10:rl_ml_relife10:end' => array('int,text', 'help|help'),
        ),
        'uythac_reset' => array(
            'reset_cap_1:point_uythac_rs_cap_1:zen_cap_1:chao_cap_1:cre_cap_1:blue_cap_1' => array('int,text', 'help|help'),
            'reset_cap_2:point_uythac_rs_cap_2:zen_cap_2:chao_cap_2:cre_cap_2:blue_cap_2' => array('int,text', 'help|help'),
            'reset_cap_3:point_uythac_rs_cap_3:zen_cap_3:chao_cap_3:cre_cap_3:blue_cap_3' => array('int,text', 'help|help'),
            'reset_cap_4:point_uythac_rs_cap_4:zen_cap_4:chao_cap_4:cre_cap_4:blue_cap_4' => array('int,text', 'help|help'),
            'reset_cap_5:point_uythac_rs_cap_5:zen_cap_5:chao_cap_5:cre_cap_5:blue_cap_5:end' => array('int,text', 'help|help'),
            'reset_cap_6:point_uythac_rs_cap_6:zen_cap_6:chao_cap_6:cre_cap_6:blue_cap_6' => array('int,text', 'help|help'),
            'reset_cap_7:point_uythac_rs_cap_7:zen_cap_7:chao_cap_7:cre_cap_7:blue_cap_7' => array('int,text', 'help|help'),
            'reset_cap_8:point_uythac_rs_cap_8:zen_cap_8:chao_cap_8:cre_cap_8:blue_cap_8' => array('int,text', 'help|help'),
            'reset_cap_9:point_uythac_rs_cap_9:zen_cap_9:chao_cap_9:cre_cap_9:blue_cap_9' => array('int,text', 'help|help'),
            'reset_cap_10:point_uythac_rs_cap_10:zen_cap_10:chao_cap_10:cre_cap_10:blue_cap_10:end' => array('int,text', 'help|help'),
            'reset_cap_11:point_uythac_rs_cap_11:zen_cap_11:chao_cap_11:cre_cap_11:blue_cap_11' => array('int,text', 'help|help'),
            'reset_cap_12:point_uythac_rs_cap_12:zen_cap_12:chao_cap_12:cre_cap_12:blue_cap_12' => array('int,text', 'help|help'),
            'reset_cap_13:point_uythac_rs_cap_13:zen_cap_13:chao_cap_13:cre_cap_13:blue_cap_13' => array('int,text', 'help|help'),
            'reset_cap_14:point_uythac_rs_cap_14:zen_cap_14:chao_cap_14:cre_cap_14:blue_cap_14' => array('int,text', 'help|help'),
            'reset_cap_15:point_uythac_rs_cap_15:zen_cap_15:chao_cap_15:cre_cap_15:blue_cap_15:end' => array('int,text', 'help|help'),
            'reset_cap_16:point_uythac_rs_cap_16:zen_cap_16:chao_cap_16:cre_cap_16:blue_cap_16' => array('int,text', 'help|help'),
            'reset_cap_17:point_uythac_rs_cap_17:zen_cap_17:chao_cap_17:cre_cap_17:blue_cap_17' => array('int,text', 'help|help'),
            'reset_cap_18:point_uythac_rs_cap_18:zen_cap_18:chao_cap_18:cre_cap_18:blue_cap_18' => array('int,text', 'help|help'),
            'reset_cap_19:point_uythac_rs_cap_19:zen_cap_19:chao_cap_19:cre_cap_19:blue_cap_19' => array('int,text', 'help|help'),
            'reset_cap_20:point_uythac_rs_cap_20:zen_cap_20:chao_cap_20:cre_cap_20:blue_cap_20:end' => array('int,text', 'help|help'),
        ),
        'uythac_resetvip' => array(
            'reset_cap_1:point_uythac_rsvip_cap_1:vpoint_cap_1_vip:end' => array('int,text', 'help|help'),
            'reset_cap_2:point_uythac_rsvip_cap_2:vpoint_cap_2_vip' => array('int,text', 'help|help'),
            'reset_cap_3:point_uythac_rsvip_cap_3:vpoint_cap_3_vip' => array('int,text', 'help|help'),
            'reset_cap_4:point_uythac_rsvip_cap_4:vpoint_cap_4_vip' => array('int,text', 'help|help'),
            'reset_cap_5:point_uythac_rsvip_cap_5:vpoint_cap_5_vip:end' => array('int,text', 'help|help'),
            'reset_cap_6:point_uythac_rsvip_cap_6:vpoint_cap_6_vip' => array('int,text', 'help|help'),
            'reset_cap_7:point_uythac_rsvip_cap_7:vpoint_cap_7_vip' => array('int,text', 'help|help'),
            'reset_cap_8:point_uythac_rsvip_cap_8:vpoint_cap_8_vip' => array('int,text', 'help|help'),
            'reset_cap_9:point_uythac_rsvip_cap_9:vpoint_cap_9_vip' => array('int,text', 'help|help'),
            'reset_cap_10:point_uythac_rsvip_cap_10:vpoint_cap_10_vip:end' => array('int,text', 'help|help'),
            'reset_cap_11:point_uythac_rsvip_cap_11:vpoint_cap_11_vip' => array('int,text', 'help|help'),
            'reset_cap_12:point_uythac_rsvip_cap_12:vpoint_cap_12_vip' => array('int,text', 'help|help'),
            'reset_cap_13:point_uythac_rsvip_cap_13:vpoint_cap_13_vip' => array('int,text', 'help|help'),
            'reset_cap_14:point_uythac_rsvip_cap_14:vpoint_cap_14_vip' => array('int,text', 'help|help'),
            'reset_cap_15:point_uythac_rsvip_cap_15:vpoint_cap_15_vip:end' => array('int,text', 'help|help'),
            'reset_cap_16:point_uythac_rsvip_cap_16:vpoint_cap_16_vip' => array('int,text', 'help|help'),
            'reset_cap_17:point_uythac_rsvip_cap_17:vpoint_cap_17_vip' => array('int,text', 'help|help'),
            'reset_cap_18:point_uythac_rsvip_cap_18:vpoint_cap_18_vip' => array('int,text', 'help|help'),
            'reset_cap_19:point_uythac_rsvip_cap_19:vpoint_cap_19_vip' => array('int,text', 'help|help'),
            'reset_cap_20:point_uythac_rsvip_cap_20:vpoint_cap_20_vip:end' => array('int,text', 'help|help'),
        ),
    );

    $options = $options_list[$sub];

    //$acv = cn_get_template_byarr($template);

    foreach ($acx as $id => $subtpl) {
        $all_header_conf[$id]['id'] = $id;
        $all_header_conf[$id]['name'] = ucwords(str_replace('_', ' ', trim($id)));
    }

    //foreach ($acv as $id => $subtpl){
    //echo "1134 CACHES $id => $subtpl <br>";
    //}

    switch ($sub) {
        case 'class':
            break;

        case 'reset':
            break;
    }
    if ($sub === 'class') {

        /*
            $dem = 0;
            //$dm = 0;
            $set_arr = array();
            $sa_name_1 ='';$sa_ma_1 ='';
            foreach($acv as $as => $sa){
                $dem++;
                
                if($dem % 2 === 0){
                    $set_arr[$sa_ma_1] = $sa_name_1;
                    $set_arr[$as] = $sa;
                    
                    //$set_arr[$dm]['ma_class'] = $sa_ma_1;
                    //$set_arr[$dm]['gt_ma_class'] = $sa_name_1;
                    //$set_arr[$dm]['name_class'] = $as;
                    //$set_arr[$dm]['gt_name_class'] = $sa;
                    $sa_name_1 ='';$sa_ma_1 ='';
                    //$dm++;
                }
                else{
                    $sa_ma_1 = $as;
                    $sa_name_1 = $sa;
                }
            }
        */
        //$options = $options_list[$sub];
        foreach ($options as $id => $vo) {
            $get_id = explode(':', $id);
            $id_1 = $get_id[0];
            $id_2 = $get_id[1];
            $id_3 = isset($get_id[2]) ? $get_id[2] : false;

            $options[$id]['id_1'] = $id_1;
            $options[$id]['id_2'] = $id_2;
            $options[$id]['id_1_val'] = $acv[$id_1];//$set_arr[$id_1];
            $options[$id]['id_2_val'] = $acv[$id_2];//$set_arr[$id_2];

            $text_parths = explode('|', $vo[1], 2);
            $title = isset($text_parths[0]) ? $text_parths[0] : '';
            $desc = isset($text_parths[1]) ? $text_parths[1] : '';
            $options[$id]['title'] = $title;
            $options[$id]['desc'] = $desc;
            $options[$id]['end'] = $id_3;

            //unset($options[$id][1]);
        }

    } elseif ($sub === 'reset') {

        foreach ($options as $id => $vo) {
            $get_id = explode(':', $id);
            $id_1 = $get_id[0];
            $id_2 = $get_id[1];
            $id_3 = $get_id[2];
            $id_4 = $get_id[3];
            $id_5 = $get_id[4];
            $id_6 = $get_id[5];
            $id_7 = $get_id[6];
            $id_8 = $get_id[7];
            $id_9 = $get_id[8];
            $id_10 = isset($get_id[9]) ? $get_id[9] : false;

            $options[$id]['id_1'] = $id_1;
            $options[$id]['id_2'] = $id_2;
            $options[$id]['id_3'] = $id_3;
            $options[$id]['id_4'] = $id_4;
            $options[$id]['id_5'] = $id_5;
            $options[$id]['id_6'] = $id_6;
            $options[$id]['id_7'] = $id_7;
            $options[$id]['id_8'] = $id_8;
            $options[$id]['id_9'] = $id_9;

            $options[$id]['id_1_val'] = $acv[$id_1];
            $options[$id]['id_2_val'] = $acv[$id_2];
            $options[$id]['id_3_val'] = $acv[$id_3];
            $options[$id]['id_4_val'] = $acv[$id_4];
            $options[$id]['id_5_val'] = $acv[$id_5];
            $options[$id]['id_6_val'] = $acv[$id_6];
            $options[$id]['id_7_val'] = $acv[$id_7];
            $options[$id]['id_8_val'] = $acv[$id_8];
            $options[$id]['id_9_val'] = $acv[$id_9];

            //user_config_reset=1 //web
//cap_reset_max=8 // web

//log_reset=0 // web
//reset_cap_0=0
            ///$text_parths=explode('|', $vo[1], 2);        
            //$title=isset($text_parths[0])?$text_parths[0]:'';
            //$desc =isset($text_parths[1])?$text_parths[1]:'';
            //$options[$id]['title'] = $title;
            //$options[$id]['desc']  = $desc;
            $options[$id]['reset_cap_0'] = 0;
            $options[$id]['end'] = $id_10;
            //unset($options[$id][1]);
        }

    } elseif ($sub === 'reset_vip') {
        foreach ($options as $id => $vo) {
            $get_id = explode(':', $id);

            $id_1 = $get_id[0];
            $id_2 = $get_id[1];
            $id_3 = $get_id[2];
            $id_4 = $get_id[3];
            $id_5 = $get_id[4];
            $id_6 = $get_id[5];
            $id_7 = isset($get_id[6]) ? $get_id[6] : false;

            //$options[$id]['id_1'] = $id_1;	
            $options[$id]['id_2'] = $id_2;
            $options[$id]['id_3'] = $id_3;
            $options[$id]['id_4'] = $id_4;
            $options[$id]['id_5'] = $id_5;
            $options[$id]['id_6'] = $id_6;

            $options[$id]['id_1_val'] = $acx['reset'][$id_1];
            $options[$id]['id_2_val'] = $acv[$id_2];
            $options[$id]['id_3_val'] = $acv[$id_3];
            //$options[$id]['id_4_val'] = $acv[$id_4];	
            //$options[$id]['id_4_val'] = (int) $acv[$id_3]*0.8;// 80% Vpoint
            $options[$id]['id_5_val'] = $acv[$id_5];
            $options[$id]['id_6_val'] = $acv[$id_6];

            //user_config_reset=1 //web

            ///$text_parths=explode('|', $vo[1], 2);        
            //$title=isset($text_parths[0])?$text_parths[0]:'';
            //$desc =isset($text_parths[1])?$text_parths[1]:'';
            //$options[$id]['title'] = $title;
            //$options[$id]['desc']  = $desc;
            //$options[$id]['reset_cap_0']  = 0;
            $options[$id]['end'] = $id_7;
            //unset($options[$id][1]);
        }

    } elseif ($sub === 'thue_point') {
        foreach ($options as $id => $vo) {
            $get_id = explode(':', $id);

            $id_1 = $get_id[0];
            $id_2 = $get_id[1];
            $id_3 = $get_id[2];        //$id_4 = $get_id[3];		
            $id_4 = isset($get_id[3]) ? $get_id[3] : false;

            $options[$id]['id_1'] = $id_1;
            $options[$id]['id_2'] = $id_2;
            $options[$id]['id_3'] = $id_3;
            $options[$id]['id_1_val'] = $acv[$id_1];
            $options[$id]['id_2_val'] = $acv[$id_2];
            $options[$id]['id_3_val'] = $acv[$id_3];


            ///$text_parths=explode('|', $vo[1], 2);        
            //$title=isset($text_parths[0])?$text_parths[0]:'';
            //$desc =isset($text_parths[1])?$text_parths[1]:'';
            //$options[$id]['title'] = $title;
            //$options[$id]['desc']  = $desc;
            //$options[$id]['reset_cap_0']  = 0;
            $options[$id]['end'] = $id_4;
            //unset($options[$id][1]);
        }

    } elseif ($sub === 'hotro_tanthu') {
        foreach ($options as $id => $vo) {
            $get_id = explode(':', $id);

            $id_1 = $get_id[0];
            $id_2 = $get_id[1];
            $id_3 = $get_id[2];
            $id_4 = $get_id[3];
            $id_5 = $get_id[4];
            $id_6 = isset($get_id[5]) ? $get_id[5] : false;

            $options[$id]['id_1'] = $id_1;
            $options[$id]['id_2'] = $id_2;
            $options[$id]['id_3'] = $id_3;
            $options[$id]['id_4'] = $id_4;
            $options[$id]['id_5'] = $id_5;
            $options[$id]['id_1_val'] = $acv[$id_1];
            $options[$id]['id_2_val'] = $acv[$id_2];
            $options[$id]['id_3_val'] = $acv[$id_3];
            $options[$id]['id_4_val'] = $acv[$id_4];
            $options[$id]['id_5_val'] = $acv[$id_5];


            ///$text_parths=explode('|', $vo[1], 2);        
            //$title=isset($text_parths[0])?$text_parths[0]:'';
            //$desc =isset($text_parths[1])?$text_parths[1]:'';
            //$options[$id]['title'] = $title;
            //$options[$id]['desc']  = $desc;
            //$options[$id]['reset_cap_0']  = 0;
            $options[$id]['end'] = $id_6;
            //unset($options[$id][1]);
        }

    } elseif ($sub === 'pk') {
        foreach ($options as $id => $vo) {
            $get_id = explode(':', $id);

            $id_1 = $get_id[0];
            $id_2 = $get_id[1];
            //$id_3 = $get_id[2];		$id_4 = $get_id[3];		$id_5 = $get_id[4];		
            $id_3 = isset($get_id[2]) ? $get_id[2] : false;

            $options[$id]['id_1'] = $id_1;
            $options[$id]['id_2'] = $id_2;
            //$options[$id]['id_3'] = $id_3;		$options[$id]['id_4'] = $id_4;		$options[$id]['id_5'] = $id_5;
            $options[$id]['id_1_val'] = $acv[$id_1];
            $options[$id]['id_2_val'] = $acv[$id_2];
            //$options[$id]['id_3_val'] = $acv[$id_3];		$options[$id]['id_4_val'] = $acv[$id_4]; 	$options[$id]['id_5_val'] = $acv[$id_5];

//            echo "9222 ------------------- " . $id_2 . $acv[$id_2] . "<br>";
            ///$text_parths=explode('|', $vo[1], 2);        
            //$title=isset($text_parths[0])?$text_parths[0]:'';
            //$desc =isset($text_parths[1])?$text_parths[1]:'';
            //$options[$id]['title'] = $title;
            //$options[$id]['desc']  = $desc;
            //$options[$id]['reset_cap_0']  = 0;
            $options[$id]['end'] = $id_3;
            //unset($options[$id][1]);
        }

    } elseif ($sub === 'gioihan_rs') {
        foreach ($options as $id => $vo) {
            $get_id = explode(':', $id);

            $id_1 = $get_id[0];
            $id_2 = $get_id[1];
            $id_3 = $get_id[2];
            $id_4 = $get_id[3];        //$id_5 = $get_id[4];		
            $id_5 = isset($get_id[4]) ? $get_id[4] : false;

            $options[$id]['id_1'] = $id_1;
            $options[$id]['id_2'] = $id_2;
            $options[$id]['id_3'] = $id_3;
            $options[$id]['id_4'] = $id_4;        //$options[$id]['id_5'] = $id_5;

            $options[$id]['id_1_val'] = $acv[$id_1];
            $options[$id]['id_2_val'] = $acv[$id_2];
            $options[$id]['id_3_val'] = $acv[$id_3];
            $options[$id]['id_4_val'] = $acv[$id_4];    //$options[$id]['id_5_val'] = $acv[$id_5];

            ///$text_parths=explode('|', $vo[1], 2);        
            //$title=isset($text_parths[0])?$text_parths[0]:'';
            //$desc =isset($text_parths[1])?$text_parths[1]:'';
            //$options[$id]['title'] = $title;
            //$options[$id]['desc']  = $desc;

            //$options[$id]['ResetInDay1']  = $id_5;

            $options[$id]['end'] = $id_5;
        }

        $array_gh_loai1 = array
        (
            "gioihanrs_top10" => 10,
            "gioihanrs_top20" => 11,
            "gioihanrs_top30" => 12,
            "gioihanrs_top40" => 14,
            "gioihanrs_top50" => 16,
            "gioihanrs_other" => 20,
        );
        $array_gh_loai2 = array('ResetInDay1:ResetInDay2' => '10:30');

        foreach ($array_gh_loai1 as $e => $vl)
            $gh_loai1[$e]['top_gh'] = $acv[$e];

        foreach ($array_gh_loai2 as $key => $vl) {
            $abc_ = explode(":", $key);
            $gh_loai2[0]['id_day1'] = $abc_[0];
            $gh_loai2[0]['day1'] = $acv[$abc_[0]];
            $gh_loai2[0]['id_day2'] = $abc_[1];
            $gh_loai2[0]['day2'] = $acv[$abc_[1]];
        }
    } elseif ($sub === 'relife') {
        foreach ($options as $id => $vo) {
            $get_id = explode(':', $id);

            $id_1 = $get_id[0];
            $id_2 = $get_id[1];
            $id_3 = $get_id[2];        //$id_4 = $get_id[3];		//$id_5 = $get_id[4];		
            $id_4 = isset($get_id[3]) ? $get_id[3] : false;

            $options[$id]['id_1'] = $id_1;
            $options[$id]['id_2'] = $id_2;
            $options[$id]['id_3'] = $id_3;        //$options[$id]['id_4'] = $id_4;		//$options[$id]['id_5'] = $id_5;

            $options[$id]['id_1_val'] = $acv[$id_1];
            $options[$id]['id_2_val'] = $acv[$id_2];
            $options[$id]['id_3_val'] = $acv[$id_3];        //$options[$id]['id_4_val'] = $acv[$id_4]; 	//$options[$id]['id_5_val'] = $acv[$id_5];

            ///$text_parths=explode('|', $vo[1], 2);        
            //$title=isset($text_parths[0])?$text_parths[0]:'';
            //$desc =isset($text_parths[1])?$text_parths[1]:'';
            //$options[$id]['title'] = $title;
            //$options[$id]['desc']  = $desc;

            //$options[$id]['ResetInDay1']  = $id_5;

            $options[$id]['end'] = $id_4;
        }
    } elseif ($sub === 'uythac_resetvip') {

        foreach ($options as $id => $vo) {
            $get_id = explode(':', $id);
            $id_1 = $get_id[0];
            $id_2 = $get_id[1];
            $id_3 = $get_id[2];
            $id_4 = isset($get_id[3]) ? $get_id[3] : false;

            $options[$id]['id_2'] = $id_2;        //$options[$id]['id_2'] = $id_2;		$options[$id]['id_3'] = $id_3;
            //$options[$id]['id_4'] = $id_4;		$options[$id]['id_5'] = $id_5;		$options[$id]['id_6'] = $id_6;	
            //$options[$id]['id_7'] = $id_7;		$options[$id]['id_8'] = $id_8;		$options[$id]['id_9'] = $id_9;		

            $options[$id]['id_1_val'] = $acx['reset'][$id_1];
            $options[$id]['id_2_val'] = $acv[$id_2];
            $options[$id]['id_3_val'] = $acx['reset_vip'][$id_3];
            $options[$id]['id_4_val'] = (int)$acx['reset_vip'][$id_3] * 0.8;


            $options[$id]['end'] = $id_4;
        }

    } elseif ($sub === 'uythac_reset') {

        foreach ($options as $id => $vo) {
            $get_id = explode(':', $id);
            $id_1 = $get_id[0];
            $id_2 = $get_id[1];
            $id_3 = $get_id[2];
            $id_4 = $get_id[3];
            $id_5 = $get_id[4];
            $id_6 = $get_id[5];
            $id_7 = isset($get_id[6]) ? $get_id[6] : false;

            $options[$id]['id_2'] = $id_2;        //$options[$id]['id_2'] = $id_2;		$options[$id]['id_3'] = $id_3;
            //$options[$id]['id_4'] = $id_4;		$options[$id]['id_5'] = $id_5;		$options[$id]['id_6'] = $id_6;	
            //$options[$id]['id_7'] = $id_7;		$options[$id]['id_8'] = $id_8;		$options[$id]['id_9'] = $id_9;		

            $options[$id]['id_1_val'] = $acx['reset'][$id_1];
            $options[$id]['id_2_val'] = $acv[$id_2];
            $options[$id]['id_3_val'] = $acx['reset'][$id_3];
            $options[$id]['id_4_val'] = $acx['reset'][$id_4];
            $options[$id]['id_5_val'] = $acx['reset'][$id_5];
            $options[$id]['id_6_val'] = $acx['reset'][$id_6];

            $options[$id]['end'] = $id_7;
        }

    }

    //echo "556 => ".$set_arr['class_dw_1']."=>". $set_arr['class_dw_1_name'] ."<br>";

    //echo "556 => ".$set_arr['class_rf_2']."=>". $set_arr['class_rf_2_name'] ."<br>";

    //foreach($set_arr as $aa => $d){
    //echo "556 $aa => \$d=> ".$d[0]."=>". $d[1] ."<br>";
    //echo "556 =>".$d['ma_class']."=>". $d['gt_ma_class'] ."=>".$d['name_class']."=>". $d['gt_name_class'] ."<br>";
    //echo "556 $aa =><br>";
    //foreach($d as $a => $dd){
    //echo "565 $a => ".$dd." => \$dd['name_class'].<br>";
    //}
    //exit();
    //}
    //exit();
    //------------------------------------------------------------------
    if (!$template) {
        $template = 'config_class_';
    }

    //exit();
    // Basic template name and fetch data (user/system)

    /*
         $rewrite => array
            (
                'class_dw_1'         => array('Y/N', "Use rewrite engine"),
                'class_dw_1_name'       => array('label', ".htaccess real path|Automatic, not modify by user"),
                'class_dw_2'         => array('text', "Real path to your layout file|e.g. /home/userdir/www/layout.php"),
                'class_dw_2_name'         => array('text', "Rewrite prefix|e.g. /news/"),
                'rw_use_shorten'    => array('Y/N', "Disable .html at end of urls"),
            ),
        
        */

    /*
    // Copy default subtemplate, if not exists
    if (!isset($tuser[$template])) 
    {
        foreach ($list[$template] as $_sub => $_var) 
        {
            $tuser[$template][$_sub] = $_var;
        }
    }

    // Get all templates, mark it as user/system
    foreach ($tuser as $id => $vs) 
    {
        $all_templates[ $id ] = 'User';
    }
    
    foreach ($list as $id => $vs) 
    {
        $all_templates[ $id ] = 'Sys';
    }

    
    $all_templates  = array();
    $template_parts = array();

    
    $odata = array();
    foreach ($tuser[$template] as $id => $subtpl)
    {
        if (isset($def_ids[$id]))
        {
            $_name = $def_ids[$id];
        }
        else
        {
            $_name = ucfirst(str_replace('_', ' ', $id));
        }

        $odata[$id] = $subtpl;
        $template_parts[$id] = $_name;
    }

    reset($odata);

    // Get subtmpl by default
    if (!$sub) 
    {
        $sub = key($odata);
    }
*/
    // ------------------------------------------------------------------------------------ ACTIONS --------------------
    // save template?
    if (request_type('POST')) {
        cn_dsi_check();

        // ------------------------
        //if (REQ('select', 'POST'))
        {
            //cn_relocation(cn_url_modify(array('reset'), 'mod='.REQ('mod'), 'opt='.REQ('opt'), 'sub='.$sub));
        }
        // ------------------------
        //elseif (REQ('create') || REQ('template_name'))
        {
            //$template_name = trim(strtolower(preg_replace('/[^a-z0-9_]/i', '-', REQ('template_name'))));

            //if (!$template_name)
            {
                //cn_throw_message('Enter correct template name', 'e');
            }
            //elseif (isset($all_templates[$template_name]))
            {
                //cn_throw_message('Template already exists', 'e');
            }
            //else
            {
                //$tuser[$template][$sub] = REQ('save_template_text', 'POST');

                //setoption("#templates/$template_name", $tuser[$template]);
                //msg_info('Template ['.$template_name.'] created', cn_url_modify(array('reset'), 'mod='.REQ('mod'), 'opt='.REQ('opt'), 'template='.$template_name));
            }
        }
        // ------------------------
        //elseif (REQ('delete'))
        {
            //if ($all_templates[ $template ] === 'Sys')
            {
                //cn_throw_message("Template '$template' is system template, can't delete", 'e');
            }
            //else
            {
                //unset($tuser[$template]);
                //setoption('#templates', $tuser);

                //msg_info('Template ['.$template.'] deleted!', cn_url_modify(array('reset'), 'mod='.REQ('mod'), 'opt='.REQ('opt')));
            }
        }
        // ------------------------
        //elseif (REQ('reset'))
        {
            //  if ($all_templates[ $template ] === 'Sys')
            {
                //    unset($tuser[$template]);
                //  setoption("#templates", $tuser);

                //cn_throw_message("Template reset to default");
            }
            //else
            {
                //cn_throw_message("Template is user template, can't reset", 'e');
            }
        }
        // ------------------------
        //else
        {
            //$tuser[$template][$sub] = REQ('save_template_text', 'POST');

            $post_cfg = $_POST['config'];
            /*
                foreach ($post_cfg as $s => $f){
                    $post_cfg_[$s]['id'] = $s;
                    $post_cfg_[$s]['name'] = $f;
                    //echo "1271 ==>". $s . "=> $f <br>";
                }
                
                //foreach ($post_cfg_ as $s => $f)
                //echo "1275 ==>".$post_cfg_[$s]['id'] . "<===>".$post_cfg_[$s]['name'] . "<=  <br>";
                
                
                
                foreach ($acx[$sub] as $id => $val){
                //foreach ($post_cfg as $id => $val){
                    //if(isset($acx[$sub][$id])){
                    if(isset($post_cfg_[$id]['id'])){
                         $acx[$sub][$id] = $post_cfg_[$id]['name'];
                    }				
                    //if(isset($post_cfg_[$id]['name'])){
                        // unset($acx[$sub][$id]);
                         //$acx[$sub][$id] = $val;
                    //}
                    echo "686 => \$post_cfg[\$val]==>$post_cfg[$id]==>". $id . "=> $val <br>";
                }
    */
//            foreach ($post_cfg as $s => $f) {
                //$post_cfg_[$s]['id'] = $s;
                //$post_cfg_[$s]['name'] = $f;
//                echo "1271 POST ==>" . $s . "=> $f <br>";
//            }

            //foreach ($post_cfg_ as $s => $f)
            //echo "1275 ==>".$post_cfg_[$s]['id'] . "<===>".$post_cfg_[$s]['name'] . "<=  <br>";


            foreach ($acx[$sub] as $id => $val) {
                //foreach ($post_cfg as $id => $val){
                //if(isset($acx[$sub][$id])){
                if (isset($post_cfg[$id])) {
                    $acx[$sub][$id] = $post_cfg[$id];
                }
                //if(isset($post_cfg[$id])){
                //unset($acv[$id]);
                //$acx[$sub][$id] = $val;
                //}
                //echo "686 => \$post_cfg[\$val]==>$post_cfg[$id]==>". $acx[$sub][$id] . "==>". $id . "=> $val <br>";
            }

            //foreach ($acv as $id => $val)
            //echo "717 SAU => ==>". $id . "=> $val <br>";
            //exit();
            //echo " 1272 ==>". $post_cfg['class_dw_1'] ."=>".$post_cfg['class_dw_1_name']. "<br>";
            //echo " 1273 ==>".$acv[$post_cfg] ."=>".$post_cfg['class_dw_1_name']. "<br>";
            //echo " 1257 ==>". REQ('class_dw_1','class_dw_1_name', 'POST'). "<br>";

            //$opt_re['templates'] =	$opt_result;
            //setoption("#temp_basic", $acx);
            setoption("#temp_basic", $acx);
            cn_throw_message('Template saved successfully');
            //cn_relocation(cn_url_modify(array('reset'), 'mod='.REQ('mod'), 'opt='.REQ('opt'), 'sub='.$sub));
        }
    }
    //$get_arr_sub = cn_get_template_byarr($sub);

    if (isset($_POST['template'])) {
        //$_GET['template'] = $_POST['template'];
    }

    if (isset($_POST['sub'])) {
        //$_GET['sub'] = $_POST['sub'];
    }

    $get_gh_loai1 = isset($gh_loai1) ? $gh_loai1 : array();
    $get_gh_loai2 = isset($gh_loai2) ? $gh_loai2 : array();
    $options = isset($options) ? $options : array();
    $all_header_conf = isset($all_header_conf) ? $all_header_conf : array();


    // user can't delete system template, only modify
    //$can_delete = $all_templates[$template] == 'Sys' ? FALSE : TRUE;

    // get template text (may be modified before)
    //$template_text = isset($tuser[$template][$sub]) ? $tuser[$template][$sub] : (isset($list[$template][$sub]) ? $list[$template][$sub] : '');

    // ----
    //cn_assign('template_parts, all_templates, template_text, template, sub, can_delete, all_header_conf, set_arr', $template_parts, $acv, $template_text, $template, $sub, $can_delete, $all_header_conf, $options);
    cn_assign('gh_loai1, gh_loai2, sub, all_header_conf, set_arr', $get_gh_loai1, $get_gh_loai2, $sub, $all_header_conf, $options);
    echoheader('-@com_board/style.css', "Config Character");
    echo exec_tpl('com_board/classchar');
    echofooter();
    /*
    $all_header_conf = array();
    $all_templates  = array();
    $template_parts = array();

    $def_ids = array
    (
        'congfig_class' => 'Class',
        'congfig_reset' => 'Reset',
        'congfig_resetvip' => 'Reset Vip',
        'congfig_gioihan' => 'Gioi han Reset',
        'congfig_hotrotanthu' => 'Ho tro tan thu',
        'congfig_online' => 'Uy thac Online',
        'congfig_offline' => 'Uy thac Offline',
        'congfig_uythac_reset' => 'Uy thac Reset',
        'congfig_uythac_resetvip' => 'Uy thac Reset Vip',
        'full' => 'Full Story',
        'comment' => 'Comment',
        'form' => 'Add comment form',
        'prev_next' => 'News Pagination',
        'comments_prev_next' => 'Comments Pagination',
    );

    list($template, $sub) = GET('template, sub', 'GPG');

    // Default templates
    $list = cn_template_list();

    // User changes
    $tuser = getoption('#temp_basic');
    //list($tuser) = getoption('#temp_basic');

    // Basic template name and fetch data (user/system)
    if (!$template) 
    {
        $template = 'config_class';
    }
    
   
    
    // Copy default subtemplate, if not exists
    if (!isset($tuser[$template])) 
    {
        foreach ($list[$template] as $_sub => $_var) 
        {
            $tuser[$template][$_sub] = $_var;
        }
    }

    // Get all templates, mark it as user/system
    foreach ($tuser as $id => $vs) 
    {
        $all_templates[ $id ] = 'User';
    }
    
    foreach ($all_templates as $id => $vs) 
    {
        echo "576 mu_b $id => $vs <br>";
    }
    
    
    foreach ($list as $id => $vs) 
    {
        $all_templates[ $id ] = 'Sys';
    }
    
    foreach ($all_templates as $id => $vs) 
    {
        echo "582 mu_b $id => $vs <br>";
    }
    
    
/*
    $odata = array();
    foreach ($tuser[$template] as $id => $subtpl)
    {
        if (isset($def_ids[$id]))
        {
            $_name = $def_ids[$id];
        }
        else
        {
            $_name = ucfirst(str_replace('_', ' ', $id));
        }

        $odata[$id] = $subtpl;
        $template_parts[$id] = $_name;
    }

    reset($odata);
*/
    /*
        // Get subtmpl by default
        if (!$sub) 
        {
            $sub = key($odata);
        }
    
        // ------------------------------------------------------------------------------------ ACTIONS --------------------
        // save template?
        if (request_type('POST'))
        {
            cn_dsi_check();
    
            // ------------------------
            if (REQ('select', 'POST'))
            {
                cn_relocation(cn_url_modify(array('reset'), 'mod='.REQ('mod'), 'opt='.REQ('opt'), 'template='.$template));
            }
            // ------------------------
            elseif (REQ('create') || REQ('template_name'))
            {
                $template_name = trim(strtolower(preg_replace('/[^a-z0-9_]/i', '-', REQ('template_name'))));
    
                if (!$template_name)
                {
                    cn_throw_message('Enter correct template name', 'e');
                }
                elseif (isset($all_templates[$template_name]))
                {
                    cn_throw_message('Template already exists', 'e');
                }
                else
                {
                    $tuser[$template][$sub] = REQ('save_template_text', 'POST');
    
                    setoption("#templates/$template_name", $tuser[$template]);
                    msg_info('Template ['.$template_name.'] created', cn_url_modify(array('reset'), 'mod='.REQ('mod'), 'opt='.REQ('opt'), 'template='.$template_name));
                }
            }
            // ------------------------
            elseif (REQ('delete'))
            {
                if ($all_templates[ $template ] === 'Sys')
                {
                    cn_throw_message("Template '$template' is system template, can't delete", 'e');
                }
                else
                {
                    unset($tuser[$template]);
                    setoption('#templates', $tuser);
    
                    msg_info('Template ['.$template.'] deleted!', cn_url_modify(array('reset'), 'mod='.REQ('mod'), 'opt='.REQ('opt')));
                }
            }
            // ------------------------
            elseif (REQ('reset'))
            {
                if ($all_templates[ $template ] === 'Sys')
                {
                    unset($tuser[$template]);
                    setoption("#templates", $tuser);
    
                    cn_throw_message("Template reset to default");
                }
                else
                {
                    cn_throw_message("Template is user template, can't reset", 'e');
                }
            }
            // ------------------------
            else
            {
                $tuser[$template][$sub] = REQ('save_template_text', 'POST');
                setoption("#templates", $tuser);
    
                cn_throw_message('Template saved successfully');
            }
        }
    
        if (isset($_POST['template']))  
        {
            $_GET['template'] = $_POST['template'];
        }
        
        if (isset($_POST['sub']))       
        {
            $_GET['sub'] = $_POST['sub'];
        }
    
        // user can't delete system template, only modify
        $can_delete = $all_templates[$template] == 'Sys' ? FALSE : TRUE;
    
        // get template text (may be modified before)
        $template_text = isset($tuser[$template][$sub]) ? $tuser[$template][$sub] : (isset($list[$template][$sub]) ? $list[$template][$sub] : '');
    
        // ----
        cn_assign('template_parts, all_templates, template_text, template, sub, can_delete, tuser', $template_parts, $all_templates, $template_text, $template, $sub, $can_delete, $all_header_conf);
        echoheader('-@com_board/style.css', "Templates"); echo exec_tpl('com_board/template'); echofooter();
        */
}

// =====================================================================================================================
// Since 2.0: Users management

function board_userman()
{
    list($section, $st, $delete) = GET('section, st, delete');
    list($user_name, $user_pass, $user_confirm, $user_nick, $user_email, $user_acl) = GET('user_name, user_pass, user_confirm, user_nick, user_email, user_acl');

    $per_page = 100;
    $section = intval($section);
    $st = intval($st);
    $grp = getoption('#grp');
    $is_edit = FALSE; //visability Edit btton

    if (request_type('POST')) {
        cn_dsi_check();

        // Do Delete
        if ($delete) {
            db_user_delete($user_name);
            cn_throw_message('User [' . cn_htmlspecialchars($user_name) . '] deleted');

            $user_name = $user_nick = $user_email = $user_acl = '';
        } // Add-Edit
        else {
            $user_data = db_user_by_name($user_name);

            if (REQ('edit')) {
                if ($user_data === null) {
                    $is_edit = FALSE;
                    cn_throw_message("User not exists", 'e');
                }
            } // Add user
            else {
                // Check user
                if (!$user_name)
                    cn_throw_message("Fill required field: username", 'e');

                if (!$user_pass)
                    cn_throw_message("Fill required field: password", 'e');

                if ($user_data !== null)
                    cn_throw_message("Username already exist", 'e');

                if ($user_confirm != $user_pass)
                    cn_throw_message('Confirm not match', 'e');
                // Invalid email
                if (!check_email($user_email)) {
                    cn_throw_message("Email not valid", "e");
                } // Duplicate email
                elseif (db_user_by($user_email, 'email')) {
                    cn_throw_message('Email already exists', 'e');
                }
            }

            // Must be correct all
            if (cn_get_message('e', 'c') == 0) {
                // Edit user [user exist]
                if (REQ('edit')) {
                    db_user_update($user_name, "email=$user_email", "nick=$user_nick", "acl=$user_acl");

                    // Update exists (change password)
                    if ($user_pass) {
                        if ($user_confirm == $user_pass) {
                            db_user_update($user_name, 'pass=' . SHA256_hash($user_pass));
                            cn_throw_message('User password / user info updated');
                        } else {
                            cn_throw_message('Confirm not match', 'e');
                        }
                    } else {
                        cn_throw_message('User info updated');
                    }
                } // Add user
                else {
                    if ($user_id = db_user_add($user_name, $user_acl)) {
                        if (db_user_update($user_name, "email=$user_email", "nick=$user_nick", 'pass=' . SHA256_hash($user_pass), "acl=$user_acl")) {
                            $is_edit = TRUE;
                            cn_throw_message("User created successfully");
                        } else
                            cn_throw_message("Can't update user", 'e');
                    } else {
                        cn_throw_message("User not added: internal error", 'e');
                    }
                }
            }
        }
    }

    // ----
    $userlist = array();
    //$userlist = db_user_list();

    // Get users by ACL from index
    if ($section) {
        foreach ($userlist as $id => $dt)
            if ($dt['acl'] != $section)
                unset($userlist[$id]);
    }

    // Sort by latest & make pagination
    krsort($userlist);
    $userlist = array_slice($userlist, $st, $per_page, TRUE);

    // Fetch estimate user list
    foreach ($userlist as $id => $data) {
        $user = db_user_by($id);
        $userlist[$id] = $user;
    }
    /*
    // Retrieve info about user
    if ($user = db_user_by_name($user_name))
    {
        $user_nick  =isset($user['nick'])? $user['nick']:'';
        $user_email =isset($user['email'])? $user['email']:'';
        $user_acl   =isset($user['acl'])? $user['acl']:'';
        $is_edit=TRUE;
    }
    */
    // By default for section
    if (!$user_acl) $user_acl = $section;

    cn_assign('users, section, st, per_page, grp', $userlist, $section, $st, $per_page, $grp);
    cn_assign('user_name, user_nick, user_email, user_acl, is_edit', $user_name, $user_nick, $user_email, $user_acl, $is_edit);

    echoheader('-@dashboard/style.css', "Users manager");
    echo exec_tpl('dashboard/users');
    echofooter();
}


// =====================================================================================================================
// Since 2.0: Integration Wizard tool
/*
function board_iserverz()
{
    $sub = REQ('sub');

	
	/*
    $categories = cn_get_categories();

    $rss                    = getoption('#rss');
    $rss_encoding           =isset($rss['encoding'])? $rss['encoding']:'UTF-8';
    $rss_news_include_url   =isset($rss['news_include_url'])? $rss['news_include_url']:'';
    $rss_title              =isset($rss['title'])? $rss['title']:'';
    $rss_language           =isset($rss['language'])? $rss['language']:'en-us';

    // Default: view
    if ($rss_encoding == '') 
    {
        $rss_encoding = 'UTF-8';
    }
    if ($rss_language == '') 
    {
        $rss_language = 'en-us';
    }

    // Check submit
    if (request_type('POST'))
    {
        cn_dsi_check();

        // Save new configuration
        if ($sub == 'rss')
        {
            $rss['encoding']         = $rss_encoding         = REQ('rss_encoding');
            $rss['news_include_url'] = $rss_news_include_url = REQ('rss_news_include_url');
            $rss['title']            = $rss_title            = REQ('rss_title');
            $rss['language']         = $rss_language         = REQ('rss_language');

            // Default: save
            if ($rss_encoding == '') 
            {
                $rss_encoding = 'UTF-8';
            }
            if ($rss_language == '') 
            {
                $rss_language = 'en-us';
            }

            setoption('#rss', $rss);
        }
    }

    $all_tpls  = array();
    $listsys   = cn_template_list();
    $templates = getoption('#templates');

    // Get all templates
    foreach ($listsys as $id => $_t) 
    {
        $all_tpls[ $id ] = $id;
    }
    foreach ($templates as $id => $_t) 
    {
        $all_tpls[ $id ] = $id;
    }

    cn_assign('sub, categories, all_tpls', $sub, $categories, $all_tpls);
    cn_assign('rss_news_include_url, rss_encoding, rss_language, rss_title', $rss_news_include_url, $rss_encoding, $rss_language, $rss_title);

    echoheader('-@dashboard/style.css', 'Integration Wizard'); echo exec_tpl('dashboard/intwiz'); echofooter();
	
    echoheader('-@com_board/style.css', 'Integration Wizard'); echo exec_tpl('com_board/inserver'); echofooter();
	
}
*/
// =====================================================================================================================
// Since 2.0: Ban by IP and name
/*
function board_iswebshop()
{
	/*
    $ipban = getoption('#ipban');
    if (!is_array($ipban)) 
    {
        $ipban = array();
    }

    // Submit new IP
    if (request_type('POST'))
    {
        cn_dsi_check();

        $ip = trim(REQ('add_ip'));
        if(!empty($ip))
        {
            // Times blocked : Expire time
            $ipban[$ip] = array(0, 0);

            setoption('#ipban', $ipban);
            cn_throw_message('IP or name mask ['.$ip.'] add/replaced');
        }
        else
        {
            cn_throw_message('IP Address must be filled','w');
        }
    }
    // Unblock IP
    elseif ($ip = REQ('unblock'))
    {
        cn_dsi_check();

        if (isset($ipban[$ip]))
        {
            unset($ipban[$ip]);
        }
        
        setoption('#ipban', $ipban);
    }

    cn_assign('list', $ipban);
    echoheader('-@com_board/style.css', 'Block IP'); echo exec_tpl('com_board/ipban'); echofooter();
}
*/
// =====================================================================================================================
// Since 2.0: User logs

function board_logs()
{
    $log_read = $logs = array();
    $sub = REQ('sub', "GETPOST");

    $skip = FALSE;
    $num = 30;
    $isfin = FALSE;
    $n = 0;

    $st = REQ('st');

    $section = REQ('section');

    $all_character = [
        'changeclass' => ['name' => 'Đổi giới tính'],
        'changename' => ['name' => 'Đổi tên nhân vật'],
        'relife' => ['name' => 'Tái Sinh'],
        'resets' => ['name' => 'Reset'],
        'resetsvip' => ['name' => 'Reset Vip'],
        'rsuythac' => ['name' => 'Reset Ủy Thác'],
        'rsuythacvip' => ['name' => 'Reset Ủy Thác Vip'],
        'uythacoffline' => ['name' => 'Ủy Thác Offline'],
        'uythaconline' => ['name' => 'Ủy Thác Online'],
        'chuyenvpoint' => ['name' => 'Chuyển V.Point'],
        'online_market' => ['name' => 'Chợ trực tuyến'],
        'xosokienthiet' => ['name' => 'Xổ số kiến thiết'],
        'pcpoint2vpoint' => ['name' => 'Đổi PCPoint'],
        'randomquest' => ['name' => 'Nhiệm vụ ngẫu nhiên'],
        'ruatoi' => ['name' => 'Rửa tội'],
        'thuepoint' => ['name' => 'Thuê điểm'],
        'rspoint' => ['name' => 'Tẩy điểm'],
        'vpoint2item' => ['name' => 'Mua Item V.Point'],
        'muazen' => ['name' => 'Mua Zen bằng V.Point'],
        'item2vpoint' => ['name' => 'Item V.Point --> V.Point'],
        'vpoint2gcoin' => ['name' => 'V.Point --> Gcoin'],
        'gcoin2vpoint' => ['name' => 'Gcoin --> V.Point']
        //'orther' => ['name' => ''],
        //'orther' => ['name' => '']
    ];

    $all_shop = [
        'acient' => ['name' => 'Cửa Hàng Đồ Thần'],
        'eventticket' => ['name' => 'Cửa Hàng Vé'],
        'armor' => ['name' => 'Cửa Hàng Giáp trụ'],
        'crossbows' => ['name' => 'Cửa Hàng Cung - Nỏ'],
        'fenrir' => ['name' => 'Cửa Hàng Sói tinh'],
        'ringpendants' => ['name' => 'Cửa Hàng Trang sức'],
        'scepters' => ['name' => 'Cửa Hàng Quyền trượng'],
        'shields' => ['name' => 'Cửa Hàng Khiên'],
        'wings' => ['name' => 'Cửa Hàng Cánh'],
        'spears' => ['name' => 'Cửa Hàng Thương - Giáo'],
        'weapons' => ['name' => 'Cửa Hàng Đao - Kiếm'],
        'staffs' => ['name' => 'Cửa Hàng Gậy'],
        'orther' => ['name' => 'Cửa Hàng Khác']
    ];

    if ($section === 'character') {
        $logs_character = scan_dir(cn_path_construct(SERVDIR, 'log', 'modules', 'character'));
        $logs_shop = scan_dir(cn_path_construct(SERVDIR, 'log', 'modules', 'shop'));

        foreach ($logs_character as $lf) {
            if (preg_match('/log_(.*)\.txt/i', $lf, $c)) {
                if (isset($all_character[$c[1]])) {
                    $all_character[$c[1]]['log'] = 'log_' . $c[1];
                }
            }
        }

        foreach ($logs_shop as $lf) {
            if (preg_match('/log_(.*)\.txt/i', $lf, $c)) {
                if (isset($all_shop[$c[1]])) {
                    $all_shop[$c[1]]['log'] = 'log_' . $c[1];
                }
            }
        }
    }

    if ($st < 0) $st = 0;
//    if (!isset($st)) $st = 0;
    $over = $st + $num;

    // --- System section ---
    if (!$section) {

        $isdel = REQ('isdel');
        if (isset($isdel) && $isdel == 'islog-systems') {
            unlink(cn_path_construct(SERVDIR, 'log/system'). 'error_dump.log');
            cn_relocation(cn_url_modify(array('reset'), 'mod=' . REQ('mod'), 'opt=' . REQ('opt'), 'sub=' . $sub, 'section'));
        }

        $path = cn_path_construct(SERVDIR, 'log/system') . 'error_dump.log';
        if (file_exists($path)) {
            $r = fopen($path, 'r');
            if ($r) {
                do {
                    $n++;
                    $v = trim(fgets($r));
                    $tempLine = str_replace("\t", "|", $v);

//                    if ($v == '') {
//                        $skip = FALSE;
//                        continue;
//                    } elseif ($skip) continue;
//
//                    // Catch
//                    if (preg_match('/^\[(\d+)\] (.*)$/', $v, $c)) {
//                        $n++;
//
//                        // Skip some logs
//                        if ($n >= $st) {
//                            list(, $msg) = explode('|', $c[2], 2);
//                            $logs[] = array('msg' => $msg, 'date' => date('Y-m-d H:i:s', $c[1]));
//                        }
//
//                        $skip = TRUE;
//                    }

                    if (!$tempLine) break;
                    if ($n <= $st) continue;

                    $log_data = explode('|', $tempLine);

                    $log_read[] = array(
                        'status' => $log_data[0],
                        'time' => $log_data[1],
                        'name' => $log_data[2],
                        'ip' => $log_data[3],
                        'url' => $log_data[4],
                        'error' => $log_data[5]
                    );

                    if ($n > $over) break;
                } while (!feof($r));

                fclose($r);
            }
        }
    } // --- character log section ---
    elseif ($section === 'character') {

        list($dir, $action) = GET('dir, action', 'GPG');

        if (isset($action)) {
            unlink(cn_path_construct(SERVDIR, 'log/modules/' . $dir) . $action . '.txt');
            cn_relocation(cn_url_modify(array('reset'), 'mod=' . REQ('mod'), 'opt=' . REQ('opt'), 'sub=' . $sub, 'section=' . $section));
        }
//
//        // Save data
//        if (request_type('POST')) {
//        }
//
//        $options = $options_list[$sub];
//        foreach ($options as $id => $vo) {
//            $options[$id]['var'] = getoption($id);
//
//            $text_parths = explode('|', $vo[1], 2);
//            $title = isset($text_parths[0]) ? $text_parths[0] : '';
//            $desc = isset($text_parths[1]) ? $text_parths[1] : '';
//            $options[$id]['title'] = $title;
//            $options[$id]['desc'] = $desc;
//            $options[$id]['help'] = isset($help[$id]) ? $help[$id] : '';
//
//            unset($options[$id][1]);
//        }

        if ($dir && $sub) {
            if (!file_exists($ul = cn_path_construct(SERVDIR, 'log/modules/' . $dir) . $sub . '.txt')) {
                fclose(fopen($ul, 'w+'));
            }

            $r = fopen($ul, 'r');
            do {
                $n++;
                $v = trim(fgets($r));
                if (!$v) break;
                if ($n <= $st) continue;

                //list($date, $msg) = explode('|', $v, 2);

                //$logs[] = array('msg' => $msg, 'date' => date('Y-m-d H:i:s', intval($date)));
                $log_data = explode('|', $v);
                $tempBefore = explode('_', $log_data[2]);
                $tempAfter = explode('_', $log_data[3]);
                $gcoinDG = $tempBefore[0] - $tempAfter[0];
                $vpointDG = $tempBefore[1] - $tempAfter[1];

                $log_read[] = array(
                    'account' => $log_data[0],
                    'content' => $log_data[1],
                    'gc_vp_before' => number_format($tempBefore[0], 0, ',', '.') . ' - ' . number_format($tempBefore[1], 0, ',', '.'),
                    'gc_vp_after' => number_format($tempAfter[0], 0, ',', '.') . ' - ' . number_format($tempAfter[1], 0, ',', '.'),
                    'gc_vp_gd' => number_format($gcoinDG, 0, ',', '.') . ' - ' . number_format($vpointDG, 0, ',', '.'),
                    'time' => $log_data[4]
                );

                if ($n >= $over) break;
            } while (!feof($r));

            fclose($r);
        }
    }
    //disable pagination
    if (count($log_read) <= $st || count($log_read) <= $num) $isfin = true;

    cn_assign('log_read, st, num, isfin, section', $log_read, $st, $num, $isfin, $section);

    cn_assign('all_shop, all_character', $all_shop, $all_character);
    echoheader('-@com_board/style.css', 'System logs');
    echo exec_tpl('com_board/logs');
    echofooter();
}

// =====================================================================================================================
// Since 2.0: Additional fields

function board_statistics()
{
    $list = getoption('#more_list');

    $name = REQ('extr_name', "GET");
    $remove = REQ('remove');
    $type = $desc = $meta = $group = $req = '';

    // Apply the changes
    if (request_type('POST')) {
        cn_dsi_check();

        list($type, $name, $desc, $meta, $group, $req) = GET('type, name, desc, meta, group, req', 'POST');

        if ($remove) {
            unset($list[$name]);

            $type = $name = $desc = $meta = $group = $req = '';;
            setoption('#more_list', $list);
        } else {
            if (!preg_match('/^[a-z0-9_-]+$/i', $name))
                cn_throw_message('Name invalid - empty or bad chars', 'e');

            if ($group && !preg_match('/^[a-z0-9_-]+$/i', $group))
                cn_throw_message('Group field consists bad chars', 'e');

            $errors = cn_get_message('e', 'c');
            if (!$errors) {
                $list[$name] = array('grp' => $group, 'type' => $type, 'desc' => $desc, 'meta' => $meta, 'req' => $req);
                setoption('#more_list', $list);
                cn_throw_message("Field added successfully");
            }
        }
    }

    // Request fields
    if ($name && $list[$name]) {
        $desc = $list[$name]['desc'];
        $meta = $list[$name]['meta'];
        $type = $list[$name]['type'];
        $group = $list[$name]['grp'];
        $req = $list[$name]['req'];
    }

    cn_assign('list', $list);
    cn_assign('type, name, desc, meta, group, req', $type, $name, $desc, $meta, $group, $req);
    echoheader('-@dashboard/style.css', 'Additional fields');
    echo exec_tpl('dashboard/morefields');
    echofooter();
}

// =====================================================================================================================
// Since 2.0: Replace words

/*function board_group()
{
    global $_CN_access;

    $access_desc = array();
    $form_desc = array();

    $gn = file(SKIN . '/defaults/groups_names.tpl');
    foreach ($gn as $G) {
        if (($G = trim($G)) == '') {
            continue;
        }
        list($cc, $xgrp, $name_desc) = explode('|', $G, 3);

        if (!isset($access_desc[$xgrp])) {
            $access_desc[$xgrp] = array();
        }

        $access_desc[$xgrp][$cc] = $name_desc;
        $form_desc[$cc] = explode('|', $name_desc);
    }

    $ATR = array('C' => 'Configs', 'N' => 'New', 'M' => 'Comment', 'B' => 'Behavior');

    // Extension for access rights
    list($access_desc, $ATR) = hook('extend_acl_groups', array($access_desc, $ATR));

    $grp = array();
    $groups = getoption('#grp');
    list($group_name, $group_id, $group_grp, $ACL, $delete_group, $reset_group, $mode) = GET('group_name, group_id, group_grp, acl, delete_group, reset_group,mode');
    $is_add_edit = false;

    // -----------
    if (request_type('POST')) {
        cn_dsi_check();

        if (!$group_name) {
            cn_throw_message("Enter group name", 'e');
        } elseif ($mode == 'edit') {
            $is_edited = true;

            // Update exists or new group
            if ($group_id > 1) {
                if (!empty($groups[$group_id])) {
                    $is_edited = md5($groups[$group_id]['N'] . $groups[$group_id]['G'] . $groups[$group_id]['A']) != md5($group_name . $group_grp . (!empty($ACL) ? join(',', $ACL) : ''));
                }
                if ($is_edited) {
                    $groups[$group_id] = array
                    (
                        '#' => $groups[$group_id]['#'],
                        'N' => $group_name,
                        'G' => $group_grp,
                        'A' => (!empty($ACL) ? join(',', $ACL) : ''),
                    );
                }
            }

            if ($group_id == 1) {
                cn_throw_message("Can't update admin group", 'e');
            } elseif ($is_edited) {
                // Save to config
                setoption('#grp', $groups);
                cn_throw_message("Group updated");
            } else {
                cn_throw_message("No data for update", 'w');
            }
        } elseif ($mode == 'add') {
            $is_exists = FALSE;
            // Check group exists
            foreach ($groups as $id => $dt) {
                if ($dt['N'] == $group_name) {
                    $is_exists = TRUE;
                    break;
                }
            }

            $group_id = max(array_keys($groups)) + 1;
            // Update exists or new group
            if ($group_id > 1 && !$is_exists) {
                $groups[$group_id] = array
                (
                    '#' => '',
                    'N' => $group_name,
                    'G' => $group_grp,
                    'A' => (!empty($ACL) ? join(',', $ACL) : ''),
                );
                // Save to config
                setoption('#grp', $groups);
                cn_throw_message("Group added");
            } elseif ($is_exists) {
                cn_throw_message("Group with that name already exist", 'e');
                $group_id = 0;
            } else {
                cn_throw_message("Group not added", 'e');
            }
        } else {
            $edit_system = FALSE;
            $edit_exists = FALSE;
            $is_add_edit = TRUE;
            // Check group exists
            foreach ($groups as $id => $dt) {
                if ($id == $group_id && $dt['#']) {
                    $edit_system = TRUE;
                }

                if ($dt['N'] == $group_name) {
                    $edit_exists = TRUE;
                }
            }

            // Reset group rights
            if ($reset_group && $group_id) {
                $cgrp = file(SKIN . '/defaults/groups.tpl');
                foreach ($cgrp as $G) {
                    $G = trim($G);
                    if ($G[0] === '#') {
                        continue;
                    }

                    list($id, $name, $group, $access) = explode('|', $G);
                    $id = intval($id);

                    if ($id == $group_id) {
                        $ACL = spsep(($access === '*') ? $_CN_access['C'] . ',' . $_CN_access['N'] . ',' . $_CN_access['M'] : $access);
                        $groups[$group_id] = array
                        (
                            '#' => TRUE,
                            'N' => $name,
                            'G' => $group,
                            'A' => (!empty($ACL) ? join(',', $ACL) : ''),
                        );

                        cn_throw_message("Group reset");
                    }
                }
                $is_add_edit = FALSE;
            } // Update group
            elseif ($edit_exists && !$delete_group) {
                if ($group_id == 1) {
                    cn_throw_message("Can't update admin group", 'e');
                } else {
                    cn_throw_message('Parameters for a group are not correct specified or group already exists', 'e');
                }
            } // Unable remove system group
            elseif ($delete_group && $edit_exists) {
                if ($edit_system) {
                    cn_throw_message("Unable remove system group");
                } else {
                    unset($groups[$group_id]);

                    $ACL = array();
                    $group_id = 0;

                    cn_throw_message("Group removed");
                }
            }

            // Save to config
            setoption('#grp', $groups);
        }
    }

    foreach ($groups as $name => $data) {
        $_gtext = array();
        $G = spsep($data['G']);

        foreach ($G as $id) {
            if (isset ($groups[$id])) {
                $_gtext[] = $groups[$id]['N'];
            }
        }

        $grp[$name] = array
        (
            'system' => $data['#'],
            'name' => $data['N'],
            'grp' => $_gtext,
            'acl' => $data['A'],
        );
    }

    // Translate ACL to view
    $access = array();
    $bc = array();

    // Get user acl data
    if ($group_id && $groups[$group_id]) {
        $bc = spsep($groups[$group_id]['A']);
    }

    foreach ($_CN_access as $Gp => $Ex) {
        $Gz = array();
        $Ex = spsep($Ex);
        $Tr = $access_desc[$ATR[$Gp]];

        foreach ($Ex as $id) {
            $trp = explode('|', $Tr[$id]);
            $d = isset($trp[0]) ? $trp[0] : '';
            $t = isset($trp[1]) ? $trp[1] : '';
            $c = in_array($id, $bc);
            if ($is_add_edit) {
                $c = FALSE;
            }
            $Gz[$id] = array
            (
                //'d' => i18n( array($d, 'DS-') ),
                //'t' => i18n( array($t, 'DS-') ),
                'd' => array($d, 'DS-'),
                't' => array($t, 'DS-'),
                'c' => $c
            );
        }

        $access[$ATR[$Gp]] = $Gz;
    }

    // Group is system
    $group_system = $group_id && $groups[$group_id]['#'];


    if ($group_id) {
        if (!$is_add_edit) {
            $group_name = $groups[$group_id]['N'];
            $group_grp = $groups[$group_id]['G'];
        } else {
            $group_name = $group_grp = '';
            $group_id = 0;
        }
    }

    cn_assign('grp, group_name, group_id, group_grp, group_system, access, form_desc', $grp, $group_name, $group_id, $group_grp, $group_system, $access, $form_desc);
    echoheader('-@dashboard/style.css', 'Groups');
    echo exec_tpl('dashboard/group');
    echofooter();
}

// =====================================================================================================================
// Since 2.0: Replace words

function board_wreplace()
{
    list($word, $replace, $delete) = GET('word, replace, delete');
    $wlist = getoption('#rword');

    if (request_type('POST')) {
        cn_dsi_check();

        if ($delete && $word) {
            unset($wlist[$word]);
            cn_throw_message("Word deleted");
            setoption('#rword', $wlist);
        } elseif ($word && $replace) {
            $wlist[$word] = $replace;
            setoption('#rword', $wlist);
        } else {
            cn_throw_message("Can't save");
        }
    }

    // Require additional data
    if (isset($wlist[$word])) {
        $replace = $wlist[$word];
    }
    $is_replace_opt = getoption('use_replacement');
    cn_assign('wlist, word, replace, repopt', $wlist, $word, $replace, $is_replace_opt);
    echoheader('-@dashboard/style.css', 'Replace words');
    echo exec_tpl('dashboard/replace');
    echofooter();
}

// =====================================================================================================================
// Since 2.0: Localization

function board_locale()
{
    list($lang_token, $lang, $create_phrase, $phraseid, $translate, $delete_phrase, $exid) = GET('lang_token, lang, create_phrase, phraseid, translate, delete_phrase, exid');

    $tkn = array();
    $list = scan_dir(SERVDIR . '/core/lang/', '.*\.txt');
    $updated = FALSE;

    // Load langs
    foreach ($list as $id => $code)
        if (preg_match('/^(.*)\.txt/i', $code, $c))
            $list[$id] = $c[1];

    // Load symbols
    $lang_token = preg_replace('/[^a-z0-9_\-]/i', '', $lang_token);
    if ($lang_token) {
        $_tkn = file($cfile = SERVDIR . '/core/lang/' . $lang_token . '.txt');
        foreach ($_tkn as $data) {
            list($TKN, $DAT) = explode(': ', $data, 2);
            $tkn[$TKN] = $DAT;
        }
    }

    // Do submit new data
    if (request_type('POST') && REQ('modifica')) {
        cn_dsi_check();

        // Create new phrase
        if ($create_phrase || !$exid || $exid && $exid !== $phraseid) {
            if ($phraseid && $translate) {
                $exid = $h = hi18n($phraseid);
                if (!isset($tkn[$h])) {
                    $updated = TRUE;
                    $tkn[$h] = str_replace("\n", '', $translate);
                    cn_throw_message('Row added');
                } else {
                    cn_throw_message('Row with same ID already exists', 'e');
                }
            } else
                cn_throw_message('Fill required fields', 'e');
        } // Do delete
        elseif ($delete_phrase) {
            if (isset($tkn[$exid])) {
                $updated = TRUE;
                unset($tkn[$exid]);
                cn_throw_message('Row deleted');
            } else {
                cn_throw_message('Phrase not deleted: not exists');
            }
        } // Do modify
        else {
            $updated = TRUE;
            $tkn[$exid] = str_replace("\n", '', $translate);

            cn_throw_message('Row edited');
        }
    }

    // Updated? Try save
    if ($updated && isset($cfile)) {
        $w = fopen($cfile, 'w+');
        foreach ($tkn as $I => $T) fwrite($w, "$I: " . trim($T) . "\n");
        fclose($w);

        // Reinitialize skin
        cn_lang_init();
        cn_load_skin();
    }

    // Select
    if ($exid && isset($tkn[$exid])) {
        $phraseid = $exid;
        $translate = $tkn[$exid];
    }

    cn_assign('lang_token, lang, list, tkn, phraseid, translate', $lang_token, $lang, $list, $tkn, $phraseid, $translate);
    echoheader('-@dashboard/style.css', 'Localization');
    echo exec_tpl('dashboard/locale');
    echofooter();
}
*/