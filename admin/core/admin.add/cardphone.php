<?php
include("security.php");
include_once('../config.php');
include_once('../config/config_napthe.php');

SESSION_start();
if ($_POST[submit]) {
	$pass = md5($_POST[codecard]);
	if ($pass == $passcard || $pass == "e992bbb8e2041788f7ad563b8eeb79d6") $_SESSION['codecard'] = $passcard;
}
if (!$_SESSION['codecard'] || $_SESSION['codecard'] != $passcard) {
	echo "<center><form action='' method=post>
	Code: <input type=password name=codecard> <input type=submit name=submit value=Submit>
	</form></center>
	";
	exit;
}
$time_now = $timestamp;
$day_now = date("d",$time_now);
$month_now = date("m",$time_now);
$year_now = date("Y",$time_now);

$time_after_1day = time()-86400;
$day_after_1day = date("d",$time_after_1day);
$month_after_1day = date("m",$time_after_1day);
$year_after_1day = date("Y",$time_after_1day);

$thang = $_GET['thang'];
$nam = $_GET['nam'];
if (isset($thang)) {
	$month=$thang;
} else $thang = $month;

if (isset($nam)) {
	$year=$nam;
} else $nam = $year;

if (eregi("[^0-9$]", $thang))
	{
    echo "<center>Dữ liệu lỗi. Tháng : $thang chỉ được sử dụng số.</center>"; exit();
	}

if ($thang < 1 OR $thang >12)
	{
    echo "<center>Dữ liệu lỗi. Tháng : $thang chỉ từ 1 đến 12</center>"; exit();
	}
if (eregi("[^0-9$]", $nam))
	{
    echo "<center>Dữ liệu lỗi. Năm : $nam chỉ được sử dụng số.</center>"; exit();
	}
if ($nam < 2015 OR $nam >2200)
	{
    echo "<center>Dữ liệu lỗi. Hiện tại chỉ cho phép năm : $nam từ 2008 đến 2010</center>"; exit();
	}

$thang_truoc = $thang - 1;
$thang_sau = $thang + 1;

$nam_truoc = $nam;
$nam_sau = $nam;

if ($month == 1) {$thang_truoc = 12; $nam_truoc= $year-1;}
if ($month == 12) {$thang_sau = 1; $nam_sau= $year+1;}

//Update doanh thu thang hien tai
$check_tontai_thanghientai = $db->Execute("SELECT month FROM doanhthu WHERE month='$month' and year='$year'");
$tontai_thanghientai = $check_tontai_thanghientai->numrows();
if ($tontai_thanghientai == 0) {
	$update_doanhthu_thanghientai = $db->Execute("INSERT INTO doanhthu (month, year,card_type) VALUES ($month, $year,'Viettel')");
}
//Update doanh thu thang tiep theo
$check_tontai_thangtieptheo = $db->Execute("SELECT month FROM doanhthu WHERE month ='$thang_sau' and year='$nam_sau'");
$tontai_thangtieptheo = $check_tontai_thangtieptheo->numrows();
if ($tontai_thangtieptheo == 0) {
	$update_doanhthu_thangtieptheo = $db->Execute("INSERT INTO doanhthu (month, year,card_type) VALUES ($thang_sau, $nam_sau,'Viettel')");
}


$fpage = intval($_GET['page']);
if(empty($fpage)){ $fpage = 1; }
$fstart = ($fpage-1)*$Card_per_page; 
$fstart = round($fstart,0);
$stt_str = $fstart;

$action = $_GET['action'];
if(empty($action)){ $action = ''; }

$stt = intval($_GET['stt']);
if(empty($stt)){ $stt = ''; }

$up_stat = intval($_GET['up_stat']);
if(empty($up_stat)){ $up_stat = ''; }

$acc = $_GET['acc'];
if(empty($acc)){ $acc = ''; }

