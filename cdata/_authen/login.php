<?php

//$last_user_name = '';

cn_snippet_messages();
//cn_snippet_bc();
?>

<!-------------------------------------------------- -->
<form name="" method="post" action="<?php echo PHP_SELF; ?>">
    <input name="action" value="dologin" type="hidden">
    <div class="login_info">
        <input placeholder="Account" name="Account" id="login_username" type="text" maxlength="10"/>
        <div class="pad_2px"></div>
        <input placeholder="Password" name="Password" id="login_password" type="password" maxlength="10"/>
    </div>
    <div class="signin_btn"><input src="<?php echo(getoption('http_script_dir')); ?>/images/signin_btn.jpg" alt=""
                                   type="image"/></div>
</form>
<div class="clear"></div>
<div class="login_text">
    » <a href="?register&lostpass"><strong>Quên mật khẩu</strong></a>
    <br/>
    » <a href="?register"><strong>Ðăng ký tài khoản</strong></a>
</div>

<!--
<form  name="login" id="login_form" action='<?php //echo PHP_SELF; ?>' method="post">

    <input type="hidden" name="action" value="dologin">
    <table width="100%">
        <tr>
            <td width='80'>Username: </td>
            <td width='160'><input tabindex=1 type="text" name="username" id="login_username" value="<?php //echo $last_user_name; ?>" style="width: 150px;"></td>
            <td>&nbsp;<?php //if (getoption('allow_registration')) { ?><a href="?register">(register)</a><?php //} ?></td>
        </tr>
        <tr>
            <td>Password: </td>
            <td><input tabindex="1" type="password" name="password" id="login_password" style='width: 150px'></td>
            <td>&nbsp;<a href="?register&lostpass">(lost password)</a> </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td style='text-align:left'>
                <input tabindex=1 accesskey='s' type=submit style="width:150px; background-color: #F3F3F3;" value='      Login...      '><br/>
            </td>
            <td style='text-align:left'><label for=rememberme title='Remember me for 30 days, Do not use on Public-Terminals!'>
                    <input id=rememberme type=checkbox value=yes style="border:0px;" name=rememberme>Remember Me</label>
            </td>
        </tr>

    </table>
</form>
-->
<!-------------------------------------------------- -->
