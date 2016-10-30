<?php if (!defined('BQN_MU')) die('Access restricted');

add_hook('index/invoke_module', '*dashboard_invoke');

// =====================================================================================================================

function dashboard_invoke()
{
    $dashboard = array
    (
        'charge:sysconf:Csc' => 'Thẻ VTC',
        'charge:personal:Cp' => 'Thẻ Gate',
        'charge:templates:Ct' => 'Thẻ Viettel',
        'charge:category:Cc' => 'Thẻ Mobi',
        'charge:intwiz:Ciw' => 'Thẻ Vina',
    );

    // Call dashboard extend
    $dashboard = hook('extend_dashboard', $dashboard);

    // Exec
    $mod = REQ('mod', 'GETPOST');
    $opt = REQ('opt', 'GETPOST');


    // Top level (dashboard)
    cn_bc_add('Dashboard', cn_url_modify(array('reset'), 'mod=' . $mod));


    // Request module
    foreach ($dashboard as $id => $_t) {
        list($dl, $do, $acl_module) = explode(':', $id);


        //if (test($acl_module) && $dl == $mod && $do == $opt && function_exists("dashboard_$opt"))
        if ($dl == $mod && $do == $opt && function_exists("dashboard_$opt")) {
            cn_bc_add($_t, cn_url_modify(array('reset'), 'mod=' . $mod, 'opt=' . $opt));
            die(call_user_func("dashboard_$opt"));
        }
    }

    echoheader('-@com_charge/style.css', "Cutenews dashboard");

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
        'comments' => 'comments.png',
    );

    // More dashboard images
    $images = hook('extend_dashboard_images', $images);

    foreach ($dashboard as $id => $name) {
        list($mod, $opt, $acl) = explode(':', $id, 3);

        //if (!test($acl))
        //{
        //  unset($dashboard[$id]);
        //continue;
        //}

        $item = array
        (
            'name' => $name,
            'img' => isset($images[$opt]) ? $images[$opt] : 'home.gif',
            'mod' => $mod,
            'opt' => $opt,
        );

        $dashboard[$id] = $item;
    }


    //$member = member_get();

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

    $nameset = 'bqngoc';
    //$nameset = $_SESSION['users'];

    $greeting_message = 'Have a nice day!';
    //cn_assign('dashboard, username, greeting_message', $dashboard, $member['name'], $greeting_message);
    cn_assign('dashboard, username, greeting_message', $dashboard, $nameset, $greeting_message);

    //echo exec_tpl('header');
    echo exec_tpl('com_charge/general');

    echofooter();
}

// =====================================================================================================================
// Since 2.0: System configurations

