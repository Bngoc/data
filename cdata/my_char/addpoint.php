<?php
$odd = 0;
$i = 0;
$ok_loop = false;
$ok_loop2 = false;
list($before_info_addpoint, $showchar, $_is_classdl, $sdpoint, $rootPoint) = _GL('before_info_addpoint, showchar, is_classDl, sd_point, rootPoint');
list($sub) = _GL('sub');

echo cn_snippet_messages();
?>

<form action="<?php echo PHP_SELF; ?>" method="GET">
    <?php cn_form_open('mod, opt'); ?>
    <table style="width: 100%" cellpadding="2">

        <tr>
            <td colspan="3" class="">THÔNG TIN NHÂN VẬT<br/></td>
        </tr>
        <tr>
            <td colspan="3">
                <div class="vertical-img"><img src="<?php echo URL_PATH_IMG; ?>/vertical-separator.jpg" width="100%"
                                               height="1px"/></div>
                <br/></td>
        </tr>
        <tr>
            <td colspan="3">
                <table width="100%" border="0" cellpadding="3" cellspacing="1">
                    <tr>
                        <td align="center" colspan="2"><b>Điều kiện cộng Point </b></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <hr>
                        </td>
                    </tr>
                    <?php if ($before_info_addpoint) foreach ($before_info_addpoint as $ke => $val) {
                        if (isset($val[1]))
                            echo '<tr>
									<td align="right" width="40%">' . $val[0] . ':</td>
									<td class="pd-left10"><strong style="color:#009900">' . $val[1] . '</strong></td>
								</tr>';
                    } ?>

                </table>
            </td>
        </tr>

        <tr>
            <td class="bizwebform_col_1">Chọn Nhân vật</td>
            <td class="bizwebform_col_2">

                <select size="1" name="sub" id="bizwebselect" onchange='submit()'>
                    <?php if ($showchar) foreach ($showchar as $name => $val) { ?>
                        <option
                            value="<?php echo $name; ?>"<?php if ($sub == $name) echo 'selected'; ?>><?php echo $name . ' (LV:' . $val['level'] . '- Reset: ' . $val['reset'] . ' - Relife: ' . $val['relife']; ?>
                            )
                        </option>
                    <?php } ?>
                </select>

            </td>
            <td class="bizwebform_col_3"></td>
        </tr>
    </table>
</form>


