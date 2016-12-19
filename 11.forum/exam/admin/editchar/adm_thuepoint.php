<?php
$file_edit = 'config/config_thuepoint.php';
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
	$content = "<?php\n";
	
	$thuepoint_point1 = $_POST['thuepoint_point1'];		$content .= "\$thuepoint_point1	= $thuepoint_point1;\t";
	$thuepoint_vpoint1 = $_POST['thuepoint_vpoint1'];		$content .= "\$thuepoint_vpoint1	= $thuepoint_vpoint1;\t";
	$thuepoint_relife1 = $_POST['thuepoint_relife1'];		$content .= "\$thuepoint_relife1	= $thuepoint_relife1;\n";
	
	$thuepoint_point2 = $_POST['thuepoint_point2'];		$content .= "\$thuepoint_point2	= $thuepoint_point2;\t";
	$thuepoint_vpoint2 = $_POST['thuepoint_vpoint2'];		$content .= "\$thuepoint_vpoint2	= $thuepoint_vpoint2;\t";
	$thuepoint_relife2 = $_POST['thuepoint_relife2'];		$content .= "\$thuepoint_relife2	= $thuepoint_relife2;\n";
	
	$thuepoint_point3 = $_POST['thuepoint_point3'];		$content .= "\$thuepoint_point3	= $thuepoint_point3;\t";
	$thuepoint_vpoint3 = $_POST['thuepoint_vpoint3'];		$content .= "\$thuepoint_vpoint3	= $thuepoint_vpoint3;\t";
	$thuepoint_relife3 = $_POST['thuepoint_relife3'];		$content .= "\$thuepoint_relife3	= $thuepoint_relife3;\n";
	
	$thuepoint_point4 = $_POST['thuepoint_point4'];		$content .= "\$thuepoint_point4	= $thuepoint_point4;\t";
	$thuepoint_vpoint4 = $_POST['thuepoint_vpoint4'];		$content .= "\$thuepoint_vpoint4	= $thuepoint_vpoint4;\t";
	$thuepoint_relife4 = $_POST['thuepoint_relife4'];		$content .= "\$thuepoint_relife4	= $thuepoint_relife4;\n";
	
	$thuepoint_point5 = $_POST['thuepoint_point5'];		$content .= "\$thuepoint_point5	= $thuepoint_point5;\t";
	$thuepoint_vpoint5 = $_POST['thuepoint_vpoint5'];		$content .= "\$thuepoint_vpoint5	= $thuepoint_vpoint5;\t";
	$thuepoint_relife5 = $_POST['thuepoint_relife5'];		$content .= "\$thuepoint_relife5	= $thuepoint_relife5;\n";
	
	$thuepoint_point6 = $_POST['thuepoint_point6'];		$content .= "\$thuepoint_point6	= $thuepoint_point6;\t";
	$thuepoint_vpoint6 = $_POST['thuepoint_vpoint6'];		$content .= "\$thuepoint_vpoint6	= $thuepoint_vpoint6;\t";
	$thuepoint_relife6 = $_POST['thuepoint_relife6'];		$content .= "\$thuepoint_relife6	= $thuepoint_relife6;\n";
	
	$thuepoint_point7 = $_POST['thuepoint_point7'];		$content .= "\$thuepoint_point7	= $thuepoint_point7;\t";
	$thuepoint_vpoint7 = $_POST['thuepoint_vpoint7'];		$content .= "\$thuepoint_vpoint7	= $thuepoint_vpoint7;\t";
	$thuepoint_relife7 = $_POST['thuepoint_relife7'];		$content .= "\$thuepoint_relife7	= $thuepoint_relife7;\n";
	
	$thuepoint_point8 = $_POST['thuepoint_point8'];		$content .= "\$thuepoint_point8	= $thuepoint_point8;\t";
	$thuepoint_vpoint8 = $_POST['thuepoint_vpoint8'];		$content .= "\$thuepoint_vpoint8	= $thuepoint_vpoint8;\t";
	$thuepoint_relife8 = $_POST['thuepoint_relife8'];		$content .= "\$thuepoint_relife8	= $thuepoint_relife8;\n";
	
	$thuepoint_point9 = $_POST['thuepoint_point9'];		$content .= "\$thuepoint_point9	= $thuepoint_point9;\t";
	$thuepoint_vpoint9 = $_POST['thuepoint_vpoint9'];		$content .= "\$thuepoint_vpoint9	= $thuepoint_vpoint9;\t";
	$thuepoint_relife9 = $_POST['thuepoint_relife9'];		$content .= "\$thuepoint_relife9	= $thuepoint_relife9;\n";
	
	$thuepoint_point10 = $_POST['thuepoint_point10'];		$content .= "\$thuepoint_point10	= $thuepoint_point10;\t";
	$thuepoint_vpoint10 = $_POST['thuepoint_vpoint10'];		$content .= "\$thuepoint_vpoint10	= $thuepoint_vpoint10;\t";
	$thuepoint_relife10 = $_POST['thuepoint_relife10'];		$content .= "\$thuepoint_relife10	= $thuepoint_relife10;\n";
	
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
				<h1>Cấu Hình ReLife</h1>
			</div><br>
			Tập tin <?php echo "<b>".$file_edit."</b> : ".$can_write; ?><?php if (!$usehost) {?><br>
			Tập tin <?php echo "<b>".$file_edit_sv."</b> : ".$can_write_sv; ?><?php }?>
		  <div class="select-bar"></div>
			<div class="table">
