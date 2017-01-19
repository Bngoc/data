<?php if (!defined('BQN_MU')) die('Access restricted');

add_hook('index/invoke_module', '*transaction_invoke');

//=====================================================================================================================
function transaction_invoke()
{
    $ctrans_board = array(
        'transaction:vtc:__buy_gd:Cp' => 'Nạp thẻ VTC',
        'transaction:gate:__buy_gd:Cp' => 'Nạp thẻ Gate',
        'transaction:viettel:__buy_gd:Cp' => 'Nạp thẻ Viettel',
        'transaction:mobi:__buy_gd:Cp' => 'Nạp thẻ Mobi',
        'transaction:vina:__buy_gd:Cp' => 'Nạp thẻ Vina',
    );

    // Call dashboard extend
    $ctrans_board = hook('transaction', $ctrans_board);

    // Exec
    $mod = REQ('mod', 'GETPOST');
    $opt = REQ('opt', 'GETPOST');
    $token = REQ('token', 'GETPOST');

    cn_bc_add('Giao dịch', cn_url_modify(array('reset'), 'mod=' . $mod));

    list($vtc, $gate, $viettel, $mobi, $vina) = explode(",", getoption('napthe_list'), 5);
    $ar_list = array('vtc' => $vtc, 'gate' => $gate, 'viettel' => $viettel, 'mobi' => $mobi, 'vina' => $vina,);

    foreach ($ctrans_board as $id => $_t) {
        list($dl, $do, $_token, $acl_module) = explode(':', $id);

        if (in_array($strkey = strtolower($do), array_keys($ar_list)))
            if (empty($ar_list[$strkey])) {
                unset($ctrans_board[$id]);
                continue;
            }

        if (function_exists("transaction_$_token"))
            cn_bc_menu($_t, cn_url_modify(array('reset'), 'mod=' . $dl,'opt=' . $do, 'token=' . md5($_token . $do)), $do);
    }

    // Request module
    foreach ($ctrans_board as $id => $_t) {
        list($dl, $do, $token_, $acl_module) = explode(':', $id);
        $_token = md5($token_ . $do);
        if (test($acl_module) && $dl == $mod && $do == $opt && $token == $_token && function_exists("transaction_$token_")) {
//        if ($dl == $mod && $do == $opt && $token == $_token && function_exists("transaction_$token_")) {
            cn_bc_add($_t, cn_url_modify(array('reset'), 'mod=' . $mod, 'opt=' . $opt, 'token=' . $_token));
            die(call_user_func("transaction_$token_"));
        }
        //else{
        if ($dl == $mod && $do == $opt && $token == $_token && !function_exists("transaction_$token_")) {
            cn_bc_add('Lỗi dữ liệu', cn_url_modify(array('reset'), 'mod=' . $mod, 'opt=' . $opt, 'token=' . $_token));
            die(call_user_func("transaction_default"));
        }
    }

    $images = array(
        'vtc' => 'user.gif',
        'gate' => 'users.gif',
        'viettel' => 'options.gif',
        'mobi' => 'category.png',
        'vina' => 'template.png'
    );

    // More dashboard images
    $images = hook('extend_dashboard_images', $images);

    foreach ($ctrans_board as $id => $name) {
        list($mod, $opt, $token, $acl) = explode(':', $id, 4);

        if (!test($acl)) {
            unset($ctrans_board[$id]);
            continue;
        }

        $item = array(
            'name' => $name,
            'img' => isset($images[$opt]) ? $images[$opt] : 'home.gif',
            'mod' => $mod,
            'opt' => $opt,
            'token' => md5($token . $opt),
        );
        //$ctrans_board[$id] = $item;
        $_ctrans_board[$opt] = $item;
    }

    cn_assign('dashboard', $_ctrans_board);

    echoheader('-@my_transaction/style.css', "Nap The");
    echocomtent_here(exec_tpl('my_transaction/general'), cn_snippet_bc_re());
    echofooter();
}

function transaction_default()
{
    $arr_shop = mcache_get('.breadcrumbs');
    $name__ = array_pop($arr_shop)['name'];
    echoheader('defaults/style.css', "Error - $name__");
    echocomtent_here(exec_tpl('defaults/default'), cn_snippet_bc_re());
    echofooter();
}

