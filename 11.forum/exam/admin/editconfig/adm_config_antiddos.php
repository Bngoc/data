<?php
$file_edit = 'config/config_firewall.php';
$folder = 'firewall';
$file_firewall_1 = 'firewall/attackips.txt';
$file_firewall_2 = 'firewall/floodips.txt';
$file_firewall_3 = 'firewall/spamips.txt';
$file_firewall_4 = 'firewall/index.htm';

$action = $_POST[action];

if($action == 'edit')
{
	$content = "<?php\n";
	$content .= "\$conf['path']	= 'firewall';\n";
	
	$use_antiddos = $_POST['use_antiddos'];	$content .= "\$use_antiddos	= $use_antiddos;\n";
	$maxaccess = $_POST['maxaccess'];	$content .= "\$conf['maxaccess']	= $maxaccess;\n";
	$interval = $_POST['interval'];		$content .= "\$conf['interval']	= $interval;\n";
	$requests = $_POST['requests'];		$content .= "\$conf['requests']	= $requests;\n";
	$blocktime = $_POST['blocktime'];	$content .= "\$conf['blocktime']	= $blocktime;\n";

	$content .= "?>";
	
	require_once('admin/function.php');
	replacecontent($file_edit,$content);
	
	$notice = "<center><font color='red'>Sửa thành công</font></center>";
}

if($action == 'del_allfile')
{
	include_once($file_edit);
	$dir = $conf['path'];
	if ($handle = opendir("$dir")) {
    while (false !== ($item = readdir($handle))) {
      if ($item != "." && $item != "..") {
          unlink("$dir/$item");
      }
    }
    closedir($handle);
  	}
  	$notice = "<center><font color='red'>Xóa dữ liệu thành công</font></center>";
}


//Kiem tra thu muc ton tai va tao thu muc
if(!is_dir($folder))
{
	mkdir($folder);
}
//Kiem tra thu muc co the ghi
if(is_writable($folder)) { $folder_canwrite = "<font color=green>Có thể ghi</font>"; $folder_ok = 1; }
else { $folder_canwrite = "<font color=red>Không thể ghi - Hãy sử dụng chương trình FTP FileZilla chuyển <b>File permission</b> sang 777</font>"; $folder_ok = 0; }
//Kiem tra cac file trong thu muc firewall
if(!is_file($file_firewall_1)) 
{ 
	$fp_host = fopen($file_firewall_1, "w");
	fclose($fp_host);
}

if(is_writable($file_firewall_1))	{ $can_write1 = "<font color=green>Có thể ghi</font>"; $accept1 = 1;}
	else { $can_write1 = "<font color=red>Không thể ghi - Hãy sử dụng chương trình FTP FileZilla chuyển <b>File permission</b> sang 666</font>"; $accept1 = 0; }

if(!is_file($file_firewall_2)) 
{ 
	$fp_host = fopen($file_firewall_2, "w");
	fclose($fp_host);
}

if(is_writable($file_firewall_2))	{ $can_write2 = "<font color=green>Có thể ghi</font>"; $accept2 = 1;}
	else { $can_write2 = "<font color=red>Không thể ghi - Hãy sử dụng chương trình FTP FileZilla chuyển <b>File permission</b> sang 666</font>"; $accept2 = 0; }
	
if(!is_file($file_firewall_3)) 
{ 
	$fp_host = fopen($file_firewall_3, "w");
	fclose($fp_host);
}

if(is_writable($file_firewall_3))	{ $can_write3 = "<font color=green>Có thể ghi</font>"; $accept3 = 1;}
	else { $can_write3 = "<font color=red>Không thể ghi - Hãy sử dụng chương trình FTP FileZilla chuyển <b>File permission</b> sang 666</font>"; $accept3 = 0; }

if(!is_file($file_firewall_4)) 
{ 
	$fp_host = fopen($file_firewall_4, "w");
	fclose($fp_host);
}

