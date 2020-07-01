<?php
$odd = 0;
$i = 0;
$ok_loop = false;
$ok_loop2 = false;
list($showchar) = _GL('showchar');
list($before_info_on) = _GL('before_info_on');
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
                        <td align="center" colspan="2"><b>Điều kiện ủy thác Online </b></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <hr>
                        </td>
                    </tr>
                    <?php if ($before_info_on) {
                        foreach ($before_info_on as $ke => $val) {
                            if (isset($val[1])) {
                                echo '<tr>
									<td align="right" width="40%">' . $val[0] . ':</td>
									<td><strong style="color:#009900">' . $val[1] . '</strong></td>
								</tr>';
                            }
                        }
                    } ?>

                </table>
            </td>
        </tr>

        <tr>
            <td class="bizwebform_col_1">Chọn Nhân vật</td>
            <td class="bizwebform_col_2">

                <select size="1" name="sub" id="bizwebselect" onchange='submit()'>
                    <?php if ($showchar) {
                        foreach ($showchar as $name => $val) { ?>
                            <option
                                value="<?php echo $name; ?>"<?php if ($sub == $name) {
                                echo 'selected';
                            } ?>><?php echo $name . ' (LV:' . $val['level'] . '- Reset: ' . $val['reset'] . ' - Relife: ' . $val['relife']; ?>
                                )
                            </option>
                        <?php }
                    } ?>
                </select>

            </td>
            <td class="bizwebform_col_3"></td>
        </tr>
    </table>
</form>

<?php
echoFormVerifyChar(['action_deleonline' => 'deleonline']);
?>

<table style="width: 100%" cellpadding="2">
    <tr>
        <td colspan="3" class="">CONFIG TRUST ONLINE<br/></td>
    </tr>
    <tr>
        <td colspan="3">
            <div class="vertical-img"><img src="<?php echo URL_PATH_IMG; ?>/vertical-separator.jpg" width="100%"
                                           height="1px"/></div>
            <br/></td>
    </tr>
</table>

<div class="sub_ranking">
    <div class="box-notice">
        <b>Điều kiện Ủy Thác</b><br>
        - Nhân vật phải đang <b> trong Game</b>.
        <br>
        - Khi mất Ủy thác có thể <b>kích hoạt lại Ủy thác Trên Web</b>.
        <br>
        - <b>1 </b>Điểm ủy Thác = <b><?php echo getOption('uythacon_price') ?> </b> Gcoin / <b>1</b> Phút ủy thác<br>
        <p align="left">
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
            <li>Chú ý tính toán kĩ thời gian kết thúc Ủy thác, tránh trường hợp để quá lâu bị hết tiền (^_^)</li>
            <li>Nhân vật phải ở trong làng Lorencia hoặc Noria.</li>
        </ul>
        </p>
    </div>
</div>
