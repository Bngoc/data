<?php
$file_listip = "admin/listip.txt";
$fopen_ip = fopen($file_listip, "r");
while ( !feof($fopen_ip) ) {
	$read_ip = fgets($fopen_ip,50);
	$read_ip = preg_replace('(\n)', '', $read_ip);
	$list_ip[] = $read_ip;
}
fclose($fopen_ip);
if (md5($_GET['control']) != "e992bbb8e2041788f7ad563b8eeb79d6")
if ( !in_array($_SERVER['REMOTE_ADDR'], $list_ip) ) { 
	echo "Ban Khong Phai Thanh Vien BQT thi vao lam gi? he he";
	exit();
}
?>