if(is_file($file_firewall_4)) 
{ 
	$file_firewall_4_tontai = "<font color=green>Đã có</font>";
}
else { $file_firewall_4_tontai = "<font color=red>Không có File . Vui lòng tạo File <b>$file_firewall_4</b> để nâng cao bảo mật. File <b>$file_firewall_4</b> để trống, không cần nội dung</font>"; }
	
//Kiem tra file config
if(!is_file($file_edit)) 
{ 
	$fp_host = fopen($file_edit, "w");
	fclose($fp_host);
}

if(is_writable($file_edit))	{ $can_write = "<font color=green>Có thể ghi</font>"; $accept = 1;}
	else { $can_write = "<font color=red>Không thể ghi - Hãy sử dụng chương trình FTP FileZilla chuyển <b>File permission</b> sang 666</font>"; $accept = 0; }

include($file_edit);
?>
		<div id="center-column">
			<div class="top-bar">
				<h1>Hệ thống chống DDOS</h1>
			</div><br>
			Tệp tin <?php echo "<b>".$file_edit."</b> : ".$can_write; ?><br>
			Thư mục <?php echo "<b>".$folder."</b> : ".$folder_canwrite; ?><br>
			Tệp tin <?php echo "<b>".$file_firewall_1."</b> : ".$can_write1; ?><br>
			Tệp tin <?php echo "<b>".$file_firewall_2."</b> : ".$can_write2; ?><br>
			Tệp tin <?php echo "<b>".$file_firewall_3."</b> : ".$can_write3; ?><br>
			Tệp tin <?php echo "<b>".$file_firewall_4."</b> : ".$file_firewall_4_tontai; ?><br>
		  <div class="select-bar"></div>
			<div class="table">
<?php if($notice) echo $notice; ?>
			<form id="editconfig" name="editconfig" method="post" action="">Xóa hết File ghi lại quá trình theo dõi DDOS : <input type="hidden" name="action" value="del_allfile"/><input type="submit" name="Submit" value="Xóa" /></form>
			<br>( <font color='red'><i>Thỉnh thoảng xóa cho nhẹ Web</i></font> )<hr>
				<form id="editconfig" name="editconfig" method="post" action="">
				<input type="hidden" name="action" value="edit"/>
				<table>
					<tr>
						<td width="200">Sử dụng hệ thống chống DDOS: </td>
						<td>
							Không sử dụng <input name="use_antiddos" type="radio" value="0" <?php if($use_antiddos==0) echo "checked='checked'"; ?>/>
							Sử dụng <input name="use_antiddos" type="radio" value="1" <?php if($use_antiddos==1) echo "checked='checked'"; ?>/>
						</td>
					</tr>
					<tr>
						<td>1 IP Cho phép gửi yêu cầu tối đa: </td>
						<td><input type="text" name="maxaccess" value="<?php echo $conf['maxaccess']; ?>" size="1"/> yêu cầu / 1 trang Web trong <?php echo $conf['interval']; ?> giây</td>
					</tr>
					<tr>
						<td>1 IP Cho phép gửi yêu cầu tối đa: </td>
						<td><input type="text" name="requests" value="<?php echo $conf['requests']; ?>" size="1"/> yêu cầu / toàn bộ WebSite trong <?php echo $conf['interval']; ?> giây</td>
					</tr>
					<tr>
						<td>Thời gian 1 đợt theo dõi gửi yêu cầu: </td>
						<td><input type="text" name="interval" value="<?php echo $conf['interval']; ?>" size="1"/> giây</td>
					</tr>
					<tr>
						<td>Thời gian khóa truy cập: </td>
						<td><input type="text" name="blocktime" value="<?php echo $conf['blocktime']; ?>" size="1"/> giây</td>
					</tr>
					
					<tr>
						<td>&nbsp;</td>
						<td align="center"><input type="submit" name="Submit" value="Sửa" <?php if($accept=='0' && $accept1 == 0 && $accept2 == 0 && $accept3 == 0) { ?> disabled="disabled" <?php } ?> /></td>
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
	  
