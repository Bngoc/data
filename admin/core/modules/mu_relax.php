<?php if (!defined('BQN_MU')) die('Access restricted');

add_hook('index/invoke_module', '*relax_invoke');

// =====================================================================================================================

function relax_invoke()
{
    $dashboard = array
    (
        'money:sysconf:Csc' => 'Mua Zen',
        'money:morefields:Caf' => 'Item Vpoint',
        'money:templates:Ct' => 'Mua Item Vpoint',
        'money:category:Cc' => 'Chuyển Vpoint',
        'money:intwiz:Ciw' => 'Ð?i Vpoint --> Gcoin',
        'money:userman:Cum' => 'Ð?i Gcoin --> Vpoint',
        'money:group:Cg' => 'Ð?i Gcoin --> Wcoin',
        'money:backup:Cb' => 'Ð?i Gcoin --> WcoinP',
        'money:comments:Com' => 'Ð?i Gcoin --> GoblinCoin',
        'money:archives:Ca' => 'Ð?i Cash --> Vpoint',
        'money:ipban:Cbi' => 'Ð?i Vpoint --> Cash',
        'money:ipbdan:Cbi' => 'Ð?i IP Bouns Point --> PC.Point',
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

    echoheader('-@com_money/style.css', "Cutenews dashboard");

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
    echo exec_tpl('com_relax/general');

    echofooter();
}