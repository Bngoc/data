<?php
list($isAuthEmail, $errors_result) = _GL('isAuthEmail, errors_result');

echo cn_snippet_messages();

if ($errors_result) {
    cn_messages_show($errors_result, 'e');
}
?>


<table style="width: 100%" cellpadding="2">
    <form id="formRegist" action="<?php echo PHP_SELF; ?>" method="POST">
        <?php echo cn_snippet_get_hidden(); ?>

        <tr>
            <td colspan="3" class="code-verify">THAY ĐỔI PASS-WEB<br/></td>
        </tr>
        <tr>
            <td colspan="3">
                <div class="vertical-img"><img src="<?php echo URL_PATH_IMG; ?>/vertical-separator.jpg" width="100%"
                                               height="1px"/></div>
                <br/>
            </td>
        </tr>
        <tr>
        <tr>
            <td class="bizwebform_col_1">Mật khẩu Web <span class="required">*</span></td>
            <td class="bizwebform_col_2"><input class="bizwebform" class="txt_160" name="cpass_web" type="password"
                                                id="pass1"
                                                required="required" maxlength="15"
                                                onkeypress="valid_pass(this.value, 'cmsg_passweb','mật khẩu');"/></td>
            <td class="bizwebform_col_3" id="cmsg_passweb"></td>
        </tr>
        <tr>
            <td class="bizwebform_col_1">Xác nhận mật khẩu Web <span class="required">*</span></td>
            <td class="bizwebform_col_2"><input class="bizwebform" class="txt_160" name="crepass_web" type="password"
                                                id="repass1" required="required"
                                                maxlength="15"
                                                onchange="verify_valida(this.value, 'cpass_web', 'cremsg_passweb', 'mật khẩu');"
            </td>
            <td class="bizwebform_col_3" id="cremsg_passweb"></td>
        </tr>

        <tr>
            <td colspan="3" class="code-verify">MÃ XÁC NHẬN</td>
        </tr>
        <tr>
            <td colspan="3">
                <div class="vertical-img"><img src="<?php echo URL_PATH_IMG; ?>/vertical-separator.jpg" width="100%"
                                               height="1px"/></div>
                <br/></td>
        </tr>
        <tr>
            <td class="bizwebform_col_1"><a href="#" style="border-bottom: 1px dotted #000080;"
                                            onclick="getId('capchaWeb').src='<?php echo getoption('http_script_dir'); ?>/captcha.php?page=web&r='+Math.random(); return(false);">
                    Refresh code</a></td>
            <td colspan="" class="bizwebform_col_2" style="padding-left:20px;">
                <div class="vertical-img"><img src="<?php echo getoption('http_script_dir'); ?>/captcha.php?cap=web"
                                               id="capchaWeb" alt=""></div>
            </td>
            <td class="bizwebform_col_3"></td>
        </tr>
        <tr>
            <td class="bizwebform_col_1">Nhập mã xác nhận <span class="required">*</span></td>
            <td class="bizwebform_col_2"><input type="text" class="bizwebform" name="cnameCaptcha"
                                                onchange="checkCaptcha(this.value, 'msg_Captcha');"/></td>
            <td class="bizwebform_col_3" id="msg_Captcha"></td>
        </tr>

        <?php
        if (!$isAuthEmail) { ?>
            <tr>
                <td class="bizwebform_col_1">Ðịa chỉ Email <span class="required">*</span></td>
                <td class="bizwebform_col_2"><input name="cnameEmail" class="bizwebform" type="email" maxlength="40"
                                                    autocomplete="off" onchange="checkEmail(this.value,'checkemail');"
                                                    value="<?php echo isset($_POST['cnameEmail']) ? $_POST['cnameEmail'] : ''; ?>"/>
                </td>
                <td class="bizwebform_col_3" id="checkemail"></td>
            </tr>
        <?php } ?>
        <tr>
            <td colspan="3" class="pd-top20" style="text-align:center">
                <input type="hidden" value="deleoffline" name="action_deleoffline"/>
                <input type="image" src="<?php echo URL_PATH_IMG; ?>/capnhat.png" style="padding-right:10px">
                <img style="cursor:pointer" onclick="document.getElementById('formRegist').reset();" border="0"
                     src="<?php echo URL_PATH_IMG; ?>/cancel.png"
                     style="padding-left:10px">
            </td>
        </tr>
    </form>
</table>




