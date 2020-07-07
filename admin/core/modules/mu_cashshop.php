<?php if (!defined('BQN_MU')) {
    die('Access restricted');
}

add_hook('index/invoke_module', '*cashshop_invoke');

// =====================================================================================================================

function cashshop_invoke()
{
    $dashboard = array(
        'cashshop:acient:action:Aci' => __('cash_shop_acient'),
        'cashshop:armor:action:Arm' => __('cash_shop_armor'),
        'cashshop:wings:action:Win' => __('cash_shop_wings'),
        'cashshop:ringpendants:action:Rin' => __('cash_shop_ringpendants'),
        'cashshop:shields:action:Shi' => __('cash_shop_shields'),
        'cashshop:crossbows:action:Cro' => __('cash_shop_crossbows'),
        'cashshop:weapons:action:Wea' => __('cash_shop_weapons'),
        'cashshop:scepters:action:Sce' => __('cash_shop_scepters'),
        'cashshop:staffs:action:Sta' => __('cash_shop_staffs'),
        'cashshop:spears:action:Spe' => __('cash_shop_spears'),
        'cashshop:fenrir:action:Fen' => __('cash_shop_fenrir'),
        'cashshop:eventticket:action:Tic' => __('cash_shop_eventticket'),
        'cashshop:orther:action:Ocas' => __('cash_shop_orther'),
//        'cashshop:tft:action:Crw' => __('cash_shop_tft'),
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
        if (testRoleAdmin($acl_module) && function_exists("cashshop_$action")) {
            cn_bc_menu($_t, cn_url_modify(array('reset'), 'mod=' . $dl, 'do=' . $action, 'opt=' . $do), $do);
        }
    }

    foreach ($dashboard as $id => $_t) {
        list($dl, $do, $action, $acl_module) = explode(':', $id);

        if (testRoleAdmin($acl_module) && $dl == $mod && $do == $opt && function_exists("cashshop_$action")) {
            cn_bc_add($_t, cn_url_modify(array('reset'), 'mod=' . $mod, 'do=' . $action, 'opt=' . $do));
            die(call_user_func("cashshop_$action"));
        }
    }

    echo_header_admin('-@skins/mu_style.css', "Cash Shop");

    $images = array(
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

        if (!testRoleAdmin($acl)) {
            unset($dashboard[$id]);
            continue;
        }

        $item = array(
            'name' => $name,
            'img' => isset($images[$opt]) ? $images[$opt] : 'home.gif',
            'mod' => $mod,
            'opt' => $opt,
            'do' => $act,
        );

        $dashboard[$id] = $item;
    }

    cn_assign('dashboard', $dashboard);
    echo cn_execute_template('com_cashshop/general');
    echofooter();
}

// =====================================================================================================================

function cashshop_action()
{
    list($page, $per_page, $opt, $sub) = GET('page, per_page, opt, sub');
    list($_id, $mode) = GET('_id, mode');
    list($txt_name, $txt_price, $txt_code32, $txt_image) = GET('txt_name, txt_price, txt_code32, txt_image', "POST");

    $is_edit = $_id && $mode == 'e';
    $is_add = $mode == 'a';
    $is_delete = $_id && $mode == 'd';
    $is_cancel = $_id && $mode == 'c';

    $item_temp = $s_temp = $s_data = $set_data = array();
    $page = intval($page);
    if (!$txt_image) {
        $txt_image = '';
    }
    if (!$txt_name) {
        $txt_name = '';
    }
    if (!$txt_price) {
        $txt_price = '1000';
    }

    if (intval($per_page) == 0) {
        $per_page = 25;
    }
    $__data = getOption('#item_shop' . $opt);

    if (REQ('__item', 'GPG') == 'change-item') {
        foreach ($__data as $key => $raw) {
            $s_temp[] = $raw['code32'];
        }
        $s_data = cn_read_file($path = cn_path_construct(ROOT, 'core', 'cashshop') . 'shop_' . $opt . '.php');

        /// So sanh code item 32
        if (count($s_data)) {
            foreach ($s_data as $key => $var) {
                if (array_search(trim($var['code32']), $s_temp) !== false) {
                    unset($s_data[$key]);
                }
            }
            $__data = array_merge($s_data, $__data);

            setOption('#item_shop' . $opt, $__data);
            cn_throw_message('Add Code Item successfully');
        }
    } elseif (REQ('__item', 'GPG') == 'del-item') {
        unset($__data);
        setOption('#item_shop' . $opt, array());
        cn_throw_message('Delete all Code Item successfully');
    }

    if (request_type('POST')) {
        cn_dsi_check();

        $is_duble = false;
        $message = false;

        if (!empty($txt_code32)) {
            if ($is_add) {
                // Check category dubles
                if (!empty($__data)) {
                    foreach ($__data as $key => $value) {
                        $is_duble = $value['code32'] == $txt_code32;
                        if ($is_duble) {
                            break;
                        }
                    }
                }

                if (!$is_duble) {
                    $item_add['#'] = ctime();
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
                $__data[$_id]['code32'] = $txt_code32;
                $__data[$_id]['name'] = $txt_name;
                $__data[$_id]['price'] = $txt_price;
                $__data[$_id]['image_mh'] = $txt_image;

                cn_throw_message($message);
            }

            if (!$is_cancel) {
                setOption('#item_shop' . $opt, $__data);
            }
            $txt_image = $txt_name = $txt_price = $txt_code32 = $_id = '';
        } elseif (!$is_delete) {
            cn_throw_message('Empty Code Item', 'e');
        }
    }

    if (isset($__data)) {
        foreach ($__data as $key => $raw) {
            $set_data[$key] = cn_analysis_code32($raw['code32'], $raw['name'], $raw['price'], $raw['image_mh']);
        }
    }

    $items_data = getOption('#items_data');
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
        setOption('#items_data', array_merge($items_data, $item_temp));
    }

    list($item_read, $get_paging) = cn_render_pagination($set_data, cn_url_modify(array('reset'), 'mod=cashshop', 'do=action', "opt=$opt", '__item', '_id'), $page, $per_page);

    if ($_id) {
        $txt_name = $__data[$_id]['name'];
        $txt_price = $__data[$_id]['price'];
        $txt_code32 = $__data[$_id]['code32'];
        $txt_image = $__data[$_id]['image_mh'];
    }

    $bc_title = getMemcache('.menu');

    cn_assign('item_read, per_page, pagination, opt, sub', $item_read, $per_page, $get_paging, $opt, $sub);
    cn_assign('_id, _txt_name, _txt_price, _txt_code32, _txt_image', $_id, $txt_name, $txt_price, $txt_code32, $txt_image);

    echo_header_admin('-@skins/mu_style.css', "Configurations - " . $bc_title[$opt]['name']);
    echo cn_execute_template('com_cashshop/_armor');
    echofooter();
}
