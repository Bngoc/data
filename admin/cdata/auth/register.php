<?php

list($errors_result, $userName, $email) = _GL('errors_result, userName, email');

?>
<style>.required {
        color: red;
    }</style>

<form name=login action="<?php echo PHP_SELF; ?>?register" method="post">
    <input type="hidden" name="action" value="register">
    <table>

        <tr>
            <td colspan="3"><?php if ($errors_result) { ?>Errors:
                    <ol><?php foreach ($errors_result as $result) echo "<li style='color: red; font-weight: bold;'>$result</li>"; ?></ol>
                    <hr/><?php } ?></td>
        </tr>

        <tr>
            <td width=85>Username: <span class="required">*</span></td>
            <td colspan="2"><input tabindex="1" type="text" name="userName"
                                   value="<?php echo cnHtmlSpecialChars($userName); ?>" style="width:134px"
                                   size="20"></td>
        </tr>
        <tr>
            <td width=85>Email: <span class="required">*</span></td>
            <td colspan="2"><input tabindex="1" type="text" name="email"
                                   value="<?php echo cnHtmlSpecialChars($email); ?>" style="width:134px" size="20">
            </td>
        </tr>

        <tr>
            <td width=85>Password: <span class="required">*</span></td>
            <td>
                <div><input tabindex="1" type="password" name=password id="password"
                            onkeyup="password_strength();" style="width:134px" size="20"></div>
                <div id="password_strength"></div>
            </td>
            <td>&nbsp;<input type="text" style="border: none; width: 150px;" id="pass_msg" disabled="true"
                             value="Enter password"></td>
        </tr>

        <tr>
            <td width=85>Confirm: <span class="required">*</span></td>
            <td colspan="2"><input tabindex="1" type="password" name="confirm" style="width:134px" size="20"></td>
        </tr>

        <tr>
            <td width=85>Captcha: <span class="required">*</span></td>
            <td colspan="2"><input tabindex="1" autocomplete="on" type="text" name="captcha" style="width:134px" size="20"></td>
        </tr>

        <tr>
            <td width=85><a href="#" style="border-bottom: 1px dotted #000080;"
                            onclick="getId('captcha').src='<?php echo getOption('http_script_dir'); ?>/captcha.php?page=admin&r=' +Math.random(); return(false);">Refresh
                    code</a></td>
            <td colspan="2"><img src="<?php echo getOption('http_script_dir'); ?>/captcha.php?page=admin" id="captcha" alt="">
            </td>
        </tr>

        <tr>
            <td>&nbsp;</td>
            <td colspan="2"><input accesskey="s" type=submit style="background-color: #F3F3F3;" value='Register'></td>
        </tr>

    </table>
</form>
