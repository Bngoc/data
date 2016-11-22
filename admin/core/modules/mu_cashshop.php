<?php if (!defined('BQN_MU')) die('Access restricted');

add_hook('index/invoke_module', '*cashshop_invoke');

// =====================================================================================================================

function cashshop_invoke()
{
    $dashboard = array
    (
        'cashshop:acient:action:Aci' => 'Set thần',
        'cashshop:armor:action:Arm' => 'Giáp trụ',
        'cashshop:wings:action:Win' => 'Cánh',
        'cashshop:ringpendants:action:Rin' => 'Trang sức',
        'cashshop:shields:action:Shi' => 'Khiên',
        'cashshop:crossbows:action:Cro' => 'Cung - Nỏ',
        'cashshop:weapons:action:Wea' => 'Đao - Kiếm',
        'cashshop:scepters:action:Sce' => 'Quyền trượng',
        'cashshop:staffs:action:Sta' => 'Gậy',
        'cashshop:spears:action:Spe' => 'Thương - Giáo',
        'cashshop:fenrir:action:Fen' => 'Linh hồn Sói Tinh',
        'cashshop:eventticket:action:Tic' => 'Vé sự kiện',
        'cashshop:orther:action:Ocas' => 'Các loại khác'
//        'cashshop:tft:action:Crw' => 'Thêm dữ liệu',
    );

    // Call dashboard extend
    $dashboard = hook('extend_cashshop', $dashboard);

    $mod = REQ('mod', 'GETPOST');
    $opt = REQ('opt', 'GETPOST');
//    $_do = REQ('do', 'GETPOST');

    cn_bc_add('Cashshop', cn_url_modify(array('reset'), 'mod=' . $mod));

    // Request menu
    foreach ($dashboard as $id => $_t) {
        list($dl, $do, $action, $acl_module) = explode(':', $id);
        if (test($acl_module) && function_exists("cashshop_$action")) {
            cn_bc_menu($_t, cn_url_modify(array('reset'), 'mod=' . $dl, 'do=' . $action, 'opt=' . $do), $do);
        }
    }

    foreach ($dashboard as $id => $_t) {
        list($dl, $do, $action, $acl_module) = explode(':', $id);

        if (test($acl_module) && $dl == $mod && $do == $opt && function_exists("cashshop_$action")) {
            cn_bc_add($_t, cn_url_modify(array('reset'), 'mod=' . $mod, 'do=' . $action, 'opt=' . $do));
            die(call_user_func("cashshop_$action"));
        }
    }

    echoheader('-@com_cashshop/style.css', "Cash Shop");

    $images = array
    (
        'acient' => 'acient.png',
        'armor' => 'armor.png',
        'spears' => 'spears.png',
        'shields' => 'shields.png',
        'crossbows' => 'crossbows.png',
        'weapons' => 'weapons.png',
        'scepters' => 'scepters.png',
        'staffs' => 'staffs.png',
        'wings' => 'wings.png',
        'ringpendants' => 'ringpendants.png',
        'orther' => 'orther.png',
        'eventticket' => 'eventticket.png',
        'fenrir' => 'fenrir.png',
        'warehouse' => 'warehouse.png'
    );

    // More dashboard images
    $images = hook('extend_dashboard_images', $images);

    foreach ($dashboard as $id => $name) {
        list($mod, $opt, $act, $acl) = explode(':', $id, 4);

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
            'do' => $act,
        );

        $dashboard[$id] = $item;
    }

    $member = member_get();

    $greeting_message = 'Have a nice day!';
    cn_assign('dashboard, username, greeting_message', $dashboard, $member['user_Account'], $greeting_message);
    echo exec_tpl('com_cashshop/general');

    echofooter();
}

// =====================================================================================================================

