<?php
echo cn_snippet_messages(); ?>

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

