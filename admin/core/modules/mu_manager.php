<?php if (!defined('BQN_MU')) {
    die('Access restricted');
}

add_hook('index/invoke_module', '*manager_invoke');

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
        "character" => ['status' => false, 'query' => ''],
        "quest" => ['status' => false, 'query' => ''],
        "warehouse" => ['status' => false, 'query' => ''],
        "memb_info" => ['status' => false, 'query' => ''],
        "dk" => ['status' => false, 'query' => ''],
        "dw" => ['status' => false, 'query' => ''],
        "elf" => ['status' => false, 'query' => ''],
        "sum" => ['status' => false, 'query' => ''],
        "mg" => ['status' => false, 'query' => ''],
        "dl" => ['status' => false, 'query' => ''],
        "rf" => ['status' => false, 'query' => ''],
    ];

    // Update Character
    $result['character']['query'] = "Update Character Set [clevel]='1',[experience]='0',[money]='150000000',[LevelUpPoint]='1500',[pointdutru]='0',[resets]='25',[strength]='26',[dexterity]='26',[vitality]='26',[energy]='26',[Leadership]='26',[Life]='110',[MaxLife]='110',[Mana]='60',[MaxMana]='60',[MapNumber]='0',[MapPosX]='143',[MapPosY]='134',[MapDir]='0',[SCFPCPoints]='0',[MagicList]= CONVERT(varbinary(180), null),[isThuePoint]='0',[NoResetInDay]='0',[NoResetInMonth]='0',[Resets_Time]='0',[Inventory]= 0xFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF";
    $result['character']['status'] = do_insert_other($result['character']['query']);

    // Update Quest
    $result['quest']['query'] = "Update Character Set [Quest]=0xFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF";
    $result['quest']['status'] = do_insert_other($result['quest']['query']);

    //  Update warehouse
    $result['warehouse']['query'] = "Update warehouse set [Money]='0',[Items]= 0xFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF";
    $result['warehouse']['status'] = do_insert_other($result['warehouse']['query']);

    // Update MEMB_INFO
    $result['memb_info']['query'] = "Update MEMB_INFO Set [bank]='0',[vpoint]='0',[jewel_chao]='0',[jewel_cre]='0',[jewel_blue]='0'";
    $result['memb_info']['status'] = do_insert_other($result['memb_info']['query']);

    // Update Class DW
    $result['dw']['query'] = "Update Character SET Class='0' WHERE Class='1' OR Class='2'";
    $result['dw']['status'] = do_insert_other($result['dw']['query']);

    // Update Class DK
    $result['dk']['query'] = "Update Character SET Class='16' WHERE Class='17' OR Class='18'";
    $result['dk']['status'] = do_insert_other($result['dk']['query']);

    // Update Class ELF
    $result['elf']['query'] = "Update Character SET Class='32' WHERE Class='33' OR Class='34'";
    $result['elf']['status'] = do_insert_other($result['elf']['query']);

    // Update Class Sum
    $result['sum']['query'] = "Update Character SET Class='80' WHERE Class='81' OR Class='82'";
    $result['sum']['status'] = do_insert_other($result['sum']['query']);

    // Update Class MG
    $result['mg']['query'] = "Update Character SET Class='48' WHERE Class='49' OR Class='50'";
    $result['mg']['status'] = do_insert_other($result['mg']['query']);

    // Update Class DL
    $result['dl']['query'] = "Update Character SET Class='64' WHERE Class='65' OR Class='66'";
    $result['dl']['status'] = do_insert_other($result['dl']['query']);

    // Update Class RF
    $result['rf']['query'] = "Update Character SET Class='96' WHERE Class='97' OR Class='98'";
    $result['rf']['status'] = do_insert_other($result['rf']['query']);

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

    $class_request = trim(isset($_POST['class']) ? $_POST['class'] : '');
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

