<?php
	include("security.php");
include_once('../config.php');
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<link href="css/tooltip.css" rel="stylesheet" type="text/css" />

</head>
<body>
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
<table width="100%" cellspacing="1" cellpadding="3" border="0" bgcolor="#0000ff">
<tr bgcolor="#ffffcc" >
	<td align="center">#</td>
	<td align="center">Tài khoản</td>
	<td align="center">Tình trạng</td>
	<td align="center">Thời gian</td>
</tr>

<?
	$query = "SELECT Name,IsThuePoint,TimeThuePoint From Character Where IsThuePoint>0 Order By TimeThuePoint ASC";
	$result = $db->Execute($query);
$time = time();
while($row = $result->fetchrow())
  	{
	$rank = $rank+1;
	if ($row[1] == 1) $status = "Đang thuê Point";
	if ($row[1] == 2) $status = "Đã xử lý";
	$time_du = $row[2]-$time;
		$hour = floor($time_du/3600);
		$phut = floor (($time_du - $hour*3600 )/60);
		$time_free = "$hour h $phut phút";
						
		echo"<tr bgcolor='#ffffff' >
		<td align='center'>$rank</td>
		<td align='center'>$row[0]</td>
		<td align='center'>$status</td>
		<td align='center'>$time_free</td>
		</tr>";
}
?>

</table>
</body>