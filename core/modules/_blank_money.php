<?php if (!defined('BQN_MU')) {
    die('Access restricted');
}

add_hook('index/invoke_module', '*blank_money_invoke');

//=====================================================================================================================
function blank_money_invoke()
{
    $blank_money_board = array(
        'blank_money:chaos2blank:Csc' => 'Chaos &rsaquo;&rsaquo;&rsaquo; Bank',
        'blank_money:blank2chaos:Csc' => 'Chaos &lsaquo;&lsaquo;&lsaquo; Bank',
        'blank_money:cre2blank:Cp' => 'Cre &rsaquo;&rsaquo;&rsaquo; Bank',
        'blank_money:blank2cre:Cp' => 'Cre &lsaquo;&lsaquo;&lsaquo; blank',
        'blank_money:feather2blank:Cp' => 'Lông vũ &rsaquo;&rsaquo;&rsaquo; Bank',
        'blank_money:blank2feather:Cp' => 'Lông vũ &lsaquo;&lsaquo;&lsaquo; blank',
        'blank_money:blue2blank:Cp' => 'Bule &rsaquo;&rsaquo;&rsaquo; Bank',
        'blank_money:blank2bule:Cp' => 'Bule &lsaquo;&lsaquo;&lsaquo; blank',
        'blank_money:zen2blank:Cp' => 'Zen &rsaquo;&rsaquo;&rsaquo; Bank',
        'blank_money:blank2zen:Ct' => 'Zen &lsaquo;&lsaquo;&lsaquo; blank',
        'blank_money:vpoint2blank:Cp' => 'Vpoint &rsaquo;&rsaquo;&rsaquo; Bank',
        'blank_money:blank2vpoint:Cp' => 'Vpoint &lsaquo;&lsaquo;&lsaquo; Bank',
        //----------------------------------------------------------
        'blank_money:transvpoint:Cp' => 'Chuyển Vpoint',
        'blank_money:muazen:Cp' => 'Mua Zen bằng Vpoint',
        'blank_money:vpoint2gcoin:Cp' => 'Vpoint &rsaquo;&rsaquo;&rsaquo; Gcoin',
        'blank_money:gcoin2vpoint:Cp' => 'Gcoin &rsaquo;&rsaquo;&rsaquo; Vpoint',
        'blank_money:transgc2wc:Cp' => 'Gcoin &rsaquo;&rsaquo;&rsaquo; Wcoin',
        'blank_money:transgc2wcp:Cp' => 'Gcoin &rsaquo;&rsaquo;&rsaquo; WcoinP',
        'blank_money:transgc2gob:Cp' => 'Gcoin &rsaquo;&rsaquo;&rsaquo; GoblinCoin',
    );

    // Call dashboard extend
    $blank_money_board = hook('extend_dashboard', $blank_money_board);

    // Exec
    $mod = REQ('mod', 'GETPOST');
    $opt = REQ('opt', 'GETPOST');

    // Top level (dashboard)
    cn_bc_add('Ngân hàng - Tiền tệ', cn_url_modify(array('reset'), 'mod=' . $mod));

    foreach ($blank_money_board as $id => $_t) {
        list($dl, $do, $acl_module) = explode(':', $id);
        if (function_exists("blank_money_$do")) {
            cn_bc_menu($_t, cn_url_modify(array('reset'), 'mod=' . $dl, 'opt=' . $do), $do);
        }
    }

    // Request module
    foreach ($blank_money_board as $id => $_t) {
        list($dl, $do, $acl_module) = explode(':', $id);

        //if (testRoleWeb($acl_module) && $dl == $mod && $do == $opt && function_exists("blank_money_$opt")) {
        if ($dl == $mod && $do == $opt && function_exists("blank_money_$opt")) {
            cn_bc_add($_t, cn_url_modify(array('reset'), 'mod=' . $mod, 'opt=' . $opt));
            die(call_user_func("blank_money_$opt"));
        }

        if ($dl == $mod && $do == $opt && !function_exists("blank_money_$opt")) {
            cn_bc_add('Lỗi dữ liệu', cn_url_modify(array('reset'), 'mod=' . $mod, 'opt=' . $opt));
            die(call_user_func("blank_money_default"));
        }
    }

    $images = array(
        'chaos2blank' => 'chaos2blank.png',
        'blank2chaos' => 'blank2chaos.png',
        'cre2blank' => 'cre2blank.png',
        'blank2cre' => 'blank2cre.png',
        'feather2blank' => 'feather2blank.png',
        'blank2feather' => 'blank2feather.png',
        'blue2blank' => 'blue2blank.png',
        'blank2bule' => 'blank2bule.png',
        'zen2blank' => 'zen2blank.png',
        'blank2zen' => 'blank2zen.png',
        'vpoint2blank' => 'vpoint2blank.png',
        'blank2vpoint' => 'blank2vpoint.png',
        //----------------------------------
        'vpoint2gcoin' => 'vpoint2gcoin.png',
        'gcoin2vpoint' => 'gcoin2vpoint.png',
        'transvpoint' => 'transvpoint.png',
        'transgc2wc' => 'transgc2wc.png',
        'transgc2wcp' => 'transgc2wcp.png',
        'transgc2gob' => 'transgc2gob.png',
        'muazen' => 'muazen.png'

    );

    // More dashboard images
    $images = hook('extend_dashboard_images', $images);

    foreach ($blank_money_board as $id => $name) {
        list($mod, $opt, $acl) = explode(':', $id, 3);

        //if (!testRoleWeb($acl)) {
        // unset($blank_money_board[$id]);
        //continue;
        //}

        $item = array(
            'name' => $name,
            'img' => isset($images[$opt]) ? $images[$opt] : 'home.gif',
            'mod' => $mod,
            'opt' => $opt,
        );

        $blank_money_board[$id] = $item;
    }

    cn_assign('dashboard', $blank_money_board);
    echo_header_web('-@my_blank_money/style.css', "Ngân hàng - Tiền tệ");
    echo_content_here(exec_tpl('my_blank_money/general'), cn_snippet_bc_re());
    echo_footer_web();
}

function blank_money_default()
{
    $arr_shop = getMemcache('.breadcrumbs');
    $name__ = array_pop($arr_shop)['name'];
    echo_header_web('defaults/style.css', "Error - $name__");
    echo_content_here(exec_tpl('defaults/default'), cn_snippet_bc_re());
    echo_footer_web();
}

function show_inventory($inventory, $moneyInventory = '')
{
    $show_inventory = "<div id='warehouse' style='width:282px; margin:0px auto; padding-top:15px; padding-left:25px; height:305px; background-image: url(/public/images/inventoryPer.jpg)'>";
    $show_moneyInventory = "<div class=\"moneyInventory\" align=right style=''>" . number_format($moneyInventory, 0, ',', '.') . "</div>";

    if (empty($inventory)) {
        return $show_inventory . $show_moneyInventory . '</div>';
    }

    if ($inventory) {
        $lenghtInventoryDel = strlen($inventory);
        $itemInfo = array();
        for ($jk = 0; $jk < $lenghtInventoryDel; $jk += 32) {
            $strItem = substr($inventory, $jk, 32);
            $itemInfo[] = cn_analysis_code32($strItem, '', '', '');
        }
    }

    $x = -1;
    if ($itemInfo) {
        foreach ($itemInfo as $i => $item32) {
            //Set item exist
            setMemcache('#existItem', 1);

            ++$x;
            if ($x == 8) {
                $x = 0;
            }
            if (isset($item32['name'])) {
                if (!$item32['y']) {
                    $itemy = 1;
                } else {
                    $itemy = $item32['y'];
                }

                if (!$item32['x']) {
                    $itemx = 1;
                } else {
                    $itemx = $item32['x'];
                }

                $show_inventory .= "<div style='margin-top:" . ((floor($i / 8) * 32)) . "px; margin-left:" . ($x * 32) . "px; position:absolute; width:" . ($itemx * 32) . "px; height:" . ($itemy * 32) . "px; cursor:pointer; background-image: url(/public/images/wh_bg_on.jpg);'>";

                $pathImg = ROOT . 'public/images/web/items/' . $item32['image'] . '.gif';

                if (file_exists($pathImg)) {
                    $show_inventory .= "<img src='/public/images/web/items/" . $item32['image'] . ".gif'
											style='height:" . (32 * $itemy - $itemy - 1) . "px;
											 width:" . (32 * $itemx) . "px;'";

                    $show_inventory .= ' onMouseOut="UnTip()" onMouseOver="topxTip(document.getElementById(\'iditem' . $i . '\').innerHTML)" /></div>';
                    $show_inventory .= "<div class='floatcontainer forumbit_nopost' id='iditem$i' style='display:none; background: rgba(0, 128, 0, 0.15);'>" . $item32['info'] . "</div>";
                } else {
                    $show_inventory .= "<img src='/public/images/web/items/SinFoto.gif'
											style='height:" . (32 * $itemy - $itemy - 1) . "px;
											 width:" . (32 * $itemx) . "px;' /></div>";
                }
            }
        }
    }
    $show_inventory .= $show_moneyInventory . "</div>";

    return $show_inventory;
}

function countItemZederInventory($arrTemp, $inventory2)
{
    if (empty($inventory2)) {
        return array(0, $inventory2);
    }

    $countItem = 0;
    $inventory2After = '';
    for ($i = 0; $i < 64; $i++) {
        $item = substr($inventory2, $i * 32, 32);
        $checkCode = substr($item, 0, 4);
        $checkCode2 = substr($item, 18, 1);

        if (isset($arrTemp[$checkCode])) {
            if ($checkCode2 == $arrTemp[$checkCode][0]) {
                $countItem += $arrTemp[$checkCode][1];
                $inventory2After .= 'FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF';

                continue;
            }
        }
        $inventory2After .= $item;
    }
    return array($countItem, $inventory2After);
}

function blank_money_chaos2blank()
{
    $option = 'chaos';
    $showchar = cn_character();

    list($sub) = GET('sub', 'GPG');
    if (!$sub) {
        $sub = array_keys($showchar)[0];
    } else {
        if (!in_array($sub, array_keys($showchar))) {
            $sub = array_keys($showchar)[0];
        }
    }

    $moneyInventory = $showchar[$sub]['money'];
    $inventory = strtoupper(bin2hex($showchar[$sub]['shop_inventory']));
    $inventory1 = substr($inventory, 0, 12 * 32);
    $inventory2 = substr($inventory, 12 * 32, 64 * 32);
    $inventory3 = substr($inventory, 76 * 32);

    $chaoItem = array(
        '0F00' => ['C', 1],
        '8D00' => ['C', 10],
        '8D08' => ['C', 20],
        '8D10' => ['C', 30]
    );

    list($countChaos, $inventory2After) = countItemZederInventory($chaoItem, $inventory2);

    if (request_type('POST')) {
        if (REQ('action_sendJewelBlank')) {
            cn_dsi_check(true);
            $errors_false = false;

            if (empty($countChaos) || $countChaos < 0) {
                cn_throw_message('Thùng đồ cá nhân ' . $sub . ' không có vật phẩm chaos.', 'e');
                $errors_false = true;
            }

            list($verifyCaptcha) = GET('verifyCaptcha', 'GPG');
            if ($verifyCaptcha != $_SESSION['captcha_web']) {
                cn_throw_message("Captcah không đúng.", 'e');
                $errors_false = true;
            }

            if (!$errors_false) {
                $newInventory = $inventory1 . $inventory2After . $inventory3;
                $acountID = $_SESSION['user_Gamer'];

                do_update_orther("UPDATE Character SET Inventory=0x$newInventory WHERE Name='$sub'");
                do_update_orther("UPDATE MEMB_INFO SET jewel_chao=jewel_chao+$countChaos WHERE memb___id='$acountID'");

                cn_throw_message("Bạn đã thêm Sl: " . number_format($countChaos, 0, ",", ".") . " Chaos vào ngân hàng thành công!");
            }

            $resultData = array(
                'msgAction' => cn_snippet_messages(),
                'menuTop' => cn_menuTopMoney(true),
                'countItem' => '<strong> ' . number_format((!$errors_false ? 0 : $countChaos), 0, ',', '.') . ' </strong> Chaos',
                'result' => show_inventory(((!$errors_false) ? $inventory2After : $inventory2), $moneyInventory)
            );

            header('Content-Type: application/json');
            return json_encode($resultData);
        }
    }

    $strCountItem = '<strong>' . number_format($countChaos, 0, ',', '.') . ' </strong> Chaos';

    cn_assign('sub, showchar, show_inventory, countItem, option', $sub, $showchar, show_inventory($inventory2, $moneyInventory), $strCountItem, $option);
    echo_header_web('-@my_blank_money/style.css@my_blank_money/sendAjaxJewel.js', "Ngân hàng | Tiền tệ - Gửi chaos vào ngân hàng");
    echo_content_here(exec_tpl('my_blank_money/jewelToBlank'), cn_snippet_bc_re());
    echo_footer_web();
}