function dashboard_sysconf()
{

    $lng = $grps = $all_skins = array();
    $skins = scan_dir(cn_path_construct(SERVDIR, 'skins'));
    $langs = scan_dir(cn_path_construct(SERVDIR, 'core', 'lang'), 'txt');
    $_grps = getoption('#grp');


    // fetch skins
    foreach ($skins as $skin) {
        if (preg_match('/(.*)\.skin\.php/i', $skin, $c)) //<=> *.skin.php
        {
            $all_skins[$c[1]] = $c[1];
        }
    }

    // fetch lang packets
    foreach ($langs as $lf) {
        if (preg_match('/(.*)\.txt/i', $lf, $c)) {
            $lng[$c[1]] = $c[1];
        }
    }

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

            'skin' => array('select', 'CuteNews skin', $all_skins),
            'cn_language' => array('select', 'CuteNews internationalization', $lng),
            'useutf8' => array('Y/N', 'Use UTF-8 for ACP|with this option, admin panel uses utf-8 charset'),
            'utf8html' => array('Y/N', "Convert UTF8 symbols to HTML entities|E.g. &aring to &amp;aring;"),
            'comment_utf8html' => array('Y/N', 'Convert UTF8 symbols for comments|if this option is set, utf-8 entities convert to html entities'),
            'frontend_encoding' => array('select', 'Frontend encoding|encoding that used on your site', array(
                'UTF-8' => 'UTF-8', 'UCS-4' => 'UCS-4', 'UCS-4BE' => 'UCS-4BE', 'UCS-4LE' => 'UCS-4LE', 'UCS-2' => 'UCS-2', 'UCS-2BE' => 'UCS-2BE', 'UCS-2LE' => 'UCS-2LE',
                'UTF-32' => 'UTF-32', 'UTF-32BE' => 'UTF-32BE', 'UTF-32LE' => 'UTF-32LE', 'UTF-16' => 'UTF-16', 'UTF-16BE' => 'UTF-16BE',
                'UTF-16LE' => 'UTF-16LE', 'UTF-7' => 'UTF-7', 'UTF7-IMAP' => 'UTF7-IMAP', 'ASCII' => 'ASCII', 'EUC-JP' => 'EUC-JP', 'SJIS' => 'SJIS', 'eucJP-win' => 'eucJP-win',
                'SJIS-win' => 'SJIS-win', 'ISO-2022-JP' => 'ISO-2022-JP', 'ISO-2022-JP-MS' => 'ISO-2022-JP-MS', 'CP932' => 'CP932',
                'CP51932' => 'CP51932', 'JIS' => 'JIS', 'JIS-ms' => 'JIS-ms', 'CP866' => 'CP866', 'CP949' => 'CP949',
                'CP1251' => 'CP1251', 'CP1252' => 'CP1252', 'CP50220' => 'CP50220', 'CP50220raw' => 'CP50220raw', 'CP50221' => 'CP50221', 'CP50222' => 'CP50222',
                'ISO-8859-1' => 'ISO-8859-1', 'ISO-8859-2' => 'ISO-8859-2', 'ISO-8859-3' => 'ISO-8859-3', 'ISO-8859-4' => 'ISO-8859-4',
                'ISO-8859-5' => 'ISO-8859-5', 'ISO-8859-6' => 'ISO-8859-6',
                'ISO-8859-7' => 'ISO-8859-7', 'ISO-8859-8' => 'ISO-8859-8', 'ISO-8859-9' => 'ISO-8859-9', 'ISO-8859-10' => 'ISO-8859-10', 'ISO-8859-13' => 'ISO-8859-13',
                'ISO-8859-14' => 'ISO-8859-14', 'ISO-8859-15' => 'ISO-8859-15', 'EUC-CN' => 'EUC-CN', 'CP936' => 'CP936', 'HZ' => 'HZ',
                'EUC-TW' => 'EUC-TW', 'CP950' => 'CP950', 'BIG-5' => 'BIG-5',
                'EUC-KR' => 'EUC-KR', 'ISO-2022-KR' => 'ISO-2022-KR', 'KOI8-R' => 'KOI8-R'
            )),
            'use_wysiwyg' => array('Y/N', 'Use CKEditor in news'),
            'ckeditor2template' => array('Y/N', 'Use CKEditor for templates'),
            'date_adjust' => array('int', 'Time adjustment|in hours; eg. : +3 hours =180 minutes; -2 hours = -120 minutes'),
            'smilies' => array('text', 'Smilies'),
            'base64_encode_smile' => array('Y/N', 'Encode smile|Hide smiles path'),
            'allow_registration' => array('Y/N', 'Allow self-Registration|allow users to register automatically'),
            'registration_level' => array('select', 'Self-registration level', $grps),
            'config_login_ban' => array('int', 'Limit the number of login attempts|eg: user block after failed 5 login template within 6 hours'),
            'ban_attempts' => array('int', 'Seconds between login attempts'),
            'ipauth' => array('Y/N', 'Check IP|stronger authenticate (by changing this setting, you will be logged out)'),
            'userlogs' => array('Y/N', 'Enable user logs'),
            'allowed_extensions' => array('text', 'Allowed extensions|Used by file manager. Enter by comma without space'),
            'category_style' => array('select', 'Category style', array('list' => "Listing", 'select' => 'Drop-down menu')),
            'auto_archive' => array('Y/N', 'Automatic archiving every month'),
            'use_replacement' => array('Y/N', 'Use word replace module'),
            'client_online' => array('int', 'Expiration time client online|If 0, client online disabled'),
            'show_thumbs' => array('Y/N', 'Show thumbnail files in media gallery'),
            'num_center_pagination' => array('int', 'Centering the pagination|Center the Page number using pagination'),
            'thumbnail_with_upload' => array('Y/N', 'Generate thumbnail after upload big image'),
            'max_thumbnail_width' => array('int', 'Max image width (in px)|Larger than the specified size is considered a big'),
            'uploads_dir' => array('text', 'Server upload dir|Real path on server'),
            'uploads_ext' => array('text', 'Frontend upload dir|Frontend path for uploads'),
        ),

        'news' => array
        (
            'search_hl' => array('Y/N', 'Highlight search'),
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
            'week_list' => array('text', 'Weeks list|comma separated, 7 variables'),
            'disable_title' => array('Y/N', 'Title field will not be required'),
            'disable_short' => array('Y/N', 'Short story field will not be required'),
        ),

        'comments' => array
        (
            'comments_std_show' => array('Y/N', 'Show standart comments|show/hide standart comment system'),
            'reverse_comments' => array('Y/N', 'Reverse comments|newest comments will be shown at the top'),
            'flood_time' => array('int', 'Comments flood protection|in seconds; 0 = no protection'),
            'comment_max_long' => array('int', 'Max. Length of comments in characters|enter <b>0</b> to disable checking'),
            'comments_per_page' => array('int', 'Comments per page (pagination)|enter <b>0</b> or leave empty to disable pagination'),
            'only_registered_comment' => array('Y/N', 'Only registered users can post comments|if yes, only registered users can post comments'),
            'allow_url_instead_mail' => array('Y/N', 'Allow mail field to act as URL field|visitors will be able to put their site URL instead of an email'),
            'comments_popup' => array('Y/N', 'Show comments in popup|comments will be opened in PopUp window'),
            'comments_popup_string' => array('text', "Settings for comments popup|only if 'Show Comments In PopUp' is enabled"),
            'show_full_with_comments' => array('Y/N', 'Show full story when showing comments|if yes, comments will be shown under the story'),
            'timestamp_comment' => array('text', 'Time format for comments|view help for time formatting <a href="http://www.php.net/manual/en/function.date.php" target="_blank">here</a>'),
            'check_email_comment' => array('Y/N', 'Check email or site before add comment'),
        ),

        'notify' => array
        (
            'notify_registration' => array('Y/N', 'Notify of new registrations|automatic registration of new users'),
            'notify_comment' => array('Y/N', 'Notify of new comments|when new comment is added'),
            'notify_unapproved' => array('Y/N', 'Notify of unapproved news|when unapproved article is posted (by journalists)'),
            'notify_archive' => array('Y/N', 'Notify of auto-archiving|when (if) news are auto-archived'),
            'notify_email' => array('text', 'Email(s)|where the notification will be send, separate multyple emails by comma'),
        ),

        'social' => array
        (
            '_COM' => array('title', 'General:'),
            'i18n' => array('text', 'Language code|by default en_US. See: <a href="http://en.wikipedia.org/wiki/Language_localization#Language_tags_and_codes">codes</a>'),

            '_FB' => array('title', 'Facebook:'),
            'use_fbcomments' => array('Y/N', 'Use facebook comments for post|if yes, facebook comments will be shown'),
            'fb_inactive' => array('Y/N', 'In active news|Show in active news list'),
            'fb_appid' => array('text', 'Facebook application ID|<a href="https://developers.facebook.com/apps" target="_blank">https://developers.facebook.com/apps</a>'),

            '_FB_c' => array('title', 'Facebook comments:'),
            'fb_comments' => array('int', 'Comments number|Count comment under top box'),
            'fb_box_width' => array('int', 'Box width|In pixels'),
            'fbcomments_color' => array('select', 'Color scheme|The color scheme of the plugin', array("light" => "Light", "dark" => "Dark")),

            '_FB_lb' => array('title', 'Facebook Like button:'),
            'use_fblike' => array('Y/N', 'Use facebook like button|if yes, facebook button will be shown'),
            'fblike_send_btn' => array('Y/N', 'Send Button|include a send button'),
            'fblike_style' => array('select', 'Layout style|determines the size and amount of social context next to the button', array("standard" => "standard", "button_count" => "button_count", "box_count" => "box_count")),
            'fblike_width' => array('int', 'Box width|In pixels'),
            'fblike_show_faces' => array('Y/N', 'Show faces|if yes, profile pictures below the button will be shown'),
            'fblike_font' => array('select', 'Font|The font of the plugin', array("arial" => "Arial", "lucida grande" => "Lucida grande", "segoe ui" => "Segoe ui", "tahoma" => "Tahoma", "trebuchet ms" => "Trebuchet ms", "verdana" => "Verdana")),
            'fblike_color' => array('select', 'Color scheme|The color scheme of the plugin', array("light" => "Light", "dark" => "Dark")),
            'fblike_verb' => array('select', 'Verb to display|The verb to display in the button', array("like" => "Like", "recommend" => "Recommend")),

            '_TW' => array('title', 'Twitter button:'),
            'use_twitter' => array('Y/N', 'Use twitter button|if yes, twitter button will be shown'),
            'tw_url' => array('text', 'Share URL|if empty, use the page URL'),
            'tw_text' => array('text', 'Tweet text|if empty, use the title of the page'),
            'tw_show_count' => array('Y/N', 'Show count|if yes, count of tweets will be shown near button', array("horisontal" => "Horisontal", "vertical" => "Vertical", "none" => "None")),
            'tw_via' => array('text', 'Via @|Screen name of the user to attribute the Tweet to'),
            'tw_recommended' => array('text', 'Recommended @|Accounts suggested to the user after tweeting, comma-separated.'),
            'tw_hashtag' => array('text', 'Hashtag #|Comma-separated hashtags appended to the tweet text'),
            'tw_large' => array('Y/N', 'Large button|if yes, the twitter button will be large'),
            'tw_lang' => array('select', 'Language|The language of button text', array("en" => "English", "fr" => "French", "ar" => "Arabic", "ja" => "Japanese", "es" => "Spanish", "de" => "German", "it" => "Italian", "id" => "Indonesian", "pt" => "Portuguese", "ko" => "Korean", "tr" => "Turkish", "ru" => "Russian", "nl" => "Dutch", "fil" => "Filipino", "msa" => "Malay", "zh-tw" => "Traditional Chinese", "zh-cn" => "Simplified Chinese", "hi" => "Hindi", "no" => "Norwegian", "sv" => "Swedish", "fi" => "Finnish", "da" => "Danish", "pl" => "Polish", "hu" => "Hungarian", "fa" => "Farsi", "he" => "Hebrew", "ur" => "Urdu", "th" => "Thai", "uk" => "Ukrainian", "ca" => "Catalan", "el" => "Greek", "eu" => "Basque", "cs" => "Czech", "gl" => "Galician", "ro" => "Romanian")),

            // use_gplus + gplus_i18n
            '_G+' => array('title', 'Google+ button:'),
            'use_gplus' => array('Y/N', 'Use +1 button'),
            'gplus_size' => array('select', 'Button size', array("small" => "Small", "medium" => "Medium", "standard" => "Standard", "tall" => "Tall")),
            'gplus_annotation' => array('select', 'Annotation|Sets the annotation to display next to the button.', array('inline' => 'Inline', 'bubble' => 'Bubble', 'none' => 'None')),
            'gplus_width' => array('int', 'Box width, in pixels'),
        ),

        'ckeditor' => array
        (
            '_TIP' => array('title', 'See <a href="http://docs.cksource.com/CKEditor_3.x/Developers_Guide/Toolbar" target="_blank">CKEditor toolbar customization</a>'),
            'ck_ln1' => array('text', "Row 1|Reqired"),
            'ck_ln2' => array('text', "Row 2|Optional"),
            'ck_ln3' => array('text', "Row 3|Optional"),
            'ck_ln4' => array('text', "Row 4|Optional"),
            'ck_ln5' => array('text', "Row 5|Reqired"),
            'ck_ln6' => array('text', "Row 6|Optional"),
            'ck_ln7' => array('text', "Row 7|Optional"),
            'ck_ln8' => array('text', "Row 8|Optional"),
            'cklang' => array('text', "Ckeditor lang"),
        ),

        'rewrite' => array
        (
            'rw_engine' => array('Y/N', "Use rewrite engine"),
            'rw_htaccess' => array('label', ".htaccess real path|Automatic, not modify by user"),
            'rw_layout' => array('text', "Real path to your layout file|e.g. /home/userdir/www/layout.php"),
            'rw_prefix' => array('text', "Rewrite prefix|e.g. /news/"),
            'rw_use_shorten' => array('Y/N', "Disable .html at end of urls"),
        ),
    );

    // System help
    $help = hook('sysconf/helper', array
    (
        'http_script_dir' => 'Necessary in order to embed in websites scripts determined where the administrative panel for the correct CN obtaining the necessary resources, such as smilies or images.',
    ));

    // Static rewrite path
    $cfg = mcache_get('config');

    // Set .htaccess root
    $SN = dirname($_SERVER['SCRIPT_NAME']);

    // Make rewrite path
    //$cfg['%site']['rw_htaccess'] = (($SN == DIRECTORY_SEPARATOR) ? SERVDIR : substr(SERVDIR, 0, -strlen($SN))) .DIRECTORY_SEPARATOR.'.htaccess';
    $cfg['%site']['rw_htaccess'] = (SERVDIR . '\core') . DIRECTORY_SEPARATOR . '.htaccess';

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
        //if (empty($post_cfg['rw_layout']))
        //{
        //$post_cfg['rw_layout']   = SERVDIR .DIRECTORY_SEPARATOR .'example.php';
        //}

        // .htaccess rewrite
        if (isset($post_cfg['rw_engine']) && $post_cfg['rw_engine']) {
            if (!file_exists($fn = getoption('rw_htaccess'))) {
                fclose(fopen($fn, "w+"));
            }

            // refresh .htaccess file
            $w = array();
            $s = FALSE;
            $rw_engine_on = FALSE;
            $fx = file($fn);

            // Exclude Cutenews rewrite section
            foreach ($fx as $v) {
                if (trim($v) == '# --- CUTENEWS[ST]') {
                    $s = TRUE;
                }
                if (!$s) {
                    $v = trim($v);
                    if (preg_match('/^RewriteEngine\s+ON/i', $v)) {
                        $rw_engine_on = TRUE;
                    }

                    $w[] = trim($v) . "\n";
                }
                if (trim($v) == '# --- CUTENEWS[ED]') {
                    $s = FALSE;
                }
            }

            $URI = dirname(preg_replace('/\?.*$/', '', $_SERVER['REQUEST_URI']) . '.html');
            if ($URI == '/') {
                $URI = '/show_news.php'; //??????????????????/
            } else {
                $URI .= '/show_news.php';
            }

            // Add Cutenews rewrite rules
            $w[] = "# --- CUTENEWS[ST]\n";

            if (!$rw_engine_on) {
                $w[] = "RewriteEngine ON\n";
            }

            $w[] = "RewriteCond %{REQUEST_FILENAME} !-d\n";
            $w[] = "RewriteCond %{REQUEST_FILENAME} !-f\n";
            $w[] = "RewriteRule ^(.*)$ " . $URI . "?cn_rewrite_url=$1 [L]\n";
            $w[] = "# --- CUTENEWS[ED]\n";

            $fw = fopen($fn, "w+");
            fwrite($fw, join('', $w));
            fclose($fw);

        }

        // all
        foreach ($by_default as $id => $var) {
            if ($var[0] == 'text' || $var[0] == 'select') {
                $opt_result[$id] = $post_cfg[$id];
            } elseif ($var[0] == 'int') {
                $opt_result[$id] = intval($post_cfg[$id]);
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
        $options[$id]['help'] = isset($help[$id]) ? i18n($help[$id]) : '';

        unset($options[$id][1]);
    }

    if (REQ('message', 'GET') == 'saved') {
        unset($_GET['message']);
        cn_throw_message('Successfully saved');
    }

    cn_assign('options, sub, options_list', $options, $sub, $options_list);

    echoheader('-@dashboard/style.css', "System configurations");
    //echo exec_tpl('header');
    echo exec_tpl('dashboard/sysconf');
    echofooter();
}

