﻿<?php
$odd = 0;
$i = 0;
$ok_loop = false;
$ok_loop2 = false;
list($showchar) = _GL('showchar');
list($before_info_cn, $infoClass) = _GL('before_info_cn, infoClass');
list($sub, $num_) = _GL('sub, is_tax');

cn_snippet_messages();
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
                        <td align="center" colspan="2"><b>Điều kiện đổi tên nhân vật </b></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <hr>
                        </td>
                    </tr>
                    <?php if ($before_info_cn) foreach ($before_info_cn as $ke => $val) {
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
            <td class="bizwebform_col_1">Chọn giới tính cần đổi</td>
            <td class="bizwebform_col_2">
                <select name="nameClass" id="bizwebselect">
                <?php
                    if($infoClass) foreach ($infoClass as $key => $items){
                        echo '<option value="' . $key .'">' .  $items[$key.'_name'] .' </option>';
                    }
                ?>
                </select>
            </td>
            <td class="bizwebform_col_3"></td>
<!--            <td class="bizwebform_col_1">Tên nhân vật mới</td>-->
<!--            <td class="bizwebform_col_2">-->
<!--                <input class="bizwebform" id="" --><?php //if ($cn_false) echo 'readonly="readonly"'; ?><!-- type="text"-->
<!--                       name="c_name" placeholder="abc123">-->
<!--            </td>-->
<!--            <td class="bizwebform_col_3"></td>-->
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
                <input type="hidden" value="_cname" name="action_className"/>
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
        <td colspan="3" class="">CONFIG<br/></td>
    </tr>
    <tr>
        <td colspan="3" class=""><i>Lưu ý: Thứ tự sử dụng tiền tệ: <b>Gcoin >> Vpoint.</b></i></td>
    </tr>
    <tr>
        <td colspan="3">
            <div class="vertical-img"><img src="<?php echo URL_PATH_IMG; ?>/vertical-separator.jpg" width="640"
                                           height="1px"/></div>
            <br/></td>
    </tr>
</table>
<em>
    <?php
        $changeClass = explode(':', getoption('changeClass_str'));
        echo '<b>Phí: ' . number_format((float)(getoption('vptogc') * $changeClass[0] * 0.01), 0, ",", ".") . ' Gcoin</b> hoặc <b>' . number_format((float)($changeClass[0]), 0, ",", ".") . ' Vpoint </b><br>';
        echo '<b>Trừ: ' . $changeClass[1] . ' %</b> số Reset <b></br>';
        echo '<b>Cần: ' . $changeClass[2] . '</b> Reset tối thiểu';
        ?>
</em>
