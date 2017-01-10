<?php if (!defined('BQN_MU')) die('Access restricted');

add_hook('index/invoke_module', '*relax_invoke');

//=====================================================================================================================
function relax_invoke()
{
    $relax_board = array
    (
        'relax:baucua:Csc' => 'Bầu Cua',
        'relax:baicao:Cp' => 'Bài Cáo',
        //'relax:resetvip:Ct' => 'Reset Vip'
    );

    // Call dashboard extend
    $relax_board = hook('extend_dashboard', $relax_board);

    // Exec
    $mod = REQ('mod', 'GETPOST');
    $opt = REQ('opt', 'GETPOST');

    // Top level (dashboard)
    cn_bc_add('Giải trí', cn_url_modify(array('reset'), 'mod=' . $mod));

    foreach ($relax_board as $id => $_t) {
        list($dl, $do, $acl_module) = explode(':', $id);
        if (function_exists("relax_$do"))
            cn_bc_menu($_t, cn_url_modify(array('reset'), 'mod=' . $dl, 'opt=' . $do), $do);
    }

    // Request module
    foreach ($relax_board as $id => $_t) {
        list($dl, $do, $acl_module) = explode(':', $id);

        //if (test($acl_module) && $dl == $mod && $do == $opt && function_exists("relax_$opt")) {
        if ($dl == $mod && $do == $opt && function_exists("relax_$opt")) {
            cn_bc_add($_t, cn_url_modify(array('reset'), 'mod=' . $mod, 'opt=' . $opt));
            die(call_user_func("relax_$opt"));
        }

        if ($dl == $mod && $do == $opt && !function_exists("relax_$opt")) {
            cn_bc_add('Lỗi dữ liệu', cn_url_modify(array('reset'), 'mod=' . $mod, 'opt=' . $opt));
            die(call_user_func("relax_default"));
        }
    }

    $images = array(
        'baucua' => 'baucua.png',
        'baicao' => 'baicao.png'
//        'resetvip' => 'resetvip.png',
    );

    // More dashboard images
    $images = hook('extend_dashboard_images', $images);

    foreach ($relax_board as $id => $name) {
        list($mod, $opt, $acl) = explode(':', $id, 3);

        //if (!test($acl)) {
        // unset($relax_board[$id]);
        //continue;
        //}

        $item = array(
            'name' => $name,
            'img' => isset($images[$opt]) ? $images[$opt] : 'home.gif',
            'mod' => $mod,
            'opt' => $opt,
        );

        $relax_board[$id] = $item;
    }

    cn_assign('dashboard', $relax_board);
    echoheader('-@my_relax/style.css', "Giải trí");
    echocomtent_here(exec_tpl('my_relax/general'), cn_snippet_bc_re());
    echofooter();
}

function relax_default()
{
    $arr_shop = mcache_get('.breadcrumbs');
    $name__ = array_pop($arr_shop)['name'];
    echoheader('defaults/style.css', "Error - $name__");
    echocomtent_here(exec_tpl('defaults/default'), cn_snippet_bc_re());
    echofooter();
}

