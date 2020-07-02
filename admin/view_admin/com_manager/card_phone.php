<?php

list($catlist) = _GL('catlist');

?>

<table class="table" width="100%" cellspacing="1" cellpadding="3" border="0">
    <tr>
        <td align="center"><a href="cardphone.php">Home</a></td>

        <td align="right">Loại Thẻ</td>
        <td align="left">
            <form name=list_card_type method=get>
                <select name='list_card_type' onchange='submit();'>
                    <option value=''>- Chọn Loại thẻ -</option>
                    <option value="Viettel" <?php if ($list_card_type == 'Viettel') { ?> selected="selected" <?php } ?>>
                        Viettel
                    </option>
                    <option value="Mobi" <?php if ($list_card_type == 'Mobi') { ?> selected="selected" <?php } ?>>Mobi
                    </option>
                    <option value="Vina" <?php if ($list_card_type == 'Vina') { ?> selected="selected" <?php } ?>>Vina
                    </option>
                    <option value="VTC" <?php if ($list_card_type == 'VTC') { ?> selected="selected" <?php } ?>>VTC
                    </option>
                    <option value="Gate" <?php if ($list_card_type == 'Gate') { ?> selected="selected" <?php } ?>>Gate
                    </option>
                </select>
                <input type=hidden name='thang' value='<?php echo $month; ?>'>
                <input type=hidden name='nam' value='<?php echo $year; ?>'>
                <input type=hidden name='list_menhgia' value='<?php echo $list_menhgia; ?>'>
                <input type=hidden name='page' value='<?php echo $fpage; ?>'>
            </form>
        </td>

        <td align="right">Mệnh giá:</td>
        <td align="left">
            <form name=list_menhgia method=get>
                <input type=hidden name='list_card_type' value='<?php echo $list_card_type; ?>'>
                <select name='list_menhgia' onchange='submit();'>
                    <option value=''>- Tất cả -</option>
                    <option value='10000'
                            <?php if ($list_menhgia == '10000') { ?>selected='1'<?php } ?> ><?php echo number_format(10000, 0, ',', '.'); ?></option>
                    <option value='20000'
                            <?php if ($list_menhgia == '20000') { ?>selected='1'<?php } ?> ><?php echo number_format(20000, 0, ',', '.'); ?></option>
                    <option value='30000'
                            <?php if ($list_menhgia == '30000') { ?>selected='1'<?php } ?> ><?php echo number_format(30000, 0, ',', '.'); ?></option>
                    <option value='50000'
                            <?php if ($list_menhgia == '50000') { ?>selected='1'<?php } ?> ><?php echo number_format(50000, 0, ',', '.'); ?></option>
                    <option value='100000'
                            <?php if ($list_menhgia == '100000') { ?>selected='1'<?php } ?> ><?php echo number_format(100000, 0, ',', '.'); ?></option>
                    <option value='200000'
                            <?php if ($list_menhgia == '200000') { ?>selected='1'<?php } ?> ><?php echo number_format(200000, 0, ',', '.'); ?></option>
                    <option value='300000'
                            <?php if ($list_menhgia == '300000') { ?>selected='1'<?php } ?> ><?php echo number_format(300000, 0, ',', '.'); ?></option>
                    <option value='500000'
                            <?php if ($list_menhgia == '500000') { ?>selected='1'<?php } ?> ><?php echo number_format(500000, 0, ',', '.'); ?></option>
                </select>
                <input type=hidden name='list_status' value='<?php echo $list_status; ?>'>
                <input type=hidden name='page' value='<?php echo $fpage; ?>'>
            </form>
        </td>

        <td align="right">Tình trạng</td>
        <td align="left">
            <form name=list_status method=get>
                <input type=hidden name='list_card_type' value='<?php echo $list_card_type; ?>'>
                <input type=hidden name='list_menhgia' value='<?php echo $list_menhgia; ?>'>
                <select name='list_status' onchange='submit();'>
                    <option value=''>- Chọn Tình trạng thẻ -</option>
                    <option value="1" <?php if ($list_status == '1') { ?> selected="selected" <?php } ?>>Thẻ vừa
                        nạp/Đang chờ
                    </option>
                    <option value="2" <?php if ($list_status == '2') { ?> selected="selected" <?php } ?>>Tạm ứng/Chờ
                        kiểm tra
                    </option>
                    <option value="3" <?php if ($list_status == '3') { ?> selected="selected" <?php } ?>>Thẻ đúng/Hoàn
                        tất
                    </option>
                    <option value="4" <?php if ($list_status == '4') { ?> selected="selected" <?php } ?>>Thẻ sai/Xử
                        phạt
                    </option>
                </select>
                <input type=hidden name='page' value='<?php echo $fpage; ?>'>
            </form>
        </td>

        <td align="right"><a href='?action=dellcard' onMouseOut='hidetip();'
                             onMouseOver="showtip('Xóa đi số thẻ đã được xử lí.');">Xóa thẻ</a></td>

    </tr>
