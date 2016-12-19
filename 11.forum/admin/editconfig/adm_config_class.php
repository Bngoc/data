<?php
$file_edit = 'config/config_class.php';
if(!is_file($file_edit)) 
{ 
	$fp_host = fopen($file_edit, "w");
	fclose($fp_host);
}

if(is_writable($file_edit))	{ $can_write = "<font color=green>Có thể ghi</font>"; $accept = 1;}
	else { $can_write = "<font color=red>Không thể ghi - Hãy sử dụng chương trình FTP FileZilla chuyển <b>File permission</b> sang 666</font>"; $accept = 0; }

if (!$usehost) {
	$file_edit_sv = $server_path;
	$file_edit_sv .= $file_edit;
	if(!is_file($file_edit_sv)) 
	{ 
		$fp_host = fopen($file_edit_sv, "w");
		fclose($fp_host);
	}
	if(is_writable($file_edit_sv))	{ $can_write_sv = "<font color=green>Có thể ghi</font>"; $accept = 1;}
		else { $can_write_sv = "<font color=red>Không thể ghi - Hãy sử dụng chương trình FTP FileZilla chuyển <b>File permission</b> sang 666</font>"; $accept = 0; }
}

$action = $_POST[action];

if($action == 'edit')
{
	$class_dw_1 = $_POST['class_dw_1'];		$class_dw_1_name = $_POST['class_dw_1_name'];
	$class_dw_2 = $_POST['class_dw_2'];		$class_dw_2_name = $_POST['class_dw_2_name'];
	$class_dw_3 = $_POST['class_dw_3'];		$class_dw_3_name = $_POST['class_dw_3_name'];
	$class_dk_1 = $_POST['class_dk_1'];		$class_dk_1_name = $_POST['class_dk_1_name'];
	$class_dk_2 = $_POST['class_dk_2'];		$class_dk_2_name = $_POST['class_dk_2_name'];
	$class_dk_3 = $_POST['class_dk_3'];		$class_dk_3_name = $_POST['class_dk_3_name'];
	$class_elf_1 = $_POST['class_elf_1'];	$class_elf_1_name = $_POST['class_elf_1_name'];
	$class_elf_2 = $_POST['class_elf_2'];	$class_elf_2_name = $_POST['class_elf_2_name'];
	$class_elf_3 = $_POST['class_elf_3'];	$class_elf_3_name = $_POST['class_elf_3_name'];
	$class_mg_1 = $_POST['class_mg_1'];		$class_mg_1_name = $_POST['class_mg_1_name'];
	$class_mg_2 = $_POST['class_mg_2'];		$class_mg_2_name = $_POST['class_mg_2_name'];
	$class_dl_1 = $_POST['class_dl_1'];		$class_dl_1_name = $_POST['class_dl_1_name'];
	$class_dl_2 = $_POST['class_dl_2'];		$class_dl_2_name = $_POST['class_dl_2_name'];
	$class_sum_1 = $_POST['class_sum_1'];	$class_sum_1_name = $_POST['class_sum_1_name'];
	$class_sum_2 = $_POST['class_sum_2'];	$class_sum_2_name = $_POST['class_sum_2_name'];
	$class_sum_3 = $_POST['class_sum_3'];	$class_sum_3_name = $_POST['class_sum_3_name'];
	$class_rf_1 = $_POST['class_rf_1'];	$class_rf_1_name = $_POST['class_rf_1_name'];
	$class_rf_2 = $_POST['class_rf_2'];	$class_rf_2_name = $_POST['class_rf_2_name'];
	
	$content = "<?php\n";
	$content .= "\$class_dw_1 = $class_dw_1;\t";	$content .= "\$class_dw_1_name = '$class_dw_1_name';\n";
	$content .= "\$class_dw_2 = $class_dw_2;\t";	$content .= "\$class_dw_2_name = '$class_dw_2_name';\n";
	$content .= "\$class_dw_3 = $class_dw_3;\t";	$content .= "\$class_dw_3_name = '$class_dw_3_name';\n";
	$content .= "\$class_dk_1 = $class_dk_1;\t";	$content .= "\$class_dk_1_name = '$class_dk_1_name';\n";
	$content .= "\$class_dk_2 = $class_dk_2;\t";	$content .= "\$class_dk_2_name = '$class_dk_2_name';\n";
	$content .= "\$class_dk_3 = $class_dk_3;\t";	$content .= "\$class_dk_3_name = '$class_dk_3_name';\n";
	$content .= "\$class_elf_1 = $class_elf_1;\t";	$content .= "\$class_elf_1_name = '$class_elf_1_name';\n";
	$content .= "\$class_elf_2 = $class_elf_2;\t";	$content .= "\$class_elf_2_name = '$class_elf_2_name';\n";
	$content .= "\$class_elf_3 = $class_elf_3;\t";	$content .= "\$class_elf_3_name = '$class_elf_3_name';\n";
	$content .= "\$class_mg_1 = $class_mg_1;\t";	$content .= "\$class_mg_1_name = '$class_mg_1_name';\n";
	$content .= "\$class_mg_2 = $class_mg_2;\t";	$content .= "\$class_mg_2_name = '$class_mg_2_name';\n";
	$content .= "\$class_dl_1 = $class_dl_1;\t";	$content .= "\$class_dl_1_name = '$class_dl_1_name';\n";
	$content .= "\$class_dl_2 = $class_dl_2;\t";	$content .= "\$class_dl_2_name = '$class_dl_2_name';\n";
	$content .= "\$class_sum_1 = $class_sum_1;\t";	$content .= "\$class_sum_1_name = '$class_sum_1_name';\n";
	$content .= "\$class_sum_2 = $class_sum_2;\t";	$content .= "\$class_sum_2_name = '$class_sum_2_name';\n";
	$content .= "\$class_sum_3 = $class_sum_3;\t";	$content .= "\$class_sum_3_name = '$class_sum_3_name';\n";
	$content .= "\$class_rf_1 = $class_rf_1;\t";	$content .= "\$class_rf_1_name = '$class_rf_1_name';\n";
	$content .= "\$class_rf_2 = $class_rf_2;\t";	$content .= "\$class_rf_2_name = '$class_rf_2_name';\n";
	$content .= "?>";
	
	require_once('admin/function.php');
	replacecontent($file_edit,$content);
	if (!$usehost) replacecontent($file_edit_sv,$content);
	
	$notice = "<center><font color='red'>Sửa thành công</font></center>";
}

