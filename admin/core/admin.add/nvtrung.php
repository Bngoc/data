<?php
	include("security.php");
include_once('../config.php');
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<table width="100%" cellspacing="1" cellpadding="3" border="0" bgcolor="#0000ff">
<tr bgcolor="#ffffcc" >
	<td align="center">#</td>
	<td align="center">Tài khoản</td>
	<td align="center">Nhân Vật</td>
</tr>

<?
	$query = "SELECT AccountID,Name From Character";
	$result = $db->Execute($query);
while($row = $result->fetchrow())
  	{
	$rank = $rank+1;
	
	$query_search = "SELECT AccountID,Name From Character WHERE AccountID<>'$row[0]' AND Name='$row[1]'";
	$result_search = $db->Execute($query_search);
	$check = $result_search->numrows();
	
	if ($check > 0) {
		echo"<tr bgcolor='#ffffff' >
		<td align='center'>$rank</td>
		<td align='center'>$row[0]</td>
		<td align='center'>$row[1]</td>
		</tr>";
	}
}
?>
</table>
</body>