<?php

cn_snippet_messages();
?>
<form action="<?php echo PHP_SELF; ?>" method="POST">
    <table>
        <tr>
            <td valign="top">
                <table class="panel">
                    <tr>
                        <td>Username</td>
                        <td><input type="text" name="username" value="<?php echo REQ('username', 'POST'); ?>"/></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td><input type="text" name="email" value="<?php echo REQ('email', 'POST'); ?>"/></td>
                    </tr>
                    <tr>
                        <td>Password</td>
                        <td><input type="password" name="password1"/></td>
                    </tr>
                    <tr>
                        <td>Confirm</td>
                        <td><input type="password" name="password2"/></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td><input type="submit" value="Create admin Account"/></td>
                    </tr>
                </table>
            </td>
            <td valign="top" style="padding: 0 0 0 32px; font-size: 18px; color: #888;">
            </td>
        </tr>
    </table>
</form>
