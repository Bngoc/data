<?php

$odd = 0;
$i = 0;
$ok_loop = false;
$ok_loop2 = false;
list($options_rl, $showchar) = _GL('options_rl, showchar');
list($before_info_rl, $notify_rs_ok) = _GL('before_info_rl, notify_rs_ok');
list($sub) = _GL('sub');

echo cn_snippet_messages();
$cap_relife_max = getOption('cap_relife_max');
if ($cap_relife_max > 10) {
    $cap_relife_max = 5;
}

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
                        <td align="center" colspan="2"><b>Điều kiện Relife </b></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <hr>
                        </td>
                    </tr>
                    <?php if ($before_info_rl) {
                        foreach ($before_info_rl as $ke => $val) {
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
                            } ?>><?php echo $name ?>
                                ( LV: <?php echo $val['level'] ?> - Reset: <?php echo $val['reset'] ?> - Đã
                                Relife <?php echo $val['relife'] ?>)
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
echoFormVerifyChar(['action_relife' => 'relife']);
?>

<table style="width: 100%" cellpadding="2">
    <tr>
        <td colspan="3" style="padding:20px; text-align:center"></td>
    </tr>
    <tr>
        <td colspan="3" class="">CONFIG RELIFE<br/></td>
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
            <td align="center"><b>LV ReLife</b></td>
            <td align="center"><b>Reset</b></td>
            <td align="center"><b>Level</b></td>
            <td align="center"><b>Point</b></td>
            <td align="center"><b>Command</b></td>
        </tr>
        <?php if ($options_rl) {
            foreach ($options_rl as $df => $fd) { ?>
                <tr <?php if ($odd++ % 2) {
                    echo 'style="background: #f8f8f8;"';
                } ?>>
                    <td align="center"><b>LV <?php echo ++$i; ?></b></td>
                    <td align="center"> <?php echo $fd['reset']; ?></td>
                    <td align="center">400</td>
                    <td align="center"><?php echo number_format((float)$fd['point'], 0, ",", "."); ?></td>
                    <td align="center"><?php echo number_format((float)$fd['command'], 0, ",", "."); ?></td>
                </tr>
                <?php if ($i === $cap_relife_max) {
                    break;
                }
            }
        } ?>
    </table>
</div>