function blank_money_cre2blank()
{
    $option = 'Cre';
    $showchar = cn_character();

    list($sub) = GET('sub', 'GPG');
    if (!$sub) {
        $sub = array_keys($showchar)[0];
    } else {
        if (!in_array($sub, array_keys($showchar))) {
            $sub = array_keys($showchar)[0];
        }
    };

    $moneyInventory = $showchar[$sub]['money'];
    $inventory = strtoupper(bin2hex($showchar[$sub]['shop_inventory']));
    $inventory1 = substr($inventory, 0, 12 * 32);
    $inventory2 = substr($inventory, 12 * 32, 64 * 32);
    $inventory3 = substr($inventory, 76 * 32);

    $creItem = array(
        '1600' => ['E', 1],
        '8900' => ['C', 10],
        '8908' => ['C', 20],
        '8910' => ['C', 30]
    );

    list($countCre, $inventory2After) = countItemZederInventory($creItem, $inventory2);

    if (request_type('POST')) {
        if (REQ('action_sendJewelBlank')) {
            cn_dsi_check(true);
            $errors_false = false;

            if (empty($countCre) || $countCre < 0) {
                cn_throw_message('Thùng đồ cá nhân ' . $sub . ' không có vật phẩm Cre.', 'e');
                $errors_false = true;
            }

            list($verifyCaptcha) = GET('verifyCaptcha', 'GPG');
            if ($verifyCaptcha != $_SESSION['captcha_web']) {
                cn_throw_message("Captcah không đúng.", 'e');
                $errors_false = true;
            }

            if (!$errors_false) {
                //unset($_SESSION['captcha_web']);
                $newInventory = $inventory1 . $inventory2After . $inventory3;
                $acountID = $_SESSION['user_Gamer'];

                do_update_orther("UPDATE Character SET Inventory=0x$newInventory WHERE Name='$sub'");
                do_update_orther("UPDATE MEMB_INFO SET jewel_cre=jewel_cre+$countCre WHERE memb___id='$acountID'");

                cn_throw_message("Bạn đã thêm Sl: " . number_format($countCre, 0, ",", ".") . " Cre vào ngân hàng thành công!");
            }

            $resultData = array(
                'msgAction' => cn_snippet_messages(),
                'menuTop' => cn_menuTopMoney(true),
                'countItem' => '<strong> ' . number_format((!$errors_false ? 0 : $countCre), 0, ',', '.') . ' </strong> Cre',
                'result' => show_inventory(((!$errors_false) ? $inventory2After : $inventory2), $moneyInventory)
            );

            header('Content-Type: application/json');
            return json_encode($resultData);
        }
    }

    $strCountItem = '<strong>' . number_format($countCre, 0, ',', '.') . ' </strong> Cre';

    cn_assign('sub, showchar, show_inventory, countItem, option', $sub, $showchar, show_inventory($inventory2, $moneyInventory), $strCountItem, $option);
    echo_header_web('-@my_blank_money/style.css@my_blank_money/sendAjaxJewel.js', "Ngân hàng | Tiền tệ - Gửi Cre vào ngân hàng");
    echo_content_here(exec_tpl('my_blank_money/jewelToBlank'), cn_snippet_bc_re());
    echo_footer_web();
}

function blank_money_blue2blank()
{
    $option = 'Bule';
    $showchar = cn_character();

    list($sub) = GET('sub', 'GPG');
    if (!$sub) {
        $sub = array_keys($showchar)[0];
    } else {
        if (!in_array($sub, array_keys($showchar))) {
            $sub = array_keys($showchar)[0];
        }
    };

    $moneyInventory = $showchar[$sub]['money'];
    $inventory = strtoupper(bin2hex($showchar[$sub]['shop_inventory']));
    $inventory1 = substr($inventory, 0, 12 * 32);
    $inventory2 = substr($inventory, 12 * 32, 64 * 32);
    $inventory3 = substr($inventory, 76 * 32);

    $blueItem = array(
        '0D00' => ['E', 1],
        '1E00' => ['C', 10],
        '1E08' => ['C', 20],
        '1E10' => ['C', 30]
    );

    list($countBlue, $inventory2After) = countItemZederInventory($blueItem, $inventory2);

    if (request_type('POST')) {
        if (REQ('action_sendJewelBlank')) {
            cn_dsi_check(true);
            $errors_false = false;

            if (empty($countBlue) || $countBlue < 0) {
                cn_throw_message('Thùng đồ cá nhân ' . $sub . ' không có vật phẩm Blue.', 'e');
                $errors_false = true;
            }

            list($verifyCaptcha) = GET('verifyCaptcha', 'GPG');
            if ($verifyCaptcha != $_SESSION['captcha_web']) {
                cn_throw_message("Captcah không đúng.", 'e');
                $errors_false = true;
            }

            if (!$errors_false) {
                $newInventory = $inventory1 . $inventory2After . $inventory3;
                $acountID = $_SESSION['user_Gamer'];

                do_update_orther("UPDATE Character SET Inventory=0x$newInventory WHERE Name='$sub'");
                do_update_orther("UPDATE MEMB_INFO SET jewel_blue=jewel_blue+$countBlue WHERE memb___id='$acountID'");

                cn_throw_message("Bạn đã thêm Sl: " . number_format($countBlue, 0, ",", ".") . " Blue vào ngân hàng thành công!");
            }

            $resultData = array(
                'msgAction' => cn_snippet_messages(),
                'menuTop' => cn_menuTopMoney(true),
                'countItem' => '<strong> ' . number_format((!$errors_false ? 0 : $countBlue), 0, ',', '.') . ' </strong> Blue',
                'result' => show_inventory(((!$errors_false) ? $inventory2After : $inventory2), $moneyInventory)
            );

            header('Content-Type: application/json');
            return json_encode($resultData);
        }
    }

    $strCountItem = '<strong>' . number_format($countBlue, 0, ',', '.') . ' </strong> Blue';

    cn_assign('sub, showchar, show_inventory, countItem, option', $sub, $showchar, show_inventory($inventory2, $moneyInventory), $strCountItem, $option);
    echo_header_web('-@my_blank_money/style.css@my_blank_money/sendAjaxJewel.js', "Ngân hàng | Tiền tệ - Gửi Blue vào ngân hàng");
    echo_content_here(exec_tpl('my_blank_money/jewelToBlank'), cn_snippet_bc_re());
    echo_footer_web();
}

function blank_money_feather2blank()
{
    $option = ' Lông vũ';
    $showchar = cn_character();

    list($sub) = GET('sub', 'GPG');
    if (!$sub) {
        $sub = array_keys($showchar)[0];
    } else {
        if (!in_array($sub, array_keys($showchar))) {
            $sub = array_keys($showchar)[0];
        }
    };

    $moneyInventory = $showchar[$sub]['money'];
    $inventory = strtoupper(bin2hex($showchar[$sub]['shop_inventory']));
    $inventory1 = substr($inventory, 0, 12 * 32);
    $inventory2 = substr($inventory, 12 * 32, 64 * 32);
    $inventory3 = substr($inventory, 76 * 32);

    $featherItem = array(
        '0E00' => ['D', 1]
    );

    list($countFeather, $inventory2After) = countItemZederInventory($featherItem, $inventory2);

    if (request_type('POST')) {
        if (REQ('action_sendJewelBlank')) {
            cn_dsi_check(true);
            $errors_false = false;

            if (empty($countFeather) || $countFeather < 0) {
                cn_throw_message('Thùng đồ cá nhân ' . $sub . ' không có vật phẩm Lông vũ.', 'e');
                $errors_false = true;
            }

            list($verifyCaptcha) = GET('verifyCaptcha', 'GPG');
            if ($verifyCaptcha != $_SESSION['captcha_web']) {
                cn_throw_message("Captcah không đúng.", 'e');
                $errors_false = true;
            }

            if (!$errors_false) {
                $newInventory = $inventory1 . $inventory2After . $inventory3;
                $acountID = $_SESSION['user_Gamer'];

                do_update_orther("UPDATE Character SET Inventory=0x$newInventory WHERE Name='$sub'");
                do_update_orther("UPDATE MEMB_INFO SET jewel_feather=jewel_feather+$countFeather WHERE memb___id='$acountID'");

                cn_throw_message("Bạn đã thêm Sl: " . number_format($countFeather, 0, ",", ".") . " Lông vũ vào ngân hàng thành công!");
            }

            $resultData = array(
                'msgAction' => cn_snippet_messages(),
                'menuTop' => cn_menuTopMoney(true),
                'countItem' => '<strong> ' . number_format((!$errors_false ? 0 : $countFeather), 0, ',', '.') . ' </strong> Lông vũ',
                'result' => show_inventory(((!$errors_false) ? $inventory2After : $inventory2), $moneyInventory)
            );

            header('Content-Type: application/json');
            return json_encode($resultData);
        }
    }

    $strCountItem = '<strong>' . number_format($countFeather, 0, ',', '.') . ' </strong> Lông vũ';

    cn_assign('sub, showchar, show_inventory, countItem, option', $sub, $showchar, show_inventory($inventory2, $moneyInventory), $strCountItem, $option);
    echo_header_web('-@my_blank_money/style.css@my_blank_money/sendAjaxJewel.js', "Ngân hàng | Tiền tệ - Gửi Lông vũ vào ngân hàng");
    echo_content_here(exec_tpl('my_blank_money/jewelToBlank'), cn_snippet_bc_re());
    echo_footer_web();
}

function blank_money_zen2blank()
{
    $maxBank = MAXBANKZEN;
    $option = ' Zen';
    $showchar = cn_character();
    $_blank_var = view_bank($accoutID = $_SESSION['user_Gamer']);

    list($sub) = GET('sub', 'GPG');
    if (!$sub) {
        $sub = array_keys($showchar)[0];
    } else {
        if (!in_array($sub, array_keys($showchar))) {
            $sub = array_keys($showchar)[0];
        }
    }

    $moneyBlank = $_blank_var[0]['bank'];
    $moneyInventory = $showchar[$sub]['money'];
    $inventory = strtoupper(bin2hex($showchar[$sub]['shop_inventory']));
    $inventory2 = substr($inventory, 12 * 32, 64 * 32);

    $totalSendBank = $moneyInventory + $moneyBlank;

    if (request_type('POST')) {
        if (REQ('action_sendJewelBlank')) {
            cn_dsi_check(true);
            $errors_false = false;

            if (empty($moneyInventory) || $moneyInventory < 0) {
                cn_throw_message('Thùng đồ cá nhân ' . $sub . ' không có có Zen.', 'e');
                $errors_false = true;
            }

            if ($totalSendBank > $maxBank) {
                cn_throw_message('Tài khoản ' . $accoutID . ' có thể chứa tối đa ' . number_format($maxBank, 0, ',', '.') . ' Zen.', 'e');
                $errors_false = true;
            }

            list($verifyCaptcha) = GET('verifyCaptcha', 'GPG');
            if ($verifyCaptcha != $_SESSION['captcha_web']) {
                cn_throw_message("Captcah không đúng.", 'e');
                $errors_false = true;
            }

            if (!$errors_false) {
                do_update_orther("UPDATE Character SET Money=0 WHERE Name='$sub'");
                do_update_orther("UPDATE MEMB_INFO SET bank=$totalSendBank WHERE memb___id='$accoutID'");

                cn_throw_message("Bạn đã thêm Sl: " . number_format($moneyInventory, 0, ",", ".") . " Zen vào ngân hàng thành công!");
            }

            $resultData = array(
                'msgAction' => cn_snippet_messages(),
                'menuTop' => cn_menuTopMoney(true),
                'countItem' => '',
                'result' => show_inventory($inventory2, ((!$errors_false) ? 0 : $moneyInventory))
            );

            header('Content-Type: application/json');
            return json_encode($resultData);
        }
    }

    $strCountItem = '';

    cn_assign('sub, showchar, show_inventory, countItem, option', $sub, $showchar, show_inventory($inventory2, $moneyInventory), $strCountItem, $option);
    echo_header_web('-@my_blank_money/style.css@my_blank_money/sendAjaxJewel.js', "Ngân hàng | Tiền tệ - Gửi Zen vào ngân hàng");
    echo_content_here(exec_tpl('my_blank_money/jewelToBlank'), cn_snippet_bc_re());
    echo_footer_web();
}

