<?php if (!defined('BQN_MU')) {
    die('Access restricted');
}

use Dropbox as dbx;

define('APPLICATION_NAME', getOption('nameAppDriver'));

add_hook('index/invoke_module', '*board_invoke');
global $coreAdmin;

function board_invoke()
{
    global $request;
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    global $request;

    @$mod = $request->mod;
    @$opt = $request->opt;

    $dashboard = array(
        'editconfig:sysconf:Csc' => __('system_configuration'),
        'editconfig:confchar:Ct' => __('functional_configuration'),
        'editconfig:secure:Can' => __('configure_DDoS'),
        'editconfig:ischaracter:Ciw' => __('character'),
        'editconfig:personal:Cp' => __('personal_options'),
        'editconfig:userman:Cum' => __('users_manager'),
        'editconfig:group:Cg' => __('groups'),
        'editconfig:category:Cg' => __('categories'),
        'editconfig:logs:Csl' => __('logs'),
        'editconfig:statistics:Csl' => __('statistical'),
        'editconfig:uploadFileAPIDropBox:Csl' => __('upload_file_dropBox_API'),
        'editconfig:uploadFileAPIGoogle:Csl' => __('upload_file_google_drivers_API'),
        'editconfig:apiDriverdChangeShare:Csl:1' => __('change_share_drivers_API'),
        'editconfig:apiDeleteDrivers:Csl:1' => __('delete_item_drivers_API'),

        'editconfig:select:Ciw' => __('select'),
        'editconfig:iswebshop:Ciw' => __('iswebshop'),
        'editconfig:iserverz:Ciw' => __('iserverz'),
        'editconfig:wreplace:Ciw' => __('wreplace'),
//        'editconfig:updatemoney:Ciw' => __('update_money'),
//        'editconfig:updateCharater:Ciw' => __('update_character'),
//        'editconfig:update:Ciw' => __('update_money'),
//        'editconfig:insert:Ciw' => __('insert'),
    );

    // Call dashboard extend
    $dashboard = hook('extend_dashboard', $dashboard);

    // check mod
    if (empty($mod)) {
        $mod = REQ('mod', 'GETPOST');
    }
    if (empty($opt)) {
        $opt = REQ('opt', 'GETPOST');
    }

    // Top level (dashboard)
    cn_bc_add('Configuration', cn_url_modify(array('reset'), 'mod=' . $mod));

    // Request module
    foreach ($dashboard as $id => $_t) {
        list($dl, $do, $acl_module) = explode(':', $id);

        if (testRoleAdmin($acl_module) && $dl == $mod && $do == $opt && function_exists("board_$opt")) {
            cn_bc_add($_t, cn_url_modify(array('reset'), 'mod=' . $mod, 'opt=' . $opt));
            die(call_user_func("board_$opt"));
        }
    }
    $cfg = getMemcache('config');
    if (!isset($cfg['temp_basic']) || !count($cfg['temp_basic'])) {
        cn_get_template_by_array('class');
    }

    if (!isset($cfg['templates_basic']) || !count($cfg['templates_basic'])) {
        cn_format_template_list();
    }

    echo_header_admin('-@skins/mu_style.css', "Mu Online dashboard");

    $images = array(
        'sysconf' => 'options.gif',
        'confchar' => 'settings.png',
        'secure' => 'secure.gif',
        'ischaracter' => 'ischaracter.png',
        'uploadFileAPIDropBox' => 'api.png',
        'uploadFileAPIGoogle' => 'api.png',

        'personal' => 'user.gif',
        'userman' => 'users.gif',
        'group' => 'group.png',
        'category' => 'category.png',
        'statistics' => 'statistic.png',
        'logs' => 'list.png',
        'iswebshop' => 'list.png',
        'iserverz' => 'list.png',
        'wreplace' => 'list.png'
    );

    // More dashboard images
    $images = hook('extend_dashboard_images', $images);

    foreach ($dashboard as $id => $name) {
        list($mod, $opt, $acl) = explode(':', $id, 4);
        if (!testRoleAdmin($acl)) {
            unset($dashboard[$id]);
            continue;
        }

        $item = array(
            'name' => $name,
            'img' => isset($images[$opt]) ? $images[$opt] : 'home.gif',
            'mod' => $mod,
            'opt' => $opt,
            'isHide' => @explode(':', $id)[3] ? 0 : 1
        );

        $dashboard[$id] = $item;
    }

    $greeting_message = __('have_nice_day');
    cn_assign('dashboard, username, greeting_message', $dashboard, (@$_SESSION['mu_Account'] ? $_SESSION['mu_Account'] : ''), $greeting_message);
    echo cn_execute_template('com_board/general');
    echofooter();
}

