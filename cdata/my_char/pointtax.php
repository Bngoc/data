<?php
$odd = 0;
$i = 0;
$ok_loop = false;
$ok_loop2 = false;
list($showchar) = _GL('showchar');
list($before_info_pointtax, $opt_taxpoint) = _GL('before_info_pointtax, opt_pointtax');
list($sub, $num_) = _GL('sub, is_tax');

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
                        <td align="center" colspan="2"><b>Điều kiện thuê Point </b></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <hr>
                        </td>
                    </tr>
                    <?php if ($before_info_pointtax) foreach ($before_info_pointtax as $ke => $val) {
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
        <tr>
            <td class="bizwebform_col_1">Tỷ giá</td>
            <td class="bizwebform_col_2">
                <select id="bizwebselect" name="point_tax" onchange='submit()'/>
                <?php foreach ($opt_taxpoint as $_id => $_var)
                    echo '<option size="28" value="' . $_id . '" ' . ($_id == $num_ ? 'selected="selected"' : '') . '>' . number_format((float)$_var, 0, ",", ".") . ' Point = ' . number_format((float)$_var, 0, ",", ".") . ' Vpoint. </option>';
                ?>
                </select>
            </td>
            <td class="bizwebform_col_3"></td>
        </tr>
    </table>
</form>

<?php
echoFormVerifyChar(['action_pointtax' => '_pointtax'], 'Bạn có chắc muốm thuê điểm không?');
?>

<table style="width: 100%" cellpadding="2">
    <tr>
        <td colspan="3" style="padding:20px; text-align:center"></td>
    </tr>
    <tr>
        <td colspan="3" class="">CONFIG<br/></td>
    </tr>
    <tr>
        <td colspan="3">
            <div class="vertical-img"><img src="<?php echo URL_PATH_IMG; ?>/vertical-separator.jpg" width="100%"
                                           height="1px"/></div>
            <br/></td>
    </tr>
</table>
<b>Ghi chú: </b><br>
<em>- Thời gian sử dụng là <b>24h</b> tính từ lúc đăng ký thuê point. </em><br>
<em>- Sau <b>24h</b> nhân vật được tự dộng reset point tương ứng với cấp độ nhận vật!</em>
