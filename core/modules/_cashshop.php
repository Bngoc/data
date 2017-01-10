<?php if (!defined('BQN_MU')) die('Access restricted');

add_hook('index/invoke_module', '*cshop_invoke');

//=====================================================================================================================
function cshop_invoke()
{
    $cshop_board = array
    (
        'cash_shop:acient:__buy_s1:Csc' => 'Set thần',
        'cash_shop:armor:__buy_s1:Cp' => 'Giáp trụ',
        'cash_shop:spears:__buy_s1:Ciw' => 'Thương - Giáo',
        'cash_shop:shields:__buy_s1:Cg' => 'Khiên',
        'cash_shop:crossbows:__buy_s1:Cb' => 'Cung - nỏ',
        'cash_shop:weapons:__buy_s1:Com' => 'Dao - kiếm',
        'cash_shop:scepters:__buy_s1:Com' => 'Quyền trượng',
        'cash_shop:staffs:__buy_s1:Ca' => 'Gậy',
        'cash_shop:wings:__buy_s1:Ct' => 'Cánh',
        'cash_shop:ringpendants:__buy_s1:Cc' => 'Trang sức',
        'cash_shop:fenrir:__buy_s1:Cmm' => 'Linh hồn sói tinh',
        'cash_shop:eventticket:__buy_s1:Cum' => 'Vé sự kiện',
        'cash_shop:orther:__buy_s1:Cbi' => 'Các loại khác',
        'cash_shop:warehouse:__what_:Cbi' => 'Thùng đồ',
    );

    // Call dashboard extend
    $cshop_board = hook('cshop_board', $cshop_board);

    // Exec
    $mod = REQ('mod', 'GETPOST');
    $opt = REQ('opt', 'GETPOST');
    $token = REQ('token', 'GETPOST');

    cn_bc_add('Cash shop', cn_url_modify(array('reset'), 'mod=' . $mod));

    foreach ($cshop_board as $id => $_t) {
        list($dl, $do, $_token, $acl_module) = explode(':', $id);
        if (function_exists("shop_$_token"))
            cn_bc_menu($_t, cn_url_modify(array('reset'), 'mod=' . $dl, 'token=' . md5($_token . $do), 'opt=' . $do), $do);
    }
    //$token == $_token = md5($_token.$do)
    // Request module
    foreach ($cshop_board as $id => $_t) {
        list($dl, $do, $token_, $acl_module) = explode(':', $id);
        $_token = md5($token_ . $do);

        if ($dl == $mod && $do == $opt && $token == $_token && function_exists("shop_$token_")) {
            cn_bc_add($_t, cn_url_modify(array('reset'), 'mod=' . $mod, 'token=' . $_token, 'opt=' . $opt));
            die(call_user_func("shop_$token_"));
        }
        //else{
        if ($dl == $mod && $do == $opt && $token == $_token && !function_exists("shop_$token_")) {
            cn_bc_add('Lỗi dữ liệu', cn_url_modify(array('reset'), 'mod=' . $mod, 'token=' . $_token, 'opt=' . $opt));
            die(call_user_func("shop_default"));
        }
    }

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

    foreach ($cshop_board as $id => $name) {
        list($mod, $opt, $token, $acl) = explode(':', $id, 4);

        //if (!test($acl)){
        // unset($cshop_board[$id]);
        //continue;
        //}

        $item = array(
            'name' => $name,
            'img' => isset($images[$opt]) ? $images[$opt] : 'home.gif',
            'mod' => $mod,
            'opt' => $opt,
            'token' => md5($token . $opt),
        );

        $cshop_board[$id] = $item;
    }

    cn_assign('dashboard', $cshop_board);
    echoheader('-@my_cashshop/style.css', "Character");
    echocomtent_here(exec_tpl('my_cashshop/general'), cn_snippet_bc_re());
    echofooter();
}

