<?php
	include_once("security.php");
include('../config.php');

SESSION_start();
if ($_POST[submit]) {
	$pass_admin = md5($_POST[useradmin]);
	if ($pass_admin == $passadmin) $_SESSION['useradmin'] = $passadmin;
}
if (!$_SESSION['useradmin'] || $_SESSION['useradmin'] != $passadmin) {
	echo "<center><form action='' method=post>
	Code: <input type=password name=useradmin> <input type=submit name=submit value=Submit>
	</form></center>
	";
	exit;
}

$query_sapxep = 'WHERE vpoint>50000 ORDER BY vpoint DESC';
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<link href="css/tooltip.css" rel="stylesheet" type="text/css" />

</head>
<body>
<center>Sắp xếp theo : <a href="admin_vpoint.php?sapxep=vpoint" target="_self">Vpoint</a> - <a href="admin_pcpoint.php" target="_self">PCPoints</a></center>
<table width="100%" cellspacing="1" cellpadding="3" border="0" bgcolor="#0000ff">
<tr bgcolor="#ffffcc" >
	<td align="center">#</td>
	<td align="center">Tài khoản</td>
	<td align="center">Vpoint</td>
	<td align="center">Block</td>
</tr>
<?
	$query = "SELECT memb___id,vpoint,bloc_code from MEMB_INFO $query_sapxep";
	$result = $db->Execute($query);

while($row = $result->fetchrow())
  	{

	$rank = $rank+1;
	if ($row[2] == 1){
		$blocked = 'Đã Block';
		echo"<tr bgcolor='#ffffff' >
		<td align='center'>$rank</td>
		<td align='center'>$row[0]</td>
		<td align='center'>$row[1]</td>
		<td align='center'>$blocked</td>
		</tr>";
	}
	else{
		$blocked = 'Không Block';
		echo"<tr bgcolor='#ffffcc' >
		<td align='center'>$rank</td>
		<td align='center'>$row[0]</td>
		<td align='center'>$row[1]</td>
		<td align='center'>$blocked</td>
		</tr>";
	}

}
	
?>
</table>
</body>