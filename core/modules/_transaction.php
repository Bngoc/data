<?php if (!defined('BQN_MU')) die('Access restricted');

add_hook('index/invoke_module', '*transaction_invoke');

//=====================================================================================================================
function transaction_invoke()
{
    $ctrans_board = array
    (
        'transaction:Vtc:__buy_gd:Csc' => 'Nạp thẻ VTC',
        'transaction:Gate:__buy_gd:Cp' => 'Nạp thẻ Gate',
        'transaction:Viettel:__buy_gd:Ciw' => 'Nạp thẻ Viettel',
        'transaction:Mobi:__buy_gd:Cg' => 'Nạp thẻ Mobi',
        'transaction:Vina:__buy_gd:Cb' => 'Nạp thẻ Vina',
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
            if (!$ar_list[$strkey]) {
                unset($ctrans_board[$id]);
                continue;
            }

        if (function_exists("transaction_$_token"))
            cn_bc_menu($_t, cn_url_modify(array('reset'), 'mod=' . $dl, 'token=' . md5($acl_module . $_token . $do), 'opt=' . $do), $do);
    }

    // Request module
    foreach ($ctrans_board as $id => $_t) {
        list($dl, $do, $token_, $acl_module) = explode(':', $id);
        $_token = md5($acl_module . $token_ . $do);
        //if (test($acl_module) && $dl == $mod && $do == $opt && function_exists("dashboard_$opt"))
        if ($dl == $mod && $do == $opt && $token == $_token && function_exists("transaction_$token_")) {
            cn_bc_add($_t, cn_url_modify(array('reset'), 'mod=' . $mod, 'token=' . $_token, 'opt=' . $opt));
            die(call_user_func("transaction_$token_"));
        }
        //else{
        if ($dl == $mod && $do == $opt && $token == $_token && !function_exists("transaction_$token_")) {
            cn_bc_add('Lỗi dữ liệu', cn_url_modify(array('reset'), 'mod=' . $mod, 'token=' . $_token, 'opt=' . $opt));
            die(call_user_func("transaction_default"));
        }
    }

    echoheader('-@my_char/style.css', "Character");

    $images = array
    (
        'personal' => 'user.gif',
        'userman' => 'users.gif',
        'sysconf' => 'options.gif',
        'category' => 'category.png',
        'templates' => 'template.png',
        'backup' => 'archives.gif',
        'archives' => 'arch.png',
        'media' => 'images.gif',
        'intwiz' => 'wizard.gif',
        'logs' => 'list.png',
        'selfchk' => 'check.png',
        'ipban' => 'block.png',
        'widgets' => 'widgets.png',
        'wreplace' => 'replace.png',
        'morefields' => 'more.png',
        'maint' => 'settings.png',
        'group' => 'group.png',
        'locale' => 'locale.png',
        'script' => 'script.png',
        'comments' => 'comments.png',
    );

    // More dashboard images
    $images = hook('extend_dashboard_images', $images);

    foreach ($ctrans_board as $id => $name) {
        list($mod, $opt, $token, $acl) = explode(':', $id, 4);

        if (!test($acl)) {
            unset($ctrans_board[$id]);
            continue;
        }

        $item = array
        (
            //'name' => i18n($name),
            'name' => $name,
            'img' => isset($images[$opt]) ? $images[$opt] : 'home.gif',
            'mod' => $mod,
            'opt' => $opt,
            'token' => md5($acl . $token . $opt),
        );

        //$ctrans_board[$id] = $item;
        $_ctrans_board[$opt] = $item;
    }


    //cn_character();
    $member = member_get();

    //$meta_draft = db_index_meta_load('draft');
    //$drafts =isset($meta_draft['locs'])? intval(array_sum($meta_draft['locs'])):false;

    //if ($drafts && test('Cvn'))
    //{
    //$greeting_message = i18n('News in draft: %1', '<a href="'.cn_url_modify('mod=editnews', 'source=draft').'"><b>'.$drafts.'</b></a>');
    //}
    //else
    //{
    //$greeting_message = i18n('Have a nice day!');
    //}

    //$nameset = $accc_;


    $greeting_message = 'Have a nice day!';
    //cn_assign('dashboard, username, greeting_message', $dashboard, $member['name'], $greeting_message);
    cn_assign('dashboard, username, greeting_message', $_ctrans_board, $member['user_name'], $greeting_message);

    //echo exec_tpl('header');
    //echo exec_tpl('my_dashboard/general');
    echocomtent_here(exec_tpl('my_transaction/general'), cn_snippet_bc_re());
    echofooter();
}