function shop_default()
{
    $arr_shop = mcache_get('.breadcrumbs');
    $name__ = array_pop($arr_shop)['name'];
    echoheader('-@defaults/style.css', "Error - $name__");
    echocomtent_here(exec_tpl('defaults/default'), cn_snippet_bc_re());
    echofooter();
}

function shop___buy_s1()
{
    list($page, $per_page, $token, $opt, $sub) = GET('page, per_page, token, opt, sub', 'GPG');

    $page = intval($page);
    if (!$page) $page = 0;
    if (intval($per_page) == 0) $per_page = 12;
    if ($opt == 'eventticket' || $opt == 'orther') $per_page = 21;

    $list_item = array();
    $item_ = getoption('#item_shop' . $opt);    //'code32' - 'name'  - 'price' - 'image_mh'

    if ($item_)
        foreach ($item_ as $key => $var) {
            $list_item[$key] = cn_analysis_code32($var['code32'], $var['name'], $var['price'], $var['image_mh']);
        }
    $member = member_get();
    $accc_ = $member['user_name'];

    $warehouse_ = do_select_character('warehouse', $arr_cls = 'Items', "AccountID='$accc_'");
    $warehouse = substr(strtoupper(bin2hex($warehouse_[0]['Items'])), 0, 3840);

    /// kiem tra khi character open warehouse => ???????????
    //if (request_type('POST')) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if ($token == md5('__buy_s1' . $opt) && $id_item = REQ('item')) {
            cn_dsi_check(true);

            $errors_false = false;

            if (!in_array($id_item, array_keys($list_item))) {
                cn_throw_message("Trên Server không có Item bạn muốn mua. Chi tiết vui lòng liên hệ BQT để cập nhập.", 'e');
                $errors_false = true;
            } else {
                $price_ = $list_item[$id_item]['price'];
                $name_ = $list_item[$id_item]['title'];

                $_blank_var = view_bank($accc_);
                $vp_ = $_blank_var[0]['vp'];

                if (0 > $check = $vp_ - $price_) {
                    cn_throw_message("Bạn đang có $vp_ Vpoint. $name_ giá " . number_format($price_, 0, ",", ".") . " Vpoint. Bạn còn thiếu " . number_format((abs($check)), 0, ",", ".") . " Vpoint", 'e');
                    $errors_false = true;
                } else {
                    $items_data = getoption('#items_data');
                    $item_code = $list_item[$id_item]['code32'];

                    if ($opt == "armor") {
                        for ($i = 7; $i <= 11; $i++) {
                            $serial = do_select_orther('EXEC WZ_GetItemSerial');

                            $str_replace_begin = 6 + (8 - strlen($serial_n = $serial[0]['']));
                            $item_code = substr_replace($item_code, $serial_n, $str_replace_begin, -18);
                            $item_code = substr_replace($item_code, dechex($i * 16), 18, 2);
                            $leng_item_code = strlen($item_code);
                            $item_data = cn_getCodeItem($item_code);
                            if (($item_data['id'] == 15 || $item_data['id'] == 20 || $item_data['id'] == 23 || $item_data['id'] == 32 || $item_data['id'] == 37 || $item_data['id'] == 47 || $item_data['id'] == 48) && ($i == 7)) {
                                continue;
                            } else {
                                if (!isset($items_data[$item_data['group'] . "." . $item_data['id']])) {
                                    cn_throw_message("Vật phẩm này không có trong danh sách giao bán.", 'e');
                                    $errors_false = true;
                                    break;
                                } else {
                                    $items = $items_data[$item_data['group'] . "." . $item_data['id']];
                                    $slot = cn_CheckSlotWarehouse($warehouse, $items['X'], $items['Y']);

                                    if ($slot == 3840) {
                                        cn_throw_message("Không đủ chỗ trống trong Hòm đồ", 'e');
                                        $errors_false = true;
                                        break;
                                    } else {
                                        $warehouse = substr_replace($warehouse, $item_code, $slot * 32, $leng_item_code);
                                    }
                                }
                            }
                        }
                    } else {
                        $serial = do_select_orther('EXEC WZ_GetItemSerial');
                        $str_replace_begin = 6 + (8 - strlen($serial_n = $serial[0]['']));
                        $item_code = substr_replace($item_code, $serial_n, $str_replace_begin, -18);
                        $leng_item_code = strlen($item_code);
                        $item_data = cn_getCodeItem($item_code);

                        if (!isset($items_data[$item_data['group'] . "." . $item_data['id']])) {
                            cn_throw_message("Vật phẩm này không có trong danh sách giao bán.", 'e');
                            $errors_false = true;
                        } else {
                            $items = $items_data[$item_data['group'] . "." . $item_data['id']];
                            $slot = cn_CheckSlotWarehouse($warehouse, $items['X'], $items['Y']);
                            if ($slot == 3840) {
                                cn_throw_message("Không đủ chỗ trống trong Hòm đồ", 'e');
                                $errors_false = true;
                            } else {
                                $warehouse = substr_replace($warehouse, $item_code, $slot * 32, $leng_item_code);
                            }
                        }
                    }
                }
            }

            if (!$errors_false) {
                $new_warehouse = $warehouse;
                do_update_character('warehouse', "[Items]=0x$new_warehouse", "AccountID:'$accc_'");
                do_update_character('MEMB_INFO', "vpoint=$check", "memb___id:'$accc_'");

                //Ghi vào Log
                $content = "$accc_ đã mua $name_ (Serial: $serial_n) giá " . number_format($price_, 0, ",", ".") . " V.Point";
                $Date = date("h:iA, d/m/Y", ctime());
                $file = MODULE_ADM . "/log/modules/shop/log_" . $opt . ".log";
                $fileContents = file_get_contents($file);
                file_put_contents($file, $accc_ . "|" . $content . "|" . $_blank_var[0]['gc'] . "_" . $vp_ . "|" . $_blank_var[0]['gc'] . "_" . $check . "|" . $Date . "|\n" . $fileContents);
                //End Ghi vào Log

                cn_throw_message("Bạn đã mua thành công $name_ với giá " . number_format($price_, 0, ",", ".") . " V.Point.");
            }

            $resultData = array(
                'msgAction' => cn_snippet_messages(),
                'menuTop' => cn_menuTopMoney(true)
            );

            header('Content-Type: application/json');
            return json_encode($resultData);
        }
    }
    $arr_shop = mcache_get('.breadcrumbs');
    $name_shop = array_pop($arr_shop)['name'];


    list($list_itemNew, $echoPagination) = cn_arr_pagina($list_item, cn_url_modify(array('reset'), 'mod=cash_shop', "token=$token", "opt=$opt", 'page', "per_page=$per_page"), $page, $per_page);

    cn_assign('list_item, token, opt', $list_itemNew, $token, $opt);
    cn_assign('per_page, echoPagination', $per_page, $echoPagination);

    echoheader('-@my_cashshop/style.css@my_cashshop/customAjaxShop.js', "Cửa hàng $name_shop - $name_shop");
    echocomtent_here(exec_tpl('my_cashshop/_general'), cn_snippet_bc_re());
    echofooter();
}

