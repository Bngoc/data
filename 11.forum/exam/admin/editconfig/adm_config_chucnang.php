<?php
$file_edit = 'config/config_chucnang.php';

if(!is_file($file_edit)) 
{
	$fp_host = fopen($file_edit, "w");
	fclose($fp_host);
}
if(is_writable($file_edit))	{ $can_write = "<font color=green>Có thể ghi</font>"; $accept = 1;}
	else { $can_write = "<font color=red>Không thể ghi - Hãy sử dụng chương trình FTP FileZilla chuyển <b>File permission</b> sang 666</font>"; $accept = 0; }

$action = $_POST[action];

if($action == 'edit')
{
	$content = "<?php\n";
	
	$Use_WebShop = $_POST['Use_WebShop'];	$content .= "\$Use_WebShop	= $Use_WebShop;\n";
	$Use_NapVpoint = $_POST['Use_NapVpoint'];		$content .= "\$Use_NapVpoint	= $Use_NapVpoint;\n";
	$Use_OnlineMarket = $_POST['Use_OnlineMarket'];		$content .= "\$Use_OnlineMarket	= $Use_OnlineMarket;\n";
	
	$Use_ChuyenVpoint = $_POST['Use_ChuyenVpoint'];		$content .= "\$Use_ChuyenVpoint	= $Use_ChuyenVpoint;\n";
	$Use_PCPoint2Vpoint = $_POST['Use_PCPoint2Vpoint'];		$content .= "\$Use_PCPoint2Vpoint	= $Use_PCPoint2Vpoint;\n";
	$Use_TienTe = $_POST['Use_TienTe'];		$content .= "\$Use_TienTe	= $Use_TienTe;\n";

	$Use_DoiGioiTinh = $_POST['Use_DoiGioiTinh'];	$content .= "\$Use_DoiGioiTinh	= $Use_DoiGioiTinh;\n";
	$Use_ThuePoint = $_POST['Use_ThuePoint'];	$content .= "\$Use_ThuePoint	= $Use_ThuePoint;\n";
	$Use_ResetVIP = $_POST['Use_ResetVIP'];			$content .= "\$Use_ResetVIP	= $Use_ResetVIP;\n";
	$Use_UyThacOffline = $_POST['Use_UyThacOffline'];	$content .= "\$Use_UyThacOffline	= $Use_UyThacOffline;\n";
	$Use_UyThacResetVIP = $_POST['Use_UyThacResetVIP'];	$content .= "\$Use_UyThacResetVIP	= $Use_UyThacResetVIP;\n";
	$Use_NhiemVu = $_POST['Use_NhiemVu'];	$content .= "\$Use_NhiemVu	= $Use_NhiemVu;\n";
	$Use_XoSoKienThiet = $_POST['Use_XoSoKienThiet'];	$content .= "\$Use_XoSoKienThiet	= $Use_XoSoKienThiet;\n";
	
	$content .= "?>";
	
	require_once('admin/function.php');
	replacecontent($file_edit,$content);
	
	$notice = "<center><font color='red'>Sửa thành công</font></center>";
}

include($file_edit);
?>
		<div id="center-column">
			<div class="top-bar">
				<h1>Cấu Hình Chức năng</h1>
			</div><br>
			Tập tin <?php echo "<b>".$file_edit."</b> : ".$can_write; ?><br>
		  <div class="select-bar"></div>
			<div class="table">
