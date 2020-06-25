<?php
$odd = 0;
$i = 0;
$ok_loop = false;
$ok_loop2 = false;
list($showchar) = _GL('showchar');
list($before_info_subpoint, $sd_pointdutru, $sms_notify) = _GL('before_info_subpoint,sd_pointdutru, sms_notify');
list($sub, $point_false) = _GL('sub,point_false65k');

echo cn_snippet_messages();
if ($sms_notify) echo $sms_notify;
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
                        <td align="center" colspan="2"><b>Điều kiện Rút Point dự trữ </b></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <hr>
                        </td>
                    </tr>
                    <?php if ($before_info_subpoint) foreach ($before_info_subpoint as $ke => $val) {
                        if (isset($val[1]))
                            echo '<tr>
									<td align="right" width="40%">' . $val[0] . ':</td>
									<td><strong style="color:#009900">' . $val[1] . '</strong></td>
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

<form action="<?php echo PHP_SELF; ?>" method="POST">
    <?php cn_form_open('mod, opt, sub'); ?>
    <input type="hidden" value="deleonline" name="action_subpoint"/>
    <table width="100%">
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
            <td class="bizwebform_col_1">Nhập số Point</td>
            <td class="bizwebform_col_2">
                <!--<div class="dec button">-</div>
				<button type="button"  id="point_dutrudec" <?php //if(!$point_false) echo 'class="dec button"'; ?>> - </button>-->
                <input class="formrange" id="point_dutru" <?php if ($point_false) echo 'readonly="readonly"' ?>
                       type="range" min="0" <?php echo 'max="' . $sd_pointdutru . '"';
                if ($sd_pointdutru) echo 'value="' . $sd_pointdutru . '"'; ?> name="rut_point">
                <!--<div class="inc button">+</div>
				<button type="button"  id="point_dutruinc" <?php //if(!$point_false) echo 'class="inc button but"'; ?>> + </button></td>-->
            <td class="bizwebform_col_3" id=""><strong>
                    <output id="rut-point">&nbsp; 0</output>
                </strong></td>
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

<table style="width: 100%" cellpadding="0">
    <tr>
        <td colspan="3" class="">CONFIG <br/></td>
    </tr>
    <tr>
        <td colspan="3">
            <div class="vertical-img"><img src="<?php echo URL_PATH_IMG; ?>/vertical-separator.jpg" width="100%"
                                           height="1px"/></div>
            <br/></td>
    </tr>
</table>

<div class="sub_ranking">
    <div class="box-notice"></div>
</div>