function transaction___buy_gd()
{
    list($token, $opt, $sub, $page) = GET('token, opt, sub, page', 'GPG');

    $card_list = $list_item = array();

    $km_list = explode('|', getoption('km_list'));
    $pt_km = 0;
    if ($km_list[1]) {
        $pt_km = $km_list[1];
        $strKm = 'Chương trình khuyến mại mọi thẻ nạp: <span class="cRed">' . $km_list[1] . '%</span> cho bất kì mệnh giá nào.';
    } else {
        $km_listOne = explode(',', $km_list[0]);

        if($km_listOne[0]){
            $pt_km =  $km_listOne[0];
            $strKm = 'Chương trình khuyến mại thẻ nạp VTC: <span class="cRed">' . $km_listOne[0] . ' %</span> cho bất kì mệnh giá nào.';
        }elseif ($km_listOne[1]){
            $pt_km =  $km_listOne[1];
            $strKm = 'Chương trình khuyến mại thẻ nạp GATE: <span class="cRed">' . $km_listOne[1] . ' %</span> cho bất kì mệnh giá nào.';
        }elseif ($km_listOne[2]){
            $pt_km =  $km_listOne[2];
            $strKm = 'Chương trình khuyến mại thẻ nạp VIETTEL: <span class="cRed">' . $km_listOne[2] . ' %</span> cho bất kì mệnh giá nào.';
        }elseif ($km_listOne[3]){
            $pt_km =  $km_listOne[3];
            $strKm = 'Chương trình khuyến mại thẻ nạp MOBI: <span class="cRed">' . $km_listOne[3] . ' %</span> cho bất kì mệnh giá nào.';
        }elseif ($km_listOne[4]){
            $pt_km =  $km_listOne[4];
            $strKm = 'Chương trình khuyến mại thẻ nạp VINA: <span class="cRed">' . $km_listOne[4] . ' %</span> cho bất kì mệnh giá nào.';
        }else{
            $strKm = '';
        }
    }

    $page = intval($page);
    if (empty($page)) $page = 1;
    $pt_km = intval($pt_km);
    $opt = strtolower($opt);
    list($_10k, $_20k, $_30k, $_50k, $_100k, $_200k, $_300k, $_500k) = explode(",", getoption('napthe_' . $opt), 8);
    $napthe_list = array('10k' => $_10k, '20k' => $_20k, '30k' => $_30k, '50k' => $_50k, '100k' => $_100k, '200k' => $_200k, '300k' => $_300k, '500k' => $_500k);

    $arrTypeCard = [
        'viettel' => 1,
        'mobi' => 2,
        'vina' => 3,
        'gate' => 4,
        'vtc' => 5
    ];

    foreach ($napthe_list as $key => $var) {
        if ($var){
            $card_list[$key] = (int)substr($key, 0, -1) . "000";
        }
    }
    $accc_ = $_SESSION['user_Gamer'];
    $showHisrotyPlay = do_select_orther("SELECT [accountID], [Name], [menhgia], [card_type], [card_num], [card_serial], [status], [addvpoint], [timenap], [timeduyet], [teknet_status], [teknet_check_wait], [teknet_check_last], times_tamp FROM CardPhone WHERE accountID='" . $accc_ ."'");

    if (request_type('POST')) {
        if (REQ('action_historyCard')) {

            $resultData = array(
                'msgAction' => cn_snippet_messages(),
                'menuTop' => cn_menuTopMoney(true),
                'show_history' => show_historyDe($showHisrotyPlay, $page),
                'resetFrom' => 0
            );

            header('Content-Type: application/json');
            return json_encode($resultData);
        }
    }

    if (request_type('POST')) {
        if ($token == md5('__buy_gd' . $opt)) {
            cn_dsi_check(true);
            $errors_false = false;

            //* Card_type = 1 => Viettel
            //* Card_type = 2 => Mobiphone
            //* Card_type = 3 => Vinaphone
            //* Card_type = 4 => Gate
            //*Card_type = 5 => VTC
            $ctime = ctime();
            $card_type = $arrTypeCard[$opt];
            $merchant_id = intval(getoption('Merchant_ID')); // interger
            $api_user = trim(getoption('API_User')); // string
            $api_password = trim(getoption('API_Password')); // string

            list($pin, $seri, $verifyCaptcha) = GET('cardCode, cardSerial, verifyCaptcha', 'GPG');

            if (empty($card_type)) {
                cn_throw_message('Không xác nhận được loại thẻ nạp', 'e');
                $errors_false = true;
            }
            if ($verifyCaptcha != $_SESSION['captcha_web']) {
                cn_throw_message("Captcah không đúng.", 'e');
                $errors_false = true;
            }
            if (empty($merchant_id)) {
                cn_throw_message("Thiết lập hệ thống lỗi, vui lòng liên hệ với Admin.", 'e');
                $errors_false = true;
            }
            if (empty($api_user)) {
                cn_throw_message("Thiết lập hệ thống lỗi, vui lòng liên hệ với Admin.", 'e');
                $errors_false = true;
            }
            if (empty($api_password)) {
                cn_throw_message("Thiết lập hệ thống lỗi, vui lòng liên hệ với Admin.", 'e');
                $errors_false = true;
            }

            if (!$errors_false) {
                $ischeckActionUpdate = false;
                $codeErrorCard = array(
                    0 => 'Nạp thẻ thành công',
                    1 => 'Merchant_id not found',
                    2 => 'Unauthorized',
                    3 => 'Mã thẻ cào hoặc seri không chính xác',
                    4 => 'Thẻ đã sử dụng',
                    5 => 'Bạn phải nhập seri thẻ',
                    6 => 'Thẻ đã gửi sang hệ thống nhưng bị trễ',
                    7 => 'Hệ thống nạp thẻ đang bảo trì',
                    8 => 'Có lỗi xảy ra trong quá trình nạp thẻ.Liên hệ Gamebank',
                    9 => 'Thẻ không sử dụng được',
                    10 => 'Nhập sai định dạng thẻ',
                    11 => 'Nhập sai quá 3 lần',
                    12 => 'Lỗi hệ thống.Liên hệ Gamebank',
                    13 => 'IP không được phép truy cập sau 5 phút',
                    14 => 'Tên đăng nhập không đúng',
                    15 => 'Loại thẻ không đúng',
                    16 => 'Mã thẻ viettel phải có 13 chữ số',
                    17 => 'Seri viettel phải có 11 chữ số',
                    18 => 'Mã thẻ mobiphone phải có 12 hoặc 14 số',
                    19 => 'Seri mobiphone phải là 1 dãy số',
                    20 => 'Mã thẻ vinaphone phải có 12 hoặc 14 số',
                    21 => 'Mã thẻ gate có 10 số và seri có 10 ký tự gồm chữ và số',
                    22 => 'Thẻ đã nạp sang hệ thống, không nạp nữa',
                    23 => 'Sai thông tin partner',
                    24 => 'Chưa nhận được kết quả trả về từ nhà cung cấp mã thẻ',
                    25 => 'Dữ liệu truyền vào không đúng',
                    26 => 'Nhà cung cấp không tồn tại',
                    27 => 'Sai IP',
                    28 => 'Sai session',
                    29 => 'Session hết hạn',
                    30 => 'Hệ thống bận, nạp lại sau ít phút',
                    31 => 'Tạm thời khóa kênh nạp VMS do quá tải',
                    32 => 'Trùng giao dịch, nạp lại sau ít phút',
                    33 => 'Seri hoặc mã thẻ không đúng',
                    34 => 'Card tạm thời bị khóa trong 24h',
                    35 => 'Mã thẻ và Mã seri phải có 12 ký tự gồm chữ và số',
                    36 => 'Tài khoản của bạn chưa thiết lập IP hoặc chưa được duyệt',
                    37 => 'IP hiện tại không thuộc sở hữu hoặc trong danh sách cho phép của bạn',
                    38 => 'Thẻ VTC không còn được hỗ trợ',
                    39 => 'Thẻ đang bảo trì!',
                    40 => 'Tài khoản của bạn đang bị khóa!',
                    -1 => 'Thẻ đã sử dụng',
                    -2 => 'Thẻ đã bị khóa',
                    -3 => 'Thẻ hết hạn sử dụng',
                    -4 => 'Thẻ chưa kích hoạt',
                    -5 => 'Giao dịch không hợp lệ',
                    -6 => 'Mã thẻ và số Serial không khớp',
                    -8 => 'Cảnh báo số lần giao dịch lỗi của một tài khoản',
                    -9 => 'Thẻ thử quá số lần cho phép',
                    -10 => 'Mã seri không hợp lệ',
                    -11 => 'Mã thẻ không hợp lệ',
                    -12 => 'Thẻ không tồn tại hoặc đã sử dụng',
                    -13 => 'Sai cấu trúc Description',
                    -14 => 'Mã dịch vụ không tồn tại',
                    -15 => 'Thiếu thông tin khách hàng',
                    -16 => 'Mã giao dịch không hợp lệ',
                    -90 => 'Sai tên hàm',
                    -98 => 'Giao dịch thất bại do Lỗi hệ thống',
                    -99 => 'Giao dịch thất bại do Lỗi hệ thống',
                    -999 => 'Hệ thống tạm thời bận',
                    -100 => 'Giao dịch nghi vấn'
                );

                $gb_api = new GB_API();
                $gb_api->setMerchantId($merchant_id);
                $gb_api->setApiUser($api_user);
                $gb_api->setApiPassword($api_password);
                $gb_api->setPin($pin);
                $gb_api->setSeri($seri);
                $gb_api->setCardType(intval($card_type));
                $gb_api->setNote("username accname"); // ghi chu giao dich ben ban tu sinh
                $gb_api->cardCharging();

                $code = intval($gb_api->getCode());
                $info_card = intval($gb_api->getInfoCard());

                $vpointAdd = $info_card * $pt_km * 0.01 + $info_card;
                $resultCodeApi = 1;

echo $code .'<br>';
echo $info_card .'<br>';
echo $gb_api->getMsg() .'<br>';
echoArr($gb_api); die;
                // nap the thanh cong
                if ($code === 0 && $info_card >= 10000) {
                    $ischeckActionUpdate = true;
//                    echo json_encode(array('code' => 0, 'msg' => "Nạp thẻ thành công mệnh giá " . $info_card));
                } else {
                    // get thong bao loi
//                    echo json_encode(array('code' => 1, 'msg' => $gb_api->getMsg()));
                }


                if (!$ischeckActionUpdate) {

                    $showMoneyBank = view_bank($accc_);
                    $moneyAfter = $showMoneyBank[0]['vp'] + $vpointAdd;
                    do_update_character(
                        'CardPhone',
                        '[accountID]=\'' . $accc_ . '\'',
                        //[Name]
                        '[menhgia]=' . $info_card,
                        '[card_type]=\'' . $opt . '\'',
                        '[card_num]=\'' . $pin . '\'',
                        '[card_serial]=\'' . $seri . '\'',
                        '[addvpoint]=' . $vpointAdd,
                        '[timenap]\'=\'' . date('Y-m-d H:i:s', $ctime),
                        'times_tamp=' . $ctime
                    //      ,[status]
//      ,[timeduyet]
//      ,[teknet_status]
//      ,[teknet_check_wait]
//      ,[teknet_check_last]
//      ,[card_num_md5],

                    );

                    do_update_character(
                        'DoanhThu',
                        '[timeCard]=\'' . date('Y-m-d H:i:s', $ctime),
                        '[money]=' . $info_card,
                        '[card_type]=\'' . $opt . '\''
                    );

                    // Ghi vào Log
                    $content = "$accc_ đã nạp thẻ " . ucfirst($opt) . " mệnh giá: " . number_format($info_card, 0, ",", ".") . " VND, Serial: $seri , Số Vpoint: " . number_format($vpointAdd, 0, ",", ".") . " , Tình trạng: <span class=\"cRed\">" . $codeErrorCard[$resultCodeApi] . "</span>";
                    $Date = date("h:iA, d/m/Y", ctime());
                    $checkDir = makeDirs($files = MODULE_ADM . "/log/modules/napthe");
                    if ($checkDir) {
                        $file = $files . "/log_" . $opt . ".log";
//                    $file = MODULE_ADM . "/log/modules/log_" . $opt . ".log";
                        cn_touch($file);
                        $fileContents = file_get_contents($file);
                        file_put_contents($file, $accc_ . "|" . $content . "|" . $showMoneyBank[0]['gc'] . '_' . $showMoneyBank[0]['vp'] . "|" . $showMoneyBank[0]['gc'] . "_" . $moneyAfter . "|" . $Date . "|\n" . $fileContents);
                    }
                    // End Ghi vào Log

                    cn_throw_message($content);

                    $showHisrotyAdd['AccountID'] = $accc_;
                    $showHisrotyAdd['WriteDe'] = $numberDe;
                    $showHisrotyAdd['timestamp'] = date('Y-m-d H:i:s', $time);
                    $showHisrotyAdd['Action'] = 1;
                    $showHisrotyAdd['Vpoint'] = $moneyVpDe;
                    $showHisrotyAdd['Result'] = 0;
                    array_unshift($showHisrotyPlay, $showHisrotyAdd);
                }
            }

            $resultData = array(
                'msgAction' => cn_snippet_messages(),
                'menuTop' => cn_menuTopMoney(true),
                'show_history' => zenderHtmlTableHistoryCard($showHisrotyPlay, $page),
                'resetFrom' => (!$errors_false) ? 1 : 0
            );

            header('Content-Type: application/json');
            return json_encode($resultData);
        }
    }

    $arr_shop = mcache_get('.breadcrumbs');
    $name_shop = array_pop($arr_shop)['name'];

    cn_assign('list_item, token, opt', $list_item, $token, $opt);
    cn_assign('card_list, strKm, pt_km, show_history', $card_list, $strKm, $pt_km, zenderHtmlTableHistoryCard($showHisrotyPlay, $page));

    echoheader('-@my_transaction/style.css@my_transaction/cardAjax.js', "Giao dịch $name_shop - $name_shop");
    echocomtent_here(exec_tpl('my_transaction/napthe'), cn_snippet_bc_re());
    echofooter();
}

