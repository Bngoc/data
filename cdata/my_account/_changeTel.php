<?php
list($errors_result) = _GL('errors_result');

echo cn_snippet_messages();

if ($errors_result) {
    cn_messages_show($errors_result, 'e');
}
?>


<table style="width: 100%" cellpadding="2">
    <form id="formChangeRegist" action="<?php echo PHP_SELF; ?>" method="POST">
        <?php echo cn_snippet_get_hidden(); ?>

        <tr>
            <td colspan="3" class="code-verify">THAY ĐỔI SỐ ĐIỆN THOẠI<br/></td>
        </tr>
        <tr>
            <td colspan="3">
                <div class="vertical-img"><img src="<?php echo URL_PATH_IMG; ?>/vertical-separator.jpg" width="100%"
                                               height="1px"/></div>
                <br/>
            </td>
        </tr>
        <tr>
            <td class="bizwebform_col_1">Số điện thoại di động mới <span class="required">*</span></td>
            <td class="bizwebform_col_2"><input name="cphoneNumber" class="bizwebform" type="text" maxlength="17"
                                                id="cphoneNumber"
                                                autocomplete="off"
                                                onkeyup="renderPhoneTel(this.value, this.id); checkPhoneNumber(this.value, 'cphoneNumberID');"
                                                value="<?php echo isset($_POST['cphoneNumber']) ? $_POST['cphoneNumber'] : ''; ?>"/>
            </td>
            <td class="bizwebform_col_3" id="cphoneNumberID"></td>
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
                                            onclick="getId('captcha_web').src='<?php echo getOption('http_script_dir'); ?>/captcha.php?page=web&r='+Math.random(); return(false);">
                    Refresh code</a></td>
            <td colspan="" class="bizwebform_col_2" style="padding-left:20px;">
                <div class="vertical-img"><img src="<?php echo getOption('http_script_dir'); ?>/captcha.php?page=web"
                                               id="captcha_web" alt=""></div>
            </td>
            <td class="bizwebform_col_3"></td>
        </tr>
        <tr>
            <td class="bizwebform_col_1">Nhập mã xác nhận <span class="required">*</span></td>
            <td class="bizwebform_col_2"><input type="text" class="bizwebform" name="cnameCaptcha" required
                                                autocomplete="on"
                                                onchange="checkCaptcha(this.value, 'msg_Captcha');"/></td>
            <td class="bizwebform_col_3" id="msg_Captcha"></td>
        </tr>

        <tr>
            <td class="bizwebform_col_1">Câu hỏi bí mật <span class="required">*</span></td>
            <td class="bizwebform_col_2">
                <select size="1" name="cnameQuestion" id="bizwebselect"
                        onchange="checkQuestion(this.value, 'ccheckQuestionID');">
                    <!--                    <option value="">-- Chọn câu hỏi bí mật --</option>-->
                    <?php
                    $question_answers = getOption('question_answers');
                    $arrQA = explode(',', $question_answers);
                    $fg = isset($_POST['cnameQuestion']) ? $_POST['cnameQuestion'] : null;
                    foreach ($arrQA as $key => $item) {
                        echo '<option value="' . ($key + 1) . '">' . $item . '? </option>';
                    }
                    ?>
                </select>
            </td>
            <td class="bizwebform_col_3" id="ccheckQuestionID"></td>
        </tr>
        <tr>
            <td class="bizwebform_col_1">Câu trả lại bí mật <span class="required">*</span></td>
            <td class="bizwebform_col_2"><input name="cnameAnswer" class="bizwebform" type="text" maxlength="15"
                                                autocomplete="off" onchange="checkAnswer(this.value, 'canswerID');"
                                                value=""/>
            </td>
            <td class="bizwebform_col_3" id="canswerID"></td>
        </tr>
        <tr>
            <td colspan="3" class="pd-top20" style="text-align:center">
                <input type="hidden" value="deleoffline" name="action_deleoffline"/>
                <input type="image" src="<?php echo URL_PATH_IMG; ?>/capnhat.png" style="padding-right:10px">
                <img style="cursor:pointer" onclick="document.getElementById('formChangeRegist').reset();" border="0"
                     src="<?php echo URL_PATH_IMG; ?>/cancel.png"
                     style="padding-left:10px">
            </td>
        </tr>
    </form>
</table>