function board_sysconf()
{
    $lng = $grps = $all_skins = array();
    //$skins = scan_dir(cn_path_construct(SERVDIR,'skins'));
    $langs = scan_dir(cn_path_construct(ROOT, 'Utils', 'lang'), 'php');
    $_grps = getOption('#grp');


    // Fetch skins
//    foreach ($skins as $skin)
//    {
//        if (preg_match('/(.*)\.skin\.php/i', $skin, $c)) //<=> *.skin.php
//        {
//            $all_skins[$c[1]] = $c[1];
//        }
//    }

    // Fetch lang packets
    foreach ($langs as $lf) {
        if (preg_match('/(.*)\.php/i', $lf, $c)) {
            $lng[$c[1]] = $c[1];
        }
    }

    // fetch groups
    foreach ($_grps as $id => $vn) {
        $grps[$id] = ucfirst($vn['N']);
    }

    // Option -> 0=Type(text [Y/N] int select), 1=Title|Description, [2=Optional values]
    $options_list = array(
        'general' => array(
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
            'config_time_logout' => array('int', 'Second Time Auto Logout After for Admin |eg: 900 (Automatic Logout after 15 minutes)'),
            'config_time_logout_web' => array('int', 'Second Time Auto Logout After for Web |eg: 300 (Automatic Logout after 5 minutes)'),
            'config_login_ban' => array('text', 'Limit the number of login attempts - Minute Time Blocks |eg: 5:360 (user block after failed 5 login template within 6 hours)'),
            'ban_attempts' => array('int', 'Second between login attempts'),
            'config_auth_email' => array('text', 'Account from send email'),
            'config_auth_pass' => array('password', 'Password account from send email'),

            '_COM' => array('title', 'General:'),
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

            'allowed_extensions' => array('text', 'Allowed extensions|Used by file manager. Enter by comma without space'),
            'uploads_dir' => array('text', 'Server upload dir|Real path on server'),
            'uploads_ext' => array('text', 'Frontend upload dir|Frontend path for uploads'),


        ),
        'websites' => array(
            '_deBugWeb' => array('title', 'USE DEBUG WEB'),
            'debugSql' => array('Y/N', 'Uses have debug| Check is debug Sql'),
            'use_captcha' => array('Y/N', 'Use CAPTCHA|on registration and comments'),
            'hide_captcha' => array('Y/N', 'Hide captcha source path from visitors'),
            'category_style' => array('select', 'Category style', array('list' => "Listing", 'select' => 'Drop-down menu')),
            'smilies' => array('text', 'Smilies'),
            'use_wysiwyg' => array('Y/N', 'Use CKEditor in news'),

            '_Web' => array('title', '.............'),
            'cn_language' => array('select', 'CuteNews internationalization', $lng),
            'configBuyZen' => array('text', 'Buy zen list [500.000.000.000 - 1.000.000.000 - 1.500.000.000 - 2.000.000.000]|Ex: 5000|10000|15000|20000  ==> 5000 Vp <-> 500.000.000.000 Zen, ...'),
            'configLevel' => array('text', 'Set Vpoint level 150 - 220 - 380 |Ex: 2000|3000|5000  =-> 2k Vp <-> Level I; 3k Vp <-> Level II; 5k Vp <-> Level III'),
            '_QA' => array('title', 'Question answer'),
            'question_answer_1' => array('text', 'Question answer 1'),
            'question_answer_2' => array('text', 'Question answer 2'),
            'question_answer_3' => array('text', 'Question answer 3'),
            'question_answer_4' => array('text', 'Question answer 4'),
            'question_answer_5' => array('text', 'Question answer 5'),

            'vptogc' => array('int', 'Công thức Gcoin = X% Vpoint|VD: X = 80 => [Gcoin = 80% Vpoint]'),
            //'gctovp'         => array('int', 'Title field will not be required|VD: 1 Vpoint = 1 Gcoin'),

            'configTransVpoint' => array('int', 'Chuyển Vpoint|VD: 5000 / 1L'),
            'changename_vpoint' => array('int', 'Thay đổi tên nhân vật Vpoint|VD: 50000'),
            'changeClass_str' => array('text', 'Thay đổi Class = Vpoint:-X% Reset:MinReset |VD: 50000:15:100 (50k Vpoint, -15% số reset, min reset 100)'),

            'user_rs_uythac' => array('Y/N', 'Sử dụng Reset ủy thác |...............'),
            'taytuy_vpoint' => array('int', 'Sử dụng ủy thác tay tuy vpoint|...............'),
            'uythacon_price' => array('int', '1 Điểm ủy Thác = X Gcoin / 1 Phút ủy thác Online|VD: X = 10 => [1 Điểm ủy Thác = 10 Gcoin / 1 Phút ủy thác]'),
            'uythacoff_price' => array('int', '1 Điểm ủy Thác = X Gcoin / 1 Phút ủy thác Offline|VD: X = 10 =>[1 Điểm ủy Thác = 10 Gcoin / 1 Phút ủy thác]'),
            'user_delegate' => array('select', 'Sử dụng ủy thác|chọn ủy thác với nhu cầu', array(0 => "Offline", 1 => "Online", 2 => "Online + Offline",)),
            'user_resetvip......' => array('Y/N', 'Sử dụng top ResetVip|.........Short story field will not be required'),
            'event_toprs_on' => array('Y/N', 'Sử dụng top reset|.........Short story field will not be required'),
            'support_new_player' => array('Y/N', 'Hỗ trợ tân thủ| nếu sử dụng hỗ trợ tân thủ sẽ được giảm level theo cấp độ (có 5 cấp)'),
            'cap_relife_max' => array('int', 'Số cấp Relife hiển thị dành cho người chơi|Số cấp Relife từ cấp 1 đến cấp 10'),
            'cap_reset_max' => array('int', 'Số cấp Reset hiển thị dành cho người chơi|Số cấp Reset từ cấp 1 đến cấp 20'),
            'use_gioihanrs' => array('select', 'Sử dụng giới hạn Reset|chọn giới hạn reset với nhu cầu', array(0 => "Không sử dụng", 1 => "Loại 1", 2 => "Loại 2",)),
        ),
        'server' => array(
            'type_connect' => array('select', 'Dạng kết nối Database|show/hide standart comment system', array("odbc" => "Odbc", "mssql" => "Mssql")),
            'localhost' => array('text', 'Localhost|newest comments will be shown at the top'),
            'databaseuser' => array('text', 'User quản lý SQL (thường là sa)|in seconds; 0 = no protection'),
            'databsepassword' => array('password', 'Mật khẩu quản lý SQL|enter <b>0</b> to disable checking'),
            'd_base' => array('text', 'Database sử dụng để lưu trữ thông tin MU|enter <b>0</b> or leave empty to disable pagination'),
            'server_type' => array('select', 'Loại Server đang sử dụng|if yes, comments will be shown under the story', array("scf" => "SCF", "original" => "Original")),
        ),
        'card' => array(
            'Merchant_ID' => array('text', 'Merchant_ID|info: https://sv.gamebank.vn; VD: 12345'),
            'API_User' => array('text', 'API User|info: https://sv.gamebank.vn; VD: tukjhji5'),
            'API_Password' => array('text', 'API Password|info: https://sv.gamebank.vn; VD: 98hjhgtyjkjlklbjhgjhgyhfhfhtfdy'),
            'card_list' => array('text', 'Nap the list [VTC - GATE - VIETTEL - MOBI - VINA]| 1 => Yes, 0 => No, VD: 1,1,1,1,1'),
            'km_list' => array('text', 'Khuyen Mai list [VTC - GATE - VIETTEL - MOBI - VINA]| 10% => 10, 0 => No, 20 % => all, VD: 10,0,0,0,0|20'),
            'card_gate' => array('text', 'Card Gate list [10k - 20k - 30k - 50k - 100k - 200k - 300k -500k]| 1 => Yes, 0 => No, VD: 0,1,0,1,1,0,1,1'),
            'card_vtc' => array('text', 'Card Vtc list [10k - 20k - 30k - 50k - 100k - 200k - 300k -500k]| 1 => Yes, 0 => No, VD: 0,1,0,1,1,0,1,1'),
            'card_viettel' => array('text', 'Card Viettel list [10k - 20k - 30k - 50k - 100k - 200k - 300k -500k]| 1 => Yes, 0 => No, VD: 0,1,0,1,1,0,1,1'),
            'card_mobi' => array('text', 'Card Mobi list [10k - 20k - 30k - 50k - 100k - 200k - 300k -500k]| 1 => Yes, 0 => No, VD: 0,1,0,1,1,0,1,1'),
            'card_vina' => array('text', 'Card Vina list [10k - 20k - 30k - 50k - 100k - 200k - 300k -500k]| 1 => Yes, 0 => No, VD: 0,1,0,1,1,0,1,1'),
        ),
        'money' => array(
            '_MONEY' => array('title', 'Money:'),
            'config_itemvpoint' => array('text', 'Frontend upload dir|Frontend path for uploads'),
            'config_buyzen' => array('text', 'Frontend upload dir|Frontend path for uploads'),
            'trans_itemvp' => array('text', 'Frontend upload dir|Frontend path for uploads'),
            'config_vp2gc' => array('text', 'Frontend upload dir|Frontend path for uploads'),
            'config_gc2vp' => array('text', 'Frontend upload dir|Frontend path for uploads'),
            'config_gc2wc' => array('text', 'Frontend upload dir|Frontend path for uploads'),
            'config_gc2wcp' => array('text', 'Frontend upload dir|Frontend path for uploads'),
            'config_gc2gob' => array('text', 'Frontend upload dir|Frontend path for uploads'),
        ),
        'seo' => array(
            'description' => array('text', 'Descriptions for site'),
            'keywords' => array('text', 'Keywords for website')
        ),
        'event' => array(
            '_EVENT' => array('title', 'Event:'),
        ),
        'relax' => array(
            '_RELAX_BCua' => array('title', 'Tro Bau Cua'),
            'user_BauCua' => array('Y/N', 'Sử dụng trò Bầu Cua'),
            '_RELAX_BCao' => array('title', 'Tro Bai Cao'),
            'user_BaiCao' => array('Y/N', 'Relax:Sử dụng trò Bài Cáo'),
            '_RELAX_XoSo' => array('title', 'Danh De'),
            'url_Result_De' => array('text', 'Trang website kết quả xổ số | VD: http://ketqua.net/'),
            'id_getResult_De' => array('text', 'ID (html) xác nhận kết quả đề của trang website xổ số | VD: rs_0_0'),
            'timeWriterLimit' => array('text', 'Thời gian kết thức nhận ghi đề; Định dạng 24h| VD: 17:45 hàng ngày'),
            'timeResultDe' => array('text', 'Thời gian trả kết quả đề; Định dạng 24h| VD: 8:0 ngày ngày hôm sau, và nhỏ hơn thơi gian kết thức nhận ghi đề'),
            'moneyMinDe' => array('int', 'Số tiền tối thiểu nhận ghi đề (Vpoint)| VD: 5000 Vpoint'),
        ),
        'download' => array(
            '_Download' => array('title', 'Download Game'),
            'download_media' => array('text', 'Download file for mediafire (auto)| VD: http://download1635.mediafire.com/download.php?sz41ac5m7rn'),
            'download_onedrive' => array('text', 'Download file for OneDrive (auto)| VD: https://d.docs.live.net/bdc1aa9209a93fd4'),
            'download_4share' => array('text', 'Download file for 4share| VD: http://www.4shared.com/d7fnlfadfffp?sz41ac5m7rn'),
        ),
        'downloadApi' => array(
            '_Dropbox_API_' => array('title', 'Api Dropbox'),
            'appNameDropBox' => array('text', 'Name app of api dropbox|https://www.dropbox.com/developers/apps'),
            'keyDropBox' => array('text', 'App key|https://www.dropbox.com/developers/apps'),
            'secretDropBox' => array('text', 'App secret|https://www.dropbox.com/developers/apps'),
            'redirectUriDropBox' => array('text', 'Redirect URIs uses htttps://|https://www.dropbox.com/developers/apps'),
            'accessTokenDropBox' => array('text', 'Auto Generated access Token| OR set access Token'),
            '_GoogleDriver_API_' => array('title', 'Api Google Driver'),
            'nameAppDriver' => array('text', 'Name Application'),
            'credentialsApiDriver' => array('text', 'Auto Generated access Token')
        )
    );

    // System help
    $help = hook('sysconf/helper', array(
        'http_script_dir' => '......',
    ));

    // Static rewrite path
    $cfg = getMemcache('config');


    // Save cached copy
    setMemcache('config', $cfg);

    // ------------------
    $sub = trim(strtolower(REQ('sub', "GETPOST")));
    if (!isset($options_list[$sub])) {
        $sub = 'general';
    }

    // Save data
    if (request_type('POST')) {
        cn_dsi_check();

        $post_cfg = $_POST['config'];
        $opt_result = getOption('#%site');
        $by_default = isset($options_list[strtolower($sub)]) ? $options_list[strtolower($sub)] : [];

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
            if (!isset($post_cfg[$id])) {
                continue;
            }
            if ($var[0] == 'text' || $var[0] == 'select') {
                $opt_result[$id] = $post_cfg[$id];
            } elseif ($var[0] == 'int') {
                $opt_result[$id] = intval($post_cfg[$id]);
            } elseif ($var[0] == 'password') {
                if ($post_cfg[$id]) {
                    $opt_result[$id] = $post_cfg[$id];
                } else {
                    $opt_result[$id] = getOption($id);
                }
            } elseif ($var[0] == 'Y/N') {
                $opt_result[$id] = (isset($post_cfg[$id]) && 'Y' == $post_cfg[$id]) ? 1 : 0;
            } elseif (isset($post_cfg[$id])) {
                unset($opt_result[$id]);
            }
        }

        setOption('#%site', $opt_result);

        cn_throw_message(__('save_success'));
    }

    $options = $options_list[strtolower($sub)];
    foreach ($options as $id => $vo) {
        $options[$id]['var'] = getOption($id);

        $text_paths = explode('|', $vo[1], 2);
        $title = isset($text_paths[0]) ? $text_paths[0] : '';
        $desc = isset($text_paths[1]) ? $text_paths[1] : '';
        $options[$id]['title'] = $title;
        $options[$id]['desc'] = $desc;
        $options[$id]['help'] = isset($help[$id]) ? $help[$id] : '';

        unset($options[$id][1]);
    }

    if (REQ('message', 'GET') == 'saved') {
        unset($_GET['message']);
        cn_throw_message(__('save_success'));
    }

    cn_assign('options, sub, options_list', $options, $sub, $options_list);
    echo_header_admin('-@skins/mu_style.css', "System configurations");
    echo cn_execute_template('com_board/sysconf');
    echofooter();
}

