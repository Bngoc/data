<?php if (!defined('BQN_MU')) {
    die('Access restricted');
}

add_hook('index/invoke_module', '*manager_invoke');
include(ROOT . '/admin/core/services/ServiceMuManager.php');

// =====================================================================================================================
function manager_invoke()
{
    $dashManager = array(
        'manager:restart_data:Can' => __('restart_data'),
        'manager:debit_point:Can' => __('debit_point'),
        'manager:vpoint:Can' => __('v_point'),
        'manager:pc_point:Can' => __('pc_point'),
        'manager:card_phone:Can' => __('card_phone'),
        'manager:view_card:Can' => __('view_card'),
        'manager:account:Can' => __('manager_account'),
    );

    // Call dashboard extend
    $dashManager = hook('extend_dashboard', $dashManager);

    // Exec
    $mod = REQ('mod', 'GETPOST');
    $opt = REQ('opt', 'GETPOST');

    cn_bc_add('Cashshop', cn_url_modify(array('reset'), 'mod=' . $mod));

    // Request menu
    foreach ($dashManager as $id => $_t) {
        list($dl, $do, $acl_module) = explode(':', $id);
        if (testRoleAdmin($acl_module) && function_exists("manager_$do")) {
            cn_bc_menu($_t, cn_url_modify(array('reset'), 'mod=' . $dl, 'opt=' . $do), $do);
        }
    }

    foreach ($dashManager as $id => $_t) {
        list($dl, $do, $acl_module) = explode(':', $id);

        if (testRoleAdmin($acl_module) && $dl == $mod && $do == $opt && function_exists("manager_$do")) {
            cn_bc_add($_t, cn_url_modify(array('reset'), 'mod=' . $mod, 'opt=' . $do));
            die(call_user_func("manager_$do"));
        }
    }

    echo_header_admin('-@skins/mu_style.css', __("manager"));
    $images = array(
        'restart_data' => 'user.gif',
        'debit_point' => 'options.gif',
        'vpoint' => 'category.png',
        'pc_point' => 'template.png',
        'card_phone' => 'archives.gif',
        'view_card' => 'arch.png',
        'account' => 'arch.png',
    );

    // More dashboard images
    $images = hook('extend_dashboard_images', $images);

    foreach ($dashManager as $id => $name) {
        list($mod, $opt, $acl) = explode(':', $id, 4);

        if (!testRoleAdmin($acl)) {
            unset($dashManager[$id]);
            continue;
        }

        $item = array(
            'name' => $name,
            'img' => isset($images[$opt]) ? $images[$opt] : 'home.gif',
            'mod' => $mod,
            'opt' => $opt,
        );

        $dashManager[$id] = $item;
    }

    cn_assign('dashboard', $dashManager);

    echo execTemplate('com_manager/general');
    echofooter();
}

