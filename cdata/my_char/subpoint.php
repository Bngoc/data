<?php
$odd = 0;
$i = 0;
$ok_loop = false;
$ok_loop2 = false;
list($showchar) = _GL('showchar');
list($before_info_subpoint, $sd_pointdutru, $sms_notify) = _GL('before_info_subpoint,sd_pointdutru, sms_notify');
list($sub, $point_false) = _GL('sub,point_false65k');

cn_snippet_messages();
if ($sms_notify) echo $sms_notify;
?>


<table style="width: 100%" cellpadding="2">
    <form action="<?php echo PHP_SELF; ?>" method="GET">
        <?php cn_form_open('mod, opt'); ?>
        <tr>
            <td colspan="3" class="">THÔNG TIN NHÂN VẬT<br/></td>
        </tr>
        <tr>
            <td colspan="3">
                <div class="vertical-img"><img src="<?php echo URL_PATH_IMG; ?>/vertical-separator.jpg" width="640"
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
    </form>

    <form action="<?php echo PHP_SELF; ?>" method="POST">

        <?php echo cn_snippet_get_hidden(); //cn_form_open('mod, opt, sub'); ?>
        <tr>
            <td colspan="3" class="">MÃ XÁC NHẬN</td>
        </tr>
        <tr>
            <td colspan="3">
                <div class="vertical-img"><img src="<?php echo URL_PATH_IMG; ?>/vertical-separator.jpg" width="640"
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
                <input type="hidden" value="deleonline" name="action_subpoint"/>
                <input type="image" src="<?php echo URL_PATH_IMG; ?>/capnhat.png" style="padding-right:10px">
                <img style="cursor:pointer" border="0" src="<?php echo URL_PATH_IMG; ?>/cancel.png"
                     style="padding-left:10px">
            </td>
        </tr>
    </form>
</table>


<table style="width: 100%" cellpadding="2">
    <tr>
        <td colspan="3" style="padding:20px; text-align:center"></td>
    </tr>
    <tr>
        <td colspan="3" class="">CONFIG <br/></td>
    </tr>
    <tr>
        <td colspan="3">
            <div class="vertical-img"><img src="<?php echo URL_PATH_IMG; ?>/vertical-separator.jpg" width="640"
                                           height="1px"/></div>
            <br/></td>
    </tr>
</table>

<div class="sub_ranking">


    <center>
        <b>Điều kiện Ủy Thác</b><br>
        - Nhân vật phải đang <b> trong Game</b>.
        <br>
        - Khi mất Ủy thác có thể <b>kích hoạt lại Ủy thác Trên Web</b>.
        <br>
        - <b>1 </b>Điểm ủy Thác = <b><?php echo getoption('uythacon_price') ?> </b> Gcoin / <b>1</b> Phút ủy thác<br>
    </center>
    <blockquote><p align="center">


            <br><b>Lưu ý</b>:
        <ul>
            <li><strong>Thời gian Uỷ Thác Online tối đa trong 1 ngày là 12 tiếng</strong> (<strong>720 Điểm Ủy
                    Thác</strong>)
            </li>
            <li>Uỷ Thác Online không bị giới hạn thời gian Uỷ Thác</li>
            <li><strong>Số điểm Uỷ Thác tối đa trong 1 ngày là 1.440 điểm</strong> (Tổng điểm Uỷ Thác "<i>Online và
                    Offline</i>")
            </li>
            <li><font color='red'>Điểm Ủy Thác <b>-10%</b>, thời gian ủy thác Online <b>-5% </b> vào 24h hàng ngày. Nên
                    sử dụng hết trước 24h hàng ngày.</font></li>
            <li>Chú ý tính toán kĩ thời gian kết thúc Ủy thác, tránh trường hợp để quá lâu bị hết Gcoin (^_^)</li>
            <li> kiem tra map</li>
        </ul>
        </p></blockquote>
</div>