function transaction_default()
{
    $arr_shop = mcache_get('.breadcrumbs');
    $name__ = array_pop($arr_shop)['name'];
    echoheader('my_char/style.css', "Error - $name__");
    echocomtent_here(exec_tpl('my_char/default'), cn_snippet_bc_re());
    echofooter();
}

function transaction___buy_gd()
{

    //$opt = REQ('opt', 'GETPOST');
    list($page, $per_page, $token, $opt, $sub) = GET('page, per_page, token, opt, sub', 'GPG');

    $page = intval($page);
    if (!$page) $page = 0;
    //if (intval($per_page) == 0) $per_page = 15;
    //if ($opt == 'eventticket' || $opt == 'orther') $per_page = 21;

    $card_list = $list_item = array();
    //$item_ = getoption('napthe_'.strtolower($opt));

    list($_10k, $_20k, $_30k, $_50k, $_100k, $_200k, $_300k, $_500k) = explode(",", getoption('napthe_' . strtolower($opt)), 8);
    $napthe_list = array('10k' => $_10k, '20k' => $_20k, '30k' => $_30k, '50k' => $_50k, '100k' => $_100k, '200k' => $_200k, '300k' => $_300k, '500k' => $_500k);

    //$get = getoption('napthe_'.strtolower($opt));
    print_r($napthe_list);

    foreach ($napthe_list as $key => $var) {

        if ($var) $card_list[$key] = substr($key, 0, -1) . "000";
    }


    if ($item_)
        foreach ($item_ as $key => $var) {
            $list_item[$key] = cn_item_info($var['code32'], $var['name'], $var['price'], $var['image_mh']);
        }
    $member = member_get();
    $accc_ = $member['user_name'];

    /// kiem tra khi character open warehouse => ???????????
    if (request_type('POST')) {
        if ($token == md5('__buy_s1' . $opt) && $id_item = REQ('Item')) {

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
                    $warehouse_ = do_select_character('warehouse', $arr_cls = 'Items', "AccountID='$accc_'");
                    $warehouse = substr(strtoupper(bin2hex($warehouse_[0][0])), 0, 3840);
                    $item_code = $list_item[$id_item]['code32'];

                    echo "171 warehouse_ > " . $warehouse . " <br>";
                    echo "166 name_ = $name_ price_ =$price_  token = $token -> id_item = $id_item <br>";

                    if ($opt == "armor") {
                        for ($i = 7; $i <= 11; $i++) {
                            $serial = do_select_orther('EXEC WZ_GetItemSerial');
                            $str_replace_begin = 6 + (8 - strlen($serial_n = $serial[0][0]));
                            $item_code = substr_replace($item_code, $serial_n, $str_replace_begin, -18);
                            $item_code = substr_replace($item_code, dechex($i * 16), 18, 2);
                            $leng_item_code = strlen($item_code);
                            $item_data = GetCode($item_code);
                            if (($item_data['id'] == 15 || $item_data['id'] == 20 || $item_data['id'] == 23 || $item_data['id'] == 32 || $item_data['id'] == 37 || $item_data['id'] == 47 || $item_data['id'] == 48) && ($i == 7)) {
                                continue;
                            } else {
                                $items = $items_data[$item_data['group'] . "." . $item_data['id']];
                                if (!$items) {
                                    //cn_throw_message("[Error - line 251] Gặp sự cố trên Server. Vui thông báo cho admin",'e');
                                    //$errors_false = true;
                                    msg_info('[Error - line 251] Gặp sự cố trên Server. Vui thông báo cho admin.', cn_url_modify(array('reset'), 'mod=' . REQ('mod'), 'token=' . REQ('token'), 'opt=' . REQ('opt')));
                                }
                                $slot = CheckSlotWarehouse($warehouse, $items['X'], $items['Y']);

                                echo "<br><br><br><br>217 slot => " . $slot . " <br>";
                                if ($slot == 3840) {
                                    cn_throw_message("Không đủ chỗ trống trong Hòm đồ", 'e');
                                    $errors_false = true;
                                } else $warehouse = substr_replace($warehouse, $item_code, $slot * 32, $leng_item_code);
                            }
                        }
                    } else {
                        $serial = do_select_orther('EXEC WZ_GetItemSerial');
                        $str_replace_begin = 6 + (8 - strlen($serial_n = $serial[0][0]));
                        $item_code = substr_replace($item_code, $serial_n, $str_replace_begin, -18);
                        $leng_item_code = strlen($item_code);
                        $item_data = GetCode($item_code);
                        $items = $items_data[$item_data['group'] . "." . $item_data['id']];
                        if (!$items) {
                            //cn_throw_message("[Error - line 251] Gặp sự cố trên Server. Vui thông báo cho admin",'e');
                            //$errors_false = true;
                            msg_info('[Error - line 251] Gặp sự cố trên Server. Vui thông báo cho admin.', cn_url_modify(array('reset'), 'mod=' . REQ('mod'), 'token=' . REQ('token'), 'opt=' . REQ('opt')));
                        }
                        $slot = CheckSlotWarehouse($warehouse, $items['X'], $items['Y']);
                        if ($slot == 3840) {
                            cn_throw_message("Không đủ chỗ trống trong Hòm đồ", 'e');
                            $errors_false = true;
                        } else $warehouse = substr_replace($warehouse, $item_code, $slot * 32, $leng_item_code);
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
                $file = MODULE_ADM . "/log/modules/log_" . $opt . ".txt";
                $fp = fopen($file, "a+");
                fputs($fp, $accc_ . "|" . $content . "|" . $vp_ . "|" . $check . "|" . $Date . "|\n");
                fclose($fp);
                //End Ghi vào Log

                cn_throw_message("Bạn đã mua thành công $name_ với giá " . number_format($price_, 0, ",", ".") . " V.Point.");
            }
        }
    }

    $arr_shop = mcache_get('.breadcrumbs');
    $name_shop = array_pop($arr_shop)['name'];


    cn_assign('list_item, token, opt', $list_item, $token, $opt);
    cn_assign('per_page, card_list', $per_page, $card_list);

    echoheader('my_char/style.css', "Giao dịch $name_shop - $name_shop");                                //???????????????????
    echocomtent_here(exec_tpl('my_transaction/napthe'), cn_snippet_bc_re());
    echofooter();
}
/*
function shop___what_(){
	$member = member_get();$accc_ = $member['user_name'];
	$warehouse_ = do_select_character('warehouse','Items,Money,pw,AccountID',"AccountID='$accc_'");
	
	$item_list = substr(strtoupper(bin2hex($warehouse_[0][0])), 0, 3840);
	$money = $warehouse_[0][1];
	$password = $warehouse_[0][2];
	//$accountid_ = $warehouse_[0][3]; //??
	
	$show_warehouse = "<div id='warehouse' style='width:282px; margin:0px auto; padding-top:57px; padding-left:25px; height:628px; background-image: url(images/warehouse.jpg)'>";
	$i = -1;
	$x = -1;
	
	while ( $i < 119 ) {
		$i++;
		$x++;
		if ( $x == 8 ) $x = 0;	
		$item32 = cn_item_info(substr($item_list, $i*32,32),'','','');
		if(!$item32) continue;
		
		if($item32['name']){
			if (!$item32['y']) $itemy = 1;
			else $itemy = $item32['y'];
			
			if (!$item32['x']) $itemx = 1;
			else $itemx = $item32['x'];
			
			$show_warehouse .= "<div style='margin-top:".(floor($i/8)*32)."px; 
											margin-left:".($x*32)."px; position:absolute;
											width:".($itemx*32)."px; height:".($itemy*32)."px;
											cursor:pointer; background-image: url(images/wh_bg_on.jpg);'>
									<img src='images/items/".$item32['image'].".gif' 
											style=\"height:".(32*$itemy-$itemy-1)."px;
											width:".(32*$itemx)."px;\" 
											onMouseOut='UnTip()' onMouseOver=\"topxTip(document.getElementById('iditem".$i."').innerHTML)\">
								</div>";
			$show_warehouse .= "<div class='floatcontainer forumbit_nopost' id='iditem$i' style='display:none;background: rgba(0, 128, 0, 0.15);'>'".$item32['info']."'</div>";
					
		//onmouseover="topxTip(document.getElementById('tip_10261').innerHTML)" onmouseout="UnTip()"
		//onMouseOut='hidetip()' onMouseOver=\"showtip('".$item32['info']."')\">
		}
	}
	
	if ( $password != NULL AND $password != 0 ) $wwname = "<font color='#A42725'>Hòm đồ (Đóng)</font>";
	else $wwname = "<font color='#ffffff'>Hòm đồ (Mở)</font>";
	if ( $money < 100000) $color = "#F7DDAA";
	else if ( $money >= 100000 and $money < 1000000 ) $color	= "#3CA445";
	else if ( $money >= 1000000 and $money < 10000000 ) $color = "#D2A154";
	else $color = "#A42725";
	
	$show_warehouse	.=	"<div style='margin-top:-42px; position:absolute; text-align:center; width:256px; border:0px;'>".$wwname."</div>";
	$show_warehouse	.=	"<div id='zzen2' style='margin-top:100px; margin-left:-20px; position:absolute; border:0px; width:0px; height:0px;'></div>";
	$show_warehouse	.=	"<div align=right style='position:absolute; color:".$color."; margin-top:502px; width:200px; margin-right:37px; margin-left:50px; border:0px;'>".$money."</div>";
	//$show_warehouse	.=	"<div style='margin-top:565px; margin-left:36px; position:absolute; width:57px; cursor:pointer; height:47px;'><img alt='Rút Zen' onmousemove='return overlib(\"Rút Zen từ Hòm đồ\");' onclick='get_zen2(\"1\")' onmouseout='return nd();' src='images/insert_zen.jpg'></div>";
	//$show_warehouse	.=	"<div style='margin-top:565px; margin-left:100px; position:absolute; width:59px; cursor:pointer; height:47px;'><img alt='Gửi Zen' onmousemove='return overlib(\"Gửi Zen vào Hòm đồ\");' onclick='get_zen2(\"2\")' onmouseout='return nd();' src='images/get_zen.jpg'></div>";
	$show_warehouse	.=	"<div style='margin-top:565px; margin-left:36px; position:absolute; width:57px; height:47px;'><img src='images/insert_zen.jpg'></div>";
	$show_warehouse	.=	"<div style='margin-top:565px; margin-left:100px; position:absolute; width:59px; height:47px;'><img src='images/get_zen.jpg'></div>";
	
	if ( $password != NULL AND $password != 0 ) {
		$type = 1;
		$echo_t = "Mở khóa Hòm đồ";
		$imgl = "images/lock_on.jpg";
	}
	else {
		$type = 0;
		$echo_t = "Khóa Hòm đồ";
		$imgl = "images/lock_off.jpg";
	}
	//$show_warehouse	.=	"<div style='margin-top:565px; margin-left:166px; position:absolute; width:57px; cursor:pointer; height:47px;'><img alt='Lock' onmousemove='return overlib(\"".$echo_t."\");' onmouseout='return nd();' onclick='lock_t2(\"".$type."\");' src='".$imgl."'></div>";
	$show_warehouse	.=	"<div style='margin-top:565px; margin-left:166px; position:absolute; width:57px; height:47px;'><img src='".$imgl."'></div>";
	$show_warehouse	.=	"</div>";

	//echo $show_warehouse;
	cn_assign('show_warehouse', $show_warehouse);
	
	echoheader('my_char/style.css', "Thùng đồ - Warehouse"); 								//???????????????????
	echocomtent_here(exec_tpl('my_cashshop/_warehouse'), cn_snippet_bc_re());
	echofooter();
}

/*
function shop_acient(){
	$opt = REQ('opt', 'GETPOST');
	$list_item = array();
	$item_ = getoption('#item_shop'.$opt);	//'code32' - 'name'  - 'price' - 'image_mh'
	foreach($item_ as $ak => $var){
		echo "150 opt = $opt -> $ak => $var[code32]-> $var[name] -> $var[price] -> $var[image_mh] <br>";
	
		$list_item[] = cn_item_info($var['code32'], $var['name'], $var['price'], $var['image_mh']);
	}
	cn_assign('item_', $list_item);
	echoheader('my_char/style.css', "Error"); 								//???????????????????
	echocomtent_here(exec_tpl('my_cashshop/_acient'), cn_snippet_bc_re());
	echofooter();
}
function shop_armor(){
	$opt = REQ('opt', 'GETPOST');
	$item_ = getoption('#item_shop'.$opt);
	$arr_trust = cn_point_trust();
	$showchar = cn_character();

	foreach($showchar as $od => $do){
		if(!empty($od)){
			
			if($do['point'] > 0) $do_10 = "<a href =". cn_url_modify('mod=cshop_', 'opt=addpoint','sub='.$od)." title='cộng Point'>". number_format($do['point'],0,",",".")."</a>"; else $do_10 = $do['point'];
			if($do['point_dutru'] > 0) $do_11 = "<a href =".cn_url_modify('mod=cshop_', 'opt=subpoint','sub='.$od)." title='rút Point'>". number_format($do['point_dutru'],0,",",".")."</a>"; else $do_11 = $do['point_dutru'];
			
			if($do['status_off']) $do_12_20 = "<a href =".cn_url_modify('mod=cshop_', 'opt=offline','sub='.$od)." title='Đang ủy thác Offline'><img src='". URL_PATH_IMG ."/checkbullet.gif'></a>";
			else if($do['status_on']) $do_12_20 = "<a href =".cn_url_modify('mod=cshop_', 'opt=online','sub='.$od)." title='Đang ủy thác Online'><img src='". URL_PATH_IMG ."/checkbullet.gif'></a>";
			else $do_12_20 = "<img src='". URL_PATH_IMG ."/alert_icon.gif'>";
				
			$showchar_[] = array('char_image' => $do['char_image'], 'Name' => $od, 'cclass' => $do['cclass'], 'level' => $do['level'], 'str' => $do['str'], 'dex' => $do['dex'], 'vit' => $do['vit'], 'ene' => $do['ene'], 'com' => $do['com'], 'reset' => $do['reset'], 'relife' => $do['relife'], 'point' => $do_10, 'point_dutru' => $do_11, 'status_uythac' => $do_12_20, 'point_uythac' => $do['point_uythac'], 'pcpoint' => $do['pcpoint']);
		}
	}

	cn_assign('showchar', $showchar_);

	echoheader('-@my_char/style.css', "Information character");
	echocomtent_here(exec_tpl('my_char/info_char'), cn_snippet_bc_re());
	echofooter();
}
