<?php
//require("config.php");
//if ($muweb['baucua']=='0')
//{show("Server không bật chức năng này, nếu bạn muốn sử dụng hãy <a href='index.php?op=user&option=request'><u>liên hệ Admin</u></a>.");}
//else if ($muweb['baucua']=='1') {
//$page = "
?>
    <div id="msg-Show"></div>
    <table class='sort-table' cellpadding='0' border='0' width="100%" ;>
        <tr>
            <td colspan="3" class="">BẦU CUA<br/></td>
        </tr>
        <tr>
            <td colspan="3">
                <div class="vertical-img"><img src="<?php echo URL_PATH_IMG; ?>/vertical-separator.jpg" width="100%"
                                               height="1px"/></div>
                <br/></td>
        </tr>
    </table>
    <center>
        <form action='<?php echo PHP_SELF; ?>' method='POST' id="from-play" onsubmit="return false;">
            <?php echo cn_form_open('mod, opt, sub'); ?>
            <input name='action_playbaucua' type='hidden' value='play'>
            <table class='sort-table' cellpadding='0' border='0' width="60%">
                <tr align="middle">
                    <td class="img-height" style='background:url(/images/baucua/0.gif) no-repeat;'>
                        <input class="custom-checkbox" name='bet_0' type='checkbox' value='1'>
                    </td>
                    <td class="img-height" style='background:url(/public/images/baucua/1.gif) no-repeat;'>
                        <input class="custom-checkbox" name='bet_1' type='checkbox' value='1'>
                    </td>
                    <td class="img-height" style='background:url(/public/images/baucua/2.gif) no-repeat;'>
                        <input class="custom-checkbox" name='bet_2' type='checkbox' value='1'>
                    </td>
                </tr>
                <tr align="middle">
                    <td class="img-height" style='background:url(/public/images/baucua/3.gif) no-repeat'>
                        <input class="custom-checkbox" name='bet_3' type='checkbox' value='1'>
                    </td>
                    <td class="img-height" style='background:url(/public/images/baucua/4.gif) no-repeat'>
                        <input class="custom-checkbox" name='bet_4' type='checkbox' value='1'>
                    </td>
                    <td class="img-height" style='background:url(/public/images/baucua/5.gif) no-repeat'>
                        <input class="custom-checkbox" name='bet_5' type='checkbox' value='1'>
                    </td>
                </tr>
                <tr align="middle">
                    <td colspan="100" class="pd-top15">
                        Tiền đặt cược<span class="required">*</span>
                        <input type='number' name='bet' id="changeNumber" class="bizwebform" required/> Vpoint
                        <input type='button' class="call-play btn mg-top15" value='Mở ^_^'>
                    </td>
                </tr>
            </table>
        </form>
        <hr>
        <table class="">
            <tr align="middle" class="result-play"></tr>
            <tr class="">
                <td colspan="100" class="result"></td>
            </tr>
        </table>
    </center>

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
                <div class="vertical-img"><img src="/public/images/vertical-separator.jpg" width="100%" height="1px">
                </div>
                <br></td>
        </tr>
        </tbody>
    </table>
    <table width='100%' border='0' align='center' cellpadding='0' cellspacing='0'>
        <tr>
            <td align='left'>
                - Bạn hãy chọn ít nhất 1 hình ở trên (có thể chọn 1-6).<br>
                - Điền số tiền (Vpoint) mình đặt cược và ấn Mở bát để xem kết quả.
            </td>
        </tr>
    </table>

<?php

//echo "<table width='375' border='0' align='center' cellpadding='0' cellspacing='0'><tr><td><div align='center'>";
//if ($_POST['baucua_play']) {
//    dobaucua();
//} else {
//    show("<div align='center'><a href='index.php?op=bank&option=baucua'>Bầu cua</a> | <a href='index.php?op=bank&option=baicao'>Bài cào</a></font></div>");
//    bank_info($_SESSION['user']);
//    echo $page;
//}
//echo "</div></td></tr></table>";


?>