function blank_money_vpoint2blank()
{
    $option = ' Vpoint';
    $showchar = cn_character();
    $showBlank = view_bank($acountID = $_SESSION['user_Gamer']);

    list($sub) = GET('sub', 'GPG');
    if (!$sub) {
        $sub = array_keys($showchar)[0];
    } else {
        if (!in_array($sub, array_keys($showchar))) {
            $sub = array_keys($showchar)[0];
        }
    };

    $moneyInventory = $showchar[$sub]['money'];
    $inventory = strtoupper(bin2hex($showchar[$sub]['shop_inventory']));
    $inventory1 = substr($inventory, 0, 12 * 32);
    $inventory2 = substr($inventory, 12 * 32, 64 * 32);
    $inventory3 = substr($inventory, 76 * 32);

    $featherItem = array(
        '0C10' => ['E', 1],
        '0C00' => ['E', 10],
        '0F00' => ['E', 50]
    );

    list($countVpoint, $inventory2After) = countItemZederInventory($featherItem, $inventory2);

    if (request_type('POST')) {
        if (REQ('action_sendJewelBlank')) {
            cn_dsi_check(true);
            $errors_false = false;

            if (empty($countVpoint) || $countVpoint < 0) {
                cn_throw_message('Thùng đồ cá nhân ' . $sub . ' không có vật phẩm Vpoint.', 'e');
                $errors_false = true;
            }

            list($verifyCaptcha) = GET('verifyCaptcha', 'GPG');
            if ($verifyCaptcha != $_SESSION['captcha_web']) {
                cn_throw_message("Captcah không đúng.", 'e');
                $errors_false = true;
            }

            if (!$errors_false) {
                $newInventory = $inventory1 . $inventory2After . $inventory3;

                do_update_orther("UPDATE Character SET Inventory=0x$newInventory WHERE Name='$sub'");
                do_update_orther("UPDATE MEMB_INFO SET vpoint=vpoint+$countVpoint WHERE memb___id='$acountID'");

                //Ghi vào Log
                $afterVpoint = $showBlank[0]['vp'] + $countVpoint;
                $content = "$sub -  $acountID đã chuyển " . number_format($countVpoint, 0, ",", ".") . " Item Vpoint thành Vpoint";
                $Date = date("h:iA, d/m/Y", ctime());
                $checkDir = makeDirs($files = MODULE_ADM . "/log/modules/money");
                if ($checkDir) {
                    $file = $files . "/log_item2vpoint.log";
//                $file = MODULE_ADM . "/log/modules/money/log_item2vpoint.log";
                    cn_touch($file);
                    $fileContents = file_get_contents($file);
                    file_put_contents($file, $acountID . "|" . $content . "|" . $showBlank[0]['gc'] . "_" . $showBlank[0]['vp'] . "|" . $showBlank[0]['gc'] . "_" . $afterVpoint . "|" . $Date . "|\n" . $fileContents);
                }
                //End Ghi vào Log

                cn_throw_message("Bạn đã thêm Sl: " . number_format($countVpoint, 0, ",", ".") . " Vpoint vào ngân hàng thành công!");
            }

            $resultData = array(
                'msgAction' => cn_snippet_messages(),
                'menuTop' => cn_menuTopMoney(true),
                'countItem' => '<strong> ' . number_format((!$errors_false ? 0 : $countVpoint), 0, ',', '.') . ' </strong> Vpoint',
                'result' => show_inventory(((!$errors_false) ? $inventory2After : $inventory2), $moneyInventory)
            );

            header('Content-Type: application/json');
            return json_encode($resultData);
        }
    }

    $strCountItem = '<strong>' . number_format($countVpoint, 0, ',', '.') . ' </strong> Vpoint';

    cn_assign('sub, showchar, show_inventory, countItem, option', $sub, $showchar, show_inventory($inventory2, $moneyInventory), $strCountItem, $option);
    echo_header_web('-@my_blank_money/style.css@my_blank_money/sendAjaxJewel.js', "Ngân hàng | Tiền tệ - Gửi Vpoint vào ngân hàng");
    echo_content_here(exec_tpl('my_blank_money/jewelToBlank'), cn_snippet_bc_re());
    echo_footer_web();
}

//----------------------------------------------------------------------------

function zenderNumberSelectOption($numberItems, $numberItem = 0)
{
    $countItems = intval($numberItems);
    $numberItem = intval($numberItem);

    $htmlOption = '<select id="bizwebselect" name="numberItemJewel" onchange=\'changeValueNumber(this)\'><option value="0">--Chọn số lượng--</option>';
    if ($numberItems) {
        if ($numberItems < 10) {
            for ($i = 1; $i <= $countItems; $i++) {
                $htmlOption .= '<option ' . (($numberItem == $i) ? 'selected' : '') . ' value="' . $i . '"> ' . $i . ' </option>';
            }
        } else {
            for ($i = 1; $i <= 9; $i++) {
                $htmlOption .= '<option ' . (($numberItem == $i) ? 'selected' : '') . ' value="' . $i . '"> ' . $i . ' </option>';
            }

            if ($countItems > 10) {
                $htmlOption .= '<option ' . (($numberItem == 10) ? 'selected' : '') . ' value="10"> 10 </option>';
            }
            if ($countItems > 20) {
                $htmlOption .= '<option ' . (($numberItem == 20) ? 'selected' : '') . ' value="20"> 20 </option>';
            }
            if ($countItems >= 30) {
                $htmlOption .= '<option ' . (($numberItem == 30) ? 'selected' : '') . ' value="30"> 30 </option>';
            }
        }
    }
    $htmlOption .= '</select>';

    return $htmlOption;
}

function zenderNumberSelectOptionVpoint($numberItems, $numberItem = 0)
{
    $countItems = intval($numberItems);
    $numberItem = intval($numberItem);

    $htmlOption = '<select id="bizwebselect" name="numberItemJewel" onchange=\'changeValueNumber(this)\'><option value="0">--Chọn số lượng--</option>';
    if ($numberItems) {
        if ($numberItems < 10) {
            for ($i = 1; $i <= $countItems; $i++) {
                $htmlOption .= '<option ' . (($numberItem == $i) ? 'selected' : '') . ' value="' . $i . '"> ' . $i . ' </option>';
            }
        } else {
            for ($i = 1; $i <= 9; $i++) {
                $htmlOption .= '<option ' . (($numberItem == $i) ? 'selected' : '') . ' value="' . $i . '"> ' . $i . ' </option>';
            }

            if ($countItems > 10) {
                $htmlOption .= '<option ' . (($numberItem == 10) ? 'selected' : '') . ' value="10"> 10 </option>';
            }
            if ($countItems >= 50) {
                $htmlOption .= '<option ' . (($numberItem == 50) ? 'selected' : '') . ' value="50"> 50 </option>';
            }
        }
    }
    $htmlOption .= '</select>';

    return $htmlOption;
}

function zenderOptionBuyZen()
{
    $optionListZen = explode('|', getOption('configBuyZen'));
    $strHtml = '<select class="" id="bizwebselect" onchange="changeValueNumber(this)">
                    <option value="0">--Chọn số lượng--</option>';
    if ($optionListZen) {
        foreach ($optionListZen as $key => $list) {
            $strHtml .= '<option value="' . $list . '">' . $list . ' Vpoint</option>';
        }
    }

    $strHtml .= '</select>';

    return $strHtml;
}

function blank_money_blank2chaos()
{
    $showchar = cn_character();
    list($sub, $numberItem) = GET('sub, numberItemJewel', 'GPG');
    if (!$sub) {
        $sub = array_keys($showchar)[0];
    } else {
        if (!in_array($sub, array_keys($showchar))) {
            $sub = array_keys($showchar)[0];
        }
    }

    $moneyInventory = $showchar[$sub]['money'];
    $inventory = strtoupper(bin2hex($showchar[$sub]['shop_inventory']));
    $inventory1 = substr($inventory, 0, 12 * 32);
    $inventory2Clone = $inventory2 = substr($inventory, 12 * 32, 64 * 32);
    $inventory3 = substr($inventory, 76 * 32);

    $showBlank = view_bank($accoutID = $_SESSION['user_Gamer']);
    $countChaos = $showBlank[0]['chaos'];
    $numberItem = intval($numberItem);

    $htmlOptionNumItem = zenderNumberSelectOption($countChaos, $numberItem);

    if (request_type('POST')) {
        if (REQ('action_sendBlankJewel')) {
            cn_dsi_check(true);
            $errors_false = false;
            list($postNumberItem) = GET('numberItem', 'GPG');

            if ($countChaos < $postNumberItem) {
                cn_throw_message('Tài khoản ' . $accoutID . ' có tối đa ' . number_format($countChaos, 0, ',', '.') . ' Chaos.', 'e');
                $errors_false = true;
            }

            list($verifyCaptcha) = GET('verifyCaptcha', 'GPG');
            if ($verifyCaptcha != $_SESSION['captcha_web']) {
                cn_throw_message("Captcah không đúng.", 'e');
                $errors_false = true;
            }


            if ($postNumberItem < 10) {
                $item_code = '0F0000363B7A000000C0000000000000';
                for ($key = 0; $key < $postNumberItem; $key++) {
                    $serial = do_select_other('EXEC WZ_GetItemSerial');

                    $str_replace_begin = 6 + (8 - strlen($serial_n = $serial[0]['']));
                    $item_code = substr_replace($item_code, $serial_n, $str_replace_begin, -18);
                    $leng_item_code = strlen($item_code);
                    $slot = cn_CheckSlotInventory($inventory2, 1, 1);

                    if ($slot == 2048) {
                        cn_throw_message("Không đủ chỗ trống trong Hòm đồ cá nhân.", 'e');
                        $errors_false = true;
                        break;
                    } else {
                        $inventory2 = substr_replace($inventory2, $item_code, $slot * 32, $leng_item_code);
                    }
                }
            } else {
                if ($postNumberItem == 10) {
                    $item_code = '8D0000363B7A000000C0000000000000';
                } elseif ($postNumberItem == 20) {
                    $item_code = '8D0801363B7A000000C0000000000000';
                } elseif ($postNumberItem == 30) {
                    $item_code = '8D1002363B7A000000C0000000000000';
                } else {
                    $item_code = '0F0000363B7A000000C0000000000000';
                }

                $serial = do_select_other('EXEC WZ_GetItemSerial');

                $str_replace_begin = 6 + (8 - strlen($serial_n = $serial[0]['']));
                $item_code = substr_replace($item_code, $serial_n, $str_replace_begin, -18);
                $leng_item_code = strlen($item_code);
                $slot = cn_CheckSlotInventory($inventory2, 1, 1);

                if ($slot == 2048) {
                    cn_throw_message("Không đủ chỗ trống trong Hòm đồ cá nhân.", 'e');
                    $errors_false = true;
                } else {
                    $inventory2 = substr_replace($inventory2, $item_code, $slot * 32, $leng_item_code);
                }
            }

            $setDefaultNumItem = $postNumberItem;
            $subChaos = $countChaos;

            if (!$errors_false) {
                $newInventory = $inventory1 . $inventory2 . $inventory3;
                $acountID = $_SESSION['user_Gamer'];

                do_update_orther("UPDATE Character SET Inventory=0x$newInventory WHERE Name='$sub'");
                do_update_orther("UPDATE MEMB_INFO SET jewel_chao=jewel_chao-$postNumberItem WHERE memb___id='$acountID'");

                cn_throw_message("Bạn đã rút Sl: " . number_format($postNumberItem, 0, ",", ".") . " Chaos từ ngân hàng thành công!");

                $subChaos = $countChaos - $postNumberItem;
                if ($subChaos < $postNumberItem && $subChaos > 0) {
                    $setDefaultNumItem = 1;
                } elseif ($subChaos <= 0) {
                    $setDefaultNumItem = 0;
                }
            }

            $resultData = array(
                'msgAction' => cn_snippet_messages(),
                'menuTop' => cn_menuTopMoney(true),
                'countItem' => '<strong> ' . number_format($subChaos, 0, ',', '.') . ' </strong> Chaos',
                'htmlOptionNumItem' => zenderNumberSelectOption($subChaos, $setDefaultNumItem),
                'result' => show_inventory(((!$errors_false) ? $inventory2 : $inventory2Clone), $moneyInventory)
            );

            header('Content-Type: application/json');
            return json_encode($resultData);
        }
    }

    $strCountItem = '<strong>' . number_format($countChaos, 0, ',', '.') . ' </strong> Chaos';

    cn_assign('sub, showchar, show_inventory, countItem', $sub, $showchar, show_inventory($inventory2, $moneyInventory), $strCountItem);
    cn_assign('htmlOptionNumItem, numberItem', $htmlOptionNumItem, $numberItem);
    echo_header_web('-@my_blank_money/style.css@my_blank_money/sendAjaxJewel.js', "Ngân hàng | Tiền tệ - Rút Chaos từ ngân hàng");
    echo_content_here(exec_tpl('my_blank_money/blankToJewel'), cn_snippet_bc_re());
    echo_footer_web();
}

