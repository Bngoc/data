<?php
require_once('config/config_reset.php');

$file_edit = 'config/config_resetvip.php';
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
	
	$level_cap_1_vip = $_POST['level_cap_1_vip'];		$content .= "\$level_cap_1_vip	= $level_cap_1_vip;\n";
	$vpoint_cap_1_vip = $_POST['vpoint_cap_1_vip'];		$content .= "\$vpoint_cap_1_vip	= $vpoint_cap_1_vip;\n";
	$point_cap_1_vip = $_POST['point_cap_1_vip'];		$content .= "\$point_cap_1_vip	= $point_cap_1_vip;\n";
	$ml_cap_1_vip = $_POST['ml_cap_1_vip'];		$content .= "\$ml_cap_1_vip	= $ml_cap_1_vip;\n";
	
	$level_cap_2_vip = $_POST['level_cap_2_vip'];		$content .= "\$level_cap_2_vip	= $level_cap_2_vip;\n";
	$vpoint_cap_2_vip = $_POST['vpoint_cap_2_vip'];		$content .= "\$vpoint_cap_2_vip	= $vpoint_cap_2_vip;\n";
	$point_cap_2_vip = $_POST['point_cap_2_vip'];		$content .= "\$point_cap_2_vip	= $point_cap_2_vip;\n";
	$ml_cap_2_vip = $_POST['ml_cap_2_vip'];		$content .= "\$ml_cap_2_vip	= $ml_cap_2_vip;\n";
	
	$level_cap_3_vip = $_POST['level_cap_3_vip'];		$content .= "\$level_cap_3_vip	= $level_cap_3_vip;\n";
	$vpoint_cap_3_vip = $_POST['vpoint_cap_3_vip'];		$content .= "\$vpoint_cap_3_vip	= $vpoint_cap_3_vip;\n";
	$point_cap_3_vip = $_POST['point_cap_3_vip'];		$content .= "\$point_cap_3_vip	= $point_cap_3_vip;\n";
	$ml_cap_3_vip = $_POST['ml_cap_3_vip'];		$content .= "\$ml_cap_3_vip	= $ml_cap_3_vip;\n";
	
	$level_cap_4_vip = $_POST['level_cap_4_vip'];		$content .= "\$level_cap_4_vip	= $level_cap_4_vip;\n";
	$vpoint_cap_4_vip = $_POST['vpoint_cap_4_vip'];		$content .= "\$vpoint_cap_4_vip	= $vpoint_cap_4_vip;\n";
	$point_cap_4_vip = $_POST['point_cap_4_vip'];		$content .= "\$point_cap_4_vip	= $point_cap_4_vip;\n";
	$ml_cap_4_vip = $_POST['ml_cap_4_vip'];		$content .= "\$ml_cap_4_vip	= $ml_cap_4_vip;\n";
	
	$level_cap_5_vip = $_POST['level_cap_5_vip'];		$content .= "\$level_cap_5_vip	= $level_cap_5_vip;\n";
	$vpoint_cap_5_vip = $_POST['vpoint_cap_5_vip'];		$content .= "\$vpoint_cap_5_vip	= $vpoint_cap_5_vip;\n";
	$point_cap_5_vip = $_POST['point_cap_5_vip'];		$content .= "\$point_cap_5_vip	= $point_cap_5_vip;\n";
	$ml_cap_5_vip = $_POST['ml_cap_5_vip'];		$content .= "\$ml_cap_5_vip	= $ml_cap_5_vip;\n";
	
	$level_cap_6_vip = $_POST['level_cap_6_vip'];		$content .= "\$level_cap_6_vip	= $level_cap_6_vip;\n";
	$vpoint_cap_6_vip = $_POST['vpoint_cap_6_vip'];		$content .= "\$vpoint_cap_6_vip	= $vpoint_cap_6_vip;\n";
	$point_cap_6_vip = $_POST['point_cap_6_vip'];		$content .= "\$point_cap_6_vip	= $point_cap_6_vip;\n";
	$ml_cap_6_vip = $_POST['ml_cap_6_vip'];		$content .= "\$ml_cap_6_vip	= $ml_cap_6_vip;\n";
	
	$level_cap_7_vip = $_POST['level_cap_7_vip'];		$content .= "\$level_cap_7_vip	= $level_cap_7_vip;\n";
	$vpoint_cap_7_vip = $_POST['vpoint_cap_7_vip'];		$content .= "\$vpoint_cap_7_vip	= $vpoint_cap_7_vip;\n";
	$point_cap_7_vip = $_POST['point_cap_7_vip'];		$content .= "\$point_cap_7_vip	= $point_cap_7_vip;\n";
	$ml_cap_7_vip = $_POST['ml_cap_7_vip'];		$content .= "\$ml_cap_7_vip	= $ml_cap_7_vip;\n";
	
	$level_cap_8_vip = $_POST['level_cap_8_vip'];		$content .= "\$level_cap_8_vip	= $level_cap_8_vip;\n";
	$vpoint_cap_8_vip = $_POST['vpoint_cap_8_vip'];		$content .= "\$vpoint_cap_8_vip	= $vpoint_cap_8_vip;\n";
	$point_cap_8_vip = $_POST['point_cap_8_vip'];		$content .= "\$point_cap_8_vip	= $point_cap_8_vip;\n";
	$ml_cap_8_vip = $_POST['ml_cap_8_vip'];		$content .= "\$ml_cap_8_vip	= $ml_cap_8_vip;\n";
	
	$level_cap_9_vip = $_POST['level_cap_9_vip'];		$content .= "\$level_cap_9_vip	= $level_cap_9_vip;\n";
	$vpoint_cap_9_vip = $_POST['vpoint_cap_9_vip'];		$content .= "\$vpoint_cap_9_vip	= $vpoint_cap_9_vip;\n";
	$point_cap_9_vip = $_POST['point_cap_9_vip'];		$content .= "\$point_cap_9_vip	= $point_cap_9_vip;\n";
	$ml_cap_9_vip = $_POST['ml_cap_9_vip'];		$content .= "\$ml_cap_9_vip	= $ml_cap_9_vip;\n";
	
	$level_cap_10_vip = $_POST['level_cap_10_vip'];		$content .= "\$level_cap_10_vip	= $level_cap_10_vip;\n";
	$vpoint_cap_10_vip = $_POST['vpoint_cap_10_vip'];		$content .= "\$vpoint_cap_10_vip	= $vpoint_cap_10_vip;\n";
	$point_cap_10_vip = $_POST['point_cap_10_vip'];		$content .= "\$point_cap_10_vip	= $point_cap_10_vip;\n";
	$ml_cap_10_vip = $_POST['ml_cap_10_vip'];		$content .= "\$ml_cap_10_vip	= $ml_cap_10_vip;\n";
	
	$level_cap_11_vip = $_POST['level_cap_11_vip'];		$content .= "\$level_cap_11_vip	= $level_cap_11_vip;\n";
	$vpoint_cap_11_vip = $_POST['vpoint_cap_11_vip'];		$content .= "\$vpoint_cap_11_vip	= $vpoint_cap_11_vip;\n";
	$point_cap_11_vip = $_POST['point_cap_11_vip'];		$content .= "\$point_cap_11_vip	= $point_cap_11_vip;\n";
	$ml_cap_11_vip = $_POST['ml_cap_11_vip'];		$content .= "\$ml_cap_11_vip	= $ml_cap_11_vip;\n";
	
	$level_cap_12_vip = $_POST['level_cap_12_vip'];		$content .= "\$level_cap_12_vip	= $level_cap_12_vip;\n";
	$vpoint_cap_12_vip = $_POST['vpoint_cap_12_vip'];		$content .= "\$vpoint_cap_12_vip	= $vpoint_cap_12_vip;\n";
	$point_cap_12_vip = $_POST['point_cap_12_vip'];		$content .= "\$point_cap_12_vip	= $point_cap_12_vip;\n";
	$ml_cap_12_vip = $_POST['ml_cap_12_vip'];		$content .= "\$ml_cap_12_vip	= $ml_cap_12_vip;\n";
	
	$level_cap_13_vip = $_POST['level_cap_13_vip'];		$content .= "\$level_cap_13_vip	= $level_cap_13_vip;\n";
	$vpoint_cap_13_vip = $_POST['vpoint_cap_13_vip'];		$content .= "\$vpoint_cap_13_vip	= $vpoint_cap_13_vip;\n";
	$point_cap_13_vip = $_POST['point_cap_13_vip'];		$content .= "\$point_cap_13_vip	= $point_cap_13_vip;\n";
	$ml_cap_13_vip = $_POST['ml_cap_13_vip'];		$content .= "\$ml_cap_13_vip	= $ml_cap_13_vip;\n";
	
	$level_cap_14_vip = $_POST['level_cap_14_vip'];		$content .= "\$level_cap_14_vip	= $level_cap_14_vip;\n";
	$vpoint_cap_14_vip = $_POST['vpoint_cap_14_vip'];		$content .= "\$vpoint_cap_14_vip	= $vpoint_cap_14_vip;\n";
	$point_cap_14_vip = $_POST['point_cap_14_vip'];		$content .= "\$point_cap_14_vip	= $point_cap_14_vip;\n";
	$ml_cap_14_vip = $_POST['ml_cap_14_vip'];		$content .= "\$ml_cap_14_vip	= $ml_cap_14_vip;\n";
	
	$level_cap_15_vip = $_POST['level_cap_15_vip'];		$content .= "\$level_cap_15_vip	= $level_cap_15_vip;\n";
	$vpoint_cap_15_vip = $_POST['vpoint_cap_15_vip'];		$content .= "\$vpoint_cap_15_vip	= $vpoint_cap_15_vip;\n";
	$point_cap_15_vip = $_POST['point_cap_15_vip'];		$content .= "\$point_cap_15_vip	= $point_cap_15_vip;\n";
	$ml_cap_15_vip = $_POST['ml_cap_15_vip'];		$content .= "\$ml_cap_15_vip	= $ml_cap_15_vip;\n";
	
	$level_cap_16_vip = $_POST['level_cap_16_vip'];		$content .= "\$level_cap_16_vip	= $level_cap_16_vip;\n";
	$vpoint_cap_16_vip = $_POST['vpoint_cap_16_vip'];		$content .= "\$vpoint_cap_16_vip	= $vpoint_cap_16_vip;\n";
	$point_cap_16_vip = $_POST['point_cap_16_vip'];		$content .= "\$point_cap_16_vip	= $point_cap_16_vip;\n";
	$ml_cap_16_vip = $_POST['ml_cap_16_vip'];		$content .= "\$ml_cap_16_vip	= $ml_cap_16_vip;\n";
	
	$level_cap_17_vip = $_POST['level_cap_17_vip'];		$content .= "\$level_cap_17_vip	= $level_cap_17_vip;\n";
	$vpoint_cap_17_vip = $_POST['vpoint_cap_17_vip'];		$content .= "\$vpoint_cap_17_vip	= $vpoint_cap_17_vip;\n";
	$point_cap_17_vip = $_POST['point_cap_17_vip'];		$content .= "\$point_cap_17_vip	= $point_cap_17_vip;\n";
	$ml_cap_17_vip = $_POST['ml_cap_17_vip'];		$content .= "\$ml_cap_17_vip	= $ml_cap_17_vip;\n";
	
	$level_cap_18_vip = $_POST['level_cap_18_vip'];		$content .= "\$level_cap_18_vip	= $level_cap_18_vip;\n";
	$vpoint_cap_18_vip = $_POST['vpoint_cap_18_vip'];		$content .= "\$vpoint_cap_18_vip	= $vpoint_cap_18_vip;\n";
	$point_cap_18_vip = $_POST['point_cap_18_vip'];		$content .= "\$point_cap_18_vip	= $point_cap_18_vip;\n";
	$ml_cap_18_vip = $_POST['ml_cap_18_vip'];		$content .= "\$ml_cap_18_vip	= $ml_cap_18_vip;\n";
	
	$level_cap_19_vip = $_POST['level_cap_19_vip'];		$content .= "\$level_cap_19_vip	= $level_cap_19_vip;\n";
	$vpoint_cap_19_vip = $_POST['vpoint_cap_19_vip'];		$content .= "\$vpoint_cap_19_vip	= $vpoint_cap_19_vip;\n";
	$point_cap_19_vip = $_POST['point_cap_19_vip'];		$content .= "\$point_cap_19_vip	= $point_cap_19_vip;\n";
	$ml_cap_19_vip = $_POST['ml_cap_19_vip'];		$content .= "\$ml_cap_19_vip	= $ml_cap_19_vip;\n";
	
	$level_cap_20_vip = $_POST['level_cap_20_vip'];		$content .= "\$level_cap_20_vip	= $level_cap_20_vip;\n";
	$vpoint_cap_20_vip = $_POST['vpoint_cap_20_vip'];		$content .= "\$vpoint_cap_20_vip	= $vpoint_cap_20_vip;\n";
	$point_cap_20_vip = $_POST['point_cap_20_vip'];		$content .= "\$point_cap_20_vip	= $point_cap_20_vip;\n";
	$ml_cap_20_vip = $_POST['ml_cap_20_vip'];		$content .= "\$ml_cap_20_vip	= $ml_cap_20_vip;\n";
	
	
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
				<h1>Cấu Hình ResetVIP</h1>
			</div><br>
			Tập tin <?php echo "<b>".$file_edit."</b> : ".$can_write; ?><?php if (!$usehost) {?><br>
			Tập tin <?php echo "<b>".$file_edit_sv."</b> : ".$can_write_sv; ?><?php }?>
		  <div class="select-bar"></div>
			<div class="table">