<?php if($notice) echo $notice; ?>
				<form id="editconfig" name="editconfig" method="post" action="">
				<input type="hidden" name="action" value="edit"/>
					<table width="100%" border="0" bgcolor="#9999FF">
					  <tr bgcolor="#FFFFFF">
					    <th align="center" scope="col">Số Point thuê</th>
					    <th align="center" scope="col">Số V.Point cần khi thuê</th>
					    <th align="center" scope="col">Cấp Relife yêu cầu khi thuê</th>
					  </tr>
					  
					  <tr bgcolor="#FFFFFF">
					    <td align="center"><input type="text" name="thuepoint_point1" value="<?php echo $thuepoint_point1; ?>" size="5"/></td>
					    <td align="center"><input type="text" name="thuepoint_vpoint1" value="<?php echo $thuepoint_vpoint1; ?>" size="5"/></td>
					    <td align="center"><input type="text" name="thuepoint_relife1" value="<?php echo $thuepoint_relife1; ?>" size="5"/></td>
					  </tr>
					  
					  <tr bgcolor="#FFFFFF">
					    <td align="center"><input type="text" name="thuepoint_point2" value="<?php echo $thuepoint_point2; ?>" size="5"/></td>
					    <td align="center"><input type="text" name="thuepoint_vpoint2" value="<?php echo $thuepoint_vpoint2; ?>" size="5"/></td>
					    <td align="center"><input type="text" name="thuepoint_relife2" value="<?php echo $thuepoint_relife2; ?>" size="5"/></td>
					  </tr>
					  
					  <tr bgcolor="#FFFFFF">
					    <td align="center"><input type="text" name="thuepoint_point3" value="<?php echo $thuepoint_point3; ?>" size="5"/></td>
					    <td align="center"><input type="text" name="thuepoint_vpoint3" value="<?php echo $thuepoint_vpoint3; ?>" size="5"/></td>
					    <td align="center"><input type="text" name="thuepoint_relife3" value="<?php echo $thuepoint_relife3; ?>" size="5"/></td>
					  </tr>
					  
					  <tr bgcolor="#FFFFFF">
					    <td align="center"><input type="text" name="thuepoint_point4" value="<?php echo $thuepoint_point4; ?>" size="5"/></td>
					    <td align="center"><input type="text" name="thuepoint_vpoint4" value="<?php echo $thuepoint_vpoint4; ?>" size="5"/></td>
					    <td align="center"><input type="text" name="thuepoint_relife4" value="<?php echo $thuepoint_relife4; ?>" size="5"/></td>
					  </tr>
					  
					  <tr bgcolor="#FFFFFF">
					    <td align="center"><input type="text" name="thuepoint_point5" value="<?php echo $thuepoint_point5; ?>" size="5"/></td>
					    <td align="center"><input type="text" name="thuepoint_vpoint5" value="<?php echo $thuepoint_vpoint5; ?>" size="5"/></td>
					    <td align="center"><input type="text" name="thuepoint_relife5" value="<?php echo $thuepoint_relife5; ?>" size="5"/></td>
					  </tr>
					  
					  <tr bgcolor="#FFFFFF">
					    <td align="center"><input type="text" name="thuepoint_point6" value="<?php echo $thuepoint_point6; ?>" size="5"/></td>
					    <td align="center"><input type="text" name="thuepoint_vpoint6" value="<?php echo $thuepoint_vpoint6; ?>" size="5"/></td>
					    <td align="center"><input type="text" name="thuepoint_relife6" value="<?php echo $thuepoint_relife6; ?>" size="5"/></td>
					  </tr>
					  
					  <tr bgcolor="#FFFFFF">
					    <td align="center"><input type="text" name="thuepoint_point7" value="<?php echo $thuepoint_point7; ?>" size="5"/></td>
					    <td align="center"><input type="text" name="thuepoint_vpoint7" value="<?php echo $thuepoint_vpoint7; ?>" size="5"/></td>
					    <td align="center"><input type="text" name="thuepoint_relife7" value="<?php echo $thuepoint_relife7; ?>" size="5"/></td>
					  </tr>
					  
					  <tr bgcolor="#FFFFFF">
					    <td align="center"><input type="text" name="thuepoint_point8" value="<?php echo $thuepoint_point8; ?>" size="5"/></td>
					    <td align="center"><input type="text" name="thuepoint_vpoint8" value="<?php echo $thuepoint_vpoint8; ?>" size="5"/></td>
					    <td align="center"><input type="text" name="thuepoint_relife8" value="<?php echo $thuepoint_relife8; ?>" size="5"/></td>
					  </tr>
					  
					  <tr bgcolor="#FFFFFF">
					    <td align="center"><input type="text" name="thuepoint_point9" value="<?php echo $thuepoint_point9; ?>" size="5"/></td>
					    <td align="center"><input type="text" name="thuepoint_vpoint9" value="<?php echo $thuepoint_vpoint9; ?>" size="5"/></td>
					    <td align="center"><input type="text" name="thuepoint_relife9" value="<?php echo $thuepoint_relife9; ?>" size="5"/></td>
					  </tr>
					  
					  <tr bgcolor="#FFFFFF">
					    <td align="center"><input type="text" name="thuepoint_point10" value="<?php echo $thuepoint_point10; ?>" size="5"/></td>
					    <td align="center"><input type="text" name="thuepoint_vpoint10" value="<?php echo $thuepoint_vpoint10; ?>" size="5"/></td>
					    <td align="center"><input type="text" name="thuepoint_relife10" value="<?php echo $thuepoint_relife10; ?>" size="5"/></td>
					  </tr>
					  
					</table>
				<center><input type="submit" name="Submit" value="Sửa" <?php if($accept=='0') { ?> disabled="disabled" <?php } ?> /></center>
				</form>
			</div>
		</div>
		<div id="right-column">
			<strong class="h">Thông tin</strong>
			<div class="box">Cấu hình :<br>
			- Tên WebSite<br>
			- Địa chỉ kết nối đến Server</div>
	  </div>
	  