<form id="verify" action="<?php echo PHP_SELF; ?>" method="POST">
    <?php cn_form_open('mod, opt, sub'); ?>
    <input type="hidden" value="deleonline" name="action_addpoint"/>
    <table class="">

        <tr>
            <td colspan="3" class="">MÃ XÁC NHẬN</td>
        </tr>
        <tr>
            <td colspan="3">
                <div class="vertical-img"><img src="<?php echo URL_PATH_IMG; ?>/vertical-separator.jpg" width="100%"
                                               height="1px"/></div>
                <br/></td>
        </tr>

        <tr>
            <td class="bizwebform_col_1">Sức mạnh (str)</td>
            <td class="bizwebform_col_2">
                <div class="dec button">-</div>
                <input class="txt-add-sub" id="str" type="number" name="addstr"
                       value="<?php echo filter_var($before_info_addpoint[7][1], FILTER_SANITIZE_NUMBER_INT); ?>">
                <div class="inc button">+</div>
                <span id="str_"></span>
            </td>
            <td class="bizwebform_col_3" id=""></td>
        </tr>
        <tr>
            <td class="bizwebform_col_1">Nhanh nhẹn (agi)</td>
            <td class="bizwebform_col_2">
                <div class="dec button">-</div>
                <input class="txt-add-sub" id="agi" type="number" name="addagi"
                       value="<?php echo filter_var($before_info_addpoint[3][1], FILTER_SANITIZE_NUMBER_INT); ?>"/>
                <div class="inc button">+</div>
            </td>
            <td class="bizwebform_col_3" id=""></td>
        </tr>
        <tr>
            <td class="bizwebform_col_1">Sức khỏe (vit)</td>
            <td class="bizwebform_col_2">
                <div class="dec button">-</div>
                <!-- type="range" min="1" max="20" value="10" onchange="updateRangeValue()" -->
                <input class="txt-add-sub" id="vit" type="number" name="addvit"
                       value="<?php echo filter_var($before_info_addpoint[4][1], FILTER_SANITIZE_NUMBER_INT); ?>">
                <!-- <button type="button"  id="vitinc" class="but"> + </button><strong><output id="intNumberValue">&nbsp; kjljkj</output></strong>  -->
                <div class="inc button">+</div>
            </td>
            <td class="bizwebform_col_3" id=""></td>
        </tr>
        <tr>
            <td class="bizwebform_col_1">Năng lượng (ene)</td>
            <td class="bizwebform_col_2" class="ene numbers-row">
                <div class="dec button">-</div>
                <input class="txt-add-sub" id="ene" type="number" name="addene"
                       value="<?php echo filter_var($before_info_addpoint[5][1], FILTER_SANITIZE_NUMBER_INT); ?>"/>
                <div class="inc button">+</div>
            </td>
        </tr>
        <?php if ($_is_classdl) echo '<tr>
			<td class="bizwebform_col_1">Mệnh lệnh (cmd)</td>
			<td class="bizwebform_col_2" class="numbers-row">
				<div class="dec button">-</div>
				<input class="txt-add-sub" id="cmd" type="number" name="addcmd" value="' . filter_var($before_info_addpoint[6][1], FILTER_SANITIZE_NUMBER_INT) . '" />
				<div class="inc button">+</div>
			</td>
		</tr>';
        ?>
        <tr>
            <td class="bizwebform_col_1">Số dư Point</td>
            <td class="bizwebform_col_2"><input class="hd-sms" readonly="readonly" value="0"/></td>
            <td class="bizwebform_col_3">
                <input type="hidden" id="sum-point" value="<?php echo($rootPoint + $sdpoint); ?>"/>
                <input type="hidden" id="haveAddPoint" value="<?php echo $sdpoint; ?>"/>
            </td>
        </tr>
        <tr>
            <td class="bizwebform_col_1"><a href="#" style="border-bottom: 1px dotted #000080;"
                                            onclick="getId('capchaWeb').src='<?php echo getoption('http_script_dir'); ?>/captcha.php?page=web&r='+Math.random(); return(false);">
                    Refresh code</a></td>
            <td colspan="" class="bizwebform_col_2" style="padding-left:20px;">
                <div class="vertical-img"><img src="<?php echo getoption('http_script_dir'); ?>/captcha.php?cap=web"
                                               id="capchaWeb" alt=""></div>
            </td>
            <td class="bizwebform_col_3"></td>
        </tr>
        <tr>
            <td class="bizwebform_col_1">Nhập mã xác nhận <span class="required">*</span></td>
            <td class="bizwebform_col_2"><input type="text" class="bizwebform" name="verifyCaptcha" required
                                                autocomplete="off"
                                                onchange="checkCaptcha(this.value, 'msg_Captcha');"/></td>
            <td class="bizwebform_col_3" id="msg_Captcha"></td>
        </tr>
        <tr>
            <td colspan="3" style="padding:20px; text-align:center"></td>
        </tr>
        <tr>
            <td colspan="3" style="text-align:center">

                <input type="image" src="<?php echo URL_PATH_IMG; ?>/capnhat.png" style="padding-right:10px">
                <img style="cursor:pointer" border="0" src="<?php echo URL_PATH_IMG; ?>/cancel.png"
                     onclick="document.getElementById('verify').reset();" style="padding-left:10px">
            </td>
        </tr>
    </table>
</form>

<?php if ($_is_classdl) echo
'<table style="width: 100%" cellpadding="2">
		<tr><td colspan="3" style="padding:20px; text-align:center"></td></tr>
		<tr><td colspan="3" class="">CONFIG<br/></td></tr>
		<tr><td colspan="3"><div class="vertical-img"><img src="<?php echo URL_PATH_IMG; ?>/vertical-separator.jpg" width="100%" height="1px" /></div><br/></td></tr>
		<tr><td colspan="3">...........................cmd .....</td></tr>
	</table>';
?>
