<?php

Class ServiceMuManager
{

    function search_account($acc)
    {
        $result = [
            'notice' => '',
            'data' => []
        ];

        if (empty($acc)) {
            $result['notice'] = "Chưa điền tên tài khoản vào chỗ trống";
            return $result;
        }

        $sql_username_check = do_select_other("SELECT memb___id FROM MEMB_INFO WHERE memb___id='" . $acc . "'");
        if (count($sql_username_check) < 1) {
            $result['notice'] = "Không tồn tại tài khoản <b>$acc</b>";
            cn_throw_message($result['notice'], 'e');
            return $result;
        }

        $query = "SELECT memb___id,mail_addr,tel__numb,bloc_code,fpas_ques,fpas_answ,bank,vpoint,jewel_chao,jewel_cre,jewel_blue,memb__pwd FROM MEMB_INFO WHERE memb___id='$acc'";
        $resultQuery = do_select_other($query);
        $resultData = is_array($resultQuery) ? $resultQuery[0] : [];
        $result['data'] = $resultData;

        $block_status = ($resultData['bloc_code'] == "1") ? __("block") : __("normal");
        $array_QA = convert_question_answer();
        $question = (isset($array_QA[$resultData['fpas_ques']]) ? $array_QA[$resultData['fpas_ques']] : '');

        $result['notice'] = "<b>TÀI KHOẢN</b>: <b>" . $resultData['memb___id'] . "</b>. (<b>$block_status</b>)<br>
							Địa chỉ Email: <b>" . $resultData['mail_addr'] . "</b>. Mật khẩu: <b>" . $resultData['memb__pwd'] . "</b><br>
							Số điện thoại: <b>" . $resultData['tel__numb'] . "</b>.<br>
							Câu hỏi bí mật: <b>" . $question . "</b>. Câu trả lời bí mật: <b>" . $resultData['fpas_answ'] . "</b>.<br>
							<br>
							<b>NGÂN HÀNG</b>: <br>
							Zen hiện có: <b>" . $resultData['bank'] . "</b> Zen.<br>
							V.Point hiện có: <b>" . $resultData['vpoint'] . "</b> V.Point.<br>
							Ngọc Hỗn Nguyên hiện có: <b>" . $resultData['jewel_chao'] . "</b> Viên.<br>
							Ngọc Sáng Tạo hiện có: <b>" . $resultData['jewel_cre'] . "</b> Viên.<br>
							Lông Vũ hiện có: <b>" . $resultData['jewel_blue'] . "</b> Cái.<br>";

        return $result;
    }

    function block_account($acc)
    {
        $result = [
            'notice' => '',
        ];

        if (empty($acc)) {
            $result['notice'] = "Chưa điền tên tài khoản vào chỗ trống";
            cn_throw_message($result['notice'] , 'e');
            return $result;
        }

        $username_check = do_select_other("SELECT memb___id FROM MEMB_INFO WHERE memb___id='$acc'");
        if (count($username_check) < 1) {
            $result['notice'] = "Không tồn tại tài khoản <b>$acc</b>";
            cn_throw_message($result['notice'] , 'e');
            return $result;
        }

        $block_check = do_select_other("SELECT memb___id FROM MEMB_INFO WHERE memb___id='$acc' and bloc_code='1'");
        if (count($block_check) > 0) {
            $result['notice'] = "Tài khoản <b>$acc</b> hiện đang bị Khóa.";
            cn_throw_message($result['notice'] , 'e');
        } else {
            $sql_block_result = do_update_other("UPDATE MEMB_INFO SET bloc_code='1' WHERE memb___id='$acc'");
            $result['notice'] = "Đã khóa tài khoản <b>$acc</b> " . ($sql_block_result ? "không " : "") . "thành công.";
            cn_throw_message($result['notice']);
        }

        return $result;
    }

    function unblock_account($acc)
    {
        $result = [
            'notice' => '',
        ];

        if (empty($acc)) {
            $result['notice'] = "Chưa điền tên tài khoản vào chỗ trống";
            cn_throw_message($result['notice'], 'e');
            return $result;
        }

        $username_check = do_select_other("SELECT memb___id FROM MEMB_INFO WHERE memb___id='$acc'");
        if (count($username_check) < 1) {
            $result['notice'] = "Không tồn tại tài khoản <b>$acc</b>";
            cn_throw_message($result['notice'], 'e');
            return $result;
        }

        $block_check = do_select_other("SELECT memb___id FROM MEMB_INFO WHERE memb___id='$acc' and bloc_code='0'");
        if (count($block_check) > 0) {
            $result['notice'] = "Tài khoản <b>$acc</b> hiện đang không bị Khóa.";
        } else {
            $sql_block_query = do_update_other("UPDATE MEMB_INFO SET bloc_code='0' WHERE memb___id='$acc'");
            $result['notice'] = "Đã mở khóa tài khoản <b>$acc</b> " . ($sql_block_query ? "không " : "") . "thành công.";
            cn_throw_message($result['notice']);
        }

        return $result;
    }

    function bank_add($acc, $zen, $vpoint)
    {
        if (empty($acc)) {
            cn_throw_message("Chưa điền tên tài khoản vào chỗ trống", 'e');
            return;
        }

        $username_check = do_select_other("SELECT memb___id FROM MEMB_INFO WHERE memb___id='$acc'");
        if (count($username_check) < 1) {
            cn_throw_message("Không tồn tại tài khoản <b>$acc</b>", 'e');
            return;
        }

        do_update_other("UPDATE MEMB_INFO SET bank=bank+$zen,vpoint=vpoint+$vpoint WHERE memb___id='$acc'");
        $notice = "Tài khoản $acc đã cộng thêm $zen Zen và $vpoint V.Point trong Ngân Hàng.";

        cn_throw_message($notice);
        return $notice;
    }

    function edit_account($acc, $email, $pass)
    {
        if (empty($acc)) {
            cn_throw_message("Chưa điền tên tài khoản vào chỗ trống", 'e');
            return;
        }
        $acc_check = do_select_other("SELECT memb___id,memb__pwd FROM MEMB_INFO WHERE memb___id='$acc'");
        if (count($acc_check) < 1) {
            cn_throw_message("Không tồn tại tài khoản <b>$acc</b>", 'e');
            return;
        }

        do_update_other("UPDATE MEMB_INFO SET mail_addr='$email',memb__pwd='$pass' WHERE memb___id='$acc'");
        $notice = "Cập nhật thông tin Tài khoản <b>$acc</b> thành công";
        cn_throw_message($notice);

        return $notice;
    }

    function bank_sub($acc, $zen, $vpoint)
    {

        if (empty($acc)) {
            cn_throw_message("Chưa điền tên tài khoản vào chỗ trống", 'e');
            return;
        }

        $username_check = do_select_other("SELECT memb___id FROM MEMB_INFO WHERE memb___id='$acc'");
        if (count($username_check) < 1) {
            cn_throw_message("Không tồn tại tài khoản <b>$acc</b>", 'e');
            return;
        }

        do_update_other("UPDATE MEMB_INFO SET bank=bank-$zen,vpoint=vpoint-$vpoint WHERE memb___id='$acc'");
        $notice = "Tài khoản $acc đã trừ đi $zen Zen và $vpoint V.Point trong Ngân Hàng.";
        cn_throw_message($notice);

        return $notice;
    }

    function bank_jewel($acc, $chao, $cre, $blue)
    {
        if (empty($acc)) {
            cn_throw_message("Chưa điền tên tài khoản vào chỗ trống", 'e');
            return;
        }

        $username_check = do_select_other("SELECT memb___id FROM MEMB_INFO WHERE memb___id='$acc'");
        if (count($username_check) < 1) {
            cn_throw_message("Không tồn tại tài khoản <b>$acc</b>", 'e');
            return;
        }

        do_update_other("UPDATE MEMB_INFO SET jewel_chao='$chao',jewel_cre='$cre',jewel_blue='$blue' WHERE memb___id='$acc'");
        $notice = "Tài khoản $acc đã cập nhật $chao Chaos, $cre Cre, $blue Blue trong Ngân Hàng.";

        cn_throw_message($notice);
        return $notice;
    }

    function block_character($char)
    {
        if (empty($char)) {
            cn_throw_message("Chưa điền tên tài khoản vào chỗ trống", 'e');
            return;
        }
        $username_check = do_select_other("SELECT Name FROM Character WHERE Name='$char'");
        if (count($username_check) < 1) {
            cn_throw_message("Không tồn tại nhân vật <b>$char</b>", 'e');
            return;
        }

        $block_check = do_select_other("SELECT Name FROM Character WHERE Name='$char' and ctlcode='1'");
        if (count($block_check) > 0) {

            cn_throw_message("Nhân vật <b>$char</b> hiện đang bị Khóa.", 'e');
            return;
        }

        do_update_other("UPDATE Character SET ctlcode='1' WHERE Name='$char'");
        $notice = "Đã khóa nhân vật <b>$char</b> thành công.";

        cn_throw_message($notice);
        return $notice;
    }

    function unblock_character($char)
    {
        if (empty($char)) {
            cn_throw_message("Chưa điền tên tài khoản vào chỗ trống", 'e');
            return;
        }
        $char_check = do_select_other("SELECT Name FROM Character WHERE Name='$char'");
        if (count($char_check) < 1) {
            cn_throw_message("Không tồn tại nhân vật <b>$char</b>", 'e');
            return;
        }

        $block_check = do_select_other("SELECT Name FROM Character WHERE Name='$char' and ctlcode='0'");
        if (count($block_check) > 0) {
             cn_throw_message("Nhân vật <b>$char</b> hiện đang không bị Khóa.", 'e');
            return;
        }

        do_update_other("UPDATE Character SET ctlcode='0' WHERE Name='$char'");
        $notice = "Đã mở khóa nhân vật <b>$char</b> thành công.";

        cn_throw_message($notice);
        return $notice;
    }

    function search_character($char, $class)
    {
        $result = [
            'notice' => '',
            'data' => [],
            'options' => []
        ];

        if (empty($char)) {
            cn_throw_message("Chưa điền tên nhân vật vào chỗ trống", 'e');
            return $result;
        }
        $char_check = do_select_other("SELECT Name FROM Character WHERE Name='$char'");
        if (count($char_check) < 1) {
            cn_throw_message("Không tồn tại nhân vật <b>$char</b>", 'e');
            return $result;
        }

        $query = "SELECT AccountID,Name,Class,cLevel,Strength,Dexterity,Vitality,Energy,Leadership,Resets,Relifes,LevelUpPoint,pointdutru,uythacoffline_stat,PointUyThac,SCFPCPoints,PkLevel,PkCount,ctlcode FROM Character WHERE Name='$char'";
        switch (getOption('server_type')) {
            case "scf":
                $query = "SELECT AccountID,Name,Class,cLevel,Strength,Dexterity,Vitality,Energy,Leadership,Resets,Relifes,LevelUpPoint,pointdutru,uythacoffline_stat,PointUyThac,SCFPCPoints,PkLevel,PkCount,ctlcode FROM Character WHERE Name='$char'";
                break;
            case "ori":
                $query = "SELECT AccountID,Name,Class,cLevel,Strength,Dexterity,Vitality,Energy,Leadership,Resets,Relifes,LevelUpPoint,pointdutru,uythacoffline_stat,PointUyThac,PCPoints,PkLevel,PkCount,ctlcode FROM Character WHERE Name='$char'";
                break;
            default:
                break;
        }
        $resultQuery = do_select_other($query);
        $row = is_array($resultQuery) ? $resultQuery[0] : [];
        $result['data'] = $row;


        $account = $row['AccountID'];
        $name = $row['Name'];
        $class_current = (int)$row['Class'];
        $result['options'] = [
            'class_current' => $class_current
        ];

        $class_name = '';
        switch ($class_current) {
            case (int)$class['class_dw_1']:
                $class_name = $class['class_dw_1_name'];
                break;
            case (int)$class['class_dw_2']:
                $class_name = $class['class_dw_2_name'];
                break;
            case (int)$class['class_dw_3']:
                $class_name = $class['class_dw_3_name'];
                break;
            case (int)$class['class_dk_1']:
                $class_name = $class['class_dk_1_name'];
                break;
            case (int)$class['class_dk_2']:
                $class_name = $class['class_dk_2_name'];
                break;
            case (int)$class['class_dk_3']:
                $class_name = $class['class_dk_3_name'];
                break;
            case (int)$class['class_elf_1']:
                $class_name = $class['class_elf_1_name'];
                break;
            case (int)$class['class_elf_2']:
                $class_name = $class['class_elf_2_name'];
                break;
            case (int)$class['class_elf_3']:
                $class_name = $class['class_elf_3_name'];
                break;
            case (int)$class['class_mg_1']:
                $class_name = $class['class_mg_1_name'];
                break;
            case (int)$class['class_mg_2']:
                $class_name = $class['class_mg_2_name'];
                break;
            case (int)$class['class_dl_1']:
                $class_name = $class['class_dl_1_name'];
                break;
            case (int)$class['class_dl_2']:
                $class_name = $class['class_dl_2_name'];
                break;
            case (int)$class['class_sum_1']:
                $class_name = $class['class_sum_1_name'];
                break;
            case (int)$class['class_sum_2']:
                $class_name = $class['class_sum_2_name'];
                break;
            case (int)$class['class_sum_3']:
                $class_name = $class['class_sum_3_name'];
                break;
            case (int)$class['class_rf_1']:
                $class_name = $class['class_rf_1_name'];
                break;
            case (int)$class['class_rf_2']:
                $class_name = $class['class_rf_2_name'];
                break;
        }
        $level = $row['cLevel'];
        $str = $row['Strength'];
        $dex = $row['Dexterity'];
        $vit = $row['Vitality'];
        $ene = $row['Energy'];
        $com = $row['Leadership'];
        $reset = $row['Resets'];
        $relife = $row['Relifes'];
        $point = $row['LevelUpPoint'];
        $pointdutru = $row['pointdutru'];
        $uythac = '';
        switch ($row['uythacoffline_stat']) {
            case 0:
                $uythac = "Không Ủy thác";
                break;
            case 1:
                $uythac = "<font color='green'>Ủy thác</font>";
                break;
        }
        $pcpoint = isset($row['PCPoints']) ? $row['PCPoints'] : $row['SCFPCPoints'];

        switch ($row['PkLevel']) {
            case PK_LEVEL_SUPER_HERO:
                $pklevel = __('pk_level_super_hero');
                break;
            case PK_LEVEL_HERO:
                $pklevel = __('pk_level_hero');
                break;
            case PK_LEVEL_NORMAL:
                $pklevel = __('pK_level_normal');
                break;
            case PK_LEVEL_ASSASSIN_0 :
                $pklevel = __('pk_level_assassin_0');
                break;
            case PK_LEVEL_ASSASSIN_1:
                $pklevel = __('pk_level_assassin_1');
                break;
            case PK_LEVEL_ASSASSIN_2:
                $pklevel = __('pk_level_assassin_2');
                break;
        }

        switch ($row['ctlcode']) {
            case PK_CTL_CODE_NORMAL:
                $status = __('ctl_code_normal');
                break;
            case PK_CTL_CODE_BLOCK:
                $status = __('ctl_code_block');
                break;
            case PK_CTL_CODE_GAME_MASTER_8:
                $status = __('ctl_code_game_master_8');
                break;
            case PK_CTL_CODE_GAME_MASTER_32:
                $status = __('ctl_code_game_master_32');
                break;
            case PK_CTL_CODE_BLOCK_ITEMS:
                $status = __('ctl_code_block_items');
                break;
        }

        $result['notice'] = '<table class="table" width="100%">
						<tr>
							<td><b>TÀI KHOẢN : <font color="blue">' . $account . '</font></b></td>
							<td><b>TÊN NHÂN VẬT : <font color="blue">' . $name . '</font></b></td>
						</tr>
						<tr>
							<td>Cấp độ : <font color="orange"><b>' . $level . '</b></font></td>
							<td>Chủng tộc : <font color="brown"><b>' . $class_name . '</b></font></td>
						</tr>
						<tr>
							<td>Sức mạnh : <b>' . number_format($str, 0, ",", ".") . '</b></td>
							<td>Điểm chưa cộng : <b>' . number_format($point, 0, ",", ".") . '</b></td>
						</tr>
						<tr>
							<td>Nhanh nhẹn : <b>' . number_format($dex, 0, ",", ".") . '</b></td>
							<td>Điểm dự trữ : <b>' . number_format($pointdutru, 0, ",", ".") . '</b></td>
						</tr>
						<tr>
							<td>Sinh lực : <b>' . number_format($vit, 0, ",", ".") . '</b></td>
							<td>Điểm Phúc Duyên : <b>' . number_format($pcpoint, 0, ",", ".") . '</b></td>
						</tr>
						<tr>
							<td>Năng lượng : <b>' . number_format($ene, 0, ",", ".") . '</b></td>
							<td>Reset : <font color="red"><b>' . $reset . '</b></font></td>
						</tr>
						<tr>
							<td>Mệnh lệnh : <b>' . number_format($com, 0, ",", ".") . '</b></td>
							<td>Relife : <font color="green"><b>' . $relife . '</b></font></td>
						</tr>
						<tr>
							<td>Tình trạng Ủy Thác : <b>' . $uythac . '</b></td>
							<td>Điểm Ủy Thác : <font color="green"><b>' . number_format($row['PointUyThac'], 0, ",", ".") . '</b></font></td>
						</tr>
						<tr>
							<td>Cấp bậc: <font color="green"><b>' . $pklevel . '</b></font></td>
							<td>Đã giết: <font color="red"><b>' . $row['PkCount'] . ' mạng</b></font></td>
						</tr>
						<tr>
							<td>Tình trạng: <font color="orange"><b>' . $status . '</b></font></td>
						</tr>
							</table>';

        return $result;
    }

    function edit_character($char, $class_post, $level, $str, $dex, $vit, $ene, $com, $reset, $relife, $point, $pointdutru, $pcpoint)
    {
        if (empty($char)) {
            cn_throw_message("Chưa điền tên nhân vật vào chỗ trống", 'e');
            return;
        }

        $acc_check = do_select_other("SELECT Name FROM Character WHERE Name='$char'");
        if (count($acc_check) < 1) {
            cn_throw_message("Không tồn tại nhân vật <b>$char</b>", 'e');
            return;
        }
        switch (getOption('server_type')) {
            case "scf":
                $query = "UPDATE Character SET Class='$class_post',cLevel='$level',Strength='$str',Dexterity='$dex',Vitality='$vit',Energy='$ene',Leadership='$com',Resets='$reset',Relifes='$relife',LevelUpPoint='$point',pointdutru='$pointdutru',SCFPCPoints='$pcpoint' WHERE Name='$char'";
                break;
            case "ori":
                $query = "UPDATE Character SET Class='$class_post',cLevel='$level',Strength='$str',Dexterity='$dex',Vitality='$vit',Energy='$ene',Leadership='$com',Resets='$reset',Relifes='$relife',LevelUpPoint='$point',pointdutru='$pointdutru',PCPoints='$pcpoint' WHERE Name='$char'";
                break;
            default:
                $query = "UPDATE Character SET Class='$class_post',cLevel='$level',Strength='$str',Dexterity='$dex',Vitality='$vit',Energy='$ene',Leadership='$com',Resets='$reset',Relifes='$relife',LevelUpPoint='$point',pointdutru='$pointdutru',SCFPCPoints='$pcpoint' WHERE Name='$char'";
                break;
        }
        do_update_other($query);
        $notice = "Cập nhật thông tin Nhân vật <b>$char</b> thành công";

        cn_throw_message($notice);
        return $notice;
    }
}