function cashshop_action()
{
    list($page, $per_page, $opt, $sub) = GET('page, per_page, opt, sub');
    //list($page, $per_page, $opt, $sub) = GET('page, per_page, opt, sub', 'GPG');
    list($_id, $mode) = GET('_id, mode');
    list($txt_name, $txt_price, $txt_code32, $txt_image) = GET('txt_name, txt_price, txt_code32, txt_image', "POST");

    $is_edit = $_id && $mode == 'e';
    $is_add = $mode == 'a';
    $is_delete = $_id && $mode == 'd';
    $is_cancel = $_id && $mode == 'c';

    $item_temp = $s_temp = $s_data = $set_data = array();
    $page = intval($page);
    if (!$txt_image) $txt_image = '';
    if (!$txt_name) $txt_name = '';
    if (!$txt_price) $txt_price = '1000';
    //if(!$page) $page = 0;
    if (intval($per_page) == 0) $per_page = 25;

    $__data = getoption('#item_shop' . $opt);

    //$files = scan_dir(cn_path_construct(ROOT ,'core','cashshop'), 'txt');
    //$_grps = getoption('#items_data'); //?

    if (REQ('__item', 'GPG') == 'change-item') {
        foreach ($__data as $key => $raw) $s_temp[] = $raw['code32'];
        $s_data = cn_read_file($path = cn_path_construct(ROOT, 'core', 'cashshop') . 'shop_' . $opt . '.php');

        /// So sanh code item 32
        if (count($s_data)) {
            foreach ($s_data as $key => $var) {
                if (array_search(trim($var['code32']), $s_temp) !== false)
                    unset($s_data[$key]);
            }
            $__data = array_merge($s_data, $__data);

            //exit();
            //if($s_data)
            //setoption('#item_shop'.$opt, $s_data);
            setoption('#item_shop' . $opt, $__data);
            cn_throw_message('Add Code Item successfully');
        }
    } else if (REQ('__item', 'GPG') == 'del-item') {
        unset($__data);
        setoption('#item_shop' . $opt, array());
        cn_throw_message('Delete all Code Item successfully');
    }
    //$s_data=cn_read_file($path = cn_path_construct(ROOT,'core','cashshop').'shop_'.$opt.'.php'); //shop_acient
    //list($item_read, $get_paging) = cn_arr_pagina($s_data, 'mod=cashshop', $page, $per_page);
    //list($item_read, $get_paging) = cn_arr_pagina($s_data, cn_url_modify('mod=cashshop', 'do=action', "opt=".$opt), $page, $per_page);

    if (request_type('POST')) {
        cn_dsi_check();
        //$cat_acl=!empty($category_acl)?join(',', $category_acl):'';
        $is_duble = false;
        $message = false;

        if (!empty($txt_code32)) {
            if ($is_add) {
                //Check category dubles
                if (!empty($__data)) {
                    foreach ($__data as $key => $value) {
                        //$is_duble=$value['code32']==$txt_code32&&$value['name']==$txt_name;
                        $is_duble = $value['code32'] == $txt_code32;
                        if ($is_duble) break;
                    }
                }

                if (!$is_duble) {
                    //$categories_call['#']=count($categories_call)!=0?$categories_call['#']+1:1;
                    $item_add['#'] = ctime();//time();count($item_read)
                    $_id = intval($item_add['#']);
                    $message = 'Code Item added';
                } else {
                    cn_throw_message('This Code Item already exist', 'e');
                }
            } elseif ($is_edit) {
                $message = 'Item edited';
            } elseif ($is_delete) {
                if (array_key_exists($_id, $__data)) {
                    //unset($item_read[$_id]);
                    unset($__data[$_id]);
                    $_id = 0;
                    $message = 'Item deleted';
                }
            } elseif ($is_cancel) {
                $_id = 0;
            }

            //add to array
            if (!empty($_id)) {
                //$item_read[$_id] = cn_item_info($txt_code32, $txt_name, $txt_price);

                $__data[$_id]['code32'] = $txt_code32;
                $__data[$_id]['name'] = $txt_name;
                $__data[$_id]['price'] = $txt_price;
                $__data[$_id]['image_mh'] = $txt_image;

                cn_throw_message($message);

                //cn_relocation(cn_url_modify(array('reset'), 'mod='.REQ('mod'), 'opt='.REQ('opt'), 'do=action'));
            }

            if (!$is_cancel) {
                setoption('#item_shop' . $opt, $__data);
            }
            $txt_image = $txt_name = $txt_price = $txt_code32 = $_id = '';
        } elseif (!$is_delete) {
            cn_throw_message('Empty Code Item', 'e');
        }
    }

    if (isset($__data))
        foreach ($__data as $key => $raw)
            $set_data[$key] = cn_item_info($raw['code32'], $raw['name'], $raw['price'], $raw['image_mh']);

    $items_data = getoption('#items_data');
    $key_items_data = array_keys($items_data);

    foreach ($set_data as $key => $raw) {
        if (!in_array($key_itm = ($raw['group'] . '.' . $raw['id']), $key_items_data)) {
            $item_temp[$key_itm] = array(
                'Image' => $raw['image'],
                'G' => $raw['group'],
                'ID' => $raw['id'],
                'Name' => $raw['title'],
                'X' => $raw['x'],
                'Y' => $raw['y'],
                'SET1' => $raw['set1'],
                'SET2' => $raw['set2'],
            );
        }
    }
    if ($item_temp) {
        setoption('#items_data', array_merge($items_data, $item_temp));
    }

    list($item_read, $get_paging) = cn_arr_pagina($set_data, cn_url_modify(array('reset'), 'mod=cashshop', 'do=action', "opt=$opt", '__item', '_id'), $page, $per_page);

    if ($_id) {
        $txt_name = $__data[$_id]['name'];
        $txt_price = $__data[$_id]['price'];
        $txt_code32 = $__data[$_id]['code32'];
        $txt_image = $__data[$_id]['image_mh'];
    }

    $bc_title = mcache_get('.menu');

    cn_assign('item_read, per_page, pagination, opt, sub', $item_read, $per_page, $get_paging, $opt, $sub);
    cn_assign('_id, _txt_name, _txt_price, _txt_code32, _txt_image', $_id, $txt_name, $txt_price, $txt_code32, $txt_image);

    echoheader('-@com_cashshop/style.css', "Configurations - " . $bc_title[$opt]['name']);
    echo exec_tpl('com_cashshop/_armor');
    echofooter();
}