function blank_money_blank2cre()
{
    $showchar = cn_character();
    list($sub, $numberItem) = GET('sub, numberItemJewel', 'GPG');
    if (!$sub) {
        $sub = array_keys($showchar)[0];
    } else {
        if (!in_array($sub, array_keys($showchar))) {
            $sub = array_keys($showchar)[0];
        }
    }

    $moneyInventory = $showchar[$sub]['money'];
    $inventory = strtoupper(bin2hex($showchar[$sub]['shop_inventory']));
    $inventory1 = substr($inventory, 0, 12 * 32);
    $inventory2Clone = $inventory2 = substr($inventory, 12 * 32, 64 * 32);
    $inventory3 = substr($inventory, 76 * 32);

    $showBlank = view_bank($accoutID = $_SESSION['user_Gamer']);
    $countCre = $showBlank[0]['cre'];

    $htmlOptionNumItem = zenderNumberSelectOption($countCre, $numberItem);

    if (request_type('POST')) {
        if (REQ('action_sendBlankJewel')) {
            cn_dsi_check(true);
            $errors_false = false;
            list($postNumberItem) = GET('numberItem', 'GPG');

            if ($countCre < $postNumberItem) {
                cn_throw_message('Tài khoản ' . $accoutID . ' có tối đa ' . number_format($countCre, 0, ',', '.') . ' Chaos.', 'e');
                $errors_false = true;
            }

            list($verifyCaptcha) = GET('verifyCaptcha', 'GPG');
            if ($verifyCaptcha != $_SESSION['captcha_web']) {
                cn_throw_message("Captcah không đúng.", 'e');
                $errors_false = true;
            }


            if ($postNumberItem < 10) {
                $item_code = '160000363B7A000000E0000000000000';
                for ($key = 0; $key < $postNumberItem; $key++) {
                    $serial = do_select_other('EXEC WZ_GetItemSerial');

                    $str_replace_begin = 6 + (8 - strlen($serial_n = $serial[0]['']));
                    $item_code = substr_replace($item_code, $serial_n, $str_replace_begin, -18);
                    $leng_item_code = strlen($item_code);
                    $slot = cn_CheckSlotInventory($inventory2, 1, 1);

                    if ($slot == 2048) {
                        cn_throw_message("Không đủ chỗ trống trong Hòm đồ cá nhân.", 'e');
                        $errors_false = true;
                        break;
                    } else {
                        $inventory2 = substr_replace($inventory2, $item_code, $slot * 32, $leng_item_code);
                    }
                }
            } else {
                if ($postNumberItem == 10) {
                    $item_code = '890000363B7A000000C0000000000000';
                } elseif ($postNumberItem == 20) {
                    $item_code = '890801363B7A000000C0000000000000';
                } elseif ($postNumberItem == 30) {
                    $item_code = '891002363B7A000000C0000000000000';
                } else {
                    $item_code = '160000363B7A000000E0000000000000';
                }

                $serial = do_select_other('EXEC WZ_GetItemSerial');

                $str_replace_begin = 6 + (8 - strlen($serial_n = $serial[0]['']));
                $item_code = substr_replace($item_code, $serial_n, $str_replace_begin, -18);
                $leng_item_code = strlen($item_code);
                $slot = cn_CheckSlotInventory($inventory2, 1, 1);

                if ($slot == 2048) {
                    cn_throw_message("Không đủ chỗ trống trong Hòm đồ cá nhân.", 'e');
                    $errors_false = true;
                } else {
                    $inventory2 = substr_replace($inventory2, $item_code, $slot * 32, $leng_item_code);
                }
            }

            $setDefaultNumItem = $postNumberItem;
            $subCre = $countCre;
            if (!$errors_false) {
                $newInventory = $inventory1 . $inventory2 . $inventory3;
                $acountID = $_SESSION['user_Gamer'];

                do_update_orther("UPDATE Character SET Inventory=0x$newInventory WHERE Name='$sub'");
                do_update_orther("UPDATE MEMB_INFO SET jewel_cre=jewel_cre-$postNumberItem WHERE memb___id='$acountID'");

                cn_throw_message("Bạn đã rút Sl: " . number_format($postNumberItem, 0, ",", ".") . " Cre từ ngân hàng thành công!");

                $subCre = $countCre - $postNumberItem;
                if ($subCre < $postNumberItem && $subCre > 0) {
                    $setDefaultNumItem = 1;
                } elseif ($subCre <= 0) {
                    $setDefaultNumItem = 0;
                }
            }

            $resultData = array(
                'msgAction' => cn_snippet_messages(),
                'menuTop' => cn_menuTopMoney(true),
                'countItem' => '<strong> ' . number_format($subCre, 0, ',', '.') . ' </strong> Cre',
                'htmlOptionNumItem' => zenderNumberSelectOption($subCre, $setDefaultNumItem),
                'result' => show_inventory(((!$errors_false) ? $inventory2 : $inventory2Clone), $moneyInventory)
            );

            header('Content-Type: application/json');
            return json_encode($resultData);
        }
    }

    $strCountItem = '<strong>' . number_format($countCre, 0, ',', '.') . ' </strong> Cre';

    cn_assign('sub, showchar, show_inventory, countItem', $sub, $showchar, show_inventory($inventory2, $moneyInventory), $strCountItem);
    cn_assign('htmlOptionNumItem, numberItem', $htmlOptionNumItem, $numberItem);
    echo_header_web('-@my_blank_money/style.css@my_blank_money/sendAjaxJewel.js', "Ngân hàng | Tiền tệ - Rút Cre từ ngân hàng");
    echo_content_here(exec_tpl('my_blank_money/blankToJewel'), cn_snippet_bc_re());
    echo_footer_web();
}

function blank_money_blank2bule()
{
    $showchar = cn_character();
    list($sub, $numberItem) = GET('sub, numberItemJewel', 'GPG');
    if (!$sub) {
        $sub = array_keys($showchar)[0];
    } else {
        if (!in_array($sub, array_keys($showchar))) {
            $sub = array_keys($showchar)[0];
        }
    }

    $moneyInventory = $showchar[$sub]['money'];
    $inventory = strtoupper(bin2hex($showchar[$sub]['shop_inventory']));
    $inventory1 = substr($inventory, 0, 12 * 32);
    $inventory2Clone = $inventory2 = substr($inventory, 12 * 32, 64 * 32);
    $inventory3 = substr($inventory, 76 * 32);

    $showBlank = view_bank($accoutID = $_SESSION['user_Gamer']);
    $countBlue = $showBlank[0]['blue'];

    $htmlOptionNumItem = zenderNumberSelectOption($countBlue, $numberItem);


    if (request_type('POST')) {
        if (REQ('action_sendBlankJewel')) {
            cn_dsi_check(true);
            $errors_false = false;
            list($postNumberItem) = GET('numberItem', 'GPG');

            if ($countBlue < $postNumberItem) {
                cn_throw_message('Tài khoản ' . $accoutID . ' có tối đa ' . number_format($countBlue, 0, ',', '.') . ' Blue.', 'e');
                $errors_false = true;
            }

            list($verifyCaptcha) = GET('verifyCaptcha', 'GPG');
            if ($verifyCaptcha != $_SESSION['captcha_web']) {
                cn_throw_message("Captcah không đúng.", 'e');
                $errors_false = true;
            }


            if ($postNumberItem < 10) {
                $item_code = '0D0096363B7A000000E0000000000000';
                for ($key = 0; $key < $postNumberItem; $key++) {
                    $serial = do_select_other('EXEC WZ_GetItemSerial');

                    $str_replace_begin = 6 + (8 - strlen($serial_n = $serial[0]['']));
                    $item_code = substr_replace($item_code, $serial_n, $str_replace_begin, -18);
                    $leng_item_code = strlen($item_code);
                    $slot = cn_CheckSlotInventory($inventory2, 1, 1);

                    if ($slot == 2048) {
                        cn_throw_message("Không đủ chỗ trống trong Hòm đồ cá nhân.", 'e');
                        $errors_false = true;
                        break;
                    } else {
                        $inventory2 = substr_replace($inventory2, $item_code, $slot * 32, $leng_item_code);
                    }
                }
            } else {
                if ($postNumberItem == 10) {
                    $item_code = '1E0000363B7A000000C0000000000000';
                } elseif ($postNumberItem == 20) {
                    $item_code = '1E0800363B7A000000C0000000000000';
                } elseif ($postNumberItem == 30) {
                    $item_code = '1E1000363B7A000000C0000000000000';
                } else {
                    $item_code = '0D0096363B7A000000E0000000000000';
                }

                $serial = do_select_other('EXEC WZ_GetItemSerial');

                $str_replace_begin = 6 + (8 - strlen($serial_n = $serial[0]['']));
                $item_code = substr_replace($item_code, $serial_n, $str_replace_begin, -18);
                $leng_item_code = strlen($item_code);
                $slot = cn_CheckSlotInventory($inventory2, 1, 1);

                if ($slot == 2048) {
                    cn_throw_message("Không đủ chỗ trống trong Hòm đồ cá nhân.", 'e');
                    $errors_false = true;
                } else {
                    $inventory2 = substr_replace($inventory2, $item_code, $slot * 32, $leng_item_code);
                }
            }

            $setDefaultNumItem = $postNumberItem;
            $subBlue = $countBlue;

            if (!$errors_false) {
                $newInventory = $inventory1 . $inventory2 . $inventory3;
                $acountID = $_SESSION['user_Gamer'];

                do_update_orther("UPDATE Character SET Inventory=0x$newInventory WHERE Name='$sub'");
                do_update_orther("UPDATE MEMB_INFO SET jewel_blue=jewel_blue-$postNumberItem WHERE memb___id='$acountID'");

                cn_throw_message("Bạn đã rút Sl: " . number_format($postNumberItem, 0, ",", ".") . " Blue từ ngân hàng thành công!");

                $subBlue = $countBlue - $postNumberItem;
                if ($subBlue < $postNumberItem && $subBlue > 0) {
                    $setDefaultNumItem = 1;
                } elseif ($subBlue <= 0) {
                    $setDefaultNumItem = 0;
                }
            }

            $resultData = array(
                'msgAction' => cn_snippet_messages(),
                'menuTop' => cn_menuTopMoney(true),
                'countItem' => '<strong> ' . number_format($subBlue, 0, ',', '.') . ' </strong> Bule',
                'htmlOptionNumItem' => zenderNumberSelectOption($subBlue, $setDefaultNumItem),
                'result' => show_inventory(((!$errors_false) ? $inventory2 : $inventory2Clone), $moneyInventory)
            );

            header('Content-Type: application/json');
            return json_encode($resultData);
        }
    }

    $strCountItem = '<strong>' . number_format($countBlue, 0, ',', '.') . ' </strong> Blue';

    cn_assign('sub, showchar, show_inventory, countItem', $sub, $showchar, show_inventory($inventory2, $moneyInventory), $strCountItem);
    cn_assign('htmlOptionNumItem, numberItem', $htmlOptionNumItem, $numberItem);
    echo_header_web('-@my_blank_money/style.css@my_blank_money/sendAjaxJewel.js', "Ngân hàng | Tiền tệ - Rút Blue từ ngân hàng");
    echo_content_here(exec_tpl('my_blank_money/blankToJewel'), cn_snippet_bc_re());
    echo_footer_web();
}

