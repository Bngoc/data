<?php

//list($errors_result, $regusername, $regnickname, $regemail) = _GL('errors_result, regusername, regnickname, regemail');
list($errors_result) = _GL('errors_result');
?>

<!-------------------------------------------------- -->
<form id="form" method="post" name="frmRegister" action="<?php echo PHP_SELF; ?>?register"
      onSubmit="return validateFormOnSubmit();">
    <table style="width: 100%" cellpadding="2">
        <tr>
            <td colspan="3"><?php if ($errors_result) { ?>Errors:
                    <ol><?php foreach ($errors_result as $result) echo "<li style='color: red; font-weight: bold;'>$result</li>"; ?></ol>
                    <hr/><?php } ?></td>
        </tr>
        <tr>
            <td colspan="3" class="sub_title_1st">THÔNG TIN ÐĂNG KÝ</td>
        </tr>
        <tr>
            <td colspan="3">
                <div class="vertical-img"><img src="<?php echo URL_PATH_IMG ?>/vertical-separator.jpg" width="640"
                                               height="1px"/></div>
            </td>
        </tr>
        <tr>
            <td class="bizwebform_col_1">Tên tài khoản <span class="required">*</span></td>
            <td class="bizwebform_col_2"><input name="Account" class="bizwebform"
                                                onkeypress="return isAlphabetKey(event,'UserID')" type="text"
                                                placeholder="eg. myaccount90" maxlength="15" required
                                                pattern="[a-z0-9]+"
                                                onchange="findNewUser(this.value,'UserID','tài khoản');"/><span
                    id="error_noti"></span></td>
            <td class="bizwebform_col_3" id="UserID"></td>
        </tr>
        <tr>
            <td class="bizwebform_col_1">Mật khẩu <span class="required">*</span></td>
            <td class="bizwebform_col_2"><input name="pwd" id="abc_paws" class="bizwebform"
                                                onchange="return valid_multi(this.value,'pass_msg','mật khẩu'), verify_valida(this.value,'re_pwd','repwd_smg','mật khẩu',false);"
                                                onkeyup="pwd_strength('abc_paws','pwd_color','pass_msg');"
                                                type="password" placeholder="eg. My8Pass@9oK" required pattern=".{6,}"
                                                title="six or more character"/>
                <div id="pwd_color"></div>
            </td>
            <td class="bizwebform_col_3" id="pass_msg">&nbsp;<input type="text" style="border: none; width: 150px;"
                                                                    id="" disabled="true" value="Enter password"></td>
        </tr>
        <tr>
            <td class="bizwebform_col_1">Xác nhận mật khẩu <span class="required">*</span></td>
            <td class="bizwebform_col_2"><input name="re_pwd" class="bizwebform" type="password" maxlength="10"
                                                placeholder="eg. My8Pass@9oK" required="required"
                                                onchange="verify_valida(this.value,'pwd','repwd_smg','mật khẩu');"/>
            </td>
            <td class="bizwebform_col_3" id="repwd_smg"></td>
        </tr>
        <tr>
            <td colspan="3" class="sub_title_1st">THÔNG TIN CÁ NHÂN</td>
        </tr>
        <tr>
            <td colspan="3">
                <div class="vertical-img"><img src="<?php echo URL_PATH_IMG ?>/vertical-separator.jpg" width="640"
                                               height="1px"/></div>
            </td>
        <tr>
            <td class="bizwebform_col_1">Mã số bí mật <span class="required">*</span></td>
            <td class="bizwebform_col_2"><input name="num_7_verify" class="bizwebform" type="password" maxlength="7"
                                                onkeypress="return isNumKey(event,'err_num7')"
                                                onchange="check_num(this.value,7,'err_num7','Mã số');"/></td>
            <td class="bizwebform_col_3" id="err_num7"></td>
        </tr>
        </tr>
        <td class="bizwebform_col_1">Mật khẩu Web <span class="required">*</span></td>
        <td class="bizwebform_col_2"><input class="bizwebform" class="txt_160" name="pass1" type="password" id="pass1"
                                            placeholder="eg. My8Pass@9oK" required="required" maxlength="15"
                                            onfocus="focus_chuso(this.value,'msg_'+this.name);"
                                            onkeyup="check_chuso_4_20(this.value,'msg_'+this.name)"/> <label
                id="msg_pass1" class="msg"></label></td>
        <td class="bizwebform_col_3" id="PhoneNumberID"></td>
        </tr>
        <tr>
            <td class="bizwebform_col_1">Xác nhận mật khẩu Web <span class="required">*</span></td>
            <td class="bizwebform_col_2"><input class="bizwebform" class="txt_160" name="repass1" type="password"
                                                id="repass1" placeholder="eg. My8Pass@9oK" required="required"
                                                maxlength="15" onfocus="focus_chuso(this.value,'msg_'+this.name);"
                                                onblur="onblur_check_repass(this.form.pass1.value,this.value,'msg_'+this.name)">
                <label id="msg_repass1" class="msg"></label></td>
            <td class="bizwebform_col_3" id="PhoneNumberID"></td>
        </tr>
        <tr>