// =====================================================================================================================
// Since 2.0: Personal options
function dashboard_personal()
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
// Since 2.0: Category management
function dashboard_category()
{
    global $db;

    list($category_id, $mode) = GET('category_id, mode');
    list($category_name, $category_memo, $category_icon, $category_parent, $category_acl, $category_description) = GET('category_name, category_memo, category_icon, category_parent, category_acl, category_description', "POST");

    if (isset($category_id)) {
        $category_id = stripslashes($category_id);
        $category_id = mysqli_real_escape_string($db, $category_id);
    }
    if (isset($category_name)) {
        $category_name = stripslashes($category_name);
        $category_name = mysqli_real_escape_string($db, $category_name);
    }
    if (isset($category_memo)) {
        $category_memo = stripslashes($category_memo);
        $category_memo = mysqli_real_escape_string($db, $category_memo);
    }
    if (isset($category_icon)) {
        $category_icon = stripslashes($category_icon);
        $category_icon = mysqli_real_escape_string($db, $category_icon);
    }
    if (isset($category_parent)) {
        $category_parent = stripslashes($category_parent);
        $category_parent = mysqli_real_escape_string($db, $category_parent);
    }
    //if(isset($category_name)) {$category_name = stripslashes($category_name);$category_name = mysqli_real_escape_string($db,$category_name);}
    if (isset($category_description)) {
        $category_description = stripslashes($category_description);
        $category_description = mysqli_real_escape_string($db, $category_description);
    }
    //else $category_id =0;
    //$category_id = intval($category_id_);

    //if(!empty($category_parent_)) {$category_parent = stripslashes($category_parent_);$category_parent = mysqli_real_escape_string($db,$category_parent);}
    //else $category_parent = 0;
    //if(isset($category_acl_)) {$category_acl = stripslashes($category_acl_);$category_acl = mysqli_real_escape_string($db,$category_acl);}
    /*
    if(!empty($category_name_))
        $category_name = UTF8ToEntities($category_name_);
    else
        $category_name ='';
    if(!empty($category_memo_))
        $category_memo = UTF8ToEntities($category_memo_);
    else
        $category_memo ='';
    if(!empty($category_icon_))
        $category_icon = UTF8ToEntities($category_icon_);
    else
        $category_icon ='';
    if(!empty($category_description_))
        $category_description = UTF8ToEntities($category_description_);
    else
        $category_description = '';
    */

    $is_edit = $category_id && $mode == 'e';
    $is_add = $mode == 'a';
    $is_delete = $category_id && $mode == 'd';
    $is_cancel = $category_id && $mode == 'c';

    $groups = getoption('#grp');
    //$categories_call = getoption('#category');
    list($categories_call) = cn_category_struct_display();

    /*	$categories_data = array();
        $categories_call = array();

        $gd = $db -> query("SELECT * FROM `forums`;");
        while($catfor = $gd ->fetch_assoc()) //fetch_array //fetch_assoc
            $categories_data[] = $catfor;


        //-----------------------------------------------------------------
        if(!empty($categories_data)){
            foreach ($categories_data as $cm=> $hh){
                $_cm = $hh['id'];
                $categories_call[$_cm]['id'] = $hh['id'];
                $categories_call[$_cm]['name_forum'] = $hh['name_forum'];
                $categories_call[$_cm]['memo_forum'] = $hh['memo_forum'];
                $categories_call[$_cm]['icon_forum'] = $hh['icon_forum'];
                $categories_call[$_cm]['acl_forum'] = $hh['acl_forum'];
                $categories_call[$_cm]['parent_forum'] = $hh['parent_forum'];
                $categories_call[$_cm]['level_forum'] = $hh['level_forum'];
                $categories_call[$_cm]['ac_forum'] = $hh['ac_forum'];
                $categories_call[$_cm]['description_forum'] = $hh['description_forum'];

                //print "<br>F_dashbroad 000 bien categories_call--------- chi muc------------->" . $categories_call[$_cm]['id']."<----------------<br>";
                print "F_dashbroad 658 bien set chi muc id = hh[id]----------------------$_cm----------------<br>";
                //foreach ($hh as $h =>$jh){
                print "F_dashbroad 658 bien categories_call sql: id =>". $hh['id'] ." <br>";
                //print "<br>F_dashbroad 658 bien categories_call setoption : $id =>". $id ." <br>";
                //foreach ($hh as $h =>$jh)
                //print "F_dashbroad 628 bien ac_forum: $h => $jh <br>";
                //$_category_id   = $id;
                print "F_dashbroad 658 bien categories_call: name_forum=>" . $hh['name_forum'] ."<br>";
                //$_category_memo   = $categories_call[$category_id]['memo_forum'];
                print "F_dashbroad 658 bien categories_call: icon_forum=>" . $hh['icon_forum']."<br>";
                //$_category_acl    = spsep($categories_call[$category_id]['acl_forum']);
                //foreach ($hh['acl_forum'] as $h)
                $keys_acl = explode(',', $hh['acl_forum']);
                $acl_acl=!empty($keys_acl)?join(',', $keys_acl):'';
                print "F_dashbroad 658 bien categories_call: acl_forum=>" .  $hh['acl_forum']."<br>";
                //print "F_dashbroad 658 bien categories_call: acl_forum=>" .  $acl_acl."<br>";
                //$_category_acl=!empty($h)?join(',', $h):'';

                print "F_dashbroad 658 bien categories_call: parent_forum=>" . $hh['parent_forum']."<br>";
                print "F_dashbroad 658 bien categories_call: level_forum=>" .  $hh['level_forum']."<br>";
                //$_category_level   = $categories_call[$category_id]['level_forum'];
                //}
            }
            list($categories_call) = cn_category_struct($categories_call);
        }
        print "F_dashbroad <br><br><br>";
        //-----------------------------------------------------------------

        //list($categories_call) = cn_category_struct_display();

        */
    if (!empty($categories_call)) {
        $category_ids = array_keys($categories_call);    //get category_ids

        if (!empty($category_ids))//category_ids
        {
            $max_id = 0;
            foreach ($category_ids as $id)//category_ids
            {
                if ($max_id < $id) $max_id = $id;
            }
            $categories_call['#'] = $max_id;
        } else {
            $categories_call['#'] = 0;
        }

    }

    // Do Action
    if (request_type('POST')) {
        cn_dsi_check();
        $cat_acl = !empty($category_acl) ? join(',', $category_acl) : '';
        $is_duble = false;
        $message = false;

        if (!empty($category_name)) {
            if ($is_add) {
                //Check category dubles
                if (!empty($categories_call)) {
                    foreach ($categories_call as $value) {
                        $is_duble = $value['name_forum'] == $category_name && $value['acl_forum'] == $cat_acl;
                        if ($is_duble) break;
                    }
                }

                if (!$is_duble) {
                    //$categories_call['#']=count($categories_call)!=0?$categories_call['#']+1:1;
                    $categories_call['#'] = time();
                    $category_id = intval($categories_call['#']);
                    //$category_id = time();             

                    $msew = "INSERT INTO `forums`(`id`, `name_forum`, `memo_forum`, `icon_forum`, `acl_forum`, `parent_forum`, `level_forum`, `ac_forum`, `description_forum`) VALUES('"
                        //$addsql = "INSERT INTO `admins`(`id`, `username`, `password`, `email`, `nick`, `e-hide`, `acl_forum` , `avatar`, `ban`, `numlogin`, `lastdate`, `more`) VALUES('"
                        . $category_id //id
                        . "', '" . $category_name //name_forum
                        . "', '" . $category_memo //memo_forum
                        . "', '" . $category_icon //icon_forum
                        . "', '" . $cat_acl //acl_forum
                        . "', '" . intval($category_parent) //parent_forum
                        . "', '" . '' //level_forum
                        . "', '" . '' //ac_forum
                        . "', '" . $category_description
                        . "');"; //description_forum

                    //echo "addduse: $msew <br>";
                    //exit();

                    //if(!$db->query($msew))
                    //die ('Topic_Error:'. mysqli_error());

                    //if(!cn_category_insert($category_id,$category_name,$category_memo,$category_icon,$cat_acl,$category_parent,$category_description))
                    //die ('Topic_Error: 00000000000000000000=========>insert<======000000000000000000000 <br>');

                    $message = 'Category added';

                } else {
                    cn_throw_message('This category already exist', 'e');
                }

            } elseif ($is_edit) {
                $mesw = "UPDATE `forums` SET `name_forum`='"
                    //. $_category_id //id
                    . $category_name //$_POST['username']
                    . "', `memo_forum`='" . $category_memo //$_POST['username']
                    . "', `icon_forum`='" . $category_icon //$_POST['password1']
                    . "', `acl_forum`='" . $cat_acl //$_POST['email']
                    . "', `parent_forum`='" . $category_parent //nick
                    . "', `level_forum`='" . '' //e-hide
                    . "', `ac_forum`='" . '' //ac_forum
                    . "', `description_forum`='" . $category_description
                    . "' WHERE id = '$category_id';"; //lastdate

                //echo "F_daddduse update 833: $mesw <br>";
                //if(!$db->query($mesw))
                //die ('Topic_Error:'. mysqli_error());

                //if(!cn_category_update($category_id,$category_name,$category_memo,$category_icon,$cat_acl,$category_parent,$category_description))
                //die ('Topic_Error: 0000000000000=========>update<======0000000000000000000000 <br>');

                $message = 'Category edited';
                //htmlspecialchars($str, ENT_NOQUOTES, "UTF-8")
            } elseif ($is_delete) {
                if (array_key_exists($category_id, $categories_call)) {

                    $category_ac_f = $categories_call[$category_id]['ac_forum'];
                    if ($category_ac_f) {
                        foreach ($category_ac_f as $id_val) {
                            if (!$db->query("DELETE FROM `forums` WHERE id = '" . intval($id_val) . "';"))
                                die('Error delete record' . mysqli_error());//cn_throw_message('Error inserting new record', 'e');
                            unset($categories_call[$id_val]);
                        }
                    }
                    if (!$db->query("DELETE FROM `forums` WHERE id = '" . intval($category_id) . "';"))
                        die('Error delete record' . mysqli_error());//cn_throw_message('Error inserting new record', 'e');
                    unset($categories_call[$category_id]);

                    $category_id = 0;
                    $message = 'Category deleted';
                }
            } elseif ($is_cancel) {
                $category_id = 0;
            }

            //add to array
            if (!empty($category_id)) {
                //--------------------------------------------------------------
                //print "F_dashbroad 743 bien category_id max:" . $categories_call['#'] ." <br>";
                //--------------------------------------------------------------
                $categories_call[$category_id]['id'] = intval($category_id);
                $categories_call[$category_id]['name_forum'] = $category_name;
                $categories_call[$category_id]['memo_forum'] = $category_memo;
                $categories_call[$category_id]['icon_forum'] = $category_icon;
                $categories_call[$category_id]['description_forum'] = $category_description;
                $categories_call[$category_id]['acl_forum'] = $cat_acl;
                $categories_call[$category_id]['parent_forum'] = intval($category_parent);
                cn_throw_message($message);


                if (!$is_duble && !$is_edit && !$is_cancel) {
                    $msew = "INSERT INTO `forums`(`id`, `name_forum`, `memo_forum`, `icon_forum`, `acl_forum`, `parent_forum`, `level_forum`, `ac_forum`, `description_forum`) VALUES('"
                        //$addsql = "INSERT INTO `admins`(`id`, `username`, `password`, `email`, `nick`, `e-hide`, `acl_forum` , `avatar`, `ban`, `numlogin`, `lastdate`, `more`) VALUES('"
                        . intval($category_id) //id
                        . "', '" . $category_name //name_forum
                        . "', '" . $category_memo //memo_forum
                        . "', '" . $category_icon //icon_forum
                        . "', '" . $cat_acl //acl_forum
                        . "', '" . intval($category_parent) //parent_forum
                        . "', '" . '' //level_forum
                        . "', '" . '' //ac_forum
                        . "', '');"; //description_forum

                    //echo "addduse: $msew <br>";
                    //exit();
                    //$db->set_charset("utf8");
                    //$db->query($msew);

                    if (!cn_category_insert($category_id, $category_name, $category_memo, $category_icon, $cat_acl, $category_parent, $category_description))
                        cn_throw_message('Error inserting new record', 'e');
                    ///die ('Topic_Error: 00000000000000000000=========>insert<======000000000000000000000 <br>');

                }
                //-------------------------------------------------------------
            }
            $category_name = $category_icon = $category_memo = $category_acl = $category_parent = $category_id = $category_description = '';
            if (!$is_cancel)// || $is_edit || $is_delete)
            {
                //list($categories) = cn_category_struct($categories_call);
                list($categories_call) = cn_category_struct($categories_call);
                //setoption('#category', $categories);
                //$result = $db->query("DELETE FROM `forums`;");

                //----------------------------------------------------

                foreach ($categories_call as $id => $hh) {

                    $_category_id = intval($hh['id']);
                    //$_category_id   = $id;
                    $_category_name = $hh['name_forum'];
                    $_category_memo = $hh['memo_forum'];
                    $_category_icon = $hh['icon_forum'];
                    $_category_description = $hh['description_forum'];
                    //$_category_acl    = spsep($categories[$category_id]['acl_forum']);
                    //foreach ($hh['acl_forum'] as $h)
                    $_category_acl = $hh['acl_forum'];
                    //$_category_acl=!empty($h)?join(',', $h):'';

                    $_category_parent = $hh['parent_forum'];
                    $_category_level = $hh['level_forum'];
                    $_category_ac = !empty($hh['ac_forum']) ? join(',', $hh['ac_forum']) : '';

                    //$_category_level   = $categories[$category_id]['level_forum'];

                    //print "F_dashbroad 628 bien category_ids: $h => $jh <br>";
                    //foreach ($hh['ac_forum'] as $rt =>$jh)
                    //$acl_ac=!empty($jh)?join(',', $jh):'';


                    //$acl_ac = join(',', $hh['ac_forum']);
                    //$keys_ac = explode(',', $hh['ac_forum']);
                    //$_category_acl    = spsep($categories[$category_id]['acl_forum']);
                    //foreach ($hh['acl_forum'] as $h)
                    //$keys_acl = explode(',', $hhh['acl_forum']);
                    //$acl_acl=!empty($keys_acl)?join(',', $keys_acl):'';


                    //$myupban ="UPDATE `admins` SET `ban`=0, numlogin = 1, lastdate = NOW() WHERE username = '$name_forum';";
                    $mesw = "UPDATE `forums` SET `name_forum`='"
                        //. $_category_id //id
                        . $_category_name //$_POST['username']
                        . "', `memo_forum`='" . $_category_memo //$_POST['username']
                        . "', `icon_forum`='" . $_category_icon //$_POST['password1']
                        . "', `acl_forum`='" . $_category_acl //$_POST['email']
                        . "', `parent_forum`='" . $_category_parent //nick
                        . "', `level_forum`='" . $_category_level //e-hide
                        . "', `ac_forum`='" . $_category_ac //acl_forum
                        . "', `description_forum`='" . $_category_description
                        . "' WHERE id = '$_category_id';"; //lastdate

                    //echo "addduse: $mesw <br>";
                    //$db->query($mesw);


                    if (!cn_category_update($_category_id, $_category_name, $_category_memo, $_category_icon, $_category_acl, $_category_parent, $_category_level, $_category_ac, $_category_description))
                        cn_throw_message('Error updating record', 'e');
                    //die ('Topic_Error: 0000000000000=========>update<======0000000000000000000000 <br>');

                }
            }

        } elseif (!$is_delete) {
            if (!$is_cancel)
                cn_throw_message('Empty category name', 'e');
            $category_name = $category_icon = $category_memo = $category_acl = $category_parent = $category_id = $category_description = '';
        }
    }


    /*
        $categories_return = array();
        $gdd = $db -> query("SELECT * FROM `forums`;");
        while($catford = $gdd ->fetch_assoc()) //fetch_assoc //fetch_array
            $categories_return[] = $catford;

        if(!empty($categories_return)){
            foreach ($categories_return as $cm=> $hh){
                $_cm = $hh['id'];
                $categoriesreturn[$_cm]['id'] = $hh['id'];
                $categoriesreturn[$_cm]['name_forum'] = $hh['name_forum'];
                $categoriesreturn[$_cm]['memo_forum'] = $hh['memo_forum'];
                $categoriesreturn[$_cm]['icon_forum'] = $hh['icon_forum'];
                $categoriesreturn[$_cm]['acl_forum'] = $hh['acl_forum'];
                $categoriesreturn[$_cm]['parent_forum'] = $hh['parent_forum'];
                $categoriesreturn[$_cm]['level_forum'] = $hh['level_forum'];
                $categoriesreturn[$_cm]['ac_forum'] = $hh['ac_forum'];
                $categoriesreturn[$_cm]['description_forum'] = $hh['description_forum'];
            }
            list($categoriesreturn) = cn_category_struct($categoriesreturn);
        }
        else
            $categoriesreturn =array();


        //list($categoriesreturn) = cn_category_struct_display();

        if ($category_id && !empty($categoriesreturn)){
        //if ($category_id){
            if(array_key_exists($category_id,$categoriesreturn)){
            //if(is_array($category_id,$categoriesreturn,true)){
                $category_name   = $categoriesreturn[$category_id]['name_forum'];
                $category_memo   = $categoriesreturn[$category_id]['memo_forum'];
                $category_icon   = $categoriesreturn[$category_id]['icon_forum'];
                $category_description   = $categoriesreturn[$category_id]['description_forum'];
                $category_parent = $categoriesreturn[$category_id]['parent_forum'];
                $category_acl    = spsep($categoriesreturn[$category_id]['acl_forum']);
            }
        }
        // ---
        //get with category_id
        */

    if ($category_id) {
        if (array_key_exists($category_id, $categories_call)) {
            $category_name = $categories_call[$category_id]['name_forum'];
            $category_memo = $categories_call[$category_id]['memo_forum'];
            $category_icon = $categories_call[$category_id]['icon_forum'];
            $category_description = $categories_call[$category_id]['description_forum'];
            $category_parent = $categories_call[$category_id]['parent_forum'];
            $category_acl = spsep($categories_call[$category_id]['acl_forum']);
        }
    }

    // latest added
    unset($categories_call['#']);
    //$categories_call= null;
    //$categories_data= null;
    //$categories_return= null;


    foreach ($groups as $id => $grp) {
        $e = spsep($grp['A']);
        if (!in_array('Ncd', $e))
            unset($groups[$id]);
    }


    //---
    cn_assign('category_id, categories, category_name, category_memo, category_icon, category_description, category_acl, category_parent, groups',
        $category_id, $categories_call, $category_name, $category_memo, $category_icon, $category_description, $category_acl, $category_parent, $groups);
    echoheader('-@dashboard/style.css', "Categories");
    echo exec_tpl('dashboard/category');
    echofooter();
}

