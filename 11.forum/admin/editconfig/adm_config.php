<?php
$file_edit = 'config.php';
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
	$opensite = $_POST['opensite'];
	$title = $_POST['title'];
	$description = $_POST['description'];
	$keywords = $_POST['keywords'];
	$version = $_POST['version'];
	$reload_type = $_POST['reload_type'];
	$img_url = $_POST['img_url'];
	$yahoo_hotro = $_POST['yahoo_hotro'];
	$forum = $_POST['forum'];
	$server_url = $_POST['server_url'];
	$passtransfer = $_POST['passtransfer'];
	$usehost = $_POST['usehost'];
	
	$content = "<?php\n";
	$content .= "include('config/config_chucnang.php');\n";
	$content .= "\$opensite\t= $opensite;\n";
	$content .= "\$title\t= '$title';\n";
	$content .= "\$description\t= '$description';\n";
	$content .= "\$keywords\t= '$keywords';\n";
	$content .= "\$version\t= '$version';\n";
	$content .= "\$reload_type\t= '$reload_type';\n";
	$content .= "\$img_url\t= '$img_url';\n";
	$content .= "\$yahoo_hotro\t= '$yahoo_hotro';\n";
	$content .= "\$forum\t= '$forum';\n";
	$content .= "\$server_url\t= '$server_url';\n";
	$content .= "\$passtransfer\t= '$passtransfer';\n";
	$content .= "\$usehost\t= $usehost;\n";
	$content .= "?>";
	
	require_once('admin/function.php');
	replacecontent($file_edit,$content);
	
	$notice = "<center><font color='red'>Sửa thành công</font></center>";
}

include($file_edit);
?>
		<div id="center-column">
			<div class="top-bar">
				<h1>Cấu Hình WebSite</h1>
			</div><br>
			Tập tin <?php echo "<b>".$file_edit."</b> : ".$can_write; ?>
		  <div class="select-bar"></div>
			<div class="table">
<?php if($notice) echo $notice; ?>
				<form id="editconfig" name="editconfig" method="post" action="">
				<input type="hidden" name="action" value="edit">
				<table>
					<tr>
						<td width="100">Mở WebSite: </td>
						<td>Đóng <input name="opensite" type="radio" value="0" <?php if($opensite==0) echo "checked='checked'"; ?>>
						Mở <input name="opensite" type="radio" value="1" <?php if($opensite==1) echo "checked='checked'"; ?>>
						<br>
						<b><i>Mô tả</i></b> : WebSite bảo trì để nâng cấp</td>
					</tr>
					<tr><td colspan="2"><hr></td></tr>
					<tr>
						<td width="100">Tên WebSite: </td>
						<td><input type="text" name="title" value="<?php echo $title; ?>" size="50"><br>
						<b><i>Đang sử dụng</i></b> : <?php echo $title; ?></td>
					</tr>
					<tr><td colspan="2"><hr></td></tr>
					<tr>
						<td>Mô tả: </td>
						<td><input type="text" name="description" value="<?php echo $description; ?>" size="50"><br>
						<b><i>Đang sử dụng</i></b> : <?php echo $description; ?></td>
					</tr>
					<tr><td colspan="2"><hr></td></tr>
					<tr>
						<td>Từ khóa: </td>
						<td><input type="text" name="keywords" value="<?php echo $keywords; ?>" size="70"><br>
						<b><i>Đang sử dụng</i></b> : <?php echo $keywords; ?></td>
					</tr>
					<tr><td colspan="2"><hr></td></tr>
					<tr>
						<td>Phiên bản: </td>
						<td>Free <input name="version" type="radio" value="0" <?php if($version==0) echo "checked='checked'"; ?>>
						Pro <input name="version" type="radio" value="1" <?php if($version==1) echo "checked='checked'"; ?>>
						<br>(Nếu không đăng kí Phiên bản Pro thì chọn Free, nếu chọn Pro sẽ làm chậm Web)</td>
					</tr>
					<tr><td colspan="2"><hr></td></tr>
					<tr>
						<td>Phương thức Cập nhật thông tin Web: </td>
						<td>Cập nhật liên tục <input name="reload_type" type="radio" value="0" <?php if($reload_type==0) echo "checked='checked'"; ?>>
						Cập nhật sau mỗi 1 giờ <input name="reload_type" type="radio" value="1" <?php if($reload_type==1) echo "checked='checked'"; ?>>
						<br>(Lưu ý chọn Phương thức Cập nhật phù hợp với cấu hình Máy chủ của bạn)</td>
					</tr>
					<tr><td colspan="2"><hr></td></tr>
					<tr>
						<td>Đường dẫn đến thư mục chứa Hình ảnh: </td>
						<td><input type="text" name="img_url" value="<?php echo $img_url; ?>" size="50"><br>
						<b><i>Đang sử dụng</i></b> : <?php echo $img_url; ?><br>
					</tr>
					<tr><td colspan="2"><hr></td></tr>
					<tr>
						<td>Yahoo Hỗ trợ MU: </td>
						<td><input type="text" name="yahoo_hotro" value="<?php echo $yahoo_hotro; ?>" size="20"><br>
						<b><i>Đang sử dụng</i></b> : <?php echo $yahoo_hotro; ?><br>
					</tr>
					<tr><td colspan="2"><hr></td></tr>
					<tr>
						<td>Địa chỉ phần Diễn đàn MU: </td>
						<td><input type="text" name="forum" value="<?php echo $forum; ?>" size="50"><br>
						<b><i>Đang sử dụng</i></b> : <?php echo $forum; ?><br>
					</tr>
					<tr><td colspan="2"><hr></td></tr>
					<tr>
						<td>Địa chỉ phần WebServer: </td>
						<td><input type="text" name="server_url" value="<?php echo $server_url; ?>" size="50"><br>
						<b><i>Đang sử dụng</i></b> : <?php echo $server_url; ?><br>
						<a href='checkconnect.php' target='_blank'><font color='blue'>Kiểm tra kết nối đến Server</font></a></td>
					</tr>
					<tr><td colspan="2"><hr></td></tr>
					<tr>
						<td>Mã kiểm tra: </td>
						<td><input type="text" name="passtransfer" value="<?php echo $passtransfer; ?>" size="15"><br>
						<b><i>Đang sử dụng</i></b> : <?php echo $passtransfer; ?></td>
					</tr>
					<tr><td colspan="2"><hr></td></tr>
					<tr>
						<td>Web sử dụng Host: </td>
						<td>Không <input name="usehost" type="radio" value="0" <?php if($usehost==0) echo "checked='checked'"; ?>>
						Có <input name="usehost" type="radio" value="1" <?php if($usehost==1) echo "checked='checked'"; ?>>
						<br>(Nếu Web hoạt động trên Host thì không thể tùy chỉnh trực tiếp đến Server)</td>
					</tr>
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
	  