<!--            <td class="bizwebform_col_1">Mật khẩu Web cấp 2 <span class="required">*</span></td>-->
<!--            <td class="bizwebform_col_2"><input class="bizwebform" class="txt_160" name="pass2" type="password"-->
<!--                                                id="pass2" placeholder="eg. My8Pass@9oK" required="required"-->
<!--                                                maxlength="15" onfocus="focus_chuso(this.value,'msg_'+this.name);"-->
<!--                                                onkeyup="check_chuso_4_20(this.value,'msg_'+this.name)"/> <label-->
<!--                    id="msg_pass2" class="msg"></label></td>-->
<!--            <td class="bizwebform_col_3" id="PhoneNumberID"></td>-->
<!--        </tr>-->
<!--        <tr>-->
<!--            <td class="bizwebform_col_1">Xác nhận mật khẩu Web cấp 2 <span class="required">*</span></td>-->
<!--            <td class="bizwebform_col_2"><input class="bizwebform" class="txt_160" name="repass2" type="password"-->
<!--                                                id="repass2" placeholder="eg. My8Pass@9oK" required="required"-->
<!--                                                maxlength="15" onfocus="focus_chuso(this.value,'msg_'+this.name);"-->
<!--                                                onblur="onblur_check_repass(this.form.pass2.value,this.value,'msg_'+this.name)">-->
<!--                <label id="msg_repass2" class="msg"></label></td>-->
<!--            <td class="bizwebform_col_3" id="PhoneNumberID"></td>-->
<!--        </tr>-->
<!--        <tr>-->
        <tr>
            <td class="bizwebform_col_1">Ðịa chỉ Email <span class="required">*</span></td>
            <td class="bizwebform_col_2"><input name="email" class="bizwebform" type="email" maxlength="40"
                                                autocomplete="off" onchange="checkEmail(this.value,'id_checkemail');"/>
            </td>
            <td class="bizwebform_col_3" id="id_checkemail"></td>
        </tr>
<!--        <tr>-->
<!--            <td class="bizwebform_col_1">Xác nhận lại Email</td>-->
<!--            <td class="bizwebform_col_2"><input name="ReEmail" class="bizwebform" type="text" maxlength="40"-->
<!--                                                onchange="verify_valida(this.value,'email','err_smg_email','email');"/>-->
<!--            </td>-->
<!--            <td class="bizwebform_col_3" id="err_smg_email"></td>-->
<!--        </tr>-->
        <tr>
            <td class="bizwebform_col_1">Số điện thoại di động <span class="required">*</span></td>
            <td class="bizwebform_col_2"><input name="PhoneNumber" class="bizwebform" type="text" maxlength="15"
                                                onkeypress="return isNumKey(event,'PhoneNumberID')"
                                                onchange="checkPhoneNumber(this.value);"/></td>
            <td class="bizwebform_col_3" id="PhoneNumberID"></td>
        </tr>
        <tr>
            <td colspan="3" class="sub_title_1st">THÔNG TIN BẢO MẬT</td>
        </tr>
        <tr>
            <td colspan="3">
                <div class="vertical-img"><img src="<?php echo URL_PATH_IMG ?>/vertical-separator.jpg" width="640"
                                               height="1px"/></div>
            </td>
        </tr>
        <tr>
            <td class="bizwebform_col_1">Câu hỏi bí mật</td>
            <td class="bizwebform_col_2">
                <select size="1" name="Question" id="bizwebselect" onchange="checkQuestion(this.value);">
                    <option>-- Chọn câu hỏi bí mật --</option>
                    <option value="myPet" <?php //if ($_POST['Question']=='myPet') { ?>
                            selected="selected" <?php //} ?> >Tên con vật yêu thích?
                    </option>
                    <option value="mySchool" <?php //if ($_POST['Question']=='mySchool') { ?>
                            selected="selected" <?php //} ?> >Trường cấp 1 của bạn tên gì?
                    </option>
                    <option value="bestFriends" <?php //if ($_POST['Question']=='bestFriends') { ?>
                            selected="selected" <?php //} ?> >Người bạn yêu quý nhất?
                    </option>
                    <option value="favorGames" <?php //if ($_POST['Question']=='favorGames') { ?>
                            selected="selected" <?php //} ?> >Trò chơi bạn thích nhất?
                    </option>
                    <option value="unforgetArea" <?php //if ($_POST['Question']=='unforgetArea') { ?>
                            selected="selected" <?php //} ?> >Nơi để lại kỉ niệm khó quên nhất?
                    </option>
                </select>
            </td>
            <td class="bizwebform_col_3" id="checkQuestionID"></td>
        </tr>
        <tr>
            <td class="bizwebform_col_1">Câu trả lại bí mật <span class="required">*</span></td>
            <td class="bizwebform_col_2"><input name="Answer" class="bizwebform" type="text" maxlength="40"
                                                autocomplete="off" onchange="checkAnswer(this.value);"/></td>
            <td class="bizwebform_col_3" id="AnswerID"></td>
        </tr>

        <tr>
            <td colspan="3" class="sub_title_1st">MÃ XÁC NHẬN</td>
        </tr>
        <tr>
            <td colspan="3">
                <div class="vertical-img"><img src="<?php echo URL_PATH_IMG ?>/vertical-separator.jpg" width="640"
                                               height="1px"/></div>
            </td>
        </tr>
        <tr>
            <td class="bizwebform_col_1"><a href="#" style="border-bottom: 1px dotted #000080;"
                   onclick="getId('capchaWeb').src='/admin/captcha.php?page=web&r='+Math.random(); return(false);">
                    Refresh code</a></td>
            <td colspan="" class="bizwebform_col_2" style="padding-left:20px;"><div class="vertical-img"><img src="/admin/captcha.php?cap=web" id="capchaWeb" alt=""></div></td>
            <td class="bizwebform_col_3"></td>
        </tr>
        <tr>
            <td class="bizwebform_col_1">Nhập mã xác nhận <span class="required">*</span></td>
            <td class="bizwebform_col_2"><input type="text" name=""></td>
            <td class="bizwebform_col_3" id="msg_vImageCodP"></td>
        </tr>
        <tr>
            <td colspan="3" style="padding:20px; text-align:center"></td>
        </tr>
        <tr>
            <td colspan="3" style="text-align:center">
                <input type="hidden" value="register" name="register"/>
                <input type="image" src="<?php echo URL_PATH_IMG ?>/dangky.png" style="padding-right:10px">
                <img style="cursor:pointer" onclick="document.getElementById('frmRegister').reset();" border="0"
                     src="<?php echo URL_PATH_IMG ?>/cancel.png" style="padding-left:10px">
            </td>
        </tr>
    </table>