//    $result_info_0 = $_POST['result_info_0'];
//    $result_info_1 = $_POST['result_info_1'];
//    $result_info_2 = $_POST['result_info_2'];
//    $result_info_3 = $_POST['result_info_3'];
//    $result_info_4 = $_POST['result_info_4'];
//    $result_info_5 = $_POST['result_info_5'];
//    $result_info_6 = $_POST['result_info_6'];
//    $result_info_7 = $_POST['result_info_7'];
//    $result_info_8 = $_POST['result_info_8'];
//    $result_info_9 = $_POST['result_info_9'];
//    $result_info_10 = $_POST['result_info_10'];
//    $result_info_11 = $_POST['result_info_11'];
//    $result_info_12 = $_POST['result_info_12'];
//    $result_info_13 = $_POST['result_info_13'];
//    $result_info_14 = $_POST['result_info_14'];
//    $result_info_15 = $_POST['result_info_15'];
//    $result_info_16 = $_POST['result_info_16'];
//    $result_info_17 = $_POST['result_info_17'];

    $acx = getOption('#temp_basic');
    // TODO
    if (empty($acx)) {
        return;
    }
    $class = $acx['class'];
    switch ($action) {
        case "search_acc":
            if (empty($acc)) {
                $notice = "Chưa điền tên tài khoản vào chỗ trống";
                $result['search_acc']['notice'] = $notice;
            } else {
                $sql_username_check = do_select_other("SELECT memb___id FROM MEMB_INFO WHERE memb___id='" . $acc . "'");
                if (count($sql_username_check) < 1) {
                    $notice = "Không tồn tại tài khoản <b>$acc</b>";
                    $result['search_acc']['notice'] = $notice;
                } else {
                    $query = "SELECT memb___id,mail_addr,tel__numb,bloc_code,fpas_ques,fpas_answ,bank,vpoint,jewel_chao,jewel_cre,jewel_blue,memb__pwd FROM MEMB_INFO WHERE memb___id='$acc'";
                    $resultQuery = do_select_other($query);
                    $resultData = is_array($resultQuery) ? $resultQuery[0] : [];
                    $result['search_acc']['data'] = $resultData;

                    $block_status = ($resultData['bloc_code'] == "1") ? __("block") : __("normal");
                    $question = '';
                    switch ($resultData['fpas_ques']) {
                        case "myPet":
                            $question = "Tên con vật yêu thích?";
                            break;
                        case "mySchool":
                            $question = "Trường cấp 1 của bạn tên gì?";
                            break;
                        case "bestFriends":
                            $question = "Người bạn yêu quý nhất?";
                            break;
                        case "favorGames":
                            $question = "Trò chơi bạn thích nhất?";
                            break;
                        case "unforgetArea":
                            $question = "Nơi để lại kỉ niệm khó quên nhất?";
                            break;
                    }
                    $notice = "<b>TÀI KHOẢN</b>: <b>" . $resultData['memb___id'] . "</b>. (<b>$block_status</b>)<br>
							Địa chỉ Email: <b>" . $resultData['mail_addr'] . "</b>. Mật khẩu: <b>" . $resultData['memb__pwd'] . "</b><br>
							Số điện thoại: <b>" . $resultData['tel__numb'] . "</b>.<br>
							Câu hỏi bí mật: <b>$question</b>. Câu trả lời bí mật: <b>" . $resultData['fpas_answ'] . "</b>.<br>
							<br>
							<b>NGÂN HÀNG</b>: <br>
							Zen hiện có: <b>" . $resultData['bank'] . "</b> Zen.<br>
							V.Point hiện có: <b>" . $resultData['vpoint'] . "</b> V.Point.<br>
							Ngọc Hỗn Nguyên hiện có: <b>" . $resultData['jewel_chao'] . "</b> Viên.<br>
							Ngọc Sáng Tạo hiện có: <b>" . $resultData['jewel_cre'] . "</b> Viên.<br>
							Lông Vũ hiện có: <b>" . $resultData['jewel_blue'] . "</b> Cái.<br>";
                }
            }
            break;
        case "block_acc":
            if (empty($acc)) {
                $notice = "Chưa điền tên tài khoản vào chỗ trống";
            } else {
                $username_check = do_select_other("SELECT memb___id FROM MEMB_INFO WHERE memb___id='$acc'");
                if (count($username_check) < 1) {
                    $notice = "Không tồn tại tài khoản <b>$acc</b>";
                } else {
                    $block_check = do_select_other("SELECT memb___id FROM MEMB_INFO WHERE memb___id='$acc' and bloc_code='1'");
                    if (count($block_check) > 0) {
                        $notice = "Tài khoản <b>$acc</b> hiện đang bị Khóa.";
                    } else {
                        $sql_block_result = do_update_other("UPDATE MEMB_INFO SET bloc_code='1' WHERE memb___id='$acc'");
                        $notice = "Đã khóa tài khoản <b>$acc</b> " . ($sql_block_result ? "không " : "") . "thành công.";
                    }
                }
            }
            break;
        case "unblock_acc":
            if (empty($acc)) {
                $notice = "Chưa điền tên tài khoản vào chỗ trống";
            } else {
                $username_check = do_select_other("SELECT memb___id FROM MEMB_INFO WHERE memb___id='$acc'");
                if (count($username_check) < 1) {
                    $notice = "Không tồn tại tài khoản <b>$acc</b>";
                } else {
                    $block_check = do_select_other("SELECT memb___id FROM MEMB_INFO WHERE memb___id='$acc' and bloc_code='0'");
                    if (count($block_check) > 0) {
                        $notice = "Tài khoản <b>$acc</b> hiện đang không bị Khóa.";
                    } else {
                        $sql_block_query = do_update_other("UPDATE MEMB_INFO SET bloc_code='0' WHERE memb___id='$acc'");
                        $notice = "Đã mở khóa tài khoản <b>$acc</b> " . ($sql_block_query ? "không " : "") . "thành công.";
                    }
                }
            }
            break;
        case "bank_add":
            if (empty($acc)) {
                $notice = "Chưa điền tên tài khoản vào chỗ trống";
            } else {
                $username_check = do_select_other("SELECT memb___id FROM MEMB_INFO WHERE memb___id='$acc'");
                if (count($username_check) < 1) {
                    $notice = "Không tồn tại tài khoản <b>$acc</b>";
                } else {
                    do_update_other("UPDATE MEMB_INFO SET bank=bank+$zen,vpoint=vpoint+$vpoint WHERE memb___id='$acc'");
                    $notice = "Tài khoản $acc đã cộng thêm $zen Zen và $vpoint V.Point trong Ngân Hàng.";
                }
            }
            break;
        case "bank_sub":
            if (empty($acc)) {
                $notice = "Chưa điền tên tài khoản vào chỗ trống";
            } else {
                $username_check = do_select_other("SELECT memb___id FROM MEMB_INFO WHERE memb___id='$acc'");
                if (count($username_check) < 1) {
                    $notice = "Không tồn tại tài khoản <b>$acc</b>";
                } else {
                    do_update_other("UPDATE MEMB_INFO SET bank=bank-$zen,vpoint=vpoint-$vpoint WHERE memb___id='$acc'");
                    $notice = "Tài khoản $acc đã trừ đi $zen Zen và $vpoint V.Point trong Ngân Hàng.";
                }
            }
            break;
        case "bank_jewel":
            if (empty($acc)) {
                $notice = "Chưa điền tên tài khoản vào chỗ trống";
            } else {
                $username_check = do_select_other("SELECT memb___id FROM MEMB_INFO WHERE memb___id='$acc'");
                if (count($username_check) < 1) {
                    $notice = "Không tồn tại tài khoản <b>$acc</b>";
                } else {
                    do_update_other("UPDATE MEMB_INFO SET jewel_chao='$chao',jewel_cre='$cre',jewel_blue='$blue' WHERE memb___id='$acc'");
                    $notice = "Tài khoản $acc đã cập nhật $chao Chaos, $cre Cre, $blue Blue trong Ngân Hàng.";
                }
            }
            break;
        case "block_char":
            if (empty($char)) {
                $notice = "Chưa điền tên tài khoản vào chỗ trống";
            } else {
                $username_check = do_select_other("SELECT Name FROM Character WHERE Name='$char'");
                if (count($username_check) < 1) {
                    $notice = "Không tồn tại nhân vật <b>$char</b>";
                } else {
                    $block_check = do_select_other("SELECT Name FROM Character WHERE Name='$char' and ctlcode='1'");
                    if (count($block_check) > 0) {
                        $notice = "Nhân vật <b>$char</b> hiện đang bị Khóa.";
                    } else {
                        do_update_other("UPDATE Character SET ctlcode='1' WHERE Name='$char'");
                        $notice = "Đã khóa nhân vật <b>$char</b> thành công.";
                    }
                }
            }
            break;
        case "unblock_char":
            if (empty($char)) {
                $notice = "Chưa điền tên tài khoản vào chỗ trống";
            } else {
                $char_check = do_select_other("SELECT Name FROM Character WHERE Name='$char'");
                if (count($char_check) < 1) {
                    $notice = "Không tồn tại nhân vật <b>$char</b>";
                } else {
                    $block_check = do_select_other("SELECT Name FROM Character WHERE Name='$char' and ctlcode='0'");
                    if (count($block_check) > 0) {
                        $notice = "Nhân vật <b>$char</b> hiện đang không bị Khóa.";
                    } else {
                        do_update_other("UPDATE Character SET ctlcode='0' WHERE Name='$char'");
                        $notice = "Đã mở khóa nhân vật <b>$char</b> thành công.";
                    }
                }
            }
            break;
        case "search_char":
            if (empty($char)) {
                $notice = "Chưa điền tên nhân vật vào chỗ trống";
            } else {
                $char_check = do_select_other("SELECT Name FROM Character WHERE Name='$char'");
                if (count($char_check) < 1) {
                    $notice = "Không tồn tại nhân vật <b>$char</b>";
                } else {
                    $query = "SELECT AccountID,Name,Class,cLevel,Strength,Dexterity,Vitality,Energy,Leadership,Resets,Relifes,LevelUpPoint,pointdutru,uythacoffline_stat,PointUyThac,SCFPCPoints,PkLevel,PkCount,ctlcode FROM Character WHERE Name='$char'";
                    switch (getOption('server_type')) {
                        case "scf":
                            $query = "SELECT AccountID,Name,Class,cLevel,Strength,Dexterity,Vitality,Energy,Leadership,Resets,Relifes,LevelUpPoint,pointdutru,uythacoffline_stat,PointUyThac,SCFPCPoints,PkLevel,PkCount,ctlcode FROM Character WHERE Name='$char'";
                            break;
                        case "ori":
                            $query = "SELECT AccountID,Name,Class,cLevel,Strength,Dexterity,Vitality,Energy,Leadership,Resets,Relifes,LevelUpPoint,pointdutru,uythacoffline_stat,PointUyThac,PCPoints,PkLevel,PkCount,ctlcode FROM Character WHERE Name='$char'";
                            break;
                        default:
                            break;
                    }
                    $resultQuery = do_select_other($query);
                    $row = is_array($resultQuery) ? $resultQuery[0] : [];
                    $result['search_char']['data'] = $row;
                    $account = $row['AccountID'];
                    $name = $row['Name'];
                    $class_current = (int)$row['Class'];
                    $class_name = '';
                    switch ($class_current) {
                        case (int)$class['class_dw_1']:
                            $class_name = $class['class_dw_1_name'];
                            break;
                        case (int)$class['class_dw_2']:
                            $class_name = $class['class_dw_2_name'];
                            break;
                        case (int)$class['class_dw_3']:
                            $class_name = $class['class_dw_3_name'];
                            break;
                        case (int)$class['class_dk_1']:
                            $class_name = $class['class_dk_1_name'];
                            break;
                        case (int)$class['class_dk_2']:
                            $class_name = $class['class_dk_2_name'];
                            break;
                        case (int)$class['class_dk_3']:
                            $class_name = $class['class_dk_3_name'];
                            break;
                        case (int)$class['class_elf_1']:
                            $class_name = $class['class_elf_1_name'];
                            break;
                        case (int)$class['class_elf_2']:
                            $class_name = $class['class_elf_2_name'];
                            break;
                        case (int)$class['class_elf_3']:
                            $class_name = $class['class_elf_3_name'];
                            break;
                        case (int)$class['class_mg_1']:
                            $class_name = $class['class_mg_1_name'];
                            break;
                        case (int)$class['class_mg_2']:
                            $class_name = $class['class_mg_2_name'];
                            break;
                        case (int)$class['class_dl_1']:
                            $class_name = $class['class_dl_1_name'];
                            break;
                        case (int)$class['class_dl_2']:
                            $class_name = $class['class_dl_2_name'];
                            break;
                        case (int)$class['class_sum_1']:
                            $class_name = $class['class_sum_1_name'];
                            break;
                        case (int)$class['class_sum_2']:
                            $class_name = $class['class_sum_2_name'];
                            break;
                        case (int)$class['class_sum_3']:
                            $class_name = $class['class_sum_3_name'];
                            break;
                        case (int)$class['class_rf_1']:
                            $class_name = $class['class_rf_1_name'];
                            break;
                        case (int)$class['class_rf_2']:
                            $class_name = $class['class_rf_2_name'];
                            break;
                    }
                    $level = $row['cLevel'];
                    $str = $row['Strength'];
                    $dex = $row['Dexterity'];
                    $vit = $row['Vitality'];
                    $ene = $row['Energy'];
                    $com = $row['Leadership'];
                    $reset = $row['Resets'];
                    $relife = $row['Relifes'];
                    $point = $row['LevelUpPoint'];
                    $pointdutru = $row['pointdutru'];
                    switch ($row['uythacoffline_stat']) {
                        case 0:
                            $uythac = "Không Ủy thác";
                            break;
                        case 1:
                            $uythac = "<font color='green'>Ủy thác</font>";
                            break;
                    }
                    $uythac_point = $row['PointUyThac'];
                    $pcpoint = isset($row['PCPoints']) ? $row['PCPoints'] : $row['SCFPCPoints'];
                    switch ($row['PkLevel']) {
                        case 1 :
                            $pklevel = "Siêu Anh Hùng";
                            break;
                        case 2 :
                            $pklevel = "Anh Hùng";
                            break;
                        case 3 :
                            $pklevel = "Dân Thường";
                            break;
                        case 4 :
                            $pklevel = "Sát Thủ";
                            break;
                        case 5 :
                            $pklevel = "Sát Thủ Khát Máu";
                            break;
                        case 6 :
                            $pklevel = "Sát Thủ Điên Cuồng";
                            break;
                    }
                    $pkcount = $row['PkCount'];
                    switch ($row['ctlcode']) {
                        case 0:
                            $status = "Bình thường";
                            break;
                        case 1:
                            $status = "Hiện đang bị Khóa";
                            break;
                        case 8:
                            $status = "GameMaster";
                            break;
                        case 18:
                            $status = "Khóa đồ";
                            break;
                    }

                    $notice = '<table width="100%">
						<tr>
							<td><b>TÀI KHOẢN : <font color="blue">' . $account . '</font></b></td>
							<td><b>TÊN NHÂN VẬT : <font color="blue">' . $name . '</font></b></td>
						</tr>
						<tr>
							<td>Cấp độ : <font color="orange"><b>' . $level . '</b></font></td>
							<td>Chủng tộc : <font color="brown"><b>' . $class_name . '</b></font></td>
						</tr>
						<tr>
							<td>Sức mạnh : <b>' . number_format($str, 0, ",", ".") . '</b></td>
							<td>Điểm chưa cộng : <b>' . number_format($point, 0, ",", ".") . '</b></td>
						</tr>
						<tr>
							<td>Nhanh nhẹn : <b>' . number_format($dex, 0, ",", ".") . '</b></td>
							<td>Điểm dự trữ : <b>' . number_format($pointdutru, 0, ",", ".") . '</b></td>
						</tr>
						<tr>
							<td>Sinh lực : <b>' . number_format($vit, 0, ",", ".") . '</b></td>
							<td>Điểm Phúc Duyên : <b>' . number_format($pcpoint, 0, ",", ".") . '</b></td>
						</tr>
						<tr>
							<td>Năng lượng : <b>' . number_format($ene, 0, ",", ".") . '</b></td>
							<td>Reset : <font color="red"><b>' . $reset . '</b></font></td>
						</tr>
						<tr>
							<td>Mệnh lệnh : <b>' . number_format($com, 0, ",", ".") . '</b></td>
							<td>Relife : <font color="green"><b>' . $relife . '</b></font></td>
						</tr>
						<tr>
							<td>Tình trạng Ủy Thác : <b>' . $uythac . '</b></td>
							<td>Điểm Ủy Thác : <font color="green"><b>' . number_format($uythac_point, 0, ",", ".") . '</b></font></td>
						</tr>
						<tr>
							<td>Cấp bậc: <font color="green"><b>' . $pklevel . '</b></font></td>
							<td>Đã giết: <font color="red"><b>' . $pkcount . ' mạng</b></font></td>
						</tr>
						<tr>
							<td>Tình trạng: <font color="orange"><b>' . $status . '</b></font></td>
						</tr>
							</table>';
                }
            }
            break;
        case "edit_char":
            if (empty($char)) {
                $notice = "Chưa điền tên nhân vật vào chỗ trống";
            } else {
                $acc_check = do_select_other("SELECT Name FROM Character WHERE Name='$char'");
                if (count($acc_check) < 1) {
                    $notice = "Không tồn tại nhân vật <b>$char</b>";
                } else {
                    switch (getOption('server_type')) {
                        case "scf":
                            $query = "UPDATE Character SET cLevel='$level',Strength='$str',Dexterity='$dex',Vitality='$vit',Energy='$ene',Leadership='$com',Resets='$reset',Relifes='$relife',LevelUpPoint='$point',pointdutru='$pointdutru',SCFPCPoints='$pcpoint' WHERE Name='$char'";
//                            $query = "UPDATE Character SET Class='$class_post',cLevel='$level',Strength='$str',Dexterity='$dex',Vitality='$vit',Energy='$ene',Leadership='$com',Resets='$reset',Relifes='$relife',LevelUpPoint='$point',pointdutru='$pointdutru',SCFPCPoints='$pcpoint' WHERE Name='$char'";
                            break;
                        case "ori":
                            $query = "UPDATE Character SET cLevel='$level',Strength='$str',Dexterity='$dex',Vitality='$vit',Energy='$ene',Leadership='$com',Resets='$reset',Relifes='$relife',LevelUpPoint='$point',pointdutru='$pointdutru',PCPoints='$pcpoint' WHERE Name='$char'";
                            break;
                        default:
                            $query = "UPDATE Character SET cLevel='$level',Strength='$str',Dexterity='$dex',Vitality='$vit',Energy='$ene',Leadership='$com',Resets='$reset',Relifes='$relife',LevelUpPoint='$point',pointdutru='$pointdutru',SCFPCPoints='$pcpoint' WHERE Name='$char'";
                            break;
                    }
                    do_update_other($query);
                    $notice = "Cập nhật thông tin Nhân vật <b>$char</b> thành công";
                }
            }
            break;
        case "edit_acc":
            if (empty($acc)) {
                $notice = "Chưa điền tên tài khoản vào chỗ trống";
            } else {
                $acc_check = do_select_other("SELECT memb___id,memb__pwd FROM MEMB_INFO WHERE memb___id='$acc'");
                if (count($acc_check) < 1) {
                    $notice = "Không tồn tại tài khoản <b>$acc</b>";
                } else {
                    do_update_other("UPDATE MEMB_INFO SET mail_addr='$email',memb__pwd='$pass' WHERE memb___id='$acc'");
                    $notice = "Cập nhật thông tin Tài khoản <b>$acc</b> thành công";
                }
            }
            break;
//
//        case "ketqua_xoso":
//            $content = $result_info_0."||".$result_info_1."||".$result_info_2."||".$result_info_3."||".$result_info_4."||".$result_info_5."||".$result_info_6."||".$result_info_7."||".$result_info_8."||".$result_info_9."||".$result_info_10."||".$result_info_11."||".$result_info_12."||".$result_info_13."||".$result_info_14."||".$result_info_15."||".$result_info_16."||".$result_info_17;
//            $fp = fopen("../config/ketquaxoso.txt", "w");
//            fputs ($fp, $content);
//            fclose($fp);
//            $sql_acc_check = $db->Execute("SELECT Account FROM XoSoData");
//            $n = 0;
//            $content = "";
//            while($check_acc = $sql_acc_check->fetchrow()) {
//                $query = $db->Execute("SELECT * FROM XoSoData WHERE Account='$check_acc[0]'");
//                $row = $query->fetchrow();
//                for ($i=1;$i<11;$i++) {
//                    if (substr($row[$i],4,2) == $result_info_0) {
//                        $thuong = $giave*$giaithuong1;
//                        $query2 = "UPDATE MEMB_INFO SET vpoint=vpoint+$thuong WHERE memb___id='$check_acc[0]'";
//                        $result = $db->Execute($query2) or die("Lỗi Query: $query2");
//                        $n++;
//                        $content .= "$check_acc[0] trúng giải 1. ".number_format($thuong,0,",",".")." V.Point\n<br>";
//                    }
//                    if (substr($row[$i],3,3) == $result_info_1) {
//                        $thuong = $giave*$giaithuong2;
//                        $query2 = "UPDATE MEMB_INFO SET vpoint=vpoint+$thuong WHERE memb___id='$check_acc[0]'";
//                        $result = $db->Execute($query2) or die("Lỗi Query: $query2");
//                        $n++;
//                        $content .= "$check_acc[0] trúng giải 2. ".number_format($thuong,0,",",".")." V.Point\n<br>";
//                    }
//                    if (substr($row[$i],2,4) == $result_info_2 || substr($row[$i],2,4) == $result_info_3 || substr($row[$i],2,4) == $result_info_4) {
//                        $thuong = $giave*$giaithuong3;
//                        $query2 = "UPDATE MEMB_INFO SET vpoint=vpoint+$thuong WHERE memb___id='$check_acc[0]'";
//                        $result = $db->Execute($query2) or die("Lỗi Query: $query2");
//                        $n++;
//                        $content .= "$check_acc[0] trúng giải 3. ".number_format($thuong,0,",",".")." V.Point\n<br>";
//                    }
//                    if (substr($row[$i],2,4) == $result_info_5) {
//                        $thuong = $giave*$giaithuong4;
//                        $query2 = "UPDATE MEMB_INFO SET vpoint=vpoint+$thuong WHERE memb___id='$check_acc[0]'";
//                        $result = $db->Execute($query2) or die("Lỗi Query: $query2");
//                        $n++;
//                        $content .= "$check_acc[0] trúng giải 4. ".number_format($thuong,0,",",".")." V.Point\n<br>";
//                    }
//                    if (substr($row[$i],1,5) == $result_info_6 || substr($row[$i],1,5) == $result_info_7 || substr($row[$i],1,5) == $result_info_8 || substr($row[$i],1,5) == $result_info_9 || substr($row[$i],1,5) == $result_info_10 || substr($row[$i],1,5) == $result_info_11 || substr($row[$i],1,5) == $result_info_12) {
//                        $thuong = $giave*$giaithuong5;
//                        $query2 = "UPDATE MEMB_INFO SET vpoint=vpoint+$thuong WHERE memb___id='$check_acc[0]'";
//                        $result = $db->Execute($query2) or die("Lỗi Query: $query2");
//                        $n++;
//                        $content .= "$check_acc[0] trúng giải 5. ".number_format($thuong,0,",",".")." V.Point\n<br>";
//                    }
//                    if (substr($row[$i],1,5) == $result_info_13 || substr($row[$i],1,5) == $result_info_14) {
//                        $thuong = $giave*$giaithuong6;
//                        $query2 = "UPDATE MEMB_INFO SET vpoint=vpoint+$thuong WHERE memb___id='$check_acc[0]'";
//                        $result = $db->Execute($query2) or die("Lỗi Query: $query2");
//                        $n++;
//                        $content .= "$check_acc[0] trúng giải 6. ".number_format($thuong,0,",",".")." V.Point\n<br>";
//                    }
//                    if (substr($row[$i],1,5) == $result_info_15) {
//                        $thuong = $giave*$giaithuong7;
//                        $query2 = "UPDATE MEMB_INFO SET vpoint=vpoint+$thuong WHERE memb___id='$check_acc[0]'";
//                        $result = $db->Execute($query2) or die("Lỗi Query: $query2");
//                        $n++;
//                        $content .= "$check_acc[0] trúng giải 7. ".number_format($thuong,0,",",".")." V.Point\n<br>";
//                    }
//                    if (substr($row[$i],1,5) == $result_info_16) {
//                        $thuong = $giave*$giaithuong8;
//                        $query2 = "UPDATE MEMB_INFO SET vpoint=vpoint+$thuong WHERE memb___id='$check_acc[0]'";
//                        $result = $db->Execute($query2) or die("Lỗi Query: $query2");
//                        $n++;
//                        $content .= "$check_acc[0] trúng giải 8. ".number_format($thuong,0,",",".")." V.Point\n<br>";
//                    }
//                    if (substr($row[$i],0,6) == $result_info_17) {
//                        $thuong = $giave*$giaithuong9;
//                        $query2 = "UPDATE MEMB_INFO SET vpoint=vpoint+$thuong WHERE memb___id='$check_acc[0]'";
//                        $result = $db->Execute($query2) or die("Lỗi Query: $query2");
//                        $n++;
//                        $content .= "$check_acc[0] trúng giải 9. ".number_format($thuong,0,",",".")." V.Point\n<br>";
//                    }
//                }
//            }
//            $notice = "Cập nhật kết quả sổ xố và trao thưởng thành công. Có $n số trúng thưởng.\n<br>".$content;
//            break;
//
    }
    cn_assign('acc, result, notice, char, class, class_current', $acc, $result, $notice, $char, $class, $class_current);

    echo_header_admin('-@skins/mu_style.css', __("view_card"));
    echo execTemplate('com_manager/manager_account');
    echofooter();
}
