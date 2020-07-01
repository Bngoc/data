<?php if (!defined('BQN_MU')) {
    die('Access restricted');
}

add_hook('index/invoke_module', '*manager_invoke');

//=====================================================================================================================
function manager_invoke()
{
    $cManger_account = array(
        'manager_account:change_pass:Csc' => 'Đổi pass-Game',
        'manager_account:change_tel:Cp' => 'Đổi Sđt',
        'manager_account:change_email:Ciw' => 'Đổi Email',
        'manager_account:change_pwd:Cg' => 'Đổi pass-Web',
        'manager_account:change_secret:Cb' => 'Đổi Mã Bí mật',
        'manager_account:change_qa:Com' => 'Đổi Câu Trả Lời'
    );

    // Call dashboard extend
    $cManger_account = hook('manager_account', $cManger_account);

    // Exec
    $mod = REQ('mod', 'GETPOST');
    $opt = REQ('opt', 'GETPOST');

    cn_bc_add('Manger Account', cn_url_modify(array('reset'), 'mod=' . $mod));

    foreach ($cManger_account as $id => $_t) {
        list($dl, $do, $acl_module) = explode(':', $id);

        if (function_exists("manager_$do")) {
            cn_bc_menu($_t, cn_url_modify(array('reset'), 'mod=' . $dl, 'opt=' . $do), $do);
        }
    }

    // Request module
    foreach ($cManger_account as $id => $_t) {
        list($dl, $do, $acl_module) = explode(':', $id);

        if ($dl == $mod && $do == $opt && function_exists("manager_$do")) {
            cn_bc_add($_t, cn_url_modify(array('reset'), 'mod=' . $mod, 'opt=' . $opt));
            die(call_user_func("manager_$do"));
        }

        if ($dl == $mod && $do == $opt && !function_exists("manager_$do")) {
            cn_bc_add('Lỗi dữ liệu', cn_url_modify(array('reset'), 'mod=' . $mod, 'opt=' . $opt));
            die(call_user_func("manager_default"));
        }
    }

    echo_header_web('-@my_account/style.css', "Manger Account");

    $images = array(
        'change_pass' => 'change_pass.png',
        'change_tel' => 'change_tel.png',
        'change_email' => 'change_email.png',
        'change_pwd' => 'change_pwd.png',
        'change_secret' => 'change_secret.png',
        'change_qa' => 'change_qa.png'
    );

    // More dashboard images
    $images = hook('extend_dashboard_images', $images);

    foreach ($cManger_account as $id => $name) {
        list($mod, $opt, $acl) = explode(':', $id, 3);

        if (!testRoleWeb($acl)) {
            unset($cManger_account[$id]);
            continue;
        }

        $item = array(
            'name' => $name,
            'img' => isset($images[$opt]) ? $images[$opt] : 'home.gif',
            'mod' => $mod,
            'opt' => $opt
        );

        $cManger_account[$id] = $item;
    }

    cn_assign('dashboard', $cManger_account);
    echo_content_here(exec_tpl('my_account/general'), cn_snippet_bc_re());
    echo_footer_web();
}

function manager_default()
{
    $arr_shop = getMemcache('.breadcrumbs');
    $name__ = array_pop($arr_shop)['name'];
    echo_header_web('-@defaults/style.css', "Error - $name__");
    echo_content_here(exec_tpl('-@defaults/default'), cn_snippet_bc_re());
    echo_footer_web();
}
