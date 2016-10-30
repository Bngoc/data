<?php
$file_edit = 'config/config_gioihanrs.php';
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

    $use_gioihanrs = $_POST['use_gioihanrs'];
    $content .= "\$use_gioihanrs	= $use_gioihanrs;\n";
    $gioihanrs_top10 = $_POST['gioihanrs_top10'];
    $content .= "\$gioihanrs_top10	= $gioihanrs_top10;\n";
    $gioihanrs_top20 = $_POST['gioihanrs_top20'];
    $content .= "\$gioihanrs_top20	= $gioihanrs_top20;\n";
    $gioihanrs_top30 = $_POST['gioihanrs_top30'];
    $content .= "\$gioihanrs_top30	= $gioihanrs_top30;\n";
    $gioihanrs_top40 = $_POST['gioihanrs_top40'];
    $content .= "\$gioihanrs_top40	= $gioihanrs_top40;\n";
    $gioihanrs_top50 = $_POST['gioihanrs_top50'];
    $content .= "\$gioihanrs_top50	= $gioihanrs_top50;\n";
    $gioihanrs_other = $_POST['gioihanrs_other'];
    $content .= "\$gioihanrs_other	= $gioihanrs_other;\n";

    $ResetInDay1 = $_POST['ResetInDay1'];
    $content .= "\$ResetInDay1	= $ResetInDay1;\n";
    $ResetInDay2 = $_POST['ResetInDay2'];
    $content .= "\$ResetInDay2	= $ResetInDay2;\n";
    $VpointReset0_GioiHan0 = $_POST['VpointReset0_GioiHan0'];
    $content .= "\$VpointReset0_GioiHan0	= $VpointReset0_GioiHan0;\t";
    $VpointReset1_GioiHan0 = $_POST['VpointReset1_GioiHan0'];
    $content .= "\$VpointReset1_GioiHan0	= $VpointReset1_GioiHan0;\t";
    $VpointReset2_GioiHan0 = $_POST['VpointReset2_GioiHan0'];
    $content .= "\$VpointReset2_GioiHan0	= $VpointReset2_GioiHan0;\n";
    $GioiHanReset1 = $_POST['GioiHanReset1'];
    $content .= "\$GioiHanReset1	= $GioiHanReset1;\n";
    $VpointReset0_GioiHan1 = $_POST['VpointReset0_GioiHan1'];
    $content .= "\$VpointReset0_GioiHan1	= $VpointReset0_GioiHan1;\t";
    $VpointReset1_GioiHan1 = $_POST['VpointReset1_GioiHan1'];
    $content .= "\$VpointReset1_GioiHan1	= $VpointReset1_GioiHan1;\t";
    $VpointReset2_GioiHan1 = $_POST['VpointReset2_GioiHan1'];
    $content .= "\$VpointReset2_GioiHan1	= $VpointReset2_GioiHan1;\n";
    $GioiHanReset2 = $_POST['GioiHanReset2'];
    $content .= "\$GioiHanReset2	= $GioiHanReset2;\n";
    $VpointReset0_GioiHan2 = $_POST['VpointReset0_GioiHan2'];
    $content .= "\$VpointReset0_GioiHan2	= $VpointReset0_GioiHan2;\t";
    $VpointReset1_GioiHan2 = $_POST['VpointReset1_GioiHan2'];
    $content .= "\$VpointReset1_GioiHan2	= $VpointReset1_GioiHan2;\t";
    $VpointReset2_GioiHan2 = $_POST['VpointReset2_GioiHan2'];
    $content .= "\$VpointReset2_GioiHan2	= $VpointReset2_GioiHan2;\n";
    $GioiHanReset3 = $_POST['GioiHanReset3'];
    $content .= "\$GioiHanReset3	= $GioiHanReset3;\n";
    $VpointReset0_GioiHan3 = $_POST['VpointReset0_GioiHan3'];
    $content .= "\$VpointReset0_GioiHan3	= $VpointReset0_GioiHan3;\t";
    $VpointReset1_GioiHan3 = $_POST['VpointReset1_GioiHan3'];
    $content .= "\$VpointReset1_GioiHan3	= $VpointReset1_GioiHan3;\t";
    $VpointReset2_GioiHan3 = $_POST['VpointReset2_GioiHan3'];
    $content .= "\$VpointReset2_GioiHan3	= $VpointReset2_GioiHan3;\n";
    $GioiHanReset4 = $_POST['GioiHanReset4'];
    $content .= "\$GioiHanReset4	= $GioiHanReset4;\n";
    $VpointReset0_GioiHan4 = $_POST['VpointReset0_GioiHan4'];
    $content .= "\$VpointReset0_GioiHan4	= $VpointReset0_GioiHan4;\t";
    $VpointReset1_GioiHan4 = $_POST['VpointReset1_GioiHan4'];
    $content .= "\$VpointReset1_GioiHan4	= $VpointReset1_GioiHan4;\t";
    $VpointReset2_GioiHan4 = $_POST['VpointReset2_GioiHan4'];
    $content .= "\$VpointReset2_GioiHan4	= $VpointReset2_GioiHan4;\n";
    $GioiHanReset5 = $_POST['GioiHanReset5'];
    $content .= "\$GioiHanReset5	= $GioiHanReset5;\n";
    $VpointReset0_GioiHan5 = $_POST['VpointReset0_GioiHan5'];
    $content .= "\$VpointReset0_GioiHan5	= $VpointReset0_GioiHan5;\t";
    $VpointReset1_GioiHan5 = $_POST['VpointReset1_GioiHan5'];
    $content .= "\$VpointReset1_GioiHan5	= $VpointReset1_GioiHan5;\t";
    $VpointReset2_GioiHan5 = $_POST['VpointReset2_GioiHan5'];
    $content .= "\$VpointReset2_GioiHan5	= $VpointReset2_GioiHan5;\n";
    $GioiHanReset6 = $_POST['GioiHanReset6'];
    $content .= "\$GioiHanReset6	= $GioiHanReset6;\n";

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
        <h1>Cấu Hình Giới hạn Reset</h1>
    </div>
    <br>
    Tập tin <?php echo "<b>" . $file_edit . "</b> : " . $can_write; ?><?php if (!$usehost) { ?><br>
        Tập tin <?php echo "<b>" . $file_edit_sv . "</b> : " . $can_write_sv; ?><?php } ?>
    <div class="select-bar"></div>
    <div class="table">
        <?php if ($notice) echo $notice; ?>
        <form id="editconfig" name="editconfig" method="post" action="">
            <input type="hidden" name="action" value="edit"/>
            - Sử dụng Giới hạn Reset :
            Không <input name="use_gioihanrs" type="radio"
                         value="0" <?php if ($use_gioihanrs == 0) echo "checked='checked'"; ?>/>
            Giới Hạn Loại 1 <input name="use_gioihanrs" type="radio"
                                   value="1" <?php if ($use_gioihanrs == 1) echo "checked='checked'"; ?>/>
            Giới Hạn Loại 2 <input name="use_gioihanrs" type="radio"
                                   value="2" <?php if ($use_gioihanrs == 2) echo "checked='checked'"; ?>/>
            <br><br>
            <table width="100%" border="0" bgcolor="#9999FF">
                <center><font size="3"><b>Cấu hình Giới Hạn Reset Loại 1</b></font></center>
                <tr bgcolor="#FFFFFF">
                    <td align="center"><b>TOP 1-10</b></td>
                    <td align="center">Reset tối đa <input type="text" name="gioihanrs_top10"
                                                           value="<?php echo $gioihanrs_top10; ?>" size="1"/> lần/ngày
                    </td>
                </tr>

                <tr bgcolor="#FFFFFF">
                    <td align="center"><b>TOP 11-20</b></td>
                    <td align="center">Reset tối đa <input type="text" name="gioihanrs_top20"
                                                           value="<?php echo $gioihanrs_top20; ?>" size="1"/> lần/ngày
                    </td>
                </tr>

                <tr bgcolor="#FFFFFF">
                    <td align="center"><b>TOP 21-30</b></td>
                    <td align="center">Reset tối đa <input type="text" name="gioihanrs_top30"
                                                           value="<?php echo $gioihanrs_top30; ?>" size="1"/> lần/ngày
                    </td>
                </tr>

                <tr bgcolor="#FFFFFF">
                    <td align="center"><b>TOP 31-40</b></td>
                    <td align="center">Reset tối đa <input type="text" name="gioihanrs_top40"
                                                           value="<?php echo $gioihanrs_top40; ?>" size="1"/> lần/ngày
                    </td>
                </tr>

                <tr bgcolor="#FFFFFF">
                    <td align="center"><b>TOP 41-50</b></td>
                    <td align="center">Reset tối đa <input type="text" name="gioihanrs_top50"
                                                           value="<?php echo $gioihanrs_top50; ?>" size="1"/> lần/ngày
                    </td>
                </tr>

                <tr bgcolor="#FFFFFF">
                    <td align="center"><b>TOP > 50</b></td>
                    <td align="center">Reset tối đa <input type="text" name="gioihanrs_other"
                                                           value="<?php echo $gioihanrs_other; ?>" size="1"/> lần/ngày
                    </td>
                </tr>
            </table>
            <br>
            <table width="100%" border="0" bgcolor="#9999FF">
                <center><font size="3"><b>Cấu hình Giới Hạn Reset Loại 2</b></font></center>
                <tr bgcolor="#FFFFFF">
                    <td>
                        <div align="center"><b>Reset</b></div>
                    </td>
                    <td>
                        <div align="center"><b>0-<input type="text" name="ResetInDay1"
                                                        value="<?php echo $ResetInDay1; ?>" size="1"> RS/ngày</b></div>
                    </td>
                    <td>
                        <div align="center"><b><input type="text" name="ResetInDay1+1"
                                                      value="<?php echo $ResetInDay1 + 1; ?>" size="1">-<input
                                    type="text" name="ResetInDay2" value="<?php echo $ResetInDay2; ?>" size="1"> RS/ngày</b>
                        </div>
                    </td>
                    <td>
                        <div align="center"><b>><input type="text" name="ResetInDay2"
                                                       value="<?php echo $ResetInDay2; ?>" size="1"> RS/ngày</b></div>
                    </td>
                </tr>
                <tr bgcolor="#FFFFFF">
                    <td>
                        <div align="center">0-<input type="text" name="GioiHanReset1"
                                                     value="<?php echo $GioiHanReset1; ?>" size="1"></div>
                    </td>
                    <td>
                        <div align="center"><input type="text" name="VpointReset0_GioiHan0"
                                                   value="<?php echo $VpointReset0_GioiHan0; ?>" size="1"> Vpoint
                        </div>
                    </td>
                    <td>
                        <div align="center"><input type="text" name="VpointReset1_GioiHan0"
                                                   value="<?php echo $VpointReset1_GioiHan0; ?>" size="1"> Vpoint
                        </div>
                    </td>
                    <td>
                        <div align="center"><input type="text" name="VpointReset2_GioiHan0"
                                                   value="<?php echo $VpointReset2_GioiHan0; ?>" size="1"> Vpoint
                        </div>
                    </td>
                </tr>
                <tr bgcolor="#FFFFFF">
                    <td>
                        <div align="center"><input type="text" name="GioiHanReset1+1"
                                                   value="<?php echo $GioiHanReset1 + 1; ?>" size="1">-<input
                                type="text" name="GioiHanReset2" value="<?php echo $GioiHanReset2; ?>" size="1"></div>
                    </td>
                    <td>
                        <div align="center"><input type="text" name="VpointReset0_GioiHan1"
                                                   value="<?php echo $VpointReset0_GioiHan1; ?>" size="1"> Vpoint
                        </div>
                    </td>
                    <td>
                        <div align="center"><input type="text" name="VpointReset1_GioiHan1"
                                                   value="<?php echo $VpointReset1_GioiHan1; ?>" size="1"> Vpoint
                        </div>
                    </td>
                    <td>
                        <div align="center"><input type="text" name="VpointReset2_GioiHan1"
                                                   value="<?php echo $VpointReset2_GioiHan1; ?>" size="1"> Vpoint
                        </div>
                    </td>
                </tr>
                <tr bgcolor="#FFFFFF">
                    <td>
                        <div align="center"><input type="text" name="GioiHanReset2+1"
                                                   value="<?php echo $GioiHanReset2 + 1; ?>" size="1">-<input
                                type="text" name="GioiHanReset3" value="<?php echo $GioiHanReset3; ?>" size="1"></div>
                    </td>
                    <td>
                        <div align="center"><input type="text" name="VpointReset0_GioiHan2"
                                                   value="<?php echo $VpointReset0_GioiHan2; ?>" size="1"> Vpoint
                        </div>
                    </td>
                    <td>
                        <div align="center"><input type="text" name="VpointReset1_GioiHan2"
                                                   value="<?php echo $VpointReset1_GioiHan2; ?>" size="1"> Vpoint
                        </div>
                    </td>
                    <td>
                        <div align="center"><input type="text" name="VpointReset2_GioiHan2"
                                                   value="<?php echo $VpointReset2_GioiHan2; ?>" size="1"> Vpoint
                        </div>
                    </td>
                </tr>
                <tr bgcolor="#FFFFFF">
                    <td>
                        <div align="center"><input type="text" name="GioiHanReset3+1"
                                                   value="<?php echo $GioiHanReset3 + 1; ?>" size="1">-<input
                                type="text" name="GioiHanReset4" value="<?php echo $GioiHanReset4; ?>" size="1"></div>
                    </td>
                    <td>
                        <div align="center"><input type="text" name="VpointReset0_GioiHan3"
                                                   value="<?php echo $VpointReset0_GioiHan3; ?>" size="1"> Vpoint
                        </div>
                    </td>
                    <td>
                        <div align="center"><input type="text" name="VpointReset1_GioiHan3"
                                                   value="<?php echo $VpointReset1_GioiHan3; ?>" size="1"> Vpoint
                        </div>
                    </td>
                    <td>
                        <div align="center"><input type="text" name="VpointReset2_GioiHan3"
                                                   value="<?php echo $VpointReset2_GioiHan3; ?>" size="1"> Vpoint
                        </div>
                    </td>
                </tr>
                <tr bgcolor="#FFFFFF">
                    <td>
                        <div align="center"><input type="text" name="GioiHanReset4+1"
                                                   value="<?php echo $GioiHanReset4 + 1; ?>" size="1">-<input
                                type="text" name="GioiHanReset5" value="<?php echo $GioiHanReset5; ?>" size="1"></div>
                    </td>
                    <td>
                        <div align="center"><input type="text" name="VpointReset0_GioiHan4"
                                                   value="<?php echo $VpointReset0_GioiHan4; ?>" size="1"> Vpoint
                        </div>
                    </td>
                    <td>
                        <div align="center"><input type="text" name="VpointReset1_GioiHan4"
                                                   value="<?php echo $VpointReset1_GioiHan4; ?>" size="1"> Vpoint
                        </div>
                    </td>
                    <td>
                        <div align="center"><input type="text" name="VpointReset2_GioiHan4"
                                                   value="<?php echo $VpointReset2_GioiHan4; ?>" size="1"> Vpoint
                        </div>
                    </td>
                </tr>
                <tr bgcolor="#FFFFFF">
                    <td>
                        <div align="center"><input type="text" name="GioiHanReset5+1"
                                                   value="<?php echo $GioiHanReset5 + 1; ?>" size="1">-<input
                                type="text" name="GioiHanReset6" value="<?php echo $GioiHanReset6; ?>" size="1"></div>
                    </td>
                    <td>
                        <div align="center"><input type="text" name="VpointReset0_GioiHan5"
                                                   value="<?php echo $VpointReset0_GioiHan5; ?>" size="1"> Vpoint
                        </div>
                    </td>
                    <td>
                        <div align="center"><input type="text" name="VpointReset1_GioiHan5"
                                                   value="<?php echo $VpointReset1_GioiHan5; ?>" size="1"> Vpoint
                        </div>
                    </td>
                    <td>
                        <div align="center"><input type="text" name="VpointReset2_GioiHan5"
                                                   value="<?php echo $VpointReset2_GioiHan5; ?>" size="1"> Vpoint
                        </div>
                    </td>
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
	  