//==========================================================================================================
// Since 2.0: System configurations
/*
function cashshop_acient()
{
    list($page, $per_page, $opt, $sub) = GET('page, per_page, opt, sub', 'GPG'); //bat
    //$lng   = $grps = $all_skins = array();
    $page = intval($page);
    //$per_page = intval($per_page);
    if (!$page) $page = 0;
    if (intval($per_page) == 0) $per_page = 25;

    //$skins = scan_dir(cn_path_construct(SERVDIR,'skins'));
    echo "143 opt =============> $opt ROOT =>" . ROOT . ".----." . cn_path_construct(ROOT, 'core', 'cashshop') . "<br>";
    $files = scan_dir(cn_path_construct(ROOT, 'core', 'cashshop'), 'txt');
    //$_grps = getoption('#items_data'); //?

    $s_data = cn_read_file(cn_path_construct(ROOT, 'core', 'cashshop') . 'shop_' . $opt . '.php'); //shop_acient
    list($item_read, $get_paging) = cn_arr_pagina($s_data, 'mod=cashshop', $page, $per_page);

    foreach ($item_read as $f => $h)
        echo "162 >>> $f =>" . $h['image'] . " <br>";

    //foreach ($s_data as $key => $raw){
    //echo "163 lf = $raw --- c = c <br>";
    //}

    // chua co data............

    //$cfg = ($conf_path); //doc or tao file
    // fetch skins
    /*
    foreach ($skins as $skin)
    {
        if (preg_match('/(.*)\.skin\.php/i', $skin, $c)) //<=> *.skin.php
        {
            $all_skins[$c[1]] = $c[1];
        }
    }
*
    // fetch lang packets
    foreach ($files as  $lf){
        echo "163 lf = $lf --- c = $c <br>";
        if (preg_match('/(.*)\acient.txt/i', $lf, $c)){
            $lng[$c[1]] = $c[1];
            break;
        }
    }


    cn_assign('item_read, per_page, pagination, opt, sub', $item_read, $per_page, $get_paging, $opt, $sub);

    //echoheader('-@com_board/style.css', "Templates"); echo exec_tpl('com_board/classchar'); echofooter();
    echoheader('-@com_cashshop/style.css', "Configurations - Set thần");
    //echo exec_tpl('header');
    echo exec_tpl('com_cashshop/_acient');
    echofooter();
}

function cashshop_armor()
{
    list($page, $per_page, $opt, $sub) = GET('page, per_page, opt, sub', 'GPG');
    //list($category_name, $category_memo, $category_parent) = GET('category_icon, category_parent, category_acl', "POST");

    //$lng   = $grps = $all_skins = array();
    $page = intval($page);
    //$per_page = intval($per_page);
    if (!$page) $page = 0;
    if (intval($per_page) == 0) $per_page = 25;
    //if (intval($page) == 0) $page = 25;

    //$skins = scan_dir(cn_path_construct(SERVDIR,'skins'));
    //echo "143 opt =============> $opt ROOT =>" . ROOT . ".----." . cn_path_construct(ROOT ,'core','cashshop'). "<br>";
    //$files = scan_dir(cn_path_construct(ROOT ,'core','cashshop'), 'txt');
    //$_grps = getoption('#items_data'); //?

    $s_data = cn_read_file($path = cn_path_construct(ROOT, 'core', 'cashshop') . 'shop_' . $opt . '.php'); //shop_acient
    list($item_read, $get_paging) = cn_arr_pagina($s_data, 'mod=cashshop', $page, $per_page);

    foreach ($item_read as $f => $h)
        echo "162 >>> $f =>" . $h['image'] . " <br>";


    cn_assign('item_read, per_page, pagination, opt, sub', $item_data, $per_page, $get_paging, $opt, $sub);

    //echoheader('-@com_board/style.css', "Templates"); echo exec_tpl('com_board/classchar'); echofooter();
    echoheader('-@com_cashshop/style.css', "Configurations - Giáp trụ");
    //echo exec_tpl('header');
    echo exec_tpl('com_cashshop/_armor');
    echofooter();
}

*/