<?php if($notice) echo $notice; ?>
				<form id="editconfig" name="editconfig" method="post" action="">
				<input type="hidden" name="action" value="edit"/>
				<table>
					<tr>
						<td width="200">Sử dụng WebShop: </td>
						<td>Không <input name="Use_WebShop" type="radio" value="0" <?php if($Use_WebShop==0) echo "checked='checked'"; ?>/>
						Có <input name="Use_WebShop" type="radio" value="1" <?php if($Use_WebShop==1) echo "checked='checked'"; ?>/></td>
					</tr>
					<tr>
						<td width="200">Sử dụng Nạp thẻ: </td>
						<td>Không <input name="Use_NapVpoint" type="radio" value="0" <?php if($Use_NapVpoint==0) echo "checked='checked'"; ?>/>
						Có <input name="Use_NapVpoint" type="radio" value="1" <?php if($Use_NapVpoint==1) echo "checked='checked'"; ?>/></td>
					</tr>
					<tr>
						<td width="200">Sử dụng Chợ trực tuyến: </td>
						<td>Không <input name="Use_OnlineMarket" type="radio" value="0" <?php if($Use_OnlineMarket==0) echo "checked='checked'"; ?>/>
						Có <input name="Use_OnlineMarket" type="radio" value="1" <?php if($Use_OnlineMarket==1) echo "checked='checked'"; ?>/></td>
					</tr>
					<tr>
						<td width="200">Sử dụng Chuyển Vpoint: </td>
						<td>Không <input name="Use_ChuyenVpoint" type="radio" value="0" <?php if($Use_ChuyenVpoint==0) echo "checked='checked'"; ?>/>
						Có <input name="Use_ChuyenVpoint" type="radio" value="1" <?php if($Use_ChuyenVpoint==1) echo "checked='checked'"; ?>/></td>
					</tr>
					<tr>
						<td width="200">Sử dụng Đổi PCPoint ra Vpoint: </td>
						<td>Không <input name="Use_PCPoint2Vpoint" type="radio" value="0" <?php if($Use_PCPoint2Vpoint==0) echo "checked='checked'"; ?>/>
						Có <input name="Use_PCPoint2Vpoint" type="radio" value="1" <?php if($Use_PCPoint2Vpoint==1) echo "checked='checked'"; ?>/></td>
					</tr>
					<tr>
						<td width="200">Sử dụng Tiền tệ: </td>
						<td>Không <input name="Use_TienTe" type="radio" value="0" <?php if($Use_TienTe==0) echo "checked='checked'"; ?>/>
						Có <input name="Use_TienTe" type="radio" value="1" <?php if($Use_TienTe==1) echo "checked='checked'"; ?>/></td>
					</tr>
					<tr>
						<td width="200">Sử dụng Đổi giới tính: </td>
						<td>Không <input name="Use_DoiGioiTinh" type="radio" value="0" <?php if($Use_DoiGioiTinh==0) echo "checked='checked'"; ?>/>
						Có <input name="Use_DoiGioiTinh" type="radio" value="1" <?php if($Use_DoiGioiTinh==1) echo "checked='checked'"; ?>/></td>
					</tr>
					<tr>
						<td width="200">Sử dụng Thuê Point: </td>
						<td>Không <input name="Use_ThuePoint" type="radio" value="0" <?php if($Use_ThuePoint==0) echo "checked='checked'"; ?>/>
						Có <input name="Use_ThuePoint" type="radio" value="1" <?php if($Use_ThuePoint==1) echo "checked='checked'"; ?>/></td>
					</tr>
					<tr>
						<td width="200">Sử dụng Reset VIP: </td>
						<td>Không <input name="Use_ResetVIP" type="radio" value="0" <?php if($Use_ResetVIP==0) echo "checked='checked'"; ?>/>
						Có <input name="Use_ResetVIP" type="radio" value="1" <?php if($Use_ResetVIP==1) echo "checked='checked'"; ?>/></td>
					</tr>
					<tr>
						<td width="200">Sử dụng Ủy thác Offline: </td>
						<td>Không <input name="Use_UyThacOffline" type="radio" value="0" <?php if($Use_UyThacOffline==0) echo "checked='checked'"; ?>/>
						Có <input name="Use_UyThacOffline" type="radio" value="1" <?php if($Use_UyThacOffline==1) echo "checked='checked'"; ?>/></td>
					</tr>
					<tr>
						<td width="200">Sử dụng Ủy thác Reset VIP: </td>
						<td>Không <input name="Use_UyThacResetVIP" type="radio" value="0" <?php if($Use_UyThacResetVIP==0) echo "checked='checked'"; ?>/>
						Có <input name="Use_UyThacResetVIP" type="radio" value="1" <?php if($Use_UyThacResetVIP==1) echo "checked='checked'"; ?>/></td>
					</tr>
					<tr>
						<td width="200">Sử dụng Nhiệm Vụ: </td>
						<td>Không <input name="Use_NhiemVu" type="radio" value="0" <?php if($Use_NhiemVu==0) echo "checked='checked'"; ?>/>
						Có <input name="Use_NhiemVu" type="radio" value="1" <?php if($Use_NhiemVu==1) echo "checked='checked'"; ?>/></td>
					</tr>
					<tr>
						<td width="200">Sử dụng Xổ số kiến thiết: </td>
						<td>Không <input name="Use_XoSoKienThiet" type="radio" value="0" <?php if($Use_XoSoKienThiet==0) echo "checked='checked'"; ?>/>
						Có <input name="Use_XoSoKienThiet" type="radio" value="1" <?php if($Use_XoSoKienThiet==1) echo "checked='checked'"; ?>/></td>
					</tr>
					<tr><td colspan="2"><hr></td></tr>
					
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
	  
