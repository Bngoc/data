<?php if (!defined('BQN_MU')) {
    die('Access restricted');
}

add_hook('index/invoke_module', '*guide_invoke');

//=====================================================================================================================
function guide_invoke()
{
    $cManger_account = array(
        'guide:cottruyen:Csc' => 'Cốt truyện',
        'guide:tinhnang:Cp' => 'Tính năng',
        'guide:nhanvat:Ciw' => 'Nhân vật',
        'guide:nhiemvu:Cg' => 'Nhiệm vụ',
        'guide:thuhotro:Cb' => 'Thú hỗ trợ',
        'guide:thucuoi:Com' => 'Thú nuôi',
        'guide:quaivat:Com' => 'Quái vật',
        'guide:items:Com' => 'Vật phẩm',
        'guide:npc:Com' => 'NPC',
        'guide:banghoi:Com' => 'Bang hội',
        'guide:sukiengame:Com' => 'Sự kiện game'
    );

    // Call dashboard extend
    $cManger_account = hook('guide', $cManger_account);

    // Exec
    $mod = REQ('mod', 'GETPOST');
    $opt = REQ('opt', 'GETPOST');

    cn_bc_add('Guide', cn_url_modify(array('reset'), 'mod=' . $mod));

    foreach ($cManger_account as $id => $_t) {
        list($dl, $do, $acl_module) = explode(':', $id);

        if (function_exists("guide_$do")) {
            cn_bc_menu($_t, cn_url_modify(array('reset'), 'mod=' . $dl, 'opt=' . $do), $do);
        }
    }

    // Request module
    foreach ($cManger_account as $id => $_t) {
        list($dl, $do, $acl_module) = explode(':', $id);

        if ($dl == $mod && $do == $opt && function_exists("guide_$do")) {
            cn_bc_add($_t, cn_url_modify(array('reset'), 'mod=' . $mod, 'opt=' . $opt));
            die(call_user_func("guide_$do"));
        }

        if ($dl == $mod && $do == $opt && !function_exists("guide_$do")) {
            cn_bc_add('Lỗi dữ liệu', cn_url_modify(array('reset'), 'mod=' . $mod, 'opt=' . $opt));
            die(call_user_func("guide_default"));
        }
    }

    echo_header_web('-@my_guide/style.css', "Manger Account");

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

        $item = array(
            'name' => $name,
            'img' => isset($images[$opt]) ? $images[$opt] : 'home.gif',
            'mod' => $mod,
            'opt' => $opt
        );

        $cManger_account[$id] = $item;
    }

    cn_assign('dashboard', $cManger_account);
    echo_content_here(exec_tpl('my_guide/general'), cn_snippet_bc_re());
    echo_footer_web();
}

function guide_default()
{
    $arr_shop = getMemcache('.breadcrumbs');
    $name__ = array_pop($arr_shop)['name'];
    echo_header_web('-@defaults/style.css', "Error - $name__");
    echo_content_here(exec_tpl('-@defaults/default'), cn_snippet_bc_re());
    echo_footer_web();
}

function guide_cottruyen()
{
    echo_header_web('-@my_guide/style.css', "Hướng dẫn cách chơi game");
    echo_content_here(exec_tpl('-@my_guide/_cottruyen'), cn_snippet_bc_re());
    echo_footer_web();
}

function guide_tinhnang()
{
    $sub = REQ('sub', "GETPOST");

    $options_list = array(
        'old-features' => array(
            'nenngoc' => 'Hệ thống nén ngọc',
            'giacuong' => 'Gia cường Items',
            'tinhluyen' => 'Tinh luyện',
            'mayphatron' => 'Máy pha trộn',
            'taoquaidieu' => 'Tạo quái điểu',
            'taoaochoang' => 'Tạo áo choàng chúa tể',
            'taothunuoi' => 'Tạo thú nuôi',
            'nangcapdovat' => 'Nâng cấp đồ vật',
            'taocanh' => 'Tạo cánh',
            'chaosvua' => 'Kết hợp Chaos Vua'
        ),
        'new-features' => array(
            'khamngoc' => 'Hệ thống khảm ngọc',
            'masterlevel' => 'Master Level',
            'canhcap3' => 'Cánh cấp 3'
        )
    );

    if (!isset($options_list[$sub])) {
        $sub = 'old-features';
    }

    if (request_type('POST')) {
        if (isset($_REQUEST['show'])) {
            $show = $_REQUEST['show'];
            return exec_tpl('-@my_guide/tinhnang/' . $show);
            //return 1;
        }
    }

    $options = $options_list[$sub];
    cn_assign('sub, options, options_list', $sub, $options, $options_list);

    echo_header_web('-@my_guide/style.css@my_guide/customjs.js', "Hướng dẫn cách chơi game");
    echo_content_here(exec_tpl('-@my_guide/_tinhnang'), cn_snippet_bc_re());
    echo_footer_web();
}

