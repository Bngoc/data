<?php

list($sub, $showchar, $show_warehouse, $check_change) = _GL('sub, showchar, show_warehouse, check_change');
echo cn_snippet_messages();
?>


<form action="<?php echo PHP_SELF; ?>" method="GET">
    <?php echo cn_form_open('mod, opt, sub'); ?>
    <table style="width: 100%" cellpadding="2">
        <tr>
            <td colspan="3" class="">THÔNG TIN HÒM ĐỒ CÁ NHÂN<br/></td>
        </tr>
        <tr>
            <td colspan="3">
                <div class="vertical-img"><img src="<?php echo URL_PATH_IMG; ?>/vertical-separator.jpg" width="100%"
                                               height="1px"/></div>
                <br/></td>
        </tr>
        <tr>
            <td colspan="3">
                <?php echo $show_warehouse; ?>
            </td>
        </tr>
        <tr>
            <td colspan="3"></td>
        </tr>
        <tr>
            <td class="bizwebform_col_1 pd-top15 pd-bottom15">Chọn Nhân vật</td>
            <td class="bizwebform_col_2 pd-top15 pd-bottom15">
                <select size="1" name="sub" id="bizwebselect" onchange='submit()'>
                    <?php if ($showchar) {
                        foreach ($showchar as $name => $val) { ?>
                            <option
                                value="<?php echo $name; ?>"<?php if ($sub == $name) {
                                echo 'selected';
                            } ?>>
                                <?php echo $name ?>( LV: <?php echo $val['level'] ?> -
                                Reset: <?php echo $val['reset'] ?>
                                - Đã Relife <?php echo $val['relife'] ?>)
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
echoFormVerifyChar(['action_personalSotre' => 'personalSotre'], "Bạn có chắc muốn xóa cửa hàng cá nhân không?");
?>

<table width="100%">
    <tr>
        <td class="pd-bottom10 pd-top10">
            <div class="vertical-img"><img src="<?php echo URL_PATH_IMG; ?>/vertical-separator.jpg" width="100%"
                                           height="1px"/></div>
            <i class="mg-top5"><b>Lưu ý:</b> Nhân vật phải đổi trước khi thực hiện thao tác.</i>
        </td>
    </tr>
    <tr>
        <td>
            <?php if ($check_change) {
                echo '- Nhân vật ' . $sub . '<font color =red> đã đổi</font>';
            } else {
                echo '- Nhân vật ' . $sub . '<font color =red> chưa đổi</font>';
            } ?>
        </td>
    </tr>
</table>

