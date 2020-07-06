<?php

list($errors_result) = _GL('errors_result');
?>

<!-------------------------------------------------- -->
<form id="formRegist" method="POST" name="frmRegister" action="<?php echo PHP_SELF; ?>?register"
      onSubmit="return validateFormOnSubmit();">
    <table style="width: 100%" cellpadding="2">
        <tr>
            <td colspan="3"><?php if ($errors_result) { ?>Errors:
                    <ol><?php foreach ($errors_result as $result) {
                            echo "<li style='color: red; font-weight: bold;'>$result</li>";
                        } ?></ol>
                    <hr/><?php } ?></td>
        </tr>
        <tr>
            <td colspan="3" class="sub_title_1st">THÔNG TIN ÐĂNG KÝ</td>
        </tr>
        <tr>
            <td colspan="3">
                <div class="vertical-img"><img src="<?php echo URL_PATH_IMG ?>/vertical-separator.jpg" width="100%"
                                               height="1px"/></div>
            </td>
        </tr>
        <tr>
            <td class="bizwebform_col_1">Tên tài khoản <span class="required">*</span></td>
            <td class="bizwebform_col_2"><input name="nameAccount" class="bizwebform" id="" autocomplete="off"
                                                value="<?php echo isset($_POST['nameAccount']) ? $_POST['nameAccount'] : ''; ?>"
                                                onkeypress="isAlphabetKey(event, 'userID');"
                                                onkeyup="findNewUser(this.value, 'userID', 'tài khoản');"
                                                type="text" placeholder="eg. myaccount90" maxlength="10" required/>
                <span id="error_noti"></span></td>
            <td class="bizwebform_col_3" id="userID"></td>
        </tr>
        <tr>
            <td class="bizwebform_col_1">Mật khẩu <span class="required">*</span></td>
            <td class="bizwebform_col_2"><input name="pwd" id="abc_paws" class="bizwebform"
                                                onchange="return valid_pass(this.value, 'pass_msg','mật khẩu'); verify_valida(this.value,'re_pwd','repwd_smg','mật khẩu');"
                                                onkeyup="pwd_strength(this.id, 'pwd_color', 'pass_msg');"
                                                type="password" placeholder="eg. My8Pass@9oK" required pattern=".{6,}"
                                                title="six or more character"/>
                <div id="pwd_color"></div>
            </td>
            <td class="bizwebform_col_3" id="pass_msg"></td>
        </tr>
        <tr>
            <td class="bizwebform_col_1">Xác nhận mật khẩu <span class="required">*</span></td>
            <td class="bizwebform_col_2"><input name="re_pwd" class="bizwebform" type="password" maxlength="15"
                                                placeholder="eg. My8Pass@9oK" required="required"
                                                onchange="verify_valida(this.value, 'pwd', 'repwd_smg','mật khẩu');"/>
            </td>
            <td class="bizwebform_col_3" id="repwd_smg"></td>
        </tr>
        <tr>
            <td colspan="3" class="sub_title_1st">THÔNG TIN CÁ NHÂN</td>
        </tr>
        <tr>
            <td colspan="3">
                <div class="vertical-img"><img src="<?php echo URL_PATH_IMG ?>/vertical-separator.jpg" width="100%"
                                               height="1px"/></div>
            </td>
        <tr>
            <td class="bizwebform_col_1">Mã số bí mật (7) <span class="required">*</span></td>
            <td class="bizwebform_col_2"><input name="num_7_verify" class="bizwebform" type="text" maxlength="7"
                                                autocomplete="off"
                                                onkeypress="return isNumKey(event,'err_num7');"
                                                onchange="check_num(this.value, 7, 'err_num7','Mã số');"
                                                value="<?php echo isset($_POST['num_7_verify']) ? $_POST['num_7_verify'] : ''; ?>"/>
            </td>
            <td class="bizwebform_col_3" id="err_num7"></td>
        </tr>
        <tr>
            <td class="bizwebform_col_1">Mật khẩu Web <span class="required">*</span></td>
            <td class="bizwebform_col_2"><input class="bizwebform" class="txt_160" name="pass_web" type="password"
                                                id="pass1"
                                                required="required" maxlength="15"
                                                onkeypress="valid_pass(this.value, 'msg_passweb','mật khẩu');"/></td>
            <td class="bizwebform_col_3" id="msg_passweb"></td>
        </tr>
        <tr>
            <td class="bizwebform_col_1">Xác nhận mật khẩu Web <span class="required">*</span></td>
            <td class="bizwebform_col_2"><input class="bizwebform" class="txt_160" name="repass_web" type="password"
                                                id="repass1" required="required"
                                                maxlength="15"
                                                onchange="verify_valida(this.value, 'pass_web', 'remsg_passweb', 'mật khẩu');"
            </td>
            <td class="bizwebform_col_3" id="remsg_passweb"></td>
        </tr>

        <tr>
            <td class="bizwebform_col_1">Ðịa chỉ Email <span class="required">*</span></td>
            <td class="bizwebform_col_2"><input name="nameEmail" class="bizwebform" type="email" maxlength="40"
                                                autocomplete="off" onchange="checkEmail(this.value,'checkemail');"
                                                value="<?php echo isset($_POST['nameEmail']) ? $_POST['nameEmail'] : ''; ?>"/>
            </td>
            <td class="bizwebform_col_3" id="checkemail"></td>
        </tr>
        <tr>
            <td class="bizwebform_col_1">Số điện thoại di động <span class="required">*</span></td>
            <td class="bizwebform_col_2"><input name="phoneNumber" class="bizwebform" type="text" maxlength="17"
                                                id="phoneNumber"
                                                autocomplete="off"
                                                onkeyup="renderPhoneTel(this.value, this.id); checkPhoneNumber(this.value, 'phoneNumberID');"
                                                value="<?php echo isset($_POST['phoneNumber']) ? $_POST['phoneNumber'] : ''; ?>"/>
            </td>
            <td class="bizwebform_col_3" id="phoneNumberID"></td>
        </tr>
        <tr>
            <td colspan="3" class="sub_title_1st">THÔNG TIN BẢO MẬT</td>
        </tr>
        <tr>
            <td colspan="3">
                <div class="vertical-img"><img src="<?php echo URL_PATH_IMG ?>/vertical-separator.jpg" width="100%"
                                               height="1px"/></div>
            </td>
        </tr>
        <tr>
            <td class="bizwebform_col_1">Câu hỏi bí mật <span class="required">*</span></td>
            <td class="bizwebform_col_2">
                <select size="1" name="nameQuestion" id="bizwebselect"
                        onchange="checkQuestion(this.value, 'checkQuestionID');">
                    <!--                    <option value="">-- Chọn câu hỏi bí mật --</option>-->
                    <?php
                    $arrQA = convert_question_answer();
                    $fg = isset($_POST['nameQuestion']) ? $_POST['nameQuestion'] : null;
                    foreach ($arrQA as $key => $item) {
                        echo '<option ' . ($fg === $key  ? 'selected' : '') . ' value="' . $key . '">' . $item . '</option>';
                    }
                    ?>
                </select>
            </td>
            <td class="bizwebform_col_3" id="checkQuestionID"></td>
        </tr>
        <tr>
            <td class="bizwebform_col_1">Câu trả lại bí mật <span class="required">*</span></td>
            <td class="bizwebform_col_2"><input name="nameAnswer" class="bizwebform" type="text" maxlength="15"
                                                autocomplete="off" onchange="checkAnswer(this.value, 'answerID');"
                                                value="<?php echo isset($_POST['nameAnswer']) ? $_POST['nameAnswer'] : ''; ?>"/>
            </td>
            <td class="bizwebform_col_3" id="answerID"></td>
        </tr>
        <tr>
            <td colspan="3" class="sub_title_1st">MÃ XÁC NHẬN</td>
        </tr>
        <tr>
            <td colspan="3">
                <div class="vertical-img"><img src="<?php echo URL_PATH_IMG ?>/vertical-separator.jpg" width="100%"
                                               height="1px"/></div>
            </td>
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
            <td class="bizwebform_col_2"><input type="text" class="bizwebform" name="nameCaptcha" required
                                                autocomplete="on"
                                                onchange="checkCaptcha(this.value, 'msg_Captcha');"/></td>
            <td class="bizwebform_col_3" id="msg_Captcha"></td>
        </tr>
        <tr>
            <td colspan="3" style="padding:20px; text-align:center"></td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: center; display: inline-flex">
                <input type="hidden" value="register" name="register"/>
                <input type="image" src="<?php echo URL_PATH_IMG ?>/dangky.png" style="padding-right:10px">
                <img style="cursor:pointer" onclick="document.getElementById('formRegist').reset();" border="0"
                     src="<?php echo URL_PATH_IMG ?>/cancel.png" style="padding-left:10px">
            </td>
        </tr>
    </table>
</form>