function blank_money_blank2feather()
{
    $showchar = cn_character();
    list($sub, $numberItem) = GET('sub, numberItemJewel', 'GPG');
    if (!$sub) {
        $sub = array_keys($showchar)[0];
    } else {
        if (!in_array($sub, array_keys($showchar))) {
            $sub = array_keys($showchar)[0];
        }
    }

    $moneyInventory = $showchar[$sub]['money'];
    $inventory = strtoupper(bin2hex($showchar[$sub]['shop_inventory']));
    $inventory1 = substr($inventory, 0, 12 * 32);
    $inventory2Clone = $inventory2 = substr($inventory, 12 * 32, 64 * 32);
    $inventory3 = substr($inventory, 76 * 32);

    $showBlank = view_bank($accoutID = $_SESSION['user_Gamer']);
    $countFeather = $showBlank[0]['feather'];

    $htmlOptionNumItem = zenderNumberSelectOption($countFeather, $numberItem);


    if (request_type('POST')) {
        if (REQ('action_sendBlankJewel')) {
            cn_dsi_check(true);
            $errors_false = false;
            list($postNumberItem) = GET('numberItem', 'GPG');

            if ($countFeather < $postNumberItem) {
                cn_throw_message('Tài khoản ' . $accoutID . ' có tối đa ' . number_format($countFeather, 0, ',', '.') . ' Lông vũ.', 'e');
                $errors_false = true;
            }

            list($verifyCaptcha) = GET('verifyCaptcha', 'GPG');
            if ($verifyCaptcha != $_SESSION['captcha_web']) {
                cn_throw_message("Captcah không đúng.", 'e');
                $errors_false = true;
            }

            $item_code = '0E0000FC1E7A000000D0000000000000';
            if ($postNumberItem < 10) {
                for ($key = 0; $key < $postNumberItem; $key++) {
                    $serial = do_select_other('EXEC WZ_GetItemSerial');

                    $str_replace_begin = 6 + (8 - strlen($serial_n = $serial[0]['']));
                    $item_code = substr_replace($item_code, $serial_n, $str_replace_begin, -18);
                    $leng_item_code = strlen($item_code);
                    $slot = cn_CheckSlotInventory($inventory2, 1, 1);

                    if ($slot == 2048) {
                        cn_throw_message("Không đủ chỗ trống trong Hòm đồ cá nhân.", 'e');
                        $errors_false = true;
                        break;
                    } else {
                        $inventory2 = substr_replace($inventory2, $item_code, $slot * 32, $leng_item_code);
                    }
                }
            } else {
                $serial = do_select_other('EXEC WZ_GetItemSerial');

                $str_replace_begin = 6 + (8 - strlen($serial_n = $serial[0]['']));
                $item_code = substr_replace($item_code, $serial_n, $str_replace_begin, -18);
                $leng_item_code = strlen($item_code);
                $slot = cn_CheckSlotInventory($inventory2, 1, 2);

                if ($slot == 2048) {
                    cn_throw_message("Không đủ chỗ trống trong Hòm đồ cá nhân.", 'e');
                    $errors_false = true;
                } else {
                    $inventory2 = substr_replace($inventory2, $item_code, $slot * 32, $leng_item_code);
                }
            }

            $setDefaultNumItem = $postNumberItem;
            $subtFeather = $countFeather;

            if (!$errors_false) {
                $newInventory = $inventory1 . $inventory2 . $inventory3;
                $acountID = $_SESSION['user_Gamer'];

                do_update_orther("UPDATE Character SET Inventory=0x$newInventory WHERE Name='$sub'");
                do_update_orther("UPDATE MEMB_INFO SET jewel_feather=jewel_feather-$postNumberItem WHERE memb___id='$acountID'");

                cn_throw_message("Bạn đã rút Sl: " . number_format($postNumberItem, 0, ",", ".") . " Lông vũ từ ngân hàng thành công!");

                $subtFeather = $countFeather - $postNumberItem;
                if ($subtFeather < $postNumberItem && $subtFeather > 0) {
                    $setDefaultNumItem = 1;
                } elseif ($subtFeather <= 0) {
                    $setDefaultNumItem = 0;
                }
            }

            $resultData = array(
                'msgAction' => cn_snippet_messages(),
                'menuTop' => cn_menuTopMoney(true),
                'countItem' => '<strong> ' . number_format($subtFeather, 0, ',', '.') . ' </strong> Lông vũ',
                'htmlOptionNumItem' => zenderNumberSelectOption($subtFeather, $setDefaultNumItem),
                'result' => show_inventory(((!$errors_false) ? $inventory2 : $inventory2Clone), $moneyInventory)
            );

            header('Content-Type: application/json');
            return json_encode($resultData);
        }
    }

    $strCountItem = '<strong>' . number_format($countFeather, 0, ',', '.') . ' </strong> Lông vũ';

    cn_assign('sub, showchar, show_inventory, countItem', $sub, $showchar, show_inventory($inventory2, $moneyInventory), $strCountItem);
    cn_assign('htmlOptionNumItem, numberItem', $htmlOptionNumItem, $numberItem);
    echo_header_web('-@my_blank_money/style.css@my_blank_money/sendAjaxJewel.js', "Ngân hàng | Tiền tệ - Rút Lông vũ từ ngân hàng");
    echo_content_here(exec_tpl('my_blank_money/blankToJewel'), cn_snippet_bc_re());
    echo_footer_web();
}

function blank_money_blank2zen()
{
    $showchar = cn_character();
    list($sub, $numberItem) = GET('sub, numberItemJewel', 'GPG');
    if (!$sub) {
        $sub = array_keys($showchar)[0];
    } else {
        if (!in_array($sub, array_keys($showchar))) {
            $sub = array_keys($showchar)[0];
        }
    }

    $moneyInventory = $showchar[$sub]['money'];
    $inventory = strtoupper(bin2hex($showchar[$sub]['shop_inventory']));
    $inventory2 = substr($inventory, 12 * 32, 64 * 32);

    $showBlank = view_bank($accoutID = $_SESSION['user_Gamer']);
    $moneyStoreBank = $showBlank[0]['bank'];

    $subMoneyStoreBankNew = 0;
    $maxMoneyStore = MAX_TRANS;
    if ($moneyStoreBank >= $maxMoneyStore && $moneyInventory < $maxMoneyStore) {
        $subMoneyStoreBankNew = $maxMoneyStore - $moneyInventory;
    } elseif ($moneyInventory < $maxMoneyStore && $moneyStoreBank > 0) {
        $subRangMoney = $maxMoneyStore - $moneyInventory;
        if ($subRangMoney <= $moneyStoreBank) {
            $subMoneyStoreBankNew = $subRangMoney;
        } else {
            $subMoneyStoreBankNew = $moneyStoreBank;
        }
    } elseif ($moneyInventory < 0 && $moneyStoreBank >= $maxMoneyStore) {
        $subMoneyStoreBankNew = $maxMoneyStore;
    } elseif ($moneyInventory < 0 && $moneyStoreBank < $maxMoneyStore) {
        $subMoneyStoreBankNew = $moneyStoreBank;
    }

    $htmlOptionNumItem = '';
    $strCountItem = 'SL: Rút <strong>' . number_format($subMoneyStoreBankNew, 0, ',', '.') . ' </strong> Zen';
    $strCountItemNot = 'Tài khoản ' . $accoutID . ' không có Zen trong ngân hàng.';
    $strCountItemNot1 = 'Nhân vật ' . $sub . ' không thể rút Zen vượt quá ' . number_format($maxMoneyStore, 0, ',', '.') . ' Zen.';
    if ($moneyStoreBank <= 0) {
        $strCountItem = $strCountItemNot;
    }

    if ($moneyInventory == $maxMoneyStore) {
        $strCountItem = $strCountItemNot1;
    }

    if (request_type('POST')) {
        if (REQ('action_sendBlankJewel')) {
            cn_dsi_check(true);
            $errors_false = false;
            list($postNumberItem) = GET('numberItem', 'GPG');

            if ($subMoneyStoreBankNew <= 0 || $moneyInventory == $maxMoneyStore) {
                cn_throw_message($strCountItem, 'e');
                $errors_false = true;
            }

            list($verifyCaptcha) = GET('verifyCaptcha', 'GPG');
            if ($verifyCaptcha != $_SESSION['captcha_web']) {
                cn_throw_message("Captcah không đúng.", 'e');
                $errors_false = true;
            }

            if (!$errors_false) {
                $acountID = $_SESSION['user_Gamer'];

                do_update_orther("UPDATE Character SET Money=Money+$postNumberItem WHERE Name='$sub'");
                do_update_orther("UPDATE MEMB_INFO SET bank=bank-$postNumberItem WHERE memb___id='$acountID'");

                cn_throw_message("Bạn đã rút Sl: " . number_format($postNumberItem, 0, ",", ".") . " Zen từ ngân hàng thành công!");
            }

            if ($moneyStoreBank) {
                $subAction = (!$errors_false) ? 0 : $postNumberItem;
                $strCountItem = 'SL: Rút <strong> ' . number_format($subAction, 0, ',', '.') . ' </strong> Zen';
            }

            if ($moneyStoreBank - $postNumberItem <= 0) {
                $strCountItem = $strCountItemNot;
            }
            if (($postNumberItem + $moneyInventory) == $maxMoneyStore) {
                $strCountItem = $strCountItemNot1;
            }

            $moneyInventoryAction = (!$errors_false) ? ($postNumberItem + $moneyInventory) : $moneyInventory;
            $resultData = array(
                'msgAction' => cn_snippet_messages(),
                'menuTop' => cn_menuTopMoney(true),
                'countItem' => $strCountItem,
                'htmlOptionNumItem' => '',
                'result' => show_inventory($inventory2, $moneyInventoryAction)
            );

            header('Content-Type: application/json');
            return json_encode($resultData);
        }
    }

    cn_assign('sub, showchar, show_inventory, countItem', $sub, $showchar, show_inventory($inventory2, $moneyInventory), $strCountItem);
    cn_assign('htmlOptionNumItem, numberItem, isZen', $htmlOptionNumItem, $numberItem, $subMoneyStoreBankNew);
    echo_header_web('-@my_blank_money/style.css@my_blank_money/sendAjaxJewel.js', "Ngân hàng | Tiền tệ - Rút Lông vũ từ ngân hàng");
    echo_content_here(exec_tpl('my_blank_money/blankToJewel'), cn_snippet_bc_re());
    echo_footer_web();
}

