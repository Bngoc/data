<?php
list($errors_result, $tabActive) = _GL('errors_result, tabActive');

echo cn_snippet_messages();

if ($errors_result) {
    cn_messages_show($errors_result, 'e');
}
?>

<form id="formChangeRegist" action="<?php echo PHP_SELF; ?>" method="POST">
    <?php echo cn_snippet_get_hidden(); ?>
    <input type="hidden" name="nameActive" id="tabActive" value="<?php echo $tabActive; ?>">
    <table style="width: 100%" cellpadding="2">
        <tr>
            <td colspan="3" class="code-verify">THAY ĐỔI CÂU HỎI - TRẢ LỜI BÍ MẬT<br/></td>
        </tr>
        <tr>
            <td colspan="3">
                <div class="vertical-img"><img src="<?php echo URL_PATH_IMG; ?>/vertical-separator.jpg"
                                               width="100%" height="1px"/></div>
                <br/>
            </td>
        </tr>
        <tr>
            <td>Thay đổi</td>
            <td colspan=""><label for="radio1"><input id="radio1" type="radio"
                                                      name="cars" <?php if ($tabActive == 'Q') echo 'checked'; ?>
                                                      value="Q"/> Câu hỏi bí mật </label></td>
            <td><label for="radio2"><input id="radio2" type="radio"
                                           name="cars" <?php if ($tabActive == 'A') echo 'checked'; ?> value="A"/> Câu
                    trả lại bí mật </label></td>
        </tr>
        <tr id="Cars-Q" class="desc" <?php if ($tabActive != 'Q') echo 'style="display:none"'; ?>>
            <td class="bizwebform_col_1">Câu hỏi bí mật <span class="required">*</span></td>
            <td class="bizwebform_col_2">
                <select size="1" name="cnameQuestion" id="bizwebselect"
                        onchange="checkQuestion(this.value, 'checkQuestionID');">
                    <?php
                    $question_answers = getoption('question_answers');
                    $arrQA = explode(',', $question_answers);
                    $fg = isset($_POST['cnameQuestion']) ? $_POST['cnameQuestion'] : null;
                    foreach ($arrQA as $key => $item) {
                        echo '<option ' . ($fg == ($key + 1) ? 'selected' : '') . ' value="' . ($key + 1) . '">' . $item . '? </option>';
                    }
                    ?>
                </select>
            </td>
            <td class="bizwebform_col_3" id="checkQuestionID"></td>
        </tr>
        <tr id="Cars-A" class="desc" <?php if ($tabActive != 'A') echo 'style="display:none"'; ?>>
            <td class="bizwebform_col_1">Câu trả lại bí mật<span class="required">*</span></td>
            <td class="bizwebform_col_2"><input name="cnameAnswer" class="bizwebform" type="text" maxlength="15"
                                                autocomplete="off" onchange="checkAnswer(this.value, 'answerID');"
                                                value="<?php echo isset($_POST['cnameAnswer']) ? $_POST['cnameAnswer'] : ''; ?>"/>
            </td>
            <td class="bizwebform_col_3" id="answerID"></td>
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

        <tr>
            <td class="bizwebform_col_1">Ðịa chỉ Email <span class="required">*</span></td>
            <td class="bizwebform_col_2"><input name="xnameEmail" class="bizwebform" type="email" maxlength="40"
                                                autocomplete="off" onchange="verifyEmail(this.value,'checkemail');"
                                                value=""/>
            </td>
            <td class="bizwebform_col_3" id="checkemail"></td>
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

    </table>
</form>