// =====================================================================================================================
// Since 2.0: Template management

function dashboard_templates()
{
    $all_templates = array();
    $template_parts = array();

    $def_ids = array
    (
        'active' => 'Active News',
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
    $tuser = getoption('#templates');

    // Basic template name and fetch data (user/system)
    if (!$template) {
        $template = 'default';
    }

    // Copy default subtemplate, if not exists
    if (!isset($tuser[$template])) {
        foreach ($list[$template] as $_sub => $_var) {
            $tuser[$template][$_sub] = $_var;
        }
    }

    // Get all templates, mark it as user/system
    foreach ($tuser as $id => $vs) {
        $all_templates[$id] = 'User';
    }

    foreach ($list as $id => $vs) {
        $all_templates[$id] = 'Sys';
    }

    $odata = array();
    foreach ($tuser[$template] as $id => $subtpl) {
        if (isset($def_ids[$id])) {
            $_name = $def_ids[$id];
        } else {
            $_name = ucfirst(str_replace('_', ' ', $id));
        }

        $odata[$id] = $subtpl;
        $template_parts[$id] = $_name;
    }

    reset($odata);

    // Get subtmpl by default
    if (!$sub) {
        $sub = key($odata);
    }

    // ------------------------------------------------------------------------------------ ACTIONS --------------------
    // save template?
    if (request_type('POST')) {
        cn_dsi_check();

        // ------------------------
        if (REQ('select', 'POST')) {
            cn_relocation(cn_url_modify(array('reset'), 'mod=' . REQ('mod'), 'opt=' . REQ('opt'), 'template=' . $template));
        } // ------------------------
        elseif (REQ('create') || REQ('template_name')) {
            $template_name = trim(strtolower(preg_replace('/[^a-z0-9_]/i', '-', REQ('template_name'))));

            if (!$template_name) {
                cn_throw_message('Enter correct template name', 'e');
            } elseif (isset($all_templates[$template_name])) {
                cn_throw_message('Template already exists', 'e');
            } else {
                $tuser[$template][$sub] = REQ('save_template_text', 'POST');

                setoption("#templates/$template_name", $tuser[$template]);
                msg_info('Template [' . $template_name . '] created', cn_url_modify(array('reset'), 'mod=' . REQ('mod'), 'opt=' . REQ('opt'), 'template=' . $template_name));
            }
        } // ------------------------
        elseif (REQ('delete')) {
            if ($all_templates[$template] === 'Sys') {
                cn_throw_message("Template '$template' is system template, can't delete", 'e');
            } else {
                unset($tuser[$template]);
                setoption('#templates', $tuser);

                msg_info('Template [' . $template . '] deleted!', cn_url_modify(array('reset'), 'mod=' . REQ('mod'), 'opt=' . REQ('opt')));
            }
        } // ------------------------
        elseif (REQ('reset')) {
            if ($all_templates[$template] === 'Sys') {
                unset($tuser[$template]);
                setoption("#templates", $tuser);

                cn_throw_message("Template reset to default");
            } else {
                cn_throw_message("Template is user template, can't reset", 'e');
            }
        } // ------------------------
        else {
            $tuser[$template][$sub] = REQ('save_template_text', 'POST');
            setoption("#templates", $tuser);

            cn_throw_message('Template saved successfully');
        }
    }

    if (isset($_POST['template'])) {
        $_GET['template'] = $_POST['template'];
    }

    if (isset($_POST['sub'])) {
        $_GET['sub'] = $_POST['sub'];
    }

    // user can't delete system template, only modify
    $can_delete = $all_templates[$template] == 'Sys' ? FALSE : TRUE;

    // get template text (may be modified before)
    $template_text = isset($tuser[$template][$sub]) ? $tuser[$template][$sub] : (isset($list[$template][$sub]) ? $list[$template][$sub] : '');

    // ----
    cn_assign('template_parts, all_templates, template_text, template, sub, can_delete', $template_parts, $all_templates, $template_text, $template, $sub, $can_delete);
    echoheader('-@dashboard/style.css', "Templates");
    echo exec_tpl('dashboard/template');
    echofooter();
}

// =====================================================================================================================
// Since 2.0: Users management

function dashboard_userman()
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
    $userlist = db_user_list();

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

    // Retrieve info about user
    if ($user = db_user_by_name($user_name)) {
        $user_nick = isset($user['nick']) ? $user['nick'] : '';
        $user_email = isset($user['email']) ? $user['email'] : '';
        $user_acl = isset($user['acl']) ? $user['acl'] : '';
        $is_edit = TRUE;
    }

    // By default for section
    if (!$user_acl) $user_acl = $section;

    cn_assign('users, section, st, per_page, grp', $userlist, $section, $st, $per_page, $grp);
    cn_assign('user_name, user_nick, user_email, user_acl, is_edit', $user_name, $user_nick, $user_email, $user_acl, $is_edit);

    echoheader('-@dashboard/style.css', "Users manager");
    echo exec_tpl('dashboard/users');
    echofooter();
}