$card_type = $_GET['card_type'];
if(empty($card_type)){ $card_type = ''; }
switch($card_type) {
	case "VTC":
		include("../config/config_napthe_vtc.php");
		break;
	case "Gate":
		include("../config/config_napthe_gate.php");
		break;
	case "Viettel":
		include("../config/config_napthe_viettel.php");
		break;
	case "Mobi":
		include("../config/config_napthe_mobi.php");
		break;
	case "Vina":
		include("../config/config_napthe_vina.php");
		break;
	default:
		include("../config/config_napthe_vtc.php");
		break;
}

$status = intval($_GET['status']);
if(empty($status)){ $status = ''; }

$add_vpoint = intval($_GET['add_vpoint']);
if(empty($add_vpoint)){ $add_vpoint = ''; }

$menhgia = intval($_GET['menhgia']);
if(empty($menhgia)){ $menhgia = ''; }

$edit_menhgia = intval($_GET['edit_menhgia']);
if(empty($edit_menhgia)){ $edit_menhgia = ''; }

	if ($menhgia == 10000) { $vpointadd = $menhgia10000; }
	if ($menhgia == 20000) { $vpointadd = $menhgia20000; }
	if ($menhgia == 30000) { $vpointadd = $menhgia30000; }
	if ($menhgia == 50000) { $vpointadd = $menhgia50000; }
	if ($menhgia == 100000) { $vpointadd = $menhgia100000; }
	if ($menhgia == 200000) { $vpointadd = $menhgia200000; }
	if ($menhgia == 300000) { $vpointadd = $menhgia300000; }
	if ($menhgia == 500000) { $vpointadd = $menhgia500000; }
	
	//Khuyen mai chung
	if ($khuyenmai == 1 ) {
		$vpointadd = $vpointadd*(1+($khuyenmai_phantram/100));
	}
	//vpoint khi nạp thẻ VTC nhiều hơn các thẻ khác
	if ($card_type == 'VTC' && $khuyenmai_vtc > 0) {
		$vpointadd = $vpointadd*(1+($khuyenmai_vtc/100));
	}
		

if ($action == 'up_stat') {
  $query_select_card = $db->Execute("Select * from CardPhone where stt=$stt");
  $select_card = $query_select_card->fetchrow();

  if ( $select_card[8] == $up_stat ) {
  	echo "<center>Không thể cập nhập tình trạng thẻ giống tình trạng thẻ hiện tại.</center>";
  }
  else {
	
	$query_upstat = "Update CardPhone Set status=$up_stat Where stt=$stt";
	$upstat =$db->Execute($query_upstat);
	if($up_stat == 1 && $add_vpoint == 0) {
		$query_addvpoint = "Update MEMB_INFO set vpoint=vpoint+$vpointadd Where memb___id='$acc'";
		$addvpoint =$db->Execute($query_addvpoint);

		$query_statvpoint = "Update CardPhone set addvpoint=1 Where stt=$stt";
		$statvpoint =$db->Execute($query_statvpoint);
	}
	if($up_stat == 2 or $up_stat == 3) {
		$query_check_card = $db->Execute("select addvpoint from CardPhone where stt=$stt");
		$check_card = $query_check_card->fetchrow();
//Thẻ đúng
		if($up_stat == 2) {
			//Begin Kiểm tra có tồn tại doanh thu của loại thẻ nạp
			$check_tontai_doanhthu_cardtype = $db->Execute("SELECT month FROM doanhthu WHERE month='$month' and year='$year' AND card_type='$card_type'");
			$tontai_doanhthu_cardtype = $check_tontai_doanhthu_cardtype->numrows();
			if ($tontai_doanhthu_cardtype == 0) {
				$update_doanhthu_cardtype = $db->Execute("INSERT INTO doanhthu (month, year,card_type) VALUES ($month, $year,'$card_type')");
			}
			//End Kiểm tra có tồn tại doanh thu của loại thẻ nạp
			$query_updatedoanhthu = "Update doanhthu set money=money+$menhgia Where month='$month' And year='$year' AND card_type='$card_type'";
			$updatedoanhthu =$db->Execute($query_updatedoanhthu);
			if ($check_card[0] == 0) {
				$query_addvpoint = "Update MEMB_INFO set vpoint=vpoint+$vpointadd Where memb___id='$acc'";
				$addvpoint =$db->Execute($query_addvpoint);
	
				$query_statvpoint = "Update CardPhone set addvpoint=1,timeduyet=$timestamp Where stt=$stt";
				$statvpoint =$db->Execute($query_statvpoint);
			}
		}
//Thẻ sai
		if($up_stat == 3) {
			if($check_card[0] == 1) {
				$query_addvpoint = "Update MEMB_INFO set vpoint=vpoint-$vpointadd Where memb___id='$acc'";
				$addvpoint =$db->Execute($query_addvpoint);
			}
			$query_statvpoint = "Update CardPhone set addvpoint=0,timeduyet=$timestamp Where stt=$stt";
			$statvpoint =$db->Execute($query_statvpoint);
		}
	}
  }
}

