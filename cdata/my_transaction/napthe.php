<?php

list($showchar, $card_list, $strKm, $pt_km, $show_history, $opt) = _GL('showchar, card_list, strKm, pt_km, show_history, opt');

echo cn_snippet_messages();
?>
<div class="mg-bottom15">
    <div>THÔNG TIN TÀI KHOẢN</div>
    <td colspan="100%"><i><?php echo $strKm; ?></i></td>

    <div class="vertical-img"><img src="<?php echo URL_PATH_IMG; ?>/vertical-separator.jpg" width="100%"
                                   height="1px"/></div>
</div>
<div class="reload"></div>
<div id="msg-Show"></div>
<div class="clear"></div>
<form id="fromCard" action='<?php echo PHP_SELF; ?>' method='POST'>
    <?php echo cn_form_open('mod, opt, token'); ?>
    <table style="width: 100%" cellpadding="2" class="mg-bottom15">
        <tr>
            <td class="bizwebform_col_1">Mã số thẻ <span class="required">*</span></td>
            <td class="bizwebform_col_2"><input name="cardCode" class="bizwebform" type="text" maxlength="14" required
                                                autocomplete="off"
                                                onchange="checkCardCode(this.value, '<?php echo $opt; ?>', 'cardCodeID');"/>
            </td>
            <td class="bizwebform_col_3" id="cardCodeID"></td>
        </tr>
        <tr>
            <td class="bizwebform_col_1">Serial <span class="required">*</span></td>
            <td class="bizwebform_col_2"><input name="cardSerial" class="bizwebform" type="text" maxlength="16" required
                                                autocomplete="off"
                                                onchange="checkCardSerial(this.value, '<?php echo $opt; ?>', 'cardSerialID');"
                                                value="<?php //if ($opt == "vtc") echo "PM"; ?>"/></td>
            <td class="bizwebform_col_3" id="cardSerialID"></td>
        </tr>
<!--        <tr>-->
<!--            <td class="bizwebform_col_1">Mệnh giá thẻ</td>-->
<!--            <td class="bizwebform_col_2">-->
<!--                <select size="1" name="Denominations" id="bizwebselect" onchange="checkDenominations(this.value);">-->
<!--                    <option value="" selected="selected"> -- Chọn mệnh giá thẻ nạp --</option>-->
<!--                    --><?php //if ($card_list) foreach ($card_list as $id => $val) {
//                        echo '<option value="' . $id . '"> Thẻ ' . number_format($val, 0, ",", ".") . ' VNĐ</option>';
//                    } ?>
<!--                </select>-->
<!--            </td>-->
<!--            <td class="bizwebform_col_3" id="DenominationsID"></td>-->
<!--        </tr>-->
        <tr>
            <td class="bizwebform_col_1">Nhập mã xác nhận <span class="required">*</span></td>
            <td class="bizwebform_col_2"><input id="verifyCaptcha" type="text" class="bizwebform" name="verifyCaptcha" required autocomplete="off"
                                                onchange="checkCaptcha(this.value, 'msg_Captcha');"/></td>
            <td class="bizwebform_col_3" id="msg_Captcha"></td>
        </tr>
        <tr>
            <td class="bizwebform_col_1"><a href="#" style="border-bottom: 1px dotted #000080;"
                                            onclick="getId('capchaWeb').src='/captcha.php?page=web&r='+Math.random(); return(false);">
                    Refresh code</a></td>
            <td colspan="" class="bizwebform_col_2" style="padding-left:20px;">
                <div class="vertical-img"><img src="/captcha.php?cap=web"
                                               id="capchaWeb" alt=""></div>
            </td>
            <td class="bizwebform_col_3"></td>
        </tr>
        <tr align="middle">
            <td colspan="100%" class="pd-top15">
                <img id="actionCard" class="cursor" alt="update" src="<?php echo URL_PATH_IMG; ?>/capnhat.png" style="padding-right:10px">
                <img style="cursor:pointer" border="0" onclick="document.getElementById('fromCard').reset();" src="<?php echo URL_PATH_IMG; ?>/cancel.png"
                     style="padding-left:10px">
            </td>
        </tr>
    </table>
</form>

<div class="show">
    <div class="">DANH SÁCH ĐÂ NẠP</div>
    <div class="vertical-img"><img src="<?php echo URL_PATH_IMG; ?>/vertical-separator.jpg" width="100%"
                                   height="1px"/></div>
    <div class="show_history_card">
        <?php if (empty($show_history)) {
            echo '<div class="mg-top15 cRed mg-left15">Bạn chưa nạp thẻ nào. </div>';
        }else {
            echo $show_history;
        }?>
    </div>
</div>

<div class="clear"></div>
<div class="sub_ranking mg-top15">
    <div class="">THÔNG TIN TRỊ GIÁ</div>
    <div class="vertical-img"><img src="<?php echo URL_PATH_IMG; ?>/vertical-separator.jpg" width="100%"
                                   height="1px"/></div>

    <table class="ranking" width="100%" class="mg-top10">
        <tr>
            <th class="lbg">Mệnh giá (VNĐ)</th>
            <th class="lbg">Khuyến mại %</th>
            <th class="rbg"><span>V.Point</span></th>
        </tr>
        <?php if ($card_list) {
            foreach ($card_list as $key => $items) {
                $itemsTmp = $items * $pt_km * 0.01 + $items;
                echo '<tr><td>' . number_format($items, 0, ',', '.');
                echo '</td><td>' . $pt_km;
                echo '</td><td>' . number_format($itemsTmp, 0, ',', '.') . '</td></tr>';
            }
        } ?>
    </table>
</div>