function relax_baucua()
{
    $baucua_list = array(
        0 => 'Nai',
        1 => 'Bầu',
        2 => 'Gà',
        3 => 'Cá',
        4 => 'Cua',
        5 => 'Tôm'
    );

    if (request_type('POST')) {
        if (REQ('action_playbaucua')) {
            cn_dsi_check(true);
            $errors_false = false;
            $_blank_var = view_bank($accc_ = $_SESSION['user_Gamer']);
            $vpoint_ = $_blank_var[0]['vp'];

            list ($bet, $bet_0, $bet_1, $bet_2, $bet_3, $bet_4, $bet_5) = GET('bet, bet_0, bet_1, bet_2, bet_3, bet_4, bet_5', 'GPG');
            $bet = abs(intval($bet));
            $bets = array();
            $count = 0;
            $b = array();

            $man_bets = array(
                0 => intval($bet_0),
                1 => intval($bet_1),
                2 => intval($bet_2),
                3 => intval($bet_3),
                4 => intval($bet_4),
                5 => intval($bet_5)
            );
            $arrTemp = array();
            for ($i = 0; $i < 6; $i++) {
                if ($man_bets[$i] == 1) {
                    $bets[$i] = 1; // set
                    $count++; //dem so dk set
                    $b[$i] = -$bet;
                } else {
                    $bets[$i] = 0; // ko defaul =0
                    $b[$i] = 0;
                }
                $arrTemp[$i] = 0;
            }

            if ((empty($bet)) || (!is_numeric($bet)) || ($bet < 0)) {
                cn_throw_message("Bạn chưa đặt tiền.", 'e');
                $errors_false = true;
            }
            if (!preg_match('/^[0-9]+$/', $bet)) {
                cn_throw_message("Tiền đặt phải là số!", 'e');
                $errors_false = true;
            }
            if ($count == 0) {
                cn_throw_message("Bạn chưa chọn linh vật.", 'e');
                $errors_false = true;

            }
            if ($count * $bet > intval($_blank_var[0]['vp'])) {
                cn_throw_message("Bạn không đủ tiền!", 'e');
                $errors_false = true;
            }

            $result = $bet_item = "";
            if (!$errors_false) {
                $money = -($count * $bet);

                for ($i = 0; $i < 3; $i++) {
                    $item = rand(0, 5); // lay 3/6
                    $bet_item .= "<td><img src='/images/baucua/{$item}.jpg'><br>" . $baucua_list[$item] . "</td>";

                    ++$arrTemp[$item];
                    if ($bets[$item] == 1) {
                        $money += $bet * 2;
                        $b[$item] += $bet * 2;

                        if ($arrTemp[$item] > 1) {
                            $money -= $bet;
                            $b[$item] -= $bet;
                        }
                    }
                }

                for ($i = 0; $i < 6; $i++) {
                    if ($bets[$i] == 1) {
                        $result .= "<b>Bạn đã đặt {$baucua_list[$i]}</b> ";
                        $result .= "<b>";
                        if ($b[$i] > 0) {
                            $result .= "Bạn thắng {$b[$i]} Vpoint";
                        } else if ($b[$i] < 0) {
                            $result .= "Bạn thua " . abs($b[$i]) . " Vpoint";
                        } else {
                            $result .= "Hòa";
                        }
                        $result .= "</b><br>";
                    }
                }
                $isActionUpdate = false;
                $result .= "<hr><br><font color='blue' size='2'> Tổng kết : <b>";
                if ($money < 0) {
                    $result .= "Bạn thua " . abs($money) . " Vpoint";
                    $contLog = ' thua ' . abs($money) . " Vpoint";
                } else if ($money > 0) {
                    $result .= "Bạn thắng " . $money . " Vpoint";
                    $contLog = ' thắng ' . $money . " Vpoint";
                } else {
                    $result .= "Hòa";
                    $contLog = ' hòa 0 Vpoint';
                    $isActionUpdate = true;
                }
                $result .= "</b></font>";

                if (!$isActionUpdate) {
                    $update_money = $_blank_var[0]['vp'] + $money;
                    $statusUpdate = do_select_orther("UPDATE MEMB_INFO SET [vpoint]=$update_money WHERE memb___id='$accc_'");

                    //Ghi vào Log
                    $content = "$accc_ đã chơi bầu cua, kết quả " . $contLog;
                    $Date = date("h:iA, d/m/Y", ctime());
                    $file = MODULE_ADM . "/log/modules/relax/log_baucua.log";
                    $fileContents = file_get_contents($file);
                    file_put_contents($file, $accc_ . "|" . $content . "|" . $_blank_var[0]['gc'] . '_' . $vpoint_ . "|" . $_blank_var[0]['gc'] . "_" . $update_money . "|" . $Date . "|\n" . $fileContents);
                    //End Ghi vào Log
                }
            }

            $resultData = array(
                'msgAction' => cn_snippet_messages(),
                'menuTop' => cn_menuTopMoney(true),
                'bet_item' => $bet_item,
                'result' => $result
            );

            header('Content-Type: application/json');
            return json_encode($resultData);
        }
    }

    echoheader('-@my_relax/style.css@my_relax/relaxAjaxPlay.js', "Giải trí - Bầu Cua");
    echocomtent_here(exec_tpl('my_relax/baucua'), cn_snippet_bc_re());
    echofooter();
}

