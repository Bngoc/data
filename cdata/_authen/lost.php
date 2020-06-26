<h2>Quên mật khẩu</h2>
<p>Nhập tài tài khoản và địa chỉ email</p>
<hr><br>
<form action="<?php echo PHP_SELF; ?>" method="POST">

    <input type="hidden" name="registerweb"/>
    <input type="hidden" name="lostpassweb"/>

    <table>
        <tr>
            <td>Username</td>
            <td>Email</td>
        </tr>
        <tr>
            <td><input class="bizwebform" style="width: 150px;" autocomplete="off" type="text" maxlength="10" required
                       name="usernameWeb"/>
            <td><input class="bizwebform" style="width: 150px;" type="email" name="emailWeb" autocomplete="off"
                       required/></td>
            <td><input type="image" src="/public/images/sendemail.png"></td>
        </tr>
    </table>
</form>
