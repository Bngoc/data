<?php if (!defined('BQN_MU')) die('Access restricted');

add_hook('index/invoke_module', '*screenshots_invoke');

//=====================================================================================================================
function screenshots_invoke()
{
    $cscreenshots_ = array (
        'screenshots:screenshots:Csc' => 'Cốt truyện',
        'screenshots:wallpapers:Cp' => 'Wallpapers',
        'screenshots:conceptart:Ciw' => 'Concept - Art',
        'screenshots:videostrailer:Cg' => 'Videos - Trailer'
    );

    // Call dashboard extend
    $cscreenshots_ = hook('screenshots', $cscreenshots_);

    // Exec
    $mod = REQ('mod', 'GETPOST');
    $opt = REQ('opt', 'GETPOST');

    cn_bc_add('screenshots', cn_url_modify(array('reset'), 'mod=' . $mod));

    foreach ($cscreenshots_ as $id => $_t) {
        list($dl, $do, $acl_module) = explode(':', $id);

        if (function_exists("screenshots_$do")) cn_bc_menu($_t, cn_url_modify(array('reset'), 'mod=' . $dl, 'opt=' . $do), $do);
    }

    // Request module
    foreach ($cscreenshots_ as $id => $_t) {
        list($dl, $do, $acl_module) = explode(':', $id);

        if ($dl == $mod && $do == $opt && function_exists("screenshots_$do")) {
            cn_bc_add($_t, cn_url_modify(array('reset'), 'mod=' . $mod, 'opt=' . $opt));
            die(call_user_func("screenshots_$do"));
        }

        if ($dl == $mod && $do == $opt && !function_exists("screenshots_$do")) {
            cn_bc_add('Lỗi dữ liệu', cn_url_modify(array('reset'), 'mod=' . $mod, 'opt=' . $opt));
            die(call_user_func("screenshots_default"));
        }
    }

    echoheader('-@my_screenshots/style.css', "Manger Account");

    $images = array (
        'screenshots' => 'change_pass.png',
        'wallpapers' => 'change_tel.png',
        'conceptart' => 'change_email.png',
        'videostrailer' => 'change_pwd.png'
    );

    // More dashboard images
    $images = hook('extend_dashboard_images', $images);

    foreach ($cscreenshots_ as $id => $name) {
        list($mod, $opt, $acl) = explode(':', $id, 3);

        $item = array (
            'name' => $name,
            'img' => isset($images[$opt]) ? $images[$opt] : 'home.gif',
            'mod' => $mod,
            'opt' => $opt
        );

        $cscreenshots_[$id] = $item;
    }

    cn_assign('dashboard', $cscreenshots_);
    echocomtent_here(exec_tpl('my_screenshots/general'), cn_snippet_bc_re());
    echofooter();
}

function screenshots_default()
{
    $arr_shop = mcache_get('.breadcrumbs');
    $name__ = array_pop($arr_shop)['name'];
    echoheader('-@defaults/style.css', "Error - $name__");
    echocomtent_here(exec_tpl('-@defaults/default'), cn_snippet_bc_re());
    echofooter();
}

function screenshots_screenshots() {
    $errors = array();

    // Do change pass-game


    cn_assign('errors_result', '');

    echoheader('-@my_screenshots/style.css', "Thay đổi mật khẩu Game");
    echocomtent_here(exec_tpl('-@my_screenshots/general'), cn_snippet_bc_re());
    echofooter();
}
