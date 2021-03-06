<?php

cn_snippet_messages();
?>
<form action="<?php echo PHP_SELF; ?>" method="POST">
    <table>
        <tr>
            <td valign="top">
                <table class="panel">
                    <tr>
                        <td>Dạng kết nối Database</td>
                        <td>
                            <select name="type_connect" id="type_connect">
                                <option value="odbc">Odbc</option>
                                <option value="mssql">Mssql</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Server Name</td>
                        <td><input type="text" id="nameLocal" placeholder="(local)" name="nameLocal"
                                   value="<?php echo REQ('nameLocal', 'POST'); ?>"/></td>
                    </tr>
                    <tr>
                        <td>User quản lý SQL (thường là sa)</td>
                        <td><input type="text" id="nameSql" placeholder="sa" name="nameSql"
                                   value="<?php echo REQ('nameSql', 'POST'); ?>"/></td>
                    </tr>
                    <tr>
                        <td>Mật khẩu quản lý SQL</td>
                        <td><input type="password" id="pwdDb" name="pwdDb"/></td>
                    </tr>
                    <tr>
                        <td>Database sử dụng để lưu trữ thông tin MU</td>
                        <td><input type="text" id="nameSaveDb" placeholder="MuOnline" name="nameSaveDb"
                                   value="<?php echo REQ('nameSaveDb', 'POST'); ?>"/></td>
                    </tr>
                    <tr>
                        <td>Loại Server đang sử dụng</td>
                        <td>
                            <select name="server_type">
                                <option value="scf">SCF</option>
                                <option value="original">Original</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td><input type="submit" value="Create connect Database"/>
                            <input type="button" onclick="checkConnect()" value="Check Connect"/></td>
                    </tr>
                    <tr>
                        <td colspan="100%">
                            <div id="result" style="color: blue">"Check connect" trước khi tạo kết nối đến Server</div>
                            <div id="actionSave"></div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</form>

<script>
    function checkConnect() {
        type_connect = $('#type_connect option:selected').val();
        nameLocal = $('#nameLocal').val();
        nameSql = $('#nameSql').val();
        pwdDb = $('#pwdDb').val();
        nameSaveDb = $('#nameSaveDb').val();

        var fd = 'type_connect=' + type_connect + '&nameLocal=' + nameLocal + '&nameSql=' + nameSql + '&pwdDb=' + pwdDb + '&nameSaveDb=' + nameSaveDb;
        $.ajax({
            type: "POST",
            url: "<?php echo getOption('http_script_dir') ?>/admin/core/init_admin.php?name_function=cn_check_connect",
            data: fd,
            cache: false,
            beforeSend: function () {
                $("#result").text("");
            },
            success: function (data) {
                varTemp = data.split('|');
                $("#result").css({color: (+varTemp[0] !== 0 ? 'blue' : 'red'), 'font-weight': "bold"}).text(varTemp[1]);
                $('#actionSave').html('<input type="hidden" name="actionSave" value="' + varTemp[0] + '"/>');
            },
            error: function (error) {
                console.log(error)
            }
        });
    }
</script>