function board_confChar()
{
    $grps = array();
    $_grps = getOption('#grp');

    // fetch groups
    foreach ($_grps as $id => $vn) {
        $grps[$id] = ucfirst($vn['N']);
    }

    $options_list = array(
        'cashshop' => array(
            '_CASHSHOP' => array('title', 'Cashshop settings'),
            'Use_WebShop' => array('Y/N', 'Sử dụng web shop'),
        ),
        'money' => array(
            '_MONEY' => array('title', 'Money settings'),
            'Use_NapVpoint' => array('Y/N', 'Sử dụng nạp Vpoint'),
            'Use_ChuyenVpoint' => array('Y/N', 'Sử dụng chuyển Vpoint'),
            'Use_Gcoin2VipMoney' => array('Y/N', 'Sử dụng chuyển Gcoin sang VipMoney'),
            'Use_Gcoin2WCoin' => array('Y/N', 'Sử dụng chuyển Gcoin sang WCoin'),
            'Use_Gcoin2WCoinP' => array('Y/N', 'Sử dụng chuyển Gcoin sang WCoinP'),
            'Use_Gcoin2GoblinCoin' => array('Y/N', 'Sử dụng chuyển Vpoint'),
            'Use_TienTe' => array('Y/N', 'Sử dụng tiền tệ'),
            'Use_NapThe' => array('Y/N', 'Sử dụng nạp thẻ'),
            'Use_CardGATE' => array('Y/N', 'Sử dụng card Gate'),
            'Use_CardVTCOnline' => array('Y/N', 'Sử dụng Card VTC Online'),
            'Use_CardViettel' => array('Y/N', 'Sử dụng Card Viettel'),
            'Use_CardMobi' => array('Y/N', 'Sử dụng Card Mobi'),
            'Use_CardVina' => array('Y/N', 'Sử dụng Card Vina'),
            'Use_ShopTienZen' => array('Y/N', 'Sử dụng shop Tiền Zen'),
        ),
        'delegation' => array(
            '_DELEGATION' => array('title', 'delegation settings'),
            'Use_ResetVIP' => array('Y/N', 'Sử dụng Reset VIP'),
            'Use_UyThacOffline' => array('Y/N', 'Sử dụng ủy thác Offline'),
            'Use_UyThacOnline' => array('Y/N', 'Sử dụng ủy thác Online'),
            'Use_UyThacResetVIP' => array('Y/N', 'Sử dụng ủy thác reset Vip'),
        ),
        'other' => array(
            '_OTHER' => array('title', 'other settings'),
//            'Use_Char2AccOther' => array('Y/N', 'Sử dụng chuyển Vpoint'),
            'Use_Event' => array('Y/N', 'Sử dụng event'),
            'Use_XepHang' => array('Y/N', 'Sử dụng xếp hạng'),
            'Use_ChangeName' => array('Y/N', 'Sử dụng chuyển giới tính'),
        )
    );

    // Static rewrite path
    $cfg = getMemcache('config');

    // Save cached copy
    setMemcache('config', $cfg);

    // ------------------
    $sub = trim(strtolower(REQ('sub', "GETPOST")));
    if (!isset($options_list[$sub])) {
        $sub = 'cashshop';
    }

    // Save data
    if (request_type('POST')) {
        cn_dsi_check();

        $post_cfg = isset($_POST['config']) ? $_POST['config'] : null;
        $opt_result = getOption('#%site');
        $by_default = $options_list[strtolower($sub)];

        // Detect selfpath
        $SN = dirname($_SERVER['SCRIPT_NAME']);
        $script_path = "http://" . $_SERVER['SERVER_NAME'] . (($SN == '/' || $SN == '\\') ? '' : $SN);

        // Fill empty fields
        if (empty($post_cfg['http_script_dir'])) {
            $post_cfg['http_script_dir'] = $script_path;
        }
        if (empty($post_cfg['uploads_dir'])) {
            $post_cfg['uploads_dir'] = cn_path_construct(($SN == DIRECTORY_SEPARATOR) ? SERVDIR : substr(SERVDIR, 0, -strlen($SN)), 'uploads');
        }
        if (empty($post_cfg['uploads_ext'])) {
            $post_cfg['uploads_ext'] = $script_path . '/uploads';
        }

        // all
        foreach ($by_default as $id => $var) {
            if (!isset($post_cfg[$id])) {
                continue;
            }

            if ($var[0] == 'text' || $var[0] == 'select') {
                $opt_result[$id] = $post_cfg[$id];
            } elseif ($var[0] == 'int') {
                $opt_result[$id] = intval($post_cfg[$id]);
            } elseif ($var[0] == 'password') {
                if ($post_cfg[$id]) {
                    $opt_result[$id] = $post_cfg[$id];
                } else {
                    $opt_result[$id] = getOption($id);
                }
            } elseif ($var[0] == 'Y/N') {
                $opt_result[$id] = (isset($post_cfg[$id]) && 'Y' == $post_cfg[$id]) ? 1 : 0;
            } elseif (isset($post_cfg[$id])) {
                unset($opt_result[$id]);
            }
        }

        setOption('#%site', $opt_result);

        cn_throw_message(__('save_success'));
    }

    $options = $options_list[strtolower($sub)];
    foreach ($options as $id => $vo) {
        $options[$id]['var'] = getOption($id);

        $text_parths = explode('|', $vo[1], 2);
        $title = isset($text_parths[0]) ? $text_parths[0] : '';
        $desc = isset($text_parths[1]) ? $text_parths[1] : '';
        $options[$id]['title'] = $title;
        $options[$id]['desc'] = $desc;

        unset($options[$id][1]);
    }

    if (REQ('message', 'GET') == 'saved') {
        unset($_GET['message']);
        cn_throw_message(__('save_success'));
    }

    cn_assign('options, sub, options_list', $options, $sub, $options_list);

    echo_header_admin('-@skins/mu_style.css', "System configurations character");
    echo cn_execute_template('com_board/confchar');
    echofooter();
}

function board_personal()
{
    $member = getMember();

    // Additional fields for user
    $personal_more = array(
        'site' => array('name' => 'Personal site', 'type' => 'text'),
        'about' => array('name' => 'About me', 'type' => 'textarea'),
    );

    if (request_type('POST')) {
        cn_dsi_check();

        $clause = '';
        $any_changes = false;
        list($editpassword, $confirmpassword, $editnickname, $edithidemail, $more) = GET('editpassword, confirmpassword, editnickname, edithidemail, more', 'POST');
        $avatar_file = isset($_FILES['avatar_file']) ? $_FILES['avatar_file'] : null;

        if ((!isset($member['nick']) && !empty($editnickname)) || (isset($member['nick']) && $member['nick'] !== $editnickname)) {
            $any_changes = true;
        }

        if ((!isset($member['e-hide']) && !empty($edithidemail)) || (isset($member['e-hide']) && $member['e-hide'] !== $edithidemail)) {
            $any_changes = true;
        }

        if ($editpassword) {
            if ($editpassword === $confirmpassword) {
                $any_changes = true;
                db_user_update($member['name'], "pass=" . SHA256_hash($editpassword));

                // Send mail if password changed
                $notification = cn_replace_text(cn_get_template('password_change', 'mail'), '%username%, %password%', $member['name'], $editpassword);

                $clause = __("check_your_email");
                cn_send_mail($member['email'], __("pwd_was_changed"), $notification);
            } else {
                cn_throw_message(__('pwd_do_not_match'), 'e');
            }
        }

        // Update additional fields for personal data
        $o_more = base64_encode(serialize($member['more']));
        $n_more = base64_encode(serialize($more));

        if ($o_more !== $n_more) {
            $any_changes = true;
            db_user_update($member['name'], "more=" . $n_more);
        }
        // Set an avatar
        if (!empty($avatar_file) && $avatar_file['error'] == 0) {
            $uploads_dir = getOption('uploads_dir');
            if ($uploads_dir) {
                $file_name = 'avatar_' . $member['name'] . '_' . $avatar_file['name'];
                if (isset($member['avatar']) && $member['avatar'] != $file_name) {
                    // remove old avatar
                    unlink($uploads_dir . $member['avatar']);
                }
                move_uploaded_file($avatar_file['tmp_name'], $uploads_dir . $file_name);
                db_user_update($member['name'], "avatar=" . $file_name);
                $any_changes = true;
            }
        }
        // Has changes?
        if ($any_changes) {
            db_user_update($member['name'], "nick=$editnickname", "e-hide=$edithidemail");

            // Update & Get member from DB
            setMemcache('#member', null);
            $member = getMember();

            cn_throw_message(__("user_info_updated", [$clause]));
        } else {
            cn_throw_message(__("no_change"), 'w');
        }
    }

    $grp = getOption('#grp');
    $acl_desc = $grp[$member['acl']]['N'];

    // Get info from personal data
    foreach ($personal_more as $name => $pdata) {
        if (isset($member['more'][$name])) {
            $personal_more[$name]['value'] = $member['more'][$name];
        }
    }

    cn_assign('member, acl_write_news, acl_desc, personal_more', $member, testRoleAdmin('Can'), $acl_desc, $personal_more);
    echo_header_admin('-@skins/mu_style.css', "Personal options");
    echo cn_execute_template('com_board/personal');
    echofooter();
}

