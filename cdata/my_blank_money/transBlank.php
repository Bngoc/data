<?php

list($options, $strInfoMoney, $showConfigVpoint, $optionBuyZen) = _GL('options, strInfoMoney, showConfigVpoint, optionBuyZen');
?>

<div id="msg-Show"></div>
<form action="<?php echo PHP_SELF; ?>" method="GET">
    <?php echo cn_form_open('mod, opt'); ?>
    <table style="width: 100%" cellpadding="2" align="middle">
        <tr>
            <td colspan="3" class="">TIỀN TỆ <?php echo strtoupper($options); ?><br/></td>
        </tr>
        <tr>
            <td colspan="3">
                <div class="vertical-img"><img src="<?php echo URL_PATH_IMG; ?>/vertical-separator.jpg" width="100%"
                                               height="1px"/></div>
                <br/></td>
        </tr>
        <tr align="middle">
            <td colspan="3">
                <div class="result-show"><?php echo $strInfoMoney; ?></div>
                <div class="pd-top10 cRed countItem">
                </div>
            </td>
        </tr>
        <tr>
            <td class="bizwebform_col_1">Chọn số lượng <?php echo $options; ?> <span class="required">*</span></td>
            <td colspan="" class="bizwebform_col_2">
                <?php if (!empty($optionBuyZen) && isset($optionBuyZen)) {
                    echo $optionBuyZen;
                } else {
                    echo '<input type="number" class="bizwebform" id="changeNumber" name="numberItem" value="' . (isset($_REQUEST['numberItem']) ? $_REQUEST['numberItem'] : '') . '" />';
                } ?>
            </td>
            <td>
                <div id="msg_NumItem"></div>
            </td>
        </tr>
    </table>
</form>

<?php
$arrHidden = [
    'action_transBlank' => 'blankVp2Gc',
    'numberItem' => ''
];
echoFormVerifyAjax($arrHidden, '#blankTrans');
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
            <?php echo $showConfigVpoint; ?>
        </td>
    </tr>
</table>
