<?php
$file_edit = 'config/config_pk.php';
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
	
	$pk_zen_vpoint 	= $_POST['pk_zen_vpoint'];		$content .= "\$pk_zen_vpoint	= $pk_zen_vpoint;\n";
	$pk_zen			= $_POST['pk_zen'];		$content .= "\$pk_zen	= $pk_zen;\n";
	$pk_vpoint		= $_POST['pk_vpoint'];		$content .= "\$pk_vpoint	= $pk_vpoint;\n";
	
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
				<h1>Cấu Hình Rửa tội</h1>
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
				    <th scope="col" align="center">PK</th>
				    <th scope="col" align="center">Phí</th>
				  </tr>
				  <tr bgcolor="#FFFFFF">
				    <td><div align="center">Giết <= <input type="text" name="pk_zen_vpoint" value="<?php echo $pk_zen_vpoint; ?>" size="2"/> mạng</div></td>
				    <td><div align="center"><input type="text" name="pk_zen" value="<?php echo $pk_zen; ?>" size="10"/> Zen/mạng</div></td>
				  </tr>
				  <tr bgcolor="#FFFFFF">
				    <td><div align="center">Giết > <?php echo $pk_zen_vpoint; ?> mạng</div></td>
				    <td><div align="center"><input type="text" name="pk_vpoint" value="<?php echo $pk_vpoint; ?>" size="2"/> V.Point/mạng</div></td>
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
	  