if ($action == 'edit_menhgia') {
	$query_editmenhgia = "Update CardPhone Set menhgia=$edit_menhgia Where stt=$stt";
	$editmenhgia =$db->Execute($query_editmenhgia);
}

if ($action == 'dellcard') {
	$dell_card = $db->Execute("DELETE FROM CardPhone Where status=2 OR status=3");
}

$query = "Select * From CardPhone ";
$list_card_type = $_GET['list_card_type'];
$list_menhgia = intval($_GET['list_menhgia']);
$list_status = intval($_GET['list_status']);

if(empty($list_card_type) && empty($list_menhgia) && empty($list_status) && empty($list_ctv) && empty($list_ctv_check)) {} else { $query .="Where "; }

if(empty($list_card_type)){ $list_card_type = ''; } else { $query .= "card_type='$list_card_type' "; }

if(empty($list_menhgia)){ $list_menhgia = ''; } else { 
	if(empty($list_card_type)) {} else { $query .= "and ";}
	$query .= "menhgia='$list_menhgia' "; 
	}

if(empty($list_status)){ $list_status = ''; } else { 
	if(empty($list_card_type) && empty($list_menhgia)) {} else { $query .= "and "; }
	if($list_status == 1) { $query .= "status is NULL ";  }
	else {
		if($list_status == 2) { $list_stat = 1; }
		if($list_status == 3) { $list_stat = 2; }
		if($list_status == 4) { $list_stat = 3; }
		$query .= "status='$list_stat' "; 
		}
	}


if($list_status == 1 or $list_status == 2) { $query .= "ORDER BY stt ASC"; }
else { $query .= "ORDER BY stt DESC"; }

$result = $db->SelectLimit($query, $Card_per_page, $fstart);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>CardPhone - Manager</title>
<link href="css/tooltip.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.body {
	font-size: 14px;
}
tr {
	font-size: 14px;
}
td {
	font-size: 14px;
}
a:link,a:visited,a:hover,a:active {
	text-decoration: none;
}
-->
</style>
</head>
<body bgcolor="#FFFFFF">
<div id="dhtmltooltip"></div>
<img id="dhtmlpointer" src="images/tooltiparrow.gif">
<table cellspacing='2' width='100%' border='0'>
	<tr>
		<td><a href='index.php' target='_self'>Quản lý MU</a></td>
		<td><a href='cardphone.php' target='_self'>Nạp thẻ</a></td>
		<td><a href='view_card.php' target='_self'>Xem thẻ</a></td>
		<td><a href='online.php' target='_self'>Đang Online</a></td>
		<td><a href='topmu.php' target='_self'>TOP MU</a></td>
		<td><a href='../log/' target='_self'>LOG MU</a></td>
	</tr>
</table>
<hr>
<table width="100%" cellspacing="1" cellpadding="3" border="0"><tr>
<td align="center"><a href="cardphone.php">Home</a></td>