function manager_restart_data()
{
    $result = [
        "character" => ['status' => false, 'query' => "Update Character Set [clevel]='1',[experience]='0',[money]='150000000',[LevelUpPoint]='1500',[pointdutru]='0',[resets]='25',[strength]='26',[dexterity]='26',[vitality]='26',[energy]='26',[Leadership]='26',[Life]='110',[MaxLife]='110',[Mana]='60',[MaxMana]='60',[MapNumber]='0',[MapPosX]='143',[MapPosY]='134',[MapDir]='0',[SCFPCPoints]='0',[MagicList]= CONVERT(varbinary(180), null),[isThuePoint]='0',[NoResetInDay]='0',[NoResetInMonth]='0',[Resets_Time]='0',[Inventory]= 0xFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF"],
        "quest" => ['status' => false, 'query' => "Update Character Set [Quest]=0xFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF"],
        "warehouse" => ['status' => false, 'query' => "Update warehouse set [Money]='0',[Items]= 0xFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF"],
        "memb_info" => ['status' => false, 'query' => "Update MEMB_INFO Set [bank]='0',[vpoint]='0',[jewel_chao]='0',[jewel_cre]='0',[jewel_blue]='0'"],
        "dk" => ['status' => false, 'query' => "Update Character SET Class='16' WHERE Class='17' OR Class='18'"],
        "dw" => ['status' => false, 'query' => "Update Character SET Class='0' WHERE Class='1' OR Class='2'"],
        "elf" => ['status' => false, 'query' => "Update Character SET Class='32' WHERE Class='33' OR Class='34'"],
        "sum" => ['status' => false, 'query' => "Update Character SET Class='80' WHERE Class='81' OR Class='82'"],
        "mg" => ['status' => false, 'query' => "Update Character SET Class='48' WHERE Class='49' OR Class='50'"],
        "dl" => ['status' => false, 'query' => "Update Character SET Class='64' WHERE Class='65' OR Class='66'"],
        "rf" => ['status' => false, 'query' => "Update Character SET Class='96' WHERE Class='97' OR Class='98'"],
    ];

    if (request_type('POST')) {
        list($restart_query) = GET('restart_query', 'GPG');
        foreach ($result as $k => $val) {
            $strKey = 'key_' . $k;
            $statusCheck = isset($_POST[$strKey]) ? $_POST[$strKey] : false;
            if ($statusCheck && isset($result[$restart_query])) {
                $result[$k]['status'] = true;
            }
        }

        // Update Character
        if (isset($result[$restart_query]) && $result[$restart_query]['query']) {
            $check = do_insert_other($result[$restart_query]['query']);
            $result[$restart_query]['status'] = $check;
            $msg = 'Updated ' . ($check ? __('done') : __('fail')) . '.';
            if ($check) {
                cn_throw_message($msg);
            } else {
                cn_throw_message($msg, 'e');
            }
        }
    }

    cn_assign('result', $result);
    echo_header_admin('-@skins/mu_style.css', __("restart_data"));
    echo execTemplate('com_manager/restart_data');
    echofooter();
}

function manager_debit_point()
{
    $result = do_select_character('Character', 'Name,IsThuePoint,TimeThuePoint', "IsThuePoint=1 Order By TimeThuePoint ASC");

    $time = time();
    foreach ($result as &$value) {
        $value['status'] = __('none');
        if ($value['IsThuePoint'] === 1) {
            $value['status'] = __("renting_point");
        }
        if ($value['IsThuePoint'] === 2) {
            $value['status'] = __("process");
        }

        $time_du = $value['TimeThuePoint'] - $time;
        $hour = floor($time_du / 3600);
        $phut = floor(($time_du - $hour * 3600) / 60);

        $value['time'] = "$hour h $phut m";
    }

    cn_assign('result', $result);
    echo_header_admin('-@skins/mu_style.css', __("debit_point"));
    echo execTemplate('com_manager/debit_point');
    echofooter();
}

function manager_vpoint()
{
    $result = do_select_character('MEMB_INFO', 'memb___id,vpoint,bloc_code', "WHERE vpoint>50000 ORDER BY vpoint DESC");

    $time = time();
    foreach ($result as &$value) {
        $value['status'] = __('none');
        if ($value['IsThuePoint'] === 1) {
            $value['status'] = __("renting_point");
        }
        if ($value['IsThuePoint'] === 2) {
            $value['status'] = __("process");
        }

        $time_du = $value['TimeThuePoint'] - $time;
        $hour = floor($time_du / 3600);
        $phut = floor(($time_du - $hour * 3600) / 60);

        $value['time'] = "$hour h $phut m";
    }
    cn_assign('result', $result);
    echo_header_admin('-@skins/mu_style.css', __("vpoint"));
    echo execTemplate('com_manager/vpoint');
    echofooter();
}

function manager_pc_point()
{
    $result = do_select_character('Character', 'AccountID,Name,SCFPCPoints', "SCFPCPoints>0 ORDER BY SCFPCPoints DESC");

    cn_assign('result', is_array($result) ? $result : []);
    echo_header_admin('-@skins/mu_style.css', __("pc_point"));
    echo execTemplate('com_manager/pc_point');
    echofooter();
}

