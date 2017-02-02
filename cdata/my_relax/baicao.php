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
            <td colspan="3" class="">BÀI CÁO<br/></td>
        </tr>
        <tr>
            <td colspan="3">
                <div class="vertical-img"><img src="<?php echo URL_PATH_IMG; ?>/vertical-separator.jpg" width="100%"
                                               height="1px"/></div>
                <br/></td>
        </tr>
    </table>
    <center>
        <form action='<?php echo PHP_SELF; ?>' method='POST' id="from-playbaicao" onsubmit="return false;">
            <?php echo cn_form_open('mod, opt, sub'); ?>
            <input name='action_playbaicao' type='hidden' value='play'>
            <div class="play-baicao">
                <div class="custom-height result"></div>
                <div class="btn-play">
                    Tiền đặt cược<span class="required">*</span>
                    <input type='number' name='bet' id="changeNumber" class="bizwebform" required/> Vpoint
                    <div class="clear"></div>
                    <input type='button' class="call-playbaicao btn mg-top15 mg-bottom5" value='Chia bài'>
                </div>
            </div>
        </form>
        <hr>
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
                <div class="vertical-img"><img src="/images/vertical-separator.jpg" width="100%" height="1px"></div>
                <br></td>
        </tr>
        </tbody>
    </table>
    <table width='100%' border='0' align='center' cellpadding='0' cellspacing='0'>
        <tr>
            <td align='left'>
                - Bạn hãy đặt tiền và chia bài để bắt đầu trò chơi.
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