function blank_money_blank2vpoint()
{
    $showchar = cn_character();
    list($sub, $numberItem) = GET('sub, numberItemJewel', 'GPG');
    if (!$sub) {
        $sub = array_keys($showchar)[0];
    } else {
        if (!in_array($sub, array_keys($showchar))) {
            $sub = array_keys($showchar)[0];
        }
    }

    $moneyInventory = $showchar[$sub]['money'];
    $inventory = strtoupper(bin2hex($showchar[$sub]['shop_inventory']));
    $inventory1 = substr($inventory, 0, 12 * 32);
    $inventory2Clone = $inventory2 = substr($inventory, 12 * 32, 64 * 32);
    $inventory3 = substr($inventory, 76 * 32);

    $showBlank = view_bank($acountID = $_SESSION['user_Gamer']);
    $countVpoint = $showBlank[0]['vp'];

    $htmlOptionNumItem = zenderNumberSelectOptionVpoint($countVpoint, $numberItem);


    if (request_type('POST')) {
        if (REQ('action_sendBlankJewel')) {
            cn_dsi_check(true);
            $errors_false = false;
            list($postNumberItem) = GET('numberItem', 'GPG');


            if ($countVpoint < $postNumberItem) {
                cn_throw_message('Tài khoản ' . $acountID . ' có tối đa ' . number_format($countVpoint, 0, ',', '.') . ' Blue.', 'e');
                $errors_false = true;
            }

            list($verifyCaptcha) = GET('verifyCaptcha', 'GPG');
            if ($verifyCaptcha != $_SESSION['captcha_web']) {
                cn_throw_message("Captcah không đúng.", 'e');
                $errors_false = true;
            }

            if ($postNumberItem < 10) {
                $item_code = '0C10009044A9000000E0000000000000';
                for ($key = 0; $key < $postNumberItem; $key++) {
                    $serial = do_select_other('EXEC WZ_GetItemSerial');

                    $str_replace_begin = 6 + (8 - strlen($serial_n = $serial[0]['']));
                    $item_code = substr_replace($item_code, $serial_n, $str_replace_begin, -18);
                    $leng_item_code = strlen($item_code);
                    $slot = cn_CheckSlotInventory($inventory2, 1, 1);

                    if ($slot == 2048) {
                        cn_throw_message("Không đủ chỗ trống trong Hòm đồ cá nhân.", 'e');
                        $errors_false = true;
                        break;
                    } else {
                        $inventory2 = substr_replace($inventory2, $item_code, $slot * 32, $leng_item_code);
                    }
                }
            } else {
                if ($postNumberItem == 10) {
                    $item_code = '0C00009044A9000000E0000000000000';
                } elseif ($postNumberItem == 50) {
                    $item_code = '0F00009044A9000000E0000000000000';
                } else {
                    $item_code = '0C10009044A9000000E0000000000000';
                }

                $serial = do_select_other('EXEC WZ_GetItemSerial');

                $str_replace_begin = 6 + (8 - strlen($serial_n = $serial[0]['']));
                $item_code = substr_replace($item_code, $serial_n, $str_replace_begin, -18);
                $leng_item_code = strlen($item_code);
                $slot = cn_CheckSlotInventory($inventory2, 1, 1);

                if ($slot == 2048) {
                    cn_throw_message("Không đủ chỗ trống trong Hòm đồ cá nhân.", 'e');
                    $errors_false = true;
                } else {
                    $inventory2 = substr_replace($inventory2, $item_code, $slot * 32, $leng_item_code);
                }
            }

            $setDefaultNumItem = $postNumberItem;
            $subVpoint = $countVpoint;

            if (!$errors_false) {
                $newInventory = $inventory1 . $inventory2 . $inventory3;

                do_update_orther("UPDATE Character SET Inventory=0x$newInventory WHERE Name='$sub'");
                do_update_orther("UPDATE MEMB_INFO SET vpoint=vpoint-$postNumberItem WHERE memb___id='$acountID'");

                //Ghi vào Log
                $afterVpoint = ($showBlank[0]['vp'] - $countVpoint);
                $content = "$sub - $acountID chuyển " . number_format($postNumberItem, 0, ",", ".") . " Vpoint thành Vpoint Item.";
                $Date = date("h:iA, d/m/Y", ctime());
                $checkDir = makeDirs($files = MODULE_ADM . "/log/modules/money");
                if ($checkDir) {
                    $file = $files . "/log_vpoint2item.log";
//                    $file = MODULE_ADM . "/log/modules/money/log_vpoint2item.log";
                    cn_touch($file);
                    $fileContents = file_get_contents($file);
                    file_put_contents($file, $acountID . "|" . $content . "|" . $showBlank[0]['gc'] . "_" . $showBlank[0]['vp'] . "|" . $showBlank[0]['gc'] . "_" . $afterVpoint . "|" . $Date . "|\n" . $fileContents);
                }
                //End Ghi vào Log

                cn_throw_message("Bạn đã rút Sl: " . number_format($postNumberItem, 0, ",", ".") . " Vpoint từ ngân hàng thành công!");

                $subVpoint = $countVpoint - $postNumberItem;
                if ($subVpoint < $postNumberItem && $subVpoint > 0) {
                    $setDefaultNumItem = 1;
                } elseif ($subVpoint <= 0) {
                    $setDefaultNumItem = 0;
                }
            }

            $resultData = array(
                'msgAction' => cn_snippet_messages(),
                'menuTop' => cn_menuTopMoney(true),
                'countItem' => '<strong> ' . number_format($subVpoint, 0, ',', '.') . ' </strong> Vpoint',
                'htmlOptionNumItem' => zenderNumberSelectOptionVpoint($subVpoint, $setDefaultNumItem),
                'result' => show_inventory(((!$errors_false) ? $inventory2 : $inventory2Clone), $moneyInventory)
            );

            header('Content-Type: application/json');
            return json_encode($resultData);
        }
    }

    $strCountItem = '<strong>' . number_format($countVpoint, 0, ',', '.') . ' </strong> Vpoint';

    cn_assign('sub, showchar, show_inventory, countItem', $sub, $showchar, show_inventory($inventory2, $moneyInventory), $strCountItem);
    cn_assign('htmlOptionNumItem, numberItem', $htmlOptionNumItem, $numberItem);
    echo_header_web('-@my_blank_money/style.css@my_blank_money/sendAjaxJewel.js', "Ngân hàng | Tiền tệ - Rút Vpoint từ ngân hàng");
    echo_content_here(exec_tpl('my_blank_money/blankToJewel'), cn_snippet_bc_re());
    echo_footer_web();
}

//-----------------------------------------------------------------------------------------------------------------------------------------------

function blank_money_vpoint2gcoin()
{
    $showBlank = view_bank($accoutID = $_SESSION['user_Gamer']);

    $rootVpoint = $showBlank[0]['vp'];
    $rootGcoin = $showBlank[0]['gc'];


    if (request_type('POST')) {
        if (REQ('action_transBlank')) {
            cn_dsi_check(true);
            $errors_false = false;
            list($postNumberItem) = GET('numberItem', 'GPG');

            $postNumberItem = intval($postNumberItem);

            if ($postNumberItem > MAX_TRANS) {
                cn_throw_message('Hạn mức giao dịch tối đa là  2 tỷ.', 'e');
                $errors_false = true;
            }

            if (empty($rootVpoint)) {
                cn_throw_message('Tài khoản ' . $accoutID . ' không Vpoint trong ngân hàng.', 'e');
                $errors_false = true;
            }
            if ($postNumberItem <= 0) {
                cn_throw_message('Tài khoản ' . $accoutID . ' chưa nhập số Vpoint cần chuyển sang Gcoin.', 'e');
                $errors_false = true;
            }

            if ($postNumberItem > $rootVpoint) {
                cn_throw_message('Tài khoản ' . $accoutID . ' có tối đa ' . number_format($rootVpoint, 0, ',', '.') . ' Vpoint.', 'e');
                $errors_false = true;
            }

            list($verifyCaptcha) = GET('verifyCaptcha', 'GPG');
            if ($verifyCaptcha != $_SESSION['captcha_web']) {
                cn_throw_message("Captcah không đúng.", 'e');
                $errors_false = true;
            }

            if (!$errors_false) {
                $gcoinNew = floor($postNumberItem * getOption('vptogc') / 100);
                $acountID = $_SESSION['user_Gamer'];
                do_update_orther("UPDATE MEMB_INFO SET gcoin=gcoin+$gcoinNew, vpoint=vpoint-$postNumberItem WHERE memb___id='$acountID'");

                cn_throw_message("Bạn đã chuyển " . number_format($postNumberItem, 0, ",", ".") . " Vpoint sang " . number_format($gcoinNew, 0, ',', '.') . " Gcoin thành công!");

                //Ghi vào Log
                $afterVpoint = ($rootVpoint - $postNumberItem);
                $afterGcoin = ($rootGcoin + $gcoinNew);
                $content = "$accoutID đã chuyển Vpoint " . number_format($postNumberItem, 0, ",", ".") . " thành Gcoin " . number_format($gcoinNew, 0, ',', '.');
                $Date = date("h:iA, d/m/Y", ctime());
                $checkDir = makeDirs($files = MODULE_ADM . "/log/modules/money");
                if ($checkDir) {
                    $file = $files . "/log_vpoint2gcoin.log";
//                    $file = MODULE_ADM . "/log/modules/money/log_vpoint2gcoin.log";
                    cn_touch($file);
                    $fileContents = file_get_contents($file);
                    file_put_contents($file, $accoutID . "|" . $content . "|" . $showBlank[0]['gc'] . "_" . $showBlank[0]['vp'] . "|" . $afterGcoin . "_" . $afterVpoint . "|" . $Date . "|\n" . $fileContents);
                }
                //End Ghi vào Log
            }

            $resultData = array(
                'msgAction' => cn_snippet_messages(),
                'menuTop' => cn_menuTopMoney(true),
                'countItem' => '',
                'htmlOptionNumItem' => '',
                'result' => ''
            );

            header('Content-Type: application/json');
            return json_encode($resultData);
        }
    }

    $showConfigVpoint = '- Tỷ lệ: <strong> 1 Gcoin</strong><i> = </i><strong> 1*' . getOption('vptogc') . '% Vpoint</strong>';
    cn_assign('options, strInfoMoney, showConfigVpoint, optionBuyZen', 'Vpoint', '', $showConfigVpoint, '');
    echo_header_web('-@my_blank_money/style.css@my_blank_money/sendAjaxJewel.js', "Ngân hàng | Money - Chuyển Vpoint sang Gcoin.");
    echo_content_here(exec_tpl('my_blank_money/transBlank'), cn_snippet_bc_re());
    echo_footer_web();
}

function blank_money_gcoin2vpoint()
{
    $showBlank = view_bank($accoutID = $_SESSION['user_Gamer']);

    $rootVpoint = $showBlank[0]['vp'];
    $rootGcoin = $showBlank[0]['gc'];

    if (request_type('POST')) {
        if (REQ('action_transBlank')) {
            cn_dsi_check(true);
            $errors_false = false;
            list($postNumberItem) = GET('numberItem', 'GPG');

            $postNumberItem = intval($postNumberItem);

            if ($postNumberItem > MAX_TRANS) {
                cn_throw_message('Hạn mức giao dịch tối đa là  2 tỷ.', 'e');
                $errors_false = true;
            }

            if (empty($rootGcoin)) {
                cn_throw_message('Tài khoản ' . $accoutID . ' không Gcoin trong ngân hàng.', 'e');
                $errors_false = true;
            }
            if ($postNumberItem <= 0) {
                cn_throw_message('Tài khoản ' . $accoutID . ' chưa nhập số Gcoin cần chuyển sang Vpoint.', 'e');
                $errors_false = true;
            }

            if ($postNumberItem > $rootGcoin) {
                cn_throw_message('Tài khoản ' . $accoutID . ' có tối đa ' . number_format($rootGcoin, 0, ',', '.') . ' Gcoin.', 'e');
                $errors_false = true;
            }

            list($verifyCaptcha) = GET('verifyCaptcha', 'GPG');
            if ($verifyCaptcha != $_SESSION['captcha_web']) {
                cn_throw_message("Captcah không đúng.", 'e');
                $errors_false = true;
            }

            if (!$errors_false) {
                $acountID = $_SESSION['user_Gamer'];
                do_update_orther("UPDATE MEMB_INFO SET gcoin=gcoin-$postNumberItem, vpoint=vpoint+$postNumberItem WHERE memb___id='$acountID'");

                cn_throw_message("Bạn đã chuyển " . number_format($postNumberItem, 0, ",", ".") . " Gcoin sang " . number_format($postNumberItem, 0, ',', '.') . " Vpoint thành công!");

                //Ghi vào Log
                $afterVpoint = ($rootVpoint + $postNumberItem);
                $afterGcoin = $rootGcoin - $postNumberItem;
                $content = "$accoutID đã chuyển " . number_format($postNumberItem, 0, ",", ".") . " Gcoin thành " . number_format($postNumberItem, 0, ',', ' Vpoint.');
                $Date = date("h:iA, d/m/Y", ctime());
                $checkDir = makeDirs($files = MODULE_ADM . "/log/modules/money");
                if ($checkDir) {
                    $file = $files . "/log_gcoin2vpoint.log";
//                $file = MODULE_ADM . "/log/modules/money/log_gcoin2vpoint.log";
                    cn_touch($file);
                    $fileContents = file_get_contents($file);
                    file_put_contents($file, $accoutID . "|" . $content . "|" . $showBlank[0]['gc'] . "_" . $showBlank[0]['vp'] . "|" . $afterGcoin . "_" . $afterVpoint . "|" . $Date . "|\n" . $fileContents);
                }
                //End Ghi vào Log
            }

            $resultData = array(
                'msgAction' => cn_snippet_messages(),
                'menuTop' => cn_menuTopMoney(true),
                'countItem' => '',
                'htmlOptionNumItem' => '',
                'result' => ''
            );

            header('Content-Type: application/json');
            return json_encode($resultData);
        }
    }
    $showConfigVpoint = '- Tỷ lệ: <strong> 1 Gcoin</strong><i> = </i><strong>1 Vpoint</strong>';
    cn_assign('options, strInfoMoney, showConfigVpoint', 'Gcoin', '', $showConfigVpoint);
    echo_header_web('-@my_blank_money/style.css@my_blank_money/sendAjaxJewel.js', "Ngân hàng | Tiền tệ - Gcoin sang Vpoint");
    echo_content_here(exec_tpl('my_blank_money/transBlank'), cn_snippet_bc_re());
    echo_footer_web();
}