// =====================================================================================================================
// Since 2.0: Cutenews Self-Checking
function dashboard_selfchk()
{
    $errors = array();

    $check_dirs = array
    (
        'cdata',
        'cdata/backup',
        'cdata/btree',
        'cdata/log',
        'cdata/news',
        'cdata/plugins',
    );

    //         'uploads',

    // --- Check dirs
    foreach (hook('cnsc_dirs', $check_dirs) as $dir) {
        // Try create file in cdata
        $test_file = cn_path_construct(SERVDIR, $dir) . 'test.html';
        fclose(fopen($test_file, 'w+'));

        // File exists?
        if (file_exists($test_file)) {
            unlink($test_file);
        } else {
            $errors[] = array('perm' => '---', 'file' => SERVDIR . DIRECTORY_SEPARATOR . $dir, 'msg' => i18n('<b>Directory not writable</b>'));
        }
    }

    // --- Check uploads dir
    if (getoption('uploads_dir')) {
        $updir = getoption('uploads_dir');
    } else {
        $updir = cn_path_construct(SERVDIR, 'uploads');
    }

    fclose(fopen($cfile = $updir . 'test.html', 'w+'));
    if (file_exists($cfile)) {
        unlink($cfile);
    } else {
        $errors[] = array('perm' => '---', 'file' => $updir, 'msg' => i18n('<b>Directory not writable</b>'));
    }

    // ---
    $check_files = array
    (
        '/cdata/users.txt',
        '/cdata/flood.txt',
        '/cdata/conf.php',
    );

    foreach (hook('cnsc_files', $check_files) as $file) {
        $the_file = SERVDIR . $file;

        // Check exists
        if (file_exists($the_file)) {
            // Check readable
            if (is_readable($the_file)) {
                // FS. BEFORE
                clearstatcache();
                $fs0 = filesize($the_file);

                $af = fopen($the_file, 'a+');
                fwrite($af, "\n");
                fclose($af);

                // FS. AFTER
                clearstatcache();
                $fs1 = filesize($the_file);

                // REVERT
                $aw = fopen($the_file, 'a+');
                ftruncate($aw, $fs0);
                fclose($aw);

                // Check writable status: no change in filesize
                if ($fs0 == $fs1) {
                    $errors[] = array('perm' => decoct(fileperms($the_file)), 'file' => $the_file, 'msg' => i18n('File not writable'));
                }
            } else {
                $errors[] = array('perm' => decoct(fileperms($the_file)), 'file' => $the_file, 'msg' => i18n('File not writable'));
            }
        } else {
            $errors[] = array('perm' => '---', 'file' => $the_file, 'msg' => i18n('Not exists'));
        }
    }

    if ($errors) {
        cn_assign('errors', $errors);
        echoheader('', 'Permission self check');
        echo exec_tpl('dashboard/selfchk');
        echofooter();
    } else {
        msg_info('All is fine, necessary permits have');
    }

}