function board_iswebshop()
{

    $ipban = getOption('#ipban');
    if (!is_array($ipban)) {
        $ipban = array();
    }

    // Submit new IP
    if (request_type('POST')) {
        cn_dsi_check();

        $ip = trim(REQ('add_ip'));
        if (!empty($ip)) {
            // Times blocked : Expire time
            $ipban[$ip] = array(0, 0);

            setOption('#ipban', $ipban);
            cn_throw_message('IP or name mask [' . $ip . '] add/replaced');
        } else {
            cn_throw_message('IP Address must be filled', 'w');
        }
    } // Unblock IP
    elseif ($ip = REQ('unblock')) {
        cn_dsi_check();

        if (isset($ipban[$ip])) {
            unset($ipban[$ip]);
        }

        setOption('#ipban', $ipban);
    }

    cn_assign('list', $ipban);
    echo_header_admin('-@skins/mu_style.css', 'Block IP');
    echo cn_execute_template('com_board/ipban');
    echofooter();
}

function board_iserverz()
{
    $sub = REQ('sub');

    $categories = cn_get_categories();

    $rss = getOption('#rss');
    $rss_encoding = isset($rss['encoding']) ? $rss['encoding'] : 'UTF-8';
    $rss_news_include_url = isset($rss['news_include_url']) ? $rss['news_include_url'] : '';
    $rss_title = isset($rss['title']) ? $rss['title'] : '';
    $rss_language = isset($rss['language']) ? $rss['language'] : 'en-us';

    // Default: view
    if ($rss_encoding == '') {
        $rss_encoding = 'UTF-8';
    }
    if ($rss_language == '') {
        $rss_language = 'en-us';
    }

    // Check submit
    if (request_type('POST')) {
        cn_dsi_check();

        // Save new configuration
        if ($sub == 'rss') {
            $rss['encoding'] = $rss_encoding = REQ('rss_encoding');
            $rss['news_include_url'] = $rss_news_include_url = REQ('rss_news_include_url');
            $rss['title'] = $rss_title = REQ('rss_title');
            $rss['language'] = $rss_language = REQ('rss_language');

            // Default: save
            if ($rss_encoding == '') {
                $rss_encoding = 'UTF-8';
            }
            if ($rss_language == '') {
                $rss_language = 'en-us';
            }

            setOption('#rss', $rss);
        }
    }

    $all_tpls = array();
    $listsys = cn_template_list();
    $templates = getOption('#templates');

    // Get all templates
    foreach ($listsys as $id => $_t) {
        $all_tpls[$id] = $id;
    }
    foreach ($templates as $id => $_t) {
        $all_tpls[$id] = $id;
    }

    cn_assign('sub, categories, all_tpls', $sub, $categories, $all_tpls);
    cn_assign('rss_news_include_url, rss_encoding, rss_language, rss_title', $rss_news_include_url, $rss_encoding, $rss_language, $rss_title);

    echo_header_admin('-@skins/mu_style.css', 'Integration Wizard');
    echo cn_execute_template('com_board/intwiz');
    echofooter();

}

// Since 2.0: Replace words
function board_wreplace()
{
    list($word, $replace, $delete) = GET('word, replace, delete');
    $wlist = getOption('#rword');

    if (request_type('POST')) {
        cn_dsi_check();

        if ($delete && $word) {
            unset($wlist[$word]);
            cn_throw_message("Word deleted");
            setOption('#rword', $wlist);
        } elseif ($word && $replace) {
            $wlist[$word] = $replace;
            setOption('#rword', $wlist);
        } else {
            cn_throw_message("Can't save");
        }
    }

    // Require additional data
    if (isset($wlist[$word])) {
        $replace = $wlist[$word];
    }
    $is_replace_opt = getOption('use_replacement');
    cn_assign('wlist, word, replace, repopt', $wlist, $word, $replace, $is_replace_opt);
    echo_header_admin('-@skins/mu_style.css', 'Replace words');
    echo exec_tpl('com_board/replace');
    echofooter();
}

function board_ischaracter()
{
    list($template, $sub) = GET('template, sub', 'GPG');

    if (!$sub) {
        $sub = 'class';
    }

    // get array $sub
    $acv = cn_get_template_by_array($sub);
    // User changes
    $acx = getOption('#temp_basic');

    // Option -> 0=Type(text [Y/N] int select), 1=Title|Description, [2=Optional values]
    $options_list = array(
        'class' => array(
            'class_dw_1:class_dw_1_name' => array('int,text', 'Mã nhân vật DarkWizard cấp 1|Tên hiển thị nhân vật DarkWizard cấp 1'),
            'class_dw_2:class_dw_2_name' => array('int,text', 'Mã nhân vật DarkWizard cấp 2|Tên hiển thị nhân vật DarkWizard cấp 2'),
            'class_dw_3:class_dw_3_name:end' => array('int,text', 'Mã nhân vật DarkWizard cấp 3|Tên hiển thị nhân vật DarkWizard cấp 3'),

            'class_dk_1:class_dk_1_name' => array('int,text', 'Mã nhân vật DarkKnight cấp 1|with this option, admin panel uses utf-8 charset'),
            'class_dk_2:class_dk_2_name' => array('int,text', 'Mã nhân vật DarkKnight cấp 2|Tên hiển thị nhân vật DarkKnight cấp 2'),
            'class_dk_3:class_dk_3_name:end' => array('int,text', 'Mã nhân vật DarkKnight cấp 3|Tên hiển thị nhân vật DarkKnight cấp 3'),

            'class_elf_1:class_elf_1_name' => array('int,text', 'Mã nhân vật ELF cấp 1|Tên hiển thị nhân vật ELF cấp 1'),
            'class_elf_2:class_elf_2_name' => array('int,text', 'Mã nhân vật ELF cấp 2|Tên hiển thị nhân vật ELF cấp 2'),
            'class_elf_3:class_elf_3_name:end' => array('int,text', 'Mã nhân vật ELF cấp 3|Tên hiển thị nhân vật ELF cấp 3'),

            'class_mg_1:class_mg_1_name' => array('int,text', 'Mã nhân vật MG cấp 1|Tên hiển thị nhân vật MG cấp 1'),
            'class_mg_2:class_mg_2_name:end' => array('int,text', 'Mã nhân vật MG cấp 2|Tên hiển thị nhân vật MG cấp 2'),

            'class_dl_1:class_dl_1_name' => array('int,text', 'Mã nhân vật DarkLord cấp 1|Tên hiển thị nhân vật DarkLord cấp 1'),
            'class_dl_2:class_dl_2_name:end' => array('int,text', 'Mã nhân vật DarkLord cấp 2|Tên hiển thị nhân vật DarkLord cấp 2'),

            'class_sum_1:class_sum_1_name' => array('int,text', 'Mã nhân vật Summoner cấp 1|Larger than the specified size is considered a big'),
            'class_sum_2:class_sum_2_name' => array('int,text', 'Mã nhân vật Summoner cấp 2|Tên hiển thị nhân vật Summoner cấp 2'),
            'class_sum_3:class_sum_3_name:end' => array('int,text', 'Mã nhân vật Summoner cấp 3|Tên hiển thị nhân vật Summoner cấp 3'),

            'class_rf_1:class_rf_1_name' => array('int,text', 'Mã nhân vật RageFighter cấp 1|Tên hiển thị nhân vật RageFighter cấp 1'),
            'class_rf_2:class_rf_2_name:end' => array('int,text', 'Mã nhân vật RageFighter cấp 2|Tên hiển thị nhân vật RageFighter cấp 2'),
        ),
        'reset' => array(
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

    $options = isset($options_list[$sub]) ? $options_list[$sub] : [];

    foreach ($acx as $id => $subtpl) {
        $all_header_conf[$id]['id'] = $id;
        $all_header_conf[$id]['name'] = ucwords(str_replace('_', ' ', trim($id)));
    }

    switch ($sub) {
        case 'class':
        {
            break;
        }
        case 'reset':
        {
            break;
        }
        case 'reset_vip':
        {
            break;
        }
        case 'thue_point' :
        {
            break;
        }
        case 'hotro_tanthu':
        {
            break;
        }
        case 'pk':
        {
            break;
        }
        case 'gioihan_rs':
        {
            break;
        }
        case 'relife':
        {
            break;
        }
        case 'uythac_resetvip':
        {
            break;
        }
        case 'uythac_reset':
        {
            break;
        }
        default:
    }

    if ($sub === 'class') {
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

            $options[$id]['reset_cap_0'] = 0;
            $options[$id]['end'] = $id_10;
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

            $options[$id]['end'] = $id_7;
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

            $options[$id]['end'] = $id_4;
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

            $options[$id]['end'] = $id_6;
        }
    } elseif ($sub === 'pk') {
        foreach ($options as $id => $vo) {
            $get_id = explode(':', $id);

            $id_1 = $get_id[0];
            $id_2 = $get_id[1];
            $id_3 = isset($get_id[2]) ? $get_id[2] : false;

            $options[$id]['id_1'] = $id_1;
            $options[$id]['id_2'] = $id_2;
            $options[$id]['id_1_val'] = $acv[$id_1];
            $options[$id]['id_2_val'] = $acv[$id_2];

            $options[$id]['end'] = $id_3;
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
            $options[$id]['id_4'] = $id_4;

            $options[$id]['id_1_val'] = $acv[$id_1];
            $options[$id]['id_2_val'] = $acv[$id_2];
            $options[$id]['id_3_val'] = $acv[$id_3];
            $options[$id]['id_4_val'] = $acv[$id_4];

            $options[$id]['end'] = $id_5;
        }

        $array_gh_loai1 = array(
            "gioihanrs_top10" => 10,
            "gioihanrs_top20" => 11,
            "gioihanrs_top30" => 12,
            "gioihanrs_top40" => 14,
            "gioihanrs_top50" => 16,
            "gioihanrs_other" => 20,
        );
        $array_gh_loai2 = array('ResetInDay1:ResetInDay2' => '10:30');

        foreach ($array_gh_loai1 as $e => $vl) {
            $gh_loai1[$e]['top_gh'] = $acv[$e];
        }

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
            $id_3 = $get_id[2];
            $id_4 = isset($get_id[3]) ? $get_id[3] : false;

            $options[$id]['id_1'] = $id_1;
            $options[$id]['id_2'] = $id_2;
            $options[$id]['id_3'] = $id_3;

            $options[$id]['id_1_val'] = $acv[$id_1];
            $options[$id]['id_2_val'] = $acv[$id_2];
            $options[$id]['id_3_val'] = $acv[$id_3];

            $options[$id]['end'] = $id_4;
        }
    } elseif ($sub === 'uythac_resetvip') {
        foreach ($options as $id => $vo) {
            $get_id = explode(':', $id);
            $id_1 = $get_id[0];
            $id_2 = $get_id[1];
            $id_3 = $get_id[2];
            $id_4 = isset($get_id[3]) ? $get_id[3] : false;

            $options[$id]['id_2'] = $id_2;

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

            $options[$id]['id_2'] = $id_2;

            $options[$id]['id_1_val'] = $acx['reset'][$id_1];
            $options[$id]['id_2_val'] = $acv[$id_2];
            $options[$id]['id_3_val'] = $acx['reset'][$id_3];
            $options[$id]['id_4_val'] = $acx['reset'][$id_4];
            $options[$id]['id_5_val'] = $acx['reset'][$id_5];
            $options[$id]['id_6_val'] = $acx['reset'][$id_6];

            $options[$id]['end'] = $id_7;
        }
    }

    if (!$template) {
        $template = 'config_class_';
    }

    // save template?
    if (request_type('POST')) {
        cn_dsi_check();

        $post_cfg = $_POST['config'];
        foreach ($acx[$sub] as $id => $val) {
            if (!isset($post_cfg[$id])) {
                continue;
            }
            if (isset($post_cfg[$id])) {
                $acx[$sub][$id] = $post_cfg[$id];
            }
        }
        setOption("#temp_basic", $acx);
        cn_throw_message(__('template_save_success'));
    }

    $get_gh_loai1 = isset($gh_loai1) ? $gh_loai1 : array();
    $get_gh_loai2 = isset($gh_loai2) ? $gh_loai2 : array();
    $options = isset($options) ? $options : array();
    $all_header_conf = isset($all_header_conf) ? $all_header_conf : array();

    cn_assign('gh_loai1, gh_loai2, sub, all_header_conf, set_arr', $get_gh_loai1, $get_gh_loai2, $sub, $all_header_conf, $options);
    echo_header_admin('-@skins/mu_style.css', "Config Character");
    echo cn_execute_template('com_board/classchar');
    echofooter();
}