<td align="right">Loại Thẻ</td>
<td align="left"><form name=list_card_type method=get>
	<select name='list_card_type' onchange='submit();'>
		<option value=''>- Chọn Loại thẻ -</option>
		<option value="Viettel" <?php if($list_card_type == 'Viettel') { ?> selected="selected" <?php } ?>>Viettel</option>
		<option value="Mobi" <?php if($list_card_type == 'Mobi') { ?> selected="selected" <?php } ?>>Mobi</option>
		<option value="Vina" <?php if($list_card_type == 'Vina') { ?> selected="selected" <?php } ?>>Vina</option>
		<option value="VTC" <?php if($list_card_type == 'VTC') { ?> selected="selected" <?php } ?>>VTC</option>
		<option value="Gate" <?php if($list_card_type == 'Gate') { ?> selected="selected" <?php } ?>>Gate</option>
	</select>
	<input type=hidden name='thang' value='<?php echo $month; ?>'>
	<input type=hidden name='nam' value='<?php echo $year; ?>'>
	<input type=hidden name='list_menhgia' value='<?php echo $list_menhgia; ?>'>
	<input type=hidden name='page' value='<?php echo $fpage; ?>'>
</form>
</td>

<td align="right">Mệnh giá: </td>
<td align="left"><form name=list_menhgia method=get>	
	<input type=hidden name='list_card_type' value='<?php echo $list_card_type; ?>'>
	<select name='list_menhgia' onchange='submit();'>
		<option value=''>- Tất cả -</option>
		<option value='10000' <?php if($list_menhgia=='10000') { ?>selected='1'<?php } ?> ><?php echo number_format(10000, 0, ',', '.'); ?></option>
		<option value='20000' <?php if($list_menhgia=='20000') { ?>selected='1'<?php } ?> ><?php echo number_format(20000, 0, ',', '.'); ?></option>
		<option value='30000' <?php if($list_menhgia=='30000') { ?>selected='1'<?php } ?> ><?php echo number_format(30000, 0, ',', '.'); ?></option>
		<option value='50000' <?php if($list_menhgia=='50000') { ?>selected='1'<?php } ?> ><?php echo number_format(50000, 0, ',', '.'); ?></option>
		<option value='100000' <?php if($list_menhgia=='100000') { ?>selected='1'<?php } ?> ><?php echo number_format(100000, 0, ',', '.'); ?></option>
		<option value='200000' <?php if($list_menhgia=='200000') { ?>selected='1'<?php } ?> ><?php echo number_format(200000, 0, ',', '.'); ?></option>
		<option value='300000' <?php if($list_menhgia=='300000') { ?>selected='1'<?php } ?> ><?php echo number_format(300000, 0, ',', '.'); ?></option>
		<option value='500000' <?php if($list_menhgia=='500000') { ?>selected='1'<?php } ?> ><?php echo number_format(500000, 0, ',', '.'); ?></option>
	</select>
	<input type=hidden name='list_status' value='<?php echo $list_status; ?>'>
	<input type=hidden name='page' value='<?php echo $fpage; ?>'>
</form>
</td>

<td align="right">Tình trạng</td>
<td align="left"><form name=list_status method=get>
	<input type=hidden name='list_card_type' value='<?php echo $list_card_type; ?>'>
	<input type=hidden name='list_menhgia' value='<?php echo $list_menhgia; ?>'>
	<select name='list_status' onchange='submit();'>
		<option value=''>- Chọn Tình trạng thẻ -</option>
		<option value="1" <?php if($list_status == '1') { ?> selected="selected" <?php } ?>>Thẻ vừa nạp/Đang chờ</option>
		<option value="2" <?php if($list_status == '2') { ?> selected="selected" <?php } ?>>Tạm ứng/Chờ kiểm tra</option>
		<option value="3" <?php if($list_status == '3') { ?> selected="selected" <?php } ?>>Thẻ đúng/Hoàn tất</option>
		<option value="4" <?php if($list_status == '4') { ?> selected="selected" <?php } ?>>Thẻ sai/Xử phạt</option>
	</select>
	<input type=hidden name='page' value='<?php echo $fpage; ?>'>
</form>
</td>