function blank_money_transgc2wc()
{
    $showBlank = view_bank($accoutID = $_SESSION['user_Gamer']);

    $rootVpoint = $showBlank[0]['vp'];
    $rootGcoin = $showBlank[0]['gc'];

    $strInfoMoney = 'Tài khoản ' . $accoutID . ' có <b class="cRed">' . number_format($showBlank[0]['wCoin'], 0, ',', '.') . ' Wcoin </b>';

    if (request_type('POST')) {
        if (REQ('action_transBlank')) {
            cn_dsi_check(true);
            $errors_false = false;
            list($postNumberItem) = GET('numberItem', 'GPG');

            $postNumberItem = intval($postNumberItem);
            if ($postNumberItem > MAX_TRANS) {
                cn_throw_message('Hạn mức giao dịch tối đa là  2 tỷ.', 'e');
                $errors_false = true;
            }
            if (empty($rootGcoin)) {
                cn_throw_message('Tài khoản ' . $accoutID . ' không Gcoin trong ngân hàng.', 'e');
                $errors_false = true;
            }
            if ($postNumberItem <= 0) {
                cn_throw_message('Tài khoản ' . $accoutID . ' chưa nhập số Gcoin cần chuyển sang Wcoin.', 'e');
                $errors_false = true;
            }

            if ($postNumberItem > $rootGcoin) {
                cn_throw_message('Tài khoản ' . $accoutID . ' có tối đa ' . number_format($rootGcoin, 0, ',', '.') . ' Gcoin.', 'e');
                $errors_false = true;
            }

            list($verifyCaptcha) = GET('verifyCaptcha', 'GPG');
            if ($verifyCaptcha != $_SESSION['captcha_web']) {
                cn_throw_message("Captcah không đúng.", 'e');
                $errors_false = true;
            }

            if (!$errors_false) {
                $acountID = $_SESSION['user_Gamer'];
                do_update_orther("UPDATE MEMB_INFO SET gcoin=gcoin-$postNumberItem, wCoin=wCoin+$postNumberItem WHERE memb___id='$acountID'");

                cn_throw_message("Bạn đã chuyển " . number_format($postNumberItem, 0, ",", ".") . " Gcoin sang " . number_format($postNumberItem, 0, ',', '.') . " Wcoin thành công!");

                //Ghi vào Log
                $afterVpoint = $rootVpoint;
                $afterGcoin = $rootGcoin - $postNumberItem;
                $content = "$accoutID đã chuyển " . number_format($postNumberItem, 0, ",", ".") . " Gcoin thành " . number_format($postNumberItem, 0, ',', ' Wcoin.');
                $Date = date("h:iA, d/m/Y", ctime());
                $checkDir = makeDirs($files = MODULE_ADM . "/log/modules/money");
                if ($checkDir) {
                    $file = $files . "/log_transgc2wc.log";
//                $file = MODULE_ADM . "/log/modules/money/.log";
                    cn_touch($file);
                    $fileContents = file_get_contents($file);
                    file_put_contents($file, $accoutID . "|" . $content . "|" . $showBlank[0]['gc'] . "_" . $showBlank[0]['vp'] . "|" . $afterGcoin . "_" . $afterVpoint . "|" . $Date . "|\n" . $fileContents);
                }
                //End Ghi vào Log
            }

            $showMoney = (!$errors_false) ? ($showBlank[0]['wCoin'] + $postNumberItem) : $showBlank[0]['wCoin'];
            $resultData = array(
                'msgAction' => cn_snippet_messages(),
                'menuTop' => cn_menuTopMoney(true),
                'countItem' => '',
                'htmlOptionNumItem' => '',
                'result' => 'Tài khoản ' . $accoutID . ' có <b class="cRed">' . number_format($showMoney, 0, ',', '.') . ' WcoinP </b>'
            );

            header('Content-Type: application/json');
            return json_encode($resultData);
        }
    }

    $showConfigVpoint = '- Tỷ lệ: <strong> 1 Gcoin</strong><i> = </i><strong>1 Wcoin</strong>';
    cn_assign('options, strInfoMoney, showConfigVpoint, optionBuyZen', 'Gcoin', $strInfoMoney, $showConfigVpoint, '');
    echo_header_web('-@my_blank_money/style.css@my_blank_money/sendAjaxJewel.js', "Ngân hàng | Tiền tệ - Gcoin sang Wcoin");
    echo_content_here(exec_tpl('my_blank_money/transBlank'), cn_snippet_bc_re());
    echo_footer_web();
}

function blank_money_transgc2wcp()
{
    $showBlank = view_bank($accoutID = $_SESSION['user_Gamer']);

    $rootVpoint = $showBlank[0]['vp'];
    $rootGcoin = $showBlank[0]['gc'];

    $strInfoMoney = 'Tài khoản ' . $accoutID . ' có <b class="cRed">' . number_format($showBlank[0]['wCoinP'], 0, ',', '.') . ' WcoinP </b>';

    if (request_type('POST')) {
        if (REQ('action_transBlank')) {
            cn_dsi_check(true);
            $errors_false = false;
            list($postNumberItem) = GET('numberItem', 'GPG');

            $postNumberItem = intval($postNumberItem);

            if ($postNumberItem > MAX_TRANS) {
                cn_throw_message('Hạn mức giao dịch tối đa là  2 tỷ.', 'e');
                $errors_false = true;
            }
            if (empty($rootGcoin)) {
                cn_throw_message('Tài khoản ' . $accoutID . ' không Gcoin trong ngân hàng.', 'e');
                $errors_false = true;
            }
            if ($postNumberItem <= 0) {
                cn_throw_message('Tài khoản ' . $accoutID . ' chưa nhập số Gcoin cần chuyển sang WcoinP.', 'e');
                $errors_false = true;
            }

            if ($postNumberItem > $rootGcoin) {
                cn_throw_message('Tài khoản ' . $accoutID . ' có tối đa ' . number_format($rootGcoin, 0, ',', '.') . ' Gcoin.', 'e');
                $errors_false = true;
            }

            list($verifyCaptcha) = GET('verifyCaptcha', 'GPG');
            if ($verifyCaptcha != $_SESSION['captcha_web']) {
                cn_throw_message("Captcah không đúng.", 'e');
                $errors_false = true;
            }

            if (!$errors_false) {
                $acountID = $_SESSION['user_Gamer'];
                do_update_orther("UPDATE MEMB_INFO SET gcoin=gcoin-$postNumberItem, wCoinP=wCoinP+$postNumberItem WHERE memb___id='$acountID'");

                cn_throw_message("Bạn đã chuyển " . number_format($postNumberItem, 0, ",", ".") . " Gcoin sang " . number_format($postNumberItem, 0, ',', '.') . " WcoinP thành công!");

                //Ghi vào Log
                $afterVpoint = $rootVpoint;
                $afterGcoin = $rootGcoin - $postNumberItem;
                $content = "$accoutID đã chuyển " . number_format($postNumberItem, 0, ",", ".") . " Gcoin thành  " . number_format($postNumberItem, 0, ',', '.') . ' WcoinP.';
                $Date = date("h:iA, d/m/Y", ctime());
                $checkDir = makeDirs($files = MODULE_ADM . "/log/modules/money");
                if ($checkDir) {
                    $file = $files . "/log_transgc2wcp.log";
//                    $file = MODULE_ADM . "/log/modules/money/log_transgc2wcp.log";
                    cn_touch($file);
                    $fileContents = file_get_contents($file);
                    file_put_contents($file, $accoutID . "|" . $content . "|" . $showBlank[0]['gc'] . "_" . $showBlank[0]['vp'] . "|" . $afterGcoin . "_" . $afterVpoint . "|" . $Date . "|\n" . $fileContents);
                }
                //End Ghi vào Log
            }

            $showMoney = (!$errors_false) ? ($showBlank[0]['wCoinP'] + $postNumberItem) : $showBlank[0]['wCoinP'];

            $resultData = array(
                'msgAction' => cn_snippet_messages(),
                'menuTop' => cn_menuTopMoney(true),
                'countItem' => '',
                'htmlOptionNumItem' => '',
                'result' => 'Tài khoản ' . $accoutID . ' có <b class="cRed">' . number_format($showMoney, 0, ',', '.') . ' WcoinP </b>'
            );

            header('Content-Type: application/json');
            return json_encode($resultData);
        }
    }
    $showConfigVpoint = '- Tỷ lệ: <strong> 1 Gcoin</strong><i> = </i><strong>1 WcoinP</strong>';

    cn_assign('options, strInfoMoney, showConfigVpoint, optionBuyZen', 'Gcoin', $strInfoMoney, $showConfigVpoint, '');
    echo_header_web('-@my_blank_money/style.css@my_blank_money/sendAjaxJewel.js', "Ngân hàng | Tiền tệ - Gcoin sang WcoinP");
    echo_content_here(exec_tpl('my_blank_money/transBlank'), cn_snippet_bc_re());
    echo_footer_web();
}