<?php if($notice) echo $notice; ?>
				<form id="editconfig" name="editconfig" method="post" action="">
				<input type="hidden" name="action" value="edit"/>
					- Cấp Reset lấy từ Reset thường.<br>
					<br>
					<table width="100%" border="0" bgcolor="#9999FF">
					  <tr bgcolor="#FFFFFF">
					    <td align="center"><b>Reset</b></td>
					    <td align="center"><b>Level</b></td>
					    <td align="center"><b>Vpoint</b></td>
					    <td align="center"><b>Point</b></td>
					    <td align="center"><b>Mệnh Lệnh</b></td>
					  </tr>
					  
					  <tr bgcolor="#FFFFFF">
					    <td align="center"><?php $reset_cap_0++; echo "$reset_cap_0 - $reset_cap_1"; ?></td>
					    <td align="center"><input type="text" name="level_cap_1_vip" value="<?php echo $level_cap_1_vip; ?>" size="2"/></td>
					    <td align="center"><input type="text" name="vpoint_cap_1_vip" value="<?php echo $vpoint_cap_1_vip; ?>" size="3"/></td>
					    <td align="center"><input type="text" name="point_cap_1_vip" value="<?php echo $point_cap_1_vip; ?>" size="2"/></td>
					    <td align="center"><input type="text" name="ml_cap_1_vip" value="<?php echo $ml_cap_1_vip; ?>" size="2"/></td>
					  </tr>

					  <tr bgcolor="#FFFFFF">
					    <td align="center"><?php $reset_cap_1++; echo "$reset_cap_1 - $reset_cap_2"; ?></td>
					    <td align="center"><input type="text" name="level_cap_2_vip" value="<?php echo $level_cap_2_vip; ?>" size="2"/></td>
					    <td align="center"><input type="text" name="vpoint_cap_2_vip" value="<?php echo $vpoint_cap_2_vip; ?>" size="3"/></td>
					    <td align="center"><input type="text" name="point_cap_2_vip" value="<?php echo $point_cap_2_vip; ?>" size="2"/></td>
					    <td align="center"><input type="text" name="ml_cap_2_vip" value="<?php echo $ml_cap_2_vip; ?>" size="2"/></td>
					  </tr>

					  <tr bgcolor="#FFFFFF">
					    <td align="center"><?php $reset_cap_2++; echo "$reset_cap_2 - $reset_cap_3"; ?></td>
					    <td align="center"><input type="text" name="level_cap_3_vip" value="<?php echo $level_cap_3_vip; ?>" size="2"/></td>
					    <td align="center"><input type="text" name="vpoint_cap_3_vip" value="<?php echo $vpoint_cap_3_vip; ?>" size="3"/></td>
					    <td align="center"><input type="text" name="point_cap_3_vip" value="<?php echo $point_cap_3_vip; ?>" size="2"/></td>
					    <td align="center"><input type="text" name="ml_cap_3_vip" value="<?php echo $ml_cap_3_vip; ?>" size="2"/></td>
					  </tr>

					  <tr bgcolor="#FFFFFF">
					    <td align="center"><?php $reset_cap_3++; echo "$reset_cap_3 - $reset_cap_4"; ?></td>
					    <td align="center"><input type="text" name="level_cap_4_vip" value="<?php echo $level_cap_4_vip; ?>" size="2"/></td>
					    <td align="center"><input type="text" name="vpoint_cap_4_vip" value="<?php echo $vpoint_cap_4_vip; ?>" size="3"/></td>
					    <td align="center"><input type="text" name="point_cap_4_vip" value="<?php echo $point_cap_4_vip; ?>" size="2"/></td>
					    <td align="center"><input type="text" name="ml_cap_4_vip" value="<?php echo $ml_cap_4_vip; ?>" size="2"/></td>
					  </tr>

					  <tr bgcolor="#FFFFFF">
					    <td align="center"><?php $reset_cap_4++; echo "$reset_cap_4 - $reset_cap_5"; ?></td>
					    <td align="center"><input type="text" name="level_cap_5_vip" value="<?php echo $level_cap_5_vip; ?>" size="2"/></td>
					    <td align="center"><input type="text" name="vpoint_cap_5_vip" value="<?php echo $vpoint_cap_5_vip; ?>" size="3"/></td>
					    <td align="center"><input type="text" name="point_cap_5_vip" value="<?php echo $point_cap_5_vip; ?>" size="2"/></td>
					    <td align="center"><input type="text" name="ml_cap_5_vip" value="<?php echo $ml_cap_5_vip; ?>" size="2"/></td>
					  </tr>

					  <tr bgcolor="#FFFFFF">
					    <td align="center"><?php $reset_cap_5++; echo "$reset_cap_5 - $reset_cap_6"; ?></td>
					    <td align="center"><input type="text" name="level_cap_6_vip" value="<?php echo $level_cap_6_vip; ?>" size="2"/></td>
					    <td align="center"><input type="text" name="vpoint_cap_6_vip" value="<?php echo $vpoint_cap_6_vip; ?>" size="3"/></td>
					    <td align="center"><input type="text" name="point_cap_6_vip" value="<?php echo $point_cap_6_vip; ?>" size="2"/></td>
					    <td align="center"><input type="text" name="ml_cap_6_vip" value="<?php echo $ml_cap_6_vip; ?>" size="2"/></td>
					  </tr>

					  <tr bgcolor="#FFFFFF">
					    <td align="center"><?php $reset_cap_6++; echo "$reset_cap_6 - $reset_cap_7"; ?></td>
					    <td align="center"><input type="text" name="level_cap_7_vip" value="<?php echo $level_cap_7_vip; ?>" size="2"/></td>
					    <td align="center"><input type="text" name="vpoint_cap_7_vip" value="<?php echo $vpoint_cap_7_vip; ?>" size="3"/></td>
					    <td align="center"><input type="text" name="point_cap_7_vip" value="<?php echo $point_cap_7_vip; ?>" size="2"/></td>
					    <td align="center"><input type="text" name="ml_cap_7_vip" value="<?php echo $ml_cap_7_vip; ?>" size="2"/></td>
					  </tr>

					  <tr bgcolor="#FFFFFF">
					    <td align="center"><?php $reset_cap_7++; echo "$reset_cap_7 - $reset_cap_8"; ?></td>
					    <td align="center"><input type="text" name="level_cap_8_vip" value="<?php echo $level_cap_8_vip; ?>" size="2"/></td>
					    <td align="center"><input type="text" name="vpoint_cap_8_vip" value="<?php echo $vpoint_cap_8_vip; ?>" size="3"/></td>
					    <td align="center"><input type="text" name="point_cap_8_vip" value="<?php echo $point_cap_8_vip; ?>" size="2"/></td>
					    <td align="center"><input type="text" name="ml_cap_8_vip" value="<?php echo $ml_cap_8_vip; ?>" size="2"/></td>
					  </tr>

					  <tr bgcolor="#FFFFFF">
					    <td align="center"><?php $reset_cap_8++; echo "$reset_cap_8 - $reset_cap_9"; ?></td>
					    <td align="center"><input type="text" name="level_cap_9_vip" value="<?php echo $level_cap_9_vip; ?>" size="2"/></td>
					    <td align="center"><input type="text" name="vpoint_cap_9_vip" value="<?php echo $vpoint_cap_9_vip; ?>" size="3"/></td>
					    <td align="center"><input type="text" name="point_cap_9_vip" value="<?php echo $point_cap_9_vip; ?>" size="2"/></td>
					    <td align="center"><input type="text" name="ml_cap_9_vip" value="<?php echo $ml_cap_9_vip; ?>" size="2"/></td>
					  </tr>

					  <tr bgcolor="#FFFFFF">
					    <td align="center"><?php $reset_cap_9++; echo "$reset_cap_9 - $reset_cap_10"; ?></td>
					    <td align="center"><input type="text" name="level_cap_10_vip" value="<?php echo $level_cap_10_vip; ?>" size="2"/></td>
					    <td align="center"><input type="text" name="vpoint_cap_10_vip" value="<?php echo $vpoint_cap_10_vip; ?>" size="3"/></td>
					    <td align="center"><input type="text" name="point_cap_10_vip" value="<?php echo $point_cap_10_vip; ?>" size="2"/></td>
					    <td align="center"><input type="text" name="ml_cap_10_vip" value="<?php echo $ml_cap_10_vip; ?>" size="2"/></td>
					  </tr>

					  <tr bgcolor="#FFFFFF">
					    <td align="center"><?php $reset_cap_10++; echo "$reset_cap_10 - $reset_cap_11"; ?></td>
					    <td align="center"><input type="text" name="level_cap_11_vip" value="<?php echo $level_cap_11_vip; ?>" size="2"/></td>
					    <td align="center"><input type="text" name="vpoint_cap_11_vip" value="<?php echo $vpoint_cap_11_vip; ?>" size="3"/></td>
					    <td align="center"><input type="text" name="point_cap_11_vip" value="<?php echo $point_cap_11_vip; ?>" size="2"/></td>
					    <td align="center"><input type="text" name="ml_cap_11_vip" value="<?php echo $ml_cap_11_vip; ?>" size="2"/></td>
					  </tr>

					  <tr bgcolor="#FFFFFF">
					    <td align="center"><?php $reset_cap_11++; echo "$reset_cap_11 - $reset_cap_12"; ?></td>
					    <td align="center"><input type="text" name="level_cap_12_vip" value="<?php echo $level_cap_12_vip; ?>" size="2"/></td>
					    <td align="center"><input type="text" name="vpoint_cap_12_vip" value="<?php echo $vpoint_cap_12_vip; ?>" size="3"/></td>
					    <td align="center"><input type="text" name="point_cap_12_vip" value="<?php echo $point_cap_12_vip; ?>" size="2"/></td>
					    <td align="center"><input type="text" name="ml_cap_12_vip" value="<?php echo $ml_cap_12_vip; ?>" size="2"/></td>
					  </tr>

					  <tr bgcolor="#FFFFFF">
					    <td align="center"><?php $reset_cap_12++; echo "$reset_cap_12 - $reset_cap_13"; ?></td>
					    <td align="center"><input type="text" name="level_cap_13_vip" value="<?php echo $level_cap_13_vip; ?>" size="2"/></td>
					    <td align="center"><input type="text" name="vpoint_cap_13_vip" value="<?php echo $vpoint_cap_13_vip; ?>" size="3"/></td>
					    <td align="center"><input type="text" name="point_cap_13_vip" value="<?php echo $point_cap_13_vip; ?>" size="2"/></td>
					    <td align="center"><input type="text" name="ml_cap_13_vip" value="<?php echo $ml_cap_13_vip; ?>" size="2"/></td>
					  </tr>

					  <tr bgcolor="#FFFFFF">
					    <td align="center"><?php $reset_cap_13++; echo "$reset_cap_13 - $reset_cap_14"; ?></td>
					    <td align="center"><input type="text" name="level_cap_14_vip" value="<?php echo $level_cap_14_vip; ?>" size="2"/></td>
					    <td align="center"><input type="text" name="vpoint_cap_14_vip" value="<?php echo $vpoint_cap_14_vip; ?>" size="3"/></td>
					    <td align="center"><input type="text" name="point_cap_14_vip" value="<?php echo $point_cap_14_vip; ?>" size="2"/></td>
					    <td align="center"><input type="text" name="ml_cap_14_vip" value="<?php echo $ml_cap_14_vip; ?>" size="2"/></td>
					  </tr>

					  <tr bgcolor="#FFFFFF">
					    <td align="center"><?php $reset_cap_14++; echo "$reset_cap_14 - $reset_cap_15"; ?></td>
					    <td align="center"><input type="text" name="level_cap_15_vip" value="<?php echo $level_cap_15_vip; ?>" size="2"/></td>
					    <td align="center"><input type="text" name="vpoint_cap_15_vip" value="<?php echo $vpoint_cap_15_vip; ?>" size="3"/></td>
					    <td align="center"><input type="text" name="point_cap_15_vip" value="<?php echo $point_cap_15_vip; ?>" size="2"/></td>
					    <td align="center"><input type="text" name="ml_cap_15_vip" value="<?php echo $ml_cap_15_vip; ?>" size="2"/></td>
					  </tr>

					  <tr bgcolor="#FFFFFF">
					    <td align="center"><?php $reset_cap_15++; echo "$reset_cap_15 - $reset_cap_16"; ?></td>
					    <td align="center"><input type="text" name="level_cap_16_vip" value="<?php echo $level_cap_16_vip; ?>" size="2"/></td>
					    <td align="center"><input type="text" name="vpoint_cap_16_vip" value="<?php echo $vpoint_cap_16_vip; ?>" size="3"/></td>
					    <td align="center"><input type="text" name="point_cap_16_vip" value="<?php echo $point_cap_16_vip; ?>" size="2"/></td>
					    <td align="center"><input type="text" name="ml_cap_16_vip" value="<?php echo $ml_cap_16_vip; ?>" size="2"/></td>
					  </tr>

					  <tr bgcolor="#FFFFFF">
					    <td align="center"><?php $reset_cap_16++; echo "$reset_cap_16 - $reset_cap_17"; ?></td>
					    <td align="center"><input type="text" name="level_cap_17_vip" value="<?php echo $level_cap_17_vip; ?>" size="2"/></td>
					    <td align="center"><input type="text" name="vpoint_cap_17_vip" value="<?php echo $vpoint_cap_17_vip; ?>" size="3"/></td>
					    <td align="center"><input type="text" name="point_cap_17_vip" value="<?php echo $point_cap_17_vip; ?>" size="2"/></td>
					    <td align="center"><input type="text" name="ml_cap_17_vip" value="<?php echo $ml_cap_17_vip; ?>" size="2"/></td>
					  </tr>

					  <tr bgcolor="#FFFFFF">
					    <td align="center"><?php $reset_cap_17++; echo "$reset_cap_17 - $reset_cap_18"; ?></td>
					    <td align="center"><input type="text" name="level_cap_18_vip" value="<?php echo $level_cap_18_vip; ?>" size="2"/></td>
					    <td align="center"><input type="text" name="vpoint_cap_18_vip" value="<?php echo $vpoint_cap_18_vip; ?>" size="3"/></td>
					    <td align="center"><input type="text" name="point_cap_18_vip" value="<?php echo $point_cap_18_vip; ?>" size="2"/></td>
					    <td align="center"><input type="text" name="ml_cap_18_vip" value="<?php echo $ml_cap_18_vip; ?>" size="2"/></td>
					  </tr>

					  <tr bgcolor="#FFFFFF">
					    <td align="center"><?php $reset_cap_18++; echo "$reset_cap_18 - $reset_cap_19"; ?></td>
					    <td align="center"><input type="text" name="level_cap_19_vip" value="<?php echo $level_cap_19_vip; ?>" size="2"/></td>
					    <td align="center"><input type="text" name="vpoint_cap_19_vip" value="<?php echo $vpoint_cap_19_vip; ?>" size="3"/></td>
					    <td align="center"><input type="text" name="point_cap_19_vip" value="<?php echo $point_cap_19_vip; ?>" size="2"/></td>
					    <td align="center"><input type="text" name="ml_cap_19_vip" value="<?php echo $ml_cap_19_vip; ?>" size="2"/></td>
					  </tr>

					  <tr bgcolor="#FFFFFF">
					    <td align="center"><?php $reset_cap_19++; echo "$reset_cap_19 - $reset_cap_20"; ?></td>
					    <td align="center"><input type="text" name="level_cap_20_vip" value="<?php echo $level_cap_20_vip; ?>" size="2"/></td>
					    <td align="center"><input type="text" name="vpoint_cap_20_vip" value="<?php echo $vpoint_cap_20_vip; ?>" size="3"/></td>
					    <td align="center"><input type="text" name="point_cap_20_vip" value="<?php echo $point_cap_20_vip; ?>" size="2"/></td>
					    <td align="center"><input type="text" name="ml_cap_20_vip" value="<?php echo $ml_cap_20_vip; ?>" size="2"/></td>
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
	  
