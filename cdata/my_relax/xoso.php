<?php
list ($resultDe, $timesTampResult, $show_history) = _GL('resultPlayDe, timesTampResult, show_history');

?>
<div id="msg-Show"></div>
<table class='sort-table' cellpadding='0' border='0' width="100%" ;>
    <tr>
        <td colspan="100%" class="">CHƠI ĐỀ<br/></td>
    </tr>
    <tr>
        <td colspan="100%">
            <div class="vertical-img"><img src="<?php echo URL_PATH_IMG; ?>/vertical-separator.jpg" width="100%"
                                           height="1px"/></div>
            <br/></td>
    </tr>
    <tr align="middle">
        <td align="right" width="55%"><strong>Kết Quả Đề </strong><?php echo date('l, d-m-Y', $timesTampResult); ?>:
        </td>
        <td align="left">
            <div class="cRed pd-left15"><strong><?php echo $resultDe; ?></strong></div>
        </td>
    </tr>
</table>
<center>
    <form action='<?php echo PHP_SELF; ?>' method='POST' id="from-playDe" onsubmit="return false;">
        <?php echo cn_form_open('mod, opt, sub'); ?>
        <input name='action_playDe' type='hidden' value='play'>
        <table width="100%" class="mg-top15" align="center">
            <tr>
                <td class="bizwebform_col_1" align="right">Đánh số Đề <span class="required">*</span></td>
                <td class="bizwebform_col_2"><input type='number' id="numberDe" name='numberDe' max="99" min="0"
                                                    class="changeNumber bizwebform width90" required/></td>
                <td class="bizwebform_col_3" align="left"></td>
            </tr>
            <tr>
                <td class="bizwebform_col_1" align="right">Tiền đặt cược<span class="required">*</span></td>
                <td class="bizwebform_col_2"><input type='number' id="" name='moneyVpDe'
                                                    class="changeNumber bizwebform width90" required/></td>
                <td class="bizwebform_col_3" align="left">Vpoint</td>
            </tr>
            <tr>
                <td class="bizwebform_col_1">Nhập mã xác nhận <span class="required">*</span></td>
                <td class="bizwebform_col_2"><input id="verifyCaptcha" type="text" class="bizwebform width90"
                                                    name="verifyCaptcha" required autocomplete="off"
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
            <tr>
                <td colspan="3" style="text-align:center">
                    <img src="/public/images/capnhat.png" class="cursor" style="padding-right:10px" alt="update"
                         id="actionDe">
                    <img style="cursor:pointer" border="0" src="/public/images/cancel.png"
                         onclick="document.getElementById('from-playDe').reset();" style="padding-left:10px">
                </td>
            </tr>
        </table>
    </form>
</center>
<br>
<span colspan="100%" class="mg-top15 textUpcase textBold">LỊCH SỬ CHƠI</span>
<hr>
<div class="show-history">
    <?php if (empty($show_history)) {
        echo '<div class="mg-top15 cRed mg-left15">Bạn chưa ghi đề. </div>';
    } else {
        echo $show_history;
    } ?>
</div>

<table style="width: 100%" cellpadding="2">
    <tbody>
    <tr>
        <td colspan="3" style="padding-top:15px; text-align:center"></td>
    </tr>
    <tr>
        <td colspan="3" class="textUpcase textBold">Hướng dẫn chơi</td>
    </tr>
    <tr>
        <td colspan="3">
            <div class="vertical-img"><img src="/public/images/vertical-separator.jpg" width="100%" height="1px"></div>
            <br></td>
    </tr>
    </tbody>
</table>
<table width='100%' border='0' align='center' cellpadding='0' cellspacing='0'>
    <tr>
        <td align='left'>
            - 1 Vpoint = 1* 70 Vpoint;<br>
            - Thời gian ghi số để bắt đầu 00h đến <?php
            if ($timeWriterLimit = getoption('timeWriterLimit')) {
                $strTimeLimit = substr_replace($timeWriterLimit, 'h', strrpos($timeWriterLimit, ':'), 0);
                echo $strTimeLimit . '\'';
            } ?>.<br>

            - Thời gian trả kết quả là <?php if ($timeResultDe = getoption('timeResultDe')) {
                $strTimeResultDe = substr_replace($timeResultDe, 'h', strrpos($timeResultDe, ':'), 0);
                echo $strTimeResultDe . '\'';
            } ?> ngày hôm sau.<br>
            - Số tiền tối thiểu nhận ghi đề <?php echo number_format(getoption('moneyMinDe'), 0, ',', '.'); ?>
            (Vpoint)
        </td>
    </tr>
</table>
