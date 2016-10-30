<?php
require_once('config/config_reset.php');
require_once('config/config_class.php');

$file_edit = 'config/config_relife.php';
if (!is_file($file_edit)) {
    $fp_host = fopen($file_edit, "w");
    fclose($fp_host);
}

if (is_writable($file_edit)) {
    $can_write = "<font color=green>Có thể ghi</font>";
    $accept = 1;
} else {
    $can_write = "<font color=red>Không thể ghi - Hãy sử dụng chương trình FTP FileZilla chuyển <b>File permission</b> sang 666</font>";
    $accept = 0;
}

if (!$usehost) {
    $file_edit_sv = $server_path;
    $file_edit_sv .= $file_edit;
    if (!is_file($file_edit_sv)) {
        $fp_host = fopen($file_edit_sv, "w");
        fclose($fp_host);
    }
    if (is_writable($file_edit_sv)) {
        $can_write_sv = "<font color=green>Có thể ghi</font>";
        $accept = 1;
    } else {
        $can_write_sv = "<font color=red>Không thể ghi - Hãy sử dụng chương trình FTP FileZilla chuyển <b>File permission</b> sang 666</font>";
        $accept = 0;
    }
}

$action = $_POST[action];

if ($action == 'edit') {
    $content = "<?php\n";

    $cap_relife_max = $_POST['cap_relife_max'];
    $content .= "\$cap_relife_max	= $cap_relife_max;\n";

    $rl_reset_relife1 = $_POST['rl_reset_relife1'];
    $content .= "\$rl_reset_relife1	= $rl_reset_relife1;\t";
    $rl_point_relife1 = $_POST['rl_point_relife1'];
    $content .= "\$rl_point_relife1	= $rl_point_relife1;\t";
    $rl_ml_relife1 = $_POST['rl_ml_relife1'];
    $content .= "\$rl_ml_relife1	= $rl_ml_relife1;\n";

    $rl_reset_relife2 = $_POST['rl_reset_relife2'];
    $content .= "\$rl_reset_relife2	= $rl_reset_relife2;\t";
    $rl_point_relife2 = $_POST['rl_point_relife2'];
    $content .= "\$rl_point_relife2	= $rl_point_relife2;\t";
    $rl_ml_relife2 = $_POST['rl_ml_relife2'];
    $content .= "\$rl_ml_relife2	= $rl_ml_relife2;\n";

    $rl_reset_relife3 = $_POST['rl_reset_relife3'];
    $content .= "\$rl_reset_relife3	= $rl_reset_relife3;\t";
    $rl_point_relife3 = $_POST['rl_point_relife3'];
    $content .= "\$rl_point_relife3	= $rl_point_relife3;\t";
    $rl_ml_relife3 = $_POST['rl_ml_relife3'];
    $content .= "\$rl_ml_relife3	= $rl_ml_relife3;\n";

    $rl_reset_relife4 = $_POST['rl_reset_relife4'];
    $content .= "\$rl_reset_relife4	= $rl_reset_relife4;\t";
    $rl_point_relife4 = $_POST['rl_point_relife4'];
    $content .= "\$rl_point_relife4	= $rl_point_relife4;\t";
    $rl_ml_relife4 = $_POST['rl_ml_relife4'];
    $content .= "\$rl_ml_relife4	= $rl_ml_relife4;\n";

    $rl_reset_relife5 = $_POST['rl_reset_relife5'];
    $content .= "\$rl_reset_relife5	= $rl_reset_relife5;\t";
    $rl_point_relife5 = $_POST['rl_point_relife5'];
    $content .= "\$rl_point_relife5	= $rl_point_relife5;\t";
    $rl_ml_relife5 = $_POST['rl_ml_relife5'];
    $content .= "\$rl_ml_relife5	= $rl_ml_relife5;\n";

    $rl_reset_relife6 = $_POST['rl_reset_relife6'];
    $content .= "\$rl_reset_relife6	= $rl_reset_relife6;\t";
    $rl_point_relife6 = $_POST['rl_point_relife6'];
    $content .= "\$rl_point_relife6	= $rl_point_relife6;\t";
    $rl_ml_relife6 = $_POST['rl_ml_relife6'];
    $content .= "\$rl_ml_relife6	= $rl_ml_relife6;\n";

    $rl_reset_relife7 = $_POST['rl_reset_relife7'];
    $content .= "\$rl_reset_relife7	= $rl_reset_relife7;\t";
    $rl_point_relife7 = $_POST['rl_point_relife7'];
    $content .= "\$rl_point_relife7	= $rl_point_relife7;\t";
    $rl_ml_relife7 = $_POST['rl_ml_relife7'];
    $content .= "\$rl_ml_relife7	= $rl_ml_relife7;\n";

    $rl_reset_relife8 = $_POST['rl_reset_relife8'];
    $content .= "\$rl_reset_relife8	= $rl_reset_relife8;\t";
    $rl_point_relife8 = $_POST['rl_point_relife8'];
    $content .= "\$rl_point_relife8	= $rl_point_relife8;\t";
    $rl_ml_relife8 = $_POST['rl_ml_relife8'];
    $content .= "\$rl_ml_relife8	= $rl_ml_relife8;\n";

    $rl_reset_relife9 = $_POST['rl_reset_relife9'];
    $content .= "\$rl_reset_relife9	= $rl_reset_relife9;\t";
    $rl_point_relife9 = $_POST['rl_point_relife9'];
    $content .= "\$rl_point_relife9	= $rl_point_relife9;\t";
    $rl_ml_relife9 = $_POST['rl_ml_relife9'];
    $content .= "\$rl_ml_relife9	= $rl_ml_relife9;\n";

    $rl_reset_relife10 = $_POST['rl_reset_relife10'];
    $content .= "\$rl_reset_relife10	= $rl_reset_relife10;\t";
    $rl_point_relife10 = $_POST['rl_point_relife10'];
    $content .= "\$rl_point_relife10	= $rl_point_relife10;\t";
    $rl_ml_relife10 = $_POST['rl_ml_relife10'];
    $content .= "\$rl_ml_relife10	= $rl_ml_relife10;\n";


    $content .= "?>";

    require_once('admin/function.php');
    replacecontent($file_edit, $content);
    if (!$usehost) replacecontent($file_edit_sv, $content);

    $notice = "<center><font color='red'>Sửa thành công</font></center>";
}