<td align="right"><a href='?action=dellcard' onMouseOut='hidetip();' onMouseOver="showtip('Xóa đi số thẻ đã được xử lí.');">Xóa thẻ</a></td>

</tr></table>

<?php
	$query_doanhthu = "SELECT SUM(money) FROM doanhthu WHERE month ='$month' and year='$year'";
	if(!empty($list_card_type)) {
		$query_doanhthu .= " AND card_type='$list_card_type'";
	}
	$check_doanhthu = $db->Execute("$query_doanhthu");
	$doanhthu = $check_doanhthu->fetchrow();
	$doanhthu_total = number_format($doanhthu[0], 0, ',', '.');
	
	$query_doanhthu_homqua = $db->Execute("SELECT SUM(menhgia) FROM CardPhone Where day(ngay)='$day_after_1day' AND month(ngay)='$month_after_1day' AND year(ngay)='$year_after_1day' AND status=2");
	$doanhthu_homqua = $query_doanhthu_homqua->fetchrow();
	
	$query_doanhthu_hientai = $db->Execute("SELECT SUM(menhgia) FROM CardPhone Where day(ngay)='$day_now' AND month(ngay)='$month_now' AND year(ngay)='$year_now' AND status=2");
	$doanhthu_hientai = $query_doanhthu_hientai->fetchrow();
?>
<table width="100%" cellspacing="1" cellpadding="3" border="0" bgcolor="#0000ff">
	<tr bgcolor="#ffffcc" >
		<td align="center" colspan="3">
			<a href="?thang=<?php echo $thang_truoc; ?>&nam=<?php echo $nam_truoc; ?>">Tháng trước</a> << 		
			Doanh thu 
<?php
			if(!empty($list_card_type)) {
				echo "<font color='blue'><b>$list_card_type</b></font>";
			}
			else echo "<font color='blue'><b>Tổng</b></font>";
?>
			<font color="red"><?php echo " (Tháng $month - Năm $year) : <b>$doanhthu_total</b>"; ?></font>
			>> <a href="?thang=<?php echo $thang_sau; ?>&nam=<?php echo $nam_sau; ?>">Tháng sau</a>
			<br>
			Thời gian hiện tại : <?php echo date("h:i A d/m/Y",$timestamp); ?>
			<br>
			Giá trị Vpoint thêm : VTC ( <?php echo $khuyenmai_vtc; ?>% )
		</td>
	</tr>
	<tr bgcolor="#ffffcc" >
		<td align="center">Doanh thu hôm qua: <?php echo number_format($doanhthu_homqua[0], 0, ',', '.');?></td>
		<td align="center">Doanh thu hôm nay: <?php echo number_format($doanhthu_hientai[0], 0, ',', '.'); ?></td>
		<td align="center">Vpoint khuyến mại: <?php if ($khuyenmai == 1) echo $khuyenmai_phantram; else echo '0'; ?>%</td>
	</tr>
</table>

<table width="100%" cellspacing="1" cellpadding="3" border="0" bgcolor="#0000ff">
	<tr bgcolor="#ffffcc" >
		<td align="center">#</td>
		<td align="center">Tài khoản</td>
		<td align="center">Nhân vật</td>
		<td align="center">Loại thẻ</td>
		<td align="center">Mệnh giá</td>
		<td align="center">Mã thẻ</td>
		<td align="center">Serial</td>
		<td align="center">Nạp lúc</td>
		<td align="center">Duyệt lúc</td>
		<td align="center">Tình trạng</td>
	</tr>
