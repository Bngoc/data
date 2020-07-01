<?php
$odd = 0;
$i = 0;
$ok_loop = false;
$ok_loop2 = false;
list($gh_loai1, $gh_loai2, $get_arr_gh, $set_arr_rsvip, $showchar, $options_tanthu) = _GL('gh_loai1, gh_loai2, set_arr_gh, set_arr_rsvip, showchar, options_tanthu');
list($cap_reset_max, $use_gioihanrs, $before_info_rsvip, $notify_rs_ok) = _GL('user_max_rs, user_type_gh_rs, before_info_rsvip, notify_rs_ok');
list($sub) = _GL('sub');

echo cn_snippet_messages();
if ($notify_rs_ok) {
    echo $notify_rs_ok;
}
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
                        <td align="center" colspan="2"><b>Điều kiện Reset Vip </b></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <hr>
                        </td>
                    </tr>
                    <?php if ($before_info_rsvip) {
                        foreach ($before_info_rsvip as $ke => $val) {
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
                            } ?>><?php echo $name; ?>
                                ( LV: <?php echo $val['level'] ?> - Reset: <?php echo $val['reset'] ?> - Đã
                                Reset <?php echo $val['resetInDay'] ?> lần / ngày )
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
echoFormVerifyChar(['action_rsvip' => 'resetvip']);
?>

<table style="width: 100%" cellpadding="2">
    <tr>
        <td colspan="3" style="padding:20px; text-align:center"></td>
    </tr>
    <tr>
        <td colspan="3" class="">CONFIG RESET VIP<br/></td>
    </tr>
    <tr>
        <td colspan="3" class=""><i>Lưu ý: Thứ tự sử dụng tiền tệ Reset Vip. <b>Gcoin KM</b> >> <b>Gcoin</b> >> <b>(Gcoin
                    KM + Gcoin)</b> >> <b>Vpoint.</b> </i></td>
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
            <td align="center"><b>LV Reset Vip</b></td>
            <td align="center"><b>Reset Vip</b></td>
            <td align="center"><b>Level</b></td>
            <td align="center"><b>Vpoint</b></td>
            <td align="center"><b>Gcoin (Gcoin KM)</b></td>
            <td align="center"><b>Point</b></td>
            <td align="center"><b>Command</b></td>
        </tr>
        <?php if ($set_arr_rsvip) {
            $lv_rs_e = 0;
            foreach ($set_arr_rsvip as $df => $fd) {
                $lv_rs_f = $ok_loop ? $lv_rs_e : 0;
                $lv_rs_e = $fd['reset'];
                $ok_loop = true; ?>
                <tr <?php if ($odd++ % 2) {
                    echo 'style="background: #f8f8f8;"';
                } ?>>
                    <td align="center"><b>LV <?php echo ++$i; ?></b></td>
                    <td align="center"> <?php echo ++$lv_rs_f . ' &rarr; ' . $fd['reset']; ?></td>
                    <td align="center"><?php echo $fd['level']; ?></td>
                    <td align="center"><?php echo number_format((float)$fd['vpoint'], 0, ",", "."); ?></td>
                    <td align="center"><?php echo number_format((float)$fd['gcoin'], 0, ",", "."); ?></td>
                    <td align="center"><?php echo $fd['point']; ?></td>
                    <td align="center"><?php echo $fd['command']; ?></td>

                </tr>
                <?php if ($i === $cap_reset_max) {
                    break;
                }
            }
        } ?>
    </table>
</div>

<table style="width: 100%" cellpadding="2">
    <tr>
        <td colspan="3" style="padding:15px; text-align:center"></td>
    </tr>
    <tr>
        <td colspan="3" class="">LIMIT RESET VIP<br/></td>
    </tr>
    <tr>
        <td colspan="3">
            <div class="vertical-img"><img src="<?php echo URL_PATH_IMG; ?>/vertical-separator.jpg" width="100%"
                                           height="1px"/></div>
            <br/></td>
    </tr>
</table>
<?php if ($use_gioihanrs == 1) { ?>

    <div class="sub_ranking">

        <table id="tbl_ranking" class="std-table opt_table">
            <tr>
                <td>
                    <div align="center"><b>TOP</b></div>
                </td>
                <td>
                    <div align="center"><b>Reset</b></div>
                </td>
            </tr>
            <?php if ($gh_loai1) {
                $i_f = 0;
                foreach ($gh_loai1 as $key => $val) {
                    $i_f = $ok_loop2 ? $i_e : 0;
                    $i_e = $i_e + 10;
                    $ok_loop2 = true; ?>
                    <tr <?php if ($odd++ % 2) {
                        echo 'style="background: #f8f8f8;"';
                    } ?>>
                        <td align="center"><b>TOP <?php if (++$i_f > 50) {
                                    echo ' > ' . --$i_f;
                                } else {
                                    echo $i_f . ' &rarr; ' . $i_e;
                                } ?></b></td>
                        <td align="center">Reset Max <b> <?php echo $val['top']; ?></b> lần / ngày</td>
                    </tr>

                    <?php
                }
            } ?>
        </table>
    </div>

<?php } elseif ($use_gioihanrs == 2) { ?>


    <div class="sub_ranking">

        <table id="tbl_ranking" class="std-table opt_table">
            <?php //}
            if ($gh_loai2) {
                foreach ($gh_loai2 as $key => $val) {
                    $count = count($gh_loai2) - 1;
                    if ($ok_loop2) {
                        $lv_rs_f = $lv_rs_en;
                        $lv_rs_en = $val['col1'];
                        if ($key != $count) {
                            ?>
                            <tr <?php if ($key % 2) {
                                echo 'style="background: #f8f8f8;"';
                            } ?>>
                                <td>
                                    <div align="center"> <?php echo ++$lv_rs_f . ' &rarr; ' . $val['col1']; ?></div>
                                </td>
                                <td>
                                    <div align="center"><?php echo $val['col2']; ?> Vpoint</div>
                                </td>
                                <td>
                                    <div align="center"><?php echo $val['col3']; ?> Vpoint</div>
                                </td>
                                <td>
                                    <div align="center"><?php echo $val['col4']; ?> Vpoint</div>
                                </td>
                            </tr>
                            <?php
                        } else {
                            ?>
                            <tr <?php if ($key % 2) {
                                echo 'style="background: #f8f8f8;"';
                            } ?>>
                                <td>
                                    <div align="center"> <?php echo '>> ' . $val['col1']; ?></div>
                                </td>
                                <td>
                                    <div align="center"><?php echo $val['col2']; ?> Vpoint</div>
                                </td>
                                <td>
                                    <div align="center"><?php echo $val['col3']; ?> Vpoint</div>
                                </td>
                                <td>
                                    <div align="center"><?php echo $val['col4']; ?> Vpoint</div>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        $lv_rs_en = $val['col1'];
                        $ok_loop2 = true; ?>
                        <tr <?php if ($key % 2) {
                            echo 'style="background: #f8f8f8;"';
                        } ?>>
                            <td>
                                <div align="center"><b>Reset</b></div>
                            </td>
                            <td>
                                <div align="center"><b>1 &rarr; <?php echo $val['day1']; ?> RS / ngày</b></div>
                            </td>
                            <td>
                                <div align="center"><b><?php echo ++$val['day1']; ?> &rarr; <?php echo $val['day2']; ?>
                                        RS /
                                        ngày</b></div>
                            </td>
                            <td>
                                <div align="center"><b> >> <?php echo $val['day2']; ?> RS / ngày</b></div>
                            </td>
                        </tr>
                        <tr <?php if ($key % 2) {
                            echo 'style="background: #f8f8f8;"';
                        } ?>>
                            <td>
                                <div align="center"> <?php echo 1 . ' &rarr; ' . $lv_rs_en; ?></div>
                            </td>
                            <td>
                                <div align="center"><?php echo $val['col2']; ?> Vpoint</div>
                            </td>
                            <td>
                                <div align="center"><?php echo $val['col3']; ?> Vpoint</div>
                            </td>
                            <td>
                                <div align="center"><?php echo $val['col4']; ?> Vpoint</div>
                            </td>
                        </tr>
                        <?php
                    }
                }
            } ?>
        </table>
    </div>
<?php } else {
    echo '<table style="width: 100%" cellpadding="2">
			<tr><td><b><font styles ="font-size:15px;" color="red">Hiện không sử dụng giới hạn Reset!</font></b></td></tr>
		</table>';
}

if (getOption('support_new_player') == 1) { ?>
    <table style="width: 100%" cellpadding="2">
        <tr>
            <td colspan="3" style="padding:15px; text-align:center"></td>
        </tr>
        <tr>
            <td colspan="3" class="">HỖ TRỢ TÂN THỦ<br/></td>
        </tr>
        <tr>
            <td colspan="3">
                <div class="vertical-img"><img src="<?php echo URL_PATH_IMG; ?>/vertical-separator.jpg" width="100%"
                                               height="1px"/></div>
                <br/></td>
        </tr>
    </table>

    <table id="tbl_ranking" class="std-table opt_table">
        <tr>
            <td align="center"><b>Cấp</b></td>
            <td align="center"><b>Reset</b></td>
            <td align="center"><b>ReLife</b></td>
            <td align="center"><b>Level giảm</b></td>
        </tr>
        <?php $k = 0;
        if ($options_tanthu) {
            foreach ($options_tanthu as $df => $fd) {
                ?>
                <tr <?php if ($odd++ % 2) {
                    echo 'style="background: #f8f8f8;"';
                } ?>>
                    <td align="center"><b>Cấp <?php echo ++$k; ?></b></td>
                    <td align="center"><?php echo $fd['reset_min']; ?> &le; Reset
                        &le; <?php echo $fd['reset_max']; ?></td>
                    <td align="center"><?php echo $fd['relife_min']; ?> &le;
                        ReLife &le; <?php echo $fd['relife_max']; ?></td>
                    <td align="center"><?php echo $fd['levelgiam']; ?></td>
                </tr>
                <?php
            }
        } ?>

    </table>
<?php }
?>