</table>

<table width="100%" cellspacing="1" cellpadding="3" border="0" bgcolor="#0000ff">
    <tr bgcolor="#ffffcc">
        <td align="center" colspan="3">
            <a href="?thang=<?php echo $thang_truoc; ?>&nam=<?php echo $nam_truoc; ?>">Tháng trước</a> <<
            Doanh thu
            <?php
            if (!empty($list_card_type)) {
                echo "<font color='blue'><b>$list_card_type</b></font>";
            } else echo "<font color='blue'><b>Tổng</b></font>";
            ?>
            <font color="red"><?php echo " (Tháng $month - Năm $year) : <b>$doanhthu_total</b>"; ?></font>
            >> <a href="?thang=<?php echo $thang_sau; ?>&nam=<?php echo $nam_sau; ?>">Tháng sau</a>
            <br>
            Thời gian hiện tại : <?php echo date("h:i A d/m/Y", $timestamp); ?>
            <br>
            Giá trị Vpoint thêm : VTC ( <?php echo $khuyenmai_vtc; ?>% )
        </td>
    </tr>
    <tr bgcolor="#ffffcc">
        <td align="center">Doanh thu hôm qua: <?php echo number_format($doanhthu_homqua[0], 0, ',', '.'); ?></td>
        <td align="center">Doanh thu hôm nay: <?php echo number_format($doanhthu_hientai[0], 0, ',', '.'); ?></td>
        <td align="center">Vpoint khuyến mại: <?php if ($khuyenmai == 1) echo $khuyenmai_phantram; else echo '0'; ?>%
        </td>
    </tr>
</table>

