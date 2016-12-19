<?php
$file_edit = $server_path.'config.php';
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
	require_once($file_edit);
	$type_connect = $_POST['type_connect'];
	$localhost = $_POST['localhost'];
	$databaseuser = $_POST['databaseuser'];
	$databsepassword = $_POST['databsepassword'];
	$database = $_POST['database'];
	if ($_POST['passadmin'] == $passadmin) $passadmin = $_POST['passadmin']; else $passadmin = md5($_POST['passadmin']);
	if ($_POST['passcode'] == $passcode) $passcode = $_POST['passcode']; else $passcode = md5($_POST['passcode']);
	if ($_POST['passcard'] == $passcard) $passcard = $_POST['passcard']; else $passcard = md5($_POST['passcard']);
	if ($_POST['passviewcard'] == $passviewcard) $passviewcard = $_POST['passviewcard']; else $passviewcard = md5($_POST['passviewcard']);
	$Card_per_page = $_POST['Card_per_page'];
	$server_md5 = $_POST['server_md5'];
	$server_type = $_POST['server_type'];
	$type_acc = $_POST['type_acc'];
	$datedisplay = $_POST['datedisplay'];
	$transfercode = $_POST['transfercode'];
	$IP_LAN = $_POST['IP_LAN'];
	$IP_WAN = $_POST['IP_WAN'];
	
	$content = "<?php\n";
	$content .= "\$type_connect	= '$type_connect';\n";
	$content .= "\$localhost	= '$localhost';\n";
	$content .= "\$databaseuser	= '$databaseuser';\n";
	$content .= "\$databsepassword	= '$databsepassword';\n";
	$content .= "\$database	= '$database';\n";
	$content .= "\$passviewcard	= '$passviewcard';\n";
	$content .= "\$passcode = '$passcode';\n";
	$content .= "\$passadmin	= '$passadmin';\n";
	$content .= "\$passcard	= '$passcard';\n";
	$content .= "\$Card_per_page = '$Card_per_page';\n";
	$content .= "\$server_md5 = '$server_md5';\n";
	$content .= "\$server_type = '$server_type';\n";
	$content .= "\$type_acc = '$type_acc';\n";
	$content .= "\$datedisplay = '$datedisplay';\n";
	$content .= "\$transfercode = '$transfercode';\n\n";
	$content .= "\$list_ip = array (\n";
	$content .= "\t'127.0.0.1',\n";
	$content .= "\t'$IP_LAN',\n";
	$content .= "\t'$IP_WAN',\n";
	$content .= ");\n\n";
	$content .= "\$timestamp = time()-3600;\n";
	$content .= "\$day = date('d',\$timestamp);\n";
	$content .= "\$month = date('m',\$timestamp);\n";
	$content .= "\$year = date('Y',\$timestamp);\n\n";
	$content .= "include('adodb/adodb.inc.php');\n";
	$content .= "if(\$type_connect=='odbc') {\n\t";
	$content .= "\$db = &ADONewConnection('odbc');\n\t";
	$content .= "\$connect_mssql = \$db->Connect(\$database,\$databaseuser,\$databsepassword);\n\t";
	$content .= "if (!\$connect_mssql) die('Ket noi voi SQL Server loi! Hay kiem tra lai ODBC ton tai hoac User & Pass SQL dung.');\n";
	$content .= "}\n";
	$content .= "else if(\$type_connect=='mssql') {\n\t";
	$content .= "if (extension_loaded('mssql')) echo('');\n\t";
	$content .= "else Die('Loi! Khong the load thu vien php_mssql.dll. Hay cho phep su dung php_mssql.dll trong php.ini');\n\t";
	$content .= "\$db = &ADONewConnection('mssql');\n\t";
	$content .= "\$connect_mssql = \$db->Connect(\$localhost,\$databaseuser,\$databsepassword,\$database);\n\t";
	$content .= "if (!\$connect_mssql) die('Loi! Khong the ket noi SQL Server');\n";
	$content .= "}\n";
	$content .= "?>";
	
	require_once('admin/function.php');
	replacecontent($file_edit,$content);
	
	$notice = "<center><font color='red'>Sửa thành công</font></center>";
}

include($file_edit);
?>
		<div id="center-column">
			<div class="top-bar">
				<h1>Cấu Hình Server</h1>
			</div><br>
			Tập tin <?php echo "<b>".$file_edit."</b> : ".$can_write; ?>
		  <div class="select-bar"></div>
			<div class="table">