function guide_nhanvat()
{
    $options = array(
        'chuate' => 'Chúa tể',
        'phuthuy' => 'Phù thủy',
        'tiennu' => 'Tiên nữ',
        'dausi' => 'Đấu sĩ',
        'chienbinh' => 'Chiến binh',
        'thuatsi' => 'Thuật sĩ',
        'rageFighter' => 'Rage Fighter',
        'tuyetchieumoi' => 'Tuyệt chiêu mới',
    );

    if (request_type('POST')) {
        if (isset($_REQUEST['sub'])) {
            $sub = $_REQUEST['sub'];
            return exec_tpl('-@my_guide/character/' . $sub);
        }
    }

    if (!isset($sub)) {
        $sub = 'chuate';
    }
    cn_assign('sub, options', $sub, $options);

    echo_header_web('-@my_guide/style.css@my_guide/customjs.js', "Hướng dẫn cách chơi game");
    echo_content_here(exec_tpl('-@my_guide/_nhanvat'), cn_snippet_bc_re());
    echo_footer_web();
}

function guide_nhiemvu()
{
    echo_header_web('-@my_guide/style.css', "Hướng dẫn cách chơi game");
    echo_content_here(exec_tpl('-@my_guide/_nhiemvu'), cn_snippet_bc_re());
    echo_footer_web();
}

function guide_thuhotro()
{
    echo_header_web('-@my_guide/style.css', "Hướng dẫn cách chơi game");
    echo_content_here(exec_tpl('-@my_guide/_thuhotro'), cn_snippet_bc_re());
    echo_footer_web();
}

function guide_quaivat()
{
    $options = array(
        'lorencia' => 'Lorencia',
        'noria' => 'Noria',
        'devias' => 'Devias',
        'dungeon' => 'Dungeon',
        'elbeland' => 'Elbeland',
        'lostTower' => 'Lost Tower',
        'atlans' => 'Atlans',
        'aida' => 'Aida',
        'tarkan' => 'Tarkan',
        'icarus' => 'Icarus',
        'kanturu' => 'Kanturu',
        'raklion' => 'Raklion',
        'calmness' => 'Swamp of Calmness',
        'kalima' => 'Kalima',
        'crywolf' => 'Crywolf'
    );

    if (request_type('POST')) {
        if (isset($_REQUEST['sub'])) {
            $sub = $_REQUEST['sub'];
            return exec_tpl('-@my_guide/monster/' . $sub);
        }
    }

    if (!isset($sub)) {
        $sub = 'lorencia';
    }
    cn_assign('sub, options', $sub, $options);

    echo_header_web('-@my_guide/style.css@my_guide/customjs.js', "Hướng dẫn cách chơi game");
    echo_content_here(exec_tpl('-@my_guide/_quaivat'), cn_snippet_bc_re());
    echo_footer_web();
}

function guide_items()
{
    echo_header_web('-@my_guide/style.css', "Hướng dẫn cách chơi game");
    echo_content_here(exec_tpl('-@my_guide/_items'), cn_snippet_bc_re());
    echo_footer_web();
}

function guide_npc()
{
    echo_header_web('-@my_guide/style.css', "Hướng dẫn cách chơi game");
    echo_content_here(exec_tpl('-@my_guide/_npc'), cn_snippet_bc_re());
    echo_footer_web();
}

function guide_thucuoi()
{
    echo_header_web('-@my_guide/style.css', "Hướng dẫn cách chơi game");
    echo_content_here(exec_tpl('-@my_guide/_thucuoi'), cn_snippet_bc_re());
    echo_footer_web();
}

function guide_banghoi()
{
    echo_header_web('-@my_guide/style.css', "Hướng dẫn cách chơi game");
    echo_content_here(exec_tpl('-@my_guide/_banghoi'), cn_snippet_bc_re());
    echo_footer_web();
}

function guide_sukiengame()
{
    $options = array(
        'blood' => 'Lâu đài máu',
        'devil' => 'Quảng Trường Quỷ',
        'chaoscastle' => 'Hỗn Nguyên Lâu',
        'thuthach' => 'Vùng Đất Thử Thách',
        'ctc' => 'Công Thành Chiến',
        'bld' => 'Bạch Long Điện',
        'pds' => 'Pháo Đài Sói',
    );

    if (request_type('POST')) {
        if (isset($_REQUEST['sub'])) {
            $sub = $_REQUEST['sub'];
            return exec_tpl('-@my_guide/eventgame/' . $sub);
        }
    }

    if (!isset($sub)) {
        $sub = 'blood';
    }
    cn_assign('sub, options', $sub, $options);

    echo_header_web('-@my_guide/style.css@my_guide/customjs.js', "Hướng dẫn cách chơi game");
    echo_content_here(exec_tpl('-@my_guide/_sukiengame'), cn_snippet_bc_re());
    echo_footer_web();
}