function board_userman()
{
    list($section, $st, $delete) = GET('section, st, delete');
    list($user_name, $user_pass, $user_confirm, $user_nick, $user_email, $user_acl) = GET('user_name, user_pass, user_confirm, user_nick, user_email, user_acl');

    $per_page = 100;
    $section = intval($section);
    $st = intval($st);
    $grp = getOption('#grp');
    $is_edit = false; //visability Edit btton

    if (request_type('POST')) {
        cn_dsi_check();

        // Do Delete
        if ($delete) {
            // TODO
            db_user_delete($user_name);
            cn_throw_message(__("delete_user", [cnHtmlSpecialChars($user_name)]));

            $user_name = $user_nick = $user_email = $user_acl = '';
        } // Add-Edit
        else {
            $user_data = db_user_admin_by_name($user_name);

            if (REQ('edit')) {
                if ($user_data === null) {
                    $is_edit = false;
                    cn_throw_message(__("user_not_found"), 'e');
                }
            } else {
                // Add user
                // Check user
                if (!$user_name) {
                    cn_throw_message(__("user_required"), 'e');
                }

                if (!$user_pass) {
                    cn_throw_message(__("pwd_required"), 'e');
                }

                if ($user_data !== null) {
                    cn_throw_message(__("user_exist"), 'e');
                }

                if ($user_confirm != $user_pass) {
                    cn_throw_message(__("pwd_do_not_match"), 'e');
                }
                // Invalid email
                if (!check_email($user_email)) {
                    cn_throw_message(__("email_validate"), "e");
                } // Duplicate email
                elseif (db_user_by($user_email, 'email')) {
                    cn_throw_message(__('email_exist'), 'e');
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
                            cn_throw_message(__('update_success'));
                        } else {
                            cn_throw_message(__("pwd_do_not_match"), 'e');
                        }
                    } else {
                        cn_throw_message('User info updated');
                    }
                } else {// Add user
                    if ($user_id = db_user_add($user_name, $user_acl)) {
                        if (db_user_update($user_name, "email=$user_email", "nick=$user_nick", 'pass=' . SHA256_hash($user_pass), "acl=$user_acl")) {
                            $is_edit = true;
                            cn_throw_message(__("save_success"));
                        } else {
                            cn_throw_message(__("error_update_user"), 'e');
                        }
                    } else {
                        cn_throw_message(__("error_add_user"), 'e');
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
        foreach ($userlist as $id => $dt) {
            if ($dt['acl'] != $section) {
                unset($userlist[$id]);
            }
        }
    }

    // Sort by latest & make pagination
    krsort($userlist);
    $userlist = array_slice($userlist, $st, $per_page, true);

    // Fetch estimate user list
    foreach ($userlist as $id => $data) {
        $user = db_user_by($id);
        $userlist[$id] = $user;
    }

    // By default for section
    if (!$user_acl) {
        $user_acl = $section;
    }

    cn_assign('users, section, st, per_page, grp', $userlist, $section, $st, $per_page, $grp);
    cn_assign('user_name, user_nick, user_email, user_acl, is_edit', $user_name, $user_nick, $user_email, $user_acl, $is_edit);

    echo_header_admin('-@skins/mu_style.css', "Users manager");
    echo cn_execute_template('com_board/users');
    echofooter();
}

function board_group()
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
    $groups = getOption('#grp');
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
                setOption('#grp', $groups);
                cn_throw_message("Group updated");
            } else {
                cn_throw_message("No data for update", 'w');
            }
        } elseif ($mode == 'add') {
            $is_exists = false;
            // Check group exists
            foreach ($groups as $id => $dt) {
                if ($dt['N'] == $group_name) {
                    $is_exists = true;
                    break;
                }
            }

            $group_id = max(array_keys($groups)) + 1;
            // Update exists or new group
            if ($group_id > 1 && !$is_exists) {
                $groups[$group_id] = array(
                    '#' => '',
                    'N' => $group_name,
                    'G' => $group_grp,
                    'A' => (!empty($ACL) ? join(',', $ACL) : ''),
                );
                // Save to config
                setOption('#grp', $groups);
                cn_throw_message("Group added");
            } elseif ($is_exists) {
                cn_throw_message("Group with that name already exist", 'e');
                $group_id = 0;
            } else {
                cn_throw_message("Group not added", 'e');
            }
        } else {
            $edit_system = false;
            $edit_exists = false;
            $is_add_edit = true;
            // Check group exists
            foreach ($groups as $id => $dt) {
                if ($id == $group_id && $dt['#']) {
                    $edit_system = true;
                }

                if ($dt['N'] == $group_name) {
                    $edit_exists = true;
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
                        $ACL = separateString(($access === '*') ? $_CN_access['C'] . ',' . $_CN_access['N'] . ',' . $_CN_access['M'] : $access);
                        $groups[$group_id] = array(
                            '#' => true,
                            'N' => $name,
                            'G' => $group,
                            'A' => (!empty($ACL) ? join(',', $ACL) : ''),
                        );

                        cn_throw_message("Group reset");
                    }
                }
                $is_add_edit = false;
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
            setOption('#grp', $groups);
        }
    }

    foreach ($groups as $name => $data) {
        $_gtext = array();
        $G = separateString($data['G']);

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
        $bc = separateString($groups[$group_id]['A']);
    }

    foreach ($_CN_access as $Gp => $Ex) {
        $Gz = array();
        $Ex = separateString($Ex);
        $Tr = $access_desc[$ATR[$Gp]];

        foreach ($Ex as $id) {
            $trp = explode('|', $Tr[$id]);
            $d = isset($trp[0]) ? $trp[0] : '';
            $t = isset($trp[1]) ? $trp[1] : '';
            $c = in_array($id, $bc);
            if ($is_add_edit) {
                $c = false;
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
    echo_header_admin('-@skins/mu_style.css', __('groups'));
    echo cn_execute_template('com_board/group');
    echofooter();
}

// Since 2.0: Category management
function board_category()
{
    list($category_id, $delete_cat, $new_cat) = GET('category_id, delete_cat, new_cat');
    list($category_name, $category_memo, $category_icon, $category_parent, $category_acl) = GET('category_name, category_memo, category_icon, category_parent, category_acl', "POST");

    $groups = getOption('#grp');
    $categories = getOption('#category');

    // Do Action
    if (request_type('POST')) {
        cn_dsi_check();

        if ($category_name) {
            // Add category, if not exist is [or if new_cat checkbox]
            if (!$category_id || $new_cat) {
                @$categories['#']++;
                $category_id = intval(@$categories['#']);
            }

            // Edit any news
            $categories[$category_id]['name'] = $category_name;
            $categories[$category_id]['memo'] = $category_memo;
            $categories[$category_id]['icon'] = $category_icon;
            $categories[$category_id]['acl'] = @join(',', $category_acl);
            $categories[$category_id]['parent'] = $category_parent;

            cn_throw_message('Category edited');
        } else {
            cn_throw_message('Empty category name', 'e');
        }

        // Delete checkbox selected
        if ($delete_cat) {
            unset($categories[$category_id]);

            cn_throw_message('Category deleted');
            $category_name = $category_icon = $category_memo = $category_acl = $category_id = '';
        }

        list($categories) = cn_category_struct($categories);
        setOption('#category', $categories);
    }

    // ---
    if ($category_id) {
        $category_name = $categories[$category_id]['name'];
        $category_memo = $categories[$category_id]['memo'];
        $category_icon = $categories[$category_id]['icon'];
        $category_parent = $categories[$category_id]['parent'];
        $category_acl = separateString($categories[$category_id]['acl']);
    }

    // latest added
    unset($categories['#']);

    foreach ($groups as $id => $grp) {
        $e = separateString($grp['A']);
        if (!in_array('Ncd', $e))
            unset($groups[$id]);
    }

    // ---
    cn_assign('category_id, categories, category_name, category_memo, category_icon, category_acl, category_parent, groups', $category_id, $categories, $category_name, $category_memo, $category_icon, $category_acl, $category_parent, $groups);
    echo_header_admin('-@skins/mu_style.css', __('categories'));
    echo cn_execute_template('com_board/category');
    echofooter();
}

function board_logs()
{
    $log_read = $logs = array();
    $sub = REQ('sub', "GETPOST");
    $page = intval(REQ('page', 'GETPOST'));
    $per_page = intval(REQ('per_page', 'GETPOST'));
    $section = REQ('section');

    if (empty($per_page) || $per_page < 0) {
        $num = 50;
    } else {
        $num = $per_page;
    }
    $n = 0;
    if ($page < 0) {
        $page = 1;
    }
    $st = ($page - 1) * $num;

    $default_log = array(
        'system' => [],
        'character' => [
            'changeclass' => ['name' => 'Đổi giới tính'],
            'changename' => ['name' => 'Đổi tên nhân vật'],
            'relife' => ['name' => 'Tái Sinh'],
            'resets' => ['name' => 'Reset'],
            'resetsvip' => ['name' => 'Reset Vip'],
            'rsuythac' => ['name' => 'Reset Ủy Thác'],
            'rsuythacvip' => ['name' => 'Reset Ủy Thác Vip'],
            'uythacoffline' => ['name' => 'Ủy Thác Offline'],
            'uythaconline' => ['name' => 'Ủy Thác Online'],
            'online_market' => ['name' => 'Chợ trực tuyến'],
            'pcpoint2vpoint' => ['name' => 'Đổi PCPoint'],
            'randomquest' => ['name' => 'Nhiệm vụ ngẫu nhiên'],
            'level150' => ['name' => 'Nhiệm vụ level 150'],
            'level220' => ['name' => 'Nhiệm vụ level 220'],
            'level380' => ['name' => 'Nhiệm vụ level 380'],
            'ruatoi' => ['name' => 'Rửa tội'],
            'thuepoint' => ['name' => 'Thuê điểm'],
            'rspoint' => ['name' => 'Tẩy điểm'],
        ],
        'shop' => [
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
        ],
        'relax' => array(
            'baucua' => ['name' => 'Bầu Cua'],
            'baicao' => ['name' => 'Bài Cáo'],
            'xosoDe' => ['name' => 'Xổ số kiến thiết'],
        ),
        'money' => array(
            'vpoint2gcoin' => ['name' => 'Vpoint &rsaquo;&rsaquo;&rsaquo; Gcoin'],
            'gcoin2vpoint' => ['name' => 'Gcoin &rsaquo;&rsaquo;&rsaquo; Vpoint'],
            'transgc2wc' => ['name' => 'Gcoin &rsaquo;&rsaquo;&rsaquo; Wcoin'],
            'transgc2wcp' => ['name' => 'Gcoin &rsaquo;&rsaquo;&rsaquo; WcoinP'],
            'transgc2gob' => ['name' => 'Gcoin &rsaquo;&rsaquo;&rsaquo; GoblinCoin'],
            'item2vpoint' => ['name' => 'Item V.Point &rsaquo;&rsaquo;&rsaquo; V.Point'],
            'vpoint2item' => ['name' => 'Mua Item V.Point'],
            'chuyenvpoint' => ['name' => 'Chuyển V.Point'],
            'muazen' => ['name' => 'Mua Zen bằng V.Point']

        ),
        'card' => array(
            'viettel' => ['name' => 'Viettel'],
            'mobi' => ['name' => 'Mobiphone'],
            'vina' => ['name' => 'Vinaphone'],
            'gate' => ['name' => 'Gate'],
            'vtc' => ['name' => 'VTC']
        )
    );

    if ($st < 0) {
        $st = 0;
    }
    $over = $st + $num;
    $log_read = array();


    $isActionDele = REQ('action');
    if (!empty($isActionDele) && $isActionDele) {
        if ((empty($section) || $section == 'system')) {
            $_sestion = 'system';
        } else {
            $_sestion = 'modules/' . $section;
        }

        if (file_exists(cn_path_construct(SERVDIR, 'log/' . $_sestion) . $isActionDele . '.log')) {
            unlink(cn_path_construct(SERVDIR, 'log/' . $_sestion) . $isActionDele . '.log');
        }
    }

    if (!$section || $section === 'system') {
        $_url = cn_url_modify(array('reset'), 'mod=editconfig', 'opt=logs');
        $path = cn_path_construct(SERVDIR, 'log/system') . 'error_dump.log';
        $options = $default_log['system'];

        if (file_exists($path)) {
            $r = fopen($path, 'r');

            $totalLines = intval(exec("wc -l '$path'"));

            if ($r) {
                do {
                    $n++;
                    $v = trim(fgets($r));
                    $tempLine = str_replace("\t", "|", $v);

                    if (!$tempLine) {
                        break;
                    }
                    if ($n <= $st) {
                        continue;
                    }
                    if ($n > $over) {
                        break;
                    }
                    $log_data = explode('|', $tempLine);

                    $log_read[] = array(
                        'id' => $n,
                        'status' => $log_data[0],
                        'time' => $log_data[1],
                        'name' => $log_data[2],
                        'ip' => $log_data[3],
                        'url' => $log_data[4],
                        'error' => $log_data[5]
                    );
                } while (!feof($r));
                fclose($r);
            }
        }
    } else {
        $options = $default_log[strtolower($section)];

        $logs_ = scan_dir(cn_path_construct(SERVDIR, 'log', 'modules', $section));
        $_url = cn_url_modify('mod=editconfig', 'opt=logs', 'section=' . $section, 'page', 'per_page');

        $isSub = false;
        foreach ($logs_ as $lf) {
            if (preg_match('/log_(.*)\.log/i', $lf, $c)) {
                if (isset($options[$c[1]])) {
                    $options[$c[1]]['log'] = 'log_' . $c[1];
                    if (!$isSub && empty($sub)) {
                        $sub = $c[1];
                        $isSub = true;
                    }
                }
            }
        }

        if (!empty($sub)) {
            if (!file_exists($ul = cn_path_construct(SERVDIR, 'log/modules/' . $section) . 'log_' . $sub . '.log')) {
                fclose(fopen($ul, 'w+'));
            }

            $r = fopen($ul, 'r');
            $totalLines = intval(exec("wc -l '$ul'"));
            do {
                $n++;
                $v = trim(fgets($r));
                if (!$v) {
                    break;
                }
                if ($n <= $st) {
                    continue;
                }
                if ($n >= $over) {
                    break;
                }

                $log_data = explode('|', $v);
                $tempBefore = explode('_', $log_data[2]);
                $tempAfter = explode('_', $log_data[3]);
                $gcoinDG = $tempBefore[0] - $tempAfter[0];
                $vpointDG = $tempBefore[1] - $tempAfter[1];

                $log_read[] = array(
                    'id' => $n,
                    'account' => $log_data[0],
                    'content' => $log_data[1],
                    'gc_vp_before' => number_format($tempBefore[0], 0, ',', '.') . ' ~ ' . number_format($tempBefore[1], 0, ',', '.'),
                    'gc_vp_after' => number_format($tempAfter[0], 0, ',', '.') . ' ~ ' . number_format($tempAfter[1], 0, ',', '.'),
                    'gc_vp_gd' => number_format($gcoinDG, 0, ',', '.') . ' ~ ' . (($vpointDG < 0) ? '(' . number_format($vpointDG, 0, ',', '.') . ')' : number_format($vpointDG, 0, ',', '.')),
                    'time' => $log_data[4]
                );
            } while (!feof($r));

            fclose($r);
        }
    }

    $totalLines = isset($totalLines) ? $totalLines : 0;
    $_url = isset($_url) ? $_url : '';
    $echoPagination = cn_countArr_pagination($totalLines, $_url, $page, $num);

    cn_assign('log_read, section, default_log, options, sub', $log_read, $section, $default_log, $options, $sub);
    cn_assign('echoPagination', $echoPagination);
    echo_header_admin('-@skins/mu_style.css', 'System logs');
    echo cn_execute_template('com_board/logs');
    echofooter();
}

function board_statistics()
{
    $list = getOption('#more_list');

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
            setOption('#more_list', $list);
        } else {
            if (!preg_match('/^[a-z0-9_-]+$/i', $name)) {
                cn_throw_message('Name invalid - empty or bad chars', 'e');
            }

            if ($group && !preg_match('/^[a-z0-9_-]+$/i', $group)) {
                cn_throw_message('Group field consists bad chars', 'e');
            }

            $errors = cn_get_message('e', 'c');
            if (!$errors) {
                $list[$name] = array('grp' => $group, 'type' => $type, 'desc' => $desc, 'meta' => $meta, 'req' => $req);
                setOption('#more_list', $list);
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
    echo_header_admin('-@skins/mu_style.css', 'statistics - Thống kê');
    echo cn_execute_template('com_board/statistics');
    echofooter();
}

function board_uploadFileAPIDropBox()
{
    $nameApp = trim(getOption('appNameDropBox'));
    $dropbox_config = array(
        'key' => getOption('keyDropBox'),
        'secret' => getOption('secretDropBox')
    );
    $configData = array(
        'nameApp' => $nameApp,
        'redirectUri' => getOption('redirectUriDropBox')
    );
//        'redirectUri' => (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"
    try {
        $webAuthClone = getWebAuth($dropbox_config, $configData);

        if (empty($webAuthClone)) {
            msg_info('No setup or setup failed with dropbox Api.');
        }

        $accessTokenDropBox = trim(getOption('accessTokenDropBox'));
        if (empty($accessTokenDropBox)) {
            list($code) = GET('code', 'GETPOST');
            if (empty($code)) {
                $authorizeUrl = $webAuthClone->start();
                header("Location: $authorizeUrl");
            } else {
                list($accessTokenDropBox, $userId, $urlState) = $webAuthClone->finish($_GET);

                assert($urlState === null);  // Since we didn't pass anything in start()
                setOption('accessTokenDropBox', $accessTokenDropBox);
            }
        }
    } catch (dbx\WebAuthException_BadRequest $ex) {
        msg_info($ex->getMessage());
//        error_log("/dropbox-auth-finish: bad request: " . $ex->getMessage());
        // Respond with an HTTP 400 and display error page...
    } catch (dbx\WebAuthException_Csrf $ex) {
        msg_info($ex->getMessage());
//        error_log("/dropbox-auth-finish: CSRF mismatch: " . $ex->getMessage());
        // Respond with HTTP 403 and display error page...
    } catch (dbx\WebAuthException_NotApproved $ex) {
        msg_info($ex->getMessage());
//        error_log("/dropbox-auth-finish: not approved: " . $ex->getMessage());
    } catch (dbx\WebAuthException_Provider $ex) {
        msg_info($ex->getMessage());
//        error_log("/dropbox-auth-finish: error redirect from Dropbox: " . $ex->getMessage());
    } catch (dbx\Exception $ex) {
        msg_info($ex->getMessage());
//        error_log("/dropbox-auth-finish: error communicating with Dropbox API: " . $ex->getMessage());
    }

    if ($accessTokenDropBox && $nameApp) {
        try {
            $dbxClient = new dbx\Client($accessTokenDropBox, $nameApp, 'UTF-8');
//            $accoutInfo = $dbxClient->getAccountInfo();

            if (request_type('POST')) {
                if ($_REQUEST['actionPost']) {
                    cn_dsi_check();

                    if (!empty($_SERVER['CONTENT_LENGTH']) && empty($_FILES) && empty($_POST)) {
                        echo 'The uploaded zip was too large. You must upload a file smaller than ' . ini_get("upload_max_filesize");
                    }

                    $sFileName = $_FILES['image_file']['name'];
                    if ($sFileName) {
                        $f = fopen($_FILES["image_file"]["tmp_name"], "rb");

                        $result = $dbxClient->uploadFile('/' . $sFileName, dbx\WriteMode::force(), $f);
//                $result = $dbxClient->uploadFile($sFileName, dbx\WriteMode::add(), $file);


//            $sFileType = $_FILES['image_file']['type'];
//            $sFileSize = bytesToSize1024($_FILES['image_file']['size'], 1);

                        $html = "<p>Your file: $sFileName has been successfully received.</p>
                     <p>Type: " . $result['mime_type'] . "</p>
                     <p>Size: " . $result['size'] . "</p>";

                        return $html;
                    }
                }
            }
        } catch (dbx\Exception_InvalidAccessToken $e) {
            msg_info('No setup or setup failed with dropbox Api.....');
        }
    } else {
    }

//    $f = fopen("working-draft.txt", "rb");
//    $result = $dbxClient->uploadFile("/working-draft.txt", dbx\WriteMode::add(), $f);
//    fclose($f);
//    print_r($result);

//    $folderMetadata = $dbxClient->getMetadataWithChildren("/");
//    print_r($folderMetadata);

//    $f = fopen("working-draft.txt", "w+b");
//    $fileMetadata = $dbxClient->getFile("/working-draft.txt", $f);
//    fclose($f);
//    print_r($fileMetadata);

    echo_header_admin('-@skins/mu_style.css@com_board/downloadapi_dropbox.js', 'download Api - download');
    echo cn_execute_template('com_board/downloadApi');
    echofooter();
}

function getWebAuth($dropbox_config, $configData)
{
    if (empty($dropbox_config['key']) || empty($dropbox_config['secret']) || empty($configData['nameApp']) || empty($configData['redirectUri'])) {
        return;
    }
    $clientIdentifier = $configData['nameApp'] . "/1.0";
    $redirectUri = $configData['redirectUri'];
    $appInfo = dbx\AppInfo::loadFromJson($dropbox_config);

    $csrfTokenStore = new dbx\ArrayEntryStore($_SESSION, 'dropbox-auth-csrf-token');

    return new dbx\WebAuth($appInfo, $clientIdentifier, $redirectUri, $csrfTokenStore);
}

function board_uploadFileAPIGoogle()
{
    if (empty(APPLICATION_NAME)) {
        msg_info('Application name undefined drive api');
    }

    if (empty(CLIENT_SECRET_PATH)) {
        msg_info('File \'client_secret.json\' does not exist');
    }

    list($code) = GET('code', 'GETPOST');
    $client = getClient($code);
    $service = new Google_Service_Drive($client);

    $fileStatus = array(
        'status' => 1,
        'message' => '',
        'statusUpload' => '',
        'body' => ''
    );

    if (request_type('POST')) {
        global $request;

        @$actionUpload = $request->actionUpload;
        if (isset($_REQUEST['actionUpload']) && $_REQUEST['actionUpload'] || isset($actionUpload) && $actionUpload) {
            cn_dsi_check();

            $mimes = array(
                'image/jpeg',
                'image/png',
                'image/gif',
                'application/msword',
                'application/octet-stream', // ...
                'text/css',
                'text/plain',
                'application/x-msdownload', // .exe
                'video/mp4',
                'audio/x-aac',
                'audio/mp3',
            );

            if (isset($_FILES['myfile']) && $client->getAccessToken()) {
                $nameFiles = $_FILES['myfile'];

                try {
                    $file = new Google_Service_Drive_DriveFile();
//                    foreach ($nameFiles['name'] as $key => $items) {
//                        if (empty($nameFiles['error'][$key])) {
                    if (empty($nameFiles['error'])) {
                        $fileName = $nameFiles['name'];
                        $fileType = $nameFiles['type'];
                        $fileError = $nameFiles['error'];

                        if ($fileError == 1) {
                            //Lỗi vượt dung lượng
                            $fileStatus['message'] = 'Dung lượng quá giới hạn cho phép';
                        } elseif (!in_array($fileType, $mimes)) {
                            //Kiểm tra định dạng file
                            $fileStatus['message'] = 'Không cho phép định dạng này';
                        } else {
                            //Không có lỗi nào
//                              move_uploaded_file($nameFiles['tmp_name'][$key], 'uploads/' . $fileName);

                            $file->setName($fileName);
                            $file->setDescription('A test document');
                            $file->setMimeType($fileType);
                            $data = file_get_contents($nameFiles['tmp_name']);

                            $createdFile = $service->files->create($file, array(
                                'data' => $data,
                                'mimeType' => $fileType,
                                'uploadType' => 'multipart'
                            ));

                            if ($createdFile->getId()) {
                                do_insert_character(
                                    'ListFileApiCloud',
                                    "nameFile='" . $fileName . "'",
                                    "alias='" . $createdFile->getId() . "'",
                                    'createTime=' . ctime()
                                );

                                $fileStatus['message'] = "Bạn đã upload $fileName thành công";
                                $fileStatus['statusUpload'] = "upload thành công";
                                $fileStatus['status'] = 0;
                            }
                        }
                    }
//                    }
                } catch (Google_Service_Exception $ex) {
                    $fileStatus['message'] = $ex->getMessage();
                }
//                $dataResults = selectListFiles($service);
//                $fileStatus['body'] = $dataResults;

                header('Content-Type: application/json');
                return json_encode($fileStatus);

//            /************************************************
//             * If we're signed in then lets try to upload our
//             * file.
//             ************************************************/
//            if ($_SERVER['REQUEST_METHOD'] == 'POST' && $client->getAccessToken()) {
//                /************************************************
//                 * We'll setup an empty 20MB file to upload.
//                 ************************************************/
//                DEFINE("TESTFILE", 'testfile.txt');
//                if (!file_exists(TESTFILE)) {
//                    $fh = fopen(TESTFILE, 'w');
//                    fseek($fh, 1024 * 1024 * 20);
//                    fwrite($fh, "!", 1);
//                    fclose($fh);
//                }

//                $file = new Google_Service_Drive_DriveFile();
//                $file->name = "Big File";
//                $chunkSizeBytes = 1 * 1024 * 1024;
//                // Call the API with the media upload, defer so it doesn't immediately return.
//                $client->setDefer(true);
//                $request = $service->files->create($file);
//                // Create a media file upload to represent our upload process.
//                $media = new Google_Http_MediaFileUpload(
//                    $client,
//                    $request,
//                    'text/plain',
//                    null,
//                    true,
//                    $chunkSizeBytes
//                );
//
//                $media->setFileSize(filesize(TESTFILE));
//                // Upload the various chunks. $status will be false until the process is
//                // complete.
//                $status = false;
//                $handle = fopen(TESTFILE, "rb");
//                while (!$status && !feof($handle)) {
//                    // read until you get $chunkSizeBytes from TESTFILE
//                    // fread will never return more than 8192 bytes if the stream is read buffered and it does not represent a plain file
//                    // An example of a read buffered file is when reading from a URL
//                    $chunk = readVideoChunk($handle, $chunkSizeBytes);
//                    $status = $media->nextChunk($chunk);
//                }
//                // The final value of $status will be the data from the API for the object
//                // that has been uploaded.
//                $result = false;
//                if ($status != false) {
//                    $result = $status;
//                }
//                fclose($handle);
//
//                try {
//                    $service->files->delete($fileId);
//                } catch (Exception $e) {
//                    print "An error occurred: " . $e->getMessage();
//                }
            }
        }
    }

    if (isset($_REQUEST['actAng']) && ($_REQUEST['actAng'] == 1)) {
        list($sort, $isTrash) = GET('sort, trash', 'GPG');
        $dataResult = selectListFiles($service, $sort, $isTrash);

        $fileStatus['body'] = $dataResult;
        if (empty($dataResult['status'])) {
            $fileStatus['status'] = 0;
        }

        header('Content-Type: application/json');
        return json_encode($fileStatus);
    }

    echo_header_admin('-@skins/mu_style.css@com_board/uploadApiGoogleDrivers.js', 'Api-Upload file to GoogleDrivers');
    echo cn_execute_template('com_board/downloadApiGoogle');
    echofooter();
}

function selectListFiles($service, $sort, $isTrash)
{
    if (strtolower($sort) == 'a') {
        $namSort = 'asc';
    } else {
        $namSort = 'desc';
    }
    $resultData = do_select_other("SELECT * FROM ListFileApiCloud WHERE typeApi=0 ORDER BY createTime $namSort");

    $resultDataClone = array();
    $resultDataResult = array(
        'status' => 0,
        'msg' => '',
        'data' => ''
    );

    $optParams = array(
        'orderBy' => "createdTime $namSort",
//        'pageSize' => 20,
        'fields' => 'nextPageToken, files(id, name, modifiedTime, createdTime, mimeType, size, originalFilename)',

        'q' => "trashed=$isTrash"
    );

    try {
        $results = $service->files->listFiles($optParams);
        if (count($results->getFiles())) {
            foreach ($results->getFiles() as $keys => $file) {
                $key = trim($file->getId());
                $resultDataClone[$key]['name'] = $file->getName();
                $resultDataClone[$key]['ID'] = $file->getId();
                $resultDataClone[$key]['mimeType'] = $file->getMimeType();
                $resultDataClone[$key]['size'] = bytesToSize1024($file->getSize());
                $resultDataClone[$key]['originalFilename'] = $file->getOriginalFilename();
                $resultDataClone[$key]['modifiedTime'] = cn_Rfc3339ToDateTime($file->getModifiedTime(), 'D, d-m-Y H:i:s');
                $resultDataClone[$key]['createdTime'] = cn_Rfc3339ToDateTime($file->getCreatedTime(), 'D, d-m-Y H:i:s');
                $resultDataClone[$key]['sortTime'] = strtotime($file->getCreatedTime());
//                $resultDataClone[]['getOriginalFilename'] =  $file->getOriginalFilename();
            }
        }
    } catch (Exception $e) {
        $resultDataResult['msg'] = $e->getMessage();
        $resultDataResult['status'] = 1;
    }

    if ($resultDataClone && $resultData) {
        foreach ($resultData as $kr => $item) {
            if (!isset($resultDataClone[trim($item['alias'])])) {
                unset($resultData[$kr]);
                continue;
            }
            $resultData[$kr]['size'] = $resultDataClone[$item['alias']]['size'];
            $resultData[$kr]['mimeType'] = $resultDataClone[$item['alias']]['mimeType'];
            $resultData[$kr]['modifiedTime'] = $resultDataClone[$item['alias']]['modifiedTime'];
            $resultData[$kr]['createdTime'] = $resultDataClone[$item['alias']]['createdTime'];
            $resultData[$kr]['sortTime'] = $resultDataClone[$item['alias']]['sortTime'];
            $resultData[$kr]['isTrash'] = $isTrash;
        }
        $resultDataResult['data'] = $resultData;
    } else {
        $resultDataResult['status'] = 1;
        $resultDataResult['msg'] = 'Error Select List';
    }

    return $resultDataResult;
}

function broad_downloadApiMediafrie()
{
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require_once("../mflib.php");

    $appId = "";
    $apiKey = "";
    $email = "";
    $password = "";

//    <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
//    <head>
//        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
//        <title>PHP - MediaFire API Library - File Uploading With Get Link</title>
//    </head>
//    <body>
//    <form method="post" enctype="multipart/form-data" action="">
//        <p>Upload a file:</p>
//        <label title="Choose a Local File to a MediaFire account" for="file">File:</label>
//        <input type="file" id="file" name="file" size="30" />
//        <div style="clear:left;display:block;" id="dvFile"></div>
//        <input type="submit" id="upload" name="upload" value="Upload" />
//    </form>
//    </body>
//    </html>
//

    if (isset($_POST['upload'])) {
        $mflib = new mflib($appId, $apiKey);
        $mflib->email = $email;
        $mflib->password = $password;
        $token = $mflib->userGetSessionToken(null);

        $uploadkey = $mflib->fileUpload($token, $_FILES["file"]["tmp_name"], "myfiles", $_FILES["file"]["name"]);
        $fileDetails = $mflib->filePollUpload($token, $uploadkey);
        $link = $mflib->fileGetLinks($fileDetails['quickkey'], "direct_download", $token);


        print_r($link);
    }
}

function board_select()
{
    list($sub, $sort, $page) = GET('sub, sort, page', "GETPOST");
    $class_board = array();

//    $class_board = array(
//        'class_none' => 'All',
//        'class_gate' => 'Gate',
//        'class_mobi' => 'Mobifone',
//        'class_vina' => 'VinaPhone',
//        'class_viettel' => 'Viettel',
//        'class_vtc' => 'Vtc'
//    );
//    if (empty($sub)) {
//        $sub = 'class_none';
//    }
//    if (empty($sort)) {
//        $sort = 'desc';
//    }
    if (empty($page) || $page <= 0) {
        $page = 1;
    }

    $url = cn_url_modify(array('reset'), 'mod=ranking', 'opt=rickCard', 'sub=' . $sub, 'sort=' . strtolower($sort), 'per_page', 'page');


    if (request_type('POST')) {
        if (isset($_REQUEST['sub'])) {
            cn_checkDisk();
            list($arrRankingCharater, $pagination) = zenderRankingCharacter($sub, $url, $page, strtoupper($sort));

            $resultData = array(
                'id-sub' => $sub,
                'id-sort' => $sort,
                'result_content' => zenderDataContent($arrRankingCharater),
                'result_pagination' => $pagination
            );

            header('Content-Type: application/json');
            return json_encode($resultData);
        }
    }
//    list ($arrRankingCharater, $pagination) = zendeHtmlExecute();
//    list ($arrRankingCharater, $pagination) = zendeHtmlExecute($sub, $url, $page, strtoupper($sort));

    cn_assign('sub, pagination, sort, result_content', $sub, '', $sort, array());

    echo_header_admin('-@skins/mu_style.csss@com_board/executeSelect.js', "Select");
    echo cn_execute_template('com_board/selsect');
    echofooter();
}

/**
 * Expands the home directory alias '~' to the full path.
 * @param string $path the path to expand.
 * @return string the expanded path.
 */
function expandHomeDirectory($path)
{
    $homeDirectory = getenv('HOME');
    if (empty($homeDirectory)) {
        $homeDirectory = getenv('HOMEDRIVE') . getenv('HOMEPATH');
    }
    return str_replace('~', realpath($homeDirectory), $path);
}

function board_apiDriverdChangeShare()
{
    if (request_type('POST')) {
        try {
            cn_dsi_check();

            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);

            $alias = htmlentities(html_entity_decode(trim($request->alias)));
            $shareDownload = (int)$request->shareDownload;
            $shareDownloadChange = ($shareDownload == 1) ? 0 : 1;
            $result = array(
                'messgase' => '',
                'status' => 1,
                'atcDownload' => $shareDownload
            );

            $isChek = do_update_other("UPDATE ListFileApiCloud SET shareDownload=$shareDownloadChange WHERE alias='$alias'");

//            $shareDownloadChange = $shareDownload;
            if ($isChek) {
                $result['msg'] = 'ok';
                $result['status'] = 0;
                $result['atcDownload'] = $shareDownloadChange;
            } else {
                $result['msg'] = 'Error update';
            }
        } catch (Exception $ex) {
            $result['msg'] = $ex->getMessage();
        }

        header('Content-Type: application/json');
        return json_encode($result);
    }
}

function board_apiRestoreDriver()
{
}

function board_apiDeleteDrivers()
{
    if (request_type('POST')) {
        $result = array(
            'messgase' => '',
            'status' => 1,
            'f' => ''
        );

        try {
            cn_dsi_check();
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);
            list($code) = GET('code', 'GETPOST');
            $client = getClient($code);
            $service = new Google_Service_Drive($client);
            if ($request->alias) {
                $alias = htmlentities(html_entity_decode(trim($request->alias)));

                $service->files->delete($alias);
                $isChek = do_update_other("UPDATE ListFileApiCloud SET isDelete=1 WHERE alias='$alias'");

//            $shareDownloadChange = $shareDownload;
                if ($isChek) {
                    $result['msg'] = 'ok';
                    $result['status'] = 0;
                } else {
                    $result['msg'] = 'Error execute';
                }
            }
        } catch (Exception $ex) {
            $result['msg'] = $ex->getMessage();
        }

        header('Content-Type: application/json');
        return json_encode($result);
    }
}

function board_apiEditDrivers()
{
}
