<?php
$file_edit = 'config/config_domain.php';
if(!is_file($file_edit)) { 
	$fp_host = fopen($file_edit, "w");
	fclose($fp_host);
}
if(is_writable($file_edit))	{ $can_write = "<font color=green>Có thể ghi</font>"; $accept = 1;}
else { $can_write = "<font color=red>Không thể ghi - Hãy sử dụng chương trình FTP FileZilla chuyển <b>File permission</b> sang 666</font>"; $accept = 0; }

$action = $_POST[action];
if($action == 'edit') {
	$content = "<?php\n";
	$domain_pri = $_POST['domain_pri'];			$content .= "\$domain_pri	= '$domain_pri';\n";
	$home_url = $_POST['home_url'];		$content .= "\$home_url	= '$home_url';\n";
	$content .= "?>";
	require_once('admin/function.php');
	replacecontent($file_edit,$content);
	$notice = "<center><font color='red'>Sửa thành công</font></center>";
}

include($file_edit);
?>
		<div id="center-column">
			<div class="top-bar">
				<h1>Tên miền chính WebSite</h1>
			</div><br>
			Tệp tin <?php echo "<b>".$file_edit."</b> : ".$can_write; ?>
		  <div class="select-bar"></div>
			<div class="table">
<?php if($notice) echo $notice; ?>
				<form id="editconfig" name="editconfig" method="post" action="">
				<input type="hidden" name="action" value="edit"/>
				<table>
					<tr>
						<td width="100">Tên miền chính WebSite: </td>
						<td><input type="text" name="domain_pri" value="<?php echo $domain_pri; ?>" size="50"/></td>
					</tr>
					<tr>
						<td width="100" valign="top">Địa chỉ WebSite: </td>
						<td><input type="text" name="home_url" value="<?php echo $home_url; ?>" size="50"/><br>
						<b><i>Tên miền chính của WebSite</i></b> : Sử dụng để tránh bị mất phiên bản Pro khi WebSite có nhiều tên miền trỏ tới. Tất cả các tên miền khác được sử dụng sẽ được chuyển sang địa chỉ WebSite.<br>
						<b><i>Địa chỉ WebSite</i></b> : WebSite sẽ tự chuyển về địa chỉ này nếu tên miền không trùng với tên miền chính.<br>
						<b>Ví dụ:</b><br>
						- WebSite sử dụng 2 địa chỉ : http://muonline.vn/taikhoan - http://duphong.vn/taikhoan<br>
						Cả 2 địa chỉ này cùng trỏ tới 1 Web. Địa chỉ chính : http://muonline.vn/taikhoan.<br><br>
						<b>Khi đó</b>: Tên miền chính WebSite : muonline.vn<br>
						Địa chỉ WebSite : http://muonline.vn/taikhoan<br>
						Người sử dụng khi vào bằng địa chỉ http://duphong.vn/taikhoan sẽ được <br>chuyển sang http://muonline.vn/taikhoan
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td align="center"><input type="submit" name="Submit" value="Sửa" <?php if($accept=='0') { ?> disabled="disabled" <?php } ?> /></td>
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