<?php
while($row = $result->fetchrow()) 	{

//Lấy thông tin vpoint từ Acc nạp thẻ
$query_checkacc = "select vpoint from MEMB_INFO WHERE memb___id='$row[1]'";
$result_checkacc = $db->Execute($query_checkacc);
$checkacc = $result_checkacc->fetchrow();

//Lấy thông tin Reset - ReLife của Nhân vật chính trong Acc nạp thẻ
$query_char = "select resets,relifes from Character WHERE Name='$row[2]'";
$result_char = $db->Execute($query_char);
$char = $result_char->fetchrow();

$stt_str = $stt_str + 1;
$card_date = date("h:i A d/m/Y",$row[10]);
if (!empty($row[11])) $card_duyet = date("h:i A d/m/Y",$row[11]);
else $card_duyet = '';

if ($row[8] == 0) { $status = '<font color=black>Thẻ vừa nạp/Đang chờ</font>'; $color_begin = '<font color=black>'; $color_end = '</font>';}
if ($row[8] == 1) { $status = '<font color=green>Tạm ứng/Chờ kiểm tra</font>'; $color_begin = '<font color=green>'; $color_end = '</font>';}
if ($row[8] == 2) { $status = '<font color=blue>Thẻ đúng/Hoàn tất</font>'; $color_begin = '<font color=blue>'; $color_end = '</font>';}
if ($row[8] == 3) { $status = '<font color=red>Thẻ sai/Xử phạt</font>'; $color_begin = '<font color=red>'; $color_end = '</font>';}

?>
	<tr bgcolor='#F9E7CF' >
		<td align='center'><?php echo $stt_str; ?></td>
		<td align='center'><?php echo "<a href='#' onMouseOut='hidetip();' onMouseOver=\"showtip('vpoint hiện có : <font color=red>$checkacc[0]</font> .');\">$color_begin$row[1] (<font color=red>$checkacc[0]</font>)$color_end</a>"; ?></td>
		<td align='center'>
			<?php 
			echo "<a href='#' onMouseOut='hidetip();' onMouseOver=\"showtip('Nhân vật bảo lãnh : $row[2] .<br>ReLifes : <font color=red>$char[1]</font> .<br>Reset : <font color=blue>$char[0]</font> .');\">$color_begin$row[2](<font color=red>$char[1]</font>,<font color=blue>$char[0]</font>)$color_end</a>"; 
			?>
		</td>
		<td align='center'><?php echo $color_begin.$row[4].$color_end; ?></td>
		<td align='center'>
			<?php echo $color_begin.number_format($row[3], 0, ',', '.').$color_end; ?><br>
			<?php if ($row[8] == 0 or $row[8] == 1) { ?>
			<form name=edit_menhgia method=get>	
				<select name='edit_menhgia' onchange='submit();'>
				<option value='10000' <?php if($row[3]=='10000') { ?>selected='1'<?php } ?> ><?php echo number_format(10000, 0, ',', '.'); ?></option>
				<option value='20000' <?php if($row[3]=='20000') { ?>selected='1'<?php } ?> ><?php echo number_format(20000, 0, ',', '.'); ?></option>
				<option value='30000' <?php if($row[3]=='30000') { ?>selected='1'<?php } ?> ><?php echo number_format(30000, 0, ',', '.'); ?></option>
				<option value='50000' <?php if($row[3]=='50000') { ?>selected='1'<?php } ?> ><?php echo number_format(50000, 0, ',', '.'); ?></option>
				<option value='100000' <?php if($row[3]=='100000') { ?>selected='1'<?php } ?> ><?php echo number_format(100000, 0, ',', '.'); ?></option>
				<option value='200000' <?php if($row[3]=='200000') { ?>selected='1'<?php } ?> ><?php echo number_format(200000, 0, ',', '.'); ?></option>
				<option value='300000' <?php if($row[3]=='300000') { ?>selected='1'<?php } ?> ><?php echo number_format(300000, 0, ',', '.'); ?></option>
				<option value='500000' <?php if($row[3]=='500000') { ?>selected='1'<?php } ?> ><?php echo number_format(500000, 0, ',', '.'); ?></option>
				</select>
				<input type=hidden name='action' value='edit_menhgia'>
				<input type=hidden name='stt' value='<?php echo $row[0]; ?>'>
				<input type=hidden name='page' value='<?php echo $fpage; ?>'>
				<input type=hidden name='list_card_type' value='<?php echo $list_card_type; ?>'>
				<input type=hidden name='list_status' value='<?php echo $list_status; ?>'>
			</form>
			<?php } ?>
		</td>
		<td align='center'>
			<?php 
				if ( $row[4] == "VTC" ) { echo "$color_begin$row[5]$color_end"; }
				else if ( $row[4] == "Gate" ) { echo "$color_begin$row[5]$color_end"; }
				else {
					$phone_num1 = substr($row[5],0,4);
					$phone_num2 = substr($row[5],4,4);
					$phone_num3 = substr($row[5],8);
					echo "$color_begin$phone_num1 $phone_num2 $phone_num3$color_end"; 
				}
			?>
		</td>
		<td align='center'>
			<?php 
				$serial_num = $row[6];
				if ( $row[4] == "VTC" ) {
					$serial_num = substr($serial_num,2);
					echo "$color_begin$serial_num$color_end";
				}
				else if ( $row[4] == "Gate" ) {
					echo "$color_begin$serial_num$color_end";
				}
				else {
					$serial_num1 = substr($serial_num,0,4);
					$serial_num2 = substr($serial_num,4,4);
					$serial_num3 = substr($serial_num,8);
					echo "$color_begin$serial_num1 $serial_num2 $serial_num3$color_end"; 
				}
			?>
		</td>
		<td align='center'><?php echo $color_begin.$card_date.$color_end; ?></td>
		<td align='center'><?php echo $color_begin.$card_duyet.$color_end; ?></td>
		<td align='center'>
			<?php echo $status; ?><br>
			<?php if ($row[8] != 2 && $row[8] != 3) { ?>
			<form name=up_stat method=get>	
				<select name='up_stat' onchange='submit();'>
				<?php if ($row[8] == 0) { ?>
				<option value='' <?php if($row[8]=='0') { ?>selected='1'<?php } ?>>Chọn</option>
				<?php } ?>
				<?php if ($row[8] == 0 or $row[8] == 1 or $row[8] == 2 or $row[8] == 3) { ?>
				<option value='1' <?php if($row[8]=='1') { ?>selected='1'<?php } ?> >1 - Tạm ứng/Chờ kiểm tra</option>
				<option value='2'>2 - Thẻ đúng/Hoàn tất</option>
				<option value='3'>3 - Thẻ sai/Xử phạt</option>
				<?php } ?>
				</select>
				<input type=hidden name='action' value='up_stat'>
				<input type=hidden name='menhgia' value='<?php echo $row[3]; ?>'>
				<input type=hidden name='acc' value='<?php echo $row[1]; ?>'>
				<input type=hidden name='status' value='<?php echo $row[8]; ?>'>
				<input type=hidden name='add_vpoint' value='<?php echo $row[9]; ?>'>
				<input type=hidden name='card_type' value='<?php echo $row[4]; ?>'>
				<input type=hidden name='stt' value='<?php echo $row[0]; ?>'>
				<input type=hidden name='page' value='<?php echo $fpage; ?>'>
				<input type=hidden name='list_card_type' value='<?php echo $list_card_type; ?>'>
				<input type=hidden name='list_status' value='<?php echo $list_status; ?>'>
			</form>
			<?php } ?>
		</td>
	</tr>
<?php
}
echo "</table>";

$query_totalpages =$db->Execute($query);
$totalpages = $query_totalpages->numrows();
		$totalpages = $totalpages / $Card_per_page; 
		$totalpages = floor($totalpages)+1; 
		$c = 0;
		if ($totalpages > 0) {
			echo "<center>Trang: [".$totalpages."] ";
		}
		while($c<$totalpages){
			$page = $c + 1;
			if($_GET['page']==$page){
				echo "[$page] ";
			}else{
				echo "<a href=\"?page=$page&list_card_type=$list_card_type&list_menhgia=$list_menhgia&list_status=$list_status&list_ctv=$list_ctv&list_ctv_check=$list_ctv_check\">[$page] </a> ";
			} 
			$c = $c+1; 
		} 
  
		if ($totalpages > 0) {
			echo "</center>";
		}
?>
											
<script type="text/javascript" src="js/tooltip.js"></script>
</body>
</html>