<?php if($notice) echo $notice; ?>
				<form id="editconfig" name="editconfig" method="post" action="">
				<input type="hidden" name="action" value="edit">
				<table>
					<tr>
						<td width="240">Dạng kết nối Database: </td>
						<td>odbc <input name="type_connect" type="radio" value="odbc" <?php if($type_connect=='odbc') echo "checked='checked'"; ?>>
						mssql <input name="type_connect" type="radio" value="mssql" <?php if($type_connect=='mssql') echo "checked='checked'"; ?>></td>
					</tr>
					<tr>
						<td>Localhost: </td>
						<td><input type="text" name="localhost" value="<?php echo $localhost; ?>" size="10"></td>
					</tr>
					<tr>
						<td>User quản lý SQL (thường là 'sa'): </td>
						<td><input type="text" name="databaseuser" value="<?php echo $databaseuser; ?>" size="10"></td>
					</tr>
					<tr>
						<td>Mật khẩu quản lý SQL: </td>
						<td><input type="text" name="databsepassword" value="<?php echo $databsepassword; ?>" size="10"></td>
					</tr>
					<tr>
						<td>Database sử dụng để lưu trữ thông tin MU: </td>
						<td><input type="text" name="database" value="<?php echo $database; ?>" size="10"></td>
					</tr>
					<tr>
						<td>Mật khẩu để vào trang Log, Admin: </td>
						<td><?php echo $passadmin; ?></td>
						<td>Nhập mới: </td>
						<td><input type="text" name="passadmin" value="<?php echo $passadmin; ?>" size="10"></td>
					</tr>
					<tr>
						<td>Mật khẩu để vào trang Online, CheckIP: </td>
						<td><?php echo $passcode; ?></td>
						<td>Nhập mới: </td>
						<td><input type="text" name="passcode" value="<?php echo $passcode; ?>" size="10"></td>
					</tr>
					<tr>
						<td>Mật khẩu để vào trang CardPhone: </td>
						<td><?php echo $passcard; ?></td>
						<td>Nhập mới: </td>
						<td><input type="text" name="passcard" value="<?php echo $passcard; ?>" size="10"></td>
					</tr>
					<tr>
						<td>Mật khẩu để vào trang ViewCard: </td>
						<td><?php echo $passviewcard; ?></td>
						<td>Nhập mới: </td>
						<td><input type="text" name="passviewcard" value="<?php echo $passviewcard; ?>" size="10"></td>
					</tr>
					<tr>
						<td>Số lượng Card trên 1 trang: </td>
						<td><input type="text" name="Card_per_page" value="<?php echo $Card_per_page; ?>" size="10"></td>
					</tr>
					<tr>
						<td>Database sử dụng MD5: </td>
						<td>Không <input name="server_md5" type="radio" value="0" <?php if($server_md5=='0') echo "checked='checked'"; ?>>
						Có <input name="server_md5" type="radio" value="1" <?php if($server_md5=='1') echo "checked='checked'"; ?>></td>
					</tr>
					<tr>
						<td>Loại Server đang sử dụng: </td>
						<td>SCF <input name="server_type" type="radio" value="scf" <?php if($server_type=='scf') echo "checked='checked'"; ?>>
						Original <input name="server_type" type="radio" value="ori" <?php if($server_type=='ori') echo "checked='checked'"; ?>></td>
					</tr>
					<tr>
						<td>Qui định khi tạo Tài khoản: </td>
						<td>Sử dụng Chữ & Số <input name="type_acc" type="radio" value="0" <?php if($type_acc=='0') echo "checked='checked'"; ?>>
						Chỉ sử dụng Số <input name="type_acc" type="radio" value="1" <?php if($type_acc=='1') echo "checked='checked'"; ?>></td>
					</tr>
					<tr>
						<td>Kiểu hiển thị Thời gian: </td>
						<td><input type="text" name="datedisplay" value="<?php echo $datedisplay; ?>" size="10"></td>
					</tr>
					<tr>
						<td>Mã so sánh nhận dữ liệu với WebClient: </td>
						<td><input type="text" name="transfercode" value="<?php echo $transfercode; ?>" size="15"></td>
					</tr>
					<tr>
						<td>IP LAN (Nếu thư mục Server đặt tại Local): </td>
						<td><input type="text" name="IP_LAN" value="<?php echo $list_ip[1]; ?>" size="15"></td>
					</tr>
					<tr>
						<td>IP Hosting (Nếu thư mục Server đặt tại Host): </td>
						<td><input type="text" name="IP_WAN" value="<?php echo $list_ip[2]; ?>" size="15"></td>
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
	  