function relax_baicao()
{
    if (request_type('POST')) {
        if (REQ('action_playbaicao')) {
            cn_dsi_check(true);
            $errors_false = false;
            $_blank_var = view_bank($accc_ = $_SESSION['user_Gamer']);
            $vpoint_ = $_blank_var[0]['vp'];

            list ($bet) = GET('bet', 'GPG');
            $bet = abs(intval($bet));

            if ((empty($bet)) || (!is_numeric($bet)) || ($bet < 0)) {
                cn_throw_message("Bạn chưa đặt tiền.", 'e');
                $errors_false = true;
            }
            if (!preg_match('/^[0-9]+$/', $bet)) {
                cn_throw_message("Tiền đặt phải là số!", 'e');
                $errors_false = true;
            }
            if ($bet > intval($_blank_var[0]['vp'])) {
                cn_throw_message("Bạn không đủ tiền!", 'e');
                $errors_false = true;
            }

            $you = 0;
            $com = 0;
            $card_num = array();
            $card_type = array();
            $you_bacao = true;
            $cards = $result = "";

            if (!$errors_false) {

                for ($i = 0; $i < 6; $i++) {
                    do {
                        $num = rand(1, 52);
                    } while (strpos($cards, strval($num) . ",") != false);

                    $cards .= strval($num) . ",";
                }

                $list_cards = explode(",", $cards);

                for ($i = 0; $i < 3; $i++) {
                    $card_type[$i] = ($list_cards[$i] % 4) + 1;
                    $card_num[$i] = ceil($list_cards[$i] / 4);

                    if ($card_num[$i] <= 10) {
                        $you_bacao = false;
                    }

                    $you += baicao_get_card_value($card_num[$i]);
                }

                $com_bacao = true;
                for ($i = 3; $i < 6; $i++) {
                    $card_type[$i] = ($list_cards[$i] % 4) + 1;
                    $card_num[$i] = ceil(($list_cards[$i]) / 4);

                    if ($card_num[$i] <= 10) {
                        $com_bacao = false;
                    }
                    $com += baicao_get_card_value($card_num[$i]);
                }

                $you = $you % 10;
                $com = $com % 10;
                $you_have = $you . " điểm";
                $com_have = $com . " điểm";

                if ($you_bacao) {
                    $you_have = "3 Cào";
                    $you = 11;
                }

                if ($com_bacao) {
                    $com = 11;
                    $com_have = "3 Cào";
                }
                $isActionUpdate = false;
                if ($you > $com) {
                    $msg = "Bạn thắng " . $bet . " Vpoint";
                    $update_money = $_blank_var[0]['vp'] + $bet;
                } else if ($you < $com) {
                    $msg = "Bạn thua " . $bet . " Vpoint";
                    $update_money = $_blank_var[0]['vp'] - $bet;
                } else {
                    $msg = "Bạn hòa";
                    $isActionUpdate = true;
                }

                $result .= "<table class='sort-table' cellpadding='0' border='0' width=\"100%\">
                            <tr align='middle'>
                                <td valign='top' class='pd-top10'>
                                    <font color='white' class='info-per'>Máy <b>$com</b> điểm</font> <br>
                                    <img src='/images/baicao/{$card_num[3]}_{$card_type[3]}.gif' border=0>&nbsp;
                                    <img src='/images/baicao/{$card_num[4]}_{$card_type[4]}.gif' border=0>&nbsp;
                                    <img src='/images/baicao/{$card_num[5]}_{$card_type[5]}.gif' border=0>
                                </td>
                            </tr>
                            <tr align='middle'><td colspan='100' class='pd-top20 pd-bottom20'><b><font class='text-result'>$msg</font><b/></td></tr>
                            <tr align='middle'>
                                <td valign='bottom' class='pd-top20'>
                                    <font color='white' class='info-per'>Bạn <b>$you</b> điểm</font> <br>
                                    <img src='/images/baicao/{$card_num[0]}_{$card_type[0]}.gif' border=0>&nbsp;
                                    <img src='/images/baicao/{$card_num[1]}_{$card_type[1]}.gif' border=0>&nbsp;
                                    <img src='/images/baicao/{$card_num[2]}_{$card_type[2]}.gif' border=0>
                                </td>
                            </tr>
                            </table>
                ";

                if (!$isActionUpdate) {
                    do_update_orther("UPDATE MEMB_INFO SET [vpoint]=$update_money WHERE memb___id='$accc_'");

                    //Ghi vào Log
                    $content = "$accc_ đã chơi bài cáo, kết quả" . substr($msg, 4);
                    $Date = date("h:iA, d/m/Y", ctime());
                    $file = MODULE_ADM . "/log/modules/relax/log_baicao.log";
                    $fileContents = file_get_contents($file);
                    file_put_contents($file, $accc_ . "|" . $content . "|" . $_blank_var[0]['gc'] . '_' . $vpoint_ . "|" . $_blank_var[0]['gc'] . "_" . $update_money . "|" . $Date . "|\n" . $fileContents);
                    //End Ghi vào Log
                }
            }

            $resultData = array(
                'msgAction' => cn_snippet_messages(),
                'menuTop' => cn_menuTopMoney(true),
                'result' => $result
            );

            header('Content-Type: application/json');
            return json_encode($resultData);
        }
    }

    echoheader('-@my_relax/style.css@my_relax/relaxAjaxPlay.js', "Giải trí - Bài Cáo");
    echocomtent_here(exec_tpl('my_relax/baicao'), cn_snippet_bc_re());
    echofooter();
}

function baicao_get_card_value($i)
{
    if ($i > 10) {
        $i = 10;
    }

    return $i;
}