function manager_card_phone()
{
    // TODO check all function card phone
    $time_now = $timestamp;
    $day_now = date("d", $time_now);
    $month_now = date("m", $time_now);
    $year_now = date("Y", $time_now);

    $time_after_1day = time() - 86400;
    $day_after_1day = date("d", $time_after_1day);
    $month_after_1day = date("m", $time_after_1day);
    $year_after_1day = date("Y", $time_after_1day);

    $thang = $_GET['thang'];
    $nam = $_GET['nam'];
    if (isset($thang)) {
        $month = $thang;
    } else $thang = $month;

    if (isset($nam)) {
        $year = $nam;
    } else $nam = $year;

    if (eregi("[^0-9$]", $thang)) {
        echo "<center>Dữ liệu lỗi. Tháng : $thang chỉ được sử dụng số.</center>";
        exit();
    }

    if ($thang < 1 OR $thang > 12) {
        echo "<center>Dữ liệu lỗi. Tháng : $thang chỉ từ 1 đến 12</center>";
        exit();
    }
    if (eregi("[^0-9$]", $nam)) {
        echo "<center>Dữ liệu lỗi. Năm : $nam chỉ được sử dụng số.</center>";
        exit();
    }
    if ($nam < 2015 OR $nam > 2200) {
        echo "<center>Dữ liệu lỗi. Hiện tại chỉ cho phép năm : $nam từ 2008 đến 2010</center>";
        exit();
    }

    $thang_truoc = $thang - 1;
    $thang_sau = $thang + 1;

    $nam_truoc = $nam;
    $nam_sau = $nam;

    if ($month == 1) {
        $thang_truoc = 12;
        $nam_truoc = $year - 1;
    }
    if ($month == 12) {
        $thang_sau = 1;
        $nam_sau = $year + 1;
    }

//Update doanh thu thang hien tai
    $check_tontai_thanghientai = $db->Execute("SELECT month FROM doanhthu WHERE month='$month' and year='$year'");
    $tontai_thanghientai = $check_tontai_thanghientai->numrows();
    if ($tontai_thanghientai == 0) {
        $update_doanhthu_thanghientai = $db->Execute("INSERT INTO doanhthu (month, year,card_type) VALUES ($month, $year,'Viettel')");
    }
//Update doanh thu thang tiep theo
    $check_tontai_thangtieptheo = $db->Execute("SELECT month FROM doanhthu WHERE month ='$thang_sau' and year='$nam_sau'");
    $tontai_thangtieptheo = $check_tontai_thangtieptheo->numrows();
    if ($tontai_thangtieptheo == 0) {
        $update_doanhthu_thangtieptheo = $db->Execute("INSERT INTO doanhthu (month, year,card_type) VALUES ($thang_sau, $nam_sau,'Viettel')");
    }


    $fpage = intval($_GET['page']);
    if (empty($fpage)) {
        $fpage = 1;
    }
    $fstart = ($fpage - 1) * $Card_per_page;
    $fstart = round($fstart, 0);
    $stt_str = $fstart;

    $action = $_GET['action'];
    if (empty($action)) {
        $action = '';
    }

    $stt = intval($_GET['stt']);
    if (empty($stt)) {
        $stt = '';
    }

    $up_stat = intval($_GET['up_stat']);
    if (empty($up_stat)) {
        $up_stat = '';
    }

    $acc = $_GET['acc'];
    if (empty($acc)) {
        $acc = '';
    }

    $card_type = $_GET['card_type'];
    if (empty($card_type)) {
        $card_type = '';
    }
    switch ($card_type) {
        case "VTC":
            include("../config/config_napthe_vtc.php");
            break;
        case "Gate":
            include("../config/config_napthe_gate.php");
            break;
        case "Viettel":
            include("../config/config_napthe_viettel.php");
            break;
        case "Mobi":
            include("../config/config_napthe_mobi.php");
            break;
        case "Vina":
            include("../config/config_napthe_vina.php");
            break;
        default:
            include("../config/config_napthe_vtc.php");
            break;
    }

    $status = intval($_GET['status']);
    if (empty($status)) {
        $status = '';
    }

    $add_vpoint = intval($_GET['add_vpoint']);
    if (empty($add_vpoint)) {
        $add_vpoint = '';
    }

    $menhgia = intval($_GET['menhgia']);
    if (empty($menhgia)) {
        $menhgia = '';
    }

    $edit_menhgia = intval($_GET['edit_menhgia']);
    if (empty($edit_menhgia)) {
        $edit_menhgia = '';
    }

    if ($menhgia == 10000) {
        $vpointadd = $menhgia10000;
    }
    if ($menhgia == 20000) {
        $vpointadd = $menhgia20000;
    }
    if ($menhgia == 30000) {
        $vpointadd = $menhgia30000;
    }
    if ($menhgia == 50000) {
        $vpointadd = $menhgia50000;
    }
    if ($menhgia == 100000) {
        $vpointadd = $menhgia100000;
    }
    if ($menhgia == 200000) {
        $vpointadd = $menhgia200000;
    }
    if ($menhgia == 300000) {
        $vpointadd = $menhgia300000;
    }
    if ($menhgia == 500000) {
        $vpointadd = $menhgia500000;
    }

//Khuyen mai chung
    if ($khuyenmai == 1) {
        $vpointadd = $vpointadd * (1 + ($khuyenmai_phantram / 100));
    }
//vpoint khi nạp thẻ VTC nhiều hơn các thẻ khác
    if ($card_type == 'VTC' && $khuyenmai_vtc > 0) {
        $vpointadd = $vpointadd * (1 + ($khuyenmai_vtc / 100));
    }


    if ($action == 'up_stat') {
        $query_select_card = $db->Execute("Select * from CardPhone where stt=$stt");
        $select_card = $query_select_card->fetchrow();

        if ($select_card[8] == $up_stat) {
            echo "<center>Không thể cập nhập tình trạng thẻ giống tình trạng thẻ hiện tại.</center>";
        } else {

            $query_upstat = "Update CardPhone Set status=$up_stat Where stt=$stt";
            $upstat = $db->Execute($query_upstat);
            if ($up_stat == 1 && $add_vpoint == 0) {
                $query_addvpoint = "Update MEMB_INFO set vpoint=vpoint+$vpointadd Where memb___id='$acc'";
                $addvpoint = $db->Execute($query_addvpoint);

                $query_statvpoint = "Update CardPhone set addvpoint=1 Where stt=$stt";
                $statvpoint = $db->Execute($query_statvpoint);
            }
            if ($up_stat == 2 or $up_stat == 3) {
                $query_check_card = $db->Execute("select addvpoint from CardPhone where stt=$stt");
                $check_card = $query_check_card->fetchrow();
//Thẻ đúng
                if ($up_stat == 2) {
                    //Begin Kiểm tra có tồn tại doanh thu của loại thẻ nạp
                    $check_tontai_doanhthu_cardtype = $db->Execute("SELECT month FROM doanhthu WHERE month='$month' and year='$year' AND card_type='$card_type'");
                    $tontai_doanhthu_cardtype = $check_tontai_doanhthu_cardtype->numrows();
                    if ($tontai_doanhthu_cardtype == 0) {
                        $update_doanhthu_cardtype = $db->Execute("INSERT INTO doanhthu (month, year,card_type) VALUES ($month, $year,'$card_type')");
                    }
                    //End Kiểm tra có tồn tại doanh thu của loại thẻ nạp
                    $query_updatedoanhthu = "Update doanhthu set money=money+$menhgia Where month='$month' And year='$year' AND card_type='$card_type'";
                    $updatedoanhthu = $db->Execute($query_updatedoanhthu);
                    if ($check_card[0] == 0) {
                        $query_addvpoint = "Update MEMB_INFO set vpoint=vpoint+$vpointadd Where memb___id='$acc'";
                        $addvpoint = $db->Execute($query_addvpoint);

                        $query_statvpoint = "Update CardPhone set addvpoint=1,timeduyet=$timestamp Where stt=$stt";
                        $statvpoint = $db->Execute($query_statvpoint);
                    }
                }
//Thẻ sai
                if ($up_stat == 3) {
                    if ($check_card[0] == 1) {
                        $query_addvpoint = "Update MEMB_INFO set vpoint=vpoint-$vpointadd Where memb___id='$acc'";
                        $addvpoint = $db->Execute($query_addvpoint);
                    }
                    $query_statvpoint = "Update CardPhone set addvpoint=0,timeduyet=$timestamp Where stt=$stt";
                    $statvpoint = $db->Execute($query_statvpoint);
                }
            }
        }
    }

    if ($action == 'edit_menhgia') {
        $query_editmenhgia = "Update CardPhone Set menhgia=$edit_menhgia Where stt=$stt";
        $editmenhgia = $db->Execute($query_editmenhgia);
    }

    if ($action == 'dellcard') {
        $dell_card = $db->Execute("DELETE FROM CardPhone Where status=2 OR status=3");
    }

    $query = "Select * From CardPhone ";
    $list_card_type = $_GET['list_card_type'];
    $list_menhgia = intval($_GET['list_menhgia']);
    $list_status = intval($_GET['list_status']);

    if (empty($list_card_type) && empty($list_menhgia) && empty($list_status) && empty($list_ctv) && empty($list_ctv_check)) {
    } else {
        $query .= "Where ";
    }

    if (empty($list_card_type)) {
        $list_card_type = '';
    } else {
        $query .= "card_type='$list_card_type' ";
    }

    if (empty($list_menhgia)) {
        $list_menhgia = '';
    } else {
        if (empty($list_card_type)) {
        } else {
            $query .= "and ";
        }
        $query .= "menhgia='$list_menhgia' ";
    }

    if (empty($list_status)) {
        $list_status = '';
    } else {
        if (empty($list_card_type) && empty($list_menhgia)) {
        } else {
            $query .= "and ";
        }
        if ($list_status == 1) {
            $query .= "status is NULL ";
        } else {
            if ($list_status == 2) {
                $list_stat = 1;
            }
            if ($list_status == 3) {
                $list_stat = 2;
            }
            if ($list_status == 4) {
                $list_stat = 3;
            }
            $query .= "status='$list_stat' ";
        }
    }


    if ($list_status == 1 or $list_status == 2) {
        $query .= "ORDER BY stt ASC";
    } else {
        $query .= "ORDER BY stt DESC";
    }

    $result = $db->SelectLimit($query, $Card_per_page, $fstart);

    $query_doanhthu = "SELECT SUM(money) FROM doanhthu WHERE month ='$month' and year='$year'";
    if (!empty($list_card_type)) {
        $query_doanhthu .= " AND card_type='$list_card_type'";
    }
    $check_doanhthu = $db->Execute("$query_doanhthu");
    $doanhthu = $check_doanhthu->fetchrow();
    $doanhthu_total = number_format($doanhthu[0], 0, ',', '.');

    $query_doanhthu_homqua = $db->Execute("SELECT SUM(menhgia) FROM CardPhone Where day(ngay)='$day_after_1day' AND month(ngay)='$month_after_1day' AND year(ngay)='$year_after_1day' AND status=2");
    $doanhthu_homqua = $query_doanhthu_homqua->fetchrow();

    $query_doanhthu_hientai = $db->Execute("SELECT SUM(menhgia) FROM CardPhone Where day(ngay)='$day_now' AND month(ngay)='$month_now' AND year(ngay)='$year_now' AND status=2");
    $doanhthu_hientai = $query_doanhthu_hientai->fetchrow();

    echo_header_admin('-@skins/mu_style.css', __("card_phone"));
    echo execTemplate('com_manager/card_phone');
    echofooter();
}