</form>

<!-- ----------------------------------------- -->
<!--
<style>.required { color: red; }</style>

<form  name=login action="<?php //echo PHP_SELF; ?>?register" method="post">
    <input type="hidden" name="action" value="register">
    <table>

        <tr>
            <td colspan="3"><?php //if ($errors_result) { ?>Errors: <ol><?php //foreach ($errors_result as $result) echo "<li style='color: red; font-weight: bold;'>$result</li>"; ?></ol><hr/><?php //} ?></td>
        </tr>

        <tr>
            <td width=85>Username: <span class="required">*</span></td>
            <td colspan="2"><input tabindex="1" type="text" name=regusername value="<?php //echo cn_htmlspecialchars($regusername); ?>" style="width:134px" size="20"></td>
        </tr>

        <tr>
            <td width=85>Nickname:</td>
            <td colspan="2"><input tabindex="1" type="text" name=regnickname value="<?php //echo cn_htmlspecialchars($regnickname); ?>" style="width:134px" size="20"></td>
        </tr>

        <tr>
            <td width=85>Password: <span class="required">*</span></td>
            <td>
                <div><input tabindex="1" type="password" name=regpassword id="regpassword" onkeyup="password_strength();" style="width:134px" size="20"></div>
                <div id="password_strength"></div></td>
            <td>&nbsp;<input type="text" style="border: none; width: 150px;" id="pass_msg" disabled="true" value="Enter password"></td>
        </tr>

        <tr>
            <td width=85>Confirm:  <span class="required">*</span></td>
            <td colspan="2"><input tabindex="1" type="password" name="confirm" style="width:134px" size="20"></td>
        </tr>

        <tr>
            <td width=85>Email: <span class="required">*</span></td>
            <td colspan="2"><input tabindex="1" type="text" name="regemail" value="<?php //echo cn_htmlspecialchars($regemail); ?>" style="width:134px" size="20"></td>
        </tr>

        <tr>
            <td width=85>Captcha: <span class="required">*</span></td>
            <td colspan="2"><input tabindex="1" type="text" name="captcha" style="width:134px" size="20"></td>
        </tr>

        <tr>
            <td width=85><a href="#" style="border-bottom: 1px dotted #000080;" onclick="getId('capcha').src='captcha.php?r='+Math.random(); return(false);">Refresh code</a></td>
            <td colspan="2"><img src="captcha.php" id="capcha" alt=""></td>
        </tr>

        <tr>
            <td>&nbsp;</td>
            <td colspan="2"><input accesskey="s" type=submit style="background-color: #F3F3F3;" value='Register'></td>
        </tr>

    </table>
</form>
-->
