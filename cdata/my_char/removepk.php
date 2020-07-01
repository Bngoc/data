<?php
$odd = 0;
$i = 0;
$ok_loop = false;
$ok_loop2 = false;
list($before_info_pk, $showchar, $option_pk) = _GL('before_info_pk, showchar, option_pk');
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
                        <td align="center" colspan="2"><b>Điều kiện Reset Point </b></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <hr>
                        </td>
                    </tr>
                    <?php if ($before_info_pk) {
                        foreach ($before_info_pk as $ke => $val) {
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
echoFormVerifyChar(['action_removepk' => 'removepk']);
?>

<table style="width: 100%" cellpadding="2">
    <tr>
        <td colspan="3" style="padding:20px; text-align:center"></td>
    </tr>
    <tr>
        <td colspan="3" class="">CONFIG<br/></td>
    </tr>
    <tr>
        <td colspan="3" class=""><i>Lưu ý: Thứ tự sử dụng tiền tệ:</i> <b>Gcoin >> Vpoint<b>.</td>
    </tr>
    <tr>
        <td colspan="3">
            <div class="vertical-img"><img src="<?php echo URL_PATH_IMG; ?>/vertical-separator.jpg" width="100%"
                                           height="1px"/></div>
            <br/></td>
    </tr>
</table>

<div class="sub_ranking">
    <table id="tbl_ranking" class="std-table opt_table">
        <tr>
            <td align="center"><b>Pk</b></td>
            <td align="center"><b>Phí</b></td>
        </tr>
        <?php if ($option_pk) {
            foreach ($option_pk as $df => $fd) {
                echo '<tr';
                if ($odd++ % 2) {
                    echo 'style="background: #f8f8f8;"';
                }
                echo '><td align="center">Giết';
                if (!$ok_loop) {
                    echo ' &le; ';
                } else {
                    echo ' > ';
                }
                echo $fd['pkcount'] . ' mạng</td><td align="center">' . number_format((float)$fd['pk'], 0, ",", ".");
                if (!$ok_loop) {
                    echo ' Zen/mạng </td></tr>';
                    $ok_loop = true;
                } else {
                    echo ' V.Point/mạng</td></tr>';
                }
            }
        } ?>
    </table>
</div>
