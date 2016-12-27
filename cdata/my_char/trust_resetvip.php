<?php

list($showchar, $options_rsvip_trust, $before_info_trustvip) = _GL('showchar, options_rsvip_trust, before_info_trustvip');
list($sub) = _GL('sub');
echo cn_snippet_messages();
$cap_reset_max = getoption('cap_reset_max');
if ($cap_reset_max > 20) $cap_reset_max = 20;
$ok_loop = false;
$odd = 0;
$i = 0;
?>

    <table style="width: 100%" cellpadding="2">
        <form action="<?php echo PHP_SELF; ?>" method="GET">
            <?php cn_form_open('mod, opt'); ?>
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
                            <td align="center" colspan="2"><b>Điều kiện Reset ủy thác Vip </b></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <hr>
                            </td>
                        </tr>
                        <?php if ($before_info_trustvip) foreach ($before_info_trustvip as $ke => $val) {
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
                                value="<?php echo $name; ?>"<?php if ($sub == $name) echo 'selected'; ?>><?php echo $name; ?>
                                (LV: <?php echo $val['level'] ?> - Reset: <?php echo $val['reset'] ?> )
                            </option>
                        <?php } ?>
                    </select>

                </td>
                <td class="bizwebform_col_3"></td>
            </tr>
        </form>

        <form action="<?php echo PHP_SELF; ?>" method="POST">

            <?php echo cn_snippet_get_hidden(); //cn_form_open('mod, opt, sub'); ?>
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
                <td class="bizwebform_col_1">Code Image</td>
                <td class="bizwebform_col_2" style="padding-left:20px;"><img src="img.php?size=6"/></td>
                <td class="bizwebform_col_3"></td>
            </tr>
            <tr>
                <td class="bizwebform_col_1">Nhập mã xác nhận</td>
                <td class="bizwebform_col_2"><a href='javascript: refreshCaptcha();'><img
                            src="captcha.php?rand=<?php echo rand(); ?>"
                            id='captchaimg'></a><?php //$vImage->showCodBox(1); ?></td>
                <td class="bizwebform_col_3" id="msg_vImageCodP"></td>
            </tr>
            <tr>
                <td colspan="3" style="padding:20px; text-align:center"></td>
            </tr>
            <tr>
                <td colspan="3" style="text-align:center">
                    <input type="hidden" value="uythacresetvip" name="action_rsvipuythac"/>
                    <input type="image" src="<?php echo URL_PATH_IMG; ?>/capnhat.png" style="padding-right:10px">
                    <img style="cursor:pointer" border="0" src="<?php echo URL_PATH_IMG; ?>/cancel.png"
                         style="padding-left:10px">
                </td>
            </tr>
        </form>
    </table>


<?php
if (getoption('user_rs_uythac')) { ?>
    <div class="sub_ranking">
        <table style="width: 100%" cellpadding="2">
            <tr>
                <td colspan="3" class="">CONFIG TRUST RESET VIP<br/></td>
            </tr>
            <tr>
                <td colspan="3" class=""><i>Lưu ý: Thứ tự sử dụng tiền tệ Reset Vip. <b>Gcoin</b> >> <b>Vpoint.</b> </i>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <div class="vertical-img"><img src="<?php echo URL_PATH_IMG; ?>/vertical-separator.jpg" width="100%"
                                                   height="1px"/></div>
                    <br/></td>
            </tr>
        </table>
        <table id="tbl_ranking">
            <tr>
                <td align="center"><b>Reset</b></td>
                <td align="center"><b>Point ủy Thác</b></td>
                <td align="center"><b>Vpoint</b></td>
                <td align="center"><b>Gcoin (80% Vp)</b></td>
            </tr>

            <?php if ($options_rsvip_trust) foreach ($options_rsvip_trust as $df => $fd) {
                if ($ok_loop) {
                    $lv_rs_f = $lv_rs_e;
                    $lv_rs_e = $fd['reset'];
                } else {
                    $lv_rs_f = 0;
                    $lv_rs_e = $fd['reset'];
                    $ok_loop = true;
                } ?>
                <tr <?php if ($odd++ % 2) echo 'style="background: #f8f8f8;"'; ?>>
                    <td align="center"> <?php echo ++$lv_rs_f . ' &rarr; ' . $fd['reset']; ?></td>
                    <td align="center"><?php echo $fd['point']; ?></td>
                    <td align="center"><?php echo number_format((float)$fd['vpoint'], 0, ",", "."); ?></td>
                    <td align="center"><?php echo number_format((float)$fd['gcoin'], 0, ",", "."); ?></td>
                </tr>
                <?php ++$i;
                if ($i === $cap_reset_max) break;
            } ?>

        </table>
    </div>

<?php } else {
    echo '<table style="width: 100%" cellpadding="2">
			<tr><td><b><font styles ="font-size:15px;" color="red">Hiện không sử dụng Reset ủy thác Vip!</font></b></td></tr>
		</table>';
}