include($file_edit);
?>


<div id="center-column">
    <div class="top-bar">
        <h1>Cấu Hình ReLife</h1>
    </div>
    <br>
    Tập tin <?php echo "<b>" . $file_edit . "</b> : " . $can_write; ?><?php if (!$usehost) { ?><br>
        Tập tin <?php echo "<b>" . $file_edit_sv . "</b> : " . $can_write_sv; ?><?php } ?>
    <div class="select-bar"></div>
    <div class="table">
        <?php if ($notice) echo $notice; ?>
        <form id="editconfig" name="editconfig" method="post" action="">
            <input type="hidden" name="action" value="edit"/>
            - Số cấp Relife hiển thị dành cho người chơi : <input type="text" name="cap_relife_max"
                                                                  value="<?php echo $cap_relife_max; ?>" size="1"/><br>
            <br><br>
            <table width="100%" border="0" bgcolor="#9999FF">
                <tr bgcolor="#FFFFFF">
                    <th align="center" scope="col">ReLife</th>
                    <th align="center" scope="col">Reset</th>
                    <th align="center" scope="col">Level</th>
                    <th align="center" scope="col">Point</th>
                    <th align="center" scope="col">Mệnh lệnh</th>
                </tr>

                <tr bgcolor="#FFFFFF">
                    <td align="center">1</td>
                    <td align="center"><input type="text" name="rl_reset_relife1"
                                              value="<?php echo $rl_reset_relife1; ?>" size="3"/></td>
                    <td align="center">400</td>
                    <td align="center"><input type="text" name="rl_point_relife1"
                                              value="<?php echo $rl_point_relife1; ?>" size="5"/></td>
                    <td align="center"><input type="text" name="rl_ml_relife1" value="<?php echo $rl_ml_relife1; ?>"
                                              size="5"/></td>
                </tr>

                <tr bgcolor="#FFFFFF">
                    <td align="center">2</td>
                    <td align="center"><input type="text" name="rl_reset_relife2"
                                              value="<?php echo $rl_reset_relife2; ?>" size="3"/></td>
                    <td align="center">400</td>
                    <td align="center"><input type="text" name="rl_point_relife2"
                                              value="<?php echo $rl_point_relife2; ?>" size="5"/></td>
                    <td align="center"><input type="text" name="rl_ml_relife2" value="<?php echo $rl_ml_relife2; ?>"
                                              size="5"/></td>
                </tr>

                <tr bgcolor="#FFFFFF">
                    <td align="center">3</td>
                    <td align="center"><input type="text" name="rl_reset_relife3"
                                              value="<?php echo $rl_reset_relife3; ?>" size="3"/></td>
                    <td align="center">400</td>
                    <td align="center"><input type="text" name="rl_point_relife3"
                                              value="<?php echo $rl_point_relife3; ?>" size="5"/></td>
                    <td align="center"><input type="text" name="rl_ml_relife3" value="<?php echo $rl_ml_relife3; ?>"
                                              size="5"/></td>
                </tr>

                <tr bgcolor="#FFFFFF">
                    <td align="center">4</td>
                    <td align="center"><input type="text" name="rl_reset_relife4"
                                              value="<?php echo $rl_reset_relife4; ?>" size="3"/></td>
                    <td align="center">400</td>
                    <td align="center"><input type="text" name="rl_point_relife4"
                                              value="<?php echo $rl_point_relife4; ?>" size="5"/></td>
                    <td align="center"><input type="text" name="rl_ml_relife4" value="<?php echo $rl_ml_relife4; ?>"
                                              size="5"/></td>
                </tr>

                <tr bgcolor="#FFFFFF">
                    <td align="center">5</td>
                    <td align="center"><input type="text" name="rl_reset_relife5"
                                              value="<?php echo $rl_reset_relife5; ?>" size="3"/></td>
                    <td align="center">400</td>
                    <td align="center"><input type="text" name="rl_point_relife5"
                                              value="<?php echo $rl_point_relife5; ?>" size="5"/></td>
                    <td align="center"><input type="text" name="rl_ml_relife5" value="<?php echo $rl_ml_relife5; ?>"
                                              size="5"/></td>
                </tr>

                <tr bgcolor="#FFFFFF">
                    <td align="center">6</td>
                    <td align="center"><input type="text" name="rl_reset_relife6"
                                              value="<?php echo $rl_reset_relife6; ?>" size="3"/></td>
                    <td align="center">400</td>
                    <td align="center"><input type="text" name="rl_point_relife6"
                                              value="<?php echo $rl_point_relife6; ?>" size="5"/></td>
                    <td align="center"><input type="text" name="rl_ml_relife6" value="<?php echo $rl_ml_relife6; ?>"
                                              size="5"/></td>
                </tr>

                <tr bgcolor="#FFFFFF">
                    <td align="center">7</td>
                    <td align="center"><input type="text" name="rl_reset_relife7"
                                              value="<?php echo $rl_reset_relife7; ?>" size="3"/></td>
                    <td align="center">400</td>
                    <td align="center"><input type="text" name="rl_point_relife7"
                                              value="<?php echo $rl_point_relife7; ?>" size="5"/></td>
                    <td align="center"><input type="text" name="rl_ml_relife7" value="<?php echo $rl_ml_relife7; ?>"
                                              size="5"/></td>
                </tr>

                <tr bgcolor="#FFFFFF">
                    <td align="center">8</td>
                    <td align="center"><input type="text" name="rl_reset_relife8"
                                              value="<?php echo $rl_reset_relife8; ?>" size="3"/></td>
                    <td align="center">400</td>
                    <td align="center"><input type="text" name="rl_point_relife8"
                                              value="<?php echo $rl_point_relife8; ?>" size="5"/></td>
                    <td align="center"><input type="text" name="rl_ml_relife8" value="<?php echo $rl_ml_relife8; ?>"
                                              size="5"/></td>
                </tr>

                <tr bgcolor="#FFFFFF">
                    <td align="center">9</td>
                    <td align="center"><input type="text" name="rl_reset_relife9"
                                              value="<?php echo $rl_reset_relife9; ?>" size="3"/></td>
                    <td align="center">400</td>
                    <td align="center"><input type="text" name="rl_point_relife9"
                                              value="<?php echo $rl_point_relife9; ?>" size="5"/></td>
                    <td align="center"><input type="text" name="rl_ml_relife9" value="<?php echo $rl_ml_relife9; ?>"
                                              size="5"/></td>
                </tr>

                <tr bgcolor="#FFFFFF">
                    <td align="center">10</td>
                    <td align="center"><input type="text" name="rl_reset_relife10"
                                              value="<?php echo $rl_reset_relife10; ?>" size="3"/></td>
                    <td align="center">400</td>
                    <td align="center"><input type="text" name="rl_point_relife10"
                                              value="<?php echo $rl_point_relife10; ?>" size="5"/></td>
                    <td align="center"><input type="text" name="rl_ml_relife10" value="<?php echo $rl_ml_relife10; ?>"
                                              size="5"/></td>
                </tr>
            </table>
            <center><input type="submit" name="Submit"
                           value="Sửa" <?php if ($accept == '0') { ?> disabled="disabled" <?php } ?> /></center>
        </form>
    </div>
</div>
<div id="right-column">
    <strong class="h">Thông tin</strong>
    <div class="box">Cấu hình :<br>
        - Tên WebSite<br>
        - Địa chỉ kết nối đến Server
    </div>
</div>
	  