include($file_edit);
?>
		<div id="center-column">
			<div class="top-bar">
				<h1>Cấu Hình Chung</h1>
			</div><br>
			Tập tin <?php echo "<b>".$file_edit."</b> : ".$can_write; ?><?php if (!$usehost) {?><br>
			Tập tin <?php echo "<b>".$file_edit_sv."</b> : ".$can_write_sv; ?><?php }?>
		  <div class="select-bar"></div>
			<div class="table">
<?php if($notice) echo $notice; ?>
				<form id="editconfig" name="editconfig" method="post" action="">
				<input type="hidden" name="action" value="edit">
				<table>
					<tr><td colspan="2"><hr></td></tr>
					
					<tr>
						<td>Mã nhân vật DarkWizard cấp 1: </td>
						<td><input type="text" name="class_dw_1" value="<?php echo $class_dw_1; ?>" size="3" maxlength="2"></td>
						<td>Tên hiển thị nhân vật DarkWizard cấp 1: </td>
						<td><input type="word" name="class_dw_1_name" value="<?php echo $class_dw_1_name; ?>" size="20" maxlength="19"></td>
					</tr>
					<tr>
						<td>Mã nhân vật DarkWizard cấp 2: </td>
						<td><input type="text" name="class_dw_2" value="<?php echo $class_dw_2; ?>" size="3" maxlength="2"></td>
						<td>Tên hiển thị nhân vật DarkWizard cấp 2: </td>
						<td><input type="text" name="class_dw_2_name" value="<?php echo $class_dw_2_name; ?>" size="20" maxlength="19"></td>
					</tr>
					<tr>
						<td>Mã nhân vật DarkWizard cấp 3: </td>
						<td><input type="text" name="class_dw_3" value="<?php echo $class_dw_3; ?>" size="3" maxlength="2"></td>
						<td>Tên hiển thị nhân vật DarkWizard cấp 3: </td>
						<td><input type="text" name="class_dw_3_name" value="<?php echo $class_dw_3_name; ?>" size="20" maxlength="19"></td>
					</tr>
					<tr><td colspan="2"><hr></td></tr>
					
					<tr>
						<td>Mã nhân vật DarkKnight cấp 1: </td>
						<td><input type="text" name="class_dk_1" value="<?php echo $class_dk_1; ?>" size="3" maxlength="2"></td>
						<td>Tên hiển thị nhân vật DarkKnight cấp 1: </td>
						<td><input type="text" name="class_dk_1_name" value="<?php echo $class_dk_1_name; ?>" size="20" maxlength="19"></td>
					</tr>
					<tr>
						<td>Mã nhân vật DarkKnight cấp 2: </td>
						<td><input type="text" name="class_dk_2" value="<?php echo $class_dk_2; ?>" size="3" maxlength="2"></td>
						<td>Tên hiển thị nhân vật DarkKnight cấp 2: </td>
						<td><input type="text" name="class_dk_2_name" value="<?php echo $class_dk_2_name; ?>" size="20" maxlength="19"></td>
					</tr>
					<tr>
						<td>Mã nhân vật DarkKnight cấp 3: </td>
						<td><input type="text" name="class_dk_3" value="<?php echo $class_dk_3; ?>" size="3" maxlength="2"></td>
						<td>Tên hiển thị nhân vật DarkKnight cấp 3: </td>
						<td><input type="text" name="class_dk_3_name" value="<?php echo $class_dk_3_name; ?>" size="20" maxlength="19"></td>
					</tr>
					<tr><td colspan="2"><hr></td></tr>
					
					<tr>
						<td>Mã nhân vật ELF cấp 1: </td>
						<td><input type="text" name="class_elf_1" value="<?php echo $class_elf_1; ?>" size="3" maxlength="2"></td>
						<td>Tên hiển thị nhân vật ELF cấp 1: </td>
						<td><input type="text" name="class_elf_1_name" value="<?php echo $class_elf_1_name; ?>" size="20" maxlength="19"></td>
					</tr>
					<tr>
						<td>Mã nhân vật ELF cấp 2: </td>
						<td><input type="text" name="class_elf_2" value="<?php echo $class_elf_2; ?>" size="3" maxlength="2"></td>
						<td>Tên hiển thị nhân vật ELF cấp 2: </td>
						<td><input type="text" name="class_elf_2_name" value="<?php echo $class_elf_2_name; ?>" size="20" maxlength="19"></td>
					</tr>
					<tr>
						<td>Mã nhân vật ELF cấp 3: </td>
						<td><input type="text" name="class_elf_3" value="<?php echo $class_elf_3; ?>" size="3" maxlength="2"></td>
						<td>Tên hiển thị nhân vật ELF cấp 3: </td>
						<td><input type="text" name="class_elf_3_name" value="<?php echo $class_elf_3_name; ?>" size="20" maxlength="19"></td>
					</tr>
					<tr><td colspan="2"><hr></td></tr>
					
					<tr>
						<td>Mã nhân vật MG cấp 1: </td>
						<td><input type="text" name="class_mg_1" value="<?php echo $class_mg_1; ?>" size="3" maxlength="2"></td>
						<td>Tên hiển thị nhân vật MG cấp 1: </td>
						<td><input type="text" name="class_mg_1_name" value="<?php echo $class_mg_1_name; ?>" size="20" maxlength="19"></td>
					</tr>
					<tr>
						<td>Mã nhân vật MG cấp 2: </td>
						<td><input type="text" name="class_mg_2" value="<?php echo $class_mg_2; ?>" size="3" maxlength="2"></td>
						<td>Tên hiển thị nhân vật MG cấp 2: </td>
						<td><input type="text" name="class_mg_2_name" value="<?php echo $class_mg_2_name; ?>" size="20" maxlength="19"></td>
					</tr>
					<tr><td colspan="2"><hr></td></tr>
					
					<tr>
						<td>Mã nhân vật DarkLord cấp 1: </td>
						<td><input type="text" name="class_dl_1" value="<?php echo $class_dl_1; ?>" size="3" maxlength="2"></td>
						<td>Tên hiển thị nhân vật DarkLord cấp 1: </td>
						<td><input type="text" name="class_dl_1_name" value="<?php echo $class_dl_1_name; ?>" size="20" maxlength="19"></td>
					</tr>
					<tr>
						<td>Mã nhân vật DarkLord cấp 2: </td>
						<td><input type="text" name="class_dl_2" value="<?php echo $class_dl_2; ?>" size="3" maxlength="2"></td>
						<td>Tên hiển thị nhân vật DarkLord cấp 2: </td>
						<td><input type="text" name="class_dl_2_name" value="<?php echo $class_dl_2_name; ?>" size="20" maxlength="19"></td>
					</tr>
					<tr><td colspan="2"><hr></td></tr>
					
					<tr>
						<td>Mã nhân vật Summoner cấp 1: </td>
						<td><input type="text" name="class_sum_1" value="<?php echo $class_sum_1; ?>" size="3" maxlength="2"></td>
						<td>Tên hiển thị nhân vật Summoner cấp 1: </td>
						<td><input type="text" name="class_sum_1_name" value="<?php echo $class_sum_1_name; ?>" size="20" maxlength="19"></td>
					</tr>
					<tr>
						<td>Mã nhân vật Summoner cấp 2: </td>
						<td><input type="text" name="class_sum_2" value="<?php echo $class_sum_2; ?>" size="3" maxlength="2"></td>
						<td>Tên hiển thị nhân vật Summoner cấp 2: </td>
						<td><input type="text" name="class_sum_2_name" value="<?php echo $class_sum_2_name; ?>" size="20" maxlength="19"></td>
					</tr>
					<tr>
						<td>Mã nhân vật Summoner cấp 3: </td>
						<td><input type="text" name="class_sum_3" value="<?php echo $class_sum_3; ?>" size="3" maxlength="2"></td>
						<td>Tên hiển thị nhân vật Summoner cấp 3: </td>
						<td><input type="text" name="class_sum_3_name" value="<?php echo $class_sum_3_name; ?>" size="20" maxlength="19"></td>
					</tr>
					<tr><td colspan="2"><hr></td></tr>
					
					<tr>
						<td>Mã nhân vật RageFighter cấp 1: </td>
						<td><input type="text" name="class_rf_1" value="<?php echo $class_rf_1; ?>" size="3" maxlength="2"></td>
						<td>Tên hiển thị nhân vật RageFighter cấp 1: </td>
						<td><input type="text" name="class_rf_1_name" value="<?php echo $class_rf_1_name; ?>" size="20" maxlength="19"></td>
					</tr>
					<tr>
						<td>Mã nhân vật RageFighter cấp 2: </td>
						<td><input type="text" name="class_rf_2" value="<?php echo $class_rf_2; ?>" size="3" maxlength="2"></td>
						<td>Tên hiển thị nhân vật RageFighter cấp 2: </td>
						<td><input type="text" name="class_rf_2_name" value="<?php echo $class_rf_2_name; ?>" size="20" maxlength="19"></td>
					</tr>
					<tr><td colspan="2"><hr></td></tr>
					
					<tr>
						<td>&nbsp;</td>
						<td align="center"><input type="submit" name="Submit" value="Sửa" <?php if($accept=='0') { ?> disabled="disabled" <?php } ?> ></td>
					</tr>
				</table>
				</form>
			</div>
		</div>
		<div id="right-column">
			<strong class="h">Thông tin</strong>
			<div class="box">Cấu hình :<br>
			- Tên WebSite<br>
			- Địa chỉ kết nối đến Server</div>
	  </div>
	  