// =====================================================================================================================
// Since 2.0: Make ZIP backups

function dashboard_backup()
{
    $name = '';
    require_once SERVDIR . '/core/zip.class.php';

    if (request_type('POST')) {
        cn_dsi_check();

        $name = trim(preg_replace('/[^a-z0_9_]/i', '', REQ('backup_name')));
        $backup_sysonly = REQ('backup_sysonly');

        if (!$name) {
            cn_throw_message('Enter correct backup name', 'e');
        } else {
            // Do compress files
            $zip = new zipfile();

            if (!$backup_sysonly) {
                $zip->create_dir('news/');
                $zip->create_dir('users/');

                // Compress news
                $news = scan_dir(cn_path_construct(SERVDIR, 'cdata', 'news'));
                foreach ($news as $file) {
                    $data = join('', file(cn_path_construct(SERVDIR, 'cdata', 'news') . $file));
                    $zip->create_file($data, 'news' . DIRECTORY_SEPARATOR . $file);
                }

                // Compress users
                $news = scan_dir(cn_path_construct(SERVDIR, 'cdata', 'users'));
                foreach ($news as $file) {
                    $data = join('', file(cn_path_construct(SERVDIR, 'cdata', 'users') . $file));
                    $zip->create_file($data, 'news' . DIRECTORY_SEPARATOR . $file);
                }

                $files = array('conf.php', 'users.txt');
            } else {
                $files = array('conf.php');
            }

            // Append files
            foreach ($files as $file) {
                $data = join('', file(cn_path_construct(SERVDIR, 'cdata') . $file));
                $zip->create_file($data, $file);
            }

            // write compressed data
            $wb = fopen(cn_path_construct(SERVDIR, 'cdata', 'backup') . $name . '.zip', 'w+');
            fwrite($wb, $zip->zipped_file());
            fclose($wb);

            // backup created
            cn_throw_message('Backup sucessfull created');

            unset($zip);
            $name = '';
        }
    } // Unpack procedure called
    elseif ($unpack_file = REQ('unpack', 'GET')) {
        cn_dsi_check();

        if (file_exists($cf = cn_path_construct(SERVDIR, 'cdata', 'backup') . $unpack_file . 'zip')) {
            $zip = new zipfile();
            $files = $zip->read_zip(cn_path_construct(SERVDIR, 'cdata', 'backup') . $unpack_file . 'zip');
            unset($zip);

            // replace files from zip-archive
            foreach ($files as $fdata) {
                $file = $fdata['dir'] . DIRECTORY_SEPARATOR . $fdata['name'];
                $w = fopen(cn_path_construct(SERVDIR, 'cdata') . $file, 'w+');
                fwrite($w, $fdata['data']);
                fclose($w);
            }

            unlink($cf);
            cn_throw_message('File decompressed, backup removed');
        } else {
            cn_throw_message('File [' . cn_htmlspecialchars($unpack_file) . '] not exists', 'e');
        }
    }

    $archives = array();

    $list = scan_dir(cn_path_construct(SERVDIR, 'cdata', 'backup'), '\.zip');
    foreach ($list as $d) {
        $file = cn_path_construct(SERVDIR, 'cdata', 'backup') . $d;
        $archives[] = array
        (
            'name' => str_replace('.zip', '', $d),
            'size' => filesize($file),
            'date' => date('Y-m-d H:i:s', filemtime($file)),
        );
    }

    cn_assign('archives, name', $archives, $name);
    echoheader('-@dashboard/style.css', 'Backups');
    echo exec_tpl('dashboard/backups');
    echofooter();
}

