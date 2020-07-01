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
	<td align="center">Nhân vật</td>
	<td align="center">PCPoint</td>
</tr>

<?
	$query = "SELECT AccountID,Name,SCFPCPoints from Character Where SCFPCPoints>0 ORDER BY SCFPCPoints DESC";
	$result = $db->Execute($query);

while($row = $result->fetchrow())
  	{

	$rank = $rank+1;
		echo"<tr bgcolor='#ffffcc' >
		<td align='center'>$rank</td>
		<td align='center'>$row[0]</td>
		<td align='center'>$row[1]</td>
		<td align='center'>$row[2]</td>
		</tr>";
}
	
?>

</table>
</body>