function manager_view_card()
{
    // TODO check all function card phone
    echo_header_admin('-@skins/mu_style.css', __("view_card"));
    echo execTemplate('com_manager/view_card');
    echofooter();
}

function manager_account()
{
    $result = [
        'search_acc' => ['notice' => '', 'data' => []],
        'search_char' => ['notice' => '', 'data' => []],
    ];
    $notice = '';
    $class_current = null;
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    $acc = trim(isset($_POST['acc']) ? $_POST['acc'] : '');
    $email = trim(isset($_POST['email']) ? $_POST['email'] : '');
    $pass = trim(isset($_POST['pass']) ? $_POST['pass'] : '');

    $char = trim(isset($_POST['char']) ? $_POST['char'] : '');

    $zen = isset($_POST['zen']) ? (int)$_POST['zen'] : 0;
    $vpoint = isset($_POST['vpoint']) ? (int)$_POST['vpoint'] : 0;
    $chao = isset($_POST['chao']) ? (int)$_POST['chao'] : 0;
    $cre = isset($_POST['cre']) ? (int)$_POST['cre'] : 0;
    $blue = isset($_POST['blue']) ? (int)$_POST['blue'] : 0;

    $class_post = trim(isset($_POST['class']) ? $_POST['class'] : '');
    $level = trim(isset($_POST['level']) ? $_POST['level'] : 0);
    $str = trim(isset($_POST['str']) ? $_POST['str'] : 0);
    $dex = trim(isset($_POST['dex']) ? $_POST['dex'] : 0);
    $vit = trim(isset($_POST['vit']) ? $_POST['vit'] : 0);
    $ene = trim(isset($_POST['ene']) ? $_POST['ene'] : 0);
    $com = trim(isset($_POST['com']) ? $_POST['com'] : 0);
    $reset = trim(isset($_POST['reset']) ? $_POST['reset'] : 0);
    $relife = trim(isset($_POST['relife']) ? $_POST['relife'] : 0);
    $point = trim(isset($_POST['point']) ? $_POST['point'] : 0);
    $pointdutru = trim(isset($_POST['pointdutru']) ? $_POST['pointdutru'] : 0);
    $pcpoint = trim(isset($_POST['pcpoint']) ? $_POST['pcpoint'] : 0);

    $acx = getOption('#temp_basic');
    if (empty($acx)) {
        return;
    }

    $class = $acx['class'];
    $muManager = new ServiceMuManager();
    switch ($action) {
        case "search_acc":
        {
            $resultSearchAccount = $muManager->search_account($acc);

            $notice = $resultSearchAccount['notice'];
            $result['search_acc']['notice'] = $notice;
            $result['search_acc']['data'] = $resultSearchAccount['data'];

            break;
        }
        case "block_acc":
        {
            $resultSearchAccount = $muManager->block_account($acc);

            $notice = $resultSearchAccount['notice'];
            break;
        }
        case "unblock_acc":
        {
            $resultSearchAccount = $muManager->unblock_account($acc);

            $notice = $resultSearchAccount['notice'];
            break;
        }
        case "bank_add":
        {
            $notice = $muManager->bank_add($acc, $zen, $vpoint);

            break;
        }
        case "bank_sub":
        {
            $notice = $muManager->bank_sub($acc, $zen, $vpoint);

            break;
        }
        case "bank_jewel":
        {
            $notice = $muManager->bank_jewel($acc, $chao, $cre, $blue);
            break;
        }
        case "edit_acc":
        {
            $notice = $muManager->edit_account($acc, $email, $pass);
            break;
        }
        case "block_char":
        {
            $notice = $muManager->block_character($char);
            break;
        }
        case "unblock_char":
        {
            $notice = $muManager->unblock_character($char);
            break;
        }
        case "search_char":
        {
            $resultSearchAccount = $muManager->search_character($char, $class);

            $notice = $resultSearchAccount['notice'];
            $result['search_char']['notice'] = $notice;
            $result['search_char']['data'] = $resultSearchAccount['data'];
            $class_current = $resultSearchAccount['options']['class_current'];
            break;
        }
        case "edit_char":
        {
            $notice = $muManager->edit_character($char, $class_post, $level, $str, $dex, $vit, $ene, $com, $reset, $relife, $point, $pointdutru, $pcpoint);
            break;
        }
    }

    cn_assign('acc, result, notice, char, class, class_current', $acc, $result, $notice, $char, $class, $class_current);

    echo_header_admin('-@skins/mu_style.css', __("view_card"));
    echo execTemplate('com_manager/manager_account');
    echofooter();
}

