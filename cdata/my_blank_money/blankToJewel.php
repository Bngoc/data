<?php

list($sub, $showchar, $show_inventory, $countItem, $numberItem) = _GL('sub, showchar, show_inventory, countItem, numberItem');
list($htmlOptionNumItem, $isZen) = _GL('htmlOptionNumItem, isZen');

?>

<div id="msg-Show"></div>
<form action="<?php echo PHP_SELF; ?>" method="GET">
    <?php echo cn_form_open('mod, opt'); ?>
    <!--    --><?php //echo cn_form_open('mod, opt, sub, numberItemJewel');?>
    <table style="width: 100%" cellpadding="2" align="middle">
        <tr>
            <td colspan="3" class="">THÔNG TIN HÒM ĐỒ CÁ NHÂN<br/></td>
        </tr>
        <tr>
            <td colspan="3">
                <div class="vertical-img">
                    <img src="<?php echo URL_PATH_IMG; ?>/vertical-separator.jpg" width="100%" height="1px"/></div>
                <br/>
            </td>
        </tr>
        <tr align="middle">
            <td colspan="3">
                <div class="result-show">
                    <?php echo $show_inventory; ?>
                </div>
                <div class="pd-top10 cRed countItem">
                    <?php echo $countItem; ?>
                </div>
            </td>
        </tr>
        <tr>
            <td class="bizwebform_col_1"><?php echo((@$isZen || $isZen == 0) ? '' : 'Chọn số lượng'); ?></td>
            <td colspan="">
                <div class="show-NumItem"><?php echo $htmlOptionNumItem; ?></div>
            </td>
            <td id="msg_NumItem"></td>
        </tr>
        <tr>
            <td class="bizwebform_col_1 pd-top15 pd-bottom15">Chọn Nhân vật</td>
            <td class="bizwebform_col_2 pd-top5 pd-bottom15">
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
$arrHidden = [
    'action_sendBlankJewel' => 'blank2jewel',
    'numberItem' => @$isZen ? $isZen : $numberItem
];
echoFormVerifyAjax($arrHidden, '#blankJewel');
?>

<div class="clear"></div>
<table width="100%" class="pd-top20">
    <tr>
        <td>CONFIG</td>
    </tr>
    <tr>
        <td colspan="100">
            <hr>
        </td>
    </tr>
    <tr>
        <td class="pd-top10">
            - Vật phẩm để sau khi rút sẽ trong <strong> thùng đồ cá nhân <i> <?php echo $sub; ?></i>.</strong>
        </td>
    </tr>
</table>