// =====================================================================================================================
// Since 2.0: Integration Wizard tool

function dashboard_intwiz()
{
    $sub = REQ('sub');

    $categories = cn_get_categories();

    $rss = getoption('#rss');
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

            setoption('#rss', $rss);
        }
    }

    $all_tpls = array();
    $listsys = cn_template_list();
    $templates = getoption('#templates');

    // Get all templates
    foreach ($listsys as $id => $_t) {
        $all_tpls[$id] = $id;
    }
    foreach ($templates as $id => $_t) {
        $all_tpls[$id] = $id;
    }

    cn_assign('sub, categories, all_tpls', $sub, $categories, $all_tpls);
    cn_assign('rss_news_include_url, rss_encoding, rss_language, rss_title', $rss_news_include_url, $rss_encoding, $rss_language, $rss_title);

    echoheader('-@dashboard/style.css', 'Integration Wizard');
    echo exec_tpl('dashboard/intwiz');
    echofooter();
}

// =====================================================================================================================
// Since 2.0: Ban by IP and name

function dashboard_ipban()
{
    $ipban = getoption('#ipban');
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

            setoption('#ipban', $ipban);
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

        setoption('#ipban', $ipban);
    }

    cn_assign('list', $ipban);
    echoheader('-@dashboard/style.css', 'Block IP');
    echo exec_tpl('dashboard/ipban');
    echofooter();
}

// =====================================================================================================================
// Since 2.0: User logs

function dashboard_logs()
{
    $logs = array();


    $skip = FALSE;
    $num = 20;
    $isfin = FALSE;
    $n = 0;

    $st = REQ('st');
    $section = REQ('section');

    if ($st < 0) $st = 0;
    $over = $st + $num;

    // --- System section ---
    if (!$section) {
        $path = cn_path_construct(SERVDIR, 'log') . 'error_dump.log';
        if (file_exists($path)) {
            $r = fopen($path, 'r');
            if ($r) {
                do {
                    $v = trim(fgets($r));

                    if ($v == '') {
                        $skip = FALSE;
                        continue;
                    } elseif ($skip) continue;

                    // Catch
                    if (preg_match('/^\[(\d+)\] (.*)$/', $v, $c)) {
                        $n++;

                        // Skip some logs
                        if ($n >= $st) {
                            list(, $msg) = explode('|', $c[2], 2);
                            $logs[] = array('msg' => $msg, 'date' => date('Y-m-d H:i:s', $c[1]));
                        }

                        $skip = TRUE;
                    }

                    if ($n > $over) break;
                } while (!feof($r));

                fclose($r);
            }
        }
    } // --- User log section ---
    elseif ($section === 'user') {
        if (!file_exists($ul = cn_path_construct(SERVDIR, 'log') . 'user.log')) {
            fclose(fopen($ul, 'w+'));
        }

        $r = fopen($ul, 'r');

        do {
            $n++;
            $v = trim(fgets($r));
            if (!$v) break;

            if ($n <= $st) continue;

            list($date, $msg) = explode('|', $v, 2);
            $logs[] = array('msg' => $msg, 'date' => date('Y-m-d H:i:s', intval($date)));

            if ($n >= $over) break;
        } while (!feof($r));

        fclose($r);
    }
    //disable pagination
    if (count($logs) <= $st || count($logs) <= $num) $isfin = TRUE;

    cn_assign('logs, st, num, isfin, section', $logs, $st, $num, $isfin, $section);
    echoheader('-@dashboard/style.css', 'System logs');
    echo exec_tpl('dashboard/logs');
    echofooter();
}