<table width="100%" cellspacing="1" cellpadding="3" border="0" bgcolor="#0000ff">
    <tr bgcolor="#ffffcc">
        <td align="center">#</td>
        <td align="center">Tài khoản</td>
        <td align="center">Nhân vật</td>
        <td align="center">Loại thẻ</td>
        <td align="center">Mệnh giá</td>
        <td align="center">Mã thẻ</td>
        <td align="center">Serial</td>
        <td align="center">Nạp lúc</td>
        <td align="center">Duyệt lúc</td>
        <td align="center">Tình trạng</td>
    </tr>
    <?php
    while ($row = $result->fetchrow()) {

        //Lấy thông tin vpoint từ Acc nạp thẻ
        $query_checkacc = "select vpoint from MEMB_INFO WHERE memb___id='$row[1]'";
        $result_checkacc = $db->Execute($query_checkacc);
        $checkacc = $result_checkacc->fetchrow();

        //Lấy thông tin Reset - ReLife của Nhân vật chính trong Acc nạp thẻ
        $query_char = "select resets,relifes from Character WHERE Name='$row[2]'";
        $result_char = $db->Execute($query_char);
        $char = $result_char->fetchrow();

        $stt_str = $stt_str + 1;
        $card_date = date("h:i A d/m/Y", $row[10]);
        if (!empty($row[11])) $card_duyet = date("h:i A d/m/Y", $row[11]);
        else $card_duyet = '';

        if ($row[8] == 0) {
            $status = '<font color=black>Thẻ vừa nạp/Đang chờ</font>';
            $color_begin = '<font color=black>';
            $color_end = '</font>';
        }
        if ($row[8] == 1) {
            $status = '<font color=green>Tạm ứng/Chờ kiểm tra</font>';
            $color_begin = '<font color=green>';
            $color_end = '</font>';
        }
        if ($row[8] == 2) {
            $status = '<font color=blue>Thẻ đúng/Hoàn tất</font>';
            $color_begin = '<font color=blue>';
            $color_end = '</font>';
        }
        if ($row[8] == 3) {
            $status = '<font color=red>Thẻ sai/Xử phạt</font>';
            $color_begin = '<font color=red>';
            $color_end = '</font>';
        }

        ?>
        <tr bgcolor='#F9E7CF'>
            <td align='center'><?php echo $stt_str; ?></td>
            <td align='center'><?php echo "<a href='#' onMouseOut='hidetip();' onMouseOver=\"showtip('vpoint hiện có : <font color=red>$checkacc[0]</font> .');\">$color_begin$row[1] (<font color=red>$checkacc[0]</font>)$color_end</a>"; ?></td>
            <td align='center'>
                <?php
                echo "<a href='#' onMouseOut='hidetip();' onMouseOver=\"showtip('Nhân vật bảo lãnh : $row[2] .<br>ReLifes : <font color=red>$char[1]</font> .<br>Reset : <font color=blue>$char[0]</font> .');\">$color_begin$row[2](<font color=red>$char[1]</font>,<font color=blue>$char[0]</font>)$color_end</a>";
                ?>
            </td>
            <td align='center'><?php echo $color_begin . $row[4] . $color_end; ?></td>
            <td align='center'>
                <?php echo $color_begin . number_format($row[3], 0, ',', '.') . $color_end; ?><br>
                <?php if ($row[8] == 0 or $row[8] == 1) { ?>
                    <form name=edit_menhgia method=get>
                        <select name='edit_menhgia' onchange='submit();'>
                            <option value='10000'
                                    <?php if ($row[3] == '10000') { ?>selected='1'<?php } ?> ><?php echo number_format(10000, 0, ',', '.'); ?></option>
                            <option value='20000'
                                    <?php if ($row[3] == '20000') { ?>selected='1'<?php } ?> ><?php echo number_format(20000, 0, ',', '.'); ?></option>
                            <option value='30000'
                                    <?php if ($row[3] == '30000') { ?>selected='1'<?php } ?> ><?php echo number_format(30000, 0, ',', '.'); ?></option>
                            <option value='50000'
                                    <?php if ($row[3] == '50000') { ?>selected='1'<?php } ?> ><?php echo number_format(50000, 0, ',', '.'); ?></option>
                            <option value='100000'
                                    <?php if ($row[3] == '100000') { ?>selected='1'<?php } ?> ><?php echo number_format(100000, 0, ',', '.'); ?></option>
                            <option value='200000'
                                    <?php if ($row[3] == '200000') { ?>selected='1'<?php } ?> ><?php echo number_format(200000, 0, ',', '.'); ?></option>
                            <option value='300000'
                                    <?php if ($row[3] == '300000') { ?>selected='1'<?php } ?> ><?php echo number_format(300000, 0, ',', '.'); ?></option>
                            <option value='500000'
                                    <?php if ($row[3] == '500000') { ?>selected='1'<?php } ?> ><?php echo number_format(500000, 0, ',', '.'); ?></option>
                        </select>
                        <input type=hidden name='action' value='edit_menhgia'>
                        <input type=hidden name='stt' value='<?php echo $row[0]; ?>'>
                        <input type=hidden name='page' value='<?php echo $fpage; ?>'>
                        <input type=hidden name='list_card_type' value='<?php echo $list_card_type; ?>'>
                        <input type=hidden name='list_status' value='<?php echo $list_status; ?>'>
                    </form>
                <?php } ?>
            </td>
            <td align='center'>
                <?php
                if ($row[4] == "VTC") {
                    echo "$color_begin$row[5]$color_end";
                } else if ($row[4] == "Gate") {
                    echo "$color_begin$row[5]$color_end";
                } else {
                    $phone_num1 = substr($row[5], 0, 4);
                    $phone_num2 = substr($row[5], 4, 4);
                    $phone_num3 = substr($row[5], 8);
                    echo "$color_begin$phone_num1 $phone_num2 $phone_num3$color_end";
                }
                ?>
            </td>
            <td align='center'>
                <?php
                $serial_num = $row[6];
                if ($row[4] == "VTC") {
                    $serial_num = substr($serial_num, 2);
                    echo "$color_begin$serial_num$color_end";
                } else if ($row[4] == "Gate") {
                    echo "$color_begin$serial_num$color_end";
                } else {
                    $serial_num1 = substr($serial_num, 0, 4);
                    $serial_num2 = substr($serial_num, 4, 4);
                    $serial_num3 = substr($serial_num, 8);
                    echo "$color_begin$serial_num1 $serial_num2 $serial_num3$color_end";
                }
                ?>
            </td>
            <td align='center'><?php echo $color_begin . $card_date . $color_end; ?></td>
            <td align='center'><?php echo $color_begin . $card_duyet . $color_end; ?></td>
            <td align='center'>
                <?php echo $status; ?><br>
                <?php if ($row[8] != 2 && $row[8] != 3) { ?>
                    <form name=up_stat method=get>
                        <select name='up_stat' onchange='submit();'>
                            <?php if ($row[8] == 0) { ?>
                                <option value='' <?php if ($row[8] == '0') { ?>selected='1'<?php } ?>>Chọn</option>
                            <?php } ?>
                            <?php if ($row[8] == 0 or $row[8] == 1 or $row[8] == 2 or $row[8] == 3) { ?>
                                <option value='1' <?php if ($row[8] == '1') { ?>selected='1'<?php } ?> >1 - Tạm ứng/Chờ
                                    kiểm tra
                                </option>
                                <option value='2'>2 - Thẻ đúng/Hoàn tất</option>
                                <option value='3'>3 - Thẻ sai/Xử phạt</option>
                            <?php } ?>
                        </select>
                        <input type=hidden name='action' value='up_stat'>
                        <input type=hidden name='menhgia' value='<?php echo $row[3]; ?>'>
                        <input type=hidden name='acc' value='<?php echo $row[1]; ?>'>
                        <input type=hidden name='status' value='<?php echo $row[8]; ?>'>
                        <input type=hidden name='add_vpoint' value='<?php echo $row[9]; ?>'>
                        <input type=hidden name='card_type' value='<?php echo $row[4]; ?>'>
                        <input type=hidden name='stt' value='<?php echo $row[0]; ?>'>
                        <input type=hidden name='page' value='<?php echo $fpage; ?>'>
                        <input type=hidden name='list_card_type' value='<?php echo $list_card_type; ?>'>
                        <input type=hidden name='list_status' value='<?php echo $list_status; ?>'>
                    </form>
                <?php } ?>
            </td>
        </tr>
        <?php
    }
    echo "</table>";

    $query_totalpages = $db->Execute($query);
    $totalpages = $query_totalpages->numrows();
    $totalpages = $totalpages / $Card_per_page;
    $totalpages = floor($totalpages) + 1;
    $c = 0;
    if ($totalpages > 0) {
        echo "<center>Trang: [" . $totalpages . "] ";
    }
    while ($c < $totalpages) {
        $page = $c + 1;
        if ($_GET['page'] == $page) {
            echo "[$page] ";
        } else {
            echo "<a href=\"?page=$page&list_card_type=$list_card_type&list_menhgia=$list_menhgia&list_status=$list_status&list_ctv=$list_ctv&list_ctv_check=$list_ctv_check\">[$page] </a> ";
        }
        $c = $c + 1;
    }

    if ($totalpages > 0) {
        echo "</center>";
    }
    ?>
