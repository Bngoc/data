<?php if (!defined('BQN_MU')) die('Access restricted');

add_hook('index/invoke_module', '*event_invoke');

//=====================================================================================================================
function event_invoke()
{
    $relax_board = array
    (
        'event:xxxxxxxxxxxxxx:Csc' => 'xxxxxxxxxxxxx',
        'event:xxxxxxxxxxxxxxx:Cp' => 'xxxxxxxxxxxxxxxxxx',
        //'event:resetvip:Ct' => 'xxxxxxxxxxxxxxxx'
    );

    // Call dashboard extend
    $relax_board = hook('extend_dashboard', $relax_board);

    // Exec
    $mod = REQ('mod', 'GETPOST');
    $opt = REQ('opt', 'GETPOST');

    // Top level (dashboard)
    cn_bc_add('Sự kiện', cn_url_modify(array('reset'), 'mod=' . $mod));

    foreach ($relax_board as $id => $_t) {
        list($dl, $do, $acl_module) = explode(':', $id);
        if (function_exists("event_$do"))
            cn_bc_menu($_t, cn_url_modify(array('reset'), 'mod=' . $dl, 'opt=' . $do), $do);
    }

    // Request module
    foreach ($relax_board as $id => $_t) {
        list($dl, $do, $acl_module) = explode(':', $id);

        //if (test($acl_module) && $dl == $mod && $do == $opt && function_exists("relax_$opt")) {
        if ($dl == $mod && $do == $opt && function_exists("event_$opt")) {
            cn_bc_add($_t, cn_url_modify(array('reset'), 'mod=' . $mod, 'opt=' . $opt));
            die(call_user_func("event_$opt"));
        }

        if ($dl == $mod && $do == $opt && !function_exists("relax_$opt")) {
            cn_bc_add('Lỗi dữ liệu', cn_url_modify(array('reset'), 'mod=' . $mod, 'opt=' . $opt));
            die(call_user_func("event_default"));
        }
    }
//
//    $images = array(
//        'baucua' => 'baucua.png',
//        'baicao' => 'baicao.png'
////        'resetvip' => 'resetvip.png',
//    );
//
//    // More dashboard images
//    $images = hook('extend_dashboard_images', $images);
//
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
//
    cn_assign('dashboard', $relax_board);
    echoheader('-@my_event/style.css', "Sự kiện");
    echocomtent_here(exec_tpl('my_event/general'), cn_snippet_bc_re());
    echofooter();
}

function event_default()
{
    $arr_shop = mcache_get('.breadcrumbs');
    $name__ = array_pop($arr_shop)['name'];
    echoheader('defaults/style.css', "Error - $name__");
    echocomtent_here(exec_tpl('defaults/default'), cn_snippet_bc_re());
    echofooter();
}

function relax_baucua()
{

    if (request_type('POST')) {
        if (REQ('action_playbaucua')) {
            cn_dsi_check(true);
            $errors_false = false;

//            if (!preg_match('/^[0-9]+$/', $bet)) {
//                cn_throw_message("Tiền đặt phải là số!", 'e');
//                $errors_false = true;
//            }
//            if ($count == 0) {
//                cn_throw_message("Bạn chưa chọn linh vật.", 'e');
//                $errors_false = true;
//
//            }
//            if ($count * $bet > intval($_blank_var[0]['vp'])) {
//                cn_throw_message("Bạn không đủ tiền!", 'e');
//                $errors_false = true;
//            }

            $result = $bet_item = "";
            if (!$errors_false) {

//                //Ghi vào Log
//                $content = "$accc_ đã chơi bầu cua, kết quả " . $contLog;
//                $Date = date("h:iA, d/m/Y", ctime());
//                $checkDir = makeDirs($files = MODULE_ADM . "/log/modules/money");
//                if ($checkDir) {
//                    $file = $files . "/log_baucua.log";
//                $file = MODULE_ADM . "/log/modules/relax/log_baucua.log";
//                cn_touch($file);
//                $fileContents = file_get_contents($file);
//                file_put_contents($file, $accc_ . "|" . $content . "|" . $_blank_var[0]['gc'] . '_' . $vpoint_ . "|" . $_blank_var[0]['gc'] . "_" . $update_money . "|" . $Date . "|\n" . $fileContents);
//               }
//                //End Ghi vào Log
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
