<?php
$file_edit = 'config/config_hotrotanthu.php';
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

    $hotrotanthu = $_POST['hotrotanthu'];
    $content .= "\$hotrotanthu	= $hotrotanthu;\n";
    $capsudung = $_POST['capsudung'];
    $content .= "\$capsudung	= $capsudung;\n";

    //Nhân vật có số lần $cap1_reset_min<=Reset<=$cap1_reset_max và $cap1_relife_min<=ReLife<=$cap1_relife_max thì Level để Reset giảm $cap1_levelgiam
    $cap1_reset_min = $_POST['cap1_reset_min'];
    $content .= "\$cap1_reset_min	= $cap1_reset_min;\n";
    $cap1_reset_max = $_POST['cap1_reset_max'];
    $content .= "\$cap1_reset_max	= $cap1_reset_max;\n";
    $cap1_relife_min = $_POST['cap1_relife_min'];
    $content .= "\$cap1_relife_min	= $cap1_relife_min;\n";
    $cap1_relife_max = $_POST['cap1_relife_max'];
    $content .= "\$cap1_relife_max	= $cap1_relife_max;\n";
    $cap1_levelgiam = $_POST['cap1_levelgiam'];
    $content .= "\$cap1_levelgiam	= $cap1_levelgiam;\n";

    //Nhân vật có số lần $cap2_reset_min<=Reset<=$cap2_reset_max và $cap2_relife_min<=ReLife<=$cap2_relife_max thì Level để Reset giảm $cap2_levelgiam
    $cap2_reset_min = $_POST['cap2_reset_min'];
    $content .= "\$cap2_reset_min	= $cap2_reset_min;\n";
    $cap2_reset_max = $_POST['cap2_reset_max'];
    $content .= "\$cap2_reset_max	= $cap2_reset_max;\n";
    $cap2_relife_min = $_POST['cap2_relife_min'];
    $content .= "\$cap2_relife_min	= $cap2_relife_min;\n";
    $cap2_relife_max = $_POST['cap2_relife_max'];
    $content .= "\$cap2_relife_max	= $cap2_relife_max;\n";
    $cap2_levelgiam = $_POST['cap2_levelgiam'];
    $content .= "\$cap2_levelgiam	= $cap2_levelgiam;\n";

    //Nhân vật có số lần $cap3_reset_min<=Reset<=$cap3_reset_max và $cap3_relife_min<=ReLife<=$cap3_relife_max thì Level để Reset giảm $cap3_levelgiam
    $cap3_reset_min = $_POST['cap3_reset_min'];
    $content .= "\$cap3_reset_min	= $cap3_reset_min;\n";
    $cap3_reset_max = $_POST['cap3_reset_max'];
    $content .= "\$cap3_reset_max	= $cap3_reset_max;\n";
    $cap3_relife_min = $_POST['cap3_relife_min'];
    $content .= "\$cap3_relife_min	= $cap3_relife_min;\n";
    $cap3_relife_max = $_POST['cap3_relife_max'];
    $content .= "\$cap3_relife_max	= $cap3_relife_max;\n";
    $cap3_levelgiam = $_POST['cap3_levelgiam'];
    $content .= "\$cap3_levelgiam	= $cap3_levelgiam;\n";

    //Nhân vật có số lần $cap4_reset_min<=Reset<=$cap4_reset_max và $cap4_relife_min<=ReLife<=$cap4_relife_max thì Level để Reset giảm $cap4_levelgiam
    $cap4_reset_min = $_POST['cap4_reset_min'];
    $content .= "\$cap4_reset_min	= $cap4_reset_min;\n";
    $cap4_reset_max = $_POST['cap4_reset_max'];
    $content .= "\$cap4_reset_max	= $cap4_reset_max;\n";
    $cap4_relife_min = $_POST['cap4_relife_min'];
    $content .= "\$cap4_relife_min	= $cap4_relife_min;\n";
    $cap4_relife_max = $_POST['cap4_relife_max'];
    $content .= "\$cap4_relife_max	= $cap4_relife_max;\n";
    $cap4_levelgiam = $_POST['cap4_levelgiam'];
    $content .= "\$cap4_levelgiam	= $cap4_levelgiam;\n";

    //Nhân vật có số lần $cap5_reset_min<=Reset<=$cap5_reset_max và $cap5_relife_min<=ReLife<=$cap5_relife_max thì Level để Reset giảm $cap5_levelgiam
    $cap5_reset_min = $_POST['cap5_reset_min'];
    $content .= "\$cap5_reset_min	= $cap5_reset_min;\n";
    $cap5_reset_max = $_POST['cap5_reset_max'];
    $content .= "\$cap5_reset_max	= $cap5_reset_max;\n";
    $cap5_relife_min = $_POST['cap5_relife_min'];
    $content .= "\$cap5_relife_min	= $cap5_relife_min;\n";
    $cap5_relife_max = $_POST['cap5_relife_max'];
    $content .= "\$cap5_relife_max	= $cap5_relife_max;\n";
    $cap5_levelgiam = $_POST['cap5_levelgiam'];
    $content .= "\$cap5_levelgiam	= $cap5_levelgiam;\n";

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
        <h1>Cấu Hình Hỗ trợ Tân thủ</h1>
    </div>
    <br>
    Tập tin <?php echo "<b>" . $file_edit . "</b> : " . $can_write; ?><?php if (!$usehost) { ?><br>
        Tập tin <?php echo "<b>" . $file_edit_sv . "</b> : " . $can_write_sv; ?><?php } ?>
    <div class="select-bar"></div>
    <div class="table">
        <?php if ($notice) echo $notice; ?>
        <form id="editconfig" name="editconfig" method="post" action="">
            <input type="hidden" name="action" value="edit"/>
            - Sử dụng Hỗ trợ tân thủ :
            Không <input name="hotrotanthu" type="radio"
                         value="0" <?php if ($hotrotanthu == 0) echo "checked='checked'"; ?>/>
            Có <input name="hotrotanthu" type="radio"
                      value="1" <?php if ($hotrotanthu == 1) echo "checked='checked'"; ?>/>
            <br>
            - Cấp sử dụng : <input type="text" name="capsudung" value="<?php echo $capsudung; ?>" size="1"/>
            <br><br>
            <table width="100%" border="0" bgcolor="#9999FF">
                <tr bgcolor="#FFFFFF">
                    <td align="center"><b>Cấp</b></td>
                    <td align="center"><b>Reset</b></td>
                    <td align="center"><b>ReLife</b></td>
                    <td align="center"><b>Level giảm</b></td>
                </tr>

                <tr bgcolor="#FFFFFF">
                    <td align="center"><b>Cấp 1</b></td>
                    <td align="center"><input type="text" name="cap1_reset_min" value="<?php echo $cap1_reset_min; ?>"
                                              size="1"/> <= Reset <= <input type="text" name="cap1_reset_max"
                                                                            value="<?php echo $cap1_reset_max; ?>"
                                                                            size="1"/></td>
                    <td align="center"><input type="text" name="cap1_relife_min" value="<?php echo $cap1_relife_min; ?>"
                                              size="1"/> <= ReLife <= <input type="text" name="cap1_relife_max"
                                                                             value="<?php echo $cap1_relife_max; ?>"
                                                                             size="1"/></td>
                    <td align="center"><input type="text" name="cap1_levelgiam" value="<?php echo $cap1_levelgiam; ?>"
                                              size="1"/></td>
                </tr>

                <tr bgcolor="#FFFFFF">
                    <td align="center"><b>Cấp 2</b></td>
                    <td align="center"><input type="text" name="cap2_reset_min" value="<?php echo $cap2_reset_min; ?>"
                                              size="1"/> <= Reset <= <input type="text" name="cap2_reset_max"
                                                                            value="<?php echo $cap2_reset_max; ?>"
                                                                            size="1"/></td>
                    <td align="center"><input type="text" name="cap2_relife_min" value="<?php echo $cap2_relife_min; ?>"
                                              size="1"/> <= ReLife <= <input type="text" name="cap2_relife_max"
                                                                             value="<?php echo $cap2_relife_max; ?>"
                                                                             size="1"/></td>
                    <td align="center"><input type="text" name="cap2_levelgiam" value="<?php echo $cap2_levelgiam; ?>"
                                              size="1"/></td>
                </tr>

                <tr bgcolor="#FFFFFF">
                    <td align="center"><b>Cấp 3</b></td>
                    <td align="center"><input type="text" name="cap3_reset_min" value="<?php echo $cap3_reset_min; ?>"
                                              size="1"/> <= Reset <= <input type="text" name="cap3_reset_max"
                                                                            value="<?php echo $cap3_reset_max; ?>"
                                                                            size="1"/></td>
                    <td align="center"><input type="text" name="cap3_relife_min" value="<?php echo $cap3_relife_min; ?>"
                                              size="1"/> <= ReLife <= <input type="text" name="cap3_relife_max"
                                                                             value="<?php echo $cap3_relife_max; ?>"
                                                                             size="1"/></td>
                    <td align="center"><input type="text" name="cap3_levelgiam" value="<?php echo $cap3_levelgiam; ?>"
                                              size="1"/></td>
                </tr>

                <tr bgcolor="#FFFFFF">
                    <td align="center"><b>Cấp 4</b></td>
                    <td align="center"><input type="text" name="cap4_reset_min" value="<?php echo $cap4_reset_min; ?>"
                                              size="1"/> <= Reset <= <input type="text" name="cap4_reset_max"
                                                                            value="<?php echo $cap4_reset_max; ?>"
                                                                            size="1"/></td>
                    <td align="center"><input type="text" name="cap4_relife_min" value="<?php echo $cap4_relife_min; ?>"
                                              size="1"/> <= ReLife <= <input type="text" name="cap4_relife_max"
                                                                             value="<?php echo $cap4_relife_max; ?>"
                                                                             size="1"/></td>
                    <td align="center"><input type="text" name="cap4_levelgiam" value="<?php echo $cap4_levelgiam; ?>"
                                              size="1"/></td>
                </tr>

                <tr bgcolor="#FFFFFF">
                    <td align="center"><b>Cấp 5</b></td>
                    <td align="center"><input type="text" name="cap5_reset_min" value="<?php echo $cap5_reset_min; ?>"
                                              size="1"/> <= Reset <= <input type="text" name="cap5_reset_max"
                                                                            value="<?php echo $cap5_reset_max; ?>"
                                                                            size="1"/></td>
                    <td align="center"><input type="text" name="cap5_relife_min" value="<?php echo $cap5_relife_min; ?>"
                                              size="1"/> <= ReLife <= <input type="text" name="cap5_relife_max"
                                                                             value="<?php echo $cap5_relife_max; ?>"
                                                                             size="1"/></td>
                    <td align="center"><input type="text" name="cap5_levelgiam" value="<?php echo $cap5_levelgiam; ?>"
                                              size="1"/></td>
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
	  