function blank_money_transgc2gob()
{
    $showBlank = view_bank($accoutID = $_SESSION['user_Gamer']);

    $rootVpoint = $showBlank[0]['vp'];
    $rootGcoin = $showBlank[0]['gc'];

    $strInfoMoney = 'Tài khoản ' . $accoutID . ' có <b class="cRed">' . number_format($showBlank[0]['goblinCoin'], 0, ',', '.') . ' GoblinCoin </b>';

    if (request_type('POST')) {
        if (REQ('action_transBlank')) {
            cn_dsi_check(true);
            $errors_false = false;
            list($postNumberItem) = GET('numberItem', 'GPG');

            $postNumberItem = intval($postNumberItem);

            if (empty($rootGcoin)) {
                cn_throw_message('Tài khoản ' . $accoutID . ' không Gcoin trong ngân hàng.', 'e');
                $errors_false = true;
            }
            if ($postNumberItem <= 0) {
                cn_throw_message('Tài khoản ' . $accoutID . ' chưa nhập số Gcoin cần chuyển sang GoblinCoin.', 'e');
                $errors_false = true;
            }

            if ($postNumberItem > MAX_TRANS) {
                cn_throw_message('Hạn mức giao dịch tối đa là  2 tỷ.', 'e');
                $errors_false = true;
            }
            if ($postNumberItem > $rootGcoin) {
                cn_throw_message('Tài khoản ' . $accoutID . ' có tối đa ' . number_format($rootGcoin, 0, ',', '.') . ' Gcoin.', 'e');
                $errors_false = true;
            }

            list($verifyCaptcha) = GET('verifyCaptcha', 'GPG');
            if ($verifyCaptcha != $_SESSION['captcha_web']) {
                cn_throw_message("Captcah không đúng.", 'e');
                $errors_false = true;
            }

            if (!$errors_false) {
                $acountID = $_SESSION['user_Gamer'];
                do_update_orther("UPDATE MEMB_INFO SET gcoin=gcoin-$postNumberItem, goblinCoin=goblinCoin+$postNumberItem WHERE memb___id='$acountID'");

                cn_throw_message("Bạn đã chuyển " . number_format($postNumberItem, 0, ",", ".") . " Gcoin sang " . number_format($postNumberItem, 0, ',', '.') . " GoblinCoin thành công!");

                //Ghi vào Log
                $afterVpoint = $rootVpoint;
                $afterGcoin = $rootGcoin - $postNumberItem;
                $content = "$accoutID đã chuyển " . number_format($postNumberItem, 0, ",", ".") . " Gcoin thành " . number_format($postNumberItem, 0, ',', '.') . ' GoblinCoin.';
                $Date = date("h:iA, d/m/Y", ctime());
                $checkDir = makeDirs($files = MODULE_ADM . "/log/modules/money");
                if ($checkDir) {
                    $file = $files . "/log_transgc2gob.log";
//                $file = MODULE_ADM . "/log/modules/money/log_transgc2gob.log";
                    cn_touch($file);
                    $fileContents = file_get_contents($file);
                    file_put_contents($file, $accoutID . "|" . $content . "|" . $showBlank[0]['gc'] . "_" . $showBlank[0]['vp'] . "|" . $afterGcoin . "_" . $afterVpoint . "|" . $Date . "|\n" . $fileContents);
                }
                //End Ghi vào Log
            }

            $showMoney = (!$errors_false) ? ($showBlank[0]['goblinCoin'] + $postNumberItem) : $showBlank[0]['goblinCoin'];

            $resultData = array(
                'msgAction' => cn_snippet_messages(),
                'menuTop' => cn_menuTopMoney(true),
                'countItem' => '',
                'htmlOptionNumItem' => '',
                'result' => 'Tài khoản ' . $accoutID . ' có <b class="cRed">' . number_format($showMoney, 0, ',', '.') . ' GoblinCoin </b>'
            );

            header('Content-Type: application/json');
            return json_encode($resultData);
        }
    }

    $showConfigVpoint = '- Tỷ lệ: <strong> 1 Gcoin</strong><i> = </i><strong>1 GoblinCoin</strong>';

    cn_assign('options, strInfoMoney, showConfigVpoint, optionBuyZen', 'Gcoin', $strInfoMoney, $showConfigVpoint, '');

    echo_header_web('-@my_blank_money/style.css@my_blank_money/sendAjaxJewel.js', "Ngân hàng | Tiền tệ - Gcoin sang GoblinCoin");
    echo_content_here(exec_tpl('my_blank_money/transBlank'), cn_snippet_bc_re());
    echo_footer_web();
}

function blank_money_muazen()
{
    $showBlank = view_bank($accoutID = $_SESSION['user_Gamer']);

    $rootVpoint = $showBlank[0]['vp'];
    $rootGcoin = $showBlank[0]['gc'];
    $rootBank = $showBlank[0]['bank'];

    if (request_type('POST')) {
        if (REQ('action_transBlank')) {
            cn_dsi_check(true);
            $errors_false = false;
            list($postNumberItem) = GET('numberItem', 'GPG');

            $postNumberItem = intval($postNumberItem);

            if (empty($rootVpoint)) {
                cn_throw_message('Tài khoản ' . $accoutID . ' không Vpoint trong ngân hàng.', 'e');
                $errors_false = true;
            }
            if ($postNumberItem <= 0) {
                cn_throw_message('Tài khoản ' . $accoutID . ' chưa nhập số lượng mua zen.', 'e');
                $errors_false = true;
            }

            if ($postNumberItem > $rootVpoint) {
                cn_throw_message('Tài khoản ' . $accoutID . ' có tối đa ' . number_format($rootVpoint, 0, ',', '.') . ' Vpoint.', 'e');
                $errors_false = true;
            }

            $arrListZen = explode('|', getOption('configBuyZen'));

            if (!in_array($postNumberItem, $arrListZen)) {
                cn_throw_message('Chức năng không được sử dụng hoặc do vấn đề coder chưa chưa xử lý.', 'e');
                goto Lable;
            }

            list($verifyCaptcha) = GET('verifyCaptcha', 'GPG');
            if ($verifyCaptcha != $_SESSION['captcha_web']) {
                cn_throw_message("Captcah không đúng.", 'e');
                $errors_false = true;
            }

            $arrZen = [500000000, 1000000000, 1500000000, 2000000000];
            $getZen = 0;
            foreach ($arrZen as $key => $item) {
                if ($arrListZen[$key] == $postNumberItem) {
                    $getZen = $item;
                    break;
                }
            }

            if (empty($getZen)) {
                cn_throw_message('Số 0 Zen không thể cập nhập vào ngân hàng', 'e');
                $errors_false = true;
            }

            if ($getZen + $rootBank > MAXBANKZEN) {
                cn_throw_message('Tài khoản ' . $accoutID . ' có thể chứa tối đa ' . number_format(MAXBANKZEN, 0, ',', '.') . ' Zen.', 'e');
                $errors_false = true;
            }


            if (!$errors_false) {
                $acountID = $_SESSION['user_Gamer'];
                do_update_orther("UPDATE MEMB_INFO SET bank=bank+$getZen, vpoint=vpoint-$postNumberItem WHERE memb___id='$acountID'");

                cn_throw_message("Bạn đã mua " . number_format($getZen, 0, ",", ".") . " Zen với " . number_format($postNumberItem, 0, ',', '.') . " Vpoint thành công!");

                //Ghi vào Log
                $afterVpoint = ($rootVpoint - $postNumberItem);
                $content = "$accoutID đã mua " . number_format($getZen, 0, ",", ".") . " Zen với " . number_format($postNumberItem, 0, ',', '.') . ' Vpoint.';
                $Date = date("h:iA, d/m/Y", ctime());
                $checkDir = makeDirs($files = MODULE_ADM . "/log/modules/money");
                if ($checkDir) {
                    $file = $files . "/log_muazen.log";
//                $file = MODULE_ADM . "/log/modules/money/log_muazen.log";
                    cn_touch($file);
                    $fileContents = file_get_contents($file);
                    file_put_contents($file, $accoutID . "|" . $content . "|" . $rootGcoin . "_" . $showBlank[0]['vp'] . "|" . $rootGcoin . "_" . $afterVpoint . "|" . $Date . "|\n" . $fileContents);
                }
                //End Ghi vào Log
            }

            Lable:
            $resultData = array(
                'msgAction' => cn_snippet_messages(),
                'menuTop' => cn_menuTopMoney(true),
                'countItem' => '',
                'htmlOptionNumItem' => '',
                'result' => ''
            );

            header('Content-Type: application/json');
            return json_encode($resultData);
        }
    }

    $showConfigVpoint = '- Mua Zen bằng Vpoint';
    cn_assign('options, strInfoMoney, showConfigVpoint, optionBuyZen', 'Zen', '', $showConfigVpoint, zenderOptionBuyZen());

    echo_header_web('-@my_blank_money/style.css@my_blank_money/sendAjaxJewel.js', "Ngân hàng | Tiền tệ - Mua Zen bằng Vpoint");
    echo_content_here(exec_tpl('my_blank_money/transBlank'), cn_snippet_bc_re());
    echo_footer_web();
}

function blank_money_transvpoint()
{
    $showBlank = view_bank($accoutID = $_SESSION['user_Gamer']);

    $rootVpoint = $showBlank[0]['vp'];
    $rootGcoin = $showBlank[0]['gc'];
    $rootBank = $showBlank[0]['bank'];
    $configTransVpoint = intval(getOption('configTransVpoint'));

    if (request_type('POST')) {
        if (REQ('action_TransVpoint2Account')) {
            cn_dsi_check(true);
            $errors_false = false;
            list($postNumberItem, $changeAccount) = GET('numberItem, changeAccount', 'GPG');

            $postNumberItem = intval($postNumberItem);
            $changeAccount = htmlentities($changeAccount);
            $vpointNew = $configTransVpoint + $postNumberItem;

            $checkResultAccount = do_select_other("SElECT memb___id FROM MEMB_INFO WHERE memb___id ='$changeAccount'");
            $newAccount = $checkResultAccount[0]['memb___id'];

            if (isset($newAccount) && $newAccount == $accoutID) {
                cn_throw_message('Tài khoản chuyển Vpoint phải khác tài khoản nhận.', 'e');
                $errors_false = true;
            }

            if (empty($newAccount)) {
                cn_throw_message('Không xác định tài khoản nhận Vpoint.', 'e');
                $errors_false = true;
            }
            if ($postNumberItem > MAX_TRANS) {
                cn_throw_message('Hạn mức giao dịch tối đa là  2 tỷ.', 'e');
                $errors_false = true;
            }

            if (empty($rootVpoint)) {
                cn_throw_message('Tài khoản ' . $accoutID . ' không Vpoint trong ngân hàng.', 'e');
                $errors_false = true;
            }
            if ($postNumberItem <= 0) {
                cn_throw_message('Tài khoản ' . $accoutID . ' chưa nhập số lượng Vpoint cần chuyển.', 'e');
                $errors_false = true;
            }

            if ($vpointNew > $rootVpoint) {
                cn_throw_message('Số Vpoint chuyển ' . number_format($postNumberItem, 0, ',', '.') . ' Vpoint phí ' . number_format($configTransVpoint, 0, ',', '.') . ' Vpoint/1L lớn hơn tổng ' . number_format($rootVpoint, 0, ',', '.') . ' Vpoint có trong ngân hàng.', 'e');
                $errors_false = true;
            }

            list($verifyCaptcha) = GET('verifyCaptcha', 'GPG');
            if ($verifyCaptcha != $_SESSION['captcha_web']) {
                cn_throw_message("Captcah không đúng.", 'e');
                $errors_false = true;
            }

            if (!$errors_false) {
                $acountID = $_SESSION['user_Gamer'];

                do_update_orther("UPDATE MEMB_INFO SET vpoint=vpoint-$vpointNew WHERE memb___id='$acountID'");
                do_update_orther("UPDATE MEMB_INFO SET vpoint=vpoint+$postNumberItem WHERE memb___id='$newAccount'");

                cn_throw_message("Bạn đã chuyển " . number_format($postNumberItem, 0, ",", ".") . " Vpoint, phí " . number_format($configTransVpoint, 0, ',', '.') . " Vpoint/1L sang tài khoản $newAccount thành công!");

                //Ghi vào Log
                $afterVpoint = ($rootVpoint - $vpointNew);
                $content = "$accoutID đã chuyển " . number_format($postNumberItem, 0, ",", ".") . " Vpoint, phí " . number_format($configTransVpoint, 0, ',', '.') . ' Vpoint/1L sang tài khoản ' . $newAccount . '.';
                $Date = date("h:iA, d/m/Y", ctime());
                $checkDir = makeDirs($files = MODULE_ADM . "/log/modules/money");
                if ($checkDir) {
                    $file = $files . "/log_chuyenvpoint.log";
//                $file = MODULE_ADM . "/log/modules/money/log_chuyenvpoint.log";
                    cn_touch($file);
                    $fileContents = file_get_contents($file);
                    file_put_contents($file, $accoutID . "|" . $content . "|" . $rootGcoin . "_" . $rootVpoint . "|" . $rootGcoin . "_" . $afterVpoint . "|" . $Date . "|\n" . $fileContents);
                }
                //End Ghi vào Log
            }

            $resultData = array(
                'msgAction' => cn_snippet_messages(),
                'menuTop' => cn_menuTopMoney(true),
                'countItem' => '',
                'htmlOptionNumItem' => '',
                'result' => ''
            );

            header('Content-Type: application/json');
            return json_encode($resultData);
        }
    }

    $showConfigTransVpoint = '- Phí: <strong> ' . number_format($configTransVpoint, 0, ',', '.') . ' Vpoint </strong><i> / </i><strong> 1L</strong>';
    cn_assign('showConfigTransVpoint', $showConfigTransVpoint);

    echo_header_web('-@my_blank_money/style.css@my_blank_money/sendAjaxJewel.js', "Ngân hàng | Tiền tệ - Chuyển Vpoint");
    echo_content_here(exec_tpl('my_blank_money/transVpoint2Account'), cn_snippet_bc_re());
    echo_footer_web();
}