function zenderHtmlTableHistoryCard($dataHistory, $page)
{
    $url = cn_url_modify(array('reset'), 'mod=relax', 'opt=xoso', 'action_historyCard=1', 'page', 'per_page');
    $per_page = 20;
    if (empty($page)) $page = 1;
    list ($resultShowData, $pagination) = cn_arr_paginaAjax($dataHistory, $url, $page, $per_page);

    if (empty($resultShowData)) return '';

    $html = '<table class="ranking" width="100%">
            <tr>
                <th class="lbg">#</th>
                <th>Loại thẻ</th>
                <th>Mã thẻ</th>
                <th>Serial</th>
                <th>Vpoint</th>
                <th>Ngày nạp</th>
                <th class="rbg"><span>Tình trạng</span></th>
            </tr>';

//if (!is_array($cardphone) && !is_object($cardphone)) settype($cardphone, 'array'); foreach ($cardphone as $cardphone){}
    if ($dataHistory) {
        foreach ($dataHistory as $key => $items) {
//            $makerTime = date_create(trim($items['timestamp']));
//            $tempTime = date_format($makerTime, 'l, Y-m-d H:i:s');
//            $checkResult = $items['Result'];
//            if ($checkResult == 1) {
//                $strResult = '<span class="cBlue"> Trúng </span>';
//            } elseif ($checkResult == 2) {
//                $strResult = '<span class="cRed"> Không trúng </span>';
//            } else {
//                $strResult = '---';
//            }

            $html .= '<tr><td>' . ($key + 1) . '</td>';
            $html .= '<td>' . ucfirst($items['card_type']) . '</td>';
            $html .= '<td>' . trim($items['card_num']) . '</td>';
            $html .= '<td>' . trim($items['card_serial']) . '</td>';
            $html .= '<td>' . number_format(intval($items['addvpoint']), 0, ',', '.') . '</td>';
//            $html .= '<td>' . number_format($items['Vpoint'], 0, ',', '.') . '</td>';
            $html .= '<td>' . date('l, d-m-Y H:i:A', $items['times_tamp']) . '</td>';
            $html .= '<td>' . 0 . '</td></tr>';
        }
    }
    $html .= '</table>';
    $html .= '<div class="clear"></div>';
    $html .= '<div class="right">' . $pagination . '</div>';

    $html .= '</table>';

    return $html;
}