// =====================================================================================================================
// Since 2.0: Archives manager

function dashboard_archives()
{
    list($req_archive_id, $arch_action, $last_only, $period) = GET('archive_id, arch_action, last_only, period');

    // Do make archive
    if (request_type('POST')) {
        cn_dsi_check();

        // Archives actions
        if ($req_archive_id) {
            // Delete
            if ($arch_action == 'rm') {
                db_archive_meta_update($req_archive_id, 0, 0, 0);
                $req_archive_id = 0;

                cn_throw_message("Archive deleted", 'e');
            } // Do extract archive
            elseif ($arch_action == 'extr') {
                if (!db_extract_archive($req_archive_id)) {
                    cn_throw_message("Archive not extracted correctly", 'e');
                } else {
                    $req_archive_id = 0;
                    cn_throw_message("Archive extracted");
                }
            } else {
                cn_throw_message('@SYSINFO: Unrecognized request', 'e');
            }
        } // Make archive
        else {
            if ($last_only) {
                $date_f = ctime() - $period * 3600 * 24;
                $date_t = ctime();
            } else {
                list($_fd, $_fm, $_fy) = GET('from_date_day, from_date_month, from_date_year', 'POST');
                list($_td, $_tm, $_ty) = GET('to_date_day, to_date_month, to_date_year', 'POST');

                $date_f = mktime(0, 0, 0, intval($_fm), intval($_fd), intval($_fy));
                $date_t = mktime(23, 59, 59, intval($_tm), intval($_td), intval($_ty));
            }

            $cc = db_make_archive($date_f, $date_t);

            if ($cc) {
                cn_throw_message(i18n('Archive created (%1 articles)', $cc));
            } else {
                cn_throw_message('There is nothing to archive', 'e');
            }
        }
    }

    // --- archives
    $arch_list = db_get_archives();

    // ---- fetch active ---
    $ids = db_index_load();
    ksort($ids);

    reset($ids);
    $st = key($ids);
    end($ids);
    $ed = key($ids);

    list($f_date_d, $f_date_m, $f_date_y) = make_postponed_date($st);
    list($t_date_d, $t_date_m, $t_date_y) = make_postponed_date($ed);

    cn_assign('arch_list, archive_id', $arch_list, $req_archive_id);
    cn_assign('f_date_d, f_date_m, f_date_y, t_date_d, t_date_m, t_date_y', $f_date_d, $f_date_m, $f_date_y, $t_date_d, $t_date_m, $t_date_y);
    echoheader('-@dashboard/style.css', 'Arhives');
    echo exec_tpl('dashboard/archives');
    echofooter();
}

// =====================================================================================================================
// Since 2.0: CN Widgets

// Widgets mod:
//
//     ?alias -- name alias
//     ?dosave -- save widget settings
//     ?settings -- get settings page

function dashboard_widgets()
{
    $_widgets = mcache_get('cn:widgets');
    $selected = REQ('selected');

    // Apply the changes
    if (request_type('POST')) {
        cn_dsi_check();

        // Apply PLUGIN section
        if (isset($_POST['submit_plugin'])) {
            if ($_POST['delete']) {
                $plugin_name = REQ('plugin_name');
                @unlink(SERVDIR . '/cdata/plugins/' . $plugin_name . '.php');
                cn_throw_message('Plugin deleted');
            }
        } // Apply WIDGET section
        elseif (isset($_POST['submit_widget'])) {
            // call syscall for widget
            if ($wn = $_POST['widget_name']) {
                // Save widget data in CuteNews
                if (isset($_POST['wsettings']) && is_array($_POST['wsettings']))
                    setoption("widget/$wn", $_POST['wsettings']);

                // save in module
                cn_widget($wn, '?dosave');
            }
        }
    }

    $s_plugin = '';
    $s_widget = '';
    $widget_current = '';
    $plugin_current = '';
    $widget_settings = '';

    // ---
    $widgets = array();
    if (is_array($_widgets)) foreach ($_widgets as $wn => $w1) foreach ($w1 as $w) {
        $WD5 = substr(md5("$wn:$w"), 0, 8);
        $widgets[] = array
        (
            'group' => $wn,
            'name' => $w,
            'md5' => $WD5,
            'selected' => ($WD5 === $selected ? TRUE : FALSE),
            'alias' => cn_widget($w, '?alias'),
        );

        if ($WD5 === $selected) $s_widget = array($wn, $w);
    }

    // widget selected
    if ($s_widget) {
        ob_start();
        cn_widget($s_widget[0], '?settings');
        $widget_settings = ob_get_clean();

        $widget_current = $s_widget[0];
    }

    // --
    $plugins = scan_dir(SERVDIR . '/cdata/plugins');

    foreach ($plugins as $id => $plugin) {
        $PD5 = substr(md5("plugin:$plugin"), 0, 8);
        $plugins[$id] = array
        (
            'md5' => $PD5,
            'selected' => ($PD5 === $selected ? TRUE : FALSE),
            'name' => str_replace('.php', '', $plugin)
        );

        if ($PD5 === $selected) $s_plugin = $plugins[$id]['name'];
    }

    // plugin selected
    if ($s_plugin)
        $plugin_current = $s_plugin;

    cn_assign('widgets, plugins, widget_settings, widget_current, plugin_current, s_widget', $widgets, $plugins, $widget_settings, $widget_current, $plugin_current, $s_widget);
    echoheader('-@dashboard/style.css', 'Plugins');
    echo exec_tpl('dashboard/widgets');
    echofooter();
}


// =====================================================================================================================
// Since 2.0: Additional fields

function dashboard_morefields()
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

function dashboard_group()
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
                'd' => i18n(array($d, 'DS-')),
                't' => i18n(array($t, 'DS-')),
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

function dashboard_wreplace()
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

function dashboard_locale()
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

// Since 2.0.1: Scripts
function dashboard_script()
{
    list($snippet, $text) = GET('snippet, text');

    if ($snippet == '') {
        $snippet = 'sandbox';
    }

    // Prevent subfoldering
    $snippet = preg_replace('/[^a-z0-9\-\.]/i', '_', $snippet);

    if (request_type('POST')) {
        cn_dsi_check();

        // Click select only
        if (!REQ('select', 'POST')) {
            if (REQ('delete', 'POST')) {
                $_t = getoption('#snippets');
                unset($_t[$snippet]);
                setoption('#snippets', $_t);
                $snippet = 'sandbox';
            } else {
                // Create new snippet
                if (REQ('create', 'POST')) {
                    $snippet = REQ('create');
                }

                setoption('#snippets/' . $snippet, $text);
                cn_throw_message('Changes saved');
            }
        } else {
            cn_throw_message('Select snippet [' . cn_htmlspecialchars($snippet) . ']');
        }
    }

    $list = getoption('#snippets');
    if (empty($list)) {
        $list['sandbox'] = '';
    }

    $opt_txt = getoption('#snippets/' . $snippet);

    $params = array
    (
        'list' => $list,
        'text' => (!empty($opt_txt) ? $opt_txt : ''),
        'can_delete' => ($snippet !== 'sandbox') ? TRUE : FALSE,
        'snippet' => $snippet,
        'snippets' => getoption('#snippets'),
    );

    echoheader('-@dashboard/style.css', 'HTML Scripts');
    echo exec_tpl('dashboard/script', $params);
    echofooter();
}

// Since 2.0.1: Latest comments
function dashboard_comments()
{
    list($list, $count) = db_comm_lst();

    $params = array
    (
        'list' => $list,
        'count' => $count,
    );

    echoheader('-@dashboard/style.css', 'Comments');
    echo exec_tpl('dashboard/comments', $params);
    echofooter();
}