function shop___what_()
{
    $member = member_get();
    $accc_ = $member['user_name'];
    $warehouse_ = do_select_character('warehouse', 'Items,Money,pw,AccountID', "AccountID='$accc_'");

    $item_list = substr(strtoupper(bin2hex($warehouse_[0]['Items'])), 0, 3840);
    $money = $warehouse_[0]['Money'];
    $password = $warehouse_[0]['pw'];

    $lenghtWarehouse = strlen($item_list);
    $ListItemInfo = array();
    for ($jk = 0; $jk < $lenghtWarehouse; $jk += 32) {
        $strItem = substr($item_list, $jk, 32);
        $ListItemInfo[] = cn_analysis_code32($strItem, '', '', '');
    }

    $x = -1;
    $show_warehouse = "<div id='warehouse' style='width:282px; margin:0px auto; padding-top:57px; padding-left:25px; height:628px; background-image: url(/images/warehouse.jpg)'>";

    if ($ListItemInfo) {
        foreach ($ListItemInfo as $i => $item32) {
            ++$x;
            if ($x == 8) $x = 0;
            if (isset($item32['name'])) {
                if (!$item32['y']) $itemy = 1;
                else $itemy = $item32['y'];

                if (!$item32['x']) $itemx = 1;
                else $itemx = $item32['x'];

                $show_warehouse .= "<div style='margin-top:" . (floor($i / 8) * 32) . "px;
											margin-left:" . ($x * 32) . "px; position:absolute;
											width:" . ($itemx * 32) . "px; height:" . ($itemy * 32) . "px;
											cursor:pointer; background-image: url(images/wh_bg_on.jpg);'>";

                if (file_exists(ROOT. '/images/items/' . $item32['image'] . '.gif')) {
                    $show_warehouse .= "<img src='images/items/" . $item32['image'] . ".gif'
											style='height:" . (32 * $itemy - $itemy - 1) . "px;
											 width:" . (32 * $itemx) . "px;'";

                    $show_warehouse .= ' onMouseOut="UnTip()" onMouseOver="topxTip(document.getElementById(\'iditem' . $i . '\').innerHTML)" /></div>';
                    $show_warehouse .= "<div class='floatcontainer forumbit_nopost' id='iditem$i' style='display:none; background: rgba(0, 128, 0, 0.15);'>" . $item32['info'] . "</div>";
                } else {
                    $show_warehouse .= "<img src='images/items/SinFoto.gif'
											style='height:" . (32 * $itemy - $itemy - 1) . "px;
											 width:" . (32 * $itemx) . "px;' /></div>";
                }
            }
        }
    }

    if ($password != NULL AND $password != 0) $wwname = "<font color='#A42725'>Hòm đồ (Đóng)</font>";
    else $wwname = "<font color='#ffffff'>Hòm đồ (Mở)</font>";
    if ($money < 100000) $color = "#F7DDAA";
    else if ($money >= 100000 and $money < 1000000) $color = "#3CA445";
    else if ($money >= 1000000 and $money < 10000000) $color = "#D2A154";
    else $color = "#A42725";

    $show_warehouse .= "<div style='margin-top:-42px; position:absolute; text-align:center; width:256px; border:0px;'>" . $wwname . "</div>";
    $show_warehouse .= "<div id='zzen2' style='margin-top:100px; margin-left:-20px; position:absolute; border:0px; width:0px; height:0px;'></div>";
    $show_warehouse .= "<div align=right style='position:absolute; color:" . $color . "; margin-top:502px; width:200px; margin-right:37px; margin-left:50px; border:0px;'>" . number_format($money, 0, ',', '.') . "</div>";
    $show_warehouse .= "<div style='margin-top:565px; margin-left:36px; position:absolute; width:57px; height:47px;'><img src='images/insert_zen.jpg'></div>";
    $show_warehouse .= "<div style='margin-top:565px; margin-left:100px; position:absolute; width:59px; height:47px;'><img src='images/get_zen.jpg'></div>";

    if ($password != NULL AND $password != 0) {
        $imgl = "images/lock_on.jpg";
    } else {
        $imgl = "images/lock_off.jpg";
    }
    $show_warehouse .= "<div style='margin-top:565px; margin-left:166px; position:absolute; width:57px; height:47px;'><img src='" . $imgl . "'></div>";
    $show_warehouse .= "</div>";

    cn_assign('show_warehouse', $show_warehouse);

    echoheader('-@my_cashshop/style.css', "Thùng đồ - Warehouse");
    echocomtent_here(exec_tpl('my_cashshop/_warehouse'), cn_snippet_bc_re());
    echofooter();
}