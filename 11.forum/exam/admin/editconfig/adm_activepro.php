<div id="center-column">
	<div class="top-bar"><h1>Kích hoạt Phiên bản Pro</h1></div>
	<div class="select-bar"></div>
	<div class="table">
<?php
include('config.php');
include('./includes/function.php');

$domain = $_SERVER['HTTP_HOST'];
$domain = strtolower( $domain );
$domain_check = substr( $domain, 0, 4 );
if ( $domain_check == "www." ) {
	$domain = substr( $domain, 4 );
}
$domain_check = substr( $domain, -1 );
if ( $domain_check == "." ) {
	$domain = substr( $domain, 0, -1 );
}
$domain_check = substr( $domain, -3 );
if ( $domain_check == ":80" ) {
	$domain = substr( $domain, 0, -3 );
}

$action = $_POST['action'];
if ( $action == "activePro" ) {
	$License = $_POST['License'];
	if ( $domain == "localhost" ) {
		echo "<center><b><font color='green' size='3'>Nếu sử dụng tên miền \"localhost\" thì bạn không cần kích hoạt vẫn có thể sử dụng chức năng Pro</font></b></center><br>";
		exit();
	}
	else if ( strlen( $License ) == 65 ) {
		$Lic_info = explode( "|", $License );
		$time_check = $Lic_info[0];
		$time_pro_exp = $Lic_info[1];
		$Lic_check = $Lic_info[2];
        $time_no_update = $Lic_info[3];
		if ( isset( $time_check, $time_pro_exp, $Lic_check, $time_no_update ) ) {
			$Lic_License = md5_tv($time_check."TVMuWeb".$domain."PeTyKhjn".$time_pro_exp."v1.85");
			if ( $Lic_check != $Lic_License ) {
				$notice = "Kiểm tra License không chính xác.";
			}
			else {
				$fp = fopen( "includes/License.txt", "w+" );
				fputs( $fp, $License );
				fclose( $fp );
				$notice = "Cập nhật License thành công.";
			}
		}
		echo "<script>alert('$notice');</script>";
	}
}

echo "<b>Kích hoạt phiên bản Pro</b> ( Liên hệ với <a href='ymsgr:sendim?trieuthieuvan290590'>trieuthieuvan290590@yahoo.com</a> để đăng kí nhận License sử dụng Phiên bản Pro )<br><br><br>";
if ( $version != "1" ) echo "<blockquote>Chưa chọn <b>\$version = '1'</b> trong file <b>config.php</b> của Phần Web trên Hosting</blockquote>";
else {
    $fp_license = fopen( "includes/License.txt", "r" );
    $License = fgets( $fp_license, 100 );
    fclose( $fp_license );
    $Lic_info = explode( "|", $License );
    $time_check = $Lic_info[0];
    $time_pro_exp = $Lic_info[1];
    $Lic_check = $Lic_info[2];
    $time_no_update = $Lic_info[3];
	if ( empty($time_check) || empty($time_pro_exp) || empty($Lic_check) || empty($time_no_update) ) {
		echo "<blockquote>Tình trạng: <b><font color='red' size='3'>Chưa kích hoạt</font></b>
			<form id='activePro' name='activePro' method='post' action=''>
				<input name='action' type='hidden' id='action' value='activePro'>
				<input name='License' type='text' id='License' size='65'>
				<input type='submit' name='Submit' value='Kích hoạt phiên bản Pro'>
			</form></blockquote>";
	}
	else {
		if ($time_check == $time_pro_exp && $time_no_update == $time_check*2) $time_pro_exp = "Không giới hạn";
		else $time_pro_exp = date( "h:iA, d/m/Y", $time_pro_exp );
		echo "<blockquote>Tình trạng: <b><font color='green' size='3'>Đã kích hoạt</font></b><br>Hạn sử dụng: <b>$time_pro_exp</b></blockquote>";
	}
}
?>
	</div>
	</div>
	<div id="right-column">
	<strong class="h">Thông tin</strong>
	<div class="box">Cấu hình :<br>
	- Tên WebSite<br>
	- Địa chỉ kết nối đến